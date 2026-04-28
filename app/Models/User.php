<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

use App\Scopes\TrashScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Master\UserRole;
use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;
use App\Models\Master\Designation;
use App\Models\Master\Contractor;


use App\Models\ATAR\USeeUActFileStatusLog;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'role',
        'user_type',
        'emp_id',
        'username',
        'password',
        'company',
        'division',
        'department',
        'designation',
        'mobile',
        'otp',
        'otp_token',
        'permission_array',
        'permission',
        'profile_image',
        'status',
        'trash',
        'remember_token',
        'job_owner_department',
        'created_by',
        'updated_by',
        'created_at',
        'created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     *  Relationship
     */

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class);
    }

    // Relationship with Role
    public function roleInfo()
    {
        return $this->belongsTo(UserRole::class, 'role');
    }

    // Relationship with Company
    public function companyInfo()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    // Relationship with Division
    public function divisionInfo()
    {
        return $this->belongsTo(Division::class, 'division');
    }

    // Relationship with Department
    public function departmentInfo()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    // Relationship with Designation
    public function designationInfo()
    {
        return $this->belongsTo(Designation::class, 'designation', 'id');
    }


    /** User Add */
    protected function Find_Single_User($find_data)
    {
        return $this->where($find_data)->first();
    }

    /** List User*/
    protected function UserList()
    {
        return $this->where('trash', 'NO')->get();
    }

    /**Insert User*/
    protected function InsertUser($data)
    {
        return $this->create($data);
    }

    /**View User */
    protected function GetUser($id)
    {
        return $this->where('id', $id)->first();
    }

    /**Update User */
    protected function UpdateUser($id, $update_data)
    {
        return $this->where('id', $id)->update($update_data);
    }

    protected function UniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])->get();
    }

    protected function ExistuniqueCheck($data)
    {
        return $this->where($data['param'],  $data['value'])
            ->where('id', '!=', decryptId($data['id']))
            ->get();
    }


    // Relationship for normal users
    public function userdesignation()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }

    // Relationship for contractor users
    public function contractorDesignation()
    {
        return $this->hasOne(Contractor::class, 'login_id', 'id');
    }

    // Get the designation name
    public function getUserDesignationNameAttribute()
    {
        if ($this->designation == 0) {

            // Return the contractor designation name
            return $this->contractorDesignation ? $this->contractorDesignation->cont_designation : null;
        } else {
            // Return the normal user designation name
            return $this->userdesignation ? $this->userdesignation->designation_name : null;
        }
    }

    protected function store()
    {

        $request = request();
        $data = array(
            'name' => $request->emp_name,
            'first_name' => $request->emp_name,
            'last_name' => '',
            'email' => $request->emp_email_id,
            'role' => array_to_string(arrayDecrypt($request->emp_role_id)),
            'user_type' => 1,
            'emp_id' => $request->emp_id,
            'username' => $request->emp_id,
            'password' => Hash::make($request->emp_id . "@12345"),
            'company' => decryptId($request->emp_company_id),
            'division' => decryptId($request->emp_division_id),
            'department' => decryptId($request->emp_department_id),
            'job_owner_department' => array_to_string(arrayDecrypt($request->emp_jobowner_department_id)),
            'designation' => decryptId($request->emp_designation_id),
            'mobile' => $request->emp_phone_no,
            'created_by' => Auth::id()
        );
        return $this->create($data);
    }

    protected function userUpdate($id)
    {

        $request = request();

        $data = array(
            'name' => $request->emp_name,
            'first_name' => $request->emp_name,
            'last_name' => '',
            'email' => $request->emp_email_id,
            'role' => array_to_string(arrayDecrypt($request->emp_role_id)),
            'emp_id' => $request->emp_id,
            'company' => decryptId($request->emp_company_id),
            'division' => decryptId($request->emp_division_id),
            'department' => decryptId($request->emp_department_id),
            'designation' => decryptId($request->emp_designation_id),
            'job_owner_department' => array_to_string(arrayDecrypt($request->emp_jobowner_department_id)),
            'mobile' => $request->emp_phone_no,
            'updated_by' => Auth::id()
        );
        return $this->where('id', $id)->update($data);
    }

    protected function passwordUpdate($id)
    {

        $request = request();

        $data = array(
            'password' => Hash::make($request->password),
            'updated_by' => Auth::id()
        );
        return $this->where('id', $id)->update($data);
    }

    protected function constore()
    {

        $request = request();
        $data = array(
            'name' => $request->con_name,
            'first_name' => $request->con_name,
            'last_name' => '',
            'email' => $request->con_email_id,
            'role' => decryptId($request->con_role),
            'user_type' => 2,
            'emp_id' => $request->con_id,
            'username' => $request->con_id,
            'password' => Hash::make($request->con_id . "@12345"),
            'department' => null,
            'designation' => null,
            'mobile' => $request->con_phone_no,
            'created_by' => Auth::id()
        );
        return $this->create($data);
    }

    protected function conReg()
    {
        $request = request();

        $con_id = getsequence('contractor');

        $data = array(
            'name' => $request->pic_name,
            'first_name' => $request->pic_name,
            'last_name' => '',
            'email' => $request->pic_email,
            'role' => 1,
            'user_type' => 2,
            'emp_id' => $con_id,
            'username' => $con_id,
            'password' => Hash::make($con_id . "@12345"),
            'department' => null,
            'designation' => null,
            'mobile' => $request->con_phone_no,
            'status' => 0,
            'created_by' => 1
        );
        return $this->create($data);
    }

    public function enableEmployee($id)
    {

        $update_data = array(
            'status' => 1,
        );

        return $this->where('id', $id)->update($update_data);
    }

    protected function conupdate($id)
    {

        $request = request();
        $data = array(
            'name' => $request->con_name,
            'first_name' => $request->con_name,
            'email' => $request->con_email_id,
            'mobile' => $request->con_phone_no,
            'updated_by' => Auth::id()
        );
        return $this->where('id', $id)->update($data);
    }


    protected function msdusers()
    {
        return $this->where('division', MSD_DIVISION)->orderBy('name', 'ASC')->get();
    }

    protected function tsdusers()
    {
        return $this->where('division', TSD_DIVISION)->orderBy('name', 'ASC')->get();
    }

    protected function caretakerusers()
    {
        return $this->whereRaw('FIND_IN_SET(?, role)', [ROLE_CARE_TAKER])->orderBy('name', 'ASC')->get();
    }

    protected function craneoperatorusers()
    {
        return $this->whereRaw('FIND_IN_SET(?, role)', [ROLE_CRANE_OPERATOR])->orderBy('name', 'ASC')->get();
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

    public function changeDetails($id)
    {
        $request = request();

        $update_array = array(

            'username' => $request->employee_id,
            'emp_id' => $request->employee_id,
            'company' => decryptId($request->emp_company_id),
            'division' => decryptId($request->emp_division_id),
            'department' => decryptId($request->emp_department_id),
            'password' => Hash::make($request->employee_id . "@12345"),
            'updated_by' => Auth::id()
        );

        return $this->where('id', $id)->update($update_array);
    }

    public function getAllDataBasedRole($status)
    {
        $data = $this->whereRaw("FIND_IN_SET(?, role)", [$status])
            ->where('status', '1')
            ->get();
        return $data;
    }

    public function ajaxList($user_roles)
    {

        $list = [];
        if (isset($user_roles)) {
            foreach (string_to_array($user_roles) as $user_role) {

                $datas = User::select('id', 'name')
                    ->where('id', $user_role)
                    ->where('status', 1)
                    ->get();


                foreach ($datas as $data) {
                    $listvalue = [];
                    $listvalue['id'] = encryptId($data->id);
                    $listvalue['name'] = $data->name;

                    $list[] = $listvalue;
                }
            }
        }
        return $list;
    }

    public function getAlluser()
    {
        $data = $this->where('status', 1)->get();
        return $data;
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('users'));
    }
}
