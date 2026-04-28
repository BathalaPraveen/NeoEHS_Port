<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Inspection extends Model
{
    use  HasFactory;


    protected $table = 'inspection_inspection_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'inspection_id',
        'inspection_type',
        'assign_to',
        'company',
        'location',
        'specific_location',
        'insp_type',
        'msd_representative',
        'tsd_representative',
        'jetty_location',
        'building_type',
        'building_type_others',
        'caretaker_id',
        'equipment_type',
        'equipment_type_other',
        'operator_id',
        'vessel_lengh',
        'vessel_name',
        'vessel_type',
        'vessel_beam',
        'vessel_depth',
        'vessel_gross',
        'vessel_hull',
        'vessel_hull_other',
        'vessel_superstructure',
        'vessel_superstructure_other',
        'vessel_propulsion',
        'vessel_owner',
        'vessel_owner_other',
        'vessel_operator',
        'vessel_operator_other',
        'vessel_imo_registration',
        'vessel_flag',
        'vessel_port_of_registry',
        'vessel_classification',
        'vessel_total_person',
        'inspected_by',
        'inspection_remarks',
        'score',
        'inspection_date',
        'inspection_time',
        'inspection_status',
        'inspector_id',
        'overallfeedback',
        'inspector_remarks',
        'org_inspection_date',
        'org_inspection_time',
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

        $query = $this->select('inspection_inspection_list.*', 'inspection_master_inspection_type.inspectiontype_name', 'master_location.location_name');
        $query = $query->leftJoin('inspection_master_inspection_type', 'inspection_master_inspection_type.id', '=', 'inspection_inspection_list.inspection_type')
            ->leftJoin('master_location', 'master_location.id', '=', 'inspection_inspection_list.location');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id())) && !in_array(ROLE_HOD, getUserRoleId(Auth::id()))) {

            $query->Where('inspection_inspection_list.assign_to', Auth::id());
        }

        if ($request->has('inspectiontype') && $request->inspectiontype != '') {
            $inspectiontype = decryptId($request->inspectiontype);
            $query->Where('inspection_inspection_list.inspection_type', '=', $inspectiontype);
        }
        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('inspection_inspection_list.location', '=', $location);
        }
        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('inspection_inspection_list.inspection_status', '=', $status);
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

    public function createinspection()
    {

        $request = request();

        $insert_array = array(
            'company' => decryptId($request->company),
            'location' => decryptId($request->location),
            'specific_location' => decryptId($request->specific_location),
            'inspection_type' => decryptId($request->inspectiontype),
            'inspection_date' => DBdateformat($request->inspectiondate),
            'inspection_time' => $request->inspectiontime,
            'assign_to' => decryptId($request->assignto),
            'inspection_remarks' => $request->inspectionremarks,
            'inspection_status' => INSPECTION_STATUS_ASSIGNED,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function store()
    {

        $request = request();

        $id = decryptId($request->id);

        if ($request->has('mark')) {
            $marks = json_encode($request->mark);
        } else {
            $marks = '';
        }

        if ($request->has('jetty_location')) {
            $jetty_location = decryptId($request->jetty_location);
        } else {
            $jetty_location = '';
        }

        if ($request->has('msd_representative')) {
            $msd_representative = decryptId($request->msd_representative);
        } else {
            $msd_representative = '';
        }

        if ($request->has('tsd_representative')) {
            $tsd_representative = decryptId($request->tsd_representative);
        } else {
            $tsd_representative = '';
        }

        if ($request->has('caretaker_id')) {
            $caretaker_id = decryptId($request->caretaker_id);
        } else {
            $caretaker_id = '';
        }


        if ($request->has('operator_id')) {
            $operator_id = $request->operator_id;
        } else {
            $operator_id = '';
        }

        if ($request->has('overallfeedback')) {
            $overallfeedback = $request->overallfeedback;
        } else {
            $overallfeedback = '';
        }
        if ($request->has('division')) {
            $division = $request->division;
        } else {
            $division = '';
        }



        $insert_array = array(
            'insp_type' => $request->insp_type,
            'msd_representative' => $msd_representative,
            'tsd_representative' => $tsd_representative,
            'jetty_location' => $jetty_location,
            'building_type' => $request->building_type,
            'building_type_others' => $request->building_type_others,
            'caretaker_id' => $caretaker_id,
            'equipment_type' => $request->equipment_type,
            'equipment_type_other' => $request->equipment_type_other,
            'operator_id' => $operator_id,
            'vessel_lengh' => $request->vessel_lengh,
            'vessel_name' => $request->vessel_name,
            'vessel_type' => $request->vessel_type,
            'vessel_beam' => $request->vessel_beam,
            'vessel_depth' => $request->vessel_depth,
            'vessel_gross' => $request->vessel_gross,
            'vessel_hull' => $request->vessel_hull,
            'vessel_hull_other' => $request->vessel_hull_other,
            'vessel_superstructure' => $request->vessel_superstructure,
            'vessel_superstructure_other' => $request->vessel_superstructure_other,
            'vessel_propulsion' => $request->vessel_propulsion,
            'vessel_owner' => $request->vessel_owner,
            'vessel_owner_other' => $request->vessel_owner_other,
            'vessel_operator' => $request->vessel_operator,
            'vessel_operator_other' => $request->vessel_operator_other,
            'vessel_imo_registration' => $request->vessel_imo_registration,
            'vessel_flag' => $request->vessel_flag,
            'vessel_port_of_registry' => $request->vessel_port_of_registry,
            'vessel_classification' => $request->vessel_classification,
            'vessel_total_person' => $request->vessel_total_person,
            'division' => $division,
            'inspector_id' => Auth::id(),
            'inspector_remarks' => $request->inspectionremarks,
            'org_inspection_date' => todayDbdate(),
            'org_inspection_time' => currenttime(),
            'score' => $marks,
            'inspection_status' => INSPECTION_STATUS_INSPECTION_COMPLETED,
            'overallfeedback' => $overallfeedback,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($insert_array);
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

        $query = $this->select('inspection_inspection_list.*', 'inspection_master_inspection_type.inspectiontype_name', 'master_location.location_name', 'inspection_inspection_status.status_name');
        $query = $query->leftJoin('inspection_master_inspection_type', 'inspection_master_inspection_type.id', '=', 'inspection_inspection_list.inspection_type')
            ->leftJoin('master_location', 'master_location.id', '=', 'inspection_inspection_list.location')
            ->leftJoin('inspection_inspection_status', 'inspection_inspection_status.id', '=', 'inspection_inspection_list.inspection_status');


        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id())) && !in_array(ROLE_HOD, getUserRoleId(Auth::id()))) {

            $query->Where('inspection_inspection_list.assign_to', Auth::id());
        }

        if ($request->has('inspectiontype') && $request->inspectiontype != '') {
            $inspectiontype = decryptId($request->inspectiontype);
            $query->Where('inspection_inspection_list.inspection_type', '=', $inspectiontype);
        }
        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('inspection_inspection_list.location', '=', $location);
        }
        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('inspection_inspection_list.inspection_status', '=', $status);
        }

        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select(
            'inspection_inspection_list.*',
            'inspection_master_inspection_type.inspectiontype_name',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
        );
        $data = $data->leftJoin('inspection_master_inspection_type', 'inspection_master_inspection_type.id', '=', 'inspection_inspection_list.inspection_type')
            ->leftJoin('master_location', 'master_location.id', '=', 'inspection_inspection_list.location')
            ->leftJoin('master_location_specific', 'master_location_specific.id', '=', 'inspection_inspection_list.specific_location')
            ->where('inspection_inspection_list.id', $id)
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


    public function apicreateinspection()
    {

        $request = request();

        $insert_array = array(
            'company' => $request->company,
            'location' => $request->location,
            'specific_location' => $request->specific_location,
            'inspection_type' => $request->inspection_type,
            'inspection_date' => DBdateformat($request->inspection_date),
            'inspection_time' => $request->inspection_time,
            'assign_to' => Auth::id(),
            'inspection_remarks' => '',
            'inspection_status' => INSPECTION_STATUS_ASSIGNED,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }


    public function apistore($id)
    {

        $request = request();

        $inspectionexist = $this->find($id);

        $inspectiontype = $inspectionexist->inspection_type;

        $inspectiontypedetails = getInspectionTypedetails($inspectiontype);

        $marks = '';

        if ($inspectiontypedetails->marks_type == 2) {

            $checklistdetails = $request->checklist;

            $total_issue = $issue_value_1 = $issue_value_2 = $issue_value_3 = $total_scores = $overallscore = 0;

            foreach ($checklistdetails as $checklist) {

                switch ($checklist) {

                    case '1':
                        $total_issue += 1;
                        $issue_value_1 += 1;
                        break;
                    case '2':
                        $total_issue += 1;
                        $issue_value_2 += 1;
                        break;
                    case '3':
                        $total_issue += 1;
                        $issue_value_3 += 1;
                        break;
                    default:
                        break;
                }
            }

            $total_scores =  ($issue_value_1 * 1) + ($issue_value_2 * 2) + ($issue_value_3 * 3);

            if ($total_issue > 0) {
                $overallscore = round(($total_scores /  $total_issue * 3) * 100, 2);
            } else {
                $overallscore = 0;
            }



            if ($overallscore >= 81) {
                $scorerange = 1;
            }
            if ($overallscore >= 41) {
                $scorerange = 2;
            }
            if ($overallscore >= 0) {
                $scorerange = 3;
            }

            $mark =  [
                "total_issue" => $total_issue,
                "issue_value_1" => $issue_value_1 * 1,
                "issue_value_2" => $issue_value_2 * 2,
                "issue_value_3" => $issue_value_3 * 3,
                "total_scores" =>  $total_scores,
                "overallscore" => $overallscore,
                "scorerange" => $scorerange
            ];

            $marks = json_encode($mark);
        }

        $boatAudit =  (object)$request->boat_audit;


        $insert_array = array(
            'insp_type' => $boatAudit?->insp_type,
            'vessel_lengh' => $boatAudit?->vessel_lengh,
            'vessel_name' => $boatAudit?->vessel_name,
            'vessel_type' => $boatAudit?->vessel_type,
            'vessel_beam' => $boatAudit?->vessel_beam,
            'vessel_depth' => $boatAudit?->vessel_depth,
            'vessel_gross' => $boatAudit?->vessel_gross,
            'vessel_hull' => $boatAudit?->vessel_hull,
            'vessel_hull_other' => $boatAudit?->vessel_hull_other,
            'vessel_superstructure' => $boatAudit?->vessel_superstructure,
            'vessel_superstructure_other' => $boatAudit?->vessel_superstructure_other,
            'vessel_propulsion' => $boatAudit?->vessel_propulsion,
            'vessel_owner' => $boatAudit?->vessel_owner,
            'vessel_owner_other' => $boatAudit?->vessel_owner_other,
            'vessel_operator' => $boatAudit?->vessel_operator,
            'vessel_operator_other' => $boatAudit?->vessel_operator_other,
            'vessel_imo_registration' => $boatAudit?->vessel_imo_registration,
            'vessel_flag' => $boatAudit?->vessel_flag,
            'vessel_port_of_registry' => $boatAudit?->vessel_port_of_registry,
            'vessel_classification' => $boatAudit?->vessel_classification,
            'vessel_total_person' => $boatAudit?->vessel_total_person,
            'inspector_id' => Auth::id(),
            'inspector_remarks' => $request->inspection_remarks,
            'org_inspection_date' => todayDbdate(),
            'org_inspection_time' => currenttime(),
            'score' => $marks,
            'inspection_status' => INSPECTION_STATUS_INSPECTION_COMPLETED,
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($insert_array);
    }


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('inspection_inspection_list'));

        static::created(function ($model) {

            $uniqueId = 'INSP-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['inspection_id' => $uniqueId]);
        });
    }
}
