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

use App\Models\Machinery\MachineryType;
use App\Models\Machinery\SupportingDocuments;
use App\Models\Machinery\ParticularsMachinery;

use App\Models\Machinery\Machinery;
use App\Models\Machinery\MachineryFile;
use App\Models\Machinery\MachineryStatus;
use App\Models\Machinery\MachineryStatusLog;


class MachineryController extends BaseController
{
    /**
     * Machinery api
     *
     * @return \Illuminate\Http\Response
     */

    private $company;
    private $division;
    private $department;
    private $location;
    private $specificlocation;

    private $machinerytype;
    private $supportingdocuments;
    private $partucularmachinery;
    private $machinery;
    private $machineryfiles;
    private $status;
    private $statuslog;

    public function __construct()
    {

        $this->company = new Company();
        $this->division = new Division();
        $this->department = new Department();
        $this->location = new Location();
        $this->specificlocation = new SpecificLocation();

        $this->machinerytype = new MachineryType();
        $this->supportingdocuments = new SupportingDocuments();
        $this->partucularmachinery = new ParticularsMachinery();
        $this->machinery = new Machinery();
        $this->machineryfiles = new MachineryFile();

        $this->status =  new MachineryStatus();
        $this->statuslog =  new MachineryStatusLog();
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

            $machinery_list_array = $this->machinery->select(
                'machinery_machinery_details.*',
                'master_location.location_name',
                'master_location_specific.specific_loc_name',
                'machinery_master_typeofmachinery.machinery_type as machinery_type_name',
            )
                ->leftJoin('master_location', 'machinery_machinery_details.location', '=', 'master_location.id')
                ->leftJoin('master_location_specific', 'machinery_machinery_details.specific_location', '=', 'master_location_specific.id')
                ->leftJoin('machinery_master_typeofmachinery', 'machinery_machinery_details.machinery_type', '=', 'machinery_master_typeofmachinery.id');

            if ($search != '') {
                $machinery_list_array = $machinery_list_array->orWhere('machinery_id', "LIKE", "%" . $search . "%");
            }

            $machinery_list_array = $machinery_list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $machinery_list = $machinery_list_array->toArray();

            $data_array = [];
            foreach ($machinery_list_array as $listdata) {
                $data = [];
                $specific_loc_name = $listdata->specific_loc_name != null ? $listdata->specific_loc_name : "";
                $data['id'] = $listdata->id;
                $data['machinery_id'] = $listdata->machinery_id;
                $data['machinery_type'] = $listdata->machinery_type_name;
                $data['location'] = $listdata->location_name;
                $data['specific_location'] = $specific_loc_name;
                $data['status'] =  machhineryStatusText($listdata->machinery_status);
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                $data_array[] = $data;
            }

            $machinery_details = [
                'per_page' => $machinery_list['per_page'],
                'current_page' => $machinery_list['current_page'],
                'from' => $machinery_list['from'],
                'to' => $machinery_list['to'],
                'total' => $machinery_list['total'],
                'total_page' => $machinery_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'machinery_details' => $machinery_details
            ];

            return $this->sendResponse($success, 'Machinery Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $id = $request->id;

                $machineryDetails = $this->machinery->selectOne($id);
                $supportDocDetails = $this->machineryfiles->getWhere(['machinery_id' => $id]);

                $locationDetails = $this->location->get();
                $specificlocationDetails = $this->specificlocation->get();

                $machinerytypeDetails = $this->machinerytype->get();
                $supportingdocumentsDetails = $this->supportingdocuments->get();
                $partucularmachineryDetails = $this->partucularmachinery->get();
                $inspectionFiles = $this->machineryfiles->getWhereInspection(['machinery_id' => $id, 'type' => 2]);

                $statuslogs = $this->statuslog->getDetails($id);

                $textcontent['heading'] = "I hereby to confirm that the information below is true and agree to perform as follows";
                $textcontent['content'] = [
                    "Bound by the provisions in the Occupational Safety and Health Act 1994, Factories and Machinery Act 1967, Bintulu Port Group Company Safety Policy, other relevant government legislation and regulations.",
                    "All losses of Bintulu Port Group Company must be borne in full for all claims, requests, legal actions, proceedings, orders, costs, losses and expenses in any form that Bintulu Port Group Holdings Berhad may experience or incur in connection with our use of the equipment mentioned in Bintulu Port.",
                    "Comply with all the requirement and regulations that have been set.",
                    "If the contractor/ port user is found not to comply with the Bintulu Port Holdings Berhad Group's safety policy, the Group Safety, Health and Environment Division has the right to withdraw the approved Machinery Tag at any time.",
                    "This notification is valid for the specific operation as presented and is not transferable.",
                    "Submit all relevant documents as requested."
                ];

                $user = getuser($machineryDetails->created_by);
                $applicantdetails = [
                    'company_name' => $user->companyInfo->company_name,
                    'applicant_name' => $user->name,
                    'job_designation' => $user->user_designation_name,
                    'tel_no' => $user->mobile,
                    'id_no' => $user->id,
                    'date_time' =>  displayDatetimeFormat($machineryDetails->created_at),
                    'location' => $machineryDetails->location_name,
                    'specific_location' => $machineryDetails->specific_loc_name,
                ];

                $machinerylocation = [
                    'area' => $machineryDetails->area,
                    'vessel_name' => $machineryDetails->vessel_name,

                ];

                $machinerytype = $machineryDetails->machinery_type_name;

                $particularmachinerydetails = [];

                $i = 0;
                foreach ($partucularmachineryDetails as $particularmachinery) {

                    $particularmachineryArray = json_decode($machineryDetails->particularmachinery);

                    $id = $particularmachinery->id;
                    if ($particularmachinery->input_type == 'date') {
                        $value = $particularmachineryArray->$id != null ? displayDateformat($particularmachineryArray->$id) : '';
                    } else {
                        $value = $particularmachineryArray->$id;
                    }
                    $particularmachinerydetails[$i]['name'] =  $particularmachinery->particulars_name;
                    $particularmachinerydetails[$i]['value'] =  $value;
                    $i++;
                }

                $supportingdocumentdetails = [];
                $i = 0;
                foreach ($supportingdocumentsDetails as $supportdocument) {
                    $name = $filename = $fileurl = "";

                    $name = $supportdocument->document_name;

                    if (isset($supportDocDetails[$supportdocument->id])) {
                        $filename = $supportDocDetails[$supportdocument->id]['file_orgname'];
                        $fileurl = url($supportDocDetails[$supportdocument->id]['file_path']);
                    }

                    $supportingdocumentdetails[$i]['name'] =  $name;
                    $supportingdocumentdetails[$i]['file_name'] =  $filename;
                    $supportingdocumentdetails[$i]['file_url'] =  $fileurl;
                    $i++;
                }

                $purposeofuse = $machineryDetails->purposeofuse;

                $machineryinspection = [
                    'inspectiondate' =>  displayDateformat($machineryDetails->inspectiondate),
                    'inspectiontime' => $machineryDetails->inspectiontime,
                    'inspectionlocation' => $machineryDetails->purposelocationofinspection,
                ];

                if ($machineryDetails->inspection_checklist == null || $machineryDetails->inspection_checklist) {
                    $checklist_url = "";
                    $checklist_name = "";
                } else {
                    $checklist_url = url($inspectionFiles[$machineryDetails->inspection_checklist]['file_path']);
                    $checklist_name = $inspectionFiles[$machineryDetails->inspection_checklist]['file_orgname'];
                }


                $inspectiondetains = [
                    'machinery_tag' =>  $machineryDetails->machinery_tag,
                    'checklist_url' =>   $checklist_url,
                    'checklist_name' =>   $checklist_name,
                    'expiry_date' =>  displayDateformat($machineryDetails->expiry_date),
                ];

                $status_log = [];
                if (count($statuslogs) > 0) {
                    foreach ($statuslogs as $statusLog) {
                        $status_log[] =  [
                            'status_name' => machhineryStatusText($statusLog->to_status),
                            'status_colorcode' => machhineryStatusColorcode($statusLog->to_status),
                            'status_username' =>  getusername($statusLog->approved_by),
                            'status_datatime' => displayDateTimeformat($statusLog->created_at),
                            'status_description' => $statusLog->remarks,
                        ];
                    }
                }

                $success = array(
                    'textcontent' => $textcontent,
                    'applicantdetails' => $applicantdetails,
                    'machinerylocation' => $machinerylocation,
                    'machinerytype' => $machinerytype,
                    'particularmachinerydetails' => $particularmachinerydetails,
                    'supportingdocumentdetails' => $supportingdocumentdetails,
                    'purposeofuse' => $purposeofuse,
                    'machineryinspection' => $machineryinspection,
                    'inspectiondetains' => $inspectiondetains,
                    'status_log' => $status_log,
                );


                return $this->sendResponse($success, 'Machinery Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

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

                return $this->sendResponse($success, 'Machinery Status Details');
            } else {
                dd('sd');
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
