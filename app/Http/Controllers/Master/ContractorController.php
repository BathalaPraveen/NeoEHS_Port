<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use Str;
use PDF;
use Mail;
use File;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Response;

use App\Models\Master\Nationality;
use App\Models\Master\Designation;
use App\Models\Master\UserRole;
use App\Models\Master\Contractor;
use App\Models\Master\ContractorCompany;

use App\Models\User;
use App\Models\UploadLog;

use App\Jobs\ImportContractorJob;
use App\Mail\ContractorRegisterEmail;

class ContractorController extends Controller
{
    private $nationality;
    private $designation;
    private $userrole;
    private $contractorcompany;
    private $contractor;
    private $uploadlog;
    private $user;



    public function __construct()
    {

        $this->nationality = new Nationality();
        $this->designation = new Designation();
        $this->user = new User();
        $this->userrole = new UserRole();
        $this->contractorcompany = new ContractorCompany();
        $this->contractor = new Contractor();
        $this->uploadlog = new UploadLog();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->contractor->list();

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
                            $btn = '<a href="' . admin_url('contractor/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('contractor/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            if (CheckUserRole(ROLE_ADMIN)) {
                                $btn .= '<a href="' . admin_url('contractor/passwordchange/' . encryptId($row->id)) . '" class=" " title="Change Password"><i class="fa-solid fa-key" style="color:#43a047;"></i></a> ';
                            }
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {
                    report($ex);
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $companylist = $this->contractorcompany->get();
        $data = array(
            'companylist' => $companylist
        );

        return view('master.contractor.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $nationalitylist = $this->nationality->get();
            $designationlist = $this->designation->get();
            $companylist = $this->contractorcompany->get();

            $rolelist = $this->userrole->get();

            $data = array(
                'nationalitylist' => $nationalitylist,
                'designationlist' => $designationlist,
                'companylist' => $companylist,

            );
            return view('master.contractor.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'con_id' => 'required',
                'con_name' => 'required',
                // 'con_gender' => 'required',
                // 'con_nationality' => 'required',
                'con_mc_or_passport_no' => 'required',
                'con_designation_id' => 'required',
                'con_company_id' => 'required',
                'con_email_id' => 'required|email',
                'con_phone_no' => 'required',
                'id_type' => 'required',
            ];
            $messages = [
                'con_id.required' => 'Please enter Contractor ID',
                'con_name.required' => 'Please enter Contractor Name',
                // 'con_gender.required' => 'Please select Gender',
                // 'con_nationality.required' => 'Please select Nationality',
                'con_mc_or_passport_no.required' => 'Please enter MyCard Number or Passport Number ',
                'con_designation_id.required' => 'Please select Designation',
                'con_company_id.required' => 'Please select Company',
                'con_email_id.required' => 'Please enter Email',
                'con_email_id.email' => 'Please enter valid Email',
                'con_phone_no.required' => 'Please enter Phone Number',
                'id_type.required' => 'Please select ID Type',

            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }



            $userDetails = User::constore();
            $id = $userDetails->id;

            $company_id = '';

            if ($request->con_company_id == 0) {

                $company_id = $this->contractorcompany->CreateNew()->id;
            }


            $contractorDetails = $this->contractor->store($id, $company_id);


            if ($contractorDetails->cont_email != '' && $contractorDetails->cont_email != null) {


                $condetails =  $this->contractor->selectOne($contractorDetails->id);

                $con  = $condetails->toArray();

                Mail::to($contractorDetails->cont_email)->queue(new ContractorRegisterEmail($con));
            }

            Session::flash('success', 'Contractor  added successfully!');

            return redirect(admin_url('contractor/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $nationalitylist = $this->nationality->get();
            $designationlist = $this->designation->get();
            $companylist = $this->contractorcompany->get();


            $contractor = $this->contractor->selectOne($id);

            $data = array(
                'nationalitylist' => $nationalitylist,
                'designationlist' => $designationlist,
                'companylist' => $companylist,
                'contractor' => $contractor,
            );


            return view('master.contractor.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $nationalitylist = $this->nationality->get();
            $designationlist = $this->designation->get();
            $companylist = $this->contractorcompany->get();


            $contractor = $this->contractor->find($id);


            $data = array(
                'nationalitylist' => $nationalitylist,
                'designationlist' => $designationlist,
                'companylist' => $companylist,
                'contractor' => $contractor,
            );

            return view('master.contractor.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'con_id' => 'required',
                'con_name' => 'required',
                // 'con_gender' => 'required',
                // 'con_nationality' => 'required',
                'con_mc_or_passport_no' => 'required',
                'con_designation_id' => 'required',
                'con_company_id' => 'required',
                'con_email_id' => 'required|email',
                'con_phone_no' => 'required',
                'id_type' => 'required',
            ];
            $messages = [
                'con_id.required' => 'Please enter Contractor ID',
                'con_name.required' => 'Please enter Contractor Name',
                // 'con_gender.required' => 'Please select Gender',
                // 'con_nationality.required' => 'Please select Nationality',
                'con_mc_or_passport_no.required' => 'Please enter MyCard Number or Passport Number ',
                'con_designation_id.required' => 'Please select Designation',
                'con_company_id.required' => 'Please select Company',
                'con_email_id.required' => 'Please enter Email',
                'con_email_id.email' => 'Please enter valid Email',
                'con_phone_no.required' => 'Please enter Phone Number',
                'id_type.required' => 'Please select ID Type',

            ];


            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $company_id = '';

            if ($request->con_company_id == 0) {

                $company_id = $this->contractorcompany->CreateNew()->id;
            }




            $contractorDetails = $this->contractor->updates($id, $company_id);

            $this->contractor->updates($id);

            $contractorDetails =  $this->contractor->find($id);
            $userid = $contractorDetails->login_id;

            User::conupdate($userid);

            Session::flash('success', 'Contractor updated successfully!');
            return redirect(admin_url('contractor/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
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
            }

            $id = $request->id;

            if ($id == '') {
                $data = array(
                    'param' => $param,
                    'value' => $value,
                );
                $user = $this->contractor->UniqueCheck($data);
            } else {
                $data = array(
                    'param' => $param,
                    'value' => $value,
                    'id' => $id,
                );
                $user = $this->contractor->ExistuniqueCheck($data);
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

            $this->contractor->statuschange($id);

            $loginid = $this->contractor->find($id)->login_id;
            $this->user->statuschange($loginid);

            return response()->json(['status' => 'success', 'msg' => 'Contractor status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->contractor->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Employee deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Import(Request $request)
    {
        $data = array();
        return view('master.contractor.import', $data);
    }

    public function ImportSubmit(Request $request)
    {
        try {
            $file = $request->file('contractor_upload');

            $rules = [
                'contractor_upload' => 'required',
            ];
            $messages = [
                'contractor_upload.required' => 'Please upload a file',
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
                    'upload_type' => 2,
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

                dispatch((new ImportContractorJob($details))->onQueue('conimport'));
            }

            $insert_data['log_id'] = $insert_id;
            $insert_data['Uploded_by'] = Auth::user()->toArray();

            Session::flash('success', 'Successfully Contractor upload');
            return redirect(admin_url('contractor/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Employee upload failed!');
            return redirect(admin_url('contractor/list'));
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->contractor->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Contractor ID',
                'Contractor Employee Name',
                'ID Type',
                'MyCard Number or Passport Number',
                'Designation',
                'Email ID',
                'Phone',
                'Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Company Name'] =  $data->con_comp_name;
                $export['Contractor ID'] =  $data->cont_id;
                $export['Contractor Employee Name'] =  $data->cont_name;
                $export['ID Type'] =   $data->cont_id_type == 1 ? 'MyCard Number' : 'Passport Number';
                $export['MyCard Number or Passport Number'] =  $data->cont_id_number;
                $export['Designation'] =  $data->cont_designation;
                $export['Email ID'] =  $data->cont_email;
                $export['Phone'] =  $data->cont_phone;
                $export[' Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Contractor.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->contractor->exportdata();

            $header = [
                'No.',
                'Company Name',
                'Contractor ID',
                'Contractor Employee Name',
                'ID Type',
                'MyCard Number or Passport Number',
                'Designation',
                'Email ID',
                'Phone',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Contractor Details",
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

            $view = view('master.contractor.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Contractor.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }

    public function PasswordUpdate(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $contractor = $this->contractor->find($id);

            $data = array(
                'contractor' => $contractor,
            );

            return view('master.contractor.passwordupdate', $data);
        } catch (Exception $error) {

            report($error);
        }
    }

    public function PasswordUpdateSubmit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'cont_id' => 'required',
                'cont_name' => 'required',
                'password' => 'required',
                'conpassword' => 'required',
            ];
            $messages = [
                'cont_id.required' => 'Please enter Contractor ID',
                'cont_name.required' => 'Please enter Contractor Name',
                'password.required' => 'Please enter the Password',
                'conpassword.required' => 'Please enter the Confirm Password',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $contdetails = $this->contractor->find($id);

            User::passwordUpdate($contdetails->login_id);

            Session::flash('success', 'Contractor password updated successfully!');
            return redirect(admin_url('contractor/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/list'));
        }
    }
}
