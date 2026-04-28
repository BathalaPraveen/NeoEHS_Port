<?php

namespace App\Http\Controllers\Incident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\ImageOptimizer\OptimizerChainFactory;


use PDF;
use Mail;
use Session;
use Exception;
use DataTables;


use App\Models\User;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Incident\{
    IncidentCategory,
    IncidentItem,
    IncidentSubItem,
    IncidentClassification,
    IncidentNotification,
    IncidentInvestigation,
    IncidentInvestigationAccident,
    IncidentInvestigationNearmiss,
    InvestigationStatus,
    InvestigationStatusLog,
    InvestigationFile
};



class IncidentInvestigationController extends Controller
{

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $category;
    private $item;
    private $subitem;
    private $classification;
    private $notification;

    private $investigation;
    private $incidentinvestigationaccident;

    private $status;
    private $statuslog;

    private $files;
    private $near_miss;
    private $accident;


    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->category = new IncidentCategory();
        $this->item = new IncidentItem();
        $this->subitem = new IncidentSubItem();
        $this->classification = new IncidentClassification();
        $this->notification = new IncidentNotification();

        $this->status = new InvestigationStatus();
        $this->statuslog = new InvestigationStatusLog();

        $this->investigation = new IncidentInvestigation();
        $this->incidentinvestigationaccident = new IncidentInvestigationAccident();

        $this->files = new InvestigationFile();
        $this->near_miss = new IncidentInvestigationNearmiss();
        $this->accident = new IncidentInvestigationAccident();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {
                try {

                    $data =  $this->investigation->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('incident_type', function ($row) {
                            return getIncidentTypeName($row->incident_type);
                        })
                        ->addColumn('location_name', function ($row) {
                            return getLocationName($row->location_id);
                        })
                        ->addColumn('investigation_status', function ($row) {
                            $text = incidentInvestigationStatus($row->investigation_status);
                            return $text;
                        })
                        ->addColumn('incident_date', function ($row) {
                            return Displaydateformat($row->incident_date);
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            $btn  = '<a href="' . admin_url('incident/investigation/view/' . encryptId($row->id)) . '"   class="" title="Incident Details"><i class="fa-regular fa-eye"></i></i></a> ';
                            if ($row->investigation_status == INCIDENT_INVESTIGATION_STATUS_NOT_ASSIGNED) {
                                $btn .= '<a href="' . admin_url('incident/investigation/assignuser/' . encryptId($row->id)) . '"   class="" title="Assign User"><i class="fa-solid fa-user"></i></a> ';
                            }

                            if ($row->investigation_status == INCIDENT_INVESTIGATION_STATUS_PENDING && (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_GHSE_APPROVER)  || Auth::id() == $row->investigator_id)) {

                                $url = '#';
                                if ($row->incident_type == ACCIDENT) {

                                    if ($row->incident_rating <= 2) {
                                        $url = 'incident/investigation/accident/minor/' . encryptId($row->id);
                                    } else {
                                        $url = 'incident/investigation/accident/major/' . encryptId($row->id);
                                    }
                                } else if ($row->incident_type == NEAR_MISS) {
                                    $url = 'incident/investigation/nearmiss/' . encryptId($row->id);
                                }

                                $btn .= '<a href="' . admin_url($url) . '"   class="" title="Assign User"><i class="fa-solid fa-clipboard-list"></i></a> ';
                            }

                            if ($row->investigation_status == INCIDENT_INVESTIGATION_NEARMISS_ADDED && (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_GHSE_APPROVER)  || Auth::id() == $row->investigator_id)) {
                                if ($row->incident_type == NEAR_MISS) {
                                    if (($row->investigation_status == INCIDENT_INVESTIGATION_NEARMISS_ADDED)) {
                                        $url = 'incident/investigation/approvereject/' . encryptId($row->id);
                                    }
                                }
                                $btn .= '<a href="' . admin_url($url) . '"   class="" title="Approval"><i class="fa-solid fa-check-to-slot"></i></a> ';
                            }

                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'investigation_status'])
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
        $status = $this->status->get();

        $data = array(
            'locationDetails' => $locationDetails,
            'statusDetails' => $status,
        );

