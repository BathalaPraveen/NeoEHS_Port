<?php

namespace App\Models\PTW;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use DB;
use App\Scopes\TrashScope;

class General extends Model
{
    use  HasFactory;


    protected $table = 'ptw_general';
    protected $primaryKey = 'id';

    protected $fillable = [
        'area_of_work',
        'ptw_id',
        'location',
        'specific_location',
        'other_location',
        'ptw_status',
        'sub_work_permit',
        'sub_work_permit_complete',
        'sub_work_permit_status',
        'area_of_work',
        'work_description',
        'job_hazard_analysis',
        'contact_number',
        'date_of_commencement',
        'date_of_completion',
        'onemonthpermit',
        'date_of_application',
        'hazard',
        'supporting_documents',
        'equipment_details',
        'site_preparation',
        'apllication_ack',
        'application_remarks',

        'work_type',
        'area_owner',
        'supervising_authority',
        'ptw_status_old',
        'hold_by',
        'hold_at',
        'hold_remarks',
        'unhold_by',
        'unhold_at',
        'unhold_remarks',
        'is_draft',

        'created_by',
        'updated_by',
        'status',
        'trash',
        'created_at',
        'updated_at'

    ];

    protected $attributes = [
        'status' => 1,
        'trash' => 'NO',
    ];

    public function list()
    {
        $request = request();
        $search = '';

        $query = $this->select('ptw_general.*', 'master_location.location_name', 'master_location_specific.specific_loc_name', 'users.name');
        $query = $query->leftJoin('master_location', 'ptw_general.location', '=', 'master_location.id');
        $query = $query->leftJoin('master_location_specific', 'ptw_general.specific_location', '=', 'master_location_specific.id');
        $query = $query->leftJoin('users', 'ptw_general.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_general.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_general.location', $location);
        }

        if ($request->has('subpermit') && $request->subpermit != '') {
            $subpermit = decryptId($request->subpermit);

            $query->whereRaw('FIND_IN_SET(?, ptw_general.sub_work_permit)', [$subpermit]);
        }

        if ($request->search['value'] != null || $request->search['value'] != '') {
            $search = $request->search['value'];

            $query->where(function ($query) use ($search) {
                $query->orWhere('ptw_id', 'LIKE', '%' . $search . '%');
            });
        }

