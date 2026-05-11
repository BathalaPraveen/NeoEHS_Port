<?php

namespace App\Http\Controllers\PTW;

use PDF;
use Mail;
use Exception;

use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Models\PTW\Gas;
use App\Models\PTW\Diving;
use App\Models\PTW\Hazard;
use App\Models\PTW\General;
use App\Models\PTW\Hotwork;

use App\Models\PTW\Lifting;
use App\Models\PTW\PTWFile;
use App\Models\PTW\PTWItem;

use App\Models\PTW\Surface;
use App\Models\PTW\Traffic;
use App\Models\PTW\Severity;
use Illuminate\Http\Request;
use App\Models\PTW\Isolation;
use App\Models\Master\Company;
use App\Models\PTW\Likelihood;

use App\Models\PTW\RiskMatrix;
use App\Models\Master\Location;
use App\Models\PTW\PTWActivity;

use App\Models\PTW\PTWCategory;
use App\Models\PTW\PermitStatus;
use App\Models\PTW\PTWSubPermit;
use App\Mail\PTW\GeneralPTWEmail;
use App\Models\Master\Contractor;
use App\Models\Master\Designation;
use App\Models\PTW\HazardCategory;
use App\Models\PTW\PermitStatusLog;
use App\Http\Controllers\Controller;
use App\Models\PTW\PTWSubWorkPermit;
use Illuminate\Support\Facades\Auth;
use App\Models\Master\WorkTypeMaster;
use App\Models\PTW\HazardSubCategory;
use App\Models\Master\SpecificLocation;
use Illuminate\Support\Facades\Session;
use App\Models\Master\ContractorCompany;
use App\Models\PTW\Reassign;
use Illuminate\Support\Facades\Validator;
use Spatie\SimpleExcel\SimpleExcelWriter;




class GeneralController extends Controller
{

    private $category;
    private $item;
    private $company;
    private $location;
    private $designation;
    private $contractor;
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

