<?php

namespace App\Http\Controllers\Chemical;

use App\Http\Controllers\Controller;
use App\Mail\Chemical\ChemicalEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;

use PDF;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;
use DataTables;

use App\Models\User;
use App\Models\Master\Company;
use App\Models\Master\Location;
use App\Models\Chemical\ChemicalCategory;
use App\Models\Chemical\ChemicalItem;
use App\Models\Chemical\Supplier;
use App\Models\Chemical\ChemicalMaster;

use App\Models\Chemical\ChemicalList;
use App\Models\Chemical\ChemicalListDetails;

use App\Models\Chemical\ChemicalStatus;
use App\Models\Chemical\ChemicalStatusLog;
use App\Models\Chemical\HazardClassification;
use App\Models\Master\CompanyActivity;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ChemicalController extends Controller
{

    private $item;
    private $chemicalmaster;
    private $location;
    private $chemicallist;
    private $chemicallistdetails;
    private $status;
    private $statuslog;
    private $hazardclassification;
    private $company_activity_type;
    private $users;

    public function __construct()
    {

        $this->item = new ChemicalItem();
        $this->chemicalmaster = new ChemicalMaster();
        $this->location = new Location();
        $this->chemicallist = new ChemicalList();
        $this->chemicallistdetails = new ChemicalListDetails();
        $this->status = new ChemicalStatus();
        $this->statuslog = new ChemicalStatusLog();
        $this->hazardclassification = new HazardClassification();
        $this->company_activity_type = new CompanyActivity();
        $this->users = new User();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->chemicallist->list();
                    $datatables = DataTables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {

                            return Displaydateformat($row->created_at);
                        })
                        ->addColumn('chemical_status', function ($row) {
                            $text = chemicalStatus($row->chemical_status);

                            return $text;
                        })

                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn .= '<a href="' . admin_url('chemical/chemical/view/' . encryptId($row->id)) . '"  title="View"><i class="fa-solid fa-eye"></i> </a>';

                            if ($row->chemical_status == CHEMICAL_STATUS_SUPERVIOER_PENDING  && (CheckUserRole(ROLE_SUPERVISING_AUTHORITY) || (CheckUserRole(ROLE_CHEMICAL_SUPERVISOR_APPROVER)) || isAdmin())) {
                                $btn .= '<a href="' . admin_url('chemical/chemical/approve/supervisor/' . encryptId($row->id)) . '"  title="Approve"><i class="fa-solid fa-check-to-slot"></i> </a>';
                            }
                            if ($row->chemical_status == CHEMICAL_STATUS_GHSE_PENDING  && (CheckUserRole(ROLE_CHEMICAL_GHSE_APPROVER) || (CheckUserRole(ROLE_CHEMICAL_HOD)) || isAdmin())) {
                                $btn .= '<a href="' . admin_url('chemical/chemical/approve/hod/' . encryptId($row->id)) . '"  title="Approve"><i class="fa-solid fa-check-to-slot"></i> </a>';
                            }
                            if (($row->chemical_status == CHEMICAL_STATUS_SUPERVIOER_REJECTED  ||  $row->chemical_status == CHEMICAL_STATUS_GHSE_REJECTED)  && ($row->created_by == Auth::id() || isAdmin())) {
                                $btn .= '<a href="' . admin_url('chemical/chemical/edit/' . encryptId($row->id)) . '"  title="Edit"><i class="fa-solid fa-pen-to-square"></i></a> ';
                            }
                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status', 'chemical_status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {
                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time', $ex], 406);
                }
            }
        }
        $locationList = $this->location->get();
        $chemicalstatus  = $this->status->get();
        $chemicalmaster = $this->chemicalmaster->get();

        $data = array(
            'locationList' => $locationList,
            'chemicalstatus' => $chemicalstatus,
            'chemicalmaster' => $chemicalmaster,

        );

        return view('chemical.chemical.list', $data);
    }

    public function Add(Request $request)
    {

        try {


            $categoryList =  ChemicalCategory::get();
            $companyList =  Company::get();
            $supplierList = Supplier::get();
            $phyformofchemicalList = $this->item->dataList(CHEMICAL_CATEGORY_PFOC);
            $ecList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMEC);
            $ppelList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMPPE);
            $uoctypeList = $this->item->dataList(CHEMICAL_CATEGORY_UOC);
            $chemicalMasterList =  $this->chemicalmaster->get();
            $locationList =  $this->location->getAllLocation();
            $hazardclassificationList =  $this->hazardclassification->get();
            $company_activity_type =  $this->company_activity_type->getAllActivityType();



            $data = array(
                'categoryList' => $categoryList,
                'companyList' => $companyList,
                'supplierList' => $supplierList,
                'phyformofchemicalList' => $phyformofchemicalList,
                'ecList' => $ecList,
                'ppelList' => $ppelList,
                'uoctypeList' => $uoctypeList,
                'chemicalMasterList' => $chemicalMasterList,
                'locationList' => $locationList,
                'hazardclassificationList' => $hazardclassificationList,
                'company_activity_type' => $company_activity_type,
            );
            return view('chemical.chemical.add', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'company' => 'required',
            ];
            $messages = [
                'company.required' => 'Please select Company',
            ];


            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {


                $chemicalDetails = $this->chemicallist->store();

                $chemicallistdetails = $this->chemicallistdetails->store($chemicalDetails->id);

                /**
                 * Send Email Notification
                 */

                $user_role = ROLE_CHEMICAL_SUPERVISOR_APPROVER;

                $users = User::whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();
                $userids = $users->pluck('id')->toArray();

                $mailsubject = 'New Chemical Created';
                $message = 'New Chemical Created - ' . $chemicalDetails->chemical_id . 'please update The Approval';
                $web_link = admin_url('chemical/chemical/approve/supervisor/' . encryptId($chemicalDetails->id));

                /**
                 * Send Email Notification
                 */

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        if ($email_id != '' || $email_id != null) {
                            $chemical = new ChemicalList();
                            $chemicaldetails =  $chemical->selectOne($chemicalDetails->id);
                            $details  = $chemicaldetails->toArray();

                            $details['name'] = $user->name;
                            $details['email_id'] =  $email_id;
                            $details['mail_subject'] = $mailsubject;

                            Mail::to($details['email_id'])->queue(new ChemicalEmail($details));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => NOTIFICATION_CHEMICAL,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => $message,
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $chemicalDetails->id,
                            'module' => NOTIFICATION_CHEMICAL,
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


                Session::flash('success', 'Chemical List added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('chemical/chemical/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/chemical/list'));
        }
    }

    public function View(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (Auth::check()) {
                $chemicalDetails = $this->chemicallist->selectOne($id);
                $chemicallistDetails = $this->chemicallistdetails->getwhere(['chemical_list_id' => $id]);
                $categoryList =  ChemicalCategory::get();
                $companyList =  Company::find($chemicalDetails->company_id);
                $supplierList = Supplier::get();
                $phyformofchemicalList = $this->item->dataList(CHEMICAL_CATEGORY_PFOC);
                $ecList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMEC);
                $ppelList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMPPE);
                $uoctypeList = $this->item->dataList(CHEMICAL_CATEGORY_UOC);
                $chemicalMasterList =  $this->chemicalmaster->get();
                $locationList =  $this->location->get();
                $statuslog  = $this->statuslog->where('chemical_id', $id)->get();
                $hazardclassificationList =  $this->hazardclassification->get();


                $data = array(
                    'categoryList' => $categoryList,
                    'companyList' => $companyList,
                    'supplierList' => $supplierList,
                    'phyformofchemicalList' => $phyformofchemicalList,
                    'ecList' => $ecList,
                    'ppelList' => $ppelList,
                    'uoctypeList' => $uoctypeList,
                    'chemicalMasterList' => $chemicalMasterList,
                    'locationList' => $locationList,
                    'chemicalDetails' => $chemicalDetails,
                    'chemicallistDetails' => $chemicallistDetails,
                    'statuslog' =>  $statuslog,
                    'hazardclassificationList' => $hazardclassificationList,

                );
            }
            return view('chemical.chemical.view', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $categoryList =  ChemicalCategory::get();
            $companyList =  Company::get();
            $supplierList = Supplier::get();
            $phyformofchemicalList = $this->item->dataList(CHEMICAL_CATEGORY_PFOC);
            $ecList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMEC);
            $ppelList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMPPE);
            $uoctypeList = $this->item->dataList(CHEMICAL_CATEGORY_UOC);
            $chemicalMasterList =  $this->chemicalmaster->get();
            $locationList =  $this->location->getAllLocation();
            $hazardclassificationList =  $this->hazardclassification->get();
            $company_activity_type =  $this->company_activity_type->getAllActivityType();
            $chemicalDetails = $this->chemicallist->selectOne($id);
            $chemicallistDetails = $this->chemicallistdetails->getwhere(['chemical_list_id' => $id]);
            $company =  Company::find($chemicalDetails->company_id);

            $data = array(
                'categoryList' => $categoryList,
                'company' => $company,
                'companyList' => $companyList,
                'supplierList' => $supplierList,
                'phyformofchemicalList' => $phyformofchemicalList,
                'ecList' => $ecList,
                'ppelList' => $ppelList,
                'uoctypeList' => $uoctypeList,
                'chemicalMasterList' => $chemicalMasterList,
                'locationList' => $locationList,
                'chemicalDetails' => $chemicalDetails,
                'chemicallistDetails' => $chemicallistDetails,
                'hazardclassificationList' => $hazardclassificationList,
                'company_activity_type' => $company_activity_type,

            );

            return view('chemical.chemical.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company' => 'required',
            ];
            $messages = [
                'company.required' => 'Please select Company',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $this->chemicallist->updates($id);
            $this->chemicallistdetails->updates($id);

            $chemicalDetails =  $this->chemicallist->find($id);

            $old_status = $chemicalDetails->old_status;

            $loginsert = array(
                'chemical_id' =>  $id,
                'from_status' => $chemicalDetails->old_status,
                'status_description' => $request->reporter_remarks,
                'created_by' => Auth::id(),
            );

            $this->chemicallist->where('id', $id)->update(['chemical_status' => $old_status]);
            $this->statuslog->create($loginsert);


            $user_role = ROLE_CHEMICAL_SUPERVISOR_APPROVER;

            $users = User::whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();
            $userids = $users->pluck('id')->toArray();

            $mailsubject = 'New Chemical Updated';
            $message = 'New Chemical Updated - ' . $chemicalDetails->chemical_id . 'please update The Approval';
            $web_link = admin_url('chemical/chemical/approve/supervisor/' . encryptId($chemicalDetails->id));

            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $chemical = new ChemicalList();
                        $chemicaldetails =  $chemical->selectOne($chemicalDetails->id);
                        $details  = $chemicaldetails->toArray();

                        $details['name'] = $user->name;
                        $details['email_id'] =  $email_id;
                        $details['mail_subject'] = $mailsubject;

                        Mail::to($details['email_id'])->queue(new ChemicalEmail($details));
                    }
                }
            }

            if (count($userids) > 0) {

                /**
                 * Send Web notification
                 */

                $notificationData = array(
                    'notification_type' => 1,
                    'module_type' => NOTIFICATION_CHEMICAL,
                    'notification_message' => $mailsubject,
                    'mobile_notification' => json_encode(array(
                        'title' => $mailsubject,
                        'message' => $message,
                        'icon' => 'public/assets/images/icons/permit_to_work.png',
                        'id' => $chemicalDetails->id,
                        'module' => NOTIFICATION_CHEMICAL,
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

            Session::flash('success', 'Chemical Item updated successfully!');
            return redirect(admin_url('chemical/chemical/list'));
        } catch (Exception $ex) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/chemical/list'));
        }
    }

    public function ApproveReject(Request $request)
    {
        try {

            $type = $request->type;
            $id = decryptId($request->id);
            if (Auth::check()) {
                $chemicalDetails = $this->chemicallist->selectOne($id);
                $chemicallistDetails = $this->chemicallistdetails->getwhere(['chemical_list_id' => $id]);
                $categoryList =  ChemicalCategory::get();
                $companyList =  Company::find($chemicalDetails->company_id);
                $supplierList = Supplier::get();
                $phyformofchemicalList = $this->item->dataList(CHEMICAL_CATEGORY_PFOC);
                $ecList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMEC);
                $ppelList = $this->item->dataList(CHEMICAL_CATEGORY_TOCMPPE);
                $uoctypeList = $this->item->dataList(CHEMICAL_CATEGORY_UOC);
                $chemicalMasterList =  $this->chemicalmaster->get();
                $locationList =  $this->location->get();
                $users = $this->users->find($chemicalDetails->contact_person_name);

                $statuslog  = $this->statuslog->where('chemical_id', $id)->get();
                $data = array(
                    'categoryList' => $categoryList,
                    'companyList' => $companyList,
                    'supplierList' => $supplierList,
                    'phyformofchemicalList' => $phyformofchemicalList,
                    'ecList' => $ecList,
                    'ppelList' => $ppelList,
                    'uoctypeList' => $uoctypeList,
                    'chemicalMasterList' => $chemicalMasterList,
                    'locationList' => $locationList,
                    'chemicalDetails' => $chemicalDetails,
                    'chemicallistDetails' => $chemicallistDetails,
                    'type' => $type,
                    'statuslog' => $statuslog,
                    'users' => $users,

                );
            }
            return view('chemical.chemical.approval', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function  SupervisorApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $action = $request->input('action');
            $chemicalDetails = $this->chemicallist->find($id);

            $rules = [
                'approved_by_id' => 'required',
                'approved_by_date' => 'required',
                'approved_by_remarks' => 'required',
            ];
            $messages = [
                'approved_by_id.required' => 'Please select approved By',
                'approved_by_date.required' => 'Please enter date',
                'approved_by_remarks.required' => 'Please Enter remark',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->chemicallist->approverupdate($id);

            if ($action == 'Approve') {
                $is_reject = 0;
                $tostatus = CHEMICAL_ACKNOWLEDGMENT_PENDING;

                $user_role = ROLE_CHEMICAL_HOD;
                $users = User::whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();
                $userids = $users->pluck('id')->toArray();

                $mailsubject = "[Chemical Notification - " . $chemicalDetails->chemical_id . " ] Requesting for Acknowledgment";
                $message = 'New chemical - ' . $chemicalDetails->chemical_id . ' submitted for approval.';
                $web_link = admin_url('chemical/chemical/approve/supervisor/' . encryptId($chemicalDetails->id));
            } elseif ($action == 'Reject') {
                $is_reject = 1;
                $tostatus = CHEMICAL_SUPERVIOR_REJECTED;

                $notifywhere = array(
                    'id' => $chemicalDetails->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'New Chemical is Rejected';
                $message = 'New chemical - ' . $chemicalDetails->chemical_id . ' is Rejected, please update and Resubmit';
                $web_link = admin_url('chemical/chemical/edit/' . encryptId($chemicalDetails->id));
            }

            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $chemical = new ChemicalList();
                        $chemicaldetails =  $chemical->selectOne($chemicalDetails->id);
                        $details  = $chemicaldetails->toArray();

                        $details['name'] = $user->name;
                        $details['email_id'] =  $email_id;
                        $details['mail_subject'] = $mailsubject;

                        Mail::to($details['email_id'])->queue(new ChemicalEmail($details));
                    }
                }
            }

            if (count($userids) > 0) {

                /**
                 * Send Web notification
                 */

                $notificationData = array(
                    'notification_type' => 1,
                    'module_type' => NOTIFICATION_CHEMICAL,
                    'notification_message' => $mailsubject,
                    'mobile_notification' => json_encode(array(
                        'title' => $mailsubject,
                        'message' => $message,
                        'icon' => 'public/assets/images/icons/permit_to_work.png',
                        'id' => $chemicalDetails->id,
                        'module' => NOTIFICATION_CHEMICAL,
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

            $loginsert = array(
                'chemical_id' =>  $id,
                'from_status' => CHEMICAL_SUPERVIOR_PENDING,
                'to_status' => $tostatus,
                'status_description' => $request->approved_by_remarks,
                'created_by' => Auth::id(),
            );

            $this->chemicallist->where('id', $id)->update(['chemical_status' => $tostatus]);
            $this->statuslog->create($loginsert);

            Session::flash('success', 'Chemical status updated successfully!');
            return redirect(admin_url('chemical/chemical/list'));
        } catch (Exception $ex) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/chemical/list'));
        }
    }

    public function  HodApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $chemicalDetails = $this->chemicallist->find($id);
            $rules = [
                'acknowledged_by' => 'required',
                'acknowledged_at' => 'required',
            ];
            $messages = [
                'acknowledged_by.required' => 'Please select acknowledged By',
                'acknowledged_at.required' => 'Please enter acknowledged date',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->chemicallist->acknowlegedsubmit($id);

            if ($request->has('approve')) {
                $tostatus = CHEMICAL_STATUS_APPROVED;

                $notifywhere = array(
                    'id' => $chemicalDetails->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'Acknowledged Successfully by Chemical HOD';
                $message = 'New chemical - ' . $chemicalDetails->chemical_id . ' has been successfully acknowledged by the Chemical HOD.';
                $web_link = admin_url('chemical/chemical/view/' . encryptId($chemicalDetails->id));
            }


            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $chemical = new ChemicalList();
                        $chemicaldetails =  $chemical->selectOne($chemicalDetails->id);
                        $details  = $chemicaldetails->toArray();

                        $details['name'] = $user->name;
                        $details['email_id'] =  $email_id;
                        $details['mail_subject'] = $mailsubject;

                        Mail::to($details['email_id'])->queue(new ChemicalEmail($details));
                    }
                }
            }

            if (count($userids) > 0) {

                /**
                 * Send Web notification
                 */

                $notificationData = array(
                    'notification_type' => 1,
                    'module_type' => NOTIFICATION_CHEMICAL,
                    'notification_message' => $mailsubject,
                    'mobile_notification' => json_encode(array(
                        'title' => $mailsubject,
                        'message' => $message,
                        'icon' => 'public/assets/images/icons/permit_to_work.png',
                        'id' => $chemicalDetails->id,
                        'module' => NOTIFICATION_CHEMICAL,
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

            $loginsert = array(
                'chemical_id' =>  $id,
                'from_status' => CHEMICAL_ACKNOWLEDGMENT_PENDING,
                'to_status' => $tostatus,
                'created_by' => Auth::id(),
            );
            $this->chemicallist->where('id', $id)->update(['chemical_status' => $tostatus]);
            $this->statuslog->create($loginsert);

            Session::flash('success', 'Chemical status updated successfully!');
            return redirect(admin_url('chemical/chemical/list'));
        } catch (Exception $ex) {
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('chemical/chemical/list'));
        }
    }

    public function Delete(Request $request)
    {

        try {
            $id = decryptId($request->id);
            $this->chemicallist->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Chemical Item deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->chemicallist->exportdata();

            $header = [
                'No.',
                'Chemical ID',
                'Name of Company',
                'Created Date',
                'Status',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];
                $export['No.'] =  $i;
                $export['Chemical ID'] =  $data->chemical_id;
                $export['Name of Company'] =  $data->company_name;
                $export['Created Date'] =  Displaydateformat($data->created_at);
                $export['Status'] =  $data->chemical_status;

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Chemical list.xlsx')
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

            $allData = $this->chemicallist->exportdata();

            $header = [
                'No.',
                'Chemical ID',
                'Name of Company',
                'Created Date',
                'Status',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Chemical list Details",
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

            $view = view('chemical.chemical.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "Chemical Item.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function list(Request $request)
    {

        $categoryid = decryptId($request->categoryid);

        $category = $this->item->ajaxList($categoryid);

        return response()->json($category);
    }
}
