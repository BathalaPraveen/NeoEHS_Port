<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


use App\Scopes\TrashScope;

class Isolation extends Model
{
    use  HasFactory;


    protected $table = 'ptw_sub_permit_isolation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'area_of_work',
        'ptw_id',
        'sub_permit_id',
        'location',
        'ptw_status',
        'durationofisolation',
        'workstartdate',
        'workenddate',
        'workdescription',
        'whatdoisolate',
        'sourceofenergy',
        'ppelist',
        'isolation',
        'loockoutapplied',
        'icno',
        'isolatiodailycheck',
        'isolationremarks',
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

        $query = $this->select('ptw_sub_permit_isolation.*', 'master_location.location_name',  'users.name');
        $query = $query->leftJoin('master_location', 'ptw_sub_permit_isolation.location', '=', 'master_location.id');
        $query = $query->leftJoin('users', 'ptw_sub_permit_isolation.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_sub_permit_isolation.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_sub_permit_isolation.location', $location);
        }

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('sub_permit_id', 'LIKE', '%' . $search . '%');
            });
        }

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id()))) {

            if (in_array(ROLE_CONTRACTORUSER, getUserRoleId(Auth::id())) || in_array(ROLE_CONTRACTORADMIN, getUserRoleId(Auth::id())) || in_array(ROLE_NORMAL_USER, getUserRoleId(Auth::id())) ) {
                $query = $query->where('ptw_sub_permit_isolation.created_by', Auth::id());
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


        $insert_array = array(
            'area_of_work' => $general->area_of_work,
            'location' => $general->location,
            'ptw_id' => $general->id,
            'ptw_status' => SUBPERMIT_STATUS_PENDING,
            'durationofisolation' => $request->durationofisolation,
            'workstartdate' => DBdateformat($request->workstartdate),
            'workenddate' => DBdateformat($request->workenddate),
            'workdescription' => $request->workdescription,
            'whatdoisolate' => $request->whatdoisolate,
            'sourceofenergy' => $request->sourceofenergy,
            'ppelist' => json_encode(arrayDecrypt($request->ppelist)),
            'isolation' => json_encode($request->isolation),
            'loockoutapplied' => $request->loockoutapplied,
            'icno' => $request->icno,
            'isolatiodailycheck' => json_encode($request->isolatiodailycheck),
            'isolationremarks' => $request->isolationremarks,
            'accept_terms' => $request->accept_terms,
            'dataandtime' => DBdatetimeformat($request->dataandtime),
            'applicant_remarks' => $request->applicant_remarks,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($general)
    {

        $request = request();

        $id  = decryptId($request->id);

        $update_array = array(
            'area_of_work' => $general->area_of_work,
            'location' => $general->location,
            'ptw_id' => $general->id,
            'ptw_status' => SUBPERMIT_STATUS_PENDING,
            'durationofisolation' => $request->durationofisolation,
            'workstartdate' => DBdateformat($request->workstartdate),
            'workenddate' => DBdateformat($request->workenddate),
            'workdescription' => $request->workdescription,
            'whatdoisolate' => $request->whatdoisolate,
            'sourceofenergy' => $request->sourceofenergy,
            'ppelist' => json_encode(arrayDecrypt($request->ppelist)),
            'isolation' => json_encode($request->isolation),
            'loockoutapplied' => $request->loockoutapplied,
            'icno' => $request->icno,
            'isolatiodailycheck' => json_encode($request->isolatiodailycheck),
            'isolationremarks' => $request->isolationremarks,
            'accept_terms' => $request->accept_terms,
            'dataandtime' => DBdatetimeformat($request->dataandtime),
            'applicant_remarks' => $request->applicant_remarks,
            'updated_by' => Auth::id()
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

        $query = $this->select('ptw_sub_permit_isolation.*', 'master_location.location_name',  'users.name');
        $query = $query->leftJoin('master_location', 'ptw_sub_permit_isolation.location', '=', 'master_location.id');
        $query = $query->leftJoin('users', 'ptw_sub_permit_isolation.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_sub_permit_isolation.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_sub_permit_isolation.location', $location);
        }

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('sub_permit_id', 'LIKE', '%' . $search . '%');
            });
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
        static::addGlobalScope(new TrashScope('ptw_sub_permit_isolation'));

        static::created(function ($model) {

            $uniqueId = 'PTW-ISO-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['sub_permit_id' => $uniqueId]);
        });
    }
}
