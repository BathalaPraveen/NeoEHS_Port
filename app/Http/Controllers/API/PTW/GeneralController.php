<?php

namespace App\Http\Controllers\API\PTW;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;
use Exception;

use App\Models\User;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Master\Company;
use App\Models\Master\Designation;
use App\Models\Master\ContractorCompany;
use App\Models\PTW\PTWActivity;
use App\Models\PTW\PTWCategory;
use App\Models\PTW\PTWItem;

use App\Models\PTW\PTWSubWorkPermit;
use App\Models\PTW\PTWFile;
use App\Models\PTW\PTWSubPermit;
use App\Models\PTW\SubpermitStatus;

use App\Models\PTW\General;
use App\Models\PTW\Gas;
use App\Models\PTW\Isolation;
use App\Models\PTW\Surface;
use App\Models\PTW\Hotwork;
use App\Models\PTW\Traffic;
use App\Models\PTW\Lifting;
use App\Models\PTW\Diving;
use App\Models\PTW\PermitStatusLog;
use App\Models\PTW\PermitStatus;
use App\Mail\PTW\GeneralPTWEmail;

use App\Models\PTW\Likelihood;
use App\Models\PTW\Severity;
use App\Models\PTW\RiskMatrix;
use App\Models\PTW\HazardCategory;
use App\Models\PTW\HazardSubCategory;
use App\Models\PTW\Hazard;
use App\Models\PTW\Reassign;

class GeneralController extends BaseController
{
    /**
     * UAUC api
     *
     * @return \Illuminate\Http\Response
     */
    private $category;
    private $item;
    private $company;
    private $location;
    private $designation;
    private $contractorCompany;
    private $subworkpermit;
    private $ptwfile;
    private $ptwsubpermit;

    private $general;
    private $gas;
    private $isolation;
    private $surface;
    private $hotwork;
    private $traffic;
    private $lifting;
    private $diving;
    private $specificlocation;

    private $permitstatuslog;
    private $status;

    private $likelihood;
    private $severity;
    private $riskmatrix;
    private $hazardcategory;
    private $hazardsubcategory;
    private $hazard;
    private $subpermitstatus;
    private $reassign_log;

    public function __construct()
    {

        $this->company = new Company();

        $this->category = new PTWCategory();
        $this->item = new PTWItem();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->designation = new Designation();
        $this->contractorCompany = new ContractorCompany();
        $this->subworkpermit = new PTWSubWorkPermit();
        $this->ptwfile = new PTWFile();
        $this->ptwsubpermit = new PTWSubPermit();

        $this->general = new General();
        $this->gas = new Gas();
        $this->isolation = new Isolation();
        $this->surface = new Surface();
        $this->hotwork = new Hotwork();
        $this->traffic = new Traffic();
        $this->lifting = new Lifting();
        $this->diving = new Diving();

        $this->status = new PermitStatus();
        $this->permitstatuslog = new PermitStatusLog();

        $this->likelihood = new Likelihood();
        $this->severity = new Severity();
        $this->riskmatrix = new RiskMatrix();
        $this->hazardcategory = new HazardCategory();
        $this->hazardsubcategory = new HazardSubCategory();
        $this->hazard = new Hazard();
        $this->subpermitstatus = new SubpermitStatus();

        $this->reassign_log = new Reassign();
    }




    public function list(Request $request)
    {

        if (Auth::user()) {

            $search = '';
            if ($request->has('search')) {
                if ($request->search != '' && $request->search != null) {
                    $search = $request->search;
                }
            }

            $ptw_list_array = $this->general->select('ptw_general.*', 'master_location.location_name', 'master_location_specific.specific_loc_name', 'users.name');
            $ptw_list_array = $ptw_list_array->leftJoin('master_location', 'ptw_general.location', '=', 'master_location.id');
            $ptw_list_array = $ptw_list_array->leftJoin('master_location_specific', 'ptw_general.location', '=', 'master_location_specific.id');
            $ptw_list_array = $ptw_list_array->leftJoin('users', 'ptw_general.created_by', '=', 'users.id');


            if ($search != '') {
                $ptw_list_array = $ptw_list_array->orWhere('ptw_id', "LIKE", "%" . $search . "%");
            }

            if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_HSEUSER)) {
            } else if (CheckUserRole(ROLE_CONTRACTORADMIN)) {

                $ptw_list_array = $ptw_list_array->where('ptw_general.created_by', Auth::id());
            } else if (CheckUserRole(ROLE_NORMAL_USER) || CheckUserRole(ROLE_CONTRACTORUSER) || (CheckUserRole(ROLE_PTW_CREATOR))) {

                $ptw_list_array = $ptw_list_array->where('ptw_general.created_by', Auth::id());
            }
            /**
             * Role Based list view condition end
             */


            $ptw_list_array = $ptw_list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $ptw_list = $ptw_list_array->toArray();

            $data_array = [];
            foreach ($ptw_list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['ptw_id'] = $listdata->ptw_id;
                $data['location_name'] = $listdata->location_name;
                $data['specific_location'] = $listdata->specific_loc_name;
                $data['username'] = $listdata->name;
                $data['status'] = permitStatusName($listdata->ptw_status);

                $text = permitStatus($listdata->ptw_status);

                $data['status_name'] = permitOrgStatusName($listdata->ptw_status);
                if ($listdata->ptw_status == PERMIT_STATUS_AO_PENDING && (subpermitcount($listdata->id) == 0)) {
                    $data['status_name'] = str_replace("Sub Work Permit Approved", "Area Owner Approval pending", $text);
                }


                $data['status_id'] = $listdata->ptw_status;
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                $data_array[] = $data;
            }

            $ptw_details = [
                'per_page' => $ptw_list['per_page'],
                'current_page' => $ptw_list['current_page'],
                'from' => $ptw_list['from'],
                'to' => $ptw_list['to'],
                'total' => $ptw_list['total'],
                'total_page' => $ptw_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'ptw_details' => $ptw_details
            ];

