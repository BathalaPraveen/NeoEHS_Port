<?php

namespace App\Models\Chemical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\Location;

use App\Scopes\TrashScope;
use Carbon\Carbon;

class ChemicalList extends Model
{
    use  HasFactory;


    protected $table = 'chemical_chemical_list';
    protected $primaryKey = 'id';

    protected $fillable = [
        'chemical_id',
        'company_id',
        'gps_coordinate',
        'telephone_no',
        'email',
        'contact_person_name',
        'contact_person_ph',
        'industrial_sector',
        'industrial_classification',
        'company_activity',
        'worker_male',
        'worker_female',
        'work_area',
        'work_process',
        'remarks',
        'chemical_status',
        'old_status',
        'approved_by_id',
        'approved_by_date',
        'approved_by_remarks',
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

        $query = $this->select('chemical_chemical_list.*', 'master_location.location_name', 'master_company.company_name')
            ->leftJoin('master_location', 'chemical_chemical_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'chemical_chemical_list.company_id', '=', 'master_company.id');


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('chemical_chemical_list.chemical_name', 'LIKE', '%' . $search . '%');
            });
        }

        if (
            !in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) &&
            !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) &&
            !in_array(ROLE_SUPERVISING_AUTHORITY, getUserRoleId(Auth::id())) &&
            !in_array(ROLE_CHEMICAL_SUPERVISOR_APPROVER, getUserRoleId(Auth::id())) &&
            !in_array(ROLE_CHEMICAL_GHSE_APPROVER, getUserRoleId(Auth::id())) &&
            !in_array(ROLE_CHEMICAL_HOD, getUserRoleId(Auth::id()))
        ) {
            $query->where('chemical_chemical_list.created_by', Auth::id());
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

    public function store()
    {

        $request = request();
        $insert_array = array(
            'company_id' => decryptId($request->company),
            'gps_coordinate' => $request->gps_coordinate,
            'telephone_no' => $request->company_telephone,
            'email' => $request->company_email,
            'contact_person_name' => Auth::id(),
            'contact_person_ph' => $request->contact_person_ph,
            'industrial_sector' => $request->industrial_sector,
            'industrial_classification' => $request->industrial_classification,
            'company_activity' => decryptId($request->company_activity),
            'work_process' => $request->work_process,
            'work_area' => $request->work_area,
            'worker_male' => $request->no_of_workers_male,
            'worker_female' => $request->no_of_workers_female,
            'chemical_status' => CHEMICAL_STATUS_SUPERVIOER_PENDING,
            'remarks' => $request->reporter_remarks,
            'created_by' => Auth::id()
        );
        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'company_id' => decryptId($request->company),
            'gps_coordinate' => $request->gps_coordinate,
            'telephone_no' => $request->company_telephone,
            'email' => $request->company_email,
            'contact_person_name' => Auth::id(),
            'contact_person_ph' => $request->contact_person_ph,
            'industrial_sector' => $request->industrial_sector,
            'industrial_classification' => $request->industrial_classification,
            'company_activity' => decryptId($request->company_activity),
            'work_area' => $request->work_area,
            'work_process' => $request->work_process,
            'worker_male' => $request->no_of_workers_male,
            'worker_female' => $request->no_of_workers_female,
            'chemical_status' => CHEMICAL_STATUS_SUPERVIOER_PENDING,
            'remarks' => $request->reporter_remarks,
            'updated_by' => Auth::id()

        );

        return $this->where('id', $id)->update($update_array);
    }

    public function approverupdate($id)
    {
        $request = request();
        $update_array = array(
            'approved_by_id' => decryptId($request->approved_by_id),
            'approved_by_date' => DBdateformat(Carbon::now()),
            'approved_by_remarks' => ($request->approved_by_remarks)

        );
        return $this->where('id', $id)->update($update_array);
    }
    public function acknowlegedsubmit($id)
    {
        $request = request();

        $update_array = array(
            'acknowledged_by' => decryptId($request->acknowledged_by),
            'acknowledged_at' => DBdateformat(Carbon::now()),

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

        $query = $this->select('chemical_chemical_list.*', 'master_location.location_name', 'master_company.company_name', 'chemical_chemical_status.chemical_status')
            ->leftJoin('master_location', 'chemical_chemical_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'chemical_chemical_list.company_id', '=', 'master_company.id')
            ->leftJoin('chemical_chemical_status', 'chemical_chemical_list.chemical_status', '=', 'chemical_chemical_status.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_SUPERVISING_AUTHORITY, getUserRoleId(Auth::id())) && !in_array(ROLE_CHEMICAL_GHSE_APPROVER, getUserRoleId(Auth::id()))) {

            $query->Where('chemical_chemical_list.created_by', Auth::id());
        }



        $query = $query->orderBy('id', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $query = $this->select('chemical_chemical_list.*', 'master_location.location_name', 'master_company.company_name')
            ->leftJoin('master_location', 'chemical_chemical_list.location_id', '=', 'master_location.id')
            ->leftJoin('master_company', 'chemical_chemical_list.company_id', '=', 'master_company.id')
            ->where('chemical_chemical_list.id', $id)
            ->first();

        return $query;
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
        static::addGlobalScope(new TrashScope('chemical_chemical_list'));

        static::created(function ($model) {

            $uniqueId = 'CHEM-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['chemical_id' => $uniqueId]);
        });
    }
}
