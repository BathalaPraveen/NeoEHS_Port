<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class PTWItem extends Model
{
    use  HasFactory;


    protected $table = 'ptw_master_item';
    protected $primaryKey = 'id';

    protected $fillable = [
        'activity_id',
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

        $query = $this->select('ptw_master_item.*', 'ptw_master_activity.activity_name', 'ptw_master_category.category_name', 'ptw_master_activity.module');
        $query = $query->leftJoin('ptw_master_activity', 'ptw_master_item.activity_id', '=', 'ptw_master_activity.id');
        $query = $query->leftJoin('ptw_master_category', 'ptw_master_item.category_id', '=', 'ptw_master_category.id');


       

        $data_count = $query->count();
        $total_records = $data_count;

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
            'activity_id' => decryptId($request->activity),
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
            'activity_id' => decryptId($request->activity),
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

        $query = $this->select('ptw_master_item.*', 'ptw_master_activity.activity_name', 'ptw_master_category.category_name', 'ptw_master_activity.module');
        $query = $query->leftJoin('ptw_master_activity', 'ptw_master_item.activity_id', '=', 'ptw_master_activity.id');
        $query = $query->leftJoin('ptw_master_category', 'ptw_master_item.category_id', '=', 'ptw_master_category.id');


       

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

    public function getWhere($where)
    {

        $query = $this->select('id', 'item_name');

        if ($where != '') {
            $query = $query->where($where);
        }

        $datas = $query->get();


        return $datas;
    }


    public function CategoryItem($activity)
    {

        $query = $this->select('id','activity_id','category_id', 'item_name');

        if ($activity != '') {
            $query = $query->where('activity_id', $activity);
        }

        $datas = $query->get();

        if ($datas != null && $datas != '') {

            $itemlist = [];
            foreach ($datas as $loan) {

                $itemlist[$loan->category_id][] = $loan;
            }
        }


        return $itemlist;
    }



    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_master_item'));


    }
}
