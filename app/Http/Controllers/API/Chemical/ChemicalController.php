<?php

namespace App\Http\Controllers\API\Chemical;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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


class ChemicalController extends BaseController
{
    /**
     * Chemical api
     *
     * @return \Illuminate\Http\Response
     */

    private $item;
    private $chemicalmaster;
    private $location;
    private $chemicallist;
    private $chemicallistdetails;
    private $status;
    private $statuslog;
    private $hazardclassification;


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

            $list_array = ChemicalList::select('chemical_chemical_list.*', 'master_location.location_name', 'master_company.company_name')
                ->leftJoin('master_location', 'chemical_chemical_list.location_id', '=', 'master_location.id')
                ->leftJoin('master_company', 'chemical_chemical_list.company_id', '=', 'master_company.id');

            if ($search != '') {
                $list_array->where(function ($query) use ($search) {
                    $query->orWhere('chemical_chemical_list.chemical_name', 'LIKE', '%' . $search . '%');
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
                $data['chemical_id'] = $listdata->chemical_id;
                $data['company_name'] = $listdata->company_name;
                $data['location'] = $listdata->location_name;
                $data['process_operation'] = $listdata->process_operation;
                $data['status'] = chemicalStatusName($listdata->chemical_status);
                $data['status_colorcode'] = 'cccccc' ;
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                $data_array[] = $data;
            }

            $uauc_details = [
                'per_page' => $final_list['per_page'],
                'current_page' => $final_list['current_page'],
                'from' => $final_list['from'],
                'to' => $final_list['to'],
                'total' => $final_list['total'],
                'total_page' => $final_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'uauc_details' => $uauc_details
            ];

            return $this->sendResponse($success, 'Chemical Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {

                $id = $request->id;

                $chemicalDetails = $this->chemicallist->selectOne($id);
                $chemicallistDetails = $this->chemicallistdetails->getwhere(['chemical_list_id' => $id]);
                $companyList =  Company::find($chemicalDetails->company_id);
                $statuslog  = $this->statuslog->where('chemical_id', $id)->get();

                $company_inofrmation = [
                    'company_name' =>   $companyList->full_name,
                    'company_telephone' =>   checknull($chemicalDetails->telephone_no),
                    'company_email' =>   checknull($chemicalDetails->email),
                    'company_address' =>   $companyList->address,
                    'company_city' =>   $companyList->city,
                    'company_state' =>   $companyList->state,
                    'company_pincode' =>   $companyList->pincode,
                    'company_dosh' =>   $companyList->dosh_reg_no,
                    'company_code_of_sector' =>   $companyList->code_of_sector,
                    'company_class_of_industry' =>   checknull($chemicalDetails->class_of_industry),
                    'company_activity' =>   checknull($chemicalDetails->company_activity),
                ];
                $list_of_chemicals = [
                    'location' => $chemicalDetails->location_name,
                    'processoperation' => $chemicalDetails->process_operation,
                    'hazardous_chemical' => $chemicalDetails->hazardous_chemical,
                    'no_of_workers_male' => $chemicalDetails->worker_male,
                    'no_of_workers_female' => $chemicalDetails->worker_female,
                ];
                $chemical_details = [];

                foreach ($chemicallistDetails as $chemical) {

                    $list = [];

                    $list['product_name'] =  $chemical->product_name;
                    $list['name_of_chemical'] =  getChemical($chemical->name_of_chemical);
                    $list['physical_form_of_chemical'] =  getChemicalItem($chemical->physical_form_of_chemical);
                    $list['workers_exposed'] =  $chemical->workers_exposed;
                    $list['engineering_control'] = getChemicalItem($chemical->engineering_control);
                    $list['ppe'] =  getChemicalItem($chemical->ppe);
                    $list['usage_of_chemical_type'] =  getChemicalItem($chemical->usage_of_chemical_type);
                    $list['usage_of_chemical_quantity'] = str_replace('_', ' / ', $chemical->usage_of_chemical_quantity);
                    $list['cas_no'] =  $chemical->cas_no;
                    $list['name_of_active_ingredients'] =  $chemical->name_of_active_ingredients;
                    $list['comply_with_classification_sds'] =  $chemical->comply_with_classification_sds;
                    $list['comply_with_classificationclass'] =  getHazardItem($chemical->comply_with_classificationclass);
                    $list['comply_with_classificationlabel'] =  $chemical->comply_with_classificationlabel;
                    $list['sds_org_name'] =  $chemical->sds_org_name;
                    $list['sds_file_path'] =  admin_url($chemical->sds_file_path);
                    $list['supplier_details'] =  getSupplier($chemical->supplier_details) ;

                    $chemical_details[] = $list;

                }
                $prepared_by = [
                    'name' => getuser($chemicalDetails->created_by)->name,
                    'designation_name' => getuser($chemicalDetails->created_by)->user_designation_name,
                    'created_at' => displayDateTimeFormat($chemicalDetails->created_at),
                    'remarks' => $chemicalDetails->remarks,
                ];

                $review = [];

                foreach ($statuslog as $status){
                    $list = [];
                    $list['status_name'] = chemicalStatusName($status->to_status) ;
                    $list['status_colorcode'] = 'cccccc' ;
                    $list['name'] =  getusername($status->created_by) ;
                    $list['date'] =  displayDateTimeformat($status->created_at) ;
                    $list['description'] =  $status->status_description ;

                    $review[] = $list;
                }

                $success = array(
                    'company_inofrmation' => $company_inofrmation,
                    'list_of_chemicals' => $list_of_chemicals,
                    'chemical_details' => $chemical_details,
                    'prepared_by' => $prepared_by,
                    'review' => $review,
                );

                return $this->sendResponse($success, 'Chemical Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
