<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class InspectionDetails extends Model
{
    use  HasFactory;


    protected $table = 'inspection_inspection_list_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspection_id',
        'inspection_type',
        'checklist_category',
        'checklist_item',
        'score',
        'observation',
        'remarks',
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

        $query = $this->select('inspection_inspection_list_details.*');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('inspection_inspection_list_details.inspectiontype_name', 'LIKE', '%' . $search . '%');
            });
        }

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

    public function store($inspection)
    {

        $request = request();

        $checklistdetails = $request->insp_check;

        foreach ($checklistdetails as $key => $checklist) {

            $itemId = decryptId($key);
            $categoryId = decryptId($checklist['category']);
            $value = $checklist['value'];
            $observation = isset($checklist['observation']) ? $checklist['observation'] : "";
            $remarks = isset($checklist['remarks']) ? $checklist['remarks'] : "";

            $insert_array = array(
                'inspection_id' => $inspection->id,
                'inspection_type' => decryptId($request->inspectiontype),
                'checklist_category' => $categoryId,
                'checklist_item' => $itemId,
                'score' => $value,
                'observation' => $observation,
                'remarks' => $remarks,
                'inspection_status' => 1,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }



        return true;
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'inspectiontype_name' => $request->inspectiontype_name,
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

        $query = $this->select('inspection_inspection_list_details.*');

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('inspection_inspection_list_details.inspectiontype_name', 'LIKE', '%' . $search . '%');
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


    public function apistore($inspection)
    {

        $request = request();

        $checklistdetails = $request->checklist;

        foreach ($checklistdetails as $key => $checklist) {

            $itemId = $checklist['subcategory_id'];
            $categoryId = $checklist['category_id'];
            $value = $checklist['marks'];
            $observation = isset($checklist['observation']) ? $checklist['observation'] : "";
            $remarks = isset($checklist['remarks']) ? $checklist['remarks'] : "";

            $insert_array = array(
                'inspection_id' => $inspection->id,
                'inspection_type' => $inspection->inspection_type,
                'checklist_category' => $categoryId,
                'checklist_item' => $itemId,
                'score' => $value,
                'observation' => $observation,
                'remarks' => $remarks,
                'inspection_status' => 1,
                'created_by' => Auth::id()
            );

            $this->create($insert_array);
        }



        return true;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_inspection_list_details'));
    }
}