        return view('incident.investigation.list', $data);
    }

    public function AssignUser(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $companyDetails = $this->company->getAllCompany();

            $data = [
                'investigation_id' => $id,
                'companyDetails' => $companyDetails,
            ];
            return view('incident.investigation.assignuser', $data);
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }


    public function AssignUserSubmit(Request $request)
    {


        try {

            $id = decryptId($request->id);

            $investigation = $this->investigation->find($id);

            $this->investigation->assignUser($id);

            $status = INCIDENT_INVESTIGATION_STATUS_PENDING;
            $is_reject = 0;


            $investigation_id = $investigation->id;

            $insert_array = array(
                'investigation_id' => $investigation_id,
                'from_status' => INCIDENT_INVESTIGATION_STATUS_NOT_ASSIGNED,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);



            Session::flash('success', 'Incident successfully Assigned');
            return redirect('incident/investigation/list');
        } catch (Exception $ex) {

            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/investigation/list'));
        }
    }


    public function Add(Request $request)
    {
        try {

            $investigation_id = decryptId($request->id);
            $type = $request->type;

            $investigation = $this->investigation->find($investigation_id);
            $notification =  $this->notification->find($investigation->inc_id);

            $companyDetails = $this->company->getAllCompany();
            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->getAllSpecificLocation();
            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);
            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);
            $rootcausecategoryList = $this->item->getlist(ROOT_CAUSE_CATEGORY);
            $classificationList = $this->classification->getList();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,
                'rootcausecategoryList' => $rootcausecategoryList,
                'investigation_id' => $investigation_id,
                'type' => $type,
                'investigation' => $investigation,
                'IncidentDetails' => $notification,
            );

            return view('incident.investigation.add', $data);
        } catch (Exception $ex) {
            dd($ex);
            report($ex);
        }
    }

    public function AddNearMiss(Request $request)
    {
        try {


            $investigation_id = decryptId($request->id);

            $investigation = $this->investigation->find($investigation_id);
            $notification =  $this->notification->find($investigation->inc_id);


            $companyDetails = $this->company->getAllCompany();
            $locationDetails = $this->location->getAllLocation();
            $specificlocationDetails = $this->specificlocation->get();
            $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
            $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
            $locationList = $this->item->getlist(LOCATION);
            $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
            $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
            $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
            $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
            $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);
            $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);
            $rootcausecategoryList = $this->item->getlist(ROOT_CAUSE_CATEGORY);
            $classificationList = $this->classification->getList();

            $data = array(
                'companyDetails' => $companyDetails,
                'locationDetails' => $locationDetails,
                'specificlocationDetails' => $specificlocationDetails,
                'emergencyincidenttireList' => $emergencyincidenttireList,
                'weatherconditionList' => $weatherconditionList,
                'locationList' => $locationList,
                'incidentpotentialList' => $incidentpotentialList,
                'authoritiesinformList' => $authoritiesinformList,
                'incidentclassificationList' => $incidentclassificationList,
                'typeofnotificationList' => $typeofnotificationList,
                'categoryofincidentList' => $categoryofincidentList,
                'subcategoryofincidentList' => $subcategoryofincidentList,
                'classificationList' => $classificationList,
                'rootcausecategoryList' => $rootcausecategoryList,
                'investigation_id' => $investigation_id,
                'investigation' => $investigation,
                'IncidentDetails' => $notification,

            );

            return view('incident.investigation.addnearmiss', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function nearMissSubmit(Request $request)
    {
        try {

            $rules = [
                'employee_involved' => 'required',
                'immediate_supervisor' => 'required',
                'description_of_hazard' => 'required',
                'immediate_action' => 'required',
                'nearmiss_status' => 'required|integer',
                'action_taken' => 'required',
                'why_why_analysis' => 'required',
                'root_cause' => 'required',
                'root_cause_category' => 'required',
                'investigation_remarks' => 'required',
            ];

            $messages = [
                'employee_involved.required' => 'Please specify the employee(s) involved.',
                'immediate_supervisor.required' => 'Immediate supervisor field is required.',
                'description_of_hazard.required' => 'Please provide a description of the hazard.',
                'immediate_action.required' => 'Immediate action taken is required.',
                'nearmiss_status.required' => 'Near miss status is required.',
                'nearmiss_status.integer' => 'Near miss status must be a valid number.',
                'action_taken.required' => 'Please specify the action taken.',
                'why_why_analysis.required' => 'Why-Why analysis field is required.',
                'root_cause.required' => 'Root cause must be provided.',
                'root_cause_category.required' => 'Please select a root cause category.',
                'investigation_remarks.required' => 'Please enter investigation remarks.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $id = decryptId($request->id);


            try {

                $investigation = $this->investigation->find($id);
                $notification = $this->notification->find($investigation->inc_id);

                if ($investigation) {

                    $this->near_miss->store($notification);

                    if ($request->nearmiss_status == 1) {
                        $investigation_status = INCIDENT_INVESTIGATION_NEARMISS_ADDED;
                    } else {
                        $investigation_status = INCIDENT_INVESTIGATION_STATUS_INVESTIGATION_COMPLETED;
                    }

                    $investigation = $this->investigation->where('id', $id)->update(['investigation_status' => $investigation_status]);

                    $insert_array = array(
                        'investigation_id' => $id,
                        'from_status' => INCIDENT_INVESTIGATION_STATUS_PENDING,
                        'to_status' => $investigation_status,
                        'is_reject' => 0,
                        'remarks' => $request->investigation_remarks,
                        'created_by' => Auth::id(),
                    );
                    $this->statuslog->create($insert_array);

                    /**
                     * Send Email Notification
                     */

                    $email_id = 'gowtham.ardhas@gmail.com';

                    $mailsubject = 'Incident Investigation Completed';



                    if ($email_id != '' || $email_id != null) {

                        $investigationdetails =  $this->investigation->selectOne($id);
                        $inspectionArray  = $investigationdetails->toArray();


                        $inspectionArray['name'] = 'Gowtham';
                        $inspectionArray['email_id'] =  $email_id;
                        $inspectionArray['mail_subject'] = $mailsubject;

                        //  Mail::to($inspectionArray['email_id'])->queue(new MachineryEmail($inspectionArray));
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
                            'message' => 'Incident Invesigation ' . $investigationdetails->investigation_id . ' Near Miss added by ' . getUsername(Auth::id()),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $investigationdetails->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('incident/investigation/view/' . encryptId($investigationdetails->id)),
                        'assigned_user' => array_to_string([1]),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = [1];
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Incident Invesigation ' . $investigationdetails->investigation_id . ' Near Miss added by ' . getUsername(Auth::id()),
                    ];
                    mobilePushNotification($userId, $notifydata);


                    Session::flash('success', 'Near Miss Added successfully !');
                } else {

                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {
                dd($ex, 'error');
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('incident/investigation/list'));
        } catch (Exception $ex) {
            dd($ex, 'error');
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/investigation/list'));
        }
    }

    public function Store(Request $request)
    {
        try {

            $rules = [
                'investigation_remarks' => 'required',
            ];
            $messages = [
                'investigation_remarks.required' => 'Please enter Inspection Remarks',
            ];



            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {

                return redirect()->back()->withErrors($validator)->withInput();
            }

            $id = decryptId($request->id);


            try {

                $investigation = $this->investigation->find($id);
                $notification = $this->notification->find($investigation->inc_id);

                if ($investigation) {

                    $this->incidentinvestigationaccident->store($investigation, $notification);

                    $this->files->store($investigation);

                    $investigation = $this->investigation->where('id', $id)->update(['investigation_status' => INCIDENT_INVESTIGATION_STATUS_INVESTIGATION_COMPLETED]);

                    $insert_array = array(
                        'investigation_id' => $id,
                        'from_status' => INCIDENT_INVESTIGATION_STATUS_PENDING,
                        'to_status' => INCIDENT_INVESTIGATION_STATUS_INVESTIGATION_COMPLETED,
                        'is_reject' => 0,
                        'remarks' => $request->investigation_remarks,
                        'created_by' => Auth::id(),
                    );
                    $this->statuslog->create($insert_array);

                    /**
                     * Send Email Notification
                     */

                    $email_id = 'gowtham.ardhas@gmail.com';

                    $mailsubject = 'Incident Investigation Completed';



                    if ($email_id != '' || $email_id != null) {

                        $investigationdetails =  $this->investigation->selectOne($id);
                        $inspectionArray  = $investigationdetails->toArray();


                        $inspectionArray['name'] = 'Gowtham';
                        $inspectionArray['email_id'] =  $email_id;
                        $inspectionArray['mail_subject'] = $mailsubject;

                        //  Mail::to($inspectionArray['email_id'])->queue(new MachineryEmail($inspectionArray));
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
                            'message' => 'Incident Invesigation ' . $investigationdetails->investigation_id . ' completed by ' . getUsername(Auth::id()),
                            'icon' => 'public/assets/images/notification/uauc.png',
                            'id' => $investigationdetails->id,
                            'module' => 1,
                        )),
                        'web_link' =>  admin_url('incident/investigation/view/' . encryptId($investigationdetails->id)),
                        'assigned_user' => array_to_string([1]),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = [1];
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Incident Invesigation ' . $investigationdetails->investigation_id . ' completed by ' . getUsername(Auth::id()),
                    ];
                    mobilePushNotification($userId, $notifydata);


                    Session::flash('success', 'Incident Invesigation successfully completed!');
                } else {

                    Session::flash('error', 'Something went wrong, Please try after sometimes!');
                }
            } catch (Exception $ex) {
                dd($ex, 'error');
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('incident/investigation/list'));
        } catch (Exception $ex) {
            dd($ex, 'error');
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/investigation/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $investigation = $this->investigation->find($id);
            $notification = $this->notification->where('incident_id', $investigation->incident_id)->first();

            $where = ['investigation_id' => $id];

            $nearMissDetails = $this->near_miss->selectOneWhere($where);
            $accidentDetails = $this->accident->selectOneWhere($where);
            $statuslogs = $this->statuslog->getDetails($investigation->id);

            if ($nearMissDetails != null) {
                $why_why_analysis = json_decode($nearMissDetails->why_why_analysis);
                $why_why_analysis = json_decode(json_encode($why_why_analysis), true);
            }
            if ($accidentDetails != null) {
                $type = $accidentDetails->type;
                $lesson_learned_details = json_decode($accidentDetails->lesson_learned_details);
                $action_parties_company = json_decode($accidentDetails->action_parties_company);
                $action_parties_location = json_decode($accidentDetails->action_parties_location);
                $action_parties_specific_location = json_decode($accidentDetails->action_parties_specific_location);
                $division = json_decode($accidentDetails->division);
                $department = json_decode($accidentDetails->department);
                $user = json_decode($accidentDetails->user);
                $conclusion_details = json_decode($accidentDetails->conclusion_details);
            }

            $appendicies_file = $this->files->getfiles($investigation->id, 1);
            $tripod_beta_report_files = $this->files->getfiles($investigation->id, 2);
            $witness_statements_files = $this->files->getfiles($investigation->id, 3);
            $photo_videos_files = $this->files->getfiles($investigation->id, 4);
            $equipment_inspection_files = $this->files->getfiles($investigation->id, 5);
            $training_records_files = $this->files->getfiles($investigation->id, 6);
            $other_records_files = $this->files->getfiles($investigation->id, 7);

            $data = array(
                'statuslogs' => $statuslogs,
                'nearMissDetails' => $nearMissDetails,
                'accidentDetails' => $accidentDetails,
                'investigation' => $notification,
                'investigation_details' => $investigation,
                'type' => $type ?? '',
                'why_why_analysis' => $why_why_analysis ?? '',
                'lesson_learned_details' => $lesson_learned_details ?? '',
                'appendicies_file' => $appendicies_file,
                'tripod_beta_report_files' => $tripod_beta_report_files,
                'witness_statements_files' => $witness_statements_files,
                'photo_videos_files' => $photo_videos_files,
                'equipment_inspection_files' => $equipment_inspection_files,
                'training_records_files' => $training_records_files,
                'other_records_files' => $other_records_files,
                'action_parties_company' => $action_parties_company ?? '',
                'action_parties_location' => $action_parties_location ?? '',
                'action_parties_specific_location' => $action_parties_specific_location ?? '',
                'division' => $division ?? '',
                'department' => $department ?? '',
                'user' => $user ?? '',
                'conclusion_details' => $conclusion_details ?? '',
            );

            return view('incident.investigation.view', $data);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function ApproveReject(Request $request)
    {
        try {

            $id = decryptId($request->id);

            $investigation = $this->investigation->find($id);
            $notification = $this->notification->where('incident_id', $investigation->incident_id)->first();

            $where = ['investigation_id' => $id];

            $nearMissDetails = $this->near_miss->selectOneWhere($where);
            $accidentDetails = $this->accident->selectOneWhere($where);
            $statuslogs = $this->statuslog->getDetails($id);
            if ($nearMissDetails != null) {
                $why_why_analysis = json_decode($nearMissDetails->why_why_analysis, true);
            }

            if ($accidentDetails != null) {
                $type = $accidentDetails->type;
            }
            $data = array(
                'statuslogs' => $statuslogs,
                'nearMissDetails' => $nearMissDetails,
                'accidentDetails' => $accidentDetails,
                'investigation' => $notification,
                'investigation_details' => $investigation,
                'why_why_analysis' => $why_why_analysis ?? '',
                'approve_status' => 'YES',
                'type' => $type ?? '',

            );


            return view('incident.investigation.view', $data);
        } catch (Exception $ex) {
        }
    }

    public function ApproveRejectSubmit(Request $request)
    {

        try {

            $id = decryptId($request->id);
            $investigation = $this->investigation->find($id);
            $notification = $this->notification->where('incident_id', $investigation->incident_id)->first();
            $where = ['investigation_id' => $id];

            $nearMissDetails = $this->near_miss->selectOneWhere($where);
            if ($request->has('approve')) {
                $is_reject = 0;
                $status = INCIDENT_INVESTIGATION_STATUS_INVESTIGATION_COMPLETED;

                $this->near_miss->approval($nearMissDetails->id);
            } else if ($request->has('reject')) {
                $is_reject = 1;
                $status =  INCIDENT_INVESTIGATION_STATUS_PENDING;
            }

            $investigation = $investigation->id;

            $insert_array = array(
                'investigation_id' => $investigation,
                'from_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);
            $investigation = $this->investigation->where('id', $id)->update(['investigation_status' => $status]);
            return redirect('incident/investigation/list');
        } catch (Exception $ex) {
            dd($ex);
            report($ex);
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $inspectionDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);
            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'statuslogs' => $statuslogs,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
                'approvereject' => 'YES',
            );

            return view('incident.investigation.view', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {



            $id = decryptId($request->id);
            $inspection = $this->notification->find($id);

            $status = INSPECTION_STATUS_INSPECTION_COMPLETED;
            $is_reject = 0;


            $inspection_id = $inspection->id;

            $insert_array = array(
                'inspection_id' => $inspection_id,
                'from_status' => INSPECTION_STATUS_HOD_REJECTED,
                'to_status' => $status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);

            $this->notification->where('id', $id)->update(['inspection_status' => $status]);

            Session::flash('success', 'Inspection successfully updated');
            return redirect('incident/investigation/list');
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('incident/investigation/list'));
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $this->notification->deleterecord($id);

            return response()->json(['status' => 'success', 'msg' => 'Location deleted successfully'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->notification->exportdata();

            $header = [
                'No.',
                'Inspection ID',
                'Inspection Type',
                'Location',
                'Inspection Date',
                'Assign To',
                'Status',
                'Created By',
                'Created Date',
            ];


            $i = 1;
            foreach ($allData as $data) {

                $export = [];

                $export[] =  $i;
                $export[] =  $data->inspection_id;
                $export[] =  $data->inspectiontype_name;
                $export[] =  $data->location_name;
                $export[] =  $data->inspection_date;
                $export[] =  getusername($data->assign_to);
                $export[] =  $data->status_name;
                $export[] =  getusername($data->created_by);
                $export[] =  Displaydateformat($data->created_at);

                $exportData[] = $export;

                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('Inspection List.xlsx')
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

            $allData = $this->notification->exportdata();
            $header = [
                'No.',
                'Inspection ID',
                'Inspection Type',
                'Location',
                'Inspection Date',
                'Assign To',
                'Status',
                'Created By',
                'Created Date',
            ];


            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "Inspection Details",
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

            $view = view('incident.investigation.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "Inspection List.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {

            $id = decryptId($request->id);

            $inspectionDetails = $this->notification->selectOne($id);
            $statuslogs = $this->statuslog->getDetails($id);

            $inspectiontype = $inspectionDetails->inspection_type;

            $where = array(
                'inspectiontype_id' => $inspectiontype
            );

            $inspectiontypeDetails = $this->inspectiontype->find($inspectiontype);

            $checklistCategoryDetails =  $this->checklistcategory->where($where)->get();
            $checklistItemList = $this->checklistitem->where($where)->get();

            $checklistItemDetails = [];
            foreach ($checklistItemList as $checklistItem) {
                $checklistItemDetails[$checklistItem->category_id][] = $checklistItem;
            }

            $inspectionchecklistitem = $this->inspectiondetails->where('inspection_id', $id)->get()->keyBy('checklist_item');

            $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);

            $inspectionFiles = [];

            foreach ($inspectionFileDetails as $inspectionFile) {
                $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
            }

            $inspectionMainFileDetails =   $this->inspectionmainfile->getinspectionfiles($id);

            $data = array(
                'inspectiontypeDetails' => $inspectiontypeDetails,
                'checklistCategoryDetails' => $checklistCategoryDetails,
                'checklistItemDetails' => $checklistItemDetails,
                'inspectionDetails' => $inspectionDetails,
                'inspectionchecklistitem' => $inspectionchecklistitem,
                'inspectionFiles' => $inspectionFiles,
                'inspectionMainFileDetails' => $inspectionMainFileDetails,
                'statuslogs' => $statuslogs,
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

            $view = view('incident.investigation.pdf.inspection', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = $inspectionDetails->inspection_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }
}
