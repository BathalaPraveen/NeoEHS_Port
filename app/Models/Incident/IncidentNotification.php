<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class IncidentNotification extends Model
{
    use  HasFactory;

    protected $table = 'incident_initial_notification';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'incident_id',
        'incident_type',
        'emergency_incident_tier',
        'type_of_notification',
        'location',
        'incident_date',
        'incident_time',
        'weather_condition',
        'company_id',
        'location_id',
        'specific_location_id',
        'category_of_incident',
        'casuality_details',
        'fatality_details',
        'incident_potential',
        'authorities_inform',
        'authorities_inform_other',
        'date_of_informed',
        'brief_description_of_incident',
        'mitigation_action',
        'additional_information',
        'incident_classification',
        'incident_remarks',
        'incident_status',
        'incident_rating',
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

        $query = $this->select('incident_initial_notification.*');


        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_GHSE_APPROVER, getUserRoleId(Auth::id()))) {

            $query->Where('incident_initial_notification.created_by', Auth::id());
        }


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->orWhere('incident_initial_notification.incident_id', 'LIKE', '%' . $search . '%');
            });
        }
        $query = $query->orderBy('id', 'Desc');

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
            'incident_type' => decryptId($request->incident_type),
            'emergency_incident_tier' => decryptId($request->emergency_incident_tier),
            'type_of_notification' => decryptId($request->typeofnotification),
            'location' => decryptId($request->inc_location),
            'incident_date' => DBdateformat($request->incidentdate),
            'incident_time' => $request->incidenttime,
            'weather_condition' => decryptId($request->weather_condition),
            'company_id' => decryptId($request->company),
            'location_id' => decryptId($request->location),
            'specific_location_id' => decryptId($request->specific_location),
            'category_of_incident' => json_encode($request->category_of_incident),
            'casuality_details' => json_encode($request->injuries),
            'fatality_details' => json_encode($request->fatalities),
            'incident_potential' => array_to_string(arrayDecrypt($request->incident_potential)),
            'authorities_inform' => array_to_string(arrayDecrypt($request->authorities_inform)),
            'authorities_inform_other' => $request->authorities_inform_others_text,
            'date_of_informed' => DBdateformat($request->date_informed),
            'brief_description_of_incident' => $request->brief_description,
            'mitigation_action' => $request->mitigation_action,
            'additional_information' => $request->additional_information,
            'incident_classification' => json_encode($request->incidentclassification),
            'incident_remarks' => $request->incident_remarks,
            'incident_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'incident_type' => decryptId($request->incident_type),
            'emergency_incident_tier' => decryptId($request->emergency_incident_tier),
            'type_of_notification' => decryptId($request->typeofnotification),
            'location' => decryptId($request->inc_location),
            'incident_date' => DBdateformat($request->incidentdate),
            'incident_time' => $request->incidenttime,
            'weather_condition' => decryptId($request->weather_condition),
            'company_id' => decryptId($request->company),
            'location_id' => decryptId($request->location),
            'specific_location_id' => decryptId($request->specific_location),
            'category_of_incident' => json_encode($request->category_of_incident),
            'casuality_details' => json_encode($request->injuries),
            'fatality_details' => json_encode($request->fatalities),
            'incident_potential' => array_to_string(arrayDecrypt($request->incident_potential)),
            'authorities_inform' => array_to_string(arrayDecrypt($request->authorities_inform)),
            'authorities_inform_other' => $request->authorities_inform_others_text,
            'date_of_informed' => DBdateformat($request->date_informed),
            'brief_description_of_incident' => $request->brief_description,
            'mitigation_action' => $request->mitigation_action,
            'additional_information' => $request->additional_information,
            'incident_classification' => json_encode($request->incidentclassification),
            'incident_remarks' => $request->incident_remarks,
            'incident_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
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

        $query = $this->select('incident_initial_notification.*', 'incident_master_category.category_name', 'incident_master_item.item_name');
        $query = $query->leftJoin('incident_master_category', 'incident_initial_notification.category_id', '=', 'incident_master_category.id');
        $query = $query->leftJoin('incident_master_item', 'incident_initial_notification.item_id', '=', 'incident_master_item.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_GHSE_APPROVER, getUserRoleId(Auth::id()))) {

            $query->Where('incident_initial_notification.created_by', Auth::id());
        }
        
        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('incident_initial_notification.subitem_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('incident_master_category.category_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('incident_master_item.item_name', 'LIKE', '%' . $search . '%');
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

    public function apistore()
    {
        $request = request();

        $insert_array = array(
            'incident_type' => $request->incident_type,
            'emergency_incident_tier' => $request->emergency_incident_tier,
            'type_of_notification' => $request->typeofnotification,
            'location' => $request->inc_location,
            'incident_date' => DBdateformat($request->incidentdate),
            'incident_time' => $request->incidenttime,
            'weather_condition' => $request->weather_condition,
            'company_id' => $request->company,
            'location_id' => $request->location,
            'specific_location_id' => $request->specific_location,
            'category_of_incident' => json_encode($request->category_of_incident),
            'casuality_details' => json_encode($request->injuries),
            'fatality_details' => json_encode($request->fatalities),
            'incident_potential' => array_to_string($request->incident_potential),
            'authorities_inform' => array_to_string($request->authorities_inform),
            'authorities_inform_other' => $request->authorities_inform_others_text,
            'date_of_informed' => DBdateformat($request->date_informed),
            'brief_description_of_incident' => $request->brief_description,
            'mitigation_action' => $request->mitigation_action,
            'additional_information' => $request->additional_information,
            'incident_classification' => json_encode($request->incidentclassification),
            'incident_remarks' => $request->incident_remarks,
            'incident_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_initial_notification'));

        static::created(function ($model) {
            $uniqueId = 'INCN-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['incident_id' => $uniqueId]);
        });
    }
}
