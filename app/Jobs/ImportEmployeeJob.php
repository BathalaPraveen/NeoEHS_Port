<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Validator;

use DB;
use Str;
use Mail;

use Shuchkin\SimpleXLSX;

use App\Models\Master\Nationality;
use App\Models\Master\Designation;
use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;
use App\Models\Master\UserRole;
use App\Models\Master\Employee;
use App\Models\Master\EmployeeCategory;

use App\Models\User;
use App\Models\UploadLog;
use App\Models\UploadLogError;


use App\Mail\EmployeeRegisterEmail;


class ImportEmployeeJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $i = 1;
        $error_data = [];

        $error_data = [];
        $update_array = array(
            'upload_status' => 1,
        );

        UploadLog::where('id', $this->details['log_id'])
            ->update($update_array);


        $xlsx = SimpleXLSX::parse($this->details['path']);

        foreach ($xlsx->rows() as $row) {

            $company_name = trim($row['0']);
            $employee_id = trim($row['1']);
            $name = trim($row['2']);
            $gender = trim($row['3']);
            $nationality = trim($row['4']);
            $id_no = trim($row['5']);
            $designation = trim($row['6']);
            $department = trim($row['7']);
            $division = trim($row['8']);
            $email = trim($row['9']);
            $phone = trim($row['10']);
            $joining_date = trim($row['11']);
            $location = trim($row['12']);
            $specificlocation = trim($row['13']);
            $role = trim($row['14']);
            $employeecategory = trim($row['15']);

            /*
             * Header column validation
             */
            if ($i == 1) {

                if (count($row) >= 16) {

                    if (
                        $company_name != 'Company Name' ||
                        $employee_id != 'Employee ID' ||
                        $name != 'Name' ||
                        $gender != 'Gender' ||
                        $nationality != 'Nationality' ||
                        $id_no != 'IC No. or Passport No.' ||
                        $designation != 'Designation' ||
                        $department != 'Department' ||
                        $division != 'Division' ||
                        $email != 'Email ID' ||
                        $phone != 'Phone Number' ||
                        $joining_date != 'Joining Date' ||
                        $location != 'Location' ||
                        $specificlocation != 'Specific Location' ||
                        $role != 'User Role'  ||
                        $employeecategory != 'Employee Category'

                    ) {

                        $error_data_1 = array(
                            'upload_id' => $this->details['log_id'],
                            'line_no' =>  $i,
                            'error' => 'Header Column Not Match',
                        );

                        UploadLogError::insert($error_data_1);
                        $i++;
                        break;
                    }
                    $i++;

                    continue;
                } else {
                    $error_data_1 = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Header Column Not Match',
                    );

                    UploadLogError::insert($error_data_1);
                    $i++;
                    break;
                }
            }


            $employee_id = str_replace( ' ', '', trim($row['1']) );
            $phone = str_replace( ' ', '', trim($row['10']) );


            /* Column data validation */

            $cond_error_data = [];


            if ($company_name == '') {

                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Company name is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $companyExist = Company::where('company_name', $company_name)->get();
                try {

                    if (count($companyExist) <= 0) {
                        $cond_error_data = array(
                            'upload_id' => $this->details['log_id'],
                            'line_no' => $i,
                            'error' => 'Invalid Company name',
                        );
                        UploadLogError::insert($cond_error_data);
                        $i++;
                        continue;
                    }
                    $companyId = $companyExist['0']->id;
                } catch (\Exception $ex) {

                }
            }

            if ($employee_id == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee ID is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $empidExist = Employee::where('emp_id', $employee_id)->count();

                if ($empidExist > 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Employee ID already exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }
            }

            if ($name == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee Name missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            }

            if ($gender == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee Gender is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                switch ($gender) {
                    case 'M':
                        $genderId = 1;
                        break;
                    case 'F':
                        $genderId = 2;
                        break;
                    default:
                        $genderId = 0;
                        break;
                }

                if ($genderId == 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Invalid Gender name',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }
            }

            if ($nationality == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee Nationality is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $nationalityExist = Nationality::where('nationality', $nationality)->get();

                if (count($nationalityExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Nationality not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $nationalityId = $nationalityExist['0']->id;
            }

            if ($id_no == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee ID NO is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            }

            if ($designation == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Employee Designation is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $designationExist = Designation::where('designation_name', $designation)->get();

                if (count($designationExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Designation not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }
                $designationId = $designationExist['0']->id;
            }


            if ($division == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Division is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $divisionExist = Division::where('division_name', $division)
                    ->where('company_id', $companyId)
                    ->get();

                if (count($divisionExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Division not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $divisionId = $divisionExist['0']->id;
            }

            if ($department == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Department is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {
                $departmentExist = Department::where('department_name', $department)
                    ->where('company_id', $companyId)
                    ->where('division_id', $divisionId)
                    ->get();

                if (count($departmentExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Department not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $departmentId = $departmentExist['0']->id;
            }


            if ($email == '') {
                // $cond_error_data = array(
                //     'upload_id' => $this->details['log_id'],
                //     'line_no' => $i,
                //     'error' => 'Employee Email is missing',
                // );
                // UploadLogError::insert($cond_error_data);
                // $i++;
                // continue;
            } else {

                $data['email'] = $email;

                $validator = Validator::make($data, [
                    'email' => ['required', 'emailid'],
                ]);

                if ($validator->fails()) {

                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Invalid Email ID',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }
            }

            $locationId = $specificLocationId = $roleId = $category =null;


            if ($location != '') {

                $locationExist = Location::where('location_name', $location)
                    ->get();

                if (count($locationExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Location not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $locationId = $locationExist['0']->id;
            }

            if ($specificlocation != '') {

                $specificlocationExist = SpecificLocation::where('specific_loc_name', $specificlocation)
                    ->get();

                if (count($specificlocationExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Specific Location not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $specificLocationId = $specificlocationExist['0']->id;
            }

            if ($role != '') {

                // $roleExist = UserRole::where('role_name', $role)
                //     ->get();

                // if (count($roleExist) <= 0) {
                //     $cond_error_data = array(
                //         'upload_id' => $this->details['log_id'],
                //         'line_no' => $i,
                //         'error' => 'Role not exist',
                //     );
                //     UploadLogError::insert($cond_error_data);
                //     $i++;
                //     continue;
                // }

                //$roleId = $roleExist['0']->id;
                $roleId = $role ;
            }

            if ($employeecategory != '') {

                $categoryExist = EmployeeCategory::where('category_name', $employeecategory)->get();

                if (count($categoryExist) <= 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Employee Category not exist',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }

                $category = $categoryExist['0']->id;
            }

            if($roleId == null || $roleId == ''){
                $roleId = ROLE_NORMAL_USER;
            }
            $employee_id = removeSpace($employee_id);

            $id_no = removeSpace($id_no);

            $data = array(
                'name' => $name,
                'first_name' => $name,
                'last_name' => '',
                'email' => $email,
                'role' => $roleId,
                'user_type' => 1,
                'emp_id' => $employee_id,
                'username' => $employee_id,
                'password' => Hash::make($employee_id."@12345"),
                'company' => $companyId,
                'division' => $divisionId,
                'department' => $departmentId,
                'designation' => $designationId,
                'mobile' => $phone,
                'created_by' => $this->details['user_id']
            );

            $userDetails = User::create($data);

            $loginId = $userDetails->id;

            $insert_array = array(
                'login_id' => $loginId,
                'emp_id' => $employee_id,
                'emp_name' => $name,
                'emp_gender' => $genderId,
                'emp_nationality' => $nationalityId,
                'emp_nationality_other' => '',
                'emp_designation_id' => $designationId,
                'emp_company_id' => $companyId,
                'emp_division_id' => $divisionId,
                'emp_department_id' => $departmentId,
                'emp_ic_or_passport_no' => $id_no,
                'emp_email_id' => $email,
                'emp_phone_no' => $phone,
                'emp_joining_date' => DBdateformat($joining_date),
                'emp_role_id' => $roleId,
                'emp_location_id' => $locationId,
                'emp_specfic_location' => $specificLocationId,
                'emp_category' => $category,
                'created_by' => $this->details['user_id']
            );

            $employeeDetails =  Employee::create($insert_array);

            if ($employeeDetails->emp_email_id != '' || $employeeDetails->emp_email_id != null) {

                $empdetails =  Employee::find($employeeDetails->id);

                $emp  = $empdetails->toArray();

                // Mail::to($employeeDetails->emp_email_id)->queue(new EmployeeRegisterEmail($emp));
            }

            $i++;
        }

        $final_update_array = array(
            'upload_status' => 2,
        );

        UploadLog::where('id', $this->details['log_id'])->update($final_update_array);
    }
}
