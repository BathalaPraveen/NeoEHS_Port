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
use App\Models\WasteManagement\WasteInventory;
use App\Models\WasteManagement\WasteInventoryDetails;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;

class WasteDisposalController extends BaseController
{
    /**
     * Chemical api
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

            $list_array = $this->wasteinventorydetails->select(
                'wastemanagement_waste_inventory_details.*',
                'wastemanagement_master_wastetype.wastetype_id',
                'wastemanagement_master_wastetype.wastetype_name',
            )
                ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

            $companyid = getCompanyId($request->company);
            $list_array->where('wastemanagement_waste_inventory_details.company_id', $companyid);
            $list_array->where('wastemanagement_waste_inventory_details.inventory_type', INVENTORY_DISPOSAL);

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
                $data['generation_date'] = Displaydateformat($listdata->generation_date);
                $data['location'] = getItemName($listdata->location);
                $data['quantity'] = $listdata->quantity;
                $data['type_of_packing'] = getpackageName($listdata->type_of_packing);
                $data['estimated_weight'] = $listdata->estimated_weight;
                $data['disposal_date'] = Displaydateformat($listdata->entry_date);
                $data['disposal_qty'] = $listdata->entry_qty;
                $data['blance_qty'] = $listdata->current_qty;
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
                'waste_add_details' => $uauc_details
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

                $list_array = $this->wasteinventorydetails->select(
                    'wastemanagement_waste_inventory_details.*',
                    'wastemanagement_master_wastetype.wastetype_id',
                    'wastemanagement_master_wastetype.wastetype_name',
                )
                    ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_inventory_details.waste_code');

                $list_array->where('wastemanagement_waste_inventory_details.id', $id);
                $list_array = $list_array->orderBy('id', 'DESC')->get();

                $data = [];
                foreach ($list_array as $listdata) {
                    $data['id'] = $listdata->id;
                    $data['waste_name'] = $listdata->wastetype_name;
                    $data['waste_code'] = $listdata->wastetype_id;
                    $data['generation_date'] = Displaydateformat($listdata->generation_date);
                    $data['location'] = getItemName($listdata->location);
                    $data['quantity'] = $listdata->quantity;
                    $data['type_of_packing'] = getpackageName($listdata->type_of_packing);
                    $data['estimated_weight'] = $listdata->estimated_weight;
                    $data['disposal_date'] = Displaydateformat($listdata->entry_date);
                    $data['disposal_qty'] = $listdata->entry_qty;
                    $data['blance_qty'] = $listdata->current_qty;
                    $data['created_at'] = Displaydatetimeformat($listdata->created_at);
                }

                $success = $data;
                return $this->sendResponse($success, 'Waste Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
