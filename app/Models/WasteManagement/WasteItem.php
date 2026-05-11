<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteItem extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_master_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id',
        'item_name',
        'status',
        'trash',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('wastemanagement_master_item.*', 'wastemanagement_master_category.category_name');
        $query = $query->leftJoin('wastemanagement_master_category', 'wastemanagement_master_item.category_id', '=', 'wastemanagement_master_category.id');



        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'DESC');


        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function store()
    {

        $request = request();

        $insert_array = array(
            'category_id' => decryptId($request->category),
            'item_name' => $request->item_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'category_id' => decryptId($request->category),
            'item_name' => $request->item_name,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id)
    {
        $request = request();

        $type = $request->types;
        if ($type == 1) {
            $update_data = array(
                'status' => 0,
            );
        } else {
            $update_data = array(
                'status' => 1,
            );
        }

        return $this->where('id', $id)->update($update_data);
    }

    public function deleterecord($id)
    {

        $update_data = array(
            'status' => 0,
            'trash' => 'YES',
        );

        return $this->where('id', $id)->update($update_data);
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select('wastemanagement_master_item.*', 'wastemanagement_master_category.category_name');
        $query = $query->leftJoin('wastemanagement_master_category', 'wastemanagement_master_item.category_id', '=', 'wastemanagement_master_category.id');


      

        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('*')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }


    public function getWhere($category)
    {

        $query = $this->select('*');
        $query = $query->where('category_id', $category);
        $datas = $query->get();

        return $datas;
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_master_item'));
    }
}
