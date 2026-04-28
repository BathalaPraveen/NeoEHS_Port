<?php

namespace App\Http\Controllers\API\HIRADC;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\HIRADC\Document;
use App\Models\HIRADC\DocumentType;
use App\Models\HIRADC\Category;
use App\Models\HIRADC\ProcessType;
use App\Models\HIRADC\ProcessTypeDetails;
use App\Models\HIRADC\Hazard;
use App\Models\HIRADC\HazardList;
use App\Models\HIRADC\Likelihood;
use App\Models\HIRADC\Severity;
use App\Models\HIRADC\RiskMatrix;
use App\Models\HIRADC\RiskStatus;

class HIRADCController extends BaseController
{
    /**
     * Waste Register api
     *
     * @return \Illuminate\Http\Response
     */

    private $document;
    private $documenttype;
    private $category;
    private $preocestype;
    private $processtypedetails;
    private $hazard;
    private $hazardlist;
    private $status;
    private $statuslog;


    public function __construct()
    {
        $this->document = new Document();
        $this->documenttype = new DocumentType();
        $this->category = new Category();
        $this->hazard = new Hazard();
        $this->hazardlist = new HazardList();
        $this->preocestype = new ProcessType();
        $this->processtypedetails = new ProcessTypeDetails();
        $this->statuslog = new RiskStatus();
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

            $list_array =  $this->hazard->select(
                'hiradc_hiradc_list.*',
                'hiradc_master_document.document_name',
                'hiradc_master_process_type.process_type_name',

            );
            $list_array = $list_array->leftJoin('hiradc_master_document', 'hiradc_hiradc_list.document_type', '=', 'hiradc_master_document.id');
            $list_array = $list_array->leftJoin('hiradc_master_process_type', 'hiradc_hiradc_list.process_type', '=', 'hiradc_master_process_type.id');

            if ($search != '') {
                $list_array->where(function ($query) use ($search) {
                    $query->orWhere('hiradc_master_document.document_name', 'LIKE', '%' . $search . '%');
                });
            }

            /**
             * Role Based list view condition start
             */
            // if (Auth::user()->role == ROLE_JOBOWNER) {

            //     $list_array->where(function ($query) use ($search) {
            //         $query->orWhere('atar_uauc.job_owner', Auth::id())
            //             ->orWhere('atar_uauc.reassign_job_owner', Auth::id())
            //             ->orWhere('atar_uauc.created_by', Auth::id());
            //     });
            // }
            /**
             * Role Based list view condition end
             */


            $list_array = $list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $final_list = $list_array->toArray();

            $data_array = [];
            foreach ($list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['risk_id'] = $listdata->risk_id;
                $data['document_type'] = $listdata->document_name;
                $data['process_type'] = $listdata->process_type_name;
                $data['created_by'] = getUsername($listdata->created_by);
                $data['date'] = Displaydateformat($listdata->created_at);
                $data['status_name'] =  mainStatusName($listdata->approve_status);
                $data['status_color'] = mainStatusColor($listdata->approve_status);
                $data_array[] = $data;
            }

            $final_details = [
                'per_page' => $final_list['per_page'],
                'current_page' => $final_list['current_page'],
                'from' => $final_list['from'],
                'to' => $final_list['to'],
                'total' => $final_list['total'],
                'total_page' => $final_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'hiradc_details' => $final_details
            ];

            return $this->sendResponse($success, 'HIRADC Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {

                $id = $request->id;

                $risk =  $this->hazard->selectOne($id);

                $riskdetails = $this->hazardlist->getwhere(['hazard_id' => $id]);

                $documentdetails = $this->document->get();
                $processtypeList = $this->preocestype->get();
                $processtypeDetailsdata = $this->processtypedetails->get();

                $processtypedetails = [];

                foreach ($processtypeDetailsdata as $processtypeDetail) {
                    $processtypedetails[$processtypeDetail->process_type_id][] = $processtypeDetail;
                }

                $user = getUser($risk->created_by);

                $data = [];

                $application = array(
                    'risk_assessed_by' => $user->name,
                    'email' => $user->email,
                    'company' => $user->companyInfo->company_name,
                    'division' => $user->divisionInfo->division_name,
                    'department' =>  $user->DepartmentInfo->department_nam,
                    'date_time' => displayDatetimeFormat($risk->created_at),
                );

                $processtypelist = string_to_array($risk->process_type_details);

                $processtypearray = [];


                if ($risk->process_type == 1) {

                    foreach ($processtypedetails[1] as $subprocesstype) {

                        if (in_array($subprocesstype->id, $processtypelist)) {
                            $checked = 1;
                        } else {
                            $checked = 0;
                        }
                        $list = array(
                            'name' =>  $subprocesstype->sub_type_name,
                            'selected_status' =>   $checked,
                        );
                        $processtypearray[] = $list;
                    }
                } else  if ($risk->process_type == 2) {

                    foreach ($processtypedetails[2] as $subprocesstype) {

                        if (in_array($subprocesstype->id, $processtypelist)) {
                            $checked = 1;
                        } else {
                            $checked = 0;
                        }
                        $list = array(
                            'name' =>  $subprocesstype->sub_type_name,
                            'selected_status' =>   $checked,
                        );
                        $processtypearray[] = $list;
                    }
                } else  if ($risk->process_type == 3) {

                    foreach ($processtypedetails[3] as $subprocesstype) {

                        if (in_array($subprocesstype->id, $processtypelist)) {
                            $checked = 1;
                        } else {
                            $checked = 0;
                        }
                        $list = array(
                            'name' =>  $subprocesstype->sub_type_name,
                            'selected_status' =>   $checked,
                        );
                        $processtypearray[] = $list;
                    }
                }

                $riskdocument = array(
                    'document_type' => $risk->document_name,
                    'document_sub_type' => $risk->documenttype_name,
                    'document_type_category' => $risk->category_name,
                    'process_type' => $risk->process_type_name,
                    'process_type_list' => $processtypearray,
                    'activity_number' => $risk->activity_number,
                );

                $riskassessment = [];

                foreach ($riskdetails as $risksig) {

                    $list = [];

                    $list['activities_area_process'] = $risksig->activities_area_process;
                    $list['routine_type'] = $risksig->routine_type;
                    $list['location_specific'] = $risksig->location_specific;
                    $list['aspects'] = $risksig->aspects;
                    $list['impacts'] = $risksig->impacts;
                    $list['compliance_obligation'] = $risksig->compliance_obligation;
                    $list['hazard'] = $risksig->hazard;
                    $list['effects'] = $risksig->effects;
                    $list['existing_control'] = $risksig->existing_control;
                    $list['likelyhood'] = $risksig->likelyhood;
                    $list['severity'] = $risksig->severity;
                    $list['risk_matrix_color'] = str_replace("#","",hazardriskcolor($risksig->risk));
                    $list['risk_matrix_value'] = $risksig->dfa;
                    $list['opportunities'] = checknull($risksig->opportunities);
                    $list['proposed_control'] = $risksig->proposed_control;

                    $riskassessment[]  = $list;
                }

                $reviews = array(
                    'name' => $user->name,
                    'designation' => $user->user_designation_name,
                    'date_time' => displayDatetimeFormat($risk->created_at),
                    'remarks' =>  $risk->remarks,
                );

               $statuslogDetails =  $this->statuslog->getlist($id);

               $statuslog = [];
               foreach($statuslogDetails as $log){
                    $list = [];
                    $list = array(
                        'status_name' => mainStatusName($log->to_status),
                        'status_name_color' => mainStatusColor($log->to_status),
                        'name' => getusername($log->created_by),
                        'designation' => getuser($log->created_by)->user_designation_name ,
                        'date' => displayDateformat($log->created_at),
                        'time' =>  Displaytimeformat($log->created_at),
                        'remarks' =>$log->status_description
                    );

                    $statuslog[] = $list;
               }

                $data = array(
                    'application' => $application,
                    'riskdocument' => $riskdocument,
                    'riskassessment' => $riskassessment,
                    'reviews' => $reviews,
                    'statuslog' => $statuslog,
                );


                $success = $data;

                return $this->sendResponse($success, 'HIRADC Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