    private $Work_type;
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
        $this->contractor = new Contractor();
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
        $this->Work_type = new WorkTypeMaster();
        $this->reassign_log = new Reassign();
    }

    public function index(Request $request)
    {

        if (Auth::check()) {
            if ($request->ajax()) {

                try {

                    $data =  $this->general->list();

                    $datatables = Datatables::of($data['data'])
                        ->addIndexColumn()
                        ->addColumn('created_date', function ($row) {

                            return Displaydatetimeformat($row->created_at);
                        })
                        ->addColumn('status', function ($row) {

                            $text = permitStatus($row->ptw_status);

                            if ($row->ptw_status == PERMIT_STATUS_AO_PENDING && (subpermitcount($row->id) == 0)) {
                                $text = str_replace("Sub Work Permit Approved", "Area Owner Approval pending", $text);
                            }

                            return $text;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '';
                            if ($row->ptw_status != PERMIT_STATUS_DRAFT) {

                                $btn = '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '"   class="" title="View"><i class="fa-solid fa-eye"></i></a> ';

                                if ($row->ptw_status != PERMIT_STATUS_PTW_HOLD) {

                                    if ($row->ptw_status == PERMIT_STATUS_PTW_APPROVED) {
                                        $btn .= '<a href="' . admin_url('ptw/general/addPTW/' . encryptId($row->id)) . '" class=" " title="Add Sub Permit"><i class="fa-solid fa-square-plus fs-5 me-1"></i></a>';
                                    }
                                    if ($row->ptw_status == PERMIT_STATUS_AO_PENDING && ($row->area_owner == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                        $btn .= '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '/aoapprove" class=" " title="Area Owner Approval / Rejection"><i class="fa-solid fa-check-to-slot"></i> </a>';
                                    }
                                    if ($row->ptw_status == PERMIT_STATUS_GHSE_PENDING && (CheckUserRole(ROLE_GHSE_APPROVER) || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                        $btn .= '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '/ghseapprove" class=" " title="GHSE Approval / Rejection"><i class="fa-solid fa-check-to-slot"></i> </a>';
                                    }
                                    if ($row->ptw_status == PERMIT_STATUS_SA_PENDING && ($row->supervising_authority == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                        $btn .= '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '/saapprove" class=" " title="Supervising Authority Approval / Rejection"><i class="fa-solid fa-check-to-slot"></i> </a>';
                                    }
                                    if ($row->ptw_status == PERMIT_STATUS_PTW_APPROVED && ($row->created_by == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                        $btn .= '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '/close" class=" " title="PTW Close"><img style="width:20px;vertical-align: sub;" src="' . url('public/assets/images/icons/tick.png') . '" alt="Approve/ Reject" > </a>';
                                    }

                                    $canReassign = false;

                                    $isAdminOrHSE = isAdmin() || CheckUserRole(ROLE_HSEUSER);

                                    if (
                                        ($row->ptw_status == PERMIT_STATUS_AO_PENDING && ($row->area_owner == Auth::id() || $isAdminOrHSE)) ||
                                        ($row->ptw_status == PERMIT_STATUS_SA_PENDING && ($row->supervising_authority == Auth::id() || $isAdminOrHSE))
                                    ) {
                                        $canReassign = true;
                                    }

                                    if ($canReassign) {
                                        $btn .= '<a href="' . admin_url('ptw/general/view/' . encryptId($row->id)) . '/reassign" class="" title="PTW Reassign">
                                        <i class="fa-solid fa-arrows-rotate fs-5 me-1"></i>
                                    </a>';
                                    }
                                }
                            }

                            $statusArray = [PERMIT_STATUS_AO_REJECTED, PERMIT_STATUS_GHSE_REJECTED, PERMIT_STATUS_SA_REJECTED, PERMIT_STATUS_DRAFT];
                            if (in_array($row->ptw_status, $statusArray) && ($row->created_by  == Auth::id() || isAdmin())) {
                                $btn .= '<a href="' . admin_url('ptw/general/edit/' . encryptId($row->id)) . '" class=" " title="Edit"><i class="fa-solid fa-pen-to-square"></i> </a>';
                            }
                            $btn .= '<a href="' . admin_url('ptw/general/view/pdf/' . encryptId($row->id)) . '" class=" " title="Pdf"><i class="fa fa-file-pdf-o"></i> ';

                            if ($row->ptw_status != PERMIT_STATUS_DRAFT) {

                                //Hold PTW

                                if ($row->ptw_status == PERMIT_STATUS_PTW_APPROVED  && (isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                    $btn .= '<a href="javascript:void(0);" data-id="' . encryptId($row->id) . '" class="btn-ptw-hold" title="PTW Hold"><i class="fa-solid fa-circle-pause text-warning fs-5 me-1"></i></a>';
                                }

                                //Un Hold PTW

                                if ($row->ptw_status == PERMIT_STATUS_PTW_HOLD && (isAdmin() || CheckUserRole(ROLE_HSEUSER))) {
                                    $btn .= '<a href="javascript:void(0);" data-id="' . encryptId($row->id) . '" class="btn-ptw-unhold" title="PTW UnHold"><i class="fa-solid fa-circle-play text-success fs-5 ms-1 me-1"></i></a>';
                                }
                            }

                            $btn .= '<a href="javascript:void(0);"  data-id="' . encryptId($row->id) . '"  class="recordDelete" title="Delete"><i class="fa-solid fa-trash text-danger" ></i></i></a> ';
                            return $btn;
                        })
                        ->rawColumns(['action', 'created_date', 'created_by', 'status'])
                        ->setFilteredRecords($data['total_records'])
                        ->setTotalRecords($data['total_records'])
                        ->skipPaging()
                        ->make(true);
                    return $datatables;
                } catch (Exception $ex) {

                    return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
                }
            }
        }

        $locationDetails = $this->location->get();
        $subpermitDetails = $this->subworkpermit->where('id', '>', 0)->get();
        $statusDetails = $this->status->get();

        $data = array(
            'locationDetails' => $locationDetails,
            'subpermitDetails' => $subpermitDetails,
            'statusDetails' => $statusDetails,
        );

        return view('ptw.general.list', $data);
    }

    public function Add(Request $request)
    {

        try {

            $companyDetails = $this->company->getAllCompany();

            $locationDetails = $this->location->getAllLocation();
            $designationDetails = $this->designation->get();
            $contractorCompanyDetails = $this->contractorCompany->get();


            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
            $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
            $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
            $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
            $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);
            $subworkpermit =  $this->subworkpermit->get();

            $likelihood = $this->likelihood->orderBy('id', 'DESC')->get();
            $severity = $this->severity->orderBy('id', 'DESC')->get();
            $riskmatrix = $this->riskmatrix->get()->keyBy('rating')->toArray();

            $hazardCategoryDetails = $this->hazardcategory->get();
            $workTypeDetails = $this->Work_type->getAllWorktypeData();

            $data = array(
                'companyDetails' => $companyDetails,
                'hazardDetails' => $hazardDetails,
                'supportCertificate' => $supportCertificate,
                'protectiveEquipment' => $protectiveEquipment,
                'protectiveEquipmentItems' => $protectiveEquipmentItems,
                'sitePreparationDetails' => $sitePreparationDetails,
                'locationDetails' => $locationDetails,
                'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'subworkpermit' => $subworkpermit,
                'likelihoodDetails' => $likelihood,
                'severityDetails' => $severity,
                'riskmatrixDetails' => $riskmatrix,
                'hazardCategoryDetails' => $hazardCategoryDetails,
                'workTypeDetails' => $workTypeDetails,

            );
            return view('ptw.general.add', $data);
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function Store(Request $request)
    {
        try {

            if (!($request->has('draft'))) {

                $rules = [
                    'company' => 'required',
                    'location' => 'required',
                    'workdescription' => 'required',
                    'accept_terms' => 'required',
                ];
                $messages = [
                    'company.required' => 'Please enter Location ID',
                    'location.required' => 'Please enter Location Name',
                    'workdescription.required' => 'Please enter General PTW Name',
                    'accept_terms.required' => 'Please enter General PTW Name',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            try {

                $generalptw = $this->general->store();

                $insert_array = array(
                    'permit_type' => PTW_PERMIT_GENERAL,
                    'ptw_id' => $generalptw->id,
                    'sub_permit_id' => 0,
                    'from_status' => 0,
                    'to_status' => $generalptw->ptw_status,
                    'is_reject' => 0,
                    'remarks' => $request->remarks,
                    'approved_by' => Auth::id(),
                );
                $this->permitstatuslog->create($insert_array);

                $this->hazard->store($generalptw);

                $this->ptwfile->general($generalptw);

                if (!($request->has('draft'))) {

                    $subPermit = '';
                    $subpermitDetails = $generalptw->sub_work_permit;
                    if ($subpermitDetails != null && $subpermitDetails != '') {
                        $subpermitArray =  $this->ptwsubpermit->store($generalptw->id, string_to_array($subpermitDetails));
                        $subPermit = $subpermitArray->sub_permit_id;
                    }


                    /**
                     * Notification send
                     */

                    sendNotificationGeneral($generalptw);

                    if ($subPermit  != '') {

                        Session::flash('success', 'General PTW added successfully!');

                        $redirectLink = 'ptw/general/list/';

                        switch ($subPermit) {

                            case PTW_SUB_PERMIT_GAS:
                                $redirectLink = 'ptw/gastest/add/';
                                break;
                            case PTW_SUB_PERMIT_ISOLATION:
                                $redirectLink = 'ptw/isolation/add/';
                                break;
                            case PTW_SUB_PERMIT_SURFACE:
                                $redirectLink = 'ptw/surfaceprnetration/add/';
                                break;
                            case PTW_SUB_PERMIT_HOTWORK:
                                $redirectLink = 'ptw/hotwork/add/';
                                break;
                            case PTW_SUB_PERMIT_WORKTRAFFIC:
                                $redirectLink = 'ptw/worktraffic/add/';
                                break;
                            case PTW_SUB_PERMIT_LIFTING:
                                $redirectLink = 'ptw/lifting/add/';
                                break;
                            case PTW_SUB_PERMIT_DIVING:
                                $redirectLink = 'ptw/diving/add/';
                                break;
                        }

                        $ptwId = $generalptw->id;
                        $redirectLink = $redirectLink . encryptId($ptwId);

                        return redirect(admin_url($redirectLink));
                    }
                }

                Session::flash('success', 'General PTW added successfully!');
            } catch (Exception $ex) {

                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {

            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function View(Request $request)
    {
        try {

            $id = decryptId($request->id);



            $general = $this->general->find($id);

            $isContractor = 0;
            $contractorCompanyName = '';
            $createduser = $general->created_by;
            $userdetails = User::find($createduser);

            if ($userdetails->user_type) {

                $isContractor = 1;
                $contractor = $this->contractor->where('login_id', $userdetails->id)->first();
                $contractorcompanyid = $contractor?->cont_company_id;
                $contractorCompany = $this->contractorCompany->find($contractorcompanyid);
                $contractorCompanyName = $contractorCompany?->con_comp_name;
            }

            if ($contractorCompanyName == '' || $contractorCompanyName == null) {
                $isContractor = 0;
            }

            $generalpermitStatusLog = $this->permitstatuslog->getDetails(PTW_PERMIT_GENERAL, $id, $id);

            $companyDetails = $this->company->get();

            $locationDetails = $this->location->get();
            $designationDetails = $this->designation->get();
            $contractorCompanyDetails = $this->contractorCompany->get();

            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
            $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
            $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
            $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
            $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
                'file_type' => 1
            );

            $hazardfile =  $this->ptwfile->getWhere($whereArray);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
                'file_type' => 2
            );

            $supportCertificateFile =  $this->ptwfile->getWhere($whereArray);
            $subpermitDetails =  $this->ptwsubpermit->getPermit($id);
            /**
             * Gas Test
             */

            $whereArray = array(
                'ptw_id' => $id
            );

            $gas = $this->gas->selectOneWhere($whereArray);
            $gaspermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_GAS, $id, $gas?->id);

            /**
             * Isolation
             */
            $isolation = $this->isolation->selectOneWhere($whereArray);
            $ppelist = $this->category->getWhere(PTW_CAT_ISOLATION_PPE);
            $isolationpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_ISOLATION, $id, $isolation?->id);

            /**
             * Surface
             */
            $surface = $this->surface->selectOneWhere($whereArray);
            $surfaceppe = $this->category->getWhere(PTW_CAT_SURFACE_PPE);
            $equipments = $this->category->getWhere(PTW_CAT_SURFACE_EQUIPMENT);
            $aditionalrequierments = $this->category->getWhere(PTW_CAT_SURFACE_ADDITIONAL_REQUIREMENTS);
            $surfacepermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_SURFACE, $id, $surface?->id);

            /**Area Owner Rejected
             * Hotwork
             */
            $hotwork = $this->hotwork->selectOneWhere($whereArray);
            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
            $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $id, $hotwork?->id);

            /**
             * Work Traffic
             */
            $traffic = $this->traffic->selectOneWhere($whereArray);
            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $whereArrayfile = array(
                'ptw_id' => $traffic?->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic?->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArrayfile);
            $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $id, $traffic?->id);

            /**
             * Lifting
             */
            $lifting = $this->lifting->selectOneWhere($whereArray);
            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
            $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_LIFTING, $id, $lifting?->id);

            $whereArrayfiles = array(
                'ptw_id' => $lifting?->ptw_id,
                'ptw_module' => 6,
                'reference_id' => $lifting?->id,
            );

            $liftingdocument =  $this->ptwfile->getWhererby($whereArrayfiles);


            /**
             * Diving
             */
            $diving = $this->diving->selectOneWhere($whereArray);
            $equipmentgear = $this->category->getWhere(PTW_CAT_DIVING_EQUIPMENT);
            $divingsitepreparation = $this->category->getWhere(PTW_CAT_DIVING_SITE_PREPARATION);
            $divingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_DIVING, $id, $diving?->id);


            $approvetype = $request->approvetype;


            $likelihood = $this->likelihood->orderBy('id', 'DESC')->get();
            $severity = $this->severity->orderBy('id', 'DESC')->get();
            $riskmatrix = $this->riskmatrix->get()->keyBy('rating')->toArray();

            $generalhazardDetails = $this->hazard->getgeneral($id);

            //job owner data

            $specificLocationData = $this->specificlocation->selectOne($general->specific_location);
            $specificlocation = !empty($specificLocationData) ? $specificLocationData->area_owner : null;

            $job_owners = string_to_array($specificlocation);
            $job_owners = array_filter($job_owners, function ($id) use ($general) {
                return $id != $general->area_owner ?? null;
            });
            $job_owners = array_values($job_owners);

            //supervising authority data

            $workTypeData = $this->Work_type->selectOne($general->work_type);
            $work_type = !empty($workTypeData) ? $workTypeData->supervising_authority : null;

            $supervising_authority = string_to_array($work_type);

            $supervising_authority = array_filter($supervising_authority, function ($id) use ($general) {
                return $id != $general->supervising_authority ?? null;
            });

            $supervising_authority = array_values($supervising_authority);


            $reassignLog = $this->reassign_log->getLog($id);


            $data = array(
                'companyDetails' => $companyDetails,
                'hazardDetails' => $hazardDetails,
                'hazardfile' => $hazardfile,
                'supportCertificate' => $supportCertificate,
                'protectiveEquipment' => $protectiveEquipment,
                'protectiveEquipmentItems' => $protectiveEquipmentItems,
                'sitePreparationDetails' => $sitePreparationDetails,
                'locationDetails' => $locationDetails,
                'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'supportCertificateFile' => $supportCertificateFile,
                'general' => $general,
                'generalpermitStatusLog' => $generalpermitStatusLog,
                'subpermitDetails' => $subpermitDetails,

                'gas' => $gas,
                'gaspermitStatusLog' => $gaspermitStatusLog,

                'isolation' => $isolation,
                'ppelist' => $ppelist,
                'isolationpermitStatusLog' => $isolationpermitStatusLog,

                'surface' => $surface,
                'surfaceppe' => $surfaceppe,
                'equipments' => $equipments,
                'aditionalrequierments' => $aditionalrequierments,
                'surfacepermitStatusLog' => $surfacepermitStatusLog,

                'hotwork' => $hotwork,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'hotworkpermitStatusLog' => $hotworkpermitStatusLog,

                'traffic' => $traffic,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'trafficplandocument' => $trafficplandocument,
                'trafficpermitStatusLog' => $trafficpermitStatusLog,

                'lifting' => $lifting,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingpermitStatusLog' => $liftingpermitStatusLog,
                'liftingdocument' => $liftingdocument,

                'diving' => $diving,
                'equipmentgear' => $equipmentgear,
                'divingsitepreparation' => $divingsitepreparation,
                'divingpermitStatusLog' => $divingpermitStatusLog,

                'approvetype' => $approvetype,

                'likelihoodDetails' => $likelihood,
                'severityDetails' => $severity,
                'riskmatrixDetails' => $riskmatrix,
                'generalhazardDetails' => $generalhazardDetails,

                'isContractor' => $isContractor,
                'contractorCompanyName' => $contractorCompanyName,

                'job_owners' => $job_owners,
                'supervising_authority' => $supervising_authority,
                'reassignLog' => $reassignLog,

            );


            return view('ptw.general.view', $data);
        } catch (Exception $ex) {

            dd($ex);
        }
    }

    public function AOApproveRejectSubmit(Request $request)
    {
        try {

            $id = decryptId($request->id);
            $permit = $this->general->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_GHSE_PENDING;
            } else if ($request->has('reject')) {
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

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function GHSEApproveRejectSubmit(Request $request)
    {
        try {

            $id = decryptId($request->id);
            $permit = $this->general->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_SA_PENDING;
            } else if ($request->has('reject')) {
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

                $notifywhere = array(
                    'id' => $permit->supervising_authority,
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

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

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function SAApproveRejectSubmit(Request $request)
    {
        try {

            $id = decryptId($request->id);
            $permit = $this->general->find($id);

            if ($request->has('approve')) {
                $is_reject = 0;
                $ptw_status = PERMIT_STATUS_PTW_APPROVED;
            } else if ($request->has('reject')) {
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

                $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " . 'Your PTW request is Approved';
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

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function PTWCloseSubmit(Request $request)
    {
        try {

            $id = decryptId($request->id);
            $permit = $this->general->find($id);
            $ptw_status = $permit->ptw_status;

            if ($request->has('approve')) {
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

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function Edit(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $general = $this->general->find($id);

            $companyDetails = $this->company->getAllCompany();

            $locationDetails = $this->location->getAllLocation();
            $specificLocation = $this->specificlocation->where('location_id', $general->location)->where('status', 1)->get();
            $designationDetails = $this->designation->get();
            $contractorCompanyDetails = $this->contractorCompany->get();


            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
            $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
            $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
            $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
            $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
                'file_type' => 1
            );

            $hazardfile =  $this->ptwfile->getWhere($whereArray);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
                'file_type' => 2
            );

            $supportCertificateFile =  $this->ptwfile->getWhere($whereArray);

            $likelihood = $this->likelihood->orderBy('id', 'DESC')->get();
            $severity = $this->severity->orderBy('id', 'DESC')->get();
            $riskmatrix = $this->riskmatrix->get()->keyBy('rating')->toArray();

            $hazardCategoryDetails = $this->hazardcategory->get();
            $generalhazardDetails = $this->hazard->getgeneral($id);

            $workTypeDetails = $this->Work_type->getAllWorktypeData();

            $data = array(
                'companyDetails' => $companyDetails,
                'hazardDetails' => $hazardDetails,
                'supportCertificate' => $supportCertificate,
                'protectiveEquipment' => $protectiveEquipment,
                'protectiveEquipmentItems' => $protectiveEquipmentItems,
                'sitePreparationDetails' => $sitePreparationDetails,
                'locationDetails' => $locationDetails,
                'specificLocation' => $specificLocation,
                'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'supportCertificateFile' => $supportCertificateFile,
                'hazardfile' => $hazardfile,
                'general' => $general,
                'likelihoodDetails' => $likelihood,
                'severityDetails' => $severity,
                'riskmatrixDetails' => $riskmatrix,
                'hazardCategoryDetails' => $hazardCategoryDetails,
                'generalhazardDetails' => $generalhazardDetails,
                'workTypeDetails' => $workTypeDetails,
            );



            return view('ptw.general.edit', $data);
        } catch (Exception $error) {
            report($error->getMessage());
        }
    }

    public function Update(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $rules = [
                'company' => 'required',
                'location' => 'required',
                'workdescription' => 'required',
            ];
            $messages = [
                'company.required' => 'Please enter Location ID',
                'location.required' => 'Please enter Location Name',
                'workdescription.required' => 'Please enter General PTW Name',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {

                $fromgeneral = $this->general->find($id);

                $this->general->updates($id);

                $generalptw = $this->general->find($id);

                $this->ptwfile->generalUpdate($generalptw);


                $permit =  $this->general->find($id);

                $notificationSatus = "";

                switch ($permit->ptw_status) {

                    case PERMIT_STATUS_AO_PENDING:

                        $notifywhere = array(
                            'id' => $permit->area_owner,
                        );

                        $userids = User::where($notifywhere)->pluck('id')->toArray();
                        $users = User::where($notifywhere)->get();

                        $mailsubject = "[PTW Notification - " . PTWID($id) . " ] " . 'Requesting for PTW Approval';
                        $message = 'PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                        $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/aoapprove');
                        $notificationSatus = 1;
                        break;

                    case PERMIT_STATUS_GHSE_PENDING:

                        $user_role = ROLE_GHSE_APPROVER;
                        $notifywhere = array(
                            'company' => $permit->area_of_work,
                        );

                        $userids = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->pluck('id')->toArray();
                        $users = User::where($notifywhere)->whereRaw('FIND_IN_SET(' . $user_role . ', role)')->get();

                        $mailsubject = "[PTW Notification - " . PTWID($id) . " ] " . 'Requesting for PTW Approval';
                        $message = 'PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                        $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/ghseapprove');
                        $notificationSatus = 1;
                        break;
                    case PERMIT_STATUS_SA_PENDING:

                        $notifywhere = array(
                            'id' => $permit->supervising_authority,
                        );

                        $userids = User::where($notifywhere)->pluck('id')->toArray();
                        $users = User::where($notifywhere)->get();

                        $mailsubject = "[PTW Notification - " . PTWID($id) . " ] " . 'Requesting for PTW Approval';
                        $message = 'PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                        $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/saapprove');
                        $notificationSatus = 1;
                        break;
                }

                if ($generalptw->is_draft == 1) {

                    $this->hazard->updates($generalptw);

                    $subPermit = '';
                    $subpermitDetails = $generalptw->sub_work_permit;
                    if ($subpermitDetails != null && $subpermitDetails != '') {
                        $subpermitArray =  $this->ptwsubpermit->store($generalptw->id, string_to_array($subpermitDetails));
                        $subPermit = $subpermitArray->sub_permit_id;
                    }
                    if ($subpermitDetails == null || $subpermitDetails == '') {

                        $notifywhere = array(
                            'id' => $permit->area_owner,
                        );

                        $userids = User::where($notifywhere)->pluck('id')->toArray();
                        $users = User::where($notifywhere)->get();

                        $mailsubject = "[PTW Notification - " . PTWID($id) . " ] " . 'Requesting for PTW Approval';
                        $message = 'PTW - ' . $permit->ptw_id . ' Submiting for Approval';
                        $web_link = admin_url('ptw/general/view/' . encryptId($permit->id) . '/aoapprove');
                        $notificationSatus = 1;
                    }

                    $this->general->changeDraftStatus($id);
                }

                if ($notificationSatus != '') {

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
                }

                $generalptw = $this->general->find($id);


                $insert_array = array(
                    'permit_type' => PTW_PERMIT_GENERAL,
                    'ptw_id' => $id,
                    'sub_permit_id' => $id,
                    'from_status' => $fromgeneral->ptw_status,
                    'to_status' => $generalptw->ptw_status,
                    'is_reject' => 0,
                    'remarks' => $request->applicant_remarks,
                    'approved_by' => Auth::id(),
                );
                $this->permitstatuslog->create($insert_array);



                Session::flash('success', 'General PTW Updated successfully!');
            } catch (Exception $ex) {

                dd($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
            }

            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            dd($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function StatusChange(Request $request)
    {

        try {
            $id = decryptId($request->id);

            $this->general->statuschange($id);

            return response()->json(['status' => 'success', 'msg' => 'PTW status changed'], 200);
        } catch (Exception $ex) {

            return response()->json(['status' => 'error', 'msg' => 'Please try after some time'], 406);
        }
    }

    public function Delete(Request $request)
    {
        try {
            $id = decryptId($request->id);
            if (CheckUserRole(ROLE_HSEUSER) || CheckUserRole(ROLE_SUPERADMIN)) {
                $this->general->deleterecord($id);

                return response()->json([
                    'status' => 'success',
                    'msg' => 'General PTW deleted successfully!'
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'msg' => 'You don’t have access to delete the General PTW!'
            ], 406);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Please try again after some time.'
            ], 500);
        }
    }


    public function ExportExcel(Request $request)
    {

        try {

            $allData = $this->general->exportdata();

            $header = [
                'No.',
                'PTW ID',
                'Location Name',
                'Specific Location',
                'Status',
                'Sub Work Permit',
                'Applied By',
                'Cretaed At',
            ];

            $i = 1;
            foreach ($allData as $data) {


                $export = [];
                $export['No.'] =  $i;
                $export['PTW ID'] =  $data->ptw_id;
                $export['Location Name'] =  $data->location_name;
                $export['Specific Location'] =  $data->specific_loc_name;
                $export['Status'] =  permitStatusName($data->ptw_status);
                $export['Sub Work Permit'] =   $data->sub_work_permit != ''  ? subpermitname($data->sub_work_permit) : "";
                $export['Applied By'] =  $data->name;
                $export['Cretaed At'] =   Displaydateformat($data->created_at);
                $exportData[] = $export;
                $i++;
            }

            $writer = SimpleExcelWriter::streamDownload('General PTW Details.xlsx')
                ->addHeader($header)
                ->addRows(
                    $exportData
                );
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportPdf(Request $request)
    {

        try {

            $allData = $this->general->exportdata();

            $header = [
                'No.',
                'PTW ID',
                'Location Name',
                'Specific Location',
                'Status',
                'Sub Work Permit',
                'Applied By',
                'Cretaed At',
            ];

            $data = array(
                'header' => $header,
                'content' => $allData,
                'pagetitle' => "General PTW Details",
            );

            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('ptw.general.pdf', $data);
            $html = $view->render();


            $mpdf->WriteHTML($html);

            $filename = "General PTW Details.pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {

            report($ex);
        }
    }

    public function ExportViewPdf(Request $request)
    {

        try {


            $id = decryptId($request->id);

            $whereArray = array(
                'id' => $id
            );

            $subpermitid = '';

            switch ($request->pdftype) {

                case "general":

                    $subpermitpagename = '';
                    break;
                case "gastest":
                    $subpermit = $this->gas->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.gastestcertificate';
                    break;
                case "isolation":
                    $subpermit =  $this->isolation->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.isolationcertificate';
                    break;
                case "surfacepenetration":
                    $subpermit = $this->surface->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.surfacepenetrationcertificate';
                    break;
                case "hotwork":
                    $subpermit = $this->hotwork->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.hotworkcertificate';
                    break;
                case "worktraffic":
                    $subpermit = $this->traffic->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.trafficmanagementcertificate';
                    break;
                case "lifting":
                    $subpermit = $this->lifting->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.liftingplancertificate';
                    break;
                case "diving":
                    $subpermit = $this->diving->selectOneWhere($whereArray);
                    $id = $subpermit->ptw_id;
                    $subpermitid = $subpermit->sub_permit_id;
                    $subpermitpagename = 'ptw.pdf.divingcertificate';
                    break;
            }

            $general = $this->general->find($id);
            $generalpermitStatusLog = $this->permitstatuslog->getDetails(PTW_PERMIT_GENERAL, $id, $id);

            $isContractor = 0;
            $contractorCompanyName = '';
            $createduser = $general->created_by;
            $userdetails = User::find($createduser);

            if ($userdetails->user_type) {

                $isContractor = 1;
                $contractor = $this->contractor->where('login_id', $userdetails->id)->first();
                $contractorcompanyid = $contractor?->cont_company_id;
                $contractorCompany = $this->contractorCompany->find($contractorcompanyid);
                $contractorCompanyName = $contractorCompany?->con_comp_name;
            }

            if ($contractorCompanyName == '' || $contractorCompanyName == null) {
                $isContractor = 0;
            }

            $companyDetails = $this->company->get();

            $locationDetails = $this->location->get();
            $designationDetails = $this->designation->get();
            $contractorCompanyDetails = $this->contractorCompany->get();


            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);
            $supportCertificate = $this->category->getWhere(PTW_CAT_GENERAL_SUPPORT_DOCUMENT);
            $protectiveEquipment = $this->category->getWhere(PTW_CAT_GENERAL_EQUIPEMNT);
            $protectiveEquipmentItems = $this->item->CategoryItem(PTW_CAT_GENERAL_EQUIPEMNT);
            $sitePreparationDetails = $this->category->getWhere(PTW_CAT_GENERAL_SITE_PREPARATION);

            $whereArray = array(
                'ptw_id' => $id,
                'ptw_module' => 0,
            );

            $supportCertificateFile =  $this->ptwfile->getWhere($whereArray);


            /**
             * Gas Test
             */

            $whereArray = array(
                'ptw_id' => $id
            );


            $gas = $this->gas->selectOneWhere($whereArray);
            $gaspermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_GAS, $id, $gas?->id);

            /**
             * Isolation
             */
            $isolation = $this->isolation->selectOneWhere($whereArray);
            $ppelist = $this->category->getWhere(PTW_CAT_ISOLATION_PPE);
            $isolationpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_ISOLATION, $id, $isolation?->id);

            /**
             * Surface
             */

            $surface = $this->surface->selectOneWhere($whereArray);
            $surfaceppe = $this->category->getWhere(PTW_CAT_SURFACE_PPE);
            $equipments = $this->category->getWhere(PTW_CAT_SURFACE_EQUIPMENT);
            $aditionalrequierments = $this->category->getWhere(PTW_CAT_SURFACE_ADDITIONAL_REQUIREMENTS);
            $surfacepermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_SURFACE, $id, $surface?->id);

            /**
             * Hotwork
             */
            $hotwork = $this->hotwork->selectOneWhere($whereArray);
            $hotworkoperation = $this->category->getWhere(PTW_CAT_HOTWORK_WORK_OPERATION);
            $precautions = $this->category->getWhere(PTW_CAT_HOTWORK_PRECAUTIONS);
            $hotworkpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_HOTWORK, $id, $hotwork?->id);

            /**
             * Work Traffic
             */
            $traffic = $this->traffic->selectOneWhere($whereArray);
            $wtmlight = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_LIGHT);
            $wtmotherdetails = $this->category->getWhere(PTW_CAT_TRAFFIC_DETAILS_OTHERS);

            $whereArrayfile = array(
                'ptw_id' => $traffic?->ptw_id,
                'ptw_module' => 5,
                'reference_id' => $traffic?->id,
            );

            $trafficplandocument =  $this->ptwfile->getWhere($whereArrayfile);
            $trafficpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_WORKTRAFFIC, $id, $traffic?->id);

            /**
             * Lifting
             */
            $lifting = $this->lifting->selectOneWhere($whereArray);
            $liftingequipment = $this->category->getWhere(PTW_CAT_LIFTING_EQUIPMENT);
            $riggingdetails = $this->category->getWhere(PTW_CAT_LIFTING_RIGGING);
            $liftingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_LIFTING, $id, $lifting?->id);

            $whereArrayfile = array(
                'ptw_id' => $lifting?->ptw_id,
                'ptw_module' => 6,
                'reference_id' => $lifting?->id,
            );

            $liftingdocument =  $this->ptwfile->getWhererby($whereArrayfile);

            /**
             * Diving
             */
            $diving = $this->diving->selectOneWhere($whereArray);
            $equipmentgear = $this->category->getWhere(PTW_CAT_DIVING_EQUIPMENT);
            $divingsitepreparation = $this->category->getWhere(PTW_CAT_DIVING_SITE_PREPARATION);
            $divingpermitStatusLog = $this->permitstatuslog->getDetails(PTW_SUB_PERMIT_DIVING, $id, $diving?->id);

            $subpermitDetails =  $this->ptwsubpermit->getPermit($id);

            if ($request->has('approvetype')) {
                $approvetype = $request->approvetype;
            } else {
                $approvetype = "";
            }

            $likelihood = $this->likelihood->orderBy('id', 'DESC')->get();
            $severity = $this->severity->orderBy('id', 'DESC')->get();
            $riskmatrix = $this->riskmatrix->get()->keyBy('rating')->toArray();

            $generalhazardDetails = $this->hazard->getgeneral($id);


            $data = array(
                'companyDetails' => $companyDetails,
                'hazardDetails' => $hazardDetails,
                'supportCertificate' => $supportCertificate,
                'protectiveEquipment' => $protectiveEquipment,
                'protectiveEquipmentItems' => $protectiveEquipmentItems,
                'sitePreparationDetails' => $sitePreparationDetails,
                'locationDetails' => $locationDetails,
                'designationDetails' => $designationDetails,
                'contractorCompanyDetails' => $contractorCompanyDetails,
                'supportCertificateFile' => $supportCertificateFile,
                'general' => $general,
                'generalpermitStatusLog' => $generalpermitStatusLog,

                'pagetitle' => $general->ptw_id,

                'subpermitDetails' => $subpermitDetails,


                'gas' => $gas,
                'gaspermitStatusLog' => $gaspermitStatusLog,


                'isolation' => $isolation,
                'ppelist' => $ppelist,
                'isolationpermitStatusLog' => $isolationpermitStatusLog,

                'surface' => $surface,
                'surfaceppe' => $surfaceppe,
                'equipments' => $equipments,
                'aditionalrequierments' => $aditionalrequierments,
                'surfacepermitStatusLog' => $surfacepermitStatusLog,

                'hotwork' => $hotwork,
                'hotworkoperation' => $hotworkoperation,
                'precautionslist' => $precautions,
                'hotworkpermitStatusLog' => $hotworkpermitStatusLog,

                'traffic' => $traffic,
                'wtmlight' => $wtmlight,
                'wtmotherdetails' => $wtmotherdetails,
                'trafficplandocument' => $trafficplandocument,
                'trafficpermitStatusLog' => $trafficpermitStatusLog,

                'lifting' => $lifting,
                'liftingequipment' => $liftingequipment,
                'riggingdetails' => $riggingdetails,
                'liftingpermitStatusLog' => $liftingpermitStatusLog,
                'liftingdocument' => $liftingdocument,

                'diving' => $diving,
                'equipmentgear' => $equipmentgear,
                'divingsitepreparation' => $divingsitepreparation,
                'divingpermitStatusLog' => $divingpermitStatusLog,

                'approvetype' => $approvetype,

                'likelihoodDetails' => $likelihood,
                'severityDetails' => $severity,
                'riskmatrixDetails' => $riskmatrix,
                'generalhazardDetails' => $generalhazardDetails,
                'subpermitpagename' => $subpermitpagename,
                'subpermitid' => $subpermitid,

                'isContractor' => $isContractor,
                'contractorCompanyName' => $contractorCompanyName,
            );


            $property = [
                'tempDir' => 'public/pdf/temp/',
                'mode' => 'c',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'use_k' => true,

            ];

            $mpdf = new \Mpdf\Mpdf($property);
            $mpdf->setAutoTopMargin = 'stretch';

            $view = view('ptw.general.pdf.general', $data);
            $html = $view->render();

            $mpdf->WriteHTML($html);

            $filename = $general->ptw_id . ".pdf";
            $mpdf->Output($filename, 'D');
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function Getsubcategory(Request $request)
    {

        $categoryId = decryptId($request->categoryId);

        $subpermitId = '';
        $subcategoryDetails = $this->hazardsubcategory->ajaxList($categoryId, $subpermitId);

        return $subcategoryDetails;
    }

    public function holdSubmit(Request $request)
    {
        try {
            $id = decryptId($request->ptw_id);

            $hold = $this->general->holdPtw($id);
            Session::flash('success', 'PTW Holded !');
            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function unholdSubmit(Request $request)
    {
        try {
            $id = decryptId($request->ptw_id);

            $unhold = $this->general->unHoldPtw($id);
            Session::flash('success', 'PTW UnHolded !');
            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function addPTW(Request $request)
    {
        try {
            $id = decryptId($request->id);

            $general = $this->general->find($id);
            $hazardDetails = $this->category->getWhere(PTW_CAT_GENERAL_HAZARD);

            $data = array(
                'hazardDetails' => $hazardDetails,
                'general' => $general,
            );
            return view('ptw.general.add_ptw', $data);
        } catch (Exception $ex) {
            report($ex);
        }
    }

    public function addPTWSubmit(Request $request)
    {
        try {
            $id = decryptId($request->id);
            $addPTW = $this->general->addPtw($id);
            $generalptw = $this->general->find($id);

            $subPermit = '';
            $subpermitDetails =  array_to_string(subpermitId(arrayDecrypt($request->hazard)));

            if ($subpermitDetails != null && $subpermitDetails != '') {
                $subpermitArray =  $this->ptwsubpermit->store($generalptw->id, string_to_array($subpermitDetails));
                $subPermit = $subpermitArray->sub_permit_id;
            }
            Session::flash('success', 'SubPermit Added !');
            return redirect(admin_url('ptw/general/list'));
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function AOReassignSubmit(Request $request)
    {

        try {

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
                return redirect()->back()->withErrors($validator)->withInput();
            }

            try {
                $id = decryptId($request->id);
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

                Session::flash('success', 'Area Owner Re-assigned !');
                return redirect(admin_url('ptw/general/list'));
            } catch (Exception $ex) {
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect(admin_url('ptw/general/list'));
            }
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }

    public function SAReassignSubmit(Request $request)
    {
        try {

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
                return redirect()->back()->withErrors($validator)->withInput();
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
                Session::flash('success', 'Supervising Authority Re-assigned !');
                return redirect(admin_url('ptw/general/list'));
            } catch (Exception $ex) {
                report($ex);
                Session::flash('error', 'Something went wrong, Please try after sometimes!');
                return redirect(admin_url('ptw/general/list'));
            }
        } catch (Exception $ex) {
            report($ex);
            Session::flash('error', 'Something went wrong, Please try after sometimes!');
            return redirect(admin_url('ptw/general/list'));
        }
    }
}
