<?php

namespace App\Models\HIRADC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class HazardList extends Model
{
    use  HasFactory;


    protected $table = 'hiradc_hiradc_list_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'hazard_id',
        'document_id',
        'documenttype_id',
        'category_id',
        'activities_area_process',
        'routine_type',
        'location_specific',
        'aspects',
        'impacts',
        'compliance_obligation',
        'hazard',
        'effects',
        'existing_control',
        'severity',
        'likelyhood',
        'risk',
        'dfa',
        'opportunities',
        'proposed_control',
        'hazard_status',
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

    public function listeai()
    {
        $request = request();
        $search = '';
        $documentid = '';

        if ($request->type == 'eai') {
            $documentid = HIRADC_DOCUMENT_EAI;
        } else if ($request->type == 'hiradc') {
            $documentid = HIRADC_DOCUMENT_HIRADC;
        } else if ($request->type == 'riskregister') {
            $documentid = HIRADC_DOCUMENT_RISK_REGISTER;
        }

        $query = $this->select(
            'hiradc_hiradc_list_details.*',
            'hiradc_master_document.document_name',
            'hiradc_master_document_type.documenttype_name',
            'hiradc_master_document_type_category.category_name'
        );
        $query = $query->leftJoin('hiradc_master_document', 'hiradc_hiradc_list_details.document_id', '=', 'hiradc_master_document.id');
        $query = $query->leftJoin('hiradc_master_document_type', 'hiradc_hiradc_list_details.documenttype_id', '=', 'hiradc_master_document_type.id');
        $query = $query->leftJoin('hiradc_master_document_type_category', 'hiradc_hiradc_list_details.category_id', '=', 'hiradc_master_document_type_category.id');

        $query = $query->where('hiradc_hiradc_list_details.document_id',  $documentid);

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('hiradc_master_document.document_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('hiradc_master_document_type.documenttype_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('hiradc_master_document_type_category.category_name', 'LIKE', '%' . $search . '%');
            });
        }

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

    public function store($risk_id)
    {

        $request = request();

        $riskdetails = $request->riskdetails;

        foreach ($riskdetails as $risk) {

            $document_id = decryptId($request->document_type);

            $risk = (object)$risk;
            if ($document_id == 2) {
                $hazard = $risk->hazard;
                $effects = $risk->effects;
            } else if ($document_id == 3) {
                $hazard = $risk->rr_hazard;
                $effects = $risk->rr_effects;
            } else {
                $hazard = '';
                $effects = '';
            }


            $riskrating = $risk->severity * $risk->likelihood;

            $riskcolor = hazardriskLevel($riskrating);

            $insert_array = array(
                'hazard_id' => $risk_id,
                'document_id' => $document_id,
                'documenttype_id' => decryptId($request->docuenttype),
                'category_id' => decryptId($request->docuenttypecategory),
                'activities_area_process' => $risk->actiities,
                'routine_type' => $risk->c,
                'location_specific' => $risk->locationspecific,
                'aspects' => $risk->aspects,
                'impacts' => $risk->impacts,
                'compliance_obligation' => $risk->complaince_obligation,
                'hazard' => $hazard,
                'effects' => $effects,
                'existing_control' => $risk->existing_control,
                'severity' => $risk->severity,
                'likelyhood' => $risk->likelihood,
                'risk' => $riskrating,
                'dfa' => $riskcolor,
                'opportunities' => $risk->opportunities,
                'proposed_control' => $risk->proposed_control,
                'hazard_status' => 0,
                'created_by' => Auth::id()
            );



            $this->create($insert_array);
        }



        return true;
    }

    public function updates($id)
    {

        $request = request();

        $riskdetails = $request->riskdetails;

        $this->where('hazard_id', $id)->update(['trash' => 'YES', 'status' => 0]);

        foreach ($riskdetails as $risk) {


            $document_id = decryptId($request->document_type);

            $risk = (object)$risk;

            $risk_order_id = decryptId($risk->risk_order_id);
            if ($document_id == 2) {
                $hazard = $risk->hazard;
                $effects = $risk->effects;
            } else if ($document_id == 3) {
                $hazard = $risk->rr_hazard;
                $effects = $risk->rr_effects;
            } else {
                $hazard = '';
                $effects = '';
            }

            $riskrating = $risk->severity * $risk->likelihood;

            $riskcolor = hazardriskLevel($riskrating);

            $update_array = array(
                'document_id' => $document_id,
                'documenttype_id' => decryptId($request->docuenttype),
                'category_id' => decryptId($request->docuenttypecategory),
                'activities_area_process' => $risk->actiities,
                'routine_type' => $risk->c,
                'location_specific' => $risk->locationspecific,
                'aspects' => $risk->aspects,
                'impacts' => $risk->impacts,
                'compliance_obligation' => $risk->complaince_obligation,
                'hazard' => $hazard,
                'effects' => $effects,
                'existing_control' => $risk->existing_control,
                'severity' => $risk->severity,
                'likelyhood' => $risk->likelihood,
                'risk' => $riskrating,
                'dfa' => $riskcolor,
                'opportunities' => $risk->opportunities,
                'proposed_control' => $risk->proposed_control,
                'hazard_status' => 0,
            );

            if($risk_order_id != '' && $risk_order_id != null){

                $update_array['updated_by'] = Auth::id();
                $update_array['trash'] = 'NO';
                $update_array['status'] = 1;

                $this->withoutGlobalScope(TrashScope::class)->where('id', $risk_order_id)->update($update_array);

            }else{

                $update_array['created_by'] = Auth::id();
                $update_array['hazard_id'] = $id;

                $this->create($update_array);
            }
        }

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

        return $this->where('hazard_id', $id)->update($update_data);
    }

    public function exportdataeai()
    {
        $request = request();
        $search = '';

        $documentid = '';

        if ($request->type == 'eai') {
            $documentid = HIRADC_DOCUMENT_EAI;
        } else if ($request->type == 'hiradc') {
            $documentid = HIRADC_DOCUMENT_HIRADC;
        } else if ($request->type == 'riskregister') {
            $documentid = HIRADC_DOCUMENT_RISK_REGISTER;
        }

        $query = $this->select(
            'hiradc_hiradc_list_details.*',
            'hiradc_master_document.document_name',
            'hiradc_master_document_type.documenttype_name',
            'hiradc_master_document_type_category.category_name'
        );
        $query = $query->leftJoin('hiradc_master_document', 'hiradc_hiradc_list_details.document_id', '=', 'hiradc_master_document.id');
        $query = $query->leftJoin('hiradc_master_document_type', 'hiradc_hiradc_list_details.documenttype_id', '=', 'hiradc_master_document_type.id');
        $query = $query->leftJoin('hiradc_master_document_type_category', 'hiradc_hiradc_list_details.category_id', '=', 'hiradc_master_document_type_category.id');

        $query = $query->where('hiradc_hiradc_list_details.document_id',  $documentid);

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {


                $query->orWhere('hiradc_master_document.document_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('hiradc_master_document_type.documenttype_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('hiradc_master_document_type_category.category_name', 'LIKE', '%' . $search . '%');
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

    public function getWhere($where)
    {

        $query = $this->select('*');

        if ($where != '') {
            $query = $query->where($where);
        }

        $datas = $query->get();


        return $datas;
    }

    public function CategoryItem($inspectiontype)
    {

        $query = $this->select('id', 'document_id', 'documenttype_id', 'category_name');

        if ($inspectiontype != '') {
            $query = $query->where('document_id', $inspectiontype);
        }

        $datas = $query->get();

        if ($datas != null && $datas != '') {

            $itemlist = [];
            foreach ($datas as $loan) {

                $itemlist[$loan->documenttype_id][] = $loan;
            }
        }


        return $itemlist;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('hiradc_hiradc_list_details'));
    }
}
