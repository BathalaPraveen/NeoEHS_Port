<?php

namespace App\Models\Machinery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Scopes\TrashScope;

class Machinery extends Model
{
    use  HasFactory;


    protected $table = 'machinery_machinery_details';
    protected $primaryKey = 'id';

    protected $fillable = [
        'machinery_id',
        'machinery_status',
        'machinery_tag',
        'inspection_checklist',
        'expiry_date',
        'location',
        'specific_location',
        'area',
        'vessel_name',
        'machinery_type',
        'particularmachinery',
        'purposeofuse',
        'inspectiondate',
        'inspectiontime',
        'purposelocationofinspection',
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
        $query = $this->select(

            'machinery_machinery_details.*',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'machinery_master_typeofmachinery.machinery_type as machinery_type_name',
        )
            ->leftJoin('master_location', 'machinery_machinery_details.location', '=', 'master_location.id')
            ->leftJoin('master_location_specific', 'machinery_machinery_details.specific_location', '=', 'master_location_specific.id')
            ->leftJoin('machinery_master_typeofmachinery', 'machinery_machinery_details.machinery_type', '=', 'machinery_master_typeofmachinery.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_GHSE_APPROVER, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id()))) {

            $query->Where('machinery_machinery_details.created_by', Auth::id());
        }

        if ($request->has('machinerytype') && $request->machinerytype != '') {
            $machinerytype = decryptId($request->machinerytype);
            $query->Where('machinery_machinery_details.machinery_type', $machinerytype);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('machinery_machinery_details.location', $location);
        }

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);

            $query->Where('machinery_machinery_details.machinery_status', $status);
        }

        // if ($request->search['value'] != null || $request->search['value'] != '') {
        //     $search = $request->search['value'];

        //     $query->where(function ($query) use ($search) {
        //         $query->orWhere('machinery_machinery_details.machinery_id', 'LIKE', '%' . $search . '%');
        //         $query->orWhere('machinery_master_typeofmachinery.machinery_type', 'LIKE', '%' . $search . '%');
        //         $query->orWhere('master_location.location_name', 'LIKE', '%' . $search . '%');
        //         $query->orWhere('machinery_master_typeofmachinery.machinery_type', 'LIKE', '%' . $search . '%');
        //     });
        // }

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

        $particularmachinery = [];

        foreach ($request->particularmachinery as $key => $value) {

            $particularmachinery[decryptId($key)] = $value == null ? "" : $value;
        }

        $insert_array = array(
            'machinery_status' => 1,
            'location' => decryptId($request->location),
            'specific_location' => decryptId($request->specific_location),
            'area' => $request->area,
            'vessel_name' => $request->vessel_name,
            'machinery_type' => decryptId($request->machinerytype),
            'machinery_type_others' => $request->machinery_type_others,
            'particularmachinery' => json_encode($particularmachinery),
            'purposeofuse' => $request->purposeofuse,
            'inspectiondate' => DBdateformat($request->inspectiondate),
            'inspectiontime' => $request->inspectiontime,
            'purposelocationofinspection' => $request->purposelocationofinspection,
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();
        $machinery_old = $this->find($id);
        $new_status = $machinery_old->machinery_status - 1;
        $particularmachinery = [];

        foreach ($request->particularmachinery as $key => $value) {

            $particularmachinery[decryptId($key)] = $value == null ? "" : $value;
        }

        $update_array = array(
            'machinery_status' =>  $new_status,
            'location' => decryptId($request->location),
            'specific_location' => decryptId($request->specific_location),
            'area' => $request->area,
            'vessel_name' => $request->vessel_name,
            'machinery_type' => decryptId($request->machinerytype),
            'machinery_type_others' => $request->machinery_type_others,
            'particularmachinery' => json_encode($particularmachinery),
            'purposeofuse' => $request->purposeofuse,
            'inspectiondate' => DBdateformat($request->inspectiondate),
            'inspectiontime' => $request->inspectiontime,
            'purposelocationofinspection' => $request->purposelocationofinspection,
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

        $query = $this->select(

            'machinery_machinery_details.*',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'machinery_master_typeofmachinery.machinery_type as machinery_type_name',
            'machinery_machinery_status.status_name'
        )
            ->leftJoin('master_location', 'machinery_machinery_details.location', '=', 'master_location.id')
            ->leftJoin('machinery_machinery_status', 'machinery_machinery_details.machinery_status', '=', 'machinery_machinery_status.id')
            ->leftJoin('master_location_specific', 'machinery_machinery_details.specific_location', '=', 'master_location_specific.id')
            ->leftJoin('machinery_master_typeofmachinery', 'machinery_machinery_details.machinery_type', '=', 'machinery_master_typeofmachinery.id');

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_GHSE_APPROVER, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id()))) {

            $query->Where('machinery_machinery_details.created_by', Auth::id());
        }

        if ($request->has('machinerytype') && $request->machinerytype != '') {
            $machinerytype = decryptId($request->machinerytype);
            $query->Where('machinery_machinery_details.machinery_type', $machinerytype);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('machinery_machinery_details.location', $location);
        }

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);

            $query->Where('machinery_machinery_details.machinery_status', $status);
        }
        $query->orderBy('id', 'DESC');
        $query = $query->orderBy('id', 'Asc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select(
            'machinery_machinery_details.*',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'machinery_master_typeofmachinery.machinery_type as machinery_type_name',
        )
            ->leftJoin('master_location', 'machinery_machinery_details.location', '=', 'master_location.id')
            ->leftJoin('master_location_specific', 'machinery_machinery_details.specific_location', '=', 'master_location_specific.id')
            ->leftJoin('machinery_master_typeofmachinery', 'machinery_machinery_details.machinery_type', '=', 'machinery_master_typeofmachinery.id')
            ->where('machinery_machinery_details.id', $id)
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
        static::addGlobalScope(new TrashScope('machinery_machinery_details'));

        static::created(function ($model) {
            $uniqueId = 'MACH-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['machinery_id' => $uniqueId]);
        });
    }
}
