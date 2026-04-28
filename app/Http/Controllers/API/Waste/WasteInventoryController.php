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

use App\Models\User;
use App\Models\WasteManagement\WasteType;
use App\Models\WasteManagement\WasteRegister;
use App\Models\WasteManagement\WasteInventory;
use App\Models\WasteManagement\WasteInventoryDetails;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;


class WasteInventoryController extends BaseController
{
    /**
     * Waste Inventory api
     *
     * @return \Illuminate\Http\Response
     */

    private $wastetype;
    private $wasteregister;
    private $wasteinventory;
    private $wasteinventorydetails;
    private $wasteitem;
    private $package;


    public function __construct()
    {
        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wasteinventory = new WasteInventory();
        $this->wasteinventorydetails = new WasteInventoryDetails();
        $this->wasteitem = new WasteItem();
        $this->package = new DisposalType();
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
            $company = $request->company;
            $companyid = getCompanyId($request->company);


            $list_array = WasteInventory::select(
                'wastemanagement_waste_inventory.*',
                'wastemanagement_master_wastetype.wastetype_id',
                'wastemanagement_master_wastetype.wastetype_name',
            )
                ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory.waste_code');

            $list_array->where('wastemanagement_waste_inventory.company_id', $companyid);


            if ($search != '') {
                $list_array->where(function ($query) use ($search) {
                    $query->orWhere('wastemanagement_waste_inventory.wastetype_id', 'LIKE', '%' . $search . '%');
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
                $data['waste_code'] = $listdata->wastetype_id;
                $data['waste_name'] = $listdata->wastetype_name;
                $data['genrration_date'] = Displaydateformat($listdata->generation_date);
                $data['location'] = getItemName($listdata->location);
                $data['quantity'] = $listdata->quantity;
                $data['type_of_packing'] = getpackageName($listdata->type_of_packing);
                $data['estimated_weight'] = $listdata->estimated_weight;
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
                'waste_inventory' => $uauc_details
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

                $list_array = WasteInventory::select(
                    'wastemanagement_waste_inventory.*',
                    'wastemanagement_master_wastetype.wastetype_id',
                    'wastemanagement_master_wastetype.wastetype_name',
                )->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory.waste_code');
                $list_array->where('wastemanagement_waste_inventory.id', $id);
                $list_array = $list_array->orderBy('id', 'DESC')->get();

                $data = [];
                foreach ($list_array as $listdata) {
                    $data['id'] = $listdata->id;
                    $data['waste_code'] = $listdata->wastetype_id;
                    $data['waste_name'] = $listdata->wastetype_name;
                    $data['genrration_date'] = Displaydateformat($listdata->generation_date);
                    $data['location'] = getItemName($listdata->location);
                    $data['quantity'] = $listdata->quantity;
                    $data['type_of_packing'] = getpackageName($listdata->type_of_packing);
                    $data['estimated_weight'] = $listdata->estimated_weight;
                    $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                }

                $success = $data;

                return $this->sendResponse($success, 'Waste Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
