<?php

namespace App\Models\ATAR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Scopes\TrashScope;

use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\ATAR\AtarTypes;
use App\Models\ATAR\HSEHazard;
use App\Models\ATAR\ActionTaken;
use App\Models\ATAR\UAUCStatus;

use Illuminate\Support\Str;
use DB;

use Carbon\Carbon;

class UAUC extends Model
{

    use  HasFactory;


    protected $table = 'atar_uauc';
    protected $primaryKey = 'id';

    protected $fillable = [
        'atar_id',
        'dateandtime',
        'uauc_company_id',
        'location',
        'specific_location',
        'other_speclocation',
        'uauc_category',
        'hse_hazard',
        'usee_remarks',
        'action_taken',
        'company',
        'division',
        'department',
        'job_owner',
        'violators_email',
        'infringement',
        'ssds_serial_number',
        'uact_remarks',
        'reassign_company',
        'reassign_division',
        'reassign_department',
        'reassign_job_owner',
        'reassign_desc',
        'accept_desc',
        'irrelavant_desc',
        'duplicate_desc',
        'close_desc',
        'atar_status',
        'status',
        'trash',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];


    public function locationInfo()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    public function specificLocationInfo()
    {
        return $this->belongsTo(SpecificLocation::class, 'specific_location');
    }

    public function ucucCategoryInfo()
    {
        return $this->belongsTo(AtarTypes::class, 'uauc_category');
    }

    public function actionTakenInfo()
    {
        return $this->belongsTo(ActionTaken::class, 'action_taken');
    }

    public function hseHazardInfo()
    {
        return $this->belongsTo(HSEHazard::class, 'hse_hazard');
    }

    public function statusInfo()
    {
        return $this->belongsTo(UAUCStatus::class, 'atar_status');
    }


    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'atar_uauc.*',
            'atar_uauc.atar_status as status_id',
            'master_location.location_name',
            'users.name',
            'users.company as user_company',
            'users.division as user_division',
            'users.department as user_department',

