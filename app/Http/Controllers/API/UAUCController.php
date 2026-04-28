<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;
use Mail;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\ATAR\UAUC;
use App\Models\ATAR\UAUCFile;
use App\Models\ATAR\UAUCFileStatusLog;

use App\Models\ATAR\HSEHazard;
use App\Models\ATAR\ActionTaken;
use App\Models\ATAR\Infringement;

use App\Mail\UAUC\UAUCStatusEmail;
use Illuminate\Support\Facades\Log;


class UAUCController extends BaseController
{
    /**
     * UAUC api
     *
     * @return \Illuminate\Http\Response
     */

    private $uauc;
    private $uaucfiles;
    private $statuslog;
    private $hsehazard;
    private $actiontaken;
    private $infringement;


    public function __construct()
    {

        $this->uauc = new UAUC();
        $this->uaucfiles = new UAUCFile();
        $this->statuslog = new UAUCFileStatusLog;
        $this->hsehazard = new HSEHazard();
        $this->actiontaken = new ActionTaken();
        $this->infringement = new Infringement();
    }


    public function list(Request $request): JsonResponse
    {

        try {
            if (Auth::user()) {

                $search = '';
                if ($request->has('search')) {
                    if ($request->search != '' && $request->search != null) {
                        $search = $request->search;
                    }
                }

                $uauc_list_array = UAUC::select('*');

                if ($search != '') {
                    $uauc_list_array = $uauc_list_array->orWhere('atar_id', "LIKE", "%" . $search . "%");
                    $uauc_list_array = $uauc_list_array->orWhere('master_company.company_name', "LIKE", "%" . $search . "%");
                    $uauc_list_array = $uauc_list_array->orWhere('atar_master_atar_types.atar_type', "LIKE", "%" . $search . "%");
                }


                /**
                 * Role Based list view condition start
                 */

                if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN)) {
                    $uauc_list_array = $uauc_list_array->where('atar_uauc.status', 1);
                } else {
                    if (CheckUserRole(ROLE_JOBOWNER)) {

                        $uauc_list_array->where(function ($query) use ($search) {
                            $query->orWhere('atar_uauc.job_owner', Auth::id())
                                ->orWhere('atar_uauc.reassign_job_owner', Auth::id())
                                ->orWhere('atar_uauc.created_by', Auth::id());
                        });
                    }

                    if (CheckUserRole(ROLE_CONTRACTORADMIN)) {

                        $uauc_list_array = $uauc_list_array->where('atar_uauc.created_by', Auth::id());
                    }

                    if (CheckUserRole(ROLE_UAUC_CREATOR)   || CheckUserRole(ROLE_CONTRACTORUSER)) {

                        $uauc_list_array = $uauc_list_array->where('atar_uauc.created_by', Auth::id());
                    }
                }

                /**
                 * Role Based list view condition end
                 */

                if ($request->company != '' && $request->company != null) {
                    $company = $request->company;
                    $uauc_list_array = $uauc_list_array->where('atar_uauc.company', $company);
                }

                if ($request->status != '' && $request->status != null) {
                    $status = decryptId($request->status);
                    $uauc_list_array = $uauc_list_array->where('atar_uauc.atar_status', $status);
                }

                $uauc_list_array = $uauc_list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

                $uauc_list = $uauc_list_array->toArray();

                $data_array = [];
                foreach ($uauc_list_array as $listdata) {
                    $data = [];

                    $data['id'] = $listdata->id;
                    $data['atar_id'] = $listdata->atar_id;
                    $data['location'] = $listdata->locationInfo?->location_name;
                    $data['specific_location'] = $listdata->specificLocationInfo?->specific_loc_name;
                    $data['uauc_category'] = $listdata->ucucCategoryInfo?->atar_type;
                    $data['description'] = $listdata->usee_remarks;
                    $data['status'] = $listdata->statusInfo?->atar_status;
                    $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                    $data_array[] = $data;
                }

                $uauc_details = [
                    'per_page' => $uauc_list['per_page'],
                    'current_page' => $uauc_list['current_page'],
                    'from' => $uauc_list['from'],
                    'to' => $uauc_list['to'],
                    'total' => $uauc_list['total'],
                    'total_page' => $uauc_list['last_page'],
                    'list' => $data_array,
                ];

                $success = [
                    'uauc_details' => $uauc_details
                ];

                return $this->sendResponse($success, 'UAUC Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function add(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $action_type =   $this->actiontaken->select('id', 'atar_type as action_taken')->orderBy('sort_order', 'ASC')->get()->toArray();

                $success = [
                    'uauc_category' => [
                        '0' => 'Positive Observation',
                        '3' => 'Unsafe Act',
                        '4' => 'Unsafe Condition',
                    ],
                    'uauc_category_po' => [
                        '1' => 'Safe Act',
                        '2' => 'Safe Condition',
                    ],
                    'action_type' => $action_type

                ];

                return $this->sendResponse($success, 'UAUC Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function hseHazard(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $uauc_category = $request->uauc_category;
                $hsehazard = $this->hsehazard->ajaxListAPI($uauc_category);

                $success = [

                    'hsehazard' => $hsehazard,
                ];

                return $this->sendResponse($success, 'HSE Hazard Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function infringement(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $uauc_category = $request->uauc_category;

                $infringementDetails = $this->infringement->get();

                $infringementList = [];
                $i = 0;
                foreach ($infringementDetails as $infringement) {

                    $infringementList[$i]['id'] = $infringement->id;
                    $infringementList[$i]['value'] = $infringement->infringement_no . ' - ' . $infringement->type_of_infringement;
                    $i++;
                }

                $success = [

                    'infringement' => $infringementList,
                ];

                return $this->sendResponse($success, 'HSE Hazard Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function store(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $rules = [
                    'location' => 'required',
                    'specific_location' => 'required',
                    'uauc_category' => 'required',
                    'hse_hazard' => 'required',
                    'usee_remarks' => 'required',
                ];
                $messages = [
                    'location.required' => 'Please select Location',
                    'specific_location.required' => 'Please select Specific Location',
                    'uauc_category.required' => 'Please select UAUC Category',
                    'hse_hazard.required' => 'Please select HSE Hazard',
                    'usee_remarks.required' => 'Please enter U-See Remarks',
                ];


                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    return $this->sendError('Validation Error', $validator->errors(), 422);
                }


                $location = $request->location;
                $specific_location = $request->specific_location;

                $uauc_category = $request->uauc_category;
                $usee_remarks = $request->usee_remarks;

                $action_taken =  $company = $division = $department = $job_owner = $violators_email = $infringement = $uact_remarks = $ssds_serial_number = null;

                $atar_status = 1;

                if ($uauc_category == 1 || $uauc_category == 2) {

                    $uauc_category = $request->uauc_category_po;
                    $atar_status = 5;
                } else {
                    $action_taken =  $request->action_taken;
                    $company =  $request->company;
                    $division =  $request->division;
                    $department =  $request->department;
                    $job_owner =  $request->job_owner;
                }

                switch ($action_taken) {

                    case 2:
                        $atar_status = 5;
                        $uact_remarks = $request->uact_remarks;
                        break;
                    case 3:
                        $uact_remarks = $request->uact_remarks;
                        $infringement = $request->infringement;
                        $infringement_name = getinfrIngementName($infringement);
                        $violators_email = $request->violators_email;
                        $ssds_serial_number = $request->ssds_serial_number;

                        if ($violators_email != '') {
                            $email = "[" . $violators_email . ']';
                        } else {
                            $email = '';
                        }

                        $uact_remarks = $infringement_name . ";" . 'S/NO - ' . $ssds_serial_number . " " . $email;

                        break;
                    case 1:
                    case 4:
                        $uact_remarks = $request->uact_remarks;
                        break;
                    default:
                        break;
                }

                $insert_array = array(
                    'location' => $location,
                    'specific_location' => $specific_location,
                    'other_speclocation' => $request->others_location,
                    'uauc_category' => $uauc_category,
                    'hse_hazard' => $request->hse_hazard,
                    'usee_remarks' => $usee_remarks,
                    'action_taken' => $action_taken,
                    'company' => $company,
                    'division' => $division,
                    'department' => $department,
                    'job_owner' => $job_owner,
                    'violators_email' => $violators_email,
                    'ssds_serial_number' => $ssds_serial_number,
                    'infringement' => $infringement,
                    'dateandtime' => DBdateformat($request->uauc_date),
                    'uact_remarks' => Str::upper($uact_remarks),
                    'atar_status' => $atar_status,
                    'created_by' => Auth::id(),
                );

                $uauc = $this->uauc->create($insert_array);

                if ($uauc) {

                    $this->uaucfiles->imageupload($uauc);

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

                    if ($uauc->uauc_category == 3 || $uauc->uauc_category == 4) {

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

                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';

                        //$mailsubject = 'New UAUC Created and Assigned to you';
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
                } else {

                    return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
                }

                $success = [
                    'uauc_id' => $uauc->atar_id
                ];

                return $this->sendResponse($success, 'UAUC successfully created');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {


                $id = $request->id;

                $uauc = $this->uauc->selectOne($id);

                $userInfo = User::find($uauc->created_by);
                $useefiles = $this->uaucfiles->getfiles($id, 1);
                $uactfiles = $this->uaucfiles->getfiles($id, 2);
                $finalfiles = $this->uaucfiles->getfiles($id, 3);
                $hscfiles = $this->uaucfiles->getfiles($id, 4);

                $uauc_status_log =  $this->statuslog->getatarstatus($uauc->id);

                $general_information = array(
                    'reporter_name' => $userInfo->name,
                    'reporter_email' => $userInfo->email,
                    'reporter_company' => $userInfo->companyInfo->company_name,
                    'reporter_division' => $userInfo->divisionInfo->division_name,
                    'reporter_department' => $userInfo->departmentInfo->department_name,
                    'reporter_datetime' => displayDatetimeformat($uauc->created_at),
                );

                $location_details = array(
                    'location' => $uauc->location_name,
                    'specific_location' => $uauc->specific_loc_name,
                );

                $category_name = '';
                if (in_array($uauc->uauc_category, [1, 2]))
                    $category_name =   'Positive Observation - ';

                $category_name =    $uauc->atar_type;

                $uauc_category = array(
                    'uauc_id' => $uauc->atar_id,
                    'uauc_date' => displayDateformat($uauc->dateandtime),
                    'category_id' => $uauc->uauc_category,
                    'category_name' => $category_name,
                    'hse_hazard' => $uauc->hse_hazard,
                    'description' => $uauc->hover_msg,
                    'zefa_rule' => $uauc->zefa_rule,
                    'remarks' => $uauc->usee_remarks,
                );

                $action_taken = [];
                if (!in_array($uauc->uauc_category, [1, 2])) {

                    $actionTakenImages = [];

                    if (count($uactfiles) > 0) {
                        foreach ($uactfiles as $uact) {
                            $actionTakenImages[] =  url($uact->file_path);
                        }
                    }

                    $action_taken = array(
                        'action_taken' => $uauc->action_taken,
                        'action_taken_details' => $uauc->action_taken_details,
                        'company' => $uauc->company_name,
                        'division' => $uauc->division_name,
                        'department' => $uauc->department_name,
                        'job_owner' => getusername($uauc->job_owner),
                        'violators_email' => $uauc->violators_email,
                        'infringement' =>  $uauc->infringement_no . " - " . $uauc->type_of_infringement,
                        'ssds_serial_number' => $uauc->ssds_serial_number,
                        'actiontakendescription' => $uauc->uact_remarks,
                        'action_taken_images' => $actionTakenImages,
                    );
                }

                $status_history = [];
                $status_history[] = array(
                    'status' => 'Pending',
                    'name' => getUser($uauc->created_by)->name,
                    'designation' => getUser($uauc->created_by)->user_designation_name,
                    'date' => displayDateformat($uauc->created_at),
                    'time' => Displaytimeformat($uauc->created_at),
                    'description' => null,
                );

                foreach ($uauc_status_log as $statusLog) {

                    $status_history[] = array(
                        'status' => $statusLog->statusToInfo->atar_status,
                        'name' => $statusLog->userInfo->name,
                        'designation' => $statusLog->userInfo->user_designation_name,
                        'date' => displayDateformat($statusLog->created_at),
                        'time' => Displaytimeformat($statusLog->created_at),
                        'description' => $statusLog->status_description,
                    );
                }

                $useeImages = [];

                if (count($uactfiles) > 0) {
                    foreach ($uactfiles as $usee) {
                        $useeImages[] =  url($usee->file_path);
                    }
                }

                $closeImages = [];

                if (count($finalfiles) > 0) {
                    foreach ($finalfiles as $final) {
                        $closeImages[] =  url($final->file_path);
                    }
                }

                $consequenceImages = [];

                if (count($hscfiles) > 0) {
                    foreach ($hscfiles as $hsc) {
                        $consequenceImages[] =  url($hsc->file_path);
                    }
                }

                $success = array(
                    'uauc_status_id' => $uauc->atar_status_id,
                    'uauc_status' => $uauc->atar_status,
                    'general_information' => $general_information,
                    'location_details' => $location_details,
                    'uauc_category' => $uauc_category,
                    'action_taken' => $action_taken,
                    'status_history' => $status_history,
                    'close_images' => $closeImages,
                    'useeImages' => $useeImages,
                    'consequenceImages' => $consequenceImages,
                );


                return $this->sendResponse($success, 'UAUC Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function statuslist(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $status = $request->status;
                $uauc_status = [];
                switch ($status) {

                    case UAUC_STATUS_PENDING:
                        $uauc_status = [
                            [
                                'id' => '2',
                                'name' => 'Accept',
                            ],
                            [
                                'id' => '3',
                                'name' => 'Reassign',
                            ],
                            [
                                'id' => '4',
                                'name' => 'Irrelevant',
                            ],
                        ];
                        break;
                    case UAUC_STATUS_ACCEPT:
                        $uauc_status = [
                            [
                                'id' => '5',
                                'name' => 'Close',
                            ],
                        ];
                        break;
                    case UAUC_STATUS_IRRELEVANT;
                        $uauc_status = [];
                        break;
                    case UAUC_STATUS_REASSIGN:
                        $uauc_status = [
                            [
                                'id' => '2',
                                'name' => 'Accept',
                            ],
                            [
                                'id' => '4',
                                'name' => 'Irrelevant',
                            ],
                        ];
                        break;
                    case UAUC_STATUS_CLOSE:
                        $uauc_status = [];
                        break;
                    default:
                        $uauc_status = [];
                        break;
                }

                return $this->sendResponse($uauc_status, 'UAUC Status Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            report($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }


    public function statusupdate(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {

                $id = $request->id;

                $uauc = $this->uauc->find($id);
                $status = $request->status;

                if ($status == UAUC_STATUS_CLOSE) {
                    $uauc = $this->uauc->where('id', $id)->first();
                    if ($uauc->action_taken == 3) {
                        $status = UAUC_STATUS_HSC_ACTION_PENDING;
                    }
                }


                $remarks = $request->remarks;
                $uauc_status = [];

                $update_array = array();

                $update_array['atar_status'] = $uauc_status;


                switch ($status) {

                    case UAUC_STATUS_ACCEPT:

                        $update_array['atar_status'] =  UAUC_STATUS_ACCEPT;
                        $update_array['accept_desc'] =  $remarks;

                        $this->uauc->where('id', $id)->update($update_array);
                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' => $uauc->atar_status,
                            'to_status' => UAUC_STATUS_ACCEPT,
                            'status_description' =>  $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        /***
                         * Notification
                         */
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        // $mailsubject = "UAUC Closure Pending";
                        $CreaterUserId = $uauc->created_by;
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


                        break;
                    case  UAUC_STATUS_REASSIGN:

                        if ($request->job_owner == null || $request->job_owner == "") {
                            return $this->sendError('Field is required.', ['error' => 'Please select JobOwner'], 400);
                        }
                        $update_array['atar_status'] =  UAUC_STATUS_REASSIGN;
                        $update_array['reassign_company'] = $request->company;
                        $update_array['reassign_division'] = $request->division;
                        $update_array['reassign_department'] = $request->department;
                        $update_array['reassign_job_owner'] = $request->job_owner;
                        $update_array['reassign_desc'] =  $remarks;

                        $this->uauc->where('id', $id)->update($update_array);

                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' =>  $uauc->atar_status,
                            'to_status' => UAUC_STATUS_REASSIGN,
                            'status_description' =>  $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        /***
                         * Notification
                         */
                        $jobowner =  decryptId($request->job_owner);
                        $jobownerDetails =  User::where('id', $jobowner)->first();
                        $userId = [$jobowner];
                        $email_id = $jobownerDetails->email;
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        // $mailsubject = 'New UAUC Assigned to you';
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

                        break;
                    case UAUC_STATUS_IRRELEVANT:

                        $update_array['atar_status'] =  UAUC_STATUS_IRRELEVANT;
                        $update_array['irrelavant_desc'] = $request->irrelavant_desc;
                        $this->uauc->where('id', $id)->update($update_array);

                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' => $uauc->atar_status,
                            'to_status' => UAUC_STATUS_REASSIGN,
                            'status_description' =>  $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        /**
                         * Notification
                         */
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        //$mailsubject = "UAUC IRRELEVANT";
                        $CreaterUserId = $uauc->created_by;
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

                        break;
                    case UAUC_STATUS_CLOSE:

                        $update_array['atar_status'] =  UAUC_STATUS_CLOSE;
                        $update_array['close_desc'] =  $remarks;

                        $this->uauc->where('id', $id)->update($update_array);

                        $this->uaucfiles->imageupload($uauc);

                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' => $uauc->atar_status,
                            'to_status' => UAUC_STATUS_CLOSE,
                            'status_description' => $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        /**
                         * Notification
                         */
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        //$mailsubject = "UAUC Closed";
                        $CreaterUserId = $uauc->created_by;
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

                        break;
                    case UAUC_STATUS_DUPLICATE:

                        $update_array['atar_status'] =  UAUC_STATUS_DUPLICATE;
                        $update_array['duplicate_desc'] =  $remarks;

                        $this->uauc->where('id', $id)->update($update_array);

                        $this->uaucfiles->imageupload($uauc);

                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' => $uauc->atar_status,
                            'to_status' => UAUC_STATUS_DUPLICATE,
                            'status_description' => $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        /**
                         * Notification
                         */
                        $uaucid = $uauc->atar_id;
                        $company_name = getCompanyName($uauc->uauc_company_id);
                        $locationname = getLocationName($uauc->location);
                        $sublocationname = getSpecificLocationName($uauc->specific_location);
                        $uauccategoryname = getuauccategoryname($uauc->uauc_category);

                        $mailsubject = '[UAUC Notification - ' . $uaucid . " - " . $company_name . ' ] - ' . $uauccategoryname . ' @ ' . $locationname . ' - ' . $sublocationname . ' ';
                        //$mailsubject = "UAUC Closed";
                        $CreaterUserId = $uauc->created_by;
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
                                'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Duplicate Entry by ' . getUsername($uauc->created_by),
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
                            'message' => 'New UAUC ' . $uauc->atar_id . ' Changed to Duplicate Entry by ' . getUsername($uauc->created_by),
                            'module_id' => $uauc->id,
                            'module_type' => 1,
                        ];
                        mobilePushNotification($assigned_user, $notifydata);

                        break;

                    case UAUC_STATUS_HSC_ACTION_PENDING:

                        $update_array['atar_status'] =  UAUC_STATUS_HSC_ACTION_PENDING;
                        $update_array['close_desc'] =  $remarks;

                        $this->uauc->where('id', $id)->update($update_array);

                        $this->uaucfiles->imageupload($uauc);

                        $insert_log_array = [
                            'atar_id' => $id,
                            'from_status' => $uauc->atar_status,
                            'to_status' => UAUC_STATUS_HSC_ACTION_PENDING,
                            'status_description' => $remarks,
                            'created_by' => Auth::id(),
                        ];
                        $this->statuslog->add($insert_log_array);
                        break;

                    default:
                        $uauc_status = [];
                        break;
                }
                $uauc_status = ['message' => 'UAUC Statuc successfully updated'];

                return $this->sendResponse($uauc_status, 'UAUC Status Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function hseSubmit(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {

                $id = $request->id;

                $uauc_old = $this->uauc->find($id);

                $this->uauc->hseSubmit($id);

                $uauc = $this->uauc->find($id);

                $status = [
                    'id' => $uauc->id,
                    'from_status' => $uauc_old->atar_status,
                    'to_status' => $uauc->atar_status,
                ];


                $this->uaucfiles->imageupload($uauc);
                $this->statuslog->store($status);


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


                $uauc_status = ['message' => 'UAUC Statuc successfully updated'];

                return $this->sendResponse($uauc_status, 'UAUC Consequence Management Details');
            } else {

                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
