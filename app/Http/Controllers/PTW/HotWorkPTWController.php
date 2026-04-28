<?php

namespace App\Http\Controllers\PTW;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Mail;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;
use DataTables;


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
use App\Models\PTW\Hotwork;

use App\Models\PTW\PermitStatusLog;

use App\Models\PTW\SubpermitStatus;

use App\Mail\PTW\SWPHotworkEmail;

class HotWorkPTWController extends Controller
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
    private $hotwork;

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
        $this->hotwork = new Hotwork();

        $this->permitstatuslog = new PermitStatusLog();
        $this->status = new SubpermitStatus();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->hotwork->list();

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
                            $btn = '<a href="' . admin_url('ptw/hotwork/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            if ($row->ptw_status == SUBPERMIT_STATUS_PENDING  && (CheckUserRole(ROLE_HOTWORK_PERMIT_APPROVER) || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                $btn .= '<a href="' . admin_url('ptw/hotwork/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }
                            if ($row->ptw_status == SUBPERMIT_STATUS_REJECTED && (Auth::id() == $row->created_by || isAdmin())) {
                                $btn .= '<a href="' . admin_url('ptw/hotwork/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a> ';
                            }
                            $btn .= '<a href="' . admin_url('ptw/hotwork/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/pdf.png') . '" alt="PDF" ></i></a> ';
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

        return view('ptw.hotwork.list', $data);
    }

    public function Add(Request $request)
    {

        try {


            $id = decryptId($request->ptwId);

            $general = $this->general->find($id);
            $ptwid = $general?->id;

            // $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_HOTWORK);

            $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_HOTWORK);

            $locationDetails = $this->location->getAllLocation();
            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);

            $subworkpermit =  $this->subworkpermit->get();

            $data = array(
                'ptwid' => $ptwid,
                'nextpermit' => $nextpermit,
                'general' => $general,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'locationDetails' => $locationDetails,
                'subworkpermit' => $subworkpermit,
            );
            return view('ptw.hotwork.add', $data);
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
                'workdescription.required' => 'Please enter Location ID',
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


                $hotwork =  $this->hotwork->store($general);

                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_HOTWORK);


                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_HOTWORK_PERMIT_APPROVER;

                $notifywhere = array(
                    'company' => $area_of_work,

                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " .  'New Hotwork PTW Request';


                        if ($email_id != '' || $email_id != null) {

                            $hotworkdetails =  $this->hotwork->selectOne($hotwork->id);
                            $hotworkArray  = $hotworkdetails->toArray();


                            $hotworkArray['name'] = $user->name;
                            $hotworkArray['email_id'] =  $email_id;
                            $hotworkArray['mail_subject'] = $mailsubject;

                            Mail::to($hotworkArray['email_id'])->queue(new SWPHotworkEmail($hotworkArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 6,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New Hotwork PTW - ' . $hotwork->sub_permit_id . ' Requested by ' . getUsername($hotwork->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $hotwork->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/hotwork/approvereject/' . encryptId($hotwork->id)),
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
                        'message' => 'New Hotwork PTW - ' . $hotwork->sub_permit_id . ' Requested by ' . getUsername($hotwork->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);
                }


                $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_HOTWORK);

                Session::flash('success', 'Hotwork PTW added successfully!');

                if ($nextpermit != null && $nextpermit != '') {

                    $redirectlink =  nextSubPermit($nextpermit->sub_permit_id, $ptwid);

                    return redirect($redirectlink);
                }
            } catch (Exception $ex) {

                dd($ex);
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/hotwork/list'));
        } catch (Exception $ex) {
            dd($ex);
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/hotwork/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $hotwork = $this->hotwork->find($id);

            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
            $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $hotwork->ptw_id, $id);

            $data = array(
                'hotwork' => $hotwork,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'hotworkpermitStatusLog' => $hotworkpermitStatusLog,
            );


            return view('ptw.hotwork.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $hotwork = $this->hotwork->find($id);

            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
            $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $hotwork->ptw_id, $id);

            $data = array(
                'hotwork' => $hotwork,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'hotworkpermitStatusLog' => $hotworkpermitStatusLog,
                'approvereject' => 'YES',
            );

            return view('ptw.hotwork.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $permit = $this->hotwork->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = SUBPERMIT_STATUS_APPROVED;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $ptw_status = SUBPERMIT_STATUS_REJECTED;
            }

            $ptw_id = $permit->ptw_id;

            $this->hotwork->statuschange($id, $ptw_status);

            $this->ptwsubpermit->statuschange($ptw_id, PTW_SUB_PERMIT_HOTWORK, $ptw_status);

            // if ($is_reject == 1) {

            //     /**
            //      * Send Email Notification
            //      */

            //     $notifywhere = array(
            //         'id' => $permit->created_by
            //     );

            //     $userids = User::where($notifywhere)->pluck('id')->toArray();
            //     $users = User::where($notifywhere)->get();

            //     if (count($users) > 0) {

            //         foreach ($users as $user) {

            //             $email_id = $user->email;

            //             $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " .  'Hotwork PTW Request is Rejected';


            //             if ($email_id != '' || $email_id != null) {

            //                 $hotworkdetails =  $this->hotwork->selectOne($permit->id);
            //                 $hotworkArray  = $hotworkdetails->toArray();


            //                 $hotworkArray['name'] = $user->name;
            //                 $hotworkArray['email_id'] =  $email_id;
            //                 $hotworkArray['mail_subject'] = $mailsubject;

            //                 Mail::to($hotworkArray['email_id'])->queue(new SWPHotworkEmail($hotworkArray));
            //             }
            //         }
            //     }

            //     if (count($userids) > 0) {

            //         /**
            //          * Send Web notification
            //          */

            //         $notificationData = array(
            //             'notification_type' => 1,
            //             'module_type' => 6,
            //             'notification_message' => $mailsubject,
            //             'mobile_notification' => json_encode(array(
            //                 'title' => $mailsubject,
            //                 'message' => 'Hotwork PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
            //                 'icon' => 'public/assets/images/icons/permit_to_work.png',
            //                 'id' => $permit->id,
            //                 'module' => 2,
            //             )),
            //             'web_link' =>  admin_url('ptw/isolation/edit/' . encryptId($permit->id)),
            //             'assigned_user' => array_to_string($userids),
            //             'created_by' => Auth::id(),
            //         );
            //         notificationSave($notificationData);

            //         /**
            //          * Send Mobile Push notification
            //          */

            //         $userId = $userids;
            //         $notifydata = [
            //             'title' => $mailsubject,
            //             'message' => 'Hotwork PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
            //         ];
            //         mobilePushNotification($userId, $notifydata);
            //     }
            // } else {
            //     /**
            //      * Send Email Notification
            //      */

            //     $notifywhere = array(
            //         'id' => $permit->created_by
            //     );

            //     $userids = User::where($notifywhere)->pluck('id')->toArray();
            //     $users = User::where($notifywhere)->get();

            //     $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
            //         ->orWhere('id', $permit->created_by)
            //         ->select('name', 'email')
            //         ->get()
            //         ->unique('email');

            //     if ($Assignedusers != null) {

            //         foreach ($Assignedusers as $user) {

            //             $email_id = $user->email;

            //             $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " .  'Hotwork PTW Request is Approved';


            //             if ($email_id != '' || $email_id != null) {

            //                 $hotworkdetails =  $this->hotwork->selectOne($permit->id);
            //                 $hotworkArray  = $hotworkdetails->toArray();


            //                 $hotworkArray['name'] = $user->name;
            //                 $hotworkArray['email_id'] =  $email_id;
            //                 $hotworkArray['mail_subject'] = $mailsubject;

            //                 Mail::to($hotworkArray['email_id'])->queue(new SWPHotworkEmail($hotworkArray));
            //             }
            //         }
            //     }

            //     if (count($userids) > 0) {

            //         /**
            //          * Send Web notification
            //          */

            //          $CreaterUserId = Auth::id();
            //          $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
            //          $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
            //          $assigned_user = array_unique($assigned_user);

            //         $notificationData = array(
            //             'notification_type' => 1,
            //             'module_type' => 6,
            //             'notification_message' => $mailsubject,
            //             'mobile_notification' => json_encode(array(
            //                 'title' => $mailsubject,
            //                 'message' => 'Hotwork PTW - ' . $permit->sub_permit_id . ' is Approved',
            //                 'icon' => 'public/assets/images/icons/permit_to_work.png',
            //                 'id' => $permit->id,
            //                 'module' => 2,
            //             )),
            //             'web_link' =>  admin_url('ptw/isolation/view/' . encryptId($permit->id)),
            //             'assigned_user' => array_to_string($assigned_user),
            //             'created_by' => Auth::id(),
            //         );
            //         notificationSave($notificationData);

            //         /**
            //          * Send Mobile Push notification
            //          */

            //         $userId = $userids;
            //         $notifydata = [
            //             'title' => $mailsubject,
            //             'message' => 'Hotwork PTW - ' . $permit->sub_permit_id . ' is Approved',
            //         ];
            //         mobilePushNotification($assigned_user, $notifydata);
            //     }
            // }

            $insert_array = array(
                'permit_type' => PTW_SUB_PERMIT_HOTWORK,
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

            return redirect(admin_url('ptw/hotwork/list'));
        } catch (Exception $ex) {
            report($ex);

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/hotwork/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $hotwork = $this->hotwork->find($id);

            $ptw_id = $hotwork->ptw_id;

            $general = $this->general->find($ptw_id);


            $locationDetails = $this->location->getAllLocation();
            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);

            $subworkpermit =  $this->subworkpermit->get();

            $data = array(

                'hotwork' => $hotwork,
                'general' => $general,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'locationDetails' => $locationDetails,
                'subworkpermit' => $subworkpermit,
            );


            return view('ptw.hotwork.edit', $data);
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
                'workdescription.required' => 'Please enter Location ID',
                'accept_terms.required' => 'Please enter General PTW Name',
                'applicant_remarks.required' => 'Please enter General PTW Name',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $id  = decryptId($request->id);
                $hotwork = $this->hotwork->find($id);

                $ptwid  = $hotwork->ptw_id;

                $general = $this->general->find($ptwid);
                $this->hotwork->updates($general);

                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_HOTWORK);

                $this->ptwsubpermit->statuschange($ptwid, PTW_SUB_PERMIT_HOTWORK, SUBPERMIT_STATUS_PENDING);

                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_HOTWORK_PERMIT_APPROVER;

                $notifywhere = array(
                    'company' => $area_of_work,

                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " .  'Hotwork Permit Resubmited';


                        if ($email_id != '' || $email_id != null) {

                            $hotworkdetails =  $this->hotwork->selectOne($hotwork->id);
                            $hotworkArray  = $hotworkdetails->toArray();


                            $hotworkArray['name'] = $user->name;
                            $hotworkArray['email_id'] =  $email_id;
                            $hotworkArray['mail_subject'] = $mailsubject;

                            Mail::to($hotworkArray['email_id'])->queue(new SWPHotworkEmail($hotworkArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 6,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Hotwork PTW - ' . $hotwork->sub_permit_id . ' Requested by ' . getUsername($hotwork->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $hotwork->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/hotwork/approvereject/' . encryptId($hotwork->id)),
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
                         'message' => 'Hotwork PTW - ' . $hotwork->sub_permit_id . ' Requested by ' . getUsername($hotwork->created_by),
                     ];
                     mobilePushNotification($userId, $notifydata);
                }


                $insert_array = array(
                    'permit_type' => PTW_SUB_PERMIT_HOTWORK,
                    'ptw_id' => $ptwid,
                    'sub_permit_id' => $id,
                    'from_status' => SUBPERMIT_STATUS_REJECTED,
                    'to_status' => SUBPERMIT_STATUS_PENDING,
                    'is_reject' => 0,
                    'remarks' => $request->applicant_remarks,
                    'approved_by' => Auth::id(),
                );
                $this->permitstatuslog->create($insert_array);


                Session::flash('success', 'Hotwork PTW added successfully!');
                return redirect(admin_url('ptw/hotwork/list'));
            } catch (Exception $ex) {

                dd($ex);
                report($ex);

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/hotwork/list'));
        } catch (Exception $ex) {

            dd($ex);
            report($ex);

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/hotwork/list'));
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

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->general->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->hotwork->exportdata();

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

            $writer = SimpleExcelWriter::streamDownload('Location.xlsx')
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

            $allData = $this->hotwork->exportdata();

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
                'pagetitle' => "Hotwork PTW",
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

            $view = view('ptw.hotwork.pdf', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = "Hotwork PTW.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {


            $id = decryptId($request->id);

            $whereArray = array(
                'id' => $id
            );

            /**
             * Hotwork
             */
            $hotwork = $this->hotwork->selectOneWhere($whereArray);
            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
            $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $id, $hotwork?->id);

            $id = $hotwork->ptw_id;


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

                'pagetitle' => $hotwork->sub_permit_id,

                'hotwork' => $hotwork,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'hotworkpermitStatusLog' => $hotworkpermitStatusLog,


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

            $view = view('ptw.hotwork.pdf.general', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
