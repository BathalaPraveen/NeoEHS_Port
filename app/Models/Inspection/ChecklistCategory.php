<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class ChecklistCategory extends Model
{
    use  HasFactory;


    protected $table = 'inspection_master_checklist_category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspectiontype_id',
        'category_name',
        'sort_order',
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

        $query = $this->select('inspection_master_checklist_category.*','inspection_master_inspection_type.inspectiontype_name');
        $query = $query->leftJoin('inspection_master_inspection_type','inspection_master_checklist_category.inspectiontype_id' , '=' ,'inspection_master_inspection_type.id');


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('inspection_master_inspection_type.inspectiontype_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('inspection_master_checklist_category.category_name', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

        // $query->orderBy('id','DESC');


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
            'inspectiontype_id' => decryptId($request->inspectiontype),
            'category_name' => $request->category_name,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'inspectiontype_id' => decryptId($request->inspectiontype),
            'category_name' => $request->category_name,
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

        $query = $this->select('inspection_master_checklist_category.*','inspection_master_inspection_type.inspectiontype_name');
        $query = $query->leftJoin('inspection_master_inspection_type','inspection_master_checklist_category.inspectiontype_id' , '=' ,'inspection_master_inspection_type.id');


        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query ->orWhere('inspection_master_inspection_type.inspectiontype_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('inspection_master_checklist_category.category_name', 'LIKE', '%' . $search . '%');
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

        $query = $this->select('id','category_name');

        if($activity != ''){
            $query = $query->where('inspectiontype_id',$activity);
        }

        $datas = $query->get();

        $list = [];
        foreach($datas as $data){
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->category_name;

            $list[] = $listvalue;
        }
        return $list;

    }

    public function getWhere($activity = ''){

        $query = $this->select('id','category_name');

        if($activity != ''){
            $query = $query->where('inspectiontype_id',$activity);
        }

        $datas = $query->get();


        return $datas;

    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_master_checklist_category'));


    }
}
