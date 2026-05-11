<?php

namespace App\Http\Controllers\Master;

use PDF;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

use Illuminate\Http\Request;
use App\Mail\PTW\GeneralPTWEmail;
use App\Models\Master\Contractor;
use Illuminate\Support\Facades\DB;
use App\Mail\Master\ContractorMail;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContractorRegisterEmail;
use Illuminate\Support\Facades\Session;
use App\Models\Master\ContractorCompany;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ContractorCompanyController extends Controller
{

    private $contractorcompany;
    private $contractor;
    private $user;

    public function __construct()
    {
        $this->contractorcompany = new ContractorCompany();
        $this->contractor = new Contractor();
        $this->user = new User();
    }


    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {
                    $data =  $this->contractorcompany->list();
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
                            $btn = '<a href="' . admin_url('contractor/company/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            $btn .= '<a href="' . admin_url('contractor/company/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> ';
                            if (($row->contractor_status == HSE_ACTION_PENDING && (CheckUserRole(ROLE_HSEUSER) || CheckUserRole(ROLE_SUPERADMIN))) || ($row->contractor_status == IT_DEPT_ACTION_PENDING && (CheckUserRole(ROLE_IT_DEPARTMENT) || CheckUserRole(ROLE_SUPERADMIN)))) {
                                $btn .= '<a href="' . admin_url('contractor/company/approval/' . encryptId($row->id)) . '" class=" " title="Approval"><i class="fa-solid fa-check-to-slot"></i> ';
                            }
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            return $btn;
                        })
                        ->addColumn('contractor_status', function ($row) {
                            return getContractorCompStatus($row->contractor_status);
                        })
                        ->addColumn('type', function ($row) {
                            return getContarctorType($row->type);
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status', 'contractor_status'])
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

        $data = array();

        return view('master.contractorcompany.list', $data);
    }

    public function Add(Request $request)
    {

        try {
            $malaysiaStates = DB::table('malaysia_states')->get();

            $data = array(
                'malaysiaStates' => $malaysiaStates
            );
            return view('master.contractorcompany.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'con_comp_id' => 'required',
                'con_comp_name' => 'required',
                'con_comp_email' => 'required|email',
                'con_comp_phone' => 'required',

                'con_comp_roc' => 'required',
                'ssm_cerificate' => 'required',
                'type_of_business' => 'required',
                'address_1' => 'required',
                'address_2' => 'required',
                'postcode' => 'required',
                'city' => 'required',
                'state' => 'required',

            ];
            $messages = [
                'con_comp_id.required' => 'Please enter Contractor Company ID',
                'con_comp_name.required' => 'Please enter Contractor Company Name',
                'con_comp_email.required' => 'Please enter Email',
                'con_comp_email.email' => 'Please enter a valid Email',
                'con_comp_phone.required' => 'Please enter Phone Number',

                'con_comp_roc.required' => 'Please enter the ROC/ROB number.',
                'ssm_cerificate.required' => 'Please upload the SSM certificate.',
                'type_of_business.required' => 'Please select the type of business.',
                'address_1.required' => 'Please enter address line 1.',
                'address_2.required' => 'Please enter address line 2.',
                'postcode.required' => 'Please enter the postcode.',
                'city.required' => 'Please enter the city.',
                'state.required' => 'Please select the state.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }



            $this->contractorcompany->store();

            Session::flash('success', 'Contractor Company added successfully!');

            return redirect(admin_url('contractor/company/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $conCompany = $this->contractorcompany->find($id);

                $data = array(
                    'conCompany' => $conCompany,
                );
            }


            return view('master.contractorcompany.view', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function approval(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $conCompany = $this->contractorcompany->find($id);

                $data = array(
                    'conCompany' => $conCompany,
                );
            }

            return view('master.contractorcompany.approval', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $conCompany = $this->contractorcompany->find($id);
            $malaysiaStates = DB::table('malaysia_states')->get();

            $data = array(
                'conCompany' => $conCompany,
                'malaysiaStates' => $malaysiaStates
            );

            return view('master.contractorcompany.edit', $data);
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'con_comp_id' => 'required',
                'con_comp_name' => 'required',
                'con_comp_email' => 'required|email',
                'con_comp_phone' => 'required',

            ];
            $messages = [
                'con_comp_id.required' => 'Please enter Contractor Company ID',
                'con_comp_name.required' => 'Please enter Contractor Company Name',
                'con_comp_email.required' => 'Please enter Email',
                'con_comp_email.email' => 'Please enter a valid Email',
                'con_comp_phone.required' => 'Please enter Phone Number',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->contractorcompany->updates($id);

            Session::flash('success', 'Contractor Company updated successfully!');
            return redirect(admin_url('contractor/company/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function hse_approval(Request $request)
    {

        try {

            $rules = [
                'hse_remarks' => 'required',

            ];
            $messages = [
                'hse_remarks.required' => 'Please enter remarks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $id = decryptId($request->id);


            $this->contractorcompany->hse_approval($id);
            $conCompDetails = $this->contractorcompany->find($id);

            if ($request->action == 1) {

                $user_role = ROLE_IT_DEPARTMENT;

                $userids = User::whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                $mailsubject = "[Contractor Company Notification - " . $conCompDetails->com_id . " ] " . 'Approved';
                $message = 'Contractor Company - ' . $conCompDetails->com_id . ' Approved by HSE';
                $web_link = admin_url('contractor/company/approval/' . encryptId($conCompDetails->id));

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 2,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => $message,
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $conCompDetails->id,
                            'module' => 2,
                        )),
                        'web_link' =>  $web_link,
                        'assigned_user' => array_to_string($userids),
                        'created_by' => auth()->id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => $message,
                    ];
                    mobilePushNotification($userId, $notifydata);
                }
            } else {

                $mailsubject = "[Contractor Company Notification - " . $conCompDetails->com_id . " ] " . 'Rejected';
                $message = 'Contractor Company - ' . $conCompDetails->com_id . ' Rejected by HSE';
                $email_id = $conCompDetails->con_email;

                if ($email_id != '' || $email_id != null) {

                    $mailArray['con_comp_name'] =  $conCompDetails->con_comp_name;
                    $mailArray['con_email'] =  $conCompDetails->con_email;
                    $mailArray['con_phone'] =  $conCompDetails->con_phone;
                    $mailArray['remarks'] =  $conCompDetails->hse_remarks;
                    $mailArray['roc_no'] =  $conCompDetails->roc_no;
                    $mailArray['message'] =  $message;
                    $mailArray['mail_subject'] = $mailsubject;

                    Mail::to($mailArray['con_email'])->queue(new ContractorMail($mailArray));
                }
            }

            Session::flash('success', 'Contractor company approval action done successfully!');
            return redirect(admin_url('contractor/company/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function it_approval(Request $request)
    {
        try {

            $rules = [
                'it_remarks' => 'required',

            ];
            $messages = [
                'it_remarks.required' => 'Please enter remarks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $id = decryptId($request->id);


            $this->contractorcompany->it_approval($id);
            $conCompDetails = $this->contractorcompany->find($id);

            if ($request->action == 1) {

                $mailsubject = "[Contractor Company Notification - " . $conCompDetails->com_id . " ] " . 'Approved';
                $message = 'Contractor Company - ' . $conCompDetails->com_id . ' Approved by IT-Department';
                $email_id = $conCompDetails->con_email;

                $contractorDetails = $this->contractor->getEmployeeUsingCompId($conCompDetails->id);

                if ($contractorDetails != '' && $conCompDetails != null) {
                    $enable_contractor = $this->contractor->enableEmployee($contractorDetails->id);
                    $enable_user = $this->user->enableEmployee($contractorDetails->login_id);

                    if ($contractorDetails->cont_email != '' && $contractorDetails->cont_email != null) {


                        $condetails =  $this->contractor->selectOne($contractorDetails->id);

                        $con  = $condetails->toArray();

                        Mail::to($contractorDetails->cont_email)->queue(new ContractorRegisterEmail($con));
                    }
                }
            } else {

                $mailsubject = "[Contractor Company Notification - " . $conCompDetails->com_id . " ] " . 'Rejected';
                $message = 'Contractor Company - ' . $conCompDetails->com_id . ' Rejected by IT-Department';
                $email_id = $conCompDetails->con_email;
            }

            if ($email_id != '' || $email_id != null) {

                $mailArray['con_comp_name'] =  $conCompDetails->con_comp_name;
                $mailArray['con_email'] =  $conCompDetails->con_email;
                $mailArray['con_phone'] =  $conCompDetails->con_phone;
                $mailArray['roc_no'] =  $conCompDetails->roc_no;
                $mailArray['remarks'] =  $conCompDetails->it_remarks;
                $mailArray['message'] =  $message;
                $mailArray['mail_subject'] = $mailsubject;

                Mail::to($mailArray['con_email'])->queue(new ContractorMail($mailArray));
            }

            Session::flash('success', 'Contractor company approval action done successfully!');
            return redirect(admin_url('contractor/company/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function Uniquecheck(Request $request)
    {
        if ($request->ajax()) {
            $email = $request->email;
            $userid = $request->userid;
            if ($userid == '') {
                $user = $this->user->EmailCheck($email);
            } else {
                $user = $this->user->ExistEmailCheck($email, $userid);
            }
            if ($user->count()) {
                return Response::json(array('msg' => 'true'));
            }
            return Response::json(array('msg' => 'false'));
        }
    }

    public function ROCUniquecheck(Request $request)
    {
        if ($request->ajax()) {
            $id = decryptId($request->id);
            $con_comp_roc = $request->con_comp_roc;

            if ($id) {
                $rocExists = $this->contractorcompany->ExistROCUniquecheck($id, $con_comp_roc);
            } else {
                $rocExists = $this->contractorcompany->ROCUniquecheck($con_comp_roc);
            }

            return response($rocExists ? 'false' : 'true');
        }
    }

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->contractorcompany->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->contractorcompany->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->contractorcompany->exportdata();

            $header = [
                'No.',
                'Contractor Company ID',
                'Contractor Company Name',
                'Email',
                'Phone',
                'Status',
                'Created Date',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Contractor Company ID'] =  $data->com_id;
                $export['Contractor Company Name'] =  $data->con_comp_name;
                $export['Email'] =  $data->con_email;
                $export['Phone'] =  $data->con_phone;
                $export['Status'] =  $data->status == 1 ? 'Active' : 'In-Active';
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Contractor Company.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->contractorcompany->exportdata();

            $header = [
                'No.',
                'Contractor Company ID',
                'Contractor Company Name',
                'Email',
                'Phone',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Contractor Company Details",
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

            $view = view('master.contractorcompany.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Contractor Company.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('contractor/company/list'));
        }
    }
}
