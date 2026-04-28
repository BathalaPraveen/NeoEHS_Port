<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;


use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;


use App\Models\User;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Inspection\InspectionType;
use App\Models\Inspection\ChecklistCategory;
use App\Models\Inspection\ChecklistItem;

use App\Models\Inspection\Inspection;
use App\Models\Inspection\InspectionDetails;

use App\Models\Inspection\InspectionStatus;
use App\Models\Inspection\InspectionStatusLog;

use App\Models\Inspection\InspectionFile;
use App\Models\Inspection\JettyLocation;


class InspectionController extends BaseController
{
    /**
     * Inspection api
     *
     * @return \Illuminate\Http\Response
     */

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $inspectiontype;
    private $checklistcategory;
    private $checklistitem;

    private $inspection;
    private $inspectiondetails;

    private $status;
    private $statuslog;

    private $inspectionfile;
    private $jettylocation;


    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->inspectiontype = new InspectionType();
        $this->checklistcategory = new ChecklistCategory();
        $this->checklistitem = new ChecklistItem();

        $this->inspection =  new Inspection();
        $this->inspectiondetails =  new InspectionDetails();

        $this->inspectionfile =  new InspectionFile();
        $this->jettylocation =  new JettyLocation();

        $this->status =  new InspectionStatus();
        $this->statuslog =  new InspectionStatusLog();
    }


    public function list(Request $request): JsonResponse
    {

        if (Auth::user()) {

            $search = '';
            if ($request->has('search')) {
                if ($request->search != '' && $request->search != null) {
                    $search = $request->search;
                }
            }

            $query = $this->inspection->select('inspection_inspection_list.*', 'inspection_master_inspection_type.inspectiontype_name', 'master_location.location_name');
            $query = $query->leftJoin('inspection_master_inspection_type', 'inspection_master_inspection_type.id', '=', 'inspection_inspection_list.inspection_type')
                ->leftJoin('master_location', 'master_location.id', '=', 'inspection_inspection_list.location');


            if ($search != '') {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('inspection_master_inspection_type.inspectiontype_name', 'LIKE', '%' . $search . '%');
                });
            }

            if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id()))) {

                $query->Where('inspection_inspection_list.assign_to', Auth::id());
            }

            $inspection_list_array = $query->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $inspection_list = $inspection_list_array->toArray();

            $data_array = [];
            foreach ($inspection_list_array as $listdata) {
                $data = [];
                $specific_loc_name = $listdata->specific_loc_name != null ? $listdata->specific_loc_name : "";
                $data['id'] = $listdata->id;
                $data['inspection_id'] = $listdata->inspection_id;
                $data['inspection_type'] = $listdata->inspectiontype_name;
                $data['location'] = $listdata->location_name;
                $data['inspection_date'] = Displaydateformat($listdata->inspection_date);
                $data['assigned_user'] = getusername($listdata->assign_to);
                $data['status'] =  inspectionStatusText($listdata->inspection_status);
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);
                $data['assigned_user_id'] = $listdata->assign_to;
                $data['status_id'] = $listdata->inspection_status;
                $data_array[] = $data;
            }

            $inspection_details = [
                'per_page' => $inspection_list['per_page'],
                'current_page' => $inspection_list['current_page'],
                'from' => $inspection_list['from'],
                'to' => $inspection_list['to'],
                'total' => $inspection_list['total'],
                'total_page' => $inspection_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'inspection_details' => $inspection_details
            ];

            return $this->sendResponse($success, 'inspection Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function add(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {


                $id = $request->id;

                $inspectionDetails = $this->inspection->selectOne($id);

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

                $user = getuser($inspectionDetails->created_by);

                $inspectiondetains = array(
                    'location' => $inspectionDetails->location_name,
                    'specific_location' => $inspectionDetails->specific_loc_name,
                    'inspection_type' => $inspectionDetails->inspectiontype_name,
                    'inspection_date' => displayDateformat($inspectionDetails->inspection_date),
                    'inspection_time' => $inspectionDetails->inspection_time,
                    'assigned_to' => getusername($inspectionDetails->assign_to),
                );

                $inspectioncreatedby = array(
                    'name' =>  $user->name,
                    'designation' =>  $user->user_designation_name,
                    'created_datetime' => displayDateTimeformat($inspectionDetails->created_at),
                    'remarks' => $inspectionDetails->inspection_remarks,
                );

                $inspectionchecklist = [];

                $inspectionchecklist['jetty_audit'] = [];
                $inspectionchecklist['building_office_audit'] = [];
                $inspectionchecklist['building_caretaker_audit'] = [];
                $inspectionchecklist['terminal_audit'] = [];
                $inspectionchecklist['container_forklift_audit'] = [];
                $inspectionchecklist['forklift_audit'] = [];
                $inspectionchecklist['reach_stacker_audit'] = [];
                $inspectionchecklist['first_aid_audit'] = [];

                $msdUserDetails = User::msdusers();
                $tsdUserDetails = User::tsdusers();
                $caretakerDetails = User::caretakerusers();

                $craneOperatorDetails = User::craneoperatorusers();

                $jettylocation = $this->jettylocation->get();

                $jettylocationArray = [];
                foreach ($jettylocation as $jettyloc) {
                    $listdatas = [];
                    $listdatas['id'] = $jettyloc->id;
                    $listdatas['jetty_location'] = $jettyloc->jetty_location;
                    $listdatas['layout_image'] = url($jettyloc->layout_image);
                    $jettylocationArray[] = $listdatas;
                }

                if ($inspectiontypeDetails->id == INSPECTION_TYPE_BOAT) {


                    $insp_type =  [
                        'Compliance Inspection',
                        'Safety Inspection',
                        'Follow-up Inspection',
                    ];
                    $length = [
                        '< 16',
                        '16-25',
                        '26-30',
                        '30',
                    ];
                    $construction = [
                        'Steel',
                        'Wood',
                        'Aluminium',
                        'Other',
                    ];
                    $propulation = [
                        'Inboard',
                        'Outboard',
                    ];
                    $vessel_owner = [
                        'BPSB',
                        'Contractor',
                        'Other'
                    ];
                    $vessel_operator = [
                        'BPSB',
                        'Contractor',
                        'Other'
                    ];

                    $inspectionchecklist['boat_audit']['insp_type'] = $insp_type;
                    $inspectionchecklist['boat_audit']['length'] = $length;
                    $inspectionchecklist['boat_audit']['hull_construction'] = $construction;
                    $inspectionchecklist['boat_audit']['superstructure_construction'] = $construction;
                    $inspectionchecklist['boat_audit']['propulation'] = $propulation;
                    $inspectionchecklist['boat_audit']['vessel_owner'] = $vessel_owner;
                    $inspectionchecklist['boat_audit']['vessel_operator'] = $vessel_operator;
                    $inspectionchecklist['boat_audit']['msd_representative'] = $msdUserDetails->toArray();
                }

                if ($inspectiontypeDetails->id == INSPECTION_JETTY_AUDIT) {
                    $inspectionchecklist['jetty_audit']['tsd_representative'] = $tsdUserDetails->toArray();
                    $inspectionchecklist['jetty_audit']['jetty_location'] =  $jettylocationArray;;
                }

                if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE) {

                    $buildingtype = array(
                        'Office' => 'Office',
                        'Workshop' => 'Workshop',
                        'Others' => 'Others',
                    );
                    $inspectionchecklist['building_office_audit']['building_type'] =  $buildingtype;
                    $inspectionchecklist['building_caretaker_audit']['caretaker'] =  $caretakerDetails->toArray();

                }

                if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE_CARETAKER) {

                    $inspectionchecklist['building_caretaker_audit']['caretaker'] =  $caretakerDetails->toArray();
                }



                if ($inspectiontypeDetails->id == INSPECTION_TYPE_FIRST_AID) {
                    $inspectionchecklist['first_aid_audit']['caretaker'] = $caretakerDetails->toArray();
                }




                $inspectionchecklist['checklist_header'] = [
                    'SNo',
                    'Item',
                ];


                if ($inspectiontypeDetails->marks_type == 1) {

                    $inspectionchecklist['checklist_header'][] = 'YES';
                    $inspectionchecklist['checklist_header'][] = 'NO';
                    $inspectionchecklist['checklist_header'][] = 'NA';

                    $score_type = 1;
                } else if ($inspectiontypeDetails->marks_type == 2) {
                    $inspectionchecklist['checklist_header'][] = '1';
                    $inspectionchecklist['checklist_header'][] = '2';
                    $inspectionchecklist['checklist_header'][] = '3';
                    $inspectionchecklist['checklist_header'][] = 'NA';

                    $score_type = 2;
                }
                $observation = 0;
                if ($inspectiontypeDetails->observation_required == 1) {
                    $inspectionchecklist['checklist_header'][] = 'Observation';
                    $observation = 1;
                }
                $remarks = 0;
                if ($inspectiontypeDetails->remarks_required == 1) {
                    $inspectionchecklist['checklist_header'][] = 'Remarks';
                    $remarks = 1;
                }

                $inspectionchecklist['checklist_type']['score_type']  =  $score_type;
                $inspectionchecklist['checklist_type']['observation']  =  $observation;
                $inspectionchecklist['checklist_type']['remarks']  =  $remarks;

                $index = 0;
                $j = 1;

                $inspectionchecklist['checklist_details'] = [];
                foreach ($checklistCategoryDetails as $checklistCategory) {
                    if (isset($checklistItemDetails[$checklistCategory->id])) {
                        $i = 0;
                        $inspectionchecklist['checklist_details'][$index]['categoryid'] = $checklistCategory->id;
                        $inspectionchecklist['checklist_details'][$index]['category'] = $checklistCategory->category_name;
                        $inspectionchecklist['checklist_details'][$index]['subcategory'] = [];
                        foreach ($checklistItemDetails[$checklistCategory->id] as $checklistItem) {
                            $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['id'] = $checklistItem->id;
                            $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['name'] = $checklistItem->item_name;
                            $i++;
                            $j++;
                        }
                    }
                    $index++;
                }

                $success = array(
                    'inspectiondetains' => $inspectiondetains,
                    'inspectioncreatedby' => $inspectioncreatedby,
                    'inspectiontypeid' => $inspectiontypeDetails->id,
                    'inspectiontypename' => $inspectiontypeDetails->inspectiontype_name,
                    'inspectionchecklist' => $inspectionchecklist,
                );

                return $this->sendResponse($success, 'Inspection Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function addsubmit(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $id = $request->id;

                $this->inspection->apistore($id);
                $inspection = $this->inspection->find($id);

                if ($inspection) {

                    $this->inspectiondetails->apistore($inspection);
                    $this->inspectionfile->apistore($id);

                    $insert_array = array(
                        'inspection_id' => $inspection->id,
                        'from_status' => INSPECTION_STATUS_ASSIGNED,
                        'to_status' => INSPECTION_STATUS_INSPECTION_COMPLETED,
                        'is_reject' => 0,
                        'remarks' => $request->inspection_remarks,
                        'created_by' => Auth::id(),
                    );
                    $this->statuslog->create($insert_array);
                }

                /**
                 * Send Email Notification
                 */

                $email_id = 'gowtham.ardhas@gmail.com';

                $mailsubject = 'Inspection Completed';



                if ($email_id != '' || $email_id != null) {

                    $inspectiondetails =  $this->inspection->selectOne($inspection->id);
                    $inspectionArray  = $inspectiondetails->toArray();


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
                        'message' => 'Inspection ' . $inspection->inspection_id . ' completed by ' . getUsername($inspection->created_by),
                        'icon' => 'public/assets/images/notification/uauc.png',
                        'id' => $inspection->id,
                        'module' => 1,
                    )),
                    'web_link' =>  admin_url('inspection/inspection/view/' . encryptId($inspection->id)),
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
                    'message' => 'Inspection ' . $inspection->machinery_id . ' completed by ' . getUsername($inspection->created_by),
                ];
                mobilePushNotification($userId, $notifydata);

                $success = array(
                    'inspectionstatus' => 'updated',

                );

                return $this->sendResponse($success, 'Inspection Details Addedd');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function create(Request $request): JsonResponse
    {

        try {

            $inspectiontype = $this->inspectiontype->select('id', 'inspectiontype_name')->get();

            $success = array(
                'inspectiontype' =>  $inspectiontype,
            );

            return $this->sendResponse($success, 'Inspection Details');
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function createsubmit(Request $request): JsonResponse
    {

        try {

            $inspection =  $this->inspection->apicreateinspection();

            $insert_array = array(
                'inspection_id' => $inspection->id,
                'from_status' => 0,
                'to_status' => INSPECTION_STATUS_ASSIGNED,
                'is_reject' => 0,
                'remarks' => "New Inspection created",
                'created_by' => Auth::id(),
            );
            $this->statuslog->create($insert_array);


            $success = array(
                'inspection_id' =>  $inspection->id,
            );

            return $this->sendResponse($success, 'Inspection Created');
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {


                $id = $request->id;

                $inspectionDetails = $this->inspection->selectOne($id);
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

                $user = getuser($inspectionDetails->created_by);

                $inspectionFileDetails =   $this->inspectionfile->getinspectionfiles($id);

                $inspectionFiles = [];

                foreach ($inspectionFileDetails as $inspectionFile) {
                    $inspectionFiles[$inspectionFile->item_id][] = $inspectionFile;
                }

                $inspectiondetains = array(
                    'location' => $inspectionDetails->location_name,
                    'specific_location' => $inspectionDetails->specific_loc_name,
                    'inspection_type' => $inspectionDetails->inspectiontype_name,
                    'inspection_type_id' => $inspectionDetails->inspection_type,
                    'inspection_date' => displayDateformat($inspectionDetails->inspection_date),
                    'inspection_time' => $inspectionDetails->inspection_time,
                    'assigned_to' => getusername($inspectionDetails->assign_to),
                );

                $inspectioncreatedby = array(
                    'name' =>  $user->name,
                    'designation' =>  $user->user_designation_name,
                    'created_datetime' => displayDateTimeformat($inspectionDetails->created_at),
                    'remarks' => $inspectionDetails->inspection_remarks,
                );

                $inspectionchecklist = [];
                $inspectionscore = [];
                $inspectionsubmitedby = [];

                if ($inspectionDetails->inspection_status >= INSPECTION_STATUS_INSPECTION_COMPLETED) {

                    $insp_type =  [
                        [
                            'name' => 'Compliance Inspection',
                            'status' => ($inspectionDetails->insp_type == 'Compliance Inspection') ? 1 : 0,
                        ],
                        [
                            'name' => 'Safety Inspection',
                            'status' => ($inspectionDetails->insp_type == 'Safety Inspection') ? 1 : 0,
                        ],
                        [
                            'name' => 'Follow-up Inspection',
                            'status' => ($inspectionDetails->insp_type == 'Follow-up Inspection') ? 1 : 0,
                        ],

                    ];
                    $length = [
                        [
                            'name' => '< 16',
                            'status' => ($inspectionDetails->vessel_lengh == '< 16') ? 1 : 0,
                        ],
                        [
                            'name' => '16-25',
                            'status' => ($inspectionDetails->vessel_lengh == '16-25') ? 1 : 0,
                        ],
                        [
                            'name' => '26-30',
                            'status' => ($inspectionDetails->vessel_lengh == '26-30') ? 1 : 0,
                        ],
                        [
                            'name' => '30',
                            'status' => ($inspectionDetails->vessel_lengh == '30') ? 1 : 0,
                        ],

                    ];


                    $inspectionchecklist['boat_audit'] = [];
                    $inspectionchecklist['jetty_audit'] = [];
                    $inspectionchecklist['building_office_audit'] = [];
                    $inspectionchecklist['building_caretaker_audit'] = [];
                    $inspectionchecklist['terminal_audit'] = [];
                    $inspectionchecklist['container_forklift_audit'] = [];
                    $inspectionchecklist['forklift_audit'] = [];
                    $inspectionchecklist['reach_stacker_audit'] = [];
                    $inspectionchecklist['first_aid_audit'] = [];

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_BOAT) {
                        $inspectionchecklist['boat_audit']['insp_type'] =   $insp_type;
                        $inspectionchecklist['boat_audit']['length'] =   $length;
                        $inspectionchecklist['boat_audit']['vessel_name'] =  $inspectionDetails->vessel_name;
                        $inspectionchecklist['boat_audit']['type_of_vessel'] =  $inspectionDetails->vessel_type;
                        $inspectionchecklist['boat_audit']['beam'] =  $inspectionDetails->vessel_beam;
                        $inspectionchecklist['boat_audit']['depth'] =  $inspectionDetails->vessel_depth;
                        $inspectionchecklist['boat_audit']['gross_tonnage'] =  $inspectionDetails->vessel_gross;
                        $inspectionchecklist['boat_audit']['hull_construction'] =  ($inspectionDetails->vessel_hull == 'Other') ? $inspectionDetails->vessel_hull_other : $inspectionDetails->vessel_hull;
                        $inspectionchecklist['boat_audit']['superstructure_contruction'] =  ($inspectionDetails->vessel_superstructure == 'Other') ? $inspectionDetails->vessel_superstructure_other : $inspectionDetails->vessel_superstructure;
                        $inspectionchecklist['boat_audit']['propulsion'] =  $inspectionDetails->vessel_propulsion;
                        $inspectionchecklist['boat_audit']['vessel_owner'] =   ($inspectionDetails->vessel_owner == 'Other') ? $inspectionDetails->vessel_owner_other : $inspectionDetails->vessel_owner;
                        $inspectionchecklist['boat_audit']['vessel_operator'] =  ($inspectionDetails->vessel_operator == 'Other') ? $inspectionDetails->vessel_operator_other : $inspectionDetails->vessel_operator;
                        $inspectionchecklist['boat_audit']['imo_reg_no'] =  $inspectionDetails->vessel_imo_registration;
                        $inspectionchecklist['boat_audit']['flag'] =  $inspectionDetails->vessel_flag;
                        $inspectionchecklist['boat_audit']['port_of_registry'] =  $inspectionDetails->vessel_port_of_registry;
                        $inspectionchecklist['boat_audit']['classification_society_or_class'] =  $inspectionDetails->vessel_classification;
                        $inspectionchecklist['boat_audit']['total_person_onboard'] =  $inspectionDetails->vessel_total_person;
                        $inspectionchecklist['boat_audit']['msd_representative'] =  getusername($inspectionDetails->msd_representative);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_JETTY_AUDIT) {
                        $inspectionchecklist['jetty_audit']['tsd_representative'] =  getusername($inspectionDetails->tsd_representative);
                        $jettydetails = getJettyLocation($inspectionDetails->jetty_location,);
                        $inspectionchecklist['jetty_audit']['jetty_location'] =  $jettydetails['location'];
                        $inspectionchecklist['jetty_audit']['jetty_location_image'] = admin_url($jettydetails['image']);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE) {
                        $inspectionchecklist['building_office_audit']['building_type'] =  $inspectionDetails->building_type;
                        $inspectionchecklist['building_office_audit']['building_type_others'] =  $inspectionDetails->building_type_others;
                        $inspectionchecklist['building_caretaker_audit']['caretaker_name'] =  getusername($inspectionDetails->caretaker_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE_CARETAKER) {

                        $inspectionchecklist['building_caretaker_audit']['caretaker_name'] =  getusername($inspectionDetails->caretaker_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_TERMINAL) {
                        $inspectionchecklist['terminal_audit']['operator_name'] =  getusername($inspectionDetails->operator_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_CONTAINER_FORKLIFT) {
                        $inspectionchecklist['container_forklift_audit']['operator_name'] =  getusername($inspectionDetails->operator_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_FORKLIFT) {
                        $inspectionchecklist['forklift_audit']['operator_name'] =  getusername($inspectionDetails->operator_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_REACH_STACKER) {
                        $inspectionchecklist['reach_stacker_audit']['operator_name'] =  getusername($inspectionDetails->operator_id);
                    }

                    if ($inspectiontypeDetails->id == INSPECTION_TYPE_FIRST_AID) {
                        $inspectionchecklist['first_aid_audit']['caretaker_name'] = getusername($inspectionDetails->caretaker_id);
                        $inspectionchecklist['first_aid_audit']['division'] =  $inspectionDetails->division;
                    }
                }

                $inspectionchecklist['checklist_header'] = [
                    'SNo',
                    'Item',
                ];

                if ($inspectiontypeDetails->marks_type == 1) {

                    $inspectionchecklist['checklist_header'][] = 'YES';
                    $inspectionchecklist['checklist_header'][] = 'NO';
                    $inspectionchecklist['checklist_header'][] = 'NA';

                    $score_type = 1;
                } else if ($inspectiontypeDetails->marks_type == 2) {
                    $inspectionchecklist['checklist_header'][] = '1';
                    $inspectionchecklist['checklist_header'][] = '2';
                    $inspectionchecklist['checklist_header'][] = '3';
                    $inspectionchecklist['checklist_header'][] = 'NA';

                    $score_type = 2;
                }
                $observation = 0;
                if ($inspectiontypeDetails->observation_required == 1) {
                    $inspectionchecklist['checklist_header'][] = 'Observation';
                    $observation = 1;
                }
                $remarks = 0;
                if ($inspectiontypeDetails->remarks_required == 1) {
                    $inspectionchecklist['checklist_header'][] = 'Remarks';
                    $remarks = 1;
                }

                $inspectionchecklist['checklist_type']['score_type']  =  $score_type;
                $inspectionchecklist['checklist_type']['observation']  =  $observation;
                $inspectionchecklist['checklist_type']['remarks']  =  $remarks;

                $index = 0;
                $j = 1;

                $inspectionchecklistitem =   $inspectionchecklistitem->toArray();
                $inspectionchecklist['checklist_details'] = [];

                if ($inspectionDetails->inspection_status != INSPECTION_STATUS_ASSIGNED) {


                    foreach ($checklistCategoryDetails as $checklistCategory) {
                        if (isset($checklistItemDetails[$checklistCategory->id])) {
                            $i = 0;
                            $inspectionchecklist['checklist_details'][$index]['categoryid'] = $checklistCategory->id;
                            $inspectionchecklist['checklist_details'][$index]['category'] = $checklistCategory->category_name;
                            $inspectionchecklist['checklist_details'][$index]['subcategory'] = [];
                            foreach ($checklistItemDetails[$checklistCategory->id] as $checklistItem) {
                                if (isset($inspectionchecklistitem[$checklistItem->id])) {
                                    $insdetails = $inspectionchecklistitem[$checklistItem->id];

                                    $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['id'] = $checklistItem->id;
                                    $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['name'] = $checklistItem->item_name;
                                    $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['score'] = $insdetails['score'];
                                    $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['observation'] = $insdetails['observation'];
                                    $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['remarks'] = $insdetails['remarks'];
                                    if (isset($inspectionFiles[$checklistItem->id])) {

                                        $images = [];
                                        foreach ($inspectionFiles[$checklistItem->id] as $image) {

                                            $images[] = admin_url($image->file_path);
                                        }

                                        $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['referenceimage'] = $images;
                                    } else {
                                        $inspectionchecklist['checklist_details'][$index]['subcategory'][$i]['referenceimage'] = [];
                                    }

                                    $i++;
                                    $j++;
                                }
                            }
                        }
                        $index++;
                    }


                    if ($score_type  == 2) {

                        $score = json_decode($inspectionDetails->score);

                        $inspectionscore['total_issue'] = $score->total_issue;
                        $inspectionscore['issue_value_1'] = $score->issue_value_1 * 1;
                        $inspectionscore['issue_value_2'] = $score->issue_value_2 * 2;
                        $inspectionscore['issue_value_3'] = $score->issue_value_3 * 3;
                        $inspectionscore['total_scores'] = $score->total_scores;
                        $inspectionscore['overallscore'] = $score->overallscore;
                        $inspectionscore['overallscore_percentage_81_100'] = ($score->scorerange == 1) ? 1 : 0;
                        $inspectionscore['overallscore_percentage_41_80'] = ($score->scorerange == 2) ? 1 : 0;
                        $inspectionscore['overallscore_percentage_0_40'] = ($score->scorerange == 3) ? 1 : 0;
                    }
                }

                $status_log = [];
                if (count($statuslogs) > 0) {
                    foreach ($statuslogs as $statusLog) {
                        $status_log[] =  [
                            'status_name' => machhineryStatusText($statusLog->to_status),
                            'status_colorcode' => machhineryStatusColorcode($statusLog->to_status),
                            'status_username' =>  getusername($statusLog->created_by),
                            'status_datatime' => displayDateTimeformat($statusLog->created_at),
                            'status_description' => $statusLog->remarks,
                        ];
                    }
                }
                if ($inspectionDetails->inspection_status >= INSPECTION_STATUS_INSPECTION_COMPLETED) {
                    $inspector = getuser($inspectionDetails->inspector_id);
                    $inspectionsubmitedby['name'] =  $inspector->name;
                    $inspectionsubmitedby['designation_name'] =  $inspector->user_designation_name;
                    $inspectionsubmitedby['inspection_date'] =  displayDateformat($inspectionDetails->org_inspection_date) . ' ' . $inspectionDetails->org_inspection_time;
                    $inspectionsubmitedby['inspector_remarks'] =  $inspectionDetails->inspector_remarks;
                }



                $success = array(
                    'inspectiondetains' => $inspectiondetains,
                    'inspectioncreatedby' => $inspectioncreatedby,
                    'inspectionchecklist' => $inspectionchecklist,
                    'inspectionscore' => $inspectionscore,
                    'inspectionsubmitedby' => $inspectionsubmitedby,
                    'inspection_status' => $inspectionDetails->inspection_status,
                    'status_log' => $status_log,
                );


                return $this->sendResponse($success, 'Inspection Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function statuslist(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $statusDetails = $this->status->select('id', 'status_name')->get()->toArray();

                $success = array(
                    'statusDetails' => $statusDetails,
                );

                return $this->sendResponse($success, 'Inspection Status Details');
            } else {
                dd('sd');
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
