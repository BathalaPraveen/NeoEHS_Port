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
use App\Models\WasteManagement\WasteCategory;
use App\Models\WasteManagement\WasteItem;


class WasteRegisterController extends BaseController
{
    /**
     * Waste Register api
     *
     * @return \Illuminate\Http\Response
     */

    private $wastetype;
    private $wasteregister;
    private $wastecategory;
    private $wasteitem;


    public function __construct()
    {
        $this->wastetype = new WasteType();
        $this->wasteregister = new WasteRegister();
        $this->wastecategory = new WasteCategory();
        $this->wasteitem = new WasteItem();
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


            $list_array = WasteRegister::select(
                'wastemanagement_waste_register.*',
                'wastemanagement_master_wastetype.wastetype_id',
                'wastemanagement_master_wastetype.wastetype_name',
                'wastemanagement_master_item.item_name as wasteform',
            )
                ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_register.waste_code')
                ->join('wastemanagement_master_item', 'wastemanagement_master_item.id', '=', 'wastemanagement_waste_register.waste_form');

            $list_array->where('wastemanagement_waste_register.company_id', $companyid);

            if ($request->wastetype != '') {
                $list_array->where('wastemanagement_waste_register.waste_code', decryptId($request->wastetype));
            }

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

            $final_list = $list_array->toArray();

            $data_array = [];
            foreach ($list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['waste_code'] = $listdata->wastetype_id;
                $data['waste_name'] = $listdata->wastetype_name;
                $data['waste_form'] = $listdata->wasteform;
                $data['notification_date'] =  Displaydateformat($listdata->notification_date);
                $data['notification_no'] = $listdata->notification_no;
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

                $list_array = WasteRegister::select(
                    'wastemanagement_waste_register.*',
                    'wastemanagement_master_wastetype.wastetype_id',
                    'wastemanagement_master_wastetype.wastetype_name',
                    'wastemanagement_master_item.item_name as wasteform',
                )
                    ->join('wastemanagement_master_wastetype', 'wastemanagement_master_wastetype.id', '=', 'wastemanagement_waste_register.waste_code')
                    ->join('wastemanagement_master_item', 'wastemanagement_master_item.id', '=', 'wastemanagement_waste_register.waste_form');

                $list_array->where('wastemanagement_waste_register.id', $id);


                $list_array = $list_array->orderBy('id', 'DESC')->get();

                $data = [];
                foreach ($list_array as $listdata) {


                    $data['id'] = $listdata->id;
                    $data['waste_code'] = $listdata->wastetype_id;
                    $data['waste_name'] = $listdata->wastetype_name;
                    $data['waste_form'] = $listdata->wasteform;
                    $data['notification_date'] =  Displaydateformat($listdata->notification_date);
                    $data['notification_no'] = $listdata->notification_no;
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
