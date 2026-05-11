<?php

namespace App\Http\Controllers\PTW;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


use App\Models\User;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;
use App\Models\Master\Company;
use App\Models\Master\Designation;
use App\Models\Master\ContractorCompany;
use App\Models\PTW\PTWActivity;
use App\Models\PTW\PTWCategory;
use App\Models\PTW\PTWItem;
use App\Models\PTW\General;
use App\Models\PTW\PTWSubWorkPermit;
use App\Models\PTW\PTWFile;

use App\Models\PTW\PTWSubPermit;
use App\Models\PTW\Traffic;

use App\Models\PTW\PermitStatusLog;
use App\Models\PTW\SubpermitStatus;

use App\Mail\PTW\SWPTrafficEmail;


class TraficPTWController extends Controller
{

    private $general;
    private $category;
    private $item;
    private $company;
    private $location;
    private $designation;
    private $contractorCompany;
    private $subworkpermit;
    private $ptwfile;

    private $ptwsubpermit;
    private $traffic;

    private $permitstatuslog;
    private $status;

    public function __construct()
    {

        $this->company = new Company();
        $this->general = new General();
        $this->category = new PTWCategory();
        $this->item = new PTWItem();
        $this->location = new Location();
        $this->designation = new Designation();
        $this->contractorCompany = new ContractorCompany();
        $this->subworkpermit = new PTWSubWorkPermit();
        $this->ptwfile = new PTWFile();
        $this->ptwsubpermit = new PTWSubPermit();
        $this->traffic = new Traffic();

        $this->permitstatuslog = new PermitStatusLog();
        $this->status = new SubpermitStatus();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->traffic->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {

                            return Displaydatetimeformat($row->created_at);
                        })
                        ->addColumn('status', function ($row) {
                            $text = subpermitStatus($row->ptw_status);
                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn = '<a href="' . admin_url('ptw/worktraffic/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            if ($row->ptw_status == SUBPERMIT_STATUS_PENDING  && (CheckUserRole(ROLE_TRAFFIC_PERMIT_APPROVER) || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                $btn .= '<a href="' . admin_url('ptw/worktraffic/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }
                            if ($row->ptw_status == SUBPERMIT_STATUS_REJECTED && (Auth::id() == $row->created_by || isAdmin())) {
                                $btn .= '<a href="' . admin_url('ptw/worktraffic/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a> ';
                            }
                            $btn .= '<a href="' . admin_url('ptw/worktraffic/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/pdf.png') . '" alt="PDF" ></i></a> ';
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

        $locationDetails = $this->location->get();
        $statusDetails = $this->status->get();

        $data = array(
            'locationDetails' => $locationDetails,
            'statusDetails' => $statusDetails,
        );

        return view('ptw.traffic.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $id = decryptId($request->ptwId);

            $general = $this->general->find($id);
            $ptwid = $general?->id;

            $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_WORKTRAFFIC);

            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $locationDetails = $this->location->getAllLocation();

            $data = array(
                'ptwid' => $ptwid,
                'nextpermit' => $nextpermit,
                'general' => $general,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'locationDetails' => $locationDetails,

            );
            return view('ptw.traffic.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {


            $rules = [
                'workdescription' => 'required',
                'accept_terms' => 'required',
                'applicant_remarks' => 'required',
            ];
            $messages = [
                'workdescription.required' => 'Please enter Location Name',
                'accept_terms.required' => 'Please enter General PTW Name',
                'applicant_remarks.required' => 'Please enter General PTW Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $ptwid = decryptId($request->ptwid);

                $general = $this->general->find($ptwid);

                $traffic = $this->traffic->store($general);

                $this->ptwfile->traffic($traffic);

                $ptwid = decryptId($request->ptwid);

                $general = $this->general->find($ptwid);

                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_WORKTRAFFIC);

                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_TRAFFIC_PERMIT_APPROVER;
                $notifywhere = array(
                    'company' => $area_of_work,
                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " . 'New Traffic PTW Request';


                        if ($email_id != '' || $email_id != null) {

                            $trafficdetails =  $this->traffic->selectOne($traffic->id);
                            $trafficArray  = $trafficdetails->toArray();


                            $trafficArray['name'] = $user->name;
                            $trafficArray['email_id'] =  $email_id;
                            $trafficArray['mail_subject'] = $mailsubject;

                            Mail::to($trafficArray['email_id'])->queue(new SWPTrafficEmail($trafficArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 7,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New Traffic PTW - ' . $traffic->sub_permit_id . ' Requested by ' . getUsername($traffic->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $traffic->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/worktraffic/approvereject/' . encryptId($traffic->id)),
                        'assigned_user' => array_to_string($userids),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New Traffic PTW - ' . $traffic->sub_permit_id . ' Requested by ' . getUsername($traffic->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);
                }


                $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_WORKTRAFFIC);

                Session::flash('success', 'Work Traffic PTW added successfully!');

                if ($nextpermit != null && $nextpermit != '') {

                    $redirectlink =  nextSubPermit($nextpermit->sub_permit_id, $ptwid);

                    return redirect($redirectlink);
                }
            } catch (Exception $ex) {
                dd($ex);
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            Session::flash('success', 'Work Traffic PTW added successfully!');
            return redirect(admin_url('ptw/worktraffic/list'));
        } catch (Exception $ex) {
            dd($ex);

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/worktraffic/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $traffic = $this->traffic->find($id);


            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $whereArray = array(
                'ptw_id' => $traffic->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArray);

            $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $traffic->ptw_id, $id);

            $data = array(

                'traffic' => $traffic,
                'trafficplandocument' => $trafficplandocument,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'trafficpermitStatusLog' => $trafficpermitStatusLog,

            );


            return view('ptw.traffic.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveReject(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $traffic = $this->traffic->find($id);


            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $whereArray = array(
                'ptw_id' => $traffic->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArray);

            $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $traffic->ptw_id, $id);


            $data = array(

                'traffic' => $traffic,
                'trafficplandocument' => $trafficplandocument,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'trafficpermitStatusLog' => $trafficpermitStatusLog,
                'approvereject' => 'YES',

            );

            return view('ptw.traffic.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $permit = $this->traffic->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = SUBPERMIT_STATUS_APPROVED;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $ptw_status = SUBPERMIT_STATUS_REJECTED;
            }

            $ptw_id = $permit->ptw_id;

            $this->traffic->statuschange($id, $ptw_status);

            $this->ptwsubpermit->statuschange($ptw_id, PTW_SUB_PERMIT_WORKTRAFFIC, $ptw_status);

            if ($is_reject == 1) {

                /**
                 * Send Email Notification
                 */

                $notifywhere = array(
                    'id' => $permit->created_by
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Work Traffic PTW Request is Rejected';


                        if ($email_id != '' || $email_id != null) {

                            $trafficdetails =  $this->traffic->selectOne($permit->id);
                            $trafficArray  = $trafficdetails->toArray();


                            $trafficArray['name'] = $user->name;
                            $trafficArray['email_id'] =  $email_id;
                            $trafficArray['mail_subject'] = $mailsubject;

                            Mail::to($trafficArray['email_id'])->queue(new SWPTrafficEmail($trafficArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 7,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Work Traffic PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/worktraffic/edit/' . encryptId($permit->id)),
                        'assigned_user' => array_to_string($userids),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Work Traffic PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                    ];
                    mobilePushNotification($userId, $notifydata);
                }
            } else {
                /**
                 * Send Email Notification
                 */

                $notifywhere = array(
                    'id' => $permit->created_by
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                    ->orWhere('id', $permit->created_by)
                    ->select('name', 'email')
                    ->get()
                    ->unique('email');

                if ($Assignedusers != null) {

                    foreach ($Assignedusers as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Work Traffic PTW Request is Approved';


                        if ($email_id != '' || $email_id != null) {

                            $trafficdetails =  $this->traffic->selectOne($permit->id);
                            $trafficArray  = $trafficdetails->toArray();


                            $trafficArray['name'] = $user->name;
                            $trafficArray['email_id'] =  $email_id;
                            $trafficArray['mail_subject'] = $mailsubject;

                            Mail::to($trafficArray['email_id'])->queue(new SWPTrafficEmail($trafficArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $CreaterUserId = Auth::id();
                    $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
                    $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
                    $assigned_user = array_unique($assigned_user);

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 7,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Work Traffic PTW - ' . $permit->sub_permit_id . ' is Approved',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/worktraffic/view/' . encryptId($permit->id)),
                        'assigned_user' => array_to_string($assigned_user),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Work Traffic PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                    ];
                    mobilePushNotification($assigned_user, $notifydata);
                }
            }

            $insert_array = array(
                'permit_type' => PTW_SUB_PERMIT_WORKTRAFFIC,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $id,
                'from_status' => 0,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);

            permitStatusUpdate($ptw_id);

            return redirect(admin_url('ptw/worktraffic/list'));
        } catch (Exception $ex) {
            report($ex);

            return redirect(admin_url('ptw/worktraffic/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $traffic = $this->traffic->find($id);

            $ptw_id = $traffic->ptw_id;

            $general = $this->general->find($ptw_id);
            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $locationDetails = $this->location->getAllLocation();

            $whereArray = array(
                'ptw_id' => $traffic->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArray);

            $data = array(

                'traffic' => $traffic,
                'general' => $general,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'locationDetails' => $locationDetails,
                'trafficplandocument' => $trafficplandocument,

            );


            return view('ptw.traffic.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {


            $rules = [
                'workdescription' => 'required',
                'accept_terms' => 'required',
                'applicant_remarks' => 'required',
            ];
            $messages = [
                'workdescription.required' => 'Please enter Location Name',
                'accept_terms.required' => 'Please enter General PTW Name',
                'applicant_remarks.required' => 'Please enter General PTW Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $id = decryptId($request->id);
                $traffic = $this->traffic->find($id);

                $ptwid = $traffic->ptw_id;

                $general = $this->general->find($ptwid);

                $this->traffic->updates($general);
                $traffic = $this->traffic->find($id);

                $this->ptwfile->trafficUpdate($traffic);

                $general = $this->general->find($ptwid);

                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_WORKTRAFFIC);

                $this->ptwsubpermit->statuschange($ptwid, PTW_SUB_PERMIT_WORKTRAFFIC, SUBPERMIT_STATUS_PENDING);

                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_TRAFFIC_PERMIT_APPROVER;
                $notifywhere = array(
                    'company' => $area_of_work,
                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " . 'Work Traffic PTW Resubmited for Approval';


                        if ($email_id != '' || $email_id != null) {

                            $trafficdetails =  $this->traffic->selectOne($traffic->id);
                            $trafficArray  = $trafficdetails->toArray();


                            $trafficArray['name'] = $user->name;
                            $trafficArray['email_id'] =  $email_id;
                            $trafficArray['mail_subject'] = $mailsubject;

                            Mail::to($trafficArray['email_id'])->queue(new SWPTrafficEmail($trafficArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 7,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Work Traffic PTW - ' . $traffic->sub_permit_id . ' Requested by ' . getUsername($traffic->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $traffic->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/worktraffic/approvereject/' . encryptId($traffic->id)),
                        'assigned_user' => array_to_string($userids),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Work Traffic PTW - ' . $traffic->sub_permit_id . ' Requested by ' . getUsername($traffic->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);
                }

                $insert_array = array(
                    'permit_type' => PTW_SUB_PERMIT_WORKTRAFFIC,
                    'ptw_id' => $ptwid,
                    'sub_permit_id' => $id,
                    'from_status' => SUBPERMIT_STATUS_REJECTED,
                    'to_status' => SUBPERMIT_STATUS_PENDING,
                    'is_reject' => 0,
                    'remarks' => $request->applicant_remarks,
                    'approved_by' => Auth::id(),
                );
                $this->permitstatuslog->create($insert_array);

                Session::flash('success', 'Work Traffic PTW updated successfully!');
                return redirect(admin_url('ptw/worktraffic/list'));
            } catch (Exception $ex) {
                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/worktraffic/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/worktraffic/list'));
        }
    }


    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->general->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->traffic->exportdata();

            $header = [
                'No.',
                'PTW ID',
                'Location Name',
                'Status',
                'Created By',
                'Created Date',
            ];

            $i = 1;

            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['PTW ID'] =  $data->sub_permit_id;
                $export['Location Name'] =  $data->location_name;
                $export['Status'] =  subpermitStatusName($data->ptw_status);
                $export['Created By'] =  $data->name;
                $export['Created Date'] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }
            $writer = SimpleExcelWriter::streamDownload('Traffic.xlsx')
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

            $allData = $this->traffic->exportdata();

            $header = [
                'No.',
                'PTW ID',
                'Location Name',
                'Status',
                'Created By',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Traffic Permit",
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

            $view = view('ptw.traffic.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Traffic PTW.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {


            $id = decryptId($request->id);

            /**
             * Work Traffic
             */

            $whereArray = array(
                'id' => $id
            );

            $traffic = $this->traffic->selectOneWhere($whereArray);
            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $whereArrayfile = array(
                'ptw_id' => $traffic?->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic?->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArrayfile);
            $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $id, $traffic?->id);

            $id = $traffic->ptw_id;


            $general = $this->general->find($id);
            $generalpermitStatusLog = $this->permitstatuslog->getDetails(PTW_PERMIT_GENERAL, $id, $id);

            $companyDetails = $this->company->get();

            $locationDetails = $this->location->getAllLocation();
            $designationDetails = $this->designation->get();
            $contractorCompanyDetails = $this->contractorCompany->get();


            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
            $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
            $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
            $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
            $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
            );

            $supportCertificateFile =  $this->ptwfile->getWhere($whereArray);

            $data = array(
                'companyDetails' => $companyDetails,
                'hazardDetails' => $hazardDetails,
                'supportCertificate' => $supportCertificate,
                'protectiveEquipment' => $protectiveEquipment,
                'protectiveEquipmentItems' => $protectiveEquipmentItems,
                'sitePreparationDetails' => $sitePreparationDetails,
                'locationDetails' => $locationDetails,
                'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'supportCertificateFile' => $supportCertificateFile,
                'general' => $general,
                'generalpermitStatusLog' => $generalpermitStatusLog,

                'pagetitle' => $traffic->sub_permit_id,

                'traffic' => $traffic,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'trafficplandocument' => $trafficplandocument,
                'trafficpermitStatusLog' => $trafficpermitStatusLog,
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

            $view = view('ptw.traffic.pdf.general', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
