<?php

namespace App\Http\Controllers\API\Incident;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Validator;
use Exception;


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
    IncidentNotificationCasualtyFatality,
    IncidentNotificationClassification,
    NotificationStatus,
    NotificationStatusLog,
    IncidentInvestigation
};

class IncidentNotificationController extends BaseController
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

    private $category;
    private $item;
    private $subitem;
    private $classification;
    private $notification;
    private $notificationcasualtyfatality;
    private $notificationclassification;

    private $investgation;

    private $status;
    private $statuslog;



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
        $this->notificationcasualtyfatality = new IncidentNotificationCasualtyFatality();
        $this->notificationclassification = new IncidentNotificationClassification();

        $this->status = new NotificationStatus();
        $this->statuslog = new NotificationStatusLog();

        $this->investgation = new IncidentInvestigation();
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

            $query = $this->notification->select('incident_initial_notification.*');

            if ($search != '') {

                $query->where(function ($query) use ($search) {
                    $query->orWhere('incident_initial_notification.incident_id', 'LIKE', '%' . $search . '%');
                });
            }

            $incident_list_array = $query->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $incident_list = $incident_list_array->toArray();

            $data_array = [];
            foreach ($incident_list_array as $listdata) {
                $data = [];
                $specific_loc_name = $listdata->specific_loc_name != null ? $listdata->specific_loc_name : "";
                $data['id'] = $listdata->id;
                $data['incident_id'] = $listdata->incident_id;
                $data['incident_type'] = getIncidentTypeName($listdata->incident_type);
                $data['location'] = getLocationName($listdata->location_id);
                $data['incident_date'] = Displaydateformat($listdata->incident_date);
                $data['incident_description'] = Displaydateformat($listdata->incident_remarks);
                $data['status'] =  incidentStatusText($listdata->incident_status);
                $data['status_id'] = $listdata->incident_status;
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);
                $data_array[] = $data;
            }

            $Incident_details = [
                'per_page' => $incident_list['per_page'],
                'current_page' => $incident_list['current_page'],
                'from' => $incident_list['from'],
                'to' => $incident_list['to'],
                'total' => $incident_list['total'],
                'total_page' => $incident_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'Incident_details' => $Incident_details
            ];

            return $this->sendResponse($success, 'Incident Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function add(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {


                $companyDetails = $this->company->select('id', 'company_name')->where('status',1)->get();

                $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
                $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
                $locationList = $this->item->getlist(LOCATION);
                $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
                $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
                $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
                $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
                $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);

                $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);

                $subcategoryofincidentListDetails = [];

                foreach ($subcategoryofincidentList as $key1 => $list1) {

                    foreach ($list1 as $key2 => $list2) {

                        $list2['other_params'] = $list2['other_params']  != "" ? json_decode($list2['other_params']) : "";

                        $subcategoryofincidentListDetails[$key1][] = $list2->toArray();
                    }
                }

                $classificationList = $this->classification->getList();

                $success = array(
                    'companyDetails' => $companyDetails,

                    'emergencyincidenttireList' => $emergencyincidenttireList,
                    'weatherconditionList' => $weatherconditionList,
                    'locationList' => $locationList,
                    'incidentpotentialList' => $incidentpotentialList,
                    'authoritiesinformList' => $authoritiesinformList,
                    'incidentclassificationList' => $incidentclassificationList,
                    'typeofnotificationList' => $typeofnotificationList,
                    'categoryofincidentList' => $categoryofincidentList,
                    'subcategoryofincidentList' => $subcategoryofincidentListDetails,
                    'classificationList' => $classificationList,

                );

                return $this->sendResponse($success, 'Incident Details');
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


               $incidentnptification  =  $this->notification->apistore();

                if ($incidentnptification) {

                    $insert_array = array(
                        'inspection_id' => $incidentnptification->id,
                        'from_status' => 0,
                        'to_status' => INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING,
                        'is_reject' => 0,
                        'remarks' => $request->incident_remarks,
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

                    $incidentdetails =  $this->notification->selectOne($incidentnptification->id);
                    $incidentArray  = $incidentdetails->toArray();


                    $incidentArray['name'] = 'Gowtham';
                    $incidentArray['email_id'] =  $email_id;
                    $incidentArray['mail_subject'] = $mailsubject;

                    //  Mail::to($incidentArray['email_id'])->queue(new MachineryEmail($incidentArray));
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
                        'message' => 'Incident Notification' . $incidentnptification->incident_id . ' created by ' . getUsername($incidentnptification->created_by),
                        'icon' => 'public/assets/images/notification/uauc.png',
                        'id' => $incidentnptification->id,
                        'module' => 1,
                    )),
                    'web_link' =>  admin_url('incident/notification/view/' . encryptId($incidentnptification->id)),
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
                    'message' => 'Incident Notification' . $incidentnptification->incident_id . ' created by ' . getUsername($incidentnptification->created_by),
                ];
                mobilePushNotification($userId, $notifydata);

                $success = array(
                    'id' => $incidentnptification->incident_id,
                    'status' => 'created',

                );

                return $this->sendResponse($success, 'Incident Notification created');
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

                $IncidentDetails = $this->notification->selectOne($id);
                $statuslogs = $this->statuslog->getDetails($id);
                $companyDetails = $this->company->select('id', 'company_name')->get();
                $emergencyincidenttireList = $this->item->getlist(EMERGENCY_INCIDENT_TIRE);
                $weatherconditionList = $this->item->getlist(WEATHER_CONDITION);
                $locationList = $this->item->getlist(LOCATION);
                $incidentpotentialList = $this->item->getlist(INCIDENT_POTENTIAL);
                $authoritiesinformList = $this->item->getlist(AUTHORITIES_INFORM);
                $incidentclassificationList = $this->item->getlist(INCIDENT_CLASSIFICATION);
                $typeofnotificationList = $this->item->getlist(TYPE_OF_NOTIFICATION);
                $categoryofincidentList = $this->item->getlist(CATEGORY_OF_INCIDENT);
                $subcategoryofincidentList = $this->subitem->getlist(CATEGORY_OF_INCIDENT);
                $classificationList = $this->classification->getList();

                $subcategoryofincidentListDetails = [];

                $category_of_incident = $IncidentDetails?->category_of_incident;

                if ($category_of_incident != '' && $category_of_incident != null) {
                    $categoryofincidentArray = json_decode($category_of_incident, true);
                } else {
                    $categoryofincidentArray = [];
                }

                foreach ($subcategoryofincidentList as $key1 => $list1) {
                    foreach ($list1 as $key2 => $list2) {
                        $list2['other_params'] = $list2['other_params']  != "" ? json_decode($list2['other_params']) : "";
                        $subcategoryofincidentListDetails[$key1][] = $list2->toArray();
                    }
                }

                $category_of_incident_details = $general_information =  $casuality = $fatality = $incidentpotential = $authorites = $status_log = $created_by = [];

                $i = 0;

                foreach ($categoryofincidentList as $categoryofincident) {

                    $category_of_incident_details[$i]['category_name'] = $categoryofincident->item_name;

                    if (isset($subcategoryofincidentList[$categoryofincident->id])) {
                        $subcategory = [];
                        $j = 0;
                        foreach ($subcategoryofincidentList[$categoryofincident->id] as $subcategoryofincident) {

                            $subcategory[$j]['subcategory_name'] =  $subcategoryofincident->subitem_name;

                            $checkvalue = 'NO';
                            if (isset($categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id],)) {
                                if (
                                    isset($categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id]['value'],)
                                ) {
                                    if ($categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id]['value'] == 'YES') {
                                        $checkvalue = 'YES';
                                    }
                                }
                            }
                            $subcategory[$j]['checked'] = $checkvalue;
                            $otherparamsValue = [];

                            if ($checkvalue == 'YES' && $subcategoryofincident->other_params != '') {
                                $otherparams = $subcategoryofincident->other_params;

                                $k = 0;
                                $otherparamsArray = [];
                                if (is_array($otherparams)) {

                                    foreach ($otherparams as $param) {
                                        $otherparamsArray[$k]['name'] = $param->name == '' ? '' : $param->name;
                                        $value = '';
                                        if (isset($categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id][$param->data_name])) {

                                            $value = $categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id][$param->data_name];
                                        }
                                        $otherparamsArray[$k]['value'] = $value;
                                        $k++;
                                    }
                                }
                                $subcategory[$j]['other_params'] = $otherparamsArray;
                            }
                            $j++;
                        }
                        $category_of_incident_details[$i]['subcategory'] = $subcategory;
                        $i++;
                    }
                }

                $general_information =  [
                    'incident_type' => getIncidentTypeName($IncidentDetails?->incident_type),
                    'emergency_incident_tier' => getIncidentItemName($IncidentDetails?->emergency_incident_tier),
                    'type_of_notification' =>  getIncidentItemName($IncidentDetails?->type_of_notification),
                    'inc_location' => getIncidentItemName($IncidentDetails->location),
                    'incident_date' => displayDateformat($IncidentDetails->incident_date),
                    'incident_time' => getIncidentItemName($IncidentDetails->location),
                    'weather_condition' => $IncidentDetails->weather_condition,
                    'company' => getCompanyName($IncidentDetails->company_id),
                    'location' => getLocationName($IncidentDetails->location_id),
                    'specific_location' => getSpecificLocationName($IncidentDetails->specific_location_id),
                ];

                $casuality_details = $IncidentDetails->casuality_details;

                if ($casuality_details != '' && $casuality_details != null) {
                    $casualitydetailsArray = json_decode($casuality_details, true);
                } else {
                    $casualitydetailsArray = [];
                }

                $staffchecked = isset($casualitydetailsArray['staff']['value']) ? 'YES' : 'NO';
                $contractorchecked = isset($casualitydetailsArray['contractor']['value']) ? 'YES' : 'NO';
                $portuserchecked = isset($casualitydetailsArray['portuser']['value'],) ? 'YES' : 'NO';

                $casuality['staff']['name'] = 'Staff';
                $casuality['staff']['checked'] =  $staffchecked;
                $casuality['staff']['value'] = [];
                $casuality['contractor']['name'] = 'Contractor';
                $casuality['contractor']['checked'] =  $contractorchecked;
                $casuality['contractor']['value'] = [];
                $casuality['portuser']['name'] = 'Port User';
                $casuality['portuser']['checked'] =  $portuserchecked;
                $casuality['portuser']['value'] = [];

                if ($staffchecked == 'YES') {
                    $staff_value = [];
                    foreach ($companyDetails as $company) {
                        $staff_value[] = [
                            'name' => $company->company_name,
                            'value' =>  $casualitydetailsArray['staff'][$company->id],
                        ];
                    }
                    $casuality['staff']['value'] =  $staff_value;
                }

                if ($contractorchecked == 'YES') {
                    $casuality['contractor']['value'] = [
                        'name' => '',
                        'value' =>  $casualitydetailsArray['contractor']['count']
                    ];
                }

                if ($portuserchecked == 'YES') {

                    $casuality['portuser']['value'] = [
                        'name' => '',
                        'value' =>  $casualitydetailsArray['portuser']['count']
                    ];
                }

                $fatality_details = $IncidentDetails->fatality_details;

                if ($fatality_details != '' && $fatality_details != null) {
                    $fatalitydetailsdetailsArray = json_decode($fatality_details, true,);
                } else {
                    $fatalitydetailsdetailsArray = [];
                }

                $staffchecked = isset($fatalitydetailsdetailsArray['staff']['value'],) ? 'checked' : '';
                $contractorchecked = isset($fatalitydetailsdetailsArray['contractor']['value'],) ? 'checked' : '';
                $portuserchecked = isset($fatalitydetailsdetailsArray['portuser']['value'],) ? 'checked' : '';

                $staffchecked = isset($fatalitydetailsdetailsArray['staff']['value']) ? 'YES' : 'NO';
                $contractorchecked = isset($fatalitydetailsdetailsArray['contractor']['value']) ? 'YES' : 'NO';
                $portuserchecked = isset($fatalitydetailsdetailsArray['portuser']['value'],) ? 'YES' : 'NO';

                $fatality['staff']['name'] = 'Staff';
                $fatality['staff']['checked'] =  $staffchecked;
                $fatality['staff']['value'] = [];
                $fatality['contractor']['name'] = 'Contractor';
                $fatality['contractor']['checked'] =  $contractorchecked;
                $fatality['contractor']['value'] = [];
                $fatality['portuser']['name'] = 'Port User';
                $fatality['portuser']['checked'] =  $portuserchecked;
                $fatality['portuser']['value'] = [];

                if ($staffchecked == 'YES') {
                    $staff_value = [];
                    foreach ($companyDetails as $company) {
                        $staff_value[] = [
                            'name' => $company->company_name,
                            'value' =>  $fatalitydetailsdetailsArray['staff'][$company->id],
                        ];
                    }
                    $fatality['staff']['value'] =  $staff_value;
                }

                if ($contractorchecked == 'YES') {
                    $fatality['contractor']['value'] = [
                        'name' => '',
                        'value' =>  $fatalitydetailsdetailsArray['contractor']['count']
                    ];
                }

                if ($portuserchecked == 'YES') {

                    $fatality['portuser']['value']  = [
                        'name' => '',
                        'value' =>  $fatalitydetailsdetailsArray['portuser']['count']
                    ];
                }

                $incident_potential = string_to_array($IncidentDetails->incident_potential);
                $i = 0;
                foreach ($incidentpotentialList as $list) {
                    $incidentpotential[$i]['name'] = $list->item_name;
                    $incidentpotential[$i]['checked'] = in_array($list->id, $incident_potential) ? 'YES' : 'NO';
                    $i++;
                }

                $authorities_inform = string_to_array($IncidentDetails->authorities_inform);
                $i = 0;
                foreach ($authoritiesinformList as $authoritiesinform) {
                    $authorites[$i]['name'] = $authoritiesinform->item_name;
                    $authorites[$i]['checked'] = in_array($authoritiesinform->id, $authorities_inform) ? 'YES' : 'NO';
                    $i++;
                }

                $authorites[$i]['name'] = 'Others';
                $authorites[$i]['checked'] = in_array('others', $authorities_inform) ? 'YES' : 'NO';
                $authorites[$i]['value'] = in_array('others', $authorities_inform) ? $IncidentDetails->authorities_inform_other  : '';


                $incident_classification = json_decode($IncidentDetails->incident_classification, true,);
                $incident_classification_array = [];
                $i = 0;
                foreach ($incidentclassificationList as $incidentclassification) {
                    $selectedvalue = isset($incident_classification[$incidentclassification->id],) ? $incident_classification[$incidentclassification->id] : '';
                    $incident_classification_array[$i]['name'] = $incidentclassification->item_name;
                    $incident_classification_array[$i]['value'] = [];
                    $k = 0;
                    $value = [];
                    foreach (range(1, 5) as $range){
                        $value[$k]['name'] = $range;
                        $value[$k]['checked'] = $selectedvalue == $range ? 'YES' : 'NO';
                        $k++;
                    }
                    $incident_classification_array[$i]['value'] = $value;
                    $i++;
                }

                  foreach($statuslogs as $log){
                    $status_log[] = [
                        'date' => '',
                        'status_name' => '',
                        'user_name' => ''
                    ];
                }


                $success = array(

                    'general_information' => $general_information,
                    'category_of_incident' => $category_of_incident_details,
                    'casuality' => $casuality,
                    'fatality' => $fatality,
                    'incidentpotential' => $incidentpotential,
                    'authorites' => $authorites,
                    'informed_date' => displayDateformat($IncidentDetails->date_of_informed),
                    'brief_description_of_incident' => $IncidentDetails->brief_description_of_incident,
                    'mitigation_action' => $IncidentDetails->mitigation_action,
                    'additional_information' => $IncidentDetails->additional_information,
                    'brief_description_of_incident' => $IncidentDetails->brief_description_of_incident,
                    'incidentclassification' => $incident_classification_array,
                    'status_log' => $status_log,
                    'created_by' => $created_by,

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

                return $this->sendResponse($success, 'Incident Status Details');
            } else {
                dd('sd');
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
