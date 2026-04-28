<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Hazard extends Model
{
    use  HasFactory;


    protected $table = 'hiradc_hiradc_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'risk_id',
        'document_type',
        'document_sub_type',
        'document_sub_type_category',
        'process_type',
        'process_type_details',
        'activity_number',
        'process_type_details_other',
        'approve_status',
        'remarks',
        'created_by',
        'updated_by',
        'status',
        'trash',
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

        $query = $this->select(
            'hiradc_hiradc_list.*',
            'hiradc_master_document.document_name',
            'hiradc_master_process_type.process_type_name',

        );
        $query = $query->leftJoin('hiradc_master_document', 'hiradc_hiradc_list.document_type', '=', 'hiradc_master_document.id');
        $query = $query->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list.process_type', '=', 'hiradc_master_process_type.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HIRADC_HOD_APPROVER, getUserRoleId(Auth::id()))) {

            $query->Where('hiradc_hiradc_list.created_by', Auth::id());
        }


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('hiradc_master_document.document_name', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->documenttype != null || $request->documenttype != '') {

            $documenttype = decryptId($request->documenttype);
            $query = $query->where('hiradc_hiradc_list.document_type', $documenttype);
        }

        if ($request->status != null || $request->status != '') {
            $status = decryptId($request->status);
            $query = $query->where('hiradc_hiradc_list.approve_status', $status);
        }

        $data_count = $query->count();
        $total_records = $data_count;

        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->orderBy('id', 'DESC');
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

        if (getProcesstypeId($request->process_type) == 2) {
            $activity_number = $request->activity_number_ammednent;
        } else if (getProcesstypeId($request->process_type) == 3) {
            $activity_number = $request->activity_number_withdraw;
        } else {
            $activity_number = '';
        }

        $insert_array = array(
            'document_type' => decryptId($request->document_type),
            'document_sub_type' => decryptId($request->docuenttype),
            'document_sub_type_category' => decryptId($request->docuenttypecategory),
            'process_type' => getProcesstypeId($request->process_type),
            'process_type_details' => array_to_string(arrayDecrypt($request->subprocesstype)),
            'process_type_details_other' => $request->category_name,
            'approve_status' => 1,
            'activity_number' =>  $activity_number,
            'remarks' => $request->reporter_remarks,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        if (getProcesstypeId($request->process_type) == 2) {
            $activity_number = $request->activity_number_ammednent;
        } else if (getProcesstypeId($request->process_type) == 3) {
            $activity_number = $request->activity_number_withdraw;
        } else {
            $activity_number = '';
        }

        $update_array = array(
            'document_type' => decryptId($request->document_type),
            'document_sub_type' => decryptId($request->docuenttype),
            'document_sub_type_category' => decryptId($request->docuenttypecategory),
            'process_type' => getProcesstypeId($request->process_type),
            'process_type_details' => array_to_string(arrayDecrypt($request->subprocesstype)),
            'process_type_details_other' => $request->category_name,
            'approve_status' => 1,
            'activity_number' =>  $activity_number,
            'remarks' => $request->reporter_remarks,
            'updated_by' => Auth::id()
        );
        $this->where('id', $id)->update($update_array);

        return true;
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

        $query = $this->select(
            'hiradc_hiradc_list.*',
            'hiradc_master_document.document_name',
            'hiradc_master_document_type.documenttype_name',
            'hiradc_master_document_type_category.category_name',
            'hiradc_master_process_type.process_type_name',
        )
            ->leftJoin('hiradc_master_document', 'hiradc_hiradc_list.document_type', '=', 'hiradc_master_document.id')
            ->leftJoin('hiradc_master_document_type', 'hiradc_hiradc_list.document_sub_type', '=', 'hiradc_master_document_type.id')
            ->leftJoin('hiradc_master_document_type_category', 'hiradc_hiradc_list.document_sub_type_category', '=', 'hiradc_master_document_type_category.id')
            ->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list.process_type', '=', 'hiradc_master_process_type.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HIRADC_HOD_APPROVER, getUserRoleId(Auth::id()))) {

            $query->Where('hiradc_hiradc_list.created_by', Auth::id());
        }

        if ($request->documenttype != null || $request->documenttype != '') {

            $documenttype = decryptId($request->documenttype);
            $query = $query->where('hiradc_hiradc_list.document_type', $documenttype);
        }

        if ($request->status != null || $request->status != '') {
            $status = decryptId($request->status);
            $query = $query->where('hiradc_hiradc_list.approve_status', $status);
        }

        $query = $query->orderBy('id', 'Desc');

        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select(
            'hiradc_hiradc_list.*',
            'hiradc_master_document.document_name',
            'hiradc_master_document_type.documenttype_name',
            'hiradc_master_document_type_category.category_name',
            'hiradc_master_process_type.process_type_name',
        )
            ->leftJoin('hiradc_master_document', 'hiradc_hiradc_list.document_type', '=', 'hiradc_master_document.id')
            ->leftJoin('hiradc_master_document_type', 'hiradc_hiradc_list.document_sub_type', '=', 'hiradc_master_document_type.id')
            ->leftJoin('hiradc_master_document_type_category', 'hiradc_hiradc_list.document_sub_type_category', '=', 'hiradc_master_document_type_category.id')
            ->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list.process_type', '=', 'hiradc_master_process_type.id')
            ->where('hiradc_hiradc_list.id', $id)
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

        $query = $this->select('id', 'category_name');

        if ($where != '') {
            $query = $query->where($where);
        }

        $datas = $query->get();


        return $datas;
    }

    protected static function booted()
    {
        static::created(function ($model) {
            $uniqueId = 'RISK-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['risk_id' => $uniqueId]);
        });

        static::addGlobalScope(new TrashScope('hiradc_hiradc_list'));
    }
}
