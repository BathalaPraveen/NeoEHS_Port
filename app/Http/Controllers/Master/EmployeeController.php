<?php

namespace App\Http\Controllers\Master;

use PDF;
use Str;
use Exception;
use DataTables;
use Response;

use App\Models\Master\EmployeeCategory;

use App\Models\User;
use App\Models\UploadLog;
use Illuminate\Http\Request;
use App\Models\Master\Company;
use App\Jobs\ImportEmployeeJob;
use App\Models\Master\Division;
use App\Models\Master\Employee;
use App\Models\Master\Location;

use App\Models\Master\UserRole;
use App\Models\Master\Department;
use App\Models\Master\Designation;
use App\Models\Master\Nationality;
use App\Mail\EmployeeRegisterEmail;
use App\Http\Controllers\Controller;
use App\Mail\EmployeeDetailsChangeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\Master\SpecificLocation;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Models\Master\EmployeeDetailsChangeLog;
use Illuminate\Support\Facades\Session as FacadesSession;

class EmployeeController extends Controller
{

    private $nationality;
    private $designation;
    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;
    private $userRole;
    private $employee;
    private $uploadlog;
    private $user;
    private $cateogry;
    private $empChangeLog;


    public function __construct()
    {

        $this->nationality = new Nationality();
        $this->designation = new Designation();
        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();
        $this->user = new User();
        $this->userRole = new UserRole();
        $this->employee = new Employee();
        $this->uploadlog = new UploadLog();
        $this->cateogry = new EmployeeCategory();
        $this->empChangeLog = new EmployeeDetailsChangeLog();
    }


    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->employee->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('status', function ($row) {
                            $text = "<span style='color:red'>In-Active<span>";
                            if ($row->status == 1) {
                                $text = "<span style='color:green;cursor:pointer' class= 'StatusChange' data-id='" . encryptId($row->id) . "' data-type = '1' >Active<span>";
                            } else if ($row->status == 0) {
                                $text = "<span style='color:red;cursor:pointer' class= 'StatusChange' data-id='" . encryptId($row->id) . "' data-type = '0' >In-Active<span>";
                            }
                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn = '<a href="' . admin_url('employee/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('employee/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            if (CheckUserRole(ROLE_ADMIN)) {
                                $btn .= '<a href="' . admin_url('employee/passwordchange/' . encryptId($row->id)) . '" class=" " title="Change Password"><i class="fa-solid fa-key" style="color:#43a047;"></i></a> ';
                            }
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $companylist = $this->company->get();
        $rolelist =  $this->userRole->get();


        $data = array(
            'company_list' => $companylist,
            'role_list' => $rolelist
        );

        return view('master.employee.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $nationalitylist = $this->nationality->get();
            $designationlist = $this->designation->get();
            $companylist = $this->company->getAllCompany();
            $locationlist = $this->location->getAllLocation();
            $rolelist = $this->userRole->get();
            $categoryList = $this->cateogry->get();

            $jobownerdepartment = $this->department->getjobowner();

            $data = array(
                'nationalitylist' => $nationalitylist,
                'designationlist' => $designationlist,
                'companylist' => $companylist,
                'locationlist' => $locationlist,
                'rolelist' => $rolelist,
                'categoryList' => $categoryList,
                'jobownerdepartment' => $jobownerdepartment,
            );
            return view('master.employee.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'emp_id' => 'required',
                'emp_name' => 'required',
                'emp_gender' => 'required',
                'emp_nationality' => 'required',
                'emp_ic_or_passport_no' => 'required',
                'emp_designation_id' => 'required',
                'emp_company_id' => 'required',
                'emp_division_id' => 'required',
                'emp_department_id' => 'required',
                'emp_joining_date' => 'required',
                'emp_role_id' => 'required',
            ];
            $messages = [
                'emp_id.required' => 'Please enter Division ID',
                'emp_name.required' => 'Please enter Division Name',
                'emp_gender.required' => 'Please enter Division  Name',
                'emp_nationality.required' => 'Please enter Division  Description',
                'emp_ic_or_passport_no.required' => 'Please enter Division  Description',
                'emp_designation_id.required' => 'Please enter Division  Description',
                'emp_company_id.required' => 'Please enter Division  Description',
                'emp_division_id.required' => 'Please enter Division  Description',
                'emp_department_id.required' => 'Please enter Division  Description',
                'emp_joining_date.required' => 'Please enter Division  Description',
                'emp_role_id.required' => 'Please enter Division  Description',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                dd($validator);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $userDetails = User::store();

                $id = $userDetails->id;

                $employeeDetails = $this->employee->store($id);

                if ($employeeDetails->emp_email_id != '' || $employeeDetails->emp_email_id != null) {

                    $empdetails =  $this->employee->selectOne($employeeDetails->id);

                    $emp  = $empdetails->toArray();

                    Mail::to($employeeDetails->emp_email_id)->queue(new EmployeeRegisterEmail($emp));
                }

                Session::flash('success', 'Employee  added successfully!');
            } catch (Exception $ex) {
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('employee/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('employee/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {

                $employee = $this->employee->selectOne($id);

                $jobownerid = string_to_array($employee->job_owner_department);

                if ($jobownerid != '' &&  $jobownerid != null) {

                    $jobownerdeparmentname = getMultipleValue('master_company_department', $employee->job_owner_department, 'id', 'department_name');;
                } else {
                    $jobownerdeparmentname = '';
                }

                $data = array(
                    'employee' => $employee,
                    'jobownerdeparmentname' => $jobownerdeparmentname,
                );
            }
            return view('master.employee.view', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $nationalitylist = $this->nationality->get();
            $designationlist = $this->designation->get();
            $companylist = $this->company->getAllCompany();
            $locationlist = $this->location->getAllLocation();
            $rolelist = $this->userRole->get();
            $categoryList = $this->cateogry->get();
            $jobownerdepartment = $this->department->getjobowner();

            $employee = $this->employee->find($id);

            $whereget = array(
                'company_id' => $employee->emp_company_id
            );
            $diviaionList = $this->division->whereget($whereget);

            $whereget = array(
                'division_id' => $employee->emp_division_id
            );
            $departmentList = $this->department->whereget($whereget);

            $whereget = array(
                'location_id' => $employee->emp_location_id
            );
            $specificlocationList = $this->specificlocation->whereget($whereget);


            $data = array(
                'nationalitylist' => $nationalitylist,
                'designationlist' => $designationlist,
                'companylist' => $companylist,
                'locationlist' => $locationlist,
                'rolelist' => $rolelist,
                'employee' => $employee,
                'diviaionList' => $diviaionList,
                'departmentList' => $departmentList,
                'specificlocationList' => $specificlocationList,
                'categoryList' => $categoryList,
                'jobownerdepartment' => $jobownerdepartment,
            );


            return view('master.employee.edit', $data);
        } catch (Exception $error) {

            report($error);
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'emp_id' => 'required',
                'emp_name' => 'required',
                'emp_gender' => 'required',
                'emp_nationality' => 'required',
                'emp_ic_or_passport_no' => 'required',
                'emp_designation_id' => 'required',
                'emp_company_id' => 'required',
                'emp_division_id' => 'required',
                'emp_department_id' => 'required',
                'emp_joining_date' => 'required',
                'emp_role_id' => 'required',
            ];
            $messages = [
                'emp_id.required' => 'Please enter Division ID',
                'emp_name.required' => 'Please enter Division Name',
                'emp_gender.required' => 'Please enter Division  Name',
                'emp_nationality.required' => 'Please enter Division  Description',
                'emp_ic_or_passport_no.required' => 'Please enter Division  Description',
                'emp_designation_id.required' => 'Please enter Division  Description',
                'emp_company_id.required' => 'Please enter Division  Description',
                'emp_division_id.required' => 'Please enter Division  Description',
                'emp_department_id.required' => 'Please enter Division  Description',
                'emp_joining_date.required' => 'Please enter Division  Description',
                'emp_role_id.required' => 'Please enter Division  Description',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->employee->updates($id);

            $empdetails = $this->employee->find($id);


            User::userUpdate($empdetails->login_id);

            Session::flash('success', 'Employee updated successfully!');
            return redirect(admin_url('employee/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('employee/list'));
        }
    }

    public function PasswordUpdate(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $employee = $this->employee->find($id);

            $data = array(
                'employee' => $employee,
            );

            return view('master.employee.passwordupdate', $data);
        } catch (Exception $error) {

            report($error);
        }
    }

    public function PasswordUpdateSubmit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'emp_id' => 'required',
                'emp_name' => 'required',
                'password' => 'required',
                'conpassword' => 'required',
            ];
            $messages = [
                'emp_id.required' => 'Please enter Division ID',
                'emp_name.required' => 'Please enter Division Name',
                'password.required' => 'Please enter the Password',
                'conpassword.required' => 'Please enter the Confirm Password',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $empdetails = $this->employee->find($id);

            User::passwordUpdate($empdetails->login_id);

            Session::flash('success', 'Employee password updated successfully!');
            return redirect(admin_url('employee/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('employee/list'));
        }
    }

    public function Uniquecheck(Request $request)
    {
        if ($request->ajax()) {

            $type = $request->type;
            $value = $request->value;

            switch ($type) {
                case 'emp_id':
                    $param = 'emp_id';
                    break;
                case 'employee_id':
                    $param = 'emp_id';
                    break;
            }

            $id = $request->id;

            if ($id == '') {
                $data = array(
                    'param' => $param,
                    'value' => $value,
                );
                $user = $this->employee->UniqueCheck($data);
            } else {
                $data = array(
                    'param' => $param,
                    'value' => $value,
                    'id' => $id,
                );
                $user = $this->employee->ExistuniqueCheck($data);
            }
            if ($user->count()) {
                return Response::json(array('msg' => 'true'));
            }
            return Response::json(array('msg' => 'false'));
        }
    }

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->employee->statuschange($id);
            $loginid = $this->employee->find($id)->login_id;
            $this->user->statuschange($loginid);

            return response()->json(['status' => 'success', 'msg' => 'Employee status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->employee->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Employee deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Import(Request $request)
    {
        $data = array();
        return view('master.employee.import', $data);
    }

    public function ImportSubmit(Request $request)
    {
        try {
            $file = $request->file('employee_upload');

            $rules = [
                'employee_upload' => 'required',
            ];
            $messages = [
                'employee_upload.required' => 'Please upload a file',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            if ($file != null) {

                $uploadpath = 'public/uploads/contractor';

                $folderPath = public_path('uploads/contractor');

                if (!File::exists($folderPath)) {

                    File::makeDirectory($folderPath, 0755, true);
                }

                $filenewname = time() . Str::random('10') . '.' . $file->getClientOriginalExtension();

                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();

                $fileExt = $file->getClientOriginalExtension();

                $file->move($uploadpath, $filenewname);

                $path = $uploadpath . "/" . $filenewname;
                $user_id = Auth::id();

                $insert_data = array(
                    'upload_type' => 1,
                    'upload_status' => 0,
                    'file_name' => $filenewname,
                    'file_orgname' => $fileName,
                    'file_path' => $path,
                    'file_size' => $fileSize,
                    'file_extension' => $fileExt,
                    'created_by' => $user_id,
                );

                $insert_id =  $this->uploadlog->create($insert_data)->id;



                $details = [
                    "user_id" => $user_id,
                    "log_id" => $insert_id,
                    "path" => $path,
                ];

                // dispatch(new ImportEmployeeJob($details));



                dispatch((new ImportEmployeeJob($details))->onQueue('empimport'));
            }

            $insert_data['log_id'] = $insert_id;
            $insert_data['Uploded_by'] = Auth::user()->toArray();

            Session::flash('success', 'Successfully Employee upload');
            return redirect(admin_url('employee/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Employee upload failed!');
            return redirect(admin_url('employee/list'));
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->employee->exportdata();

            $header = [
                'No.',
                'Employee ID',
                'Employee Name',
                'Gender',
                'Nationality',
                'Nationality Others',
                'IC or Passport No',
                'Joining Date',
                'Email ID',
                'Phone',
                'Company Name',
                'Division Name',
                'Department Name',
                'Location',
                'Specific Location',
                'Designation',
                'User Role',
                'Created Date',
                'Status',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Employee ID'] =  $data->emp_id;
                $export['Employee Name'] =  $data->emp_name;
                $export['Gender'] =  ($data->emp_gender == 1) ? "Male" : "Female";
                $export['Nationality'] = ($data->nationality != 1) ? $data->nationality : "Others";
                $export['Nationality Others'] =  $data->emp_nationality_other;
                $export['IC or Passport No'] =  $data->emp_ic_or_passport_no;
                $export['Joining Date'] =   Displaydateformat($data->emp_joining_date);
                $export['Email ID'] =  $data->emp_email_id;
                $export['Phone'] =  $data->emp_phone_no;
                $export['Company Name'] =  $data->company_name;
                $export['Division Name'] =  $data->division_name;
                $export['Department Name'] =  $data->department_name;
                $export['Location'] =  $data->location_name;
                $export['Specific Location'] =  $data->specific_loc_name;
                $export['Designation'] =  $data->designation_name;
                $export['User Role'] =  $data->role_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);
                $export['Status'] = ($data->status == 1)? "Active" : "Inactive" ;

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Employee.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->employee->exportdata();

            $header = [
                'No.',
                'Employee ID',
                'Employee Name',
                'Gender',
                'Nationality',
                'Nationality Others',
                'IC or Passport No',
                'Joining Date',
                'Email ID',
                'Phone',
                'Company Name',
                'Division Name',
                'Department Name',
                'Location',
                'Specific Location',
                'Designation',
                'User Role',
                'Created Date',
                'Status',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Employee Details",
            );

            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('master.employee.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Employee.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function getUser(Request $request)
    {

        $userrole = $request->userrole;
        $department = decryptId($request->department);

        $where = $whereIn = array();

        switch ($userrole) {
            case "job_owner":
                $whereIn = array(
                    ROLE_JOBOWNER
                );
                $where = array(
                    'emp_department_id' => $department,
                );
                $employee = $this->employee->ajaxListJobOwner($department);
                break;
            default:
                $whereIn = array();
                $where = array();
                $employee = $this->employee->ajaxList($where, $whereIn);
                break;
        }


        return response()->json($employee);
    }

    public function change_details()
    {

        try {

            $designationlist = $this->designation->get();
            $companylist = $this->company->get();
            $departmentList = $this->department->getAllDepartment();
            $locationlist = $this->location->getAllLocation();
            $employeeDetails = $this->employee->get();

            $data = array(
                'designationlist' => $designationlist,
                'companylist' => $companylist,
                'departmentList' => $departmentList,
                'locationlist' => $locationlist,
                'employeeDetails' => $employeeDetails,

            );
            return view('master.employee.change_details', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }
    public function change_details_submit(Request $request)
    {
        try {
            $id = decryptId($request->id);


            // $rules = [
            //     'emp_id' => 'required',
            //     'emp_name' => 'required',
            //     'password' => 'required',
            //     'conpassword' => 'required',
            // ];
            // $messages = [
            //     'emp_id.required' => 'Please enter Division ID',
            //     'emp_name.required' => 'Please enter Division Name',
            //     'password.required' => 'Please enter the Password',
            //     'conpassword.required' => 'Please enter the Confirm Password',
            // ];

            // $validator = Validator::make($request->all(), $rules, $messages);
            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }

            $empdetails_old = $this->employee->find($id);

            $this->employee->changeDetails($id);
            $this->user->changeDetails($empdetails_old->login_id);

            $empdetails_new = $this->employee->find($id);


            $this->empChangeLog->store($empdetails_old, $empdetails_new);

            if ($empdetails_old->emp_email_id != '' || $empdetails_old->emp_email_id != null) {


                $emp  = $empdetails_old->toArray();

                Mail::to($empdetails_old->emp_email_id)->queue(new EmployeeDetailsChangeEmail($emp));

            }

            Session::flash('success', 'Employee Details Changed successfully!');
            return redirect(admin_url('home'));
        } catch (Exception $ex) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('home'));
        }
    }

    public function getEmpDetails(Request $request)
    {
        $id = $request->id;

        $employeeDetails = $this->employee->getEmpDetails($id);
        $employeeDetails['emp_company_id'] = getCompanyName($employeeDetails['emp_company_id']);
        $employeeDetails['emp_division_id'] = getDivisionName($employeeDetails['emp_division_id']);
        $employeeDetails['emp_department_id'] = getDepartmentName($employeeDetails['emp_department_id']);
        $employeeDetails['emp_location_id'] = getLocationName($employeeDetails['emp_location_id']);
        $employeeDetails['emp_specfic_location'] = getSpecificLocationName($employeeDetails['emp_specfic_location']);
        $employeeDetails['emp_designation_id'] = getDesignationName($employeeDetails['emp_designation_id']);

        return response()->json($employeeDetails);
    }

    public function list(Request $request){

        $departmentId = decryptId($request->departmentId);

        $employeeDetails = $this->employee->ajaxEmployeeList($departmentId);
        return response()->json($employeeDetails);

    }
}
