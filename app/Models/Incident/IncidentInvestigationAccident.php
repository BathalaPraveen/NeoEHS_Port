<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class IncidentInvestigationAccident extends Model
{
    use  HasFactory;


    protected $table = 'incident_investigation_accident';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'investigation_id',
        'incident_title',
        'incident_date',
        'incident_time',
        'company_id',
        'location_id',
        'specific_location_id',
        'employee_involved',
        'witness',
        'immediate_supervisor',
        'immediate_action_taken',
        'brief_description',
        'initial_activity',
        'incident_occurrence',
        'immediate_response',
        'injury_assessment',
        'type_of_asset',
        'owner_of_the_property',
        'estimated_cost',
        'witness_statements',
        'supervisor_account',
        'tl_incident_date',
        'tl_incident_start_time',
        'tl_incident_time',
        'chronology_sequence',
        'environment_conditions',
        'equipment_tools',
        'employee_actions',
        'training_procedures',
        'underlying_cause',
        'root_cause_category',
        'root_cause_details',
        'root_cause_recommendation',
        'action_parties_company',
        'action_parties_location',
        'action_parties_specific_location',
        'division',
        'department',
        'user',
        'lesson_learned_details',
        'conclusion_details',
        'lesson_learned_users',
        'investigation_remarks',
        'type',
        'no_of_mc',
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

        $query = $this->select('incident_investigation_accident.*');


       

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

    public function store($Incident,$notification)
    {

        $request = request();

        $insert_array = array(
            'investigation_id' => $Incident->id,
            'incident_title' => $request->incident_title,
            'incident_date' => $notification->incident_date,
            'incident_time' => $notification->incident_time,
            'company_id' => $notification->company_id,
            'location_id' => $notification->location_id,
            'specific_location_id' => $notification->specific_location_id,
            'employee_involved' => $request->employee_involved,
            'witness' => $request->witness,
            'immediate_supervisor' => $request->immediate_supervisor,
            'immediate_action_taken' => $request->immediate_action_taken,
            'brief_description' => $request->brief_description,
            'initial_activity' => $request->initial_activity,
            'incident_occurrence' => $request->incident_occurrence,
            'immediate_response' => $request->immediate_response,
            'injury_assessment' => $request->injury_assessment,
            'type_of_asset' => $request->type_of_asset,
            'owner_of_the_property' => $request->owner_of_the_property,
            'estimated_cost' => $request->estimated_cost,
            // 'witness_statements' => $request->witness_statements,
            'supervisor_account' => $request->supervisor_account,
            'tl_incident_date' => $request->tl_incident_date,
            'tl_incident_start_time' => $request->tl_incident_start_time,
            'tl_incident_time' => $request->tl_incident_time,
            'chronology_sequence' => $request->chronology_sequence,
            'environment_conditions' => $request->environment_conditions,
            'equipment_tools' => $request->equipment_tools,
            'employee_actions' => $request->employee_actions,
            'training_procedures' => $request->training_procedures,
            'underlying_cause' => $request->underlying_cause,
            'root_cause_category' => decryptId($request->root_cause_category),
            'root_cause_details' => $request->root_cause_details,
            'root_cause_recommendation' => $request->root_cause_recommendation,
            'action_parties_company' => json_encode(($request->action_parties_company)),
            'action_parties_location' => json_encode(($request->action_parties_location)),
            'action_parties_specific_location' => json_encode(($request->action_parties_specific_location)),
            'division' => json_encode(($request->division)),
            'department' => json_encode(($request->department)),
            'user' => json_encode(($request->user)),
            'lesson_learned_details' => json_encode($request->lesson_learned_details),
            'conclusion_details' => json_encode($request->conclusion_details),
            'investigation_remarks' => $request->investigation_remarks,
            'type' => $request->type,
            'no_of_mc' => $request->no_of_mc,
            'created_by' => Auth::id()
        );

        // dd($insert_array);

        return $this->create($insert_array);
    }



    public function updates($id)
    {
        $request = request();

        $update_array = array(
            'category_id' => decryptId($request->category),
            'item_id' => decryptId($request->item),
            'subitem_name' => $request->subitem_name,
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

        $query = $this->select('incident_investigation_accident.*', 'incident_master_category.category_name', 'incident_master_item.item_name');
        $query = $query->leftJoin('incident_master_category', 'incident_investigation_accident.category_id', '=', 'incident_master_category.id');
        $query = $query->leftJoin('incident_master_item', 'incident_investigation_accident.item_id', '=', 'incident_master_item.id');


       

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

    public function CategoryItem($category_id)
    {

        $query = $this->select('id', 'category_id', 'item_name');

        if ($category_id != '') {
            $query = $query->where('category_id', $category_id);
        }

        $datas = $query->get();

        if ($datas != null && $datas != '') {

            $itemlist = [];
            foreach ($datas as $data) {
                $itemlist[encryptId($data->id)] = $data->category_name;
            }
        }


        return $itemlist;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_investigation_accident'));
    }
}
