<?php

namespace App\Models\WasteManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class WasteType extends Model
{
    use  HasFactory;


    protected $table = 'wastemanagement_master_wastetype';
    protected $primaryKey = 'id';

    protected $fillable = [
        'wastetype_id',
        'wastetype_name',
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

        $query = $this->select('wastemanagement_master_wastetype.*');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_master_wastetype.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query;
        $total_records = $data_count->count();

        $query->orderBy('id','DESC');


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
            'wastetype_id' => $request->type_id,
            'wastetype_name' => $request->type_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'wastetype_id' => $request->type_id,
            'wastetype_name' => $request->type_name,
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

        $query = $this->select('wastemanagement_master_wastetype.*');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('wastemanagement_master_wastetype.wastetype_id', 'LIKE', '%' . $search . '%');
                $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
            });
        }

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

    public function ajaxList($activity = ''){

        $query = $this->select('id','wastetype_name');

        if($activity != ''){
            $query = $query->where('wastetype_id',$activity);
        }

        $datas = $query->get();

        $list = [];
        foreach($datas as $data){
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->wastetype_name;

            $list[] = $listvalue;
        }
        return $list;

    }

    public function getWhere($activity = ''){

        $query = $this->select('id','wastetype_name','input_type','required','other_params');

        if($activity != ''){
            $query = $query->where('wastetype_id',$activity);
        }

        $datas = $query->get();


        return $datas;

    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('wastemanagement_master_wastetype'));


    }
}
