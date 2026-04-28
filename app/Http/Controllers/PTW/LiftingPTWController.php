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
use App\Models\Master\Company;
use App\Models\PTW\PTWCategory;
use App\Models\PTW\PTWItem;
use App\Models\PTW\General;
use App\Models\PTW\PTWSubWorkPermit;
use App\Models\PTW\PTWFile;


use App\Models\PTW\PTWSubPermit;
use App\Models\PTW\Lifting;

use App\Models\PTW\PermitStatusLog;
use App\Models\PTW\SubpermitStatus;

use App\Mail\PTW\SWPLiftingEmail;

class LiftingPTWController extends Controller
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
    private $lifting;

    private $permitstatuslog;
    private $status;

    public function __construct()
    {

        $this->company = new Company();
        $this->general = new General();
        $this->category = new PTWCategory();
        $this->item = new PTWItem();
        $this->location = new Location();
        $this->subworkpermit = new PTWSubWorkPermit();
        $this->ptwfile = new PTWFile();

        $this->ptwsubpermit = new PTWSubPermit();
        $this->lifting = new Lifting();

        $this->permitstatuslog = new PermitStatusLog();
        $this->status = new SubpermitStatus();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->lifting->list();

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
                            $btn = '<a href="' . admin_url('ptw/lifting/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';
                            if ($row->ptw_status == SUBPERMIT_STATUS_PENDING  && (CheckUserRole(ROLE_LIFTING_PERMIT_APPROVER) || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                $btn .= '<a href="' . admin_url('ptw/lifting/approvereject/' . encryptId($row->id)) . '"   class="" title="Approve / Reject"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }
                            if ($row->ptw_status == SUBPERMIT_STATUS_REJECTED && (Auth::id() == $row->created_by || isAdmin())) {
                                $btn .= '<a href="' . admin_url('ptw/lifting/edit/' . encryptId($row->id)) . '"   class="" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a> ';
                            }
                            $btn .= '<a href="' . admin_url('ptw/lifting/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/pdf.png') . '" alt="PDF" ></i></a> ';
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

        return view('ptw.lifting.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $id = decryptId($request->ptwId);

            $general = $this->general->find($id);
            $ptwid = $general?->id;

            // $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_HOTWORK);
            $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_LIFTING);

            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
            $locationDetails = $this->location->getAllLocation();

            $data = array(
                'ptwid' => $ptwid,
                'nextpermit' => $nextpermit,
                'general' => $general,
                'locationDetails' => $locationDetails,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
            );
            return view('ptw.lifting.add', $data);
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

                $lifting = $this->lifting->store($general);

                $this->ptwfile->lifting($lifting);



                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_LIFTING);


                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_LIFTING_PERMIT_APPROVER;

                $notifywhere = array(
                    'company' => $area_of_work,

                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " . 'New Lifting PTW Request';


                        if ($email_id != '' || $email_id != null) {

                            $liftingdetails =  $this->lifting->selectOne($lifting->id);
                            $liftingArray  = $liftingdetails->toArray();


                            $liftingArray['name'] = $user->name;
                            $liftingArray['email_id'] =  $email_id;
                            $liftingArray['mail_subject'] = $mailsubject;

                            Mail::to($liftingArray['email_id'])->queue(new SWPLiftingEmail($liftingArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 8,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New Lifting PTW - ' . $lifting->sub_permit_id . ' Requested by ' . getUsername($lifting->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $lifting->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/lifting/approvereject/' . encryptId($lifting->id)),
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
                        'message' => 'New Lifting PTW - ' . $lifting->sub_permit_id . ' Requested by ' . getUsername($lifting->created_by),
                    ];
                    mobilePushNotification($userId, $notifydata);
                }

                $nextpermit = $this->ptwsubpermit->nextpermit($ptwid, PTW_SUB_PERMIT_LIFTING);

                Session::flash('success', 'Lifting PTW added successfully!');

                if ($nextpermit != null && $nextpermit != '') {

                    $redirectlink =  nextSubPermit($nextpermit->sub_permit_id, $ptwid);

                    return redirect($redirectlink);
                }
            } catch (Exception $ex) {
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            Session::flash('success', 'Lifting PTW added successfully!');

            return redirect(admin_url('ptw/lifting/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');

            return redirect(admin_url('ptw/lifting/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $lifting = $this->lifting->find($id);

            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);


            $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_LIFTING, $lifting->ptw_id, $id);

            $whereArray = array(
                'ptw_id' => $lifting->ptw_id,
                'ptw_module' => 6,
                'reference_id' => $lifting->id,
            );

            $liftingdocument =  $this->ptwfile->getWhererby($whereArray);


            $data = array(
                'lifting' => $lifting,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingpermitStatusLog' => $liftingpermitStatusLog,
                'liftingdocument' => $liftingdocument,
            );


            return view('ptw.lifting.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $lifting = $this->lifting->find($id);

            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);


            $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_GAS, $lifting->ptw_id, $id);

            $whereArray = array(
                'ptw_id' => $lifting->ptw_id,
                'ptw_module' => 6,
                'reference_id' => $lifting->id,
            );

            $liftingdocument =  $this->ptwfile->getWhererby($whereArray);

            $data = array(
                'lifting' => $lifting,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingpermitStatusLog' => $liftingpermitStatusLog,
                'liftingdocument' => $liftingdocument,
                'approvereject' => 'YES',
            );

            return view('ptw.lifting.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $permit = $this->lifting->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = SUBPERMIT_STATUS_APPROVED;
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $ptw_status = SUBPERMIT_STATUS_REJECTED;
            }

            $ptw_id = $permit->ptw_id;

            $this->lifting->statuschange($id, $ptw_status);

            $this->ptwsubpermit->statuschange($ptw_id, PTW_SUB_PERMIT_LIFTING, $ptw_status);

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

                        $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Lifting PTW Request is Rejected';


                        if ($email_id != '' || $email_id != null) {

                            $liftingdetails =  $this->lifting->selectOne($permit->id);
                            $liftingArray  = $liftingdetails->toArray();


                            $liftingArray['name'] = $user->name;
                            $liftingArray['email_id'] =  $email_id;
                            $liftingArray['mail_subject'] = $mailsubject;

                            Mail::to($liftingArray['email_id'])->queue(new SWPLiftingEmail($liftingArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 8,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Lifting PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/lifting/edit/' . encryptId($permit->id)),
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
                        'message' => 'Lifting PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
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

                        $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Lifting PTW Request is Approved';


                        if ($email_id != '' || $email_id != null) {

                            $liftingdetails =  $this->lifting->selectOne($permit->id);
                            $liftingArray  = $liftingdetails->toArray();


                            $liftingArray['name'] = $user->name;
                            $liftingArray['email_id'] =  $email_id;
                            $liftingArray['mail_subject'] = $mailsubject;

                            Mail::to($liftingArray['email_id'])->queue(new SWPLiftingEmail($liftingArray));
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
                        'module_type' => 8,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Lifting PTW - ' . $permit->sub_permit_id . ' is Approved',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/lifting/view/' . encryptId($permit->id)),
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
                        'message' => 'Lifting PTW - ' . $permit->sub_permit_id . ' is Approved',
                    ];
                    mobilePushNotification($assigned_user, $notifydata);
                }
            }

            $insert_array = array(
                'permit_type' => PTW_SUB_PERMIT_LIFTING,
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

            return redirect(admin_url('ptw/lifting/list'));
        } catch (Exception $ex) {
            report($ex);

            return redirect(admin_url('ptw/lifting/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {


            $id = decryptId($request->id);

            $lifting = $this->lifting->find($id);

            $ptw_id = $lifting->ptw_id;

            $general = $this->general->find($ptw_id);

            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
            $locationDetails = $this->location->get();

            $whereArray = array(
                'ptw_id' => $lifting->ptw_id,
                'ptw_module' => 6,
                'reference_id' => $lifting->id,
            );

            $liftingdocument =  $this->ptwfile->getWhererby($whereArray);

            $data = array(

                'lifting' => $lifting,
                'general' => $general,
                'locationDetails' => $locationDetails,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingdocument' => $liftingdocument,
            );

            return view('ptw.lifting.edit', $data);
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

                $id  = decryptId($request->id);

                $lifting = $this->lifting->find($id);

                $ptwid  = $lifting->ptw_id;
                $general = $this->general->find($ptwid);

                $this->lifting->updates($general);

                $this->ptwfile->liftingUpdate($lifting);

                $this->ptwsubpermit->updatePermit($ptwid, PTW_SUB_PERMIT_LIFTING);

                $this->ptwsubpermit->statuschange($ptwid, PTW_SUB_PERMIT_LIFTING, SUBPERMIT_STATUS_PENDING);

                /**
                 * Send Email Notification
                 */

                $area_of_work = $general->area_of_work;
                $user_role = ROLE_LIFTING_PERMIT_APPROVER;

                $notifywhere = array(
                    'company' => $area_of_work,

                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwid) . " ] " . 'Lifting PTW Resubmited for Approval';


                        if ($email_id != '' || $email_id != null) {

                            $liftingdetails =  $this->lifting->selectOne($lifting->id);
                            $liftingArray  = $liftingdetails->toArray();


                            $liftingArray['name'] = $user->name;
                            $liftingArray['email_id'] =  $email_id;
                            $liftingArray['mail_subject'] = $mailsubject;

                            Mail::to($liftingArray['email_id'])->queue(new SWPLiftingEmail($liftingArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 8,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Lifting PTW - ' . $lifting->sub_permit_id . ' Requested by ' . getUsername($lifting->created_by),
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $lifting->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/lifting/approvereject/' . encryptId($lifting->id)),
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
                         'message' => 'Lifting PTW - ' . $lifting->sub_permit_id . ' Requested by ' . getUsername($lifting->created_by),
                     ];
                     mobilePushNotification($userId, $notifydata);
                }

                $insert_array = array(
                    'permit_type' => PTW_SUB_PERMIT_LIFTING,
                    'ptw_id' => $ptwid,
                    'sub_permit_id' => $id,
                    'from_status' => SUBPERMIT_STATUS_REJECTED,
                    'to_status' => SUBPERMIT_STATUS_PENDING,
                    'is_reject' => 0,
                    'remarks' => $request->applicant_remarks,
                    'approved_by' => Auth::id(),
                );


                $this->permitstatuslog->create($insert_array);

                Session::flash('success', 'Lifting PTW updated successfully!');
                return redirect(admin_url('ptw/lifting/list'));
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/lifting/list'));


            return redirect(admin_url('ptw/lifting/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/lifting/list'));
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

            $allData = $this->lifting->exportdata();

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

            $allData = $this->lifting->exportdata();

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
                'pagetitle' => "Lifting PTW",
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

            $view = view('ptw.lifting.pdf', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = "Lifting PTW.pdf";
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
             * Lifting
             */
            $lifting = $this->lifting->selectOneWhere($whereArray);
            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
            $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_LIFTING, $id, $lifting?->id);

            $id =  $lifting->ptw_id;

            $general = $this->general->find($id);
            $generalpermitStatusLog = $this->permitstatuslog->getDetails(PTW_PERMIT_GENERAL, $id, $id);

            $companyDetails = $this->company->get();

            $locationDetails = $this->location->get();
            // $designationDetails = $this->designation->get();
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
                // 'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'supportCertificateFile' => $supportCertificateFile,
                'general' => $general,
                'generalpermitStatusLog' => $generalpermitStatusLog,

                'pagetitle' => $lifting->sub_permit_id,

                'lifting' => $lifting,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingpermitStatusLog' => $liftingpermitStatusLog,

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

            $view = view('ptw.lifting.pdf.general', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
