<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Diving extends Model
{
    use  HasFactory;


    protected $table = 'ptw_sub_permit_diving';
    protected $primaryKey = 'id';

    protected $fillable = [
        'area_of_work',
        'ptw_id',
        'location',
        'sub_permit_id',
        'ptw_status',
        'workstartdate',
        'workenddate',
        'date',
        'time',
        'estimationtime',
        'divingdeep',
        'workdescription',
        'equipment',
        'sitepreparation',
        'divers',
        'accept_terms',
        'dataandtime',
        'applicant_remarks',
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

        $query = $this->select('ptw_sub_permit_diving.*', 'master_location.location_name', 'users.name');
        $query = $query->leftJoin('master_location', 'ptw_sub_permit_diving.location', '=', 'master_location.id');
        $query = $query->leftJoin('users', 'ptw_sub_permit_diving.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_sub_permit_diving.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_sub_permit_diving.location', $location);
        }

      

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id()))) {

            if (in_array(ROLE_CONTRACTORUSER, getUserRoleId(Auth::id())) || in_array(ROLE_CONTRACTORADMIN, getUserRoleId(Auth::id())) || in_array(ROLE_NORMAL_USER, getUserRoleId(Auth::id())) ) {
                $query = $query->where('ptw_sub_permit_diving.created_by', Auth::id());
            } else {
                $companyId = Auth::user()->company;
                $query = $query->where('area_of_work', $companyId);
            }

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

    public function store($general)
    {

        $request = request();

        $equipment = json_encode(
            array(
                'equipment' => arrayDecrypt($request->equipment),
                'equipmentothers' => $request->equipmentothers,
            )
        );


        $insert_array = array(
            'area_of_work' => $general->area_of_work,
            'location' => $general->location,
            'ptw_id' => $general->id,
            'ptw_status' => 1,
            'date' => $request->date,
            'time' => $request->time,
            'workstartdate' => DBdateformat($request->workstartdate),
            'workenddate' => DBdateformat($request->workenddate),
            'estimationtime' => $request->estimationtime,
            'divingdeep' => $request->divingdeep,
            'workdescription' => $request->workdescription,
            'equipment' => $equipment,
            'sitepreparation' => json_encode(arrayDecrypt($request->sitepreparation)),
            'divers' => json_encode($request->divers),
            'accept_terms' => $request->accept_terms,
            'dataandtime' => $request->dataandtime,
            'applicant_remarks' => $request->applicant_remarks,
            'created_by' => Auth::id()
        );




        return $this->create($insert_array);
    }

    public function updates($general)
    {

        $request = request();

        $id = decryptId($request->id);

        $equipment = json_encode(
            array(
                'equipment' => arrayDecrypt($request->equipment),
                'equipmentothers' => $request->equipmentothers,
            )
        );

        $update_array = array(
            'area_of_work' => $general->area_of_work,
            'location' => $general->location,
            'ptw_id' => $general->id,
            'ptw_status' => 1,
            'date' => $request->date,
            'time' => $request->time,
            'workstartdate' => DBdateformat($request->workstartdate),
            'workenddate' => DBdateformat($request->workenddate),
            'estimationtime' => $request->estimationtime,
            'divingdeep' => $request->divingdeep,
            'workdescription' => $request->workdescription,
            'equipment' => $equipment,
            'sitepreparation' => json_encode(arrayDecrypt($request->sitepreparation)),
            'divers' => json_encode($request->divers),
            'accept_terms' => $request->accept_terms,
            'dataandtime' => $request->dataandtime,
            'applicant_remarks' => $request->applicant_remarks,
            'created_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id, $status)
    {

        $update_data = array(
            'ptw_status' => $status,
        );


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

        $query = $this->select('ptw_sub_permit_diving.*', 'master_location.location_name', 'users.name');
        $query = $query->leftJoin('master_location', 'ptw_sub_permit_diving.location', '=', 'master_location.id');
        $query = $query->leftJoin('users', 'ptw_sub_permit_diving.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_sub_permit_diving.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_sub_permit_diving.location', $location);
        }

    

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id()))) {

            $companyId = Auth::user()->company;

            $query = $query->where('area_of_work', $companyId);

        }


        $query = $query->orderBy('created_at', 'Desc');
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


    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_sub_permit_diving'));

        static::created(function ($model) {

            $uniqueId = 'PTW-DIV-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['sub_permit_id' => $uniqueId]);
        });
    }
}
