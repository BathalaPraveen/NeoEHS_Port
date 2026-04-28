<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

use App\Models\Master\Company;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

class MasterController extends BaseController
{
    /**
     * Master api
     *
     * @return \Illuminate\Http\Response
     */
    public function company(Request $request): JsonResponse
    {

        if (Auth::user()) {

            $company_details = Company::select('id', 'company_name')->get();

            $success = [
                'company_details' => $company_details,
            ];

            return $this->sendResponse($success, 'Company Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function division(Request $request): JsonResponse
    {

        $rules = [
            'company_id' => 'required',
        ];

        $messages = [
            'company_id.required' => 'Company ID is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }


        if (Auth::user()) {

            $division_details = Division::select('id', 'division_name')->where('company_id', $request->company_id)->get();

            $success = [
                'division_details' => $division_details,
            ];

            return $this->sendResponse($success, 'Division Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function department(Request $request): JsonResponse
    {


        $rules = [
            'company_id' => 'required',
            'division_id' => 'required',

        ];

        $messages = [
            'company_id.required' => 'Company ID is required.',
            'division_id.required' => 'Division ID is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }


        if (Auth::user()) {

            $department_details = Department::select('id', 'department_name')
                ->where('company_id', $request->company_id)
                ->where('division_id', $request->division_id)
                ->get();

            $success = [
                'department_details' => $department_details,
            ];

            return $this->sendResponse($success, 'Department Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function location(Request $request): JsonResponse
    {


        if (Auth::user()) {

            $company_id = '';
            if($request->has('company_id')){
                $company_id = $request->company_id;
            }

            $location_details = Location::select('id', 'location_name');

            if( $company_id != '' &&  $company_id != null){
                $location_details =  $location_details->where('company_id' ,$company_id);
            }

            $location_details =  $location_details->get();

            $success = [
                'location_details' => $location_details,
            ];

            return $this->sendResponse($success, 'Location Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function specificlocation(Request $request): JsonResponse
    {

        $rules = [
            'location_id' => 'required',
        ];

        $messages = [
            'location_id.required' => 'Location ID is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }


        if (Auth::user()) {

            $specific_location_details = SpecificLocation::select('id', 'specific_loc_name')
                ->where('location_id', $request->location_id)
                ->get();

            $success = [
                'specific_location_details' => $specific_location_details,
            ];

            return $this->sendResponse($success, 'Specific Location Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function jobOwner(Request $request): JsonResponse
    {

        $rules = [
            'company_id' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
        ];

        $messages = [
            'company_id.required' => 'Company ID is required.',
            'division_id.required' => 'Division ID is required.',
            'department_id.required' => 'Department ID is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        if (Auth::user()) {

            $jobowner_details = User::select('id', 'name')
                ->where('company', $request->company_id)
                ->where('division', $request->division_id)
                //->where('department', $request->department_id)
                ->whereRaw('FIND_IN_SET(?, job_owner_department)', [$request->department_id])
                ->whereRaw('FIND_IN_SET(?, role)', [ROLE_JOBOWNER])
                ->get();

            $success = [
                'jobowner_details' => $jobowner_details,
            ];

            return $this->sendResponse($success, 'Specific Location Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function jobOwnerName(Request $request): JsonResponse
    {

        $rules = [
            'company_id' => 'required',
            'division_id' => 'required',
            'department_id' => 'required',
        ];

        $messages = [
            'company_id.required' => 'Company ID is required.',
            'division_id.required' => 'Division ID is required.',
            'department_id.required' => 'Department ID is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }


        if (Auth::user()) {

            $jobowner_details = User::select('id', 'name')
                ->where('company', $request->company_id)
                ->where('division', $request->division_id)
                //->where('department', $request->department_id)
                ->whereRaw('FIND_IN_SET(?, job_owner_department)',  [$request->department_id])
                ->whereRaw('FIND_IN_SET(?, role)', [ROLE_JOBOWNER])
                ->first();
            $jobowner_name = '';
            if ($jobowner_details != '' && $jobowner_details != null) {
                $jobowner_name = $jobowner_details['name'];
            }

            $success = [
                'jobowner_details' => $jobowner_name,
            ];

            return $this->sendResponse($success, 'Specific Location Data');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