            return $this->sendResponse($success, 'General PTW Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request)
    {

        try {

            if (Auth::user()) {

                $id = $request->id;

                /**
                 * General PTW
                 */

                $general = $this->general->find($id);
                $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
                $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
                $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
                $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
                $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);

                $general_data = array();

                $area_of_work = [];
                $i = 0;
                $companyDetails = $this->company->select('id', 'company_name')->get();
                foreach ($companyDetails as $company) {
                    $area_of_work[$i]['name'] = $company->company_name;
                    $area_of_work[$i]['status'] = $general->area_of_work == $company->id ? 1 : 0;

                    $i++;
                }

                $general_data['area_of_work'] = $area_of_work;
                $general_data['location'] = getLocationName($general->location);
                $general_data['specific_location'] = getSpecificLocationName($general->specific_location);
                $general_data['location_others'] = $general->other_location;
                $general_data['user_name'] = getusername($general->created_by);
                $general_data['user_designation'] = getUser($general->created_by)?->user_designation_name;
                $general_data['contact_number'] = $general->contact_number;
                $general_data['work_description'] = $general->work_description;
                $general_data['job_hazard_analysis'] = $general->job_hazard_analysis;
                $general_data['date_of_application'] = displayDateformat($general->date_of_application);
                $general_data['data_of_commencement'] = displayDateformat($general->date_of_commencement);
                $general_data['date_of_completion'] = displayDateformat($general->date_of_completion);
                $general_data['ptw_status'] = permitStatusName($general->ptw_status);
                $general_data['ptw_status_name'] = permitOrgStatusName($general->ptw_status);

                // $general_data['area_owner'] = getusername($general->area_owner);
                // $general_data['supervising_authority'] = getusername($general->supervising_authority);
                // $general_data['work_type'] = getWorkTypeName($general->work_type);

                array_walk_recursive($general_data, 'replaceNullWithEmpty');

                $hazardData = json_decode($general->hazard);
                $hazard_data = array();
                $hazard_data_other = "";

                $whereArrayhf = array(
                    'ptw_id' => $id,
                    'ptw_module' => 0,
                    'file_type' => 1
                );

                $hazardfile =  $this->ptwfile->getWhere($whereArrayhf);

                if ($hazardData != '' && $hazardData != null) {

                    $i = 0;

                    foreach ($hazardDetails as $hazard) {

                        if (in_array($hazard->id, $hazardData->hazard)) {
                            $hazard_data[$i]['status'] = 1;
                        } else {
                            $hazard_data[$i]['status'] = 0;
                        }
                        $hazard_data[$i]['name'] = $hazard->category_name;

                        if ($hazard->input_type == 2) {

                            if (isset($hazardfile[$hazard->id])) {
                                $hazard_data[$i]['file_name'] = $hazardfile[$hazard->id]['file_orgname'];
                                $hazard_data[$i]['path'] = url($hazardfile[$hazard->id]['file_path']);
                            }
                        } else {
                            $hazard_data[$i]['file_name'] = "";
                            $hazard_data[$i]['path'] = "";
                        }

                        $i++;
                    }
                    $hazard_data_other = isset($hazardData->hazard_others_text) ? $hazardData->hazard_others_text : "";
                }

                $document_data = array();
                $document_data_other = "";

                $documentData = json_decode($general->supporting_documents);
                $whereArraysd = array(
                    'ptw_id' => $id,
                    'ptw_module' => 0,
                    'file_type' => 2
                );
                $supportCertificateFile =  $this->ptwfile->getWhere($whereArraysd);
                if ($documentData != '' && $documentData != null) {

                    $i = 0;

                    foreach ($supportCertificate as $certificate) {
                        if (in_array($certificate->id, $documentData->supportcertificate)) {
                            $document_data[$i]['status'] = 1;
                        } else {
                            $document_data[$i]['status'] = 0;
                        }

                        $document_data[$i]['name'] = $certificate->category_name;

                        $col_name = $certificate->id;

                        $document_data[$i]['file_name'] = "";
                        $document_data[$i]['path'] = "";
                        $document_data[$i]['text'] = "";

                        if ($certificate->input_type == 1) {

                            if (in_array($certificate->id, $documentData->supportcertificate)) {
                                $document_data[$i]['text'] = $documentData->supportcertificate_data->$col_name;
                            }
                        } else {

                            if (isset($supportCertificateFile[$certificate->id])) {
                                $document_data[$i]['file_name'] = $supportCertificateFile[$certificate->id]['file_orgname'];
                                $document_data[$i]['path'] = url($supportCertificateFile[$certificate->id]['file_path']);
                            }
                        }

                        $i++;
                    }
                    $document_data_other = isset($documentData->supportcertificate_data->$col_name) ? $documentData->supportcertificate_data->$col_name : '';;
                }

                $equipmentData = json_decode($general->equipment_details);

                $equipemnt_data = [];
                $equipemnt_data_other = "";
                $i = 0;

                if ($equipmentData != '' && $equipmentData != null) {

                    foreach ($protectiveEquipment as $equipment) {

                        $equipemnt_data[$i]['category_name'] = $equipment->category_name;
                        $equipemnt_data[$i]['subcategory'] = [];
                        if (isset($protectiveEquipmentItems[$equipment->id])) {
                            $j = 0;

                            foreach ($protectiveEquipmentItems[$equipment->id] as $euipmentItems) {

                                if (in_array($euipmentItems['id'], $equipmentData->equipments)) {
                                    $equipemnt_data[$i]['subcategory'][$j]['status'] = 1;
                                } else {
                                    $equipemnt_data[$i]['subcategory'][$j]['status'] = 0;
                                }

                                $equipemnt_data[$i]['subcategory'][$j]['name'] = $euipmentItems['item_name'];
                                $j++;
                            }
                        }

                        $i++;
                    }

                    if (in_array(0, $equipmentData->equipments)) {
                        $equipemnt_data_other = $equipmentData->equipments_others_text;
                    }
                }

                $siteData = json_decode($general->site_preparation);

                $site_data = [];
                $site_data_other = "";

                if ($siteData != ''  && $siteData != null) {

                    $i = 0;

                    foreach ($sitePreparationDetails as $sitePreparation) {

                        $site_data[$i]['name'] = $sitePreparation->category_name;

                        if (in_array($sitePreparation->id, $siteData->sitepreparation)) {

                            $site_data[$i]['status'] = 1;
                        } else {
                            $site_data[$i]['status'] = 0;
                        }

                        $i++;
                    }

                    if (in_array(0, $siteData->sitepreparation)) {
                        $site_data_other = $siteData->sitepreparation_others_text;
                    }
                }

                $permit_issue = [];

                $permit_issue['apllication_ack'] = getusername($general->apllication_ack);
                $permit_issue['created_at'] = displayDateformat($general->created_at);
                $permit_issue['application_remarks'] = $general->application_remarks;

                $general_status = [];

                $generalpermitStatusLog = $this->permitstatuslog->getDetails(PTW_PERMIT_GENERAL, $id, $id);
                if (count($generalpermitStatusLog) > 0) {

                    $i = 0;
                    foreach ($generalpermitStatusLog as $statusLog) {

                        $general_status[$i]['status'] = permitStatusName($statusLog->to_status);
                        $general_status[$i]['name'] =  getusername($statusLog->approved_by);
                        $general_status[$i]['date'] =  displayDateTimeformat($statusLog->created_at);
                        $general_status[$i]['remarks'] = $statusLog->remarks;

                        $i++;
                    }
                }

                $likelihoods = $this->likelihood->select('id', 'name', 'example', 'rating')->orderBy('id', 'DESC')->get()->toArray();
                $severitys = $this->severity->select('id', 'name', 'example', 'rating')->orderBy('id', 'DESC')->get()->toArray();
                $riskmatrixDetails = $this->riskmatrix->select('rating', 'color_code')->get()->keyBy('rating')->toArray();
                $generalhazardDetails = $this->hazard->getgeneral($id);
                $jsa_risk_matrix_array = [];

                $i = 0;
                $j = 1;
                $jsa_risk_matrix_array[0][0]['text'] =  "Likelihood(L)";
                $jsa_risk_matrix_array[0][0]['colorcode'] =  "";

                foreach (array_reverse($severitys) as $severity) {
                    $jsa_risk_matrix_array[$i][$j]['text'] =  $severity['rating'];
                    $jsa_risk_matrix_array[$i][$j]['colorcode'] =  "";

                    $j++;
                }
                $i = 1;

                foreach ($likelihoods as $likelihood) {
                    $j = 0;
                    foreach (array_reverse($severitys) as $severity) {

                        $value = $likelihood['rating'] * $severity['rating'];
                        $jsa_risk_matrix_array[$i][$j]['text'] = $value;
                        $jsa_risk_matrix_array[$i][$j]['colorcode'] =  $riskmatrixDetails[$value]['color_code'];

                        $j++;
                    }

                    $i++;
                }

                $jsa_likelyhood =  $likelihoods;
                $jsa_severity = $severitys;
                $jsa_colorcode = $riskmatrixDetails;
                $jsa_risk_matrix = $jsa_risk_matrix_array;
                $jsa_details = $generalhazardDetails;

                $subpermitList = $this->subworkpermit->select('id', 'permit_name')->where('id', '!=', 0)->get()->toArray();

                $subpermitDetailsArray =  $this->ptwsubpermit->select('sub_permit_id', 'sub_permit_status')->where('ptw_id', $id)->get()->toArray();

                $subpermitDetails = [];

                $i = 0;
                foreach ($subpermitDetailsArray as $s) {
                    $subpermitDetails[$i]['id'] = $s['sub_permit_id'];
                    $subpermitDetails[$i]['status'] = subpermitStatusText($s['sub_permit_status']);
                    $subpermitDetails[$i]['status_colorcode'] = subpermitColorcode($s['sub_permit_status']);
                    $i++;
                }
                sort($subpermitDetails);

                $gastestDetails = $isolationDetails = $surfaceDetails = $hotworkDetails = $worktrafficDetails = $liftingDetails = $divingDetails = [];

                $gastestDetails = $this->gasView($id);
                $isolationDetails = $this->isolationView($id);
                $surfaceDetails = $this->surfaceView($id);
                $hotworkDetails = $this->hotworkView($id);
                $worktrafficDetails = $this->worksitetrafficView($id);
                $liftingDetails = $this->liftingView($id);
                $divingDetails = $this->divingView($id);

                // $reassignLog = $this->reassign_log->getLog($id);

                // $reassign_data = [];

                // if (!empty($reassignLog) && count($reassignLog) > 0) {
                //     foreach ($reassignLog as &$log) {
                //         $reassign_data[] = [
                //             'type' => getReassignType($log->type),
                //             'from_assigned_person' => getUserName($log->from_assigned_person),
                //             'assign_to' => getUserName($log->assign_to),
                //             'created_at' => displayDateTimeformat($log->created_at),
                //             'remarks' => $log->reassign_remarks,
                //         ];
                //     }
                // }

                // $hold_data = [];
                // if ($general->hold_by != null) {

                //     $hold_data['hold_by'] = getUserName($general->hold_by);
                //     $hold_data['hold_at'] = DisplayDateFormat($general->hold_at);
                //     $hold_data['hold_remarks'] = $general->hold_remarks;
                // }
                // array_walk_recursive($hold_data, 'replaceNullWithEmpty');

                // $unhold_data = [];

                // if ($general->unhold_by != null && $general->ptw_status != PERMIT_STATUS_PTW_HOLD) {

                //     $unhold_data['unhold_by'] = getUserName($general->unhold_by);
                //     $unhold_data['unhold_at'] = DisplayDateFormat($general->unhold_at);
                //     $unhold_data['unhold_remarks'] = $general->unhold_remarks;
                // }

                // array_walk_recursive($unhold_data, 'replaceNullWithEmpty');


                $data = array(

                    'general_data' =>  $general_data,
                    'hazard_data' =>  $hazard_data,
                    'hazard_data_other' =>  $hazard_data_other,
                    'document_data' =>  $document_data,
                    'document_data_other' =>  $document_data_other,
                    'equipemnt_data' =>  $equipemnt_data,
                    'equipemnt_data_other' =>  $equipemnt_data_other,
                    'site_data' =>  $site_data,
                    'site_data_other' =>  $site_data_other,
                    'permit_issue' =>  $permit_issue,
                    'general_status' =>  $general_status,

                    'jsa_likelyhood' =>  $jsa_likelyhood,
                    'jsa_severity' =>  $jsa_severity,
                    'jsa_colorcode' =>  $jsa_colorcode,
                    'jsa_risk_matrix' =>  $jsa_risk_matrix,
                    'jsa_details' =>  $jsa_details,

                    'subpermitList' => $subpermitList,
                    'subpermitDetails' => $subpermitDetails,
                    // 'hold_data' => $hold_data,
                    // 'unhold_data' => $unhold_data,
                    // 'reassign_data' => $reassign_data,
                );

                $success = array(
                    'general_information' => $data,
                    'gastestDetails' => $gastestDetails,
                    'isolationDetails' => $isolationDetails,
                    'surfaceDetails' => $surfaceDetails,
                    'hotworkDetails' => $hotworkDetails,
                    'worktrafficDetails' => $worktrafficDetails,
                    'liftingDetails' => $liftingDetails,
                    'divingDetails' => $divingDetails,
                );


                return $this->sendResponse($success, 'General PTW Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }


    public function gasView($id)
    {

        /**
         * Gas Test
         */

        $whereArray = array(
            'ptw_id' => $id
        );

        $gas = $this->gas->selectOneWhere($whereArray);

        if ($gas == null || $gas == '') {
            return [];
        }


        $gaspermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_GAS, $id, $gas?->id);
        if ($gas->gastestfor == 1)
            $conf_status = 1;
        else
            $conf_status = 0;

        if ($gas->gastestfor == 2)
            $openair_status = 1;
        else
            $openair_status = 0;

        $gastestDetails['workdescription'] = [
            'work_description' => $gas->workdescription,
            'location' => getLocationName($gas->location),
            'equipment_process' => $gas->equipmentprocess,
            'hotwork_type' => $gas->hotworktype,
            'gas_test_for' => [
                [
                    'name' => 'Confined Space',
                    'status' => $conf_status,
                ],
                [
                    'name' => 'Open Air',
                    'status' => $openair_status,
                ],
            ],
            'work_startdate' =>  displayDateformat($gas->workstartdate),
            'work_enddate' => displayDateformat($gas->workenddate),
        ];

        $acceswaycheck = ($gas->accesswayarrangement_check == 'YES') ? 1 : 0;
        $isolationcertificate_check = ($gas->isolationcertificate_check == 'YES') ? 1 : 0;

        $ventilationestablishment = json_decode($gas->ventilationestablishment);

        $gastestDetails['site_preparation'] = [
            'access_way_arrange' => [
                'name' => $gas->accesswayarrangement,
                'status' => $acceswaycheck,
            ],
            'isolation_certificate_required' => [
                'name' => $gas->isolationcertificate,
                'status' => $isolationcertificate_check,
            ],
            'ventilation_establishment' => [
                [
                    'status' => (in_array('Mechanical Forced Air', $ventilationestablishment)) ? 1 : 0,
                    'name' => 'Mechanical Forced Air'
                ],
                [
                    'status' => (in_array('Natural Ventilation', $ventilationestablishment)) ? 1 : 0,
                    'name' => 'Natural Ventilation'
                ]
            ],
            'mean_of_communication' => $gas->meanofcommunication,
            'space_hazard_assessment' => ($gas->spacehazardaccesment == 'YES') ? 1 : 0,
        ];

        $gastestDetails['equipment_on_scene'] = [
            'gas_detector_model' => $gas->gasdetector,
            'last_calibration_date' => $gas->lastcalivration,
            'safety' => [
                [
                    'status' => ($gas->safetybelt == 'YES') ? 1 : 0,
                    'name' => 'Safety belt, harness and/or safety line or lifeline/rescue line'
                ],
                [
                    'status' => ($gas->hoistingequipment == 'YES') ? 1 : 0,
                    'name' => 'Hoisting Equipment'
                ],
                [
                    'status' => ($gas->scba == 'YES') ? 1 : 0,
                    'name' => 'SCBA'
                ],
            ],
            'scbadetails' => $gas->scbadetails
        ];

        $authperson = array_to_string(json_decode($gas->authperson));
        $authpersonArray = string_to_array($authperson);

        $gastestDetails['parties_involved'] = [
            'standby_person' => $authpersonArray,
            'supervisor_name' => $gas->supervisordetails,

        ];

        $gastest = json_decode($gas->gastest);

        $gastestDetails['gas_test'] = [
            'gastest' => [
                array(
                    "1" => 'TEST',
                    '2' => 'STANDARD FOR CONFINED SPACE',
                    '3' => 'STANDARD FOR OPEN AREA',
                    '4' => 'INITIAL READING',
                    '5' => 'REMARKS',
                ),
                [
                    "1" => 'OXYGEN',
                    '2' => '19.5% - 23.5 %',
                    '3' =>  '19.5% - 23.5 %',
                    '4' =>  $gastest->initial->oxygen,
                    '5' => $gastest->remarks->oxygen,
                ],
                [
                    "1" => 'EXPLOSIVE ( % LEL )',
                    '2' => '<= 10% LEL',
                    '3' =>  $gastest->standard->explosive,
                    '4' => $gastest->initial->explosive,
                    '5' => $gastest->remarks->explosive,
                ],
                [
                    "1" => 'TOXIC (PEL)',
                    '2' =>  '<= PEL	',
                    '3' =>  $gastest->standard->toxic,
                    '4' =>  $gastest->initial->toxic,
                    '5' => $gastest->remarks->toxic,
                ],
                [
                    "1" =>  'H2S (PPM)',
                    '2' =>  '<= 10 PPM',
                    '3' =>  $gastest->standard->h2s,
                    '4' => $gastest->initial->h2s,
                    '5' => $gastest->remarks->h2s,
                ],
                [
                    "1" => 'CO (PPM)',
                    '2' => '<= 25 PPM',
                    '3' =>  $gastest->standard->co,
                    '4' =>  $gastest->initial->co,
                    '5' =>  $gastest->remarks->co,
                ],
            ],
            'safe_to_work' => [
                [
                    'status' => ($gas->safe_work == 'YES') ? 1 : 0,
                    'name' => 'YES'
                ],
                [
                    'status' => ($gas->safe_work != 'YES') ? 1 : 0,
                    'name' => 'NO'
                ]
            ],
            'safe_to_work_remarks' => $gas->safe_work_remarks,
            'atmosphere_monitoring_required' =>  [
                [
                    'status' => ($gas->atmosphere == 'YES') ? 1 : 0,
                    'name' => 'YES'
                ],
                [
                    'status' => ($gas->atmosphere != 'YES') ? 1 : 0,
                    'name' => 'NO'
                ]
            ],
            'atmosphere_monitoring_required_remarks' => $gas->atmosphere_remarks,
            'gas_tester_name' => $gas->gastestername,
            'gas_test_datetime' => $gas->gastestdatetime,
        ];


        $gaslog = json_decode($gas->gaslog);

        $gaslogArray[] =  [
            "1" =>  'DATE',
            '2' =>  'Time',
            '3' =>  'OXYGEN',
            '4' => 'EXPLOSIVE',
            '5' => 'TOXIC',
            '6' => 'AGT NAME & SIGN',
        ];

        foreach ($gaslog as $log) {

            $gaslogArray[] =  [
                "1" =>  $log->date,
                '2' =>  $log->time,
                '3' =>  $log->oxygen,
                '4' => $log->explosive,
                '5' => $log->toxic,
                '6' => $log->name,
            ];
            // $newArray = [];
            // $newArray["0"] = $log->date;
            // $newArray['1'] = $log->time;
            // $newArray['2'] = $log->oxygen;
            // $newArray['3'] = $log->explosive;
            // $newArray['4'] =  $log->toxic;
            // $newArray['5'] =  $log->name;
            // dd($newArray);
            // $gaslogArray[] = $newArray;
        }

        $gastestDetails['gas_test_log'] = $gaslogArray;

        $gastestDetails['accept_submit'] = [
            'name' => getusername($gas->created_by),
            'datetime' => Displaydatetimeformat($gas->created_at),
            'remarks' => $gas->applicant_remarks,
        ];

        $status_log = [];
        if (count($gaspermitStatusLog) > 0) {
            foreach ($gaspermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $gastestDetails['status_log'] = $status_log;

        $gastestDetails['status_id'] = $gas->ptw_status;

        return $gastestDetails;
    }

    public function isolationView($id)
    {

        /**
         * Isolation
         */

        $whereArray = array(
            'ptw_id' => $id
        );
        $isolation = $this->isolation->selectOneWhere($whereArray);

        if ($isolation == null || $isolation == '') {
            return [];
        }

        $ppelist = $this->category->getWhere(PTW_CAT_ISOLATION_PPE);
        $isolationpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_ISOLATION, $id, $isolation?->id);


        $isolationDetails['work_description'] = [
            'location' => getLocationName($isolation->location),
            'what_do_isolate' => $isolation->whatdoisolate,
            'source_of_energy' => $isolation->sourceofenergy,
            'work_description' =>  $isolation->workdescription,
            'start_date' => displayDateformat($isolation->workstartdate),
            'end_date' => displayDateformat($isolation->workenddate),
        ];

        $ppelistArray = json_decode($isolation->ppelist);
        $ppelistdetails = [];
        foreach ($ppelist as $ppe) {
            $ppelistdetails[] =  [
                'name' => $ppe->category_name,
                'status' => (in_array($ppe->id, $ppelistArray)) ? 1 : 0
            ];
        }
        $isolationDetails['ppe'] = $ppelistdetails;

        $isolationArray = json_decode($isolation->isolation);
        $isolation_details = [];
        foreach ($isolationArray as $details) {
            $isolation_details[] =   [
                'isolation_point' =>  $details->point,
                'log_tag_out' => $details->lock,
                'time' => $details->time,
            ];
        }

        $isolationDetails['isolation_details'] = $isolation_details;

        $isolationDetails['isolation_details_others'] = [
            'lock_out_applied' => $isolation->loockoutapplied,
            'ic_pass_no' => $isolation->icno,
            'log_out_applied_username' => getusername($isolation->created_by),
        ];

        $isolatiodailycheckArray = json_decode($isolation->isolatiodailycheck);


        $isolation_checklist = [];
        foreach ($isolatiodailycheckArray as $isoloationcheck) {

            if ($isoloationcheck->status != "" && $isoloationcheck->status != null)
                $isolation_checklist[] = (array)$isoloationcheck;
        }

        $isolationDetails['isolation_checklist'] = $isolation_checklist;

        $isolationDetails['isolation_remarks'] = $isolation->isolationremarks;


        $isolationDetails['accept_submit'] = [
            'name' => getusername($isolation->created_by),
            'datetime' =>  Displaydatetimeformat($isolation->created_at),
            'remarks' => $isolation->applicant_remarks,
        ];


        $status_log = [];
        if (count($isolationpermitStatusLog) > 0) {
            foreach ($isolationpermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $isolationDetails['status_log'] = $status_log;
        $isolationDetails['status_id'] = $isolation->ptw_status;

        return $isolationDetails;
    }

    public function surfaceView($id)
    {
        /**
         * Surface
         */

        $whereArray = array(
            'ptw_id' => $id
        );

        $surface = $this->surface->selectOneWhere($whereArray);

        if ($surface == null || $surface == '') {
            return [];
        }

        $surfaceppe = $this->category->getWhere(PTW_CAT_SURFACE_PPE);
        $equipments = $this->category->getWhere(PTW_CAT_SURFACE_EQUIPMENT);
        $aditionalrequierments = $this->category->getWhere(PTW_CAT_SURFACE_ADDITIONAL_REQUIREMENTS);
        $surfacepermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_SURFACE, $id, $surface?->id);

        $surfaceDetails['work_description'] = [
            'location' => getLocationName($surface->location),
            'excavation_hazardous_area' => [
                [
                    'name' => 'Hazardous',
                    'status' => ($surface->hazardousarea == 'Hazardous') ? 1 : 0,
                ],
                [
                    'name' => 'Non-Hazardous',
                    'status' => ($surface->hazardousarea == 'Non-Hazardous') ? 1 : 0,
                ],
            ],
            'trail_excavation' => [
                [
                    'name' => 'Hazardous',
                    'status' => ($surface->trailexcavation == 'YES') ? 1 : 0,
                ],

            ],
            'maximum_excavation_depth' => $surface->maxexcavationdepth,
            'maximum_excavation_deep' => $surface->maxexcavationdeep,
            'result_from_trail' => $surface->resulttrailfrom,
            'start_date' => displayDateformat($surface->workstartdate),
            'end_date' => displayDateformat($surface->workenddate),
            'work_description' => $surface->workdescription,
        ];

        $ppelistdetails = json_decode($surface->ppelist);
        $ppelistArray = $ppelistdetails->ppelist;

        $ppedetails = [];
        foreach ($surfaceppe as $ppe) {
            $ppedetails[] =   [
                'name' => $ppe->category_name,
                'status' => (in_array($ppe->id, $ppelistArray)) ? 1 : 0,
            ];
        }
        $surfaceDetails['ppe'] = $ppedetails;
        $surfaceDetails['ppe_others'] = $ppelistdetails->ppeothers;

        $equipmentlistdetails = json_decode($surface->equipment);
        $equipmentlistArray = $equipmentlistdetails->equipment;

        $equipmentsArray = [];
        foreach ($equipments as $equipment) {
            $equipmentsArray[] =   [
                'name' => $equipment->category_name,
                'status' => (in_array($equipment->id, $equipmentlistArray)) ? 1 : 0,
            ];
        }
        $surfaceDetails['equipments'] = $equipmentsArray;
        $surfaceDetails['equipments_others'] =  $equipmentlistdetails->equipmentothers;


        $addrequiermentslistdetails = json_decode($surface->addrequierments);
        $addrequiermentslistArray = $addrequiermentslistdetails->addrequierments;

        $additional_requierments = [];
        foreach ($aditionalrequierments as $requierments) {
            $additional_requierments[] =   [
                'name' => $requierments->category_name,
                'status' => (in_array($requierments->id, $addrequiermentslistArray)) ? 1 : 0,
            ];
        }
        $surfaceDetails['additional_requierments'] = $additional_requierments;
        $surfaceDetails['additional_requierments_others'] = $addrequiermentslistdetails->requiermentsothers;

        $surfaceDetails['work_order_no'] = $surface->accept_worknumber;
        $surfaceDetails['work_order_date'] = $surface->accept_work_date;
        $surfaceDetails['work_order_additonal_control'] = $surface->accept_work_remarks;


        $surfaceDetails['accept_submit'] = [
            'name' => getusername($surface->created_by),
            'datetime' => Displaydatetimeformat($surface->created_at),
            'remarks' => $surface->applicant_remarks,
        ];

        $status_log = [];
        if (count($surfacepermitStatusLog) > 0) {
            foreach ($surfacepermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $surfaceDetails['status_log'] = $status_log;
        $surfaceDetails['status_id'] = $surface->ptw_status;

        return  $surfaceDetails;
    }

    public function hotworkView($id)
    {

        /**
         * Hotwork
         */
        $whereArray = array(
            'ptw_id' => $id
        );
        $hotwork = $this->hotwork->selectOneWhere($whereArray);

        if ($hotwork == null || $hotwork == '') {
            return [];
        }

        $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
        $precautionslist = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
        $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $id, $hotwork?->id);

        $hotworkoperationArray = json_decode($hotwork->hotworkoperation);
        $typeofhotworkoperation = [];
        foreach ($hotworkoperation as $hotworkoperation) {

            $typeofhotworkoperation[]  = [
                'name' => $hotworkoperation->category_name,
                'status' => (in_array($hotworkoperation->id, $hotworkoperationArray)) ? 1 : 0,
            ];
        }
        $hotworkDetails['work_description'] = [
            'location' => getLocationName($hotwork->location),
            'hotworktype' => [
                [
                    'name' => 'YES',
                    'status' => ($hotwork->hotworktype == 'YES') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($hotwork->hotworktype != 'YES') ? 1 : 0,
                ],
            ],
            'location_vessel' => $hotwork->locationmarine,
            'work_description' => $hotwork->workdescription,
            'start_date' => displayDateformat($hotwork->workstartdate),
            'end_date' => displayDateformat($hotwork->workenddate),
            'typeofhotworkoperation' => $typeofhotworkoperation

        ];

        $precautionsArray = json_decode($hotwork->precautions);
        $typeofhotworkoperation = [];
        foreach ($precautionslist as $precautions) {

            $id = $precautions->id;
            $typeofhotworkoperation[]  = [
                'name' => $precautions->category_name,
                'status_yes' => ($precautionsArray?->$id == 'YES') ? 1 : 0,
                'status_na' => ($precautionsArray?->$id != 'YES') ? 1 : 0,
            ];
        }

        $hotworkDetails['typeofhotworkoperation'] = $typeofhotworkoperation;

        $hotworkDetails['accept_submit'] = [
            'name' => getusername($hotwork->created_by),
            'datetime' => Displaydatetimeformat($hotwork->created_at),
            'remarks' => $hotwork->applicant_remarks,
        ];

        $status_log = [];
        if (count($hotworkpermitStatusLog) > 0) {
            foreach ($hotworkpermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $hotworkDetails['status_log'] =  $status_log;
        $hotworkDetails['status_id'] = $hotwork->ptw_status;

        return  $hotworkDetails;
    }

    public function worksitetrafficView($id)
    {

        /**
         * Work Traffic
         */
        $whereArray = array(
            'ptw_id' => $id
        );

        $traffic = $this->traffic->selectOneWhere($whereArray);

        if ($traffic == null || $traffic == '') {
            return [];
        }

        $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
        $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

        $whereArrayfile = array(
            'ptw_id' => $traffic?->ptw_id,
            'ptw_module' => 5,
            'reference_id' => $traffic?->id,
        );

        $trafficplandocument =  $this->ptwfile->getWhere($whereArrayfile);
        $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $id, $traffic?->id);


        $worktrafficDetails['work_description'] = [
            'location' => getLocationName($traffic->location),
            'work_description' => $traffic->workdescription,
            'reason_for_closing_roads' => $traffic->reasonclosing,
            'start_date' => displayDateformat($traffic->workstartdate),
            'end_date' => displayDateformat($traffic->workenddate),
        ];

        $uploadfile = [];
        foreach ($trafficplandocument as $document) {
            $uploadfile =  [
                'filename' => $document['file_orgname'],
                'url' => url($document['file_path']),
            ];
        }

        $worktrafficDetails['upload_plan'] = $uploadfile;

        $lighting = [];
        foreach ($wtmlight as $light) {
            $lighting[] =    [
                'name' => $light->category_name,
                'status' => (in_array($light->id, json_decode($traffic->lighting))) ? 1 : 0,
            ];
        }

        $worktrafficDetails['lighting'] = $lighting;


        $lighting_others = [];
        foreach ($wtmotherdetails as $wtmother) {
            $lighting_others[] =    [
                'name' => $wtmother->category_name,
                'status' => (in_array($wtmother->id, json_decode($traffic->wtmother))) ? 1 : 0,
            ];
        }

        $worktrafficDetails['lighting_others'] = $lighting_others;

        $worktrafficDetails['lifting_others_text'] = $traffic->wtmothers;

        $worktrafficDetails['work_order'] = [
            'work_order_no' => $traffic->workpermitnymber,
            'work_order_date' => $traffic->workpermitdate,
            'work_order_remarks' => $traffic->otherserice,

        ];

        $worktrafficDetails['accept_submit'] = [
            'name' => getusername($traffic->created_by),
            'datetime' => Displaydatetimeformat($traffic->created_at),
            'remarks' => $traffic->applicant_remarks,
        ];


        $status_log = [];
        if (count($trafficpermitStatusLog) > 0) {
            foreach ($trafficpermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }


        $worktrafficDetails['status_log'] = $status_log;
        $worktrafficDetails['status_id'] = $traffic->ptw_status;

        return  $worktrafficDetails;
    }

    public function liftingView($id)
    {

        /**
         * Lifting
         */

        $whereArray = array(
            'ptw_id' => $id
        );
        $lifting = $this->lifting->selectOneWhere($whereArray);



        if ($lifting == null || $lifting == '') {
            return [];
        }

        $whereArray = array(
            'ptw_id' => $lifting->ptw_id,
            'ptw_module' => 6,
            'reference_id' => $lifting->id,
        );

        $liftingdocument =  $this->ptwfile->getWhererby($whereArray);

        $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
        $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
        $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_LIFTING, $id, $lifting?->id);

        $liftingDetails['work_description'] = [
            'location' => getLocationName($lifting->location),
            'start_date' => displayDateformat($lifting->workstartdate),
            'end_date' => displayDateformat($lifting->workenddate),
            'work_description' => $lifting->workdescription,
        ];

        $liftingDetails['load_description'] = [
            'description_of_load' => $lifting->loaddescription,
            'overall_dimensions' => $lifting->overalldimension,
            'weight_of_load' => $lifting->loadweight,
            'load_status' => [
                [
                    'name' => 'Known weight',
                    'status' => $lifting->weight_type == 'knownweight' ? 1 : 0,
                ],
                [
                    'name' => 'Estimated weight',
                    'status' => ($lifting->weight_type == 'estimatedweight') ? 1 : 0,
                ],
            ],
            'center_of_gravity' => [
                [
                    'name' => 'Obvious',
                    'status' => ($lifting->centerofgravity == 'obvious') ? 1 : 0,
                ],
                [
                    'name' => 'Estimated',
                    'status' => ($lifting->centerofgravity == 'estimated') ? 1 : 0,
                ],
                [
                    'name' => 'Determined by drawing',
                    'status' => ($lifting->centerofgravity == 'determinedbydrawing') ? 1 : 0,
                ],
            ],
        ];

        $liftequpdetails = json_decode($lifting->liftingquipment);

        $lifting_equipment_information = [];
        foreach ($liftingequipment as $equipment) {
            $equId = $equipment->id;
            $lifting_equipment_information[] = [
                'name' => $equipment->category_name,
                'value' => isset($liftequpdetails->$equId) ?   $liftequpdetails?->$equId : "",
            ];
        }
        $liftingDetails['lifting_equipment_information'] = $lifting_equipment_information;


        $riggingDetails = json_decode($lifting->riggingdetails);
        $rigging_details = [];
        foreach ($riggingdetails as $rigging) {
            $riggingId = $rigging->id;
            $rigging_details[] = [
                'category_name' => $rigging->category_name,
                'size' => $riggingDetails->$riggingId->size,
                'swl' =>  $riggingDetails->$riggingId->swl,
                'quantity' => $riggingDetails->$riggingId->quantity,
                'weight' => $riggingDetails->$riggingId->weight,
            ];
        }
        $liftingDetails['rigging_details'] = $rigging_details;

        $liftingDetails['rigging_details_other'] = [
            'total_weight' =>  $lifting->ligtgearsweight,
            'total_suspended_load' => $lifting->totalweight,
        ];

        $liftingDetails['mean_of_communication'] = [
            'mean_of_communication' => $lifting->meanofcommunication,
            'operator_see_load' => [
                [
                    'name' => 'YES',
                    'status' => ($lifting->loadinpoint == 'yes') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($lifting->loadinpoint == 'no') ? 1 : 0,
                ],
            ],
        ];

        $env_cond = json_decode($lifting->env_cond);

        $liftingDetails['physical_environmental_consideration'] = [
            'ground_condition_safe' => [
                [
                    'name' => 'YES',
                    'status' => ($env_cond->pec_gc == 'yes') ? 1 : 0
                ],
                [
                    'name' => 'NO',
                    'status' => ($env_cond->pec_gc == 'no') ? 1 : 0
                ],
            ],
            'obstacles_power_line' => [
                [
                    'name' => 'YES',
                    'status' => ($env_cond->pec_ob == 'yes') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($env_cond->pec_ob == 'no') ? 1 : 0
                ],
            ],
            'obstacles_building' => [
                [
                    'name' => 'YES',
                    'status' => ($env_cond->pec_obs == 'yes') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($env_cond->pec_obs == 'no') ? 1 : 0,
                ],
            ],
            'lighting' => [
                [
                    'name' => 'YES',
                    'status' => ($env_cond->pec_lig == 'yes') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($env_cond->pec_lig == 'no') ? 1 : 0,
                ],
            ],
            'demarcation' => [
                [
                    'name' => 'YES',
                    'status' => ($env_cond->pec_dem == 'yes') ? 1 : 0,
                ],
                [
                    'name' => 'NO',
                    'status' => ($env_cond->pec_dem == 'no') ? 1 : 0,
                ],
            ],
            'environment' => [
                [
                    'name' => 'Thunderstorm and lightening strikes in the area. the ground condition must be checked after thunderstorm',
                    'status' => (isset($env_cond->pec_env_gc)) ? 1 : 0,
                ],
                [
                    'name' => "Strong wind that may sway the suspended load. (Local weather forecast & Supervisor's experience & Tagline to address)",
                    'status' => (isset($env_cond->pec_env_wet)) ? 1 : 0,
                ],
                [
                    'name' => "Do not proceed with lifting operation during bad sea condition. (Strong current and wave). (Local weather forecast & supervisor's experience & Tagline to address.)",
                    'status' => (isset($env_cond->pec_env_scn)) ? 1 : 0,
                ],
                [
                    'name' => "Other circumstances",
                    'status' => (isset($env_cond->pec_others)) ? 1 : 0,
                    'value' => isset($env_cond->other_circum) ? $env_cond->other_circum : '',
                ],
            ]
        ];

        $liftingDetails['person_involved_lifting'] = [
            [
                'position' => 'Lifting Supervisor',
                'name' => $lifting->liftingsupervisor,
                'documents' => [
                    'name' => (isset($liftingdocument[1])) ? $liftingdocument[1]['file_orgname'] : "",
                    'url' => (isset($liftingdocument[1])) ? url($liftingdocument[1]['file_path']) : "",
                ],
            ],
            [
                'position' => 'Crane Operator',
                'name' => $lifting->liftingcraneoperator,
                'documents' => [
                    'name' => (isset($liftingdocument[2])) ? $liftingdocument[2]['file_orgname'] : "",
                    'url' => (isset($liftingdocument[2])) ? url($liftingdocument[2]['file_path']) : "",
                ],
            ],
            [
                'position' => 'Signalman',
                'name' => $lifting->liftingsignalman,
                'documents' => [
                    'name' => (isset($liftingdocument[3])) ? $liftingdocument[3]['file_orgname'] : "",
                    'url' => (isset($liftingdocument[3])) ? url($liftingdocument[3]['file_path']) : "",
                ],
            ],
            [
                'position' => 'Rigger',
                'name' => $lifting->liftingrigger,
                'documents' => [
                    'name' => (isset($liftingdocument[4])) ? $liftingdocument[4]['file_orgname'] : "",
                    'url' => (isset($liftingdocument[4])) ? url($liftingdocument[4]['file_path']) : "",
                ],
            ],
            [
                'position' => 'Others',
                'name' =>  $lifting->liftingothers,
                'documents' => [
                    'name' => (isset($liftingdocument[5])) ? $liftingdocument[5]['file_orgname'] : "",
                    'url' => (isset($liftingdocument[5])) ? url($liftingdocument[5]['file_path']) : "",
                ],
            ],
        ];

        $liftingDetails['accept_submit'] = [
            'name' => getusername($lifting->created_by),
            'datetime' => Displaydatetimeformat($lifting->created_at),
            'remarks' => $lifting->applicant_remarks,
        ];


        $status_log = [];
        if (count($liftingpermitStatusLog) > 0) {
            foreach ($liftingpermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $liftingDetails['status_log'] =  $status_log;

        $liftingDetails['status_id'] = $lifting->ptw_status;

        return $liftingDetails;
    }

    public function divingView($id)
    {

        /**
         * Diving
         */

        $whereArray = array(
            'ptw_id' => $id
        );
        $diving = $this->diving->selectOneWhere($whereArray);

        if ($diving == null || $diving == '') {
            return [];
        }

        $equipmentgear = $this->category->getWhere(PTW_CAT_DIVING_EQUIPMENT);
        $divingsitepreparation = $this->category->getWhere(PTW_CAT_DIVING_SITE_PREPARATION);
        $divingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_DIVING, $id, $diving?->id);

        $divingDetails['work_description'] = [
            'work_description' => $diving->workdescription,
            'location' => getLocationName($diving->location),
            'estimation_diving_deep' => $diving->divingdeep,
            'start_date' => displayDateformat($diving->workstartdate),
            'end_date' => displayDateformat($diving->workenddate),
            'date' => $diving->date,
            'time_start' => $diving->time,
            'time_end' => $diving->estimationtime,
            'applied_datetime' => Displaydatetimeformat($diving->created_at),
        ];


        $divingEquipments = json_decode($diving->equipment);
        $equipmentDetails = [];
        foreach ($equipmentgear as $equipment) {
            $equipmentDetails[] =  [
                'name' => $equipment->category_name,
                'status' => (in_array($equipment->id, $divingEquipments->equipment)) ? 1  : 0,
            ];
        }
        $divingDetails['equipment'] = $equipmentDetails;
        $divingDetails['equipment_other'] = $divingEquipments->equipmentothers;

        $divingsitepreparationArray = json_decode($diving->sitepreparation);
        $diving_site_preparation = [];
        foreach ($divingsitepreparation as $sitepreparation) {
            $diving_site_preparation[] =  [
                'name' => $sitepreparation->category_name,
                'status' => (in_array($sitepreparation->id, $divingsitepreparationArray)) ? 1  : 0,
            ];
        }
        $divingDetails['diving_site_preparation'] = $diving_site_preparation;


        $driversDetails = json_decode($diving->divers);
        $divers_details = [];
        foreach ($driversDetails as $driver) {
            $divers_details[] = [
                'name' => $driver->name,
                'ic_passport_no' => $driver->idnumber,
                'competency' => $driver->competency,
                'health_fitness' => $driver->healthfitness,
            ];
        }

        $divingDetails['divers_details'] = $divers_details;

        $divingDetails['accept_submit'] = [
            'name' => getusername($diving->created_by),
            'datetime' => Displaydatetimeformat($diving->created_at),
            'remarks' => $diving->applicant_remarks,
        ];

        $status_log = [];
        if (count($divingpermitStatusLog) > 0) {
            foreach ($divingpermitStatusLog as $statusLog) {
                $status_log[] =  [
                    'status_name' => subpermitStatusName($statusLog->to_status),
                    'status_colorcode' => subpermitColorcode($statusLog->to_status),
                    'status_username' =>  getusername($statusLog->approved_by),
                    'status_datatime' => displayDateTimeformat($statusLog->created_at),
                    'status_description' => $statusLog->remarks,
                ];
            }
        }

        $divingDetails['status_log'] = $status_log;

        $divingDetails['status_id'] = $diving->ptw_status;

        return $divingDetails;
    }

    public function generalstatus(Request $reques)
    {
        try {

            $status =  $this->status->select('id', 'status_name')->get()->toArray();

            $success = array(
                'status' => $status,
            );


            return $this->sendResponse($success, 'Status Details');
        } catch (Exception $ex) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function subpermitstatus(Request $reques)
    {
        try {

            $status =  $this->subpermitstatus->select('id', 'status_name')->get()->toArray();

            $success = array(
                'status' => $status,
            );


            return $this->sendResponse($success, 'Status Details');
        } catch (Exception $ex) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function statupupdate(Request $request)
    {

        try {

            $success = array();

            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function AOApproveRejectSubmit(Request $request)
    {
        try {

            $id = $request->id;
            $permit = $this->general->find($id);
            $status = $request->status;

            if ($request->remarks == '' || $request->remarks == null) {
                $this->sendError('datamissing.', ['error' => 'Approval Description is missing'], 406);
            }

            if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_AREA_OWNER)) {
            } else {

                $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }

            if ($status == 'Approve') {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_GHSE_PENDING;
            } else if ($status == 'Reject') {
                $is_reject = 1;
                $ptw_status = PERMIT_STATUS_AO_REJECTED;
            }

            $ptw_id = $permit->id;

            $this->general->statuschange($id, $ptw_status);


            if ($is_reject == 1) {

                $notifywhere = array(
                    'id' => $permit->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'PTW Request is Rejected';
                $message = 'General PTW - ' . $permit->ptw_id . ' is Rejected, please update and Resubmit';
                $web_link = admin_url('ptw/general/edit/' . encryptId($permit->id));
            } else {

                $user_role = ROLE_GHSE_APPROVER;
                $notifywhere = array(
                    'company' => $permit->area_of_work,
                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Requesting for PTW Approval';
                $message = 'New PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/ghseapprove');
            }

            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $general = new General();
                        $permitdetails =  $general->selectOne($permit->id);
                        $permitrray  = $permitdetails->toArray();

                        $permitrray['name'] = $user->name;
                        $permitrray['email_id'] =  $email_id;
                        $permitrray['mail_subject'] = $mailsubject;

                        Mail::to($permitrray['email_id'])->queue(new GeneralPTWEmail($permitrray));
                    }
                }
            }

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
                        'id' => $permit->id,
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

            $insert_array = array(
                'permit_type' => PTW_PERMIT_GENERAL,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $ptw_id,
                'from_status' => $permit->ptw_status,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);
            $success = array();
            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function GHSEApproveRejectSubmit(Request $request)
    {
        try {

            $id = $request->id;
            $permit = $this->general->find($id);

            $status = $request->status;

            if ($request->remarks == '' || $request->remarks == null) {
                $this->sendError('datamissing.', ['error' => 'Approval Description is missing'], 406);
            }

            if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_GHSE_APPROVER)) {
            } else {

                $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }


            if ($status == 'Approve') {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_SA_PENDING;
            } else if ($status == 'Reject') {
                $is_reject = 1;
                $ptw_status = PERMIT_STATUS_GHSE_REJECTED;
            }

            $ptw_id = $permit->id;

            $this->general->statuschange($id, $ptw_status);

            if ($is_reject == 1) {

                $notifywhere = array(
                    'id' => $permit->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'PTW Request is Rejected';
                $message = 'General PTW - ' . $permit->ptw_id . ' is Rejected, please update and Resubmit';
                $web_link = admin_url('ptw/general/edit/' . encryptId($permit->id));
            } else {

                $user_role = ROLE_SUPERVISING_AUTHORITY;
                $notifywhere = array(
                    'company' => $permit->area_of_work,
                );

                $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Requesting for PTW Approval';
                $message = 'New PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/saapprove');
            }

            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $general = new General();
                        $permitdetails =  $general->selectOne($permit->id);
                        $permitrray  = $permitdetails->toArray();

                        $permitrray['name'] = $user->name;
                        $permitrray['email_id'] =  $email_id;
                        $permitrray['mail_subject'] = $mailsubject;

                        Mail::to($permitrray['email_id'])->queue(new GeneralPTWEmail($permitrray));
                    }
                }
            }

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
                        'id' => $permit->id,
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

            $insert_array = array(
                'permit_type' => PTW_PERMIT_GENERAL,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $ptw_id,
                'from_status' => $permit->ptw_status,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);
            $success = array();
            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function SAApproveRejectSubmit(Request $request)
    {
        try {

            $id = $request->id;
            $permit = $this->general->find($id);

            $status = $request->status;

            if ($request->remarks == '' || $request->remarks == null) {
                $this->sendError('datamissing.', ['error' => 'Approval Description is missing'], 406);
            }

            if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_SUPERVISING_AUTHORITY)) {
            } else {
                $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }


            if ($status == 'Approve') {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_PTW_APPROVED;
            } else if ($status == 'Reject') {
                $is_reject = 1;
                $ptw_status = PERMIT_STATUS_SA_REJECTED;
            }


            $ptw_id = $permit->id;

            $this->general->statuschange($id, $ptw_status);

            if ($is_reject == 1) {

                $notifywhere = array(
                    'id' => $permit->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'PTW Request is Rejected';
                $message = 'General PTW - ' . $permit->ptw_id . ' is Rejected, please update and Resubmit';
                $web_link = admin_url('ptw/general/edit/' . encryptId($permit->id));
            } else {

                $notifywhere = array(
                    'id' => $permit->created_by,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                $mailsubject = 'Your PTW request is Approved';
                $message = 'PTW - ' . $permit->ptw_id . ' is Approved';
                $web_link = admin_url('ptw/general/view/' . encryptId($permit->id));
            }

            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $general = new General();
                        $permitdetails =  $general->selectOne($permit->id);
                        $permitrray  = $permitdetails->toArray();

                        $permitrray['name'] = $user->name;
                        $permitrray['email_id'] =  $email_id;
                        $permitrray['mail_subject'] = $mailsubject;

                        Mail::to($permitrray['email_id'])->queue(new GeneralPTWEmail($permitrray));
                    }
                }
            }

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
                        'id' => $permit->id,
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

            $insert_array = array(
                'permit_type' => PTW_PERMIT_GENERAL,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $ptw_id,
                'from_status' => $permit->ptw_status,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);
            $success = array();
            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function PTWCloseSubmit(Request $request)
    {
        try {

            $id = $request->id;
            $permit = $this->general->find($id);
            $ptw_status = $permit->ptw_status;

            $status = $request->status;

            if ($status == 'Close') {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_PTW_CLOSED;
            }

            $ptw_id = $permit->id;

            $this->general->statuschange($id, $ptw_status);

            $insert_array = array(
                'permit_type' => PTW_PERMIT_GENERAL,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $ptw_id,
                'from_status' => $permit->ptw_status,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);

            $success = array();
            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function AOReassignSubmit(Request $request)
    {
        $rules = [
            'reassigned_area_owner' => 'required',
            'reassign_remarks' => 'required',
        ];
        $messages = [
            'reassigned_area_owner.required' => 'Please Select Area Owner',
            'reassign_remarks.required' => 'Please enter Remarks',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        try {

            $id = $request->id;
            $generalptw = $this->general->find($id);
            $from_assign_person = $generalptw->area_owner;
            $reassign = $this->general->reassign($id, PTW_AO_REASSIGN);
            $generalptw = $this->general->find($id);
            $remarks = $request->reassign_remarks;

            $reassignLog = $this->reassign_log->store($id, PTW_AO_REASSIGN, $from_assign_person, $generalptw->area_owner, $remarks);

            $notifywhere = array(
                'id' => $generalptw->area_owner,
            );

            $userids = User::where($notifywhere)->pluck('id')->toArray();
            $users = User::where($notifywhere)->get();

            $mailsubject = "[PTW Notification - " . PTWID($generalptw->id) . " ] " . 'Re-Assigned';
            $message = 'PTW - ' . $generalptw->ptw_id . ' Re-Assigned AreaOwner';
            $web_link = admin_url('ptw/general/view/' . encryptId($generalptw->id) . '/aoapprove');


            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $general = new General();
                        $permitdetails =  $general->selectOne($generalptw->id);
                        $permitrray  = $permitdetails->toArray();

                        $permitrray['name'] = $user->name;
                        $permitrray['email_id'] =  $email_id;
                        $permitrray['mail_subject'] = $mailsubject;

                        Mail::to($permitrray['email_id'])->queue(new GeneralPTWEmail($permitrray));
                    }
                }
            }

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
                        'id' => $generalptw->id,
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
            $success = array();
            return $this->sendResponse($success, 'Area Owner Successfully reassigned');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function SAReassignSubmit(Request $request)
    {
        $rules = [
            'reassigned_supervising_authority' => 'required',
            'reassign_remarks' => 'required',
        ];
        $messages = [
            'reassigned_supervising_authority.required' => 'Please Select Supervising Authority',
            'reassign_remarks.required' => 'Please enter Remarks',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        try {

            $id = decryptId($request->id);
            $generalptw = $this->general->find($id);
            $from_assign_person = $generalptw->supervising_authority;
            $reassign = $this->general->reassign($id, PTW_SA_REASSIGN);
            $generalptw = $this->general->find($id);
            $remarks = $request->reassign_remarks;

            $reassignLog = $this->reassign_log->store($id, PTW_SA_REASSIGN, $from_assign_person, $generalptw->supervising_authority, $remarks);

            $notifywhere = array(
                'id' => $generalptw->supervising_authority,
            );

            $userids = User::where($notifywhere)->pluck('id')->toArray();
            $users = User::where($notifywhere)->get();

            $mailsubject = "[PTW Notification - " . PTWID($generalptw->id) . " ] " . 'Re-Assigned';
            $message = 'PTW - ' . $generalptw->ptw_id . ' Re-Assigned Supervising Authority';
            $web_link = admin_url('ptw/general/view/' . encryptId($generalptw->id) . '/saapprove');


            /**
             * Send Email Notification
             */

            if (count($users) > 0) {

                foreach ($users as $user) {

                    $email_id = $user->email;

                    if ($email_id != '' || $email_id != null) {
                        $general = new General();
                        $permitdetails =  $general->selectOne($generalptw->id);
                        $permitrray  = $permitdetails->toArray();

                        $permitrray['name'] = $user->name;
                        $permitrray['email_id'] =  $email_id;
                        $permitrray['mail_subject'] = $mailsubject;

                        Mail::to($permitrray['email_id'])->queue(new GeneralPTWEmail($permitrray));
                    }
                }
            }

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
                        'id' => $generalptw->id,
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
            $success = array();
            return $this->sendResponse($success, 'Supervising Authority Successfully reassigned');
        } catch (Exception $ex) {
            report($ex);
            $success = array();
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
