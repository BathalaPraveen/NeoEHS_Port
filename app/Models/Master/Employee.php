<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\Location;
use App\Scopes\TrashScope;

class Employee extends Model
{
    use  HasFactory;


    protected $table = 'master_employee';
    protected $primaryKey = 'id';

    protected $fillable = [
        'login_id',
        'emp_id',
        'emp_role_id',
        'emp_name',
        'emp_gender',
        'emp_ic_or_passport_no',
        'emp_nationality',
        'emp_nationality_other',
        'emp_designation_id',
        'emp_location_id',
        'emp_joining_date',
        'emp_specfic_location',
        'emp_company_id',
        'emp_division_id',
        'emp_department_id',
        'emp_email_id',
        'emp_phone_no',
        'emp_login_status',
        'cert_status',
        'job_owner_department',
        'emp_category',
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

        $query = $this->select('master_employee.*', 'master_company.company_name', 'master_company_department.department_name', 'master_designation.designation_name')
            ->leftJoin('master_company', 'master_employee.emp_company_id', '=', 'master_company.id')
            ->leftJoin('master_company_department', 'master_employee.emp_department_id', '=', 'master_company_department.id')
            ->leftJoin('master_designation', 'master_employee.emp_designation_id', '=', 'master_designation.id');

        if ($request->companyid != '' && $request->companyid != null) {
            $conpanyId = decryptId($request->companyid);
            $query->where('master_employee.emp_company_id', $conpanyId);
        }

        if ($request->divisionid != '' && $request->divisionid != null) {
            $divisionid = decryptId($request->divisionid);
            $query->where('master_employee.emp_division_id', $divisionid);
        }

        if ($request->departmentid != '' && $request->departmentid != null) {
            $departmentid = decryptId($request->departmentid);
            $query->where('master_employee.emp_department_id', $departmentid);
        }

        if ($request->roleid != '' && $request->roleid != null) {
            $roleid = decryptId($request->roleid);
            $query->whereRaw('FIND_IN_SET(?, master_employee.emp_role_id)', [$roleid]);
        }




        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_department.department_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_designation.designation_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('emp_name', 'LIKE', '%' . $search . '%');
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

    public function UniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])->get();
    }

    public function ExistuniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])
            ->where('id', '!=', decryptId($data['id']))
            ->get();
    }

    public function store($id)
    {

        $request = request();

        $insert_array = array(
            'login_id' => $id,
            'emp_id' => $request->emp_id,
            'emp_name' => $request->emp_name,
            'emp_gender' => decryptId($request->emp_gender),
            'emp_nationality' => decryptId($request->emp_nationality),
            'emp_nationality_other' => decryptId($request->emp_nationality_other),
            'emp_designation_id' => decryptId($request->emp_designation_id),
            'emp_company_id' => decryptId($request->emp_company_id),
            'emp_division_id' => decryptId($request->emp_division_id),
            'emp_department_id' => decryptId($request->emp_department_id),
            'emp_ic_or_passport_no' => $request->emp_ic_or_passport_no,
            'emp_email_id' => $request->emp_email_id,
            'emp_phone_no' => $request->emp_phone_no,
            'emp_joining_date' => DBdateformat($request->emp_joining_date),
            'emp_role_id' =>  array_to_string(arrayDecrypt($request->emp_role_id)),
            'emp_location_id' => decryptId($request->emp_location_id),
            'emp_specfic_location' => decryptId($request->emp_specfic_location),
            'emp_category' => decryptId($request->emp_category),
            'job_owner_department' => array_to_string(arrayDecrypt($request->emp_jobowner_department_id)),
            'created_by' => Auth::id()
        );

        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $update_array = array(
            'emp_name' => $request->emp_name,
            'emp_gender' => decryptId($request->emp_gender),
            'emp_nationality' => decryptId($request->emp_nationality),
            'emp_nationality_other' => $request->emp_nationality_other,
            'emp_designation_id' => decryptId($request->emp_designation_id),
            'emp_company_id' => decryptId($request->emp_company_id),
            'emp_division_id' => decryptId($request->emp_division_id),
            'emp_department_id' => decryptId($request->emp_department_id),
            'emp_ic_or_passport_no' => $request->emp_ic_or_passport_no,
            'emp_email_id' => $request->emp_email_id,
            'emp_phone_no' => $request->emp_phone_no,
            'emp_joining_date' => DBdateformat($request->emp_joining_date),
            'emp_role_id' => array_to_string(arrayDecrypt($request->emp_role_id)),
            'emp_location_id' => decryptId($request->emp_location_id),
            'emp_specfic_location' => decryptId($request->emp_specfic_location),
            'emp_category' => decryptId($request->emp_category),
            'job_owner_department' => array_to_string(arrayDecrypt($request->emp_jobowner_department_id)),
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
            'master_employee.*',
            'master_company.company_name',
            'master_company_division.division_name',
            'master_company_department.department_name',
            'master_designation.designation_name',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'master_nationality.nationality',
            'master_user_role.role_name',
            'master_employee_category.category_name',
            )
            ->leftJoin('master_company', 'master_employee.emp_company_id', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'master_employee.emp_division_id', '=', 'master_company_division.id')
            ->leftJoin('master_company_department', 'master_employee.emp_department_id', '=', 'master_company_department.id')
            ->leftJoin('master_designation', 'master_employee.emp_designation_id', '=', 'master_designation.id')
            ->leftJoin('master_nationality', 'master_employee.emp_nationality', '=', 'master_nationality.id')
            ->leftJoin('master_location', 'master_employee.emp_location_id', '=', 'master_location.id')
            ->leftJoin('master_location_specific', 'master_employee.emp_specfic_location', '=', 'master_location_specific.id')
            ->leftJoin('master_user_role', 'master_employee.emp_role_id', '=', 'master_user_role.id')
            ->leftJoin('master_employee_category', 'master_employee.emp_category', '=', 'master_employee_category.id');

        if ($request->companyid != '' && $request->companyid != null) {
            $conpanyId = decryptId($request->companyid);
            $query->where('master_employee.emp_company_id', $conpanyId);
        }

        if ($request->divisionid != '' && $request->divisionid != null) {
            $divisionid = decryptId($request->divisionid);
            $query->where('master_employee.emp_division_id', $divisionid);
        }

        if ($request->departmentid != '' && $request->departmentid != null) {
            $departmentid = decryptId($request->departmentid);
            $query->where('master_employee.emp_department_id', $departmentid);
        }

        if ($request->roleid != '' && $request->roleid != null) {
            $roleid = decryptId($request->roleid);
            $query->whereRaw('FIND_IN_SET(?, master_employee.emp_role_id)', [$roleid]);
        }

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_division.division_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_division.division_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_division.division_shortname', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company_department.department_name', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select(
            'master_employee.*',
            'master_company.company_name',
            'master_company_division.division_name',
            'master_company_department.department_name',
            'master_designation.designation_name',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'master_nationality.nationality',
            'master_user_role.role_name',
            'master_employee_category.category_name',

        )
            ->leftJoin('master_company', 'master_employee.emp_company_id', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'master_employee.emp_division_id', '=', 'master_company_division.id')
            ->leftJoin('master_company_department', 'master_employee.emp_department_id', '=', 'master_company_department.id')
            ->leftJoin('master_designation', 'master_employee.emp_designation_id', '=', 'master_designation.id')
            ->leftJoin('master_nationality', 'master_employee.emp_nationality', '=', 'master_nationality.id')
            ->leftJoin('master_location', 'master_employee.emp_location_id', '=', 'master_location.id')
            ->leftJoin('master_location_specific', 'master_employee.emp_specfic_location', '=', 'master_location_specific.id')
            ->leftJoin('master_user_role', 'master_employee.emp_role_id', '=', 'master_user_role.id')
            ->leftJoin('master_employee_category', 'master_employee.emp_category', '=', 'master_employee_category.id')
            ->where('master_employee.id', $id)
            ->first();

        return $data;
    }

    public function ajaxListJobOwner($departmentid)
    {

        $query = $this->select('login_id', 'emp_name');

        $query = $query->whereRaw('FIND_IN_SET(?, job_owner_department)', [$departmentid]);
        $query = $query->whereRaw('FIND_IN_SET(?, emp_role_id)', [ROLE_JOBOWNER]);

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->login_id);
            $listvalue['name'] = $data->emp_name;

            $list[] = $listvalue;
        }

        return $list;
    }

    public function ajaxList($where, $whereIn = [])
    {

        $query = $this->select('login_id', 'emp_name');

        if (count($where) > 0) {
            $query = $query->where($where);
        }

        if (count($whereIn) > 0) {
            $query = $query->whereRaw('FIND_IN_SET(?, emp_role_id)', [$whereIn]);
        }


        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->login_id);
            $listvalue['name'] = $data->emp_name;

            $list[] = $listvalue;
        }

        return $list;
    }

    public function getEmpDetails($id){
        $data = $this->where('id',$id)->first();
        return $data;
    }

    public function changeDetails($id){
        $request = request();

        $update_array = array(
            'emp_id' => $request->employee_id,
            'emp_company_id' => decryptId($request->emp_company_id),
            'emp_division_id' => decryptId($request->emp_division_id),
            'emp_department_id' => decryptId($request->emp_department_id),
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function ajaxEmployeeList($departmentid = '')
    {

        $query = $this->select('id', 'emp_name','emp_id');

        if ($departmentid != '') {
            $query = $query->where('emp_department_id', $departmentid);
        }

        $datas = $query->get();

        $list = [];
        foreach ($datas as $data) {
            $listvalue = [];
            $listvalue['id'] = encryptId($data->id);
            $listvalue['name'] = $data->emp_name;
            $listvalue['emp_id'] = $data->emp_id;

            $list[] = $listvalue;
        }

        return $list;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('master_employee'));
    }
}
