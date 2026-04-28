<?php

namespace App\Http\Controllers\ATAR;

use PDF;
use Exception;
use DataTables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ATAR\UAUC;


use Illuminate\Http\Request;
use App\Models\ATAR\UAUCFile;
use App\Models\ATAR\AtarTypes;
use App\Models\ATAR\HSEHazard;
use App\Models\ATAR\ZefaRules;


use App\Models\Master\Company;

use App\Models\ATAR\UAUCStatus;
use App\Models\Master\Division;
use App\Models\Master\Location;

use App\Models\ATAR\ActionTaken;
use App\Models\ATAR\Infringement;

use App\Models\Master\Department;
use App\Mail\UAUC\UAUCStatusEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\ATAR\UAUCFileStatusLog;
use App\Models\Master\SpecificLocation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Spatie\SimpleExcel\SimpleExcelWriter;

use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Contracts\Session\Session as SessionSession;

class UAUCController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;
    private $atartype;
    private $zefarule;
    private $hsehazard;
    private $uauc;
    private $uaucfiles;
    private $uaucstatus;
    private $actiontaken;
    private $statuslog;
    private $infringement;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->atartype = new AtarTypes();
        $this->zefarule = new ZefaRules();
        $this->hsehazard = new HSEHazard();

        $this->uauc = new UAUC();
        $this->uaucfiles = new UAUCFile();

        $this->uaucstatus = new UAUCStatus();

        $this->actiontaken = new ActionTaken();
        $this->statuslog = new UAUCFileStatusLog;
        $this->infringement = new Infringement();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->uauc->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('dateandtime', function ($row) {
                            return Displaydateformat($row->dateandtime);
                        })
                        ->addColumn('department', function ($row) {
                            return getDepartmentName($row->department);
                        })
                        ->addColumn('user_company', function ($row) {
                            return getCompanyName($row->user_company);
                        })
                        ->addColumn('user_department', function ($row) {
                            return getDepartmentName($row->user_department);
                        })
                        ->addColumn('user_division', function ($row) {
                            return getDivisionName($row->user_division);
                        })
                        ->editColumn('usee_remarks', function ($row) {
                            return  "<div class='text-wrap width-400' >" . $row->usee_remarks . "</div>";
                        })
                        ->editColumn('atar_status', function ($row) {
                            return  "<span class='" . $row->bg_colors . "' >" . $row->atar_status . "</span>";
                        })

                        ->addColumn('action', function ($row) {
                            $btn = '';

                            if ($row->status_id == 5 || $row->status_id == 4 || $row->status_id == 6) {
                                $status = 'fa-solid fa-eye';
                                $text = 'View';
                            } else {

                                if ((CheckUserRole(ROLE_JOBOWNER) &&
                                        ($row->job_owner == Auth::id() || $row->reassign_job_owner == Auth::id())) ||
                                    CheckUserRole(ROLE_HSEUSER) ||
                                    CheckUserRole(ROLE_SUPERADMIN) ||
                                    CheckUserRole(Auth::user()->role == ROLE_ADMIN)
                                ) {
                                    $status = 'fa-solid fa-check-to-slot';
                                    $text = 'Update Status';
                                } else {
                                    $status = 'fa-solid fa-eye';
                                    $text = 'View';
                                }
                            }

                            $btn = '<a href="' . admin_url('atar/uauc/view/' . encryptId($row->id)) . '" data-toggle="tooltip"   class="" title="' . $text . '"><i class="' . $status . '"></i></a> ';
                            $btn .= '<a href="' . admin_url('atar/uauc/view/pdf/' . encryptId($row->id)) . '" data-toggle="tooltip" class=" " title="Pdf"><i class="fa fa-file-pdf-o"></i> ';


                            if (CheckUserRole(ROLE_SUPERADMIN)) {
                                $btn .= '<a href="#" data-toggle="tooltip" class="recordDelete" data-id="' . encryptId($row->id) . '" title="Delete"><i class="fa fa-trash"></i> ';
                            }


                            return $btn;
                        })
                        ->rawColumns(['action', 'dateandtime', 'created_by', 'atar_status', 'usee_remarks'])
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

        if ($request->search != '' && $request->search != null) {

            $search = 1;
            $searchArray = string_to_array($request->search, "__");
            $searchstatus = isset($searchArray[0]) ? decryptId($searchArray[0]) : "";
        } else {
            $search = 0;
            $searchArray = [];
            $searchstatus =  "";
        }

        $uauctype =  $this->atartype->get();
        $locationDetails = $this->location->get();
        $uaucstatus =  $this->uaucstatus->get();
        $companyDetails = $this->company->getAllCompany();
        $departmentDetails = $this->department->getAllDepartment();
        $divisionDetails = $this->division->getAllDivision();
        $atartypeDetails = $this->atartype->get();

        // filter data

        function sanitize($value)
        {
            return ($value == 'undefined' || $value === '') ? null : $value;
        }

        $uauc_category     = sanitize($request->category);
        $company           = sanitize($request->company);
        $division          = sanitize($request->division);
        $department        = sanitize($request->department);
        $location          = sanitize($request->location);
        $spec_location     = sanitize($request->spec_location);
        $year              = sanitize($request->year);
        $month             = sanitize($request->month);
        $corrective_action = sanitize($request->corrective_action);

        $data = array(
            'uauctype' => $uauctype,
            'locationDetails' => $locationDetails,
            'uaucstatus' => $uaucstatus,
            'searchstatus' => $searchstatus,
            'search' => $search,
            'companyDetails' => $companyDetails,
            'departmentDetails' => $departmentDetails,
            'divisionDetails' => $divisionDetails,
            'atartypeDetails' => $atartypeDetails,

            'uauc_category_from_filter' => $uauc_category,
            'company_from_filter' => $company,
            'division_from_filter' => $division,
            'department_from_filter' => $department,
            'location_from_filter' => $location,
            'spec_location_from_filter' => $spec_location,
            'year_from_filter' => $year,
            'month_from_filter' => $month,
            'corrective_action_from_filter' => $corrective_action,
        );
        
        return view('atar.uauc.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->getAllSpecificLocation();

            $companyDetails = $this->company->getAllCompany();
            $divisionDetails = $this->division->getAllDivision();
            $departmentDetails = $this->department->getAllDepartment();

            $atartypeDetails = $this->atartype->get();
            $atartypeactDetails = $this->actiontaken->orderBy('sort_order', 'ASC')->get();
            $zefaruleDetails = $this->zefarule->get();
            $hsehazardDetails = $this->hsehazard->get();

            $infringement = $this->infringement->get();

            $data = array(
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'companyDetails' => $companyDetails,
                'divisionDetails' => $divisionDetails,
                'departmentDetails' => $departmentDetails,
                'atartypeDetails' => $atartypeDetails,
                'atartypeactDetails' => $atartypeactDetails,
                'zefaruleDetails' => $zefaruleDetails,
                'hsehazardDetails' => $hsehazardDetails,
                'infringementList' => $infringement,

            );
            return view('atar.uauc.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'reporter_name' => 'required',
                'reporter_email' => 'required',
                'reporter_company' => 'required',
                'reporter_division' => 'required',
                'reporter_department' => 'required',
                'dateandtime' => 'required',
                'location' => 'required',
                'specific_location' => 'required',
                'uauc_category' => 'required',
                'hse_hazard' => 'required',
                'usee_remarks' => 'required',
            ];
            $messages = [
                'reporter_name.required' => 'Please enter Reporter Name',
                'reporter_email.required' => 'Please enter Reporter Email',
                'reporter_company.required' => 'Please enter Reporter Company',
                'reporter_division.required' => 'Please enter Reporter Division',
                'reporter_department.required' => 'Please enter Reporter Department',
                'dateandtime.required' => 'Please enter Date & Time',
                'location.required' => 'Please select Location',
                'specific_location.required' => 'Please select Specific Location',
                'uauc_category.required' => 'Please select UAUC Category',
                'hse_hazard.required' => 'Please select HSE Hazard',
                'usee_remarks.required' => 'Please enter U-See Remarks',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $uauc =  $this->uauc->store();

                if ($uauc) {

                    $this->uaucfiles->store($uauc);

                    if ($uauc->uauc_category == 1 || $uauc->uauc_category == 2) {

                        $insert_log_array = [
                            'atar_id' => $uauc->id,
                            'from_status' => 1,
                            'to_status' => 5,
                            'status_description' =>  $request->usee_remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                    }

                    if ($uauc->action_taken != '') {

                        if ($uauc->action_taken == 2) {

                            $insert_log_array = [
                                'atar_id' => $uauc->id,
                                'from_status' => 1,
                                'to_status' => 5,
                                'status_description' =>  $request->uact_remarks,
                                'created_by' => Auth::id(),
                            ];

                            $this->statuslog->add($insert_log_array);
                        }
                    }

                    /** Notification */
                    if ($uauc->uauc_category == UAUC_SA || $uauc->uauc_category == UAUC_SC || ($uauc->uauc_category == UAUC_USA && $uauc->action_taken == UAUC_IMM_ACT)) {
                        // $mailsubject = 'New UAUC Created and Closed';


                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';

                        $CreaterUserId = Auth::id();
                        $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
                        $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
                        $assigned_user = array_unique($assigned_user);

                        $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                            ->orWhere('id', $CreaterUserId)
                            ->select('name', 'email')
                            ->get()
                            ->unique('email');

                        /**
                         * Email Web App Notification
                         */
                        if ($Assignedusers != null) {

                            foreach ($Assignedusers as $user) {

                                $email_id = $user->email;
                                if ($email_id != '' || $email_id != null) {

                                    $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                    $uaucArray  = $uaucdetails->toArray();

                                    $uaucCategory = '';
                                    if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                        $uaucCategory = 'Positive Observation - ';
                                    }
                                    $uaucCategory .= $uaucdetails->atar_type;
                                    $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                    $uaucArray['name'] = $user->name;
                                    $uaucArray['email_id'] =  $email_id;
                                    $uaucArray['mail_subject'] = $mailsubject;
                                    $uaucArray['uaucCategory'] = $uaucCategory;
                                    $uaucArray['uactfiles'] = $uactfiles;



                                    Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                                }
                            }
                        }

                        /**
                         * Send Web notification
                         */
                        $notificationData = array(
                            'notification_type' => 1,
                            'module_type' => 1,
                            'notification_message' => $mailsubject,
                            'mobile_notification' => json_encode(array(
                                'title' => $mailsubject,
                                'message' => 'New UAUC ' . $uauc->atar_id . ' created by ' . getUsername($uauc->created_by),
                                'icon' => 'public/assets/images/notification/uauc.png',
                                'id' => $uauc->id,
                                'module' => 1,
                            )),
                            'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                            'assigned_user' => array_to_string($assigned_user),
                            'created_by' => Auth::id(),
                        );
                        notificationSave($notificationData);

                        /**
                         * Send Mobile Push notification
                         */

                        $notifydata = [
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' created by ' . getUsername($uauc->created_by),
                            'module_id' => $uauc->id,
                            'module_type' => 1,
                        ];
                        mobilePushNotification($assigned_user, $notifydata);
                    } else {

                        //$mailsubject = 'New UAUC Created and Assigned to you';
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        $jobowner =  decryptId($request->job_owner);
                        $userId = [$jobowner];

                        $jobownerDetails =  User::where('id', $jobowner)->first();
                        $email_id = $jobownerDetails->email;

                        $violators_email_id = $request->violators_email;

                        /**
                         * Violators Email Notification
                         */
                        if ($request->violators_email != '' && $request->violators_email != null && $violators_email_id != $email_id) {

                            $email_id = $request->violators_email;

                            if ($email_id != '' || $email_id != null) {

                                $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                $uaucArray  = $uaucdetails->toArray();

                                $uaucCategory = '';
                                if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                    $uaucCategory = 'Positive Observation - ';
                                }
                                $uaucCategory .= $uaucdetails->atar_type;
                                $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                $uaucArray['name'] = 'User';
                                $uaucArray['email_id'] =  $email_id;
                                $uaucArray['mail_subject'] = $mailsubject;
                                $uaucArray['uaucCategory'] = $uaucCategory;
                                $uaucArray['uactfiles'] = $uactfiles;



                                Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                            }
                        }

                        /**
                         * Email Web App Notification
                         */
                        if ($jobownerDetails != '' && $jobownerDetails != null) {

                            $email_id = $jobownerDetails->email;
                            if ($email_id != '' || $email_id != null) {

                                $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                $uaucArray  = $uaucdetails->toArray();

                                $uaucCategory = '';
                                if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                    $uaucCategory = 'Positive Observation - ';
                                }
                                $uaucCategory .= $uaucdetails->atar_type;
                                $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                $uaucArray['name'] = $jobownerDetails->name;
                                $uaucArray['email_id'] =  $email_id;
                                $uaucArray['mail_subject'] = $mailsubject;
                                $uaucArray['uaucCategory'] = $uaucCategory;
                                $uaucArray['uactfiles'] = $uactfiles;



                                Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                            }
                        }

                        /**
                         * web Notification
                         */
                        $notificationData = array(
                            'notification_type' => 1,
                            'module_type' => 1,
                            'notification_message' => $mailsubject,
                            'mobile_notification' => json_encode(array(
                                'title' => $mailsubject,
                                'message' => 'New UAUC ' . $uauc->atar_id . ' created by ' . getUsername($uauc->created_by),
                                'icon' => 'public/assets/images/notification/uauc.png',
                                'id' => $uauc->id,
                                'module' => 1,
                            )),
                            'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                            'assigned_user' => array_to_string($userId),
                            'created_by' => Auth::id(),
                        );
                        notificationSave($notificationData);

                        /**
                         * Send Mobile Push notification
                         */

                        $notifydata = [
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' created by ' . getUsername($uauc->created_by),
                            'module_id' => $uauc->id,
                            'module_type' => 1,
                        ];
                        mobilePushNotification($userId, $notifydata);
                    }




                    Session::flash('success', 'UAUC added successfully!');
                } else {

                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {
                report($ex);

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }


            return redirect(admin_url('atar/uauc/list'));
        } catch (Exception $ex) {
            report($ex);

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/uauc/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $uauc = $this->uauc->selectOne($id);
            $userInfo = User::find($uauc->created_by);

            $companyDetails = $this->company->getAllCompany();

            $useefiles = $this->uaucfiles->getfiles($id, 1);
            $uactfiles = $this->uaucfiles->getfiles($id, 2);
            $finalfiles = $this->uaucfiles->getfiles($id, 3);
            $hscfiles = $this->uaucfiles->getfiles($id, 4);

            $uauc_status = $this->uaucstatus->getstatus($uauc->atar_status_id);

            $uauc_status_log =  $this->statuslog->getatarstatus($uauc->id);

            $data = array(
                'uauc' => $uauc,
                'useefiles' => $useefiles,
                'uactfiles' => $uactfiles,
                'finalfiles' => $finalfiles,
                'hscfiles' => $hscfiles,
                'uauc_status' => $uauc_status,
                'uauc_status_log' => $uauc_status_log,
                'userInfo' => $userInfo,
                'companyDetails' => $companyDetails,
            );

            return view('atar.uauc.view', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Update(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $rules = [
                'uauc_status' => 'required',
            ];
            $messages = [
                'uauc_status.required' => 'Please select the Status',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {


                $uauc_old = $this->uauc->find($id);

                $this->uauc->updates($id);

                $uauc = $this->uauc->find($id);

                $status = [
                    'id' => $uauc->id,
                    'from_status' => $uauc_old->atar_status,
                    'to_status' => $uauc->atar_status,
                ];


                $uauc_status = decryptId($request->uauc_status);


                if ($uauc_status == UAUC_STATUS_ACCEPT) {
                    //$mailsubject = "UAUC Closure Pending";
                    $uaucid = $uauc->atar_id;
                    $company_name = getCompanyName($uauc->uauc_company_id);
                    $locationname = getLocationName($uauc->location);
                    $sublocationname = getSpecificLocationName($uauc->specific_location);
                    $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                    $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                    $CreaterUserId = $uauc_old->created_by;
                    $userId = [$CreaterUserId];

                    $createduserDetails =  User::where('id', $CreaterUserId)->first();
                    $email_id = $createduserDetails->email;

                    /**
                     * Email Web App Notification
                     */
                    if ($createduserDetails != '' && $createduserDetails != null) {

                        $email_id = $createduserDetails->email;
                        if ($email_id != '' || $email_id != null) {

                            $uaucdetails =  $this->uauc->selectOne($uauc->id);
                            $uaucArray  = $uaucdetails->toArray();

                            $uaucCategory = '';
                            if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                $uaucCategory = 'Positive Observation - ';
                            }
                            $uaucCategory .= $uaucdetails->atar_type;
                            $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                            $uaucArray['name'] = $createduserDetails->name;
                            $uaucArray['email_id'] =  $email_id;
                            $uaucArray['mail_subject'] = $mailsubject;
                            $uaucArray['uaucCategory'] = $uaucCategory;
                            $uaucArray['uactfiles'] = $uactfiles;



                            Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                        }
                    }
                    /**
                     * Send Web notification
                     */
                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 1,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Accepted by ' . getUsername(Auth::id()),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $uauc->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                        'assigned_user' => array_to_string($userId),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New UAUC ' . $uauc->atar_id . ' Accepted by ' . getUsername(Auth::id()),
                        'module_id' => $uauc->id,
                        'module_type' => 1,
                    ];
                    mobilePushNotification($userId, $notifydata);
                }
                if ($uauc_status == UAUC_STATUS_CLOSE) {
                    //$mailsubject = "UAUC Closed";
                    $uaucid = $uauc->atar_id;
                    $company_name = getCompanyName($uauc->uauc_company_id);
                    $locationname = getLocationName($uauc->location);
                    $sublocationname = getSpecificLocationName($uauc->specific_location);
                    $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                    $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                    $CreaterUserId = $uauc_old->created_by;
                    $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
                    $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
                    $assigned_user = array_unique($assigned_user);
                    $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                        ->orWhere('id', $CreaterUserId)
                        ->select('name', 'email')
                        ->get()
                        ->unique('email');

                    /**
                     * Email Web App Notification
                     */
                    if ($Assignedusers != null) {

                        foreach ($Assignedusers as $user) {

                            $email_id = $user->email;
                            if ($email_id != '' || $email_id != null) {

                                $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                $uaucArray  = $uaucdetails->toArray();

                                $uaucCategory = '';
                                if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                    $uaucCategory = 'Positive Observation - ';
                                }
                                $uaucCategory .= $uaucdetails->atar_type;
                                $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                $uaucArray['name'] = $user->name;
                                $uaucArray['email_id'] =  $email_id;
                                $uaucArray['mail_subject'] = $mailsubject;
                                $uaucArray['uaucCategory'] = $uaucCategory;
                                $uaucArray['uactfiles'] = $uactfiles;



                                Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                            }
                        }
                    }
                    /**
                     * Send Web notification
                     */
                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 1,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Closed by ' . getUsername($uauc->created_by),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $uauc->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                        'assigned_user' => array_to_string($assigned_user),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);
                    /**
                     * Send Mobile Push notification
                     */

                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New UAUC ' . $uauc->atar_id . ' Closed by ' . getUsername($uauc->created_by),
                        'module_id' => $uauc->id,
                        'module_type' => 1,
                    ];
                    mobilePushNotification($assigned_user, $notifydata);
                }

                if ($uauc_status == UAUC_STATUS_REASSIGN) {
                    $jobowner =  decryptId($request->job_owner);
                    $jobownerDetails =  User::where('id', $jobowner)->first();
                    $userId = [$jobowner];
                    $email_id = $jobownerDetails->email;
                    //$mailsubject = 'New UAUC Assigned to you';
                    $uaucid = $uauc->atar_id;
                    $company_name = getCompanyName($uauc->uauc_company_id);
                    $locationname = getLocationName($uauc->location);
                    $sublocationname = getSpecificLocationName($uauc->specific_location);
                    $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                    $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                    /**
                     * Job Owner Email Web App Notification
                     */
                    if ($jobownerDetails != '' && $jobownerDetails != null) {
                        if ($email_id != '' || $email_id != null) {

                            $uaucdetails =  $this->uauc->selectOne($uauc->id);
                            $uaucArray  = $uaucdetails->toArray();

                            $uaucCategory = '';
                            if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                $uaucCategory = 'Positive Observation - ';
                            }
                            $uaucCategory .= $uaucdetails->atar_type;
                            $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                            $uaucArray['name'] = $jobownerDetails->name;
                            $uaucArray['email_id'] =  $email_id;
                            $uaucArray['mail_subject'] = $mailsubject;
                            $uaucArray['uaucCategory'] = $uaucCategory;
                            $uaucArray['uactfiles'] = $uactfiles;



                            Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                        }

                        /**
                         * Send Web notification
                         */

                        $notificationData = array(
                            'notification_type' => 1,
                            'module_type' => 1,
                            'notification_message' => $mailsubject,
                            'mobile_notification' => json_encode(array(
                                'title' => $mailsubject,
                                'message' => 'New UAUC ' . $uauc->atar_id . ' Assigned by ' . getUsername($uauc->created_by),
                                'icon' => 'public/assets/images/notification/uauc.png',
                                'id' => $uauc->id,
                                'module' => 1,
                            )),
                            'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                            'assigned_user' => array_to_string($userId),
                            'created_by' => Auth::id(),
                        );
                        notificationSave($notificationData);

                        /**
                         * Send Mobile Push notification
                         */

                        $notifydata = [
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Assigned by ' . getUsername($uauc->created_by),
                            'module_id' => $uauc->id,
                            'module_type' => 1,
                        ];
                        mobilePushNotification($userId, $notifydata);
                    }
                }
                if ($uauc_status == UAUC_STATUS_IRRELEVANT) {
                    //$mailsubject = "UAUC IRRELEVANT";
                    $uaucid = $uauc->atar_id;
                    $company_name = getCompanyName($uauc->uauc_company_id);
                    $locationname = getLocationName($uauc->location);
                    $sublocationname = getSpecificLocationName($uauc->specific_location);
                    $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                    $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                    $CreaterUserId = $uauc_old->created_by;
                    $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
                    $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
                    $assigned_user = array_unique($assigned_user);
                    $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                        ->orWhere('id', $CreaterUserId)
                        ->select('name', 'email')
                        ->get()
                        ->unique('email');

                    /**
                     * Email Web App Notification
                     */
                    if ($Assignedusers != null) {

                        foreach ($Assignedusers as $user) {

                            $email_id = $user->email;
                            if ($email_id != '' || $email_id != null) {

                                $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                $uaucArray  = $uaucdetails->toArray();

                                $uaucCategory = '';
                                if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                    $uaucCategory = 'Positive Observation - ';
                                }
                                $uaucCategory .= $uaucdetails->atar_type;
                                $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                $uaucArray['name'] = $user->name;
                                $uaucArray['email_id'] =  $email_id;
                                $uaucArray['mail_subject'] = $mailsubject;
                                $uaucArray['uaucCategory'] = $uaucCategory;
                                $uaucArray['uactfiles'] = $uactfiles;



                                Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                            }
                        }
                    }

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 1,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Irrelevant by ' . getUsername(Auth::id()),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $uauc->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                        'assigned_user' => array_to_string($assigned_user),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Irrelevant by ' . getUsername(Auth::id()),
                        'module_id' => $uauc->id,
                        'module_type' => 1,
                    ];
                    mobilePushNotification($assigned_user, $notifydata);
                }

                if ($uauc_status == UAUC_STATUS_DUPLICATE) {
                    //$mailsubject = "UAUC Duplicate";
                    $uaucid = $uauc->atar_id;
                    $company_name = getCompanyName($uauc->uauc_company_id);
                    $locationname = getLocationName($uauc->location);
                    $sublocationname = getSpecificLocationName($uauc->specific_location);
                    $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                    $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                    $CreaterUserId = $uauc_old->created_by;
                    $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
                    $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
                    $assigned_user = array_unique($assigned_user);
                    $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                        ->orWhere('id', $CreaterUserId)
                        ->select('name', 'email')
                        ->get()
                        ->unique('email');

                    /**
                     * Email Web App Notification
                     */
                    if ($Assignedusers != null) {

                        foreach ($Assignedusers as $user) {

                            $email_id = $user->email;
                            if ($email_id != '' || $email_id != null) {

                                $uaucdetails =  $this->uauc->selectOne($uauc->id);
                                $uaucArray  = $uaucdetails->toArray();

                                $uaucCategory = '';
                                if (in_array($uaucdetails->uauc_category, [1, 2])) {
                                    $uaucCategory = 'Positive Observation - ';
                                }
                                $uaucCategory .= $uaucdetails->atar_type;
                                $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                                $uaucArray['name'] = $user->name;
                                $uaucArray['email_id'] =  $email_id;
                                $uaucArray['mail_subject'] = $mailsubject;
                                $uaucArray['uaucCategory'] = $uaucCategory;
                                $uaucArray['uactfiles'] = $uactfiles;



                                Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                            }
                        }
                    }

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 1,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Duplicate Entry by ' . getUsername(Auth::id()),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $uauc->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                        'assigned_user' => array_to_string($assigned_user),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Duplicate Entry by ' . getUsername(Auth::id()),
                        'module_id' => $uauc->id,
                        'module_type' => 1,
                    ];
                    mobilePushNotification($assigned_user, $notifydata);
                }

                $this->statuslog->store($status);

                if ($uauc != null && $uauc != '') {

                    $uauc_status = decryptId($request->uauc_status);

                    if ($uauc_status == 5 || $uauc_status == 7) {
                        $this->uaucfiles->store($uauc);
                    }
                }


                Session::flash('success', 'UAUC Updated successfully!');
            } catch (Exception $ex) {
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('atar/uauc/list'));
        } catch (Exception $ex) {

            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('atar/uauc/list'));
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

            $this->uauc->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'Location status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->uauc->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->uauc->exportdata();

            $header = [
                'No.',
                // 'Timestamp',
                'Reported By',
                'Email',
                'Date',
                'Assigned Company',
                'Assigned Department',
                'Assigned Division',
                'User Company',
                'User Department',
                'User Division',
                'Job Owner / Area Owner',
                'Location',
                'UAUC Category',
                'HSE Issues',
                'UAUC Description',
                'Action',
                'Description of Action Taken',
                'Upload Photo(s)',
                'Status',
            ];

            $i = 1;
            foreach ($allData as $data) {

                $export = [];

                $export[] =  $i;
                // $export[] =  Displaydatetimeformat($data->created_at);
                $export[] =  $data->name;
                $export[] =  $data->email;
                $export[] =  Displaydateformat($data->dateandtime);
                $export[] =  $data->company_name;
                $export[] =  getDepartmentName($data->department);
                $export[] =  $data->division_name;
                $export[] =  getCompanyName($data->user_company);
                $export[] =  getDepartmentName($data->user_department);
                $export[] =  getDivisionName($data->user_division);
                $export[] =  $data->company_name;
                $export[] =  $data->location_name;
                $export[] =  $data->atar_type;
                $export[] =  $data->hover_msg;
                $export[] =  $data->usee_remarks;
                $export[] =  $data->action_taken_details;
                $export[] =  $data->uact_remarks;

                $id = $data->id;
                $uactfiles = $this->uaucfiles->getfiles($id, 2);
                $filedetails = [];
                foreach ($uactfiles as $file) {
                    $filedetails[] = url($file->file_path);
                }

                $images = array_to_string($filedetails, ", ");
                $export[] =  $images;

                $export[] =  $data->atar_status;

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('UAUC List.xlsx')
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

            $allData = $this->uauc->exportdata();

            $header = [
                'No.',
                'UAUC ID',
                'UAUC Type',
                'Assigned Company',
                'Assigned Department',
                'Location',
                'Specific Location',
                'User Company',
                'User Department',
                'User Division',
                'Status',
                'Created Date',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "UAUC Details",
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

            $view = view('atar.uauc.pdf', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = "UAUC List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $uauc = $this->uauc->selectOne($id);
            $userInfo = User::find($uauc->created_by);

            $companyDetails = $this->company->getAllCompany();

            $useefiles = $this->uaucfiles->getfiles($id, 1);
            $uactfiles = $this->uaucfiles->getfiles($id, 2);
            $finalfiles = $this->uaucfiles->getfiles($id, 3);

            $uauc_status = $this->uaucstatus->getstatus($uauc->atar_status_id);
            $uauc_status_log =  $this->statuslog->getatarstatus($uauc->id);



            $data = array(
                'uauc' => $uauc,
                'useefiles' => $useefiles,
                'uactfiles' => $uactfiles,
                'finalfiles' => $finalfiles,
                'uauc_status' => $uauc_status,
                'uauc_status_log' => $uauc_status_log,
                'userInfo' => $userInfo,
                'companyDetails' => $companyDetails,
                'pagetitle' => $uauc->atar_id,
            );

            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'default_font' => 'arial',

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('atar.uauc.pdf.uauc', $data);
            $html = $view->render();



            $mpdf->WriteHTML($html);

            $filename = $uauc->atar_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
        }
    }


    public function hseSubmit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $uauc_old = $this->uauc->find($id);

            $this->uauc->hseSubmit($id);

            $uauc = $this->uauc->find($id);

            $status = [
                'id' => $uauc->id,
                'from_status' => $uauc_old->atar_status,
                'to_status' => $uauc->atar_status,
            ];

            $uaucid = $uauc->atar_id;
            $company_name = getCompanyName($uauc->uauc_company_id);
            $locationname = getLocationName($uauc->location);
            $sublocationname = getSpecificLocationName($uauc->specific_location);
            $uauccategoryname = getuauccategoryname($uauc->uauc_category);

            $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
            $CreaterUserId = $uauc_old->created_by;
            $HSEUserId =  User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')->pluck('id')->toArray();
            $assigned_user = array_merge([$CreaterUserId], $HSEUserId);
            $assigned_user = array_unique($assigned_user);
            $Assignedusers = User::whereRaw('FIND_IN_SET(' . ROLE_HSEUSER . ', role)')
                ->orWhere('id', $CreaterUserId)
                ->select('name', 'email')
                ->get()
                ->unique('email');

            /**
             * Email Web App Notification
             */
            if ($Assignedusers != null) {

                foreach ($Assignedusers as $user) {

                    $email_id = $user->email;
                    if ($email_id != '' || $email_id != null) {

                        $uaucdetails =  $this->uauc->selectOne($uauc->id);
                        $uaucArray  = $uaucdetails->toArray();

                        $uaucCategory = '';
                        if (in_array($uaucdetails->uauc_category, [1, 2])) {
                            $uaucCategory = 'Positive Observation - ';
                        }
                        $uaucCategory .= $uaucdetails->atar_type;
                        $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                        $uaucArray['name'] = $user->name;
                        $uaucArray['email_id'] =  $email_id;
                        $uaucArray['mail_subject'] = $mailsubject;
                        $uaucArray['uaucCategory'] = $uaucCategory;
                        $uaucArray['uactfiles'] = $uactfiles;

                        Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                    }
                }
            }
            /**
             * Send Web notification
             */
            $notificationData = array(
                'notification_type' => 1,
                'module_type' => 1,
                'notification_message' => $mailsubject,
                'mobile_notification' => json_encode(array(
                    'title' => $mailsubject,
                    'message' => 'New UAUC ' . $uauc->atar_id . ' Closed by ' . getUsername($uauc->created_by),
                    'icon' => 'public/assets/images/notification/uauc.png',
                    'id' => $uauc->id,
                    'module' => 1,
                )),
                'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                'assigned_user' => array_to_string($assigned_user),
                'created_by' => Auth::id(),
            );
            notificationSave($notificationData);
            /**
             * Send Mobile Push notification
             */

            $notifydata = [
                'title' => $mailsubject,
                'message' => 'New UAUC ' . $uauc->atar_id . ' Closed by ' . getUsername($uauc->created_by),
                'module_id' => $uauc->id,
                'module_type' => 1,
            ];
            mobilePushNotification($assigned_user, $notifydata);

            $this->uaucfiles->store($uauc);
            $this->statuslog->store($status);

            Session::flash('success', 'HSE Consequence Submitted successfully');
            return redirect(admin_url('atar/uauc/list'));
        } catch (Exception $ex) {
            Session::flash('error', 'Please try after some time');
            return redirect(admin_url('atar/uauc/list'));
        }
    }

    public function UAUCCloseRemainderSecondWeek()
    {
        $twoWeeksAgo = Carbon::now()->subWeeks(2)->toDateString();

        $uauc_details = $this->uauc->whereIn('uauc_category', [3, 4])
            ->where(function ($query) use ($twoWeeksAgo) {
                $query->whereDate('created_at', $twoWeeksAgo);
            })
            ->get();

        foreach ($uauc_details as $uauc) {
            $jobowner = $uauc->jobowner;


            $uaucid = $uauc->atar_id;
            $company_name = getCompanyName($uauc->uauc_company_id);
            $locationname = getLocationName($uauc->location);
            $sublocationname = getSpecificLocationName($uauc->specific_location);
            $uauccategoryname = getuauccategoryname($uauc->uauc_category);

            $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
            $assigned_user = $jobowner;
            $user = User::where('id', $jobowner)
                ->select('name', 'email')
                ->first();

            /**
             * Email Web App Notification
             */
            if ($user != null) {

                $email_id = $user->email;
                if ($email_id != '' || $email_id != null) {

                    $uaucdetails =  $this->uauc->selectOne($uauc->id);
                    $uaucArray  = $uaucdetails->toArray();

                    $uaucCategory = '';
                    if (in_array($uaucdetails->uauc_category, [1, 2])) {
                        $uaucCategory = 'Positive Observation - ';
                    }
                    $uaucCategory .= $uaucdetails->atar_type;
                    $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                    $uaucArray['name'] = $user->name;
                    $uaucArray['email_id'] =  $email_id;
                    $uaucArray['mail_subject'] = $mailsubject;
                    $uaucArray['uaucCategory'] = $uaucCategory;
                    $uaucArray['uactfiles'] = $uactfiles;
                    $uaucArray['weeks'] = 2;

                    Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                }
            }

            /**
             * Send Web notification
             */

            $notificationData = array(
                'notification_type' => 1,
                'module_type' => 1,
                'notification_message' => $mailsubject,
                'mobile_notification' => json_encode(array(
                    'title' => $mailsubject,
                    'message' => 'Second Week Remainder of UAUC ' . $uauc->atar_id,
                    'icon' => 'public/assets/images/notification/uauc.png',
                    'id' => $uauc->id,
                    'module' => 1,
                )),
                'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                'assigned_user' => $assigned_user,
                'created_by' => Auth::id(),
            );
            notificationSave($notificationData);

            /**
             * Send Mobile Push notification
             */

            $notifydata = [
                'title' => $mailsubject,
                'message' =>  'Second Week Remainder of UAUC ' . $uauc->atar_id,
                'module_id' => $uauc->id,
                'module_type' => 1,
            ];
            mobilePushNotification([$assigned_user], $notifydata);
        }
    }

    public function UAUCCloseRemainderFourthWeek()
    {
        $fourWeeksAgo = Carbon::now()->subWeeks(4)->toDateString();

        $uauc_details = $this->uauc->whereIn('uauc_category', [3, 4])
            ->where(function ($query) use ($fourWeeksAgo) {
                $query->whereDate('created_at', $fourWeeksAgo);
            })
            ->get();

        foreach ($uauc_details as $uauc) {
            $jobowner = $uauc->jobowner;


            $uaucid = $uauc->atar_id;
            $company_name = getCompanyName($uauc->uauc_company_id);
            $locationname = getLocationName($uauc->location);
            $sublocationname = getSpecificLocationName($uauc->specific_location);
            $uauccategoryname = getuauccategoryname($uauc->uauc_category);

            $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
            $assigned_user = $jobowner;
            $user = User::where('id', $jobowner)
                ->select('name', 'email')
                ->first();

            /**
             * Email Web App Notification
             */
            if ($user != null) {

                $email_id = $user->email;
                if ($email_id != '' || $email_id != null) {

                    $uaucdetails =  $this->uauc->selectOne($uauc->id);
                    $uaucArray  = $uaucdetails->toArray();

                    $uaucCategory = '';
                    if (in_array($uaucdetails->uauc_category, [1, 2])) {
                        $uaucCategory = 'Positive Observation - ';
                    }
                    $uaucCategory .= $uaucdetails->atar_type;
                    $uactfiles = $this->uaucfiles->getfiles($uauc->id, 2);

                    $uaucArray['name'] = $user->name;
                    $uaucArray['email_id'] =  $email_id;
                    $uaucArray['mail_subject'] = $mailsubject;
                    $uaucArray['uaucCategory'] = $uaucCategory;
                    $uaucArray['uactfiles'] = $uactfiles;
                    $uaucArray['weeks'] = 4;

                    Mail::to($uaucArray['email_id'])->queue(new UAUCStatusEmail($uaucArray));
                }
            }

            /**
             * Send Web notification
             */

            $notificationData = array(
                'notification_type' => 1,
                'module_type' => 1,
                'notification_message' => $mailsubject,
                'mobile_notification' => json_encode(array(
                    'title' => $mailsubject,
                    'message' => 'Fourth Week Remainder of UAUC ' . $uauc->atar_id,
                    'icon' => 'public/assets/images/notification/uauc.png',
                    'id' => $uauc->id,
                    'module' => 1,
                )),
                'web_link' =>  admin_url('atar/uauc/view/' . encryptId($uauc->id)),
                'assigned_user' => $assigned_user,
                'created_by' => Auth::id(),
            );
            notificationSave($notificationData);

            /**
             * Send Mobile Push notification
             */

            $notifydata = [
                'title' => $mailsubject,
                'message' =>  'Fourth Week Remainder of UAUC ' . $uauc->atar_id,
                'module_id' => $uauc->id,
                'module_type' => 1,
            ];
            mobilePushNotification([$assigned_user], $notifydata);
        }
    }
}

