<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class IncidentInvestigationNearmiss extends Model
{
    use  HasFactory;


    protected $table = 'incident_investigation_nearmiss';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'investigation_id',
        'incident_date',
        'incident_time',
        'company_id',
        'location_id',
        'specific_location_id',
        'employee_involved',
        'immediate_supervisor',
        'description_of_hazard',
        'immediate_action',
        'nearmiss_status',
        'action_taken',
        'action_parties',
        'why_why_analysis',
        'root_cause',
        'root_cause_category',
        'investigation_remarks',
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

        $query = $this->select('incident_investigation_nearmiss.*');


      

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

    public function store($notification_details)
    {
        $request = request();


        $insert_array = array(
            'investigation_id' => decryptId($request->id),
            'incident_date' => $notification_details->incident_date,
            'incident_time' => $notification_details->incident_time,
            'company_id' => $notification_details->company_id,
            'location_id' => $notification_details->location_id,
            'specific_location_id' => $notification_details->specific_location_id,
            'employee_involved' => $request->employee_involved,
            'immediate_supervisor' => $request->immediate_supervisor,
            'description_of_hazard' => $request->description_of_hazard,
            'immediate_action' => $request->immediate_action,
            'nearmiss_status' => $request->nearmiss_status,
            'action_taken' => $request->action_taken,
            'why_why_analysis' => json_encode($request->why_why_analysis),
            'root_cause' => $request->root_cause,
            'root_cause_category' => decryptId($request->root_cause_category),
            'investigation_remarks' => $request->investigation_remarks,
            'created_by' => Auth::id()
        );

        // dd($insert_array);
        return $this->create($insert_array);
    }

    public function approval($id)
    {
        $request = request();

        $update_array = array(
            'approved_by' => $request->approved_by,
            'approved_remarks' => $request->remarks,
            'approved_at' => DBdateformat($request->approved_at),
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
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

        $query = $this->select('incident_investigation_nearmiss.*', 'incident_master_category.category_name', 'incident_master_item.item_name');
        $query = $query->leftJoin('incident_master_category', 'incident_investigation_nearmiss.category_id', '=', 'incident_master_category.id');
        $query = $query->leftJoin('incident_master_item', 'incident_investigation_nearmiss.item_id', '=', 'incident_master_item.id');


        

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
        static::addGlobalScope(new TrashScope('incident_investigation_nearmiss'));
    }
}