            'master_location_specific.specific_loc_name',
            'atar_master_atar_types.atar_type',
            'atar_uauc_status.atar_status',
            'atar_uauc_status.bg_colors',
            'master_company.company_name',
        );


        $query = $query->leftJoin('master_location', 'atar_uauc.location', '=', 'master_location.id');
        $query = $query->leftJoin('master_location_specific', 'atar_uauc.specific_location', '=', 'master_location_specific.id');
        $query = $query->leftJoin('atar_master_atar_types', 'atar_uauc.uauc_category', '=', 'atar_master_atar_types.id')
            ->leftJoin('atar_uauc_status', 'atar_uauc.atar_status', '=', 'atar_uauc_status.id')
            ->leftJoin('master_company', 'atar_uauc.company', '=', 'master_company.id')
            ->leftJoin('master_company_department', 'atar_uauc.department', '=', 'master_company_department.id');

        $query = $query->leftJoin('users', 'atar_uauc.created_by', '=', 'users.id');


        /**
         * Role Based list view condition start
         */

        $userId = Auth::id();
        $isAdmin = CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_SUPERADMIN);
        $isJobOwner = CheckUserRole(ROLE_JOBOWNER);
        $isContractor = CheckUserRole(ROLE_CONTRACTORADMIN) || CheckUserRole(ROLE_UAUC_CREATOR) || CheckUserRole(ROLE_CONTRACTORUSER);

        if ($isAdmin) {
            $query->where('atar_uauc.created_by', '!=', '');
        } else {
            $query->where(function ($q) use ($userId, $isJobOwner, $isContractor) {
                // Common condition: user is dept admin
                $q->whereRaw("FIND_IN_SET(?, master_company_department.dept_admin)", [$userId]);

                if ($isJobOwner) {
                    $q->orWhere('atar_uauc.job_owner', $userId)
                        ->orWhere('atar_uauc.reassign_job_owner', $userId)
                        ->orWhere('atar_uauc.created_by', $userId);
                } elseif ($isContractor) {
                    $q->orWhere('atar_uauc.created_by', $userId);
                }
            });
        }

        /**
         * Role Based list view condition end
         */


        if ($request->uauctype != '' && $request->uauctype != null) {
            $uauctype = decryptId($request->uauctype);
            $query = $query->where('uauc_category', $uauctype);
        }
        if ($request->location != '' && $request->location != null) {
            $location = decryptId($request->location);
            $query = $query->where('location', $location);
        }

        if ($request->status != '' && $request->status != null) {
            $status = decryptId($request->status);
            $query = $query->where('atar_uauc.atar_status', $status);
        }

        if ($request->company != '' && $request->company != null) {
            $company = decryptId($request->company);
            $query = $query->where('atar_uauc.company', $company);
        }
        if ($request->department != '' && $request->department != null) {
            $department = decryptId($request->department);
            $query = $query->where('atar_uauc.department', $department);
        }
        if ($request->division != '' && $request->division != null) {
            $division = $request->division;
            $query = $query->where('atar_uauc.division', $division);
        }

        if ($request->user_company != '' && $request->user_company != null) {
            $user_company = decryptId($request->user_company);
            $query = $query->where('users.company', $user_company);
        }
        if ($request->user_department != '' && $request->user_department != null) {
            $user_department = decryptId($request->user_department);
            $query = $query->where('users.department', $user_department);
        }
        if ($request->user_division != '' && $request->user_division != null) {
            $user_division = decryptId($request->user_division);
            $query = $query->where('users.division', $user_division);
        }

        if ($request->spec_location != '' && $request->spec_location != null) {
            $spec_location = $request->spec_location;
            $query = $query->where('atar_uauc.spec_location', $spec_location);
        }

        if ($request->year_filter != '' || $request->year_filter != null) {
            $query->whereYear('atar_uauc.dateandtime', $request->year_filter);
        }
        if ($request->month != '' || $request->month != null) {
            $query->whereMonth('atar_uauc.dateandtime', $request->month);
        }

        if ($request->corrective_action != '' && $request->corrective_action != null) {
            $corrective_action = $request->corrective_action;
            $query = $query->where('atar_uauc.action_taken', $corrective_action);
        }

        if (!empty($request->fromdate)) {
            $from_Date = Carbon::createFromFormat('d-m-Y', $request->fromdate)->startOfDay();
            $query = $query->whereDate('atar_uauc.dateandtime', '>=', $from_Date);
        }

        if (!empty($request->todate)) {
            $to_Date = Carbon::createFromFormat('d-m-Y', $request->todate)->endOfDay();
            $query = $query->whereDate('atar_uauc.dateandtime', '<=', $to_Date);
        }


        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('atar_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('usee_remarks', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_location.location_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('atar_master_atar_types.atar_type', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_location_specific.specific_loc_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%');
            });
        }

        $data_count = $query->count();
        $total_records = $data_count;

        $query->orderBy('id', 'DESC');


        if ($request->length != -1) {
            $query->offset($request->start)->limit($request->length);
        }

        $data = $query->get();

        $datas = [
            'data' => $data,
            'total_records' => $total_records
        ];

        return $datas;
    }

    public function store()
    {

        $request = request();

        $location = decryptId($request->location);
        $uauc_company_id = getLocationCompanyId($location);
        $specific_location = decryptId($request->specific_location);

        $hse_hazard = decryptId($request->hse_hazard);

        $uauc_category = decryptId($request->uauc_category);
        $usee_remarks = $request->usee_remarks;

        $action_taken =  $company = $division = $department = $job_owner = $violators_email = $infringement = $uact_remarks = $ssds_serial_number = null;
        $uact_remarks = $request->uact_remarks;

        $atar_status = 1;

        $insert_log_array = [];

        if ($uauc_category == 1 || $uauc_category == 2) {

            $atar_status = 5;
        } else {
            $action_taken =  decryptId($request->action_taken);
            $company =  decryptId($request->company);
            $division =  decryptId($request->division);
            $department =  decryptId($request->department);
            $job_owner =  decryptId($request->job_owner);
        }


        switch ($action_taken) {

            case 2:
                $atar_status = 5;

                break;
            case 3:
                $violators_email = $request->violators_email;
                $ssds_serial_number = $request->ssds_serial_number;
                $infringement = decryptId($request->infringement);
                $infringement_name = getinfrIngementName($infringement);
                if ($violators_email != '') {
                    $email = "[" . $violators_email . ']';
                } else {
                    $email = '';
                }

                $uact_remarks = $infringement_name . ";" . 'S/NO - ' . $ssds_serial_number . " " . $email;

                break;

            default:
                break;
        }


        $insert_array = array(
            'location' => $location,
            'uauc_company_id' => $uauc_company_id,
            'dateandtime' => DBdateformat($request->dateandtime),
            'specific_location' => $specific_location,
            'other_speclocation' => $request->other_speclocation,
            'uauc_category' => $uauc_category,
            'hse_hazard' => $hse_hazard,
            'usee_remarks' => Str::upper($usee_remarks),
            'action_taken' => $action_taken,
            'company' => $company,
            'division' => $division,
            'department' => $department,
            'job_owner' => $job_owner,
            'violators_email' => $violators_email,
            'ssds_serial_number' => $ssds_serial_number,
            'infringement' => $infringement,
            'uact_remarks' => Str::upper($uact_remarks),
            'atar_status' => $atar_status,
            'created_by' => Auth::id(),
        );


        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $request = request();

        $uauc_status = decryptId($request->uauc_status);

        $update_array = array();


        switch ($uauc_status) {

            case "2":
                $update_array['accept_desc'] = $request->accept_desc;
                break;
            case "3":
                $update_array['reassign_company'] = decryptId($request->company);
                $update_array['reassign_division'] = decryptId($request->division);
                $update_array['reassign_department'] = decryptId($request->department);
                $update_array['reassign_job_owner'] = decryptId($request->job_owner);
                $update_array['reassign_desc'] = $request->reassign_desc;
                break;
            case "4":
                $update_array['irrelavant_desc'] = $request->irrelavant_desc;
                break;
            case "5":
                $update_array['close_desc'] = $request->close_desc;
                break;
            case "6":
                $update_array['duplicate_desc'] = $request->duplicate_desc;
                break;
        }

        if ($uauc_status == 5) {
            $uauc = $this->where('id', $id)->first();
            if ($uauc->action_taken == 3) {
                $uauc_status = UAUC_STATUS_HSC_ACTION_PENDING;
            }
        }

        $update_array['atar_status'] = $uauc_status;

        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id)
    {
        $request = request();

        $type = $request->types;
        if ($type == 1) {
            $update_data = array(
                'status' => 0,
            );
        } else {
            $update_data = array(
                'status' => 1,
            );
        }

        return $this->where('id', $id)->update($update_data);
    }

    public function deleterecord($id)
    {

        $update_data = array(
            'status' => 0,
            'trash' => 'YES',
        );

        return $this->where('id', $id)->update($update_data);
    }

    public function exportdata()
    {
        $request = request();
        $search = '';

        $query = $this->select(
            'atar_uauc.*',
            'master_location.location_name',
            'users.name',
            'users.email',

            'users.company as user_company',
            'users.division as user_division',
            'users.department as user_department',

            'master_company.company_name',
            'master_company_division.division_name',
            'master_location_specific.specific_loc_name',
            'atar_master_atar_types.atar_type',
            'atar_uauc_status.atar_status',
            'atar_master_action_taken.atar_type as action_taken_details',
            'atar_master_hse_hazard.hse_hazard',
            'atar_master_hse_hazard.hover_msg',
            'atar_master_zefa_rules.zefa_rule',
            'atar_uauc_status.atar_status',
            'atar_master_ssds_infringement.infringement_no',
            'atar_master_ssds_infringement.type_of_infringement',
        );

        $query = $query->leftJoin('users', 'atar_uauc.created_by', '=', 'users.id');
        $query = $query->leftJoin('master_company_division', 'atar_uauc.division', '=', 'master_company_division.id');
        $query = $query->leftJoin('master_location', 'atar_uauc.location', '=', 'master_location.id');
        $query = $query->leftJoin('master_location_specific', 'atar_uauc.specific_location', '=', 'master_location_specific.id');
        $query = $query->leftJoin('atar_master_atar_types', 'atar_uauc.uauc_category', '=', 'atar_master_atar_types.id');
        $query = $query->leftJoin('atar_uauc_status', 'atar_uauc.atar_status', '=', 'atar_uauc_status.id')
            ->leftJoin('atar_master_action_taken', 'atar_uauc.action_taken', '=', 'atar_master_action_taken.id')
            ->leftJoin('atar_master_hse_hazard', 'atar_uauc.hse_hazard', '=', 'atar_master_hse_hazard.id')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id')
            ->leftJoin('atar_master_ssds_infringement', 'atar_uauc.infringement', '=', 'atar_master_ssds_infringement.id')
            ->leftJoin('master_company', 'atar_uauc.company', '=', 'master_company.id');

        //Role based validation 

        $userId = Auth::id();
        $isAdmin = CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_SUPERADMIN);
        $isJobOwner = CheckUserRole(ROLE_JOBOWNER);
        $isContractor = CheckUserRole(ROLE_CONTRACTORADMIN) || CheckUserRole(ROLE_UAUC_CREATOR) || CheckUserRole(ROLE_CONTRACTORUSER);

        if ($isAdmin) {
            $query->where('atar_uauc.created_by', '!=', '');
        } else {
            $query->where(function ($q) use ($userId, $isJobOwner, $isContractor) {
                // Common condition: user is dept admin
                $q->whereRaw("FIND_IN_SET(?, master_company_department.dept_admin)", [$userId]);

                if ($isJobOwner) {
                    $q->orWhere('atar_uauc.job_owner', $userId)
                        ->orWhere('atar_uauc.reassign_job_owner', $userId)
                        ->orWhere('atar_uauc.created_by', $userId);
                } elseif ($isContractor) {
                    $q->orWhere('atar_uauc.created_by', $userId);
                }
            });
        }

        if ($request->uauctype != '' && $request->uauctype != null) {
            $uauctype = decryptId($request->uauctype);
            $query = $query->where('uauc_category', $uauctype);
        }
        if ($request->location != '' && $request->location != null) {
            $location = decryptId($request->location);
            $query = $query->where('location', $location);
        }

        if ($request->status != '' && $request->status != null) {
            $status = decryptId($request->status);
            $query = $query->where('atar_uauc.atar_status', $status);
        }

        if ($request->company != '' && $request->company != null) {

            $company = decryptId($request->company);
            $query = $query->where('atar_uauc.company', $company);
        }
        if ($request->department != '' && $request->department != null) {
            $department = decryptId($request->department);
            $query = $query->where('atar_uauc.department', $department);
        }
        if ($request->user_company != '' && $request->user_company != null) {
            $user_company = decryptId($request->user_company);
            $query = $query->where('users.company', $user_company);
        }
        if ($request->user_department != '' && $request->user_department != null) {
            $user_department = decryptId($request->user_department);
            $query = $query->where('users.department', $user_department);
        }
        if ($request->user_division != '' && $request->user_division != null) {
            $user_division = decryptId($request->user_division);
            $query = $query->where('users.division', $user_division);
        }
        if ($request->division != '' && $request->division != null) {
            $division = $request->division;
            $query = $query->where('atar_uauc.division', $division);
        }
        if ($request->spec_location != '' && $request->spec_location != null) {
            $spec_location = $request->spec_location;
            $query = $query->where('atar_uauc.spec_location', $spec_location);
        }

        if ($request->corrective_action != '' && $request->corrective_action != null) {
            $corrective_action = $request->corrective_action;
            $query = $query->where('atar_uauc.action_taken', $corrective_action);
        }

        if ($request->year_filter != '' || $request->year_filter != null) {
            $query->whereYear('atar_uauc.dateandtime', $request->year_filter);
        }
        if ($request->month != '' || $request->month != null) {
            $query->whereMonth('atar_uauc.dateandtime', $request->month);
        }


        if (!empty($request->fromdate)) {
            $from_Date = Carbon::createFromFormat('d-m-Y', $request->fromdate)->startOfDay();
            $query = $query->whereDate('atar_uauc.dateandtime', '>=', $from_Date);
        } else {
            // Default: first day of current month - 3 months
            $from_Date = Carbon::now()->subMonthsNoOverflow(2)->startOfMonth();
            $query = $query->whereDate('atar_uauc.dateandtime', '>=', $from_Date);
        }

        if (!empty($request->todate)) {
            $to_Date = Carbon::createFromFormat('d-m-Y', $request->todate)->endOfDay();
            $query = $query->whereDate('atar_uauc.dateandtime', '<=', $to_Date);
        } else {
            // Default: last day of current month
            $to_Date = Carbon::now()->endOfMonth();
            $query = $query->whereDate('atar_uauc.dateandtime', '<=', $to_Date);
        }


        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('atar_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_location.location_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('atar_master_atar_types.atar_type', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_location_specific.specific_loc_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('users.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('master_company.company_name', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('atar_uauc.id', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $query = $this->select(
            'atar_uauc.id',
            'atar_uauc.dateandtime',
            'atar_uauc.infringement',
            'atar_uauc.ssds_serial_number',
            'atar_uauc.job_owner',
            'atar_uauc.atar_id',
            'atar_uauc.other_speclocation',
            'atar_uauc.uauc_category',
            'atar_uauc.reassign_desc',
            'atar_uauc.irrelavant_desc',
            'atar_uauc.duplicate_desc',
            'atar_uauc.accept_desc',
            'atar_uauc.close_desc',
            'atar_uauc.violators_email',
            'atar_uauc.atar_status as atar_status_id',
            'atar_uauc.action_taken',
            'atar_master_action_taken.atar_type as action_taken_details',
            'atar_uauc.created_by',
            'atar_uauc.usee_remarks',
            'atar_uauc.uact_remarks',
            'atar_master_hse_hazard.hse_hazard',
            'atar_master_hse_hazard.hover_msg',
            'atar_master_zefa_rules.zefa_rule',
            'atar_uauc.created_at',
            'master_location.location_name',
            'master_location_specific.specific_loc_name',
            'master_company.company_name',
            'master_company_division.division_name',
            'master_company_department.department_name',
            'atar_master_atar_types.atar_type',
            'atar_uauc_status.atar_status',
            'atar_master_ssds_infringement.infringement_no',
            'atar_master_ssds_infringement.type_of_infringement',
            'users.name',
        )
            ->leftJoin('atar_master_atar_types', 'atar_uauc.uauc_category', '=', 'atar_master_atar_types.id')
            ->leftJoin('atar_master_action_taken', 'atar_uauc.action_taken', '=', 'atar_master_action_taken.id')

            ->leftJoin('master_company', 'atar_uauc.company', '=', 'master_company.id')
            ->leftJoin('master_company_division', 'atar_uauc.division', '=', 'master_company_division.id')
            ->leftJoin('master_company_department', 'atar_uauc.department', '=', 'master_company_department.id')
            ->leftJoin('master_location', 'atar_uauc.location', '=', 'master_location.id')
            ->leftJoin('master_location_specific', 'atar_uauc.specific_location', '=', 'master_location_specific.id')

            ->leftJoin('atar_master_hse_hazard', 'atar_uauc.hse_hazard', '=', 'atar_master_hse_hazard.id')
            ->leftJoin('atar_master_zefa_rules', 'atar_master_hse_hazard.zefa_rule', '=', 'atar_master_zefa_rules.id')

            ->leftJoin('users', 'atar_uauc.created_by', '=', 'users.id')
            ->leftJoin('atar_uauc_status', 'atar_uauc.atar_status', '=', 'atar_uauc_status.id')
            ->leftJoin('atar_master_ssds_infringement', 'atar_uauc.infringement', '=', 'atar_master_ssds_infringement.id')

            ->where('atar_uauc.id', $id)
            ->first();

        return $data;
    }

    public function statusCount($type)
    {

        switch ($type) {
            case 1:
                $count = $this->where('atar_status', $type)->count();
                break;
            case 2:
                $count = $this->where('atar_status', $type)->count();
                break;
            case 3:
                $count = $this->where('atar_status', $type)->count();
                break;
            case 4:
                $count = $this->where('atar_status', $type)->count();
                break;
            case 5:
                $count = $this->where('atar_status', $type)->count();
                break;

            default:
                $count = $this->count();
                break;
        }

        return $count;
    }

    public function chartData()
    {
        $query = $this->select(
            'master_location.location_name',
            'atar_master_atar_types.atar_type',
            DB::raw('count(*) as count')
        );
        $query = $query->leftJoin('master_location', 'atar_uauc.location', '=', 'master_location.id');
        $query = $query->leftJoin('atar_master_atar_types', 'atar_uauc.uauc_category', '=', 'atar_master_atar_types.id');
        $query = $query->groupBy('atar_uauc.location', 'atar_uauc.uauc_category');

        return  $query->get();
    }

    public function hseSubmit($id)
    {

        $request = request();

        $update_array = array(
            'atar_status' => UAUC_STATUS_CLOSE,
            'hsc_remarks' => $request->hsc_remarks,
            'updated_by' => Auth::id()
        );

        $this->where('id', $id)->update($update_array);

        $updatedData = $this->where('id', $id)->first();

        return $updatedData;
    }

    public function getUAUCRecords($company, $division, $department, $location, $spec_location, $year, $month)
    {

        $query = $this->newQuery();

        if ($company != '' || $company != null) {
            $query->where('company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('dateandtime', $month);
        }

        return $query->count();
    }

    public function getUAUCCategory($company, $division, $department, $location, $spec_location, $year, $month, $category)
    {

        $query = $this->where('uauc_category', $category)
            ->where('uauc_category', '!=', 'null');

        if ($company != '' || $company != null) {
            $query->where('company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('dateandtime', $month);
        }

        return $query->count();
    }

    public function getHSCHazard($company, $division, $department, $location, $spec_location, $year, $month)
    {

        $query = $this->newQuery()
            ->selectRaw('hse_hazard, COUNT(*) as count')
            ->where('hse_hazard', '!=', 'null')
            ->groupBy('hse_hazard');

        if ($company != '' || $company != null) {
            $query->where('company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('dateandtime', $month);
        }

        return $query->pluck('count', 'hse_hazard');
    }

    public function getCorrective($company, $division, $department, $location, $spec_location, $year, $month, $action_taken)
    {

        $query = $this->where('action_taken', $action_taken)
            ->where('action_taken', '!=', 'null');


        if ($company != '' || $company != null) {
            $query->where('company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('dateandtime', $month);
        }

        return $query->count();
    }

    public function getZeFAData($company, $division, $department, $location, $spec_location, $year, $month)
    {
        $query = $this->newQuery()
            ->leftJoin('atar_master_hse_hazard AS hse', 'hse.id', '=', 'atar_uauc.hse_hazard')
            ->leftJoin('atar_master_zefa_rules AS zefa', 'zefa.id', '=', 'hse.zefa_rule')
            ->selectRaw('zefa.id AS zefa_rule_id, zefa.zefa_rule, COUNT(*) as count')
            ->where('atar_uauc.hse_hazard', '!=', 'null')
            ->groupBy('zefa.id', 'zefa.zefa_rule');


        if ($company != '' || $company != null) {
            $query->where('atar_uauc.company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('atar_uauc.division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('atar_uauc.department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('atar_uauc.location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('atar_uauc.spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('atar_uauc.dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('atar_uauc.dateandtime', $month);
        }

        return $query->pluck('count', 'zefa_rule');
    }

    public function getInfringementData($company, $division, $department, $location, $spec_location, $year, $month)
    {

        $query = $this->newQuery()
            ->selectRaw('infringement, COUNT(*) as count')
            ->where('infringement', '!=', 'null')
            ->groupBy('infringement');

        if ($company != '' || $company != null) {
            $query->where('company', $company);
        }

        if ($division != '' || $division != null) {
            $query->where('division', $division);
        }

        if ($department != '' || $department != null) {
            $query->where('department', $department);
        }

        if ($location != '' || $location != null) {
            $query->where('location', $location);
        }

        if ($spec_location != '' || $spec_location != null) {
            $query->where('spec_location', $spec_location);
        }

        if ($year != '' || $year != null) {
            $query->whereYear('dateandtime', $year);
        }

        if ($month != '' || $month != null) {
            $query->whereMonth('dateandtime', $month);
        }

        return $query->pluck('count', 'infringement');
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('atar_uauc'));

        static::created(function ($model) {

            $uniqueId = 'UAUC-' . date('Y') . "-" . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['atar_id' => $uniqueId]);
        });
    }
}

