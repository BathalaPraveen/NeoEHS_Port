<?php

namespace App\Http\Controllers\API\Waste;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\WasteManagement\WasteType;
use App\Models\WasteManagement\WasteRegister;
use App\Models\WasteManagement\WasteCompany;
use App\Models\WasteManagement\WasteCard;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;


class WasteCardController extends BaseController
{
    /**
     * Chemical api
     *
     * @return \Illuminate\Http\Response
     */

    private $wastetype;
    private $wasteregister;
    private $wastecard;
    private $wastecompany;
    private $wasteitem;
    private $packagetype;


    public function __construct()
    {

        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wastecard = new WasteCard();
        $this->wastecompany = new wastecompany();
        $this->wasteitem = new WasteItem();
        $this->packagetype = new DisposalType();
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

            $list_array = $this->wastecard->select(
                'wastemanagement_waste_waste_card.*',
                'wastemanagement_master_wastetype.wastetype_id',
                'wastemanagement_master_wastetype.wastetype_name',

            )
                ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_waste_card.waste_code');

            $companyid = getCompanyId($request->company);
            $list_array->where('wastemanagement_waste_waste_card.company_id', $companyid);

            if ($search != '') {
                $list_array->where(function ($query) use ($search) {
                    $query->orWhere('wastemanagement_master_wastetype.wastetype_name', 'LIKE', '%' . $search . '%');
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

            $uauc_list = $list_array->toArray();

            $data_array = [];
            foreach ($list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['waste_name'] = $listdata->wastetype_name;
                $data['waste_code'] = $listdata->wastetype_id;
                $data['last_updated'] =  Displaydateformat($listdata->updated_at);

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
                'waste_card' => $uauc_details
            ];

            return $this->sendResponse($success, 'Waste Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {
        try {

            if (Auth::user()) {

                $id = $request->id;

                $companyname = $request->company;

                $wastecard = $this->wastecard->selectOne($id);
                $companydetails = $this->wastecompany->find($wastecard->company);
                $wastetypedetails = $this->wastetype->find($wastecard->waste_code);

                $wastetypeList = $this->wastetype->get();
                $wastecompanyList = $this->wastecompany->get();
                $wasteroomtemplist = $this->wasteitem->getWhere(WASTE_CATEGORY_FORM_IN_ROOM_TEMP);
                $wastesolubilitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_SOLUBILITY_IN_WATER);
                $wastedensitylist = $this->wasteitem->getWhere(WASTE_CATEGORY_DENSITY);
                $wasterisklist = $this->wasteitem->getWhere(WASTE_CATEGORY_RISKS);
                $wasteppelist = $this->wasteitem->getWhere(WASTE_CATEGORY_PPE);

                $wastepackageList = $this->packagetype->get();

                $wastedisposallist = $this->wasteitem->getWhere(WASTE_CATEGORY_METHOD_OF_DISPOSAL);

                $waste_generate_information = $properties = $handling_of_waste = $precautions = $accidental_discharge = [];

                $waste_generate_information = array(
                    'company_name' => $companydetails->company_name,
                    'company_address' => $companydetails->company_address,
                    'person_incharge' => $companydetails->person_incharge,
                    'contact_no' => $companydetails->contact_no,
                    'email' => $companydetails->email,
                );

                $riskdetails = string_to_array($wastecard->risk);
                $risk = [];
                foreach ($wasterisklist as $wasterisk){
                    $list = [];

                    if (in_array($wasterisk->id, $riskdetails)){
                        $selected = 1;
                    }else{
                        $selected = 0;
                    }

                    $list = array(
                        'name' =>  $wasterisk->item_name,
                        'selected' => $selected
                    );

                    $risk[] = $list;
                }

                $properties = array(
                    'waste_code' => $wastetypedetails->wastetype_id,
                    'waste_name' => $wastetypedetails->wastetype_name,
                    'origin' => $wastecard->origin,
                    'flash_point' => $wastecard->flash_point,
                    'boiling_point' => $wastecard->boiling_point,
                    'form_in_room_temp' => getItemName($wastecard->form_in_room_temp),
                    'solubility_in_water' => getItemName($wastecard->solubility_in_water),
                    'density' =>  getItemName($wastecard->density),
                    'color' => $wastecard->color,
                    'odour' => $wastecard->odour,
                    'risk' => $risk,
                );

                $ppedetails = string_to_array($wastecard->ppe);

                $ppe = [];
                foreach ($wasteppelist as $wasteppe){
                    $list = [];

                    if (in_array($wasteppe->id, $ppedetails)){
                        $selected = 1;
                    }else{
                        $selected = 0;
                    }

                    $list = array(
                        'name' =>  $wasteppe->item_name,
                        'selected' => $selected
                    );

                    $ppe[] = $list;
                }

                $handling_of_waste = array(
                    'ppe' =>  $ppe,
                    'packagin_type' =>  getpackageName($wastecard->packaging_type),
                    'grouping_on_pallet' =>  $wastecard->grouping_on_pallet,
                    'stacking_allowed' =>  $wastecard->stacking_allowed,
                    'pictogram_for_labelling' =>  $wastecard->pictogram_for_labelling ,
                    'recommended_method_of_disposal' =>  getItemName($wastecard->recommended_method_of_disposal) ,
                );

                $precautionsdetails = json_decode($wastecard->precautions);

                foreach ($precautionsdetails as $precaution){
                    $list = [];
                    $list = array(
                        'risk' =>   getItemName(decryptId($precaution->risk)),
                        'symptoms_of_intoxication' => $precaution->symptoms,
                        'first_aid' => $precaution->firstaid,
                        'guidelines_for_the_physician' => $precaution->guidephy,
                    );

                    $precautions[] = $list;
                }


                $materialdamages = json_decode($wastecard->material_damages);

                foreach ($materialdamages as $materialdamage){
                    $list = [];
                    $list = array(
                        'spill' =>  $materialdamage->spill,
                        'fire' => $materialdamage->fire ,
                        'explosion' => $materialdamage->explosion,

                    );

                    $accidental_discharge[] = $list;
                }

                $success = array(
                    'waste_generate_information' =>  $waste_generate_information,
                    'properties' =>  $properties,
                    'handling_of_waste' =>  $handling_of_waste,
                    'precautions' =>  $precautions,
                    'accidental_discharge' =>  $accidental_discharge,

                );

                return $this->sendResponse($success, 'Waste Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