        if (!in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_ADMIN, getUserRoleId(Auth::id())) && !in_array(ROLE_HSEUSER, getUserRoleId(Auth::id()))) {

            if (
                in_array(ROLE_CONTRACTORUSER, getUserRoleId(Auth::id())) ||
                in_array(ROLE_CONTRACTORADMIN, getUserRoleId(Auth::id())) ||
                in_array(ROLE_PTW_CREATOR, getUserRoleId(Auth::id())) ||
                in_array(ROLE_NORMAL_USER, getUserRoleId(Auth::id()))
            ) {
                $query = $query->where('ptw_general.created_by', Auth::id());
            } else {
                // $companyId = Auth::user()->company;
                // $query = $query->where('area_of_work', $companyId);
            }
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

        if ($request->has('hazard')) {
            $hazardData = json_encode(
                array(
                    'hazard' => arrayDecrypt($request->hazard),
                )
            );
        } else {
            $hazardData = json_encode(
                array(
                    'hazard' => [],
                )
            );
        }


        if ($request->hazard != null && $request->hazard != '') {

            $subworkpermit = array_to_string(subpermitId(arrayDecrypt($request->hazard)));
            $subworkpermitstatus = 1;
            $ptw_status = PERMIT_STATUS_SP_PENDING;
        } else {
            $subworkpermit = null;
            $subworkpermitstatus = 0;
            $ptw_status = PERMIT_STATUS_AO_PENDING;
        }

        $draft = 0;
        if ($request->has('draft')) {
            $ptw_status = PERMIT_STATUS_DRAFT;
            $draft = 1;
        }

        if ($request->supportcertificate != null) {
            $supprotcertificate = arrayDecrypt($request->supportcertificate);
        } else {
            $supprotcertificate = '';
        }
        $supportCertificateData = json_encode(
            array(
                'supportcertificate' => $supprotcertificate
            )
        );

        if ($request->equipments == null || $request->equipments == '') {
            $equipmentsArray = [];
        } else {
            $equipmentsArray = arrayDecrypt($request->equipments);
        }

        $equipmentsData = json_encode(
            array(
                'equipments' => $equipmentsArray,
                'equipments_others_text' => $request->equipments_others_text,
            )
        );

        if ($request->sitepreparation == null || $request->sitepreparation == '') {
            $sitepreparationArray = [];
        } else {
            $sitepreparationArray = arrayDecrypt($request->sitepreparation);
        }


        $sitepreparationData = json_encode(
            array(
                'sitepreparation' =>  $sitepreparationArray,
                'sitepreparation_others_text' => $request->sitepreparation_others_text,
            )
        );


        $insert_array = array(
            'ptw_status' => $ptw_status,
            'area_of_work' => decryptId($request->company),
            'location' => decryptId($request->location),
            'specific_location' => decryptId($request->specific_location),
            'other_location' => $request->locationothers,
            'contact_number' => $request->contactnumber,
            'sub_work_permit' =>  $subworkpermit,
            'sub_work_permit_complete' => null,
            'sub_work_permit_status' => $subworkpermitstatus,
            'work_description' => $request->workdescription,
            'job_hazard_analysis' => $request->jobhazardanalysis,
            'date_of_commencement' => DBdateformat($request->dateofcommencement),
            'date_of_completion' => DBdateformat($request->dateofcompletion),
            'onemonthpermit' => $request->onemonthvalidity,
            'date_of_application' => DBdateformat($request->dateofapplication),
            'hazard' => $hazardData,
            'supporting_documents' => $supportCertificateData,
            'equipment_details' => $equipmentsData,
            'site_preparation' => $sitepreparationData,
            'apllication_ack' => 1,
            'application_remarks' => $request->applicant_remarks,
            'work_type' => decryptId($request->work_type),
            'area_owner' => decryptId($request->area_owner),
            'supervising_authority' => decryptId($request->supervising_authority),
            'is_draft' => $draft,
            'created_by' => Auth::id()
        );
        return $this->create($insert_array);
    }

    public function updates($id)
    {

        $general = $this->select('*')->where('id', $id)->first();

        $request = request();

        $hazardData = json_encode(
            array(
                'hazard' => [],
            )
        );

        $subworkpermit = null;
        $subworkpermitstatus = 0;



        if ($request->supportcertificate != null) {
            $supprotcertificate = arrayDecrypt($request->supportcertificate);
        } else {
            $supprotcertificate = '';
        }
        $supportCertificateData = json_encode(
            array(
                'supportcertificate' => $supprotcertificate
            )
        );

        
        $equipmentsData = json_encode(
            array(
                'equipments' => arrayDecrypt($request->equipments),
                'equipments_others_text' => $request->equipments_others_text,
            )
        );

        $sitepreparationData = json_encode(
            array(
                'sitepreparation' => arrayDecrypt($request->sitepreparation),
                'sitepreparation_others_text' => $request->sitepreparation_others_text,
            )
        );


        if ($general->is_draft == 1) {

            // Decode existing hazard data
            $existingHazard = [];
            if (!empty($general->hazard)) {
                $existingDecoded = json_decode($general->hazard, true);
                $existingHazard = $existingDecoded['hazard'] ?? [];
            }

            // Decrypt new hazard input
            $newHazard = [];
            if ($request->has('hazard')) {
                $newHazard = arrayDecrypt($request->hazard);
            }

            $mergedHazard = array_unique(array_merge($existingHazard, $newHazard));

            $hazardData = json_encode(['hazard' => $mergedHazard]);

            if (!empty($mergedHazard) || !empty($newHazard)) {
                $subworkpermit_old = string_to_array($general->sub_work_permit);
                $subworkpermit_new = subpermitId($mergedHazard);

                $subworkpermit = array_unique(
                    array_filter(
                        array_merge($subworkpermit_old, $subworkpermit_new)
                    )
                );

                $subworkpermit = array_to_string($subworkpermit);
                $subworkpermitstatus = 1;
                $ptw_status = PERMIT_STATUS_SP_PENDING;
            } else {
                $ptw_status = PERMIT_STATUS_AO_PENDING;
                $subworkpermit = null;
                $subworkpermitstatus = 0;
            }
        } else {
            $ptw_status = $general->ptw_status - 1;
        }


        $update_array = array(
            'ptw_status' =>  $ptw_status,
            'area_of_work' => decryptId($request->company),
            'location' => decryptId($request->location),
            'specific_location' => decryptId($request->specific_location),
            'other_location' => $request->locationothers,
            'contact_number' => $request->contactnumber,
            'sub_work_permit' =>  $subworkpermit,
            'sub_work_permit_complete' => null,
            'sub_work_permit_status' => $subworkpermitstatus,
            'work_description' => $request->workdescription,
            'job_hazard_analysis' => $request->jobhazardanalysis,
            'date_of_commencement' => DBdateformat($request->dateofcommencement),
            'date_of_completion' => DBdateformat($request->dateofcompletion),
            'onemonthpermit' => $request->onemonthvalidity,
            'date_of_application' => DBdateformat($request->dateofapplication),
            'hazard' => $hazardData,
            'supporting_documents' => $supportCertificateData,
            'equipment_details' => $equipmentsData,
            'site_preparation' => $sitepreparationData,
            'apllication_ack' => 1,
            'application_remarks' => $request->applicant_remarks,
            'work_type' => decryptId($request->work_type),
            'area_owner' => decryptId($request->area_owner),
            'supervising_authority' => decryptId($request->supervising_authority),
            'updated_by' => Auth::id()
        );


        return $this->where('id', $id)->update($update_array);
    }

    public function statuschange($id, $status)
    {

        $update_data = array(
            'ptw_status' => $status,
        );

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

        $query = $this->select('ptw_general.*', 'master_location.location_name', 'master_location_specific.specific_loc_name', 'users.name');
        $query = $query->leftJoin('master_location', 'ptw_general.location', '=', 'master_location.id');
        $query = $query->leftJoin('master_location_specific', 'ptw_general.specific_location', '=', 'master_location_specific.id');
        $query = $query->leftJoin('users', 'ptw_general.created_by', '=', 'users.id');

        if ($request->has('status') && $request->status != '') {
            $status = decryptId($request->status);
            $query->Where('ptw_general.ptw_status', $status);
        }

        if ($request->has('location') && $request->location != '') {
            $location = decryptId($request->location);
            $query->Where('ptw_general.location', $location);
        }

        if ($request->has('subpermit') && $request->subpermit != '') {
            $subpermit = decryptId($request->subpermit);

            $query->whereRaw('FIND_IN_SET(?, ptw_general.sub_work_permit)', [$subpermit]);
        }

        if ($request->search != null || $request->search != '') {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->orWhere('ptw_id', 'LIKE', '%' . $search . '%');
            });
        }

        $query = $query->orderBy('created_at', 'Desc');
        return  $query->get();
    }

    public function selectOne($id)
    {

        $data = $this->select('*')
            ->where('id', $id)
            ->first();

        return $data;
    }

    public function selectOneWhere($where)
    {

        $data = $this->select('*')
            ->where($where)
            ->first();

        return $data;
    }

    public function chartData()
    {
        $query = $this->select(
            'master_location.location_name',
            'ptw_permit_status.status_name',
            'ptw_permit_status.id as status_id',
            DB::raw('count(*) as count')
        );
        $query = $query->leftJoin('master_location', 'ptw_general.location', '=', 'master_location.id');
        $query = $query->leftJoin('ptw_permit_status', 'ptw_general.ptw_status', '=', 'ptw_permit_status.id');
        $query = $query->groupBy('ptw_general.location', 'ptw_general.ptw_status');

        return  $query->get();
    }

    public function holdPtw($id)
    {
        $request = request();

        $general = $this->select('ptw_status')->where('id', $id)->first();

        $update_data = array(
            'ptw_status_old' => $general->ptw_status,
            'hold_by' => Auth::id(),
            'hold_at' => todayDbdate(),
            'hold_remarks' => $request->hold_remarks,
            'ptw_status' => PERMIT_STATUS_PTW_HOLD,
        );

        return $this->where('id', $id)->update($update_data);
    }

    public function unHoldPtw($id)
    {
        $request = request();

        $general = $this->where('id', $id)->first();

        $update_data = array(
            'unhold_by' => Auth::id(),
            'unhold_at' => todayDbdate(),
            'unhold_remarks' => $request->unhold_remarks,
            'ptw_status' => $general->ptw_status_old,
        );

        return $this->where('id', $id)->update($update_data);
    }

    public function addPtw($id)
    {
        $request = request();
        $general = $this->where('id', $id)->first();

        $request = request();

        // Decode existing hazard data
        $existingHazard = [];
        if (!empty($general->hazard)) {
            $existingDecoded = json_decode($general->hazard, true);
            $existingHazard = $existingDecoded['hazard'] ?? [];
        }

        // Decrypt new hazard input
        $newHazard = [];
        if ($request->has('hazard')) {
            $newHazard = arrayDecrypt($request->hazard);
        }

        $mergedHazard = array_unique(array_merge($existingHazard, $newHazard));

        $hazardData = json_encode(['hazard' => $mergedHazard]);

        if (!empty($mergedHazard) && !empty($newHazard)) {
            $subworkpermit_old = string_to_array($general->sub_work_permit);
            $subworkpermit_new = subpermitId($mergedHazard);

            $subworkpermit = array_unique(
                array_filter(
                    array_merge($subworkpermit_old, $subworkpermit_new)
                )
            );

            $subworkpermit = array_to_string($subworkpermit);
            $subworkpermitstatus = 1;
            $ptw_status = PERMIT_STATUS_ADDITIONAL_SP_PENDING;
        } else {
            $ptw_status = $general->ptw_status;
            $subworkpermit = $general->sub_work_permit;
            $subworkpermitstatus = $general->sub_work_permit_status;
        }

        $update_data = array(
            'ptw_status' => $ptw_status,
            'hazard' => $hazardData,
            'sub_work_permit' =>  $subworkpermit,
            'sub_work_permit_status' => $subworkpermitstatus,
            'updated_by' => Auth::id()

        );

        return $this->where('id', $id)->update($update_data);
    }

    public function reassign($id, $type)
    {
        $request = request();

        switch ($type) {

            case PTW_AO_REASSIGN:
                $insert_array = array(
                    'area_owner' => decryptId($request->reassigned_area_owner)
                );
                break;
            case PTW_SA_REASSIGN:
                $insert_array = array(
                    'supervising_authority' => decryptId($request->reassigned_supervising_authority)
                );
                break;
        }

        return $this->where('id', $id)->update($insert_array);
    }


    public function changeDraftStatus($id)
    {

        $update_data = array(
            'is_draft' => 0,
        );

        return $this->where('id', $id)->update($update_data);
    }

    protected static function booted()
    {
        static::addGlobalScope(new TrashScope('ptw_general'));

        static::created(function ($model) {

            $uniqueId = 'PTW-GEN-' . str_pad($model->id, 5, '0', STR_PAD_LEFT);
            $model->update(['ptw_id' => $uniqueId]);
        });

        static::retrieved(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                $model->$key = $value ?? ''; // Replace null with an empty string
            }
        });
    }
}
