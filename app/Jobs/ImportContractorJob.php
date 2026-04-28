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


use App\Models\Master\Designation;
use App\Models\Master\ContractorCompany;
use App\Models\Master\Contractor;

use App\Models\User;
use App\Models\UploadLog;
use App\Models\UploadLogError;


use App\Mail\EmployeeRegisterEmail;


class ImportContractorJob implements ShouldQueue
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


            $empName = trim($row['0']);
            $idType = trim($row['1']);
            $idNumber = trim($row['2']);
            $designation = trim($row['3']);
            $company = trim($row['4']);
            $email = trim($row['5']);
            $phone = trim($row['6']);

            /*
             * Header column validation
             */
            if ($i == 1) {

                if (count($row) >= 7) {

                    if (
                        $empName != 'Contractor Employee Name' ||
                        $idType != 'ID Type' ||
                        $idNumber != 'MyCard Number or Passport Number' ||
                        $designation != 'DESIGNATION' ||
                        $company != 'COMPANY' ||
                        $email != 'Email Address' ||
                        $phone != 'Phone Number'

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


            /* Column data validation */

            $cond_error_data = [];

            if ($idType == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'ID type is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                switch ($idType) {
                    case 'PASSPORT':
                        $IDTypeID = 1;
                        break;
                    case 'MYCARD':
                        $IDTypeID = 2;
                        break;
                    default:
                        $IDTypeID = 0;
                        break;
                }

                if ($IDTypeID == 0) {
                    $cond_error_data = array(
                        'upload_id' => $this->details['log_id'],
                        'line_no' => $i,
                        'error' => 'Invalid ID type',
                    );
                    UploadLogError::insert($cond_error_data);
                    $i++;
                    continue;
                }
            }

            if ($idNumber == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'MyCard Number or Passport Number is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            }


            if ($empName == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Contractor Name missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            }

            if ($email == '') {
                // $cond_error_data = array(
                //     'upload_id' => $this->details['log_id'],
                //     'line_no' => $i,
                //     'error' => 'Contractor Email id missing',
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

            if ($phone == '') {
                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Contractor Phone number missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            }

            if ($designation == '') {
                // $cond_error_data = array(
                //     'upload_id' => $this->details['log_id'],
                //     'line_no' => $i,
                //     'error' => 'Contractor Designation is missing',
                // );
                // UploadLogError::insert($cond_error_data);
                // $i++;
                // continue;
            }

            $roleId = '0';

            if ($company == '') {

                $cond_error_data = array(
                    'upload_id' => $this->details['log_id'],
                    'line_no' => $i,
                    'error' => 'Contractor Company name is missing',
                );
                UploadLogError::insert($cond_error_data);
                $i++;
                continue;
            } else {

                $companyExist = ContractorCompany::where('con_comp_name', $company)->get();


                if (count($companyExist) <= 0) {

                    $createArray = array(
                        'con_comp_name' => $company,
                        'con_email' => $email,
                        'con_phone' => $phone,
                        'created_by' => $this->details['user_id'],
                    );

                    $concompany =  ContractorCompany::create($createArray);
                    $companyId = $concompany->id;

                    $roleId = ROLE_CONTRACTORADMIN;

                }else{

                    $roleId = ROLE_CONTRACTORUSER;
                    $companyId = $companyExist['0']->id;

                }
            }

            $insert_array = array(
                'login_id' => 0,
                'cont_name' => $empName,
                'cont_company_id' => $companyId,
                'cont_email' => $email,
                'cont_phone' => $phone,
                'cont_designation' => $designation,
                'cont_id_type' => $IDTypeID,
                'cont_id_number' => $idNumber,
                'con_login_status' => 'P',
                'created_by' => $this->details['user_id']
            );

            $contractorDetails =  Contractor::create($insert_array);

            $data = array(
                'name' => $empName,
                'first_name' => $empName,
                'last_name' => '',
                'email' => $email,
                'role' => $roleId,
                'user_type' => 2,
                'emp_id' => 0,
                'username' => $contractorDetails->cont_id ,
                'password' => Hash::make($contractorDetails->cont_id."@12345"),
                'department' => 0,
                'designation' => 0,
                'created_by' => $this->details['user_id']
            );

            $userDetails = User::create($data);

            $loginId = $userDetails->id;

            $contractorDetails->login_id =  $loginId ;
            $contractorDetails->update();

            if ($contractorDetails->cont_email != '' || $contractorDetails->cont_email != null) {

                $condetails =  Contractor::find($contractorDetails->id);

                $con  = $condetails->toArray();

                // Mail::to($employeeDetails->cont_email)->queue(new ContractorRegisterEmail($con));
            }

            $i++;
        }

        $final_update_array = array(
            'upload_status' => 2,
        );

        UploadLog::where('id', $this->details['log_id'])->update($final_update_array);
    }
}
