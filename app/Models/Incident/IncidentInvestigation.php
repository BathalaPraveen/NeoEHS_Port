<?php

namespace App\Models\Incident;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class IncidentInvestigation extends Model
{
    use  HasFactory;


    protected $table = 'incident_investigation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'inc_id',
        'incident_id',
        'incident_type',
        'investigation_id',
        'incident_rating',
        'investigation_date',
        'investigation_status',
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

        $query = $this->select('incident_investigation.*', 'incident_initial_notification.location_id', 'incident_initial_notification.incident_date');

        $query = $query->leftJoin('incident_initial_notification', 'incident_initial_notification.id', '=', 'incident_investigation.inc_id');

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($query) use ($search) {
                $query->orWhere('incident_investigation.incident_id', 'LIKE', '%' . $search . '%');
            });
        }
        $query = $query->orderBy('id', 'Desc');
        $data_count = $query->count();
        $total_records = $data_count;

        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }


        if ($request->has('incident_type') && $request->incident_type) {

            $query->where('incident_investigation.incident_type', decryptId($request->incident_type));
        }

        if ($request->has('incident_id') && $request->incident_id) {
            $query->where('incident_investigation.incident_id', ($request->incident_id));
        }
        if ($request->has('location') && $request->location) {
            $query->where('incident_initial_notification.location_id', decryptId($request->location));
        }
        if ($request->has('status') && $request->status) {
            $query->where('incident_investigation.investigation_status', decryptId($request->status));
        }
        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function assignUser($id)
    {
        $request = request();

        $update_array = array(
            'investigator_company' => decryptId($request->company),
            'investigator_division' => decryptId($request->division),
            'investigator_department' => decryptId($request->department),
            'investigator_id' => decryptId($request->user),
            'investigation_status' => INCIDENT_INVESTIGATION_STATUS_PENDING,
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function store($Incident)
    {

        $request = request();

        $insert_array = array(
            'inc_id' => $Incident->id,
            'incident_id' => $Incident->incident_id,
            'incident_type' => $Incident->incident_type,
            'incident_rating' => decryptId($request->incident_rating),
            'investigation_status' => INCIDENT_INVESTIGATION_STATUS_NOT_ASSIGNED,
            'created_by' => Auth::id()
        );

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

        $query = $this->select('incident_investigation.*', 'incident_initial_notification.location_id', 'incident_initial_notification.incident_date');

        $query = $query->leftJoin('incident_initial_notification', 'incident_initial_notification.id', '=', 'incident_investigation.inc_id');


        if ($request->has('incident_type') && $request->incident_type) {

            $query->where('incident_investigation.incident_type', decryptId($request->incident_type));
        }

        if ($request->has('incident_id') && $request->incident_id) {
            $query->where('incident_investigation.incident_id', ($request->incident_id));
        }
        if ($request->has('location') && $request->location) {
            $query->where('incident_initial_notification.location_id', decryptId($request->location));
        }
        if ($request->has('status') && $request->status) {
            $query->where('incident_investigation.investigation_status', decryptId($request->status));
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

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('incident_investigation'));

        static::created(function ($model) {
            $uniqueId = 'INCI-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['investigation_id' => $uniqueId]);
        });
    }
}
