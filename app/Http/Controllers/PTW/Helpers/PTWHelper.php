<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;


use App\Models\PTW\PTWCategory;
use App\Models\PTW\SubpermitStatus;
use App\Models\PTW\PermitStatus;
use App\Models\PTW\PTWSubPermit;
use App\Models\PTW\PTWSubWorkPermit;

use App\Models\PTW\General;
use App\Models\PTW\Gas;
use App\Models\PTW\Isolation;
use App\Models\PTW\Surface;
use App\Models\PTW\Hotwork;
use App\Models\PTW\Traffic;
use App\Models\PTW\Lifting;
use App\Models\PTW\Diving;

use App\Mail\PTW\GeneralPTWEmail;
use App\Models\Master\Employee;
use Illuminate\Support\Facades\Mail;



if (!function_exists('getPtwId')) {

    function getPtwId($id, $type)
    {

        $whereArray = array(
            'ptw_id' => $id
        );

        switch ($type) {


            case "gastest":
                $subpermit = Gas::selectOneWhere($whereArray);

                break;
            case "isolation":
                $subpermit = Isolation::selectOneWhere($whereArray);

                break;
            case "surfacepenetration":
                $subpermit = Surface::selectOneWhere($whereArray);

                break;
            case "hotwork":
                $subpermit = Hotwork::selectOneWhere($whereArray);

                break;
            case "worktraffic":
                $subpermit = Traffic::selectOneWhere($whereArray);

                break;
            case "lifting":
                $subpermit = Lifting::selectOneWhere($whereArray);

                break;
            case "diving":
                $subpermit = Diving::selectOneWhere($whereArray);

                break;
        }

        $ptwid = $subpermit;

        return $ids;
    }
}

if (!function_exists('subpermitId')) {

    function subpermitId($id = [])
    {
        $ptwsub =  PTWCategory::whereIn('id', $id)->get();
        $ids = [];
        foreach ($ptwsub as $sub) {

            $ids[] = json_decode($sub->other_params)?->permit;
        }

        return $ids;
    }
}

if (!function_exists('nextSubPermit')) {

    function nextSubPermit($subPermit, $ptwId)
    {

        $redirectLink = 'ptw/general/list/';

        if ($subPermit  != '') {

            switch ($subPermit) {

                case PTW_SUB_PERMIT_GAS:
                    $redirectLink = 'ptw/gastest/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_ISOLATION:
                    $redirectLink = 'ptw/isolation/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_SURFACE:
                    $redirectLink = 'ptw/surfacepenetration/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_HOTWORK:
                    $redirectLink = 'ptw/hotwork/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_WORKTRAFFIC:
                    $redirectLink = 'ptw/worktraffic/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_LIFTING:
                    $redirectLink = 'ptw/lifting/add/' . encryptId($ptwId);
                    break;
                case PTW_SUB_PERMIT_DIVING:
                    $redirectLink = 'ptw/diving/add/' . encryptId($ptwId);
                    break;
            }
        }

        return $redirectLink;
    }
}

if (!function_exists('subpermitStatus')) {

    function subpermitStatus($status)
    {
        $statusDetails = SubpermitStatus::find($status);

        $returnText =  '<span class="' . $statusDetails->bg_color . '">' . $statusDetails->status_name  . '</span>';


        return $returnText;
    }
}

if (!function_exists('permitStatus')) {

    function permitStatus($status)
    {
        $statusDetails = PermitStatus::find($status);

        return  '<span class="' . $statusDetails->bg_color . '">' . $statusDetails->report_status_name  . '</span>';
    }
}

if (!function_exists('subpermitStatusText')) {

    function subpermitStatusText($status)
    {
        $statusDetails = SubpermitStatus::find($status);

        $returnText =   $statusDetails->status_name;


        return $returnText;
    }
}

if (!function_exists('subpermitapprovedstatus')) {

    function subpermitapprovedstatus($ptwId)
    {
        $overallcount = PTWSubPermit::where('ptw_id', $ptwId)->count();
        $completedcount = PTWSubPermit::where('ptw_id', $ptwId)->where('sub_permit_status', SUBPERMIT_STATUS_APPROVED)->count();

        if ($overallcount == $completedcount) {
            $status = '1';
        } else {
            $status = '0';
        }

        return $status;
    }
}

if (!function_exists('subpermitcount')) {

    function subpermitcount($ptwId)
    {

        $overallcount = PTWSubPermit::where('ptw_id', $ptwId)->count();

        return $overallcount;
    }
}




if (!function_exists('subpermitColorcode')) {

    function subpermitColorcode($status)
    {
        $statusDetails = SubpermitStatus::find($status);

        $returnText =  $statusDetails->bg_color;
        $colorcode = "cccccc";
        switch ($returnText) {
            case "badge bg-secondary":
                $colorcode = '#6c757d';
                break;
            case "badge bg-info text-dark":
                $colorcode = '#0dcaf0';
                break;
            case "badge bg-success":
                $colorcode = '#198754';
                break;
            case "badge bg-danger":
                $colorcode = '#dc3545';
                break;
            case "badge bg-warning text-dark":
                $colorcode = '#ffc107';
                break;
            case "badge bg-primary":
                $colorcode = '#0d6efd';
                break;
        }

        return $colorcode;
    }
}

if (!function_exists('permitColorcode')) {

    function permitColorcode($status)
    {
        $statusDetails = PermitStatus::find($status);

        $returnText =   $statusDetails->bg_color;

        $colorcode = "cccccc";
        switch ($returnText) {
            case "badge bg-secondary":
                $colorcode = '#6c757d';
                break;
            case "badge bg-info text-dark":
                $colorcode = '#0dcaf0';
                break;
            case "badge bg-success":
                $colorcode = '#198754';
                break;
            case "badge bg-danger":
                $colorcode = '#dc3545';
                break;
            case "badge bg-warning text-dark":
                $colorcode = '#ffc107';
                break;
            case "badge bg-primary":
                $colorcode = '#0d6efd';
                break;
        }

        return $colorcode;
    }
}

if (!function_exists('permitStatusName')) {

    function permitStatusName($status)
    {
        $statusDetails = PermitStatus::find($status);

        return   $statusDetails->report_status_name;
    }
}

if (!function_exists('permitOrgStatusName')) {

    function permitOrgStatusName($status)
    {
        $statusDetails = PermitStatus::find($status);

        return   $statusDetails->status_name;
    }
}

if (!function_exists('subpermitStatusName')) {

    function subpermitStatusName($status)
    {
        $statusDetails = SubpermitStatus::find($status);

        $returnText =   $statusDetails->status_name;

        return $returnText;
    }
}

if (!function_exists('permitStatusText')) {

    function permitStatusText($status)
    {
        $statusDetails = PermitStatus::find($status);

        return  strtoupper($statusDetails->report_status_name);
    }
}

if (!function_exists('permitReportStatusText')) {

    function permitReportStatusText($status)
    {
        $statusDetails = PermitStatus::find($status);

        return  strtoupper($statusDetails->report_status_name);
    }
}





if (!function_exists('permitStatusUpdate')) {

    function permitStatusUpdate($ptwId)
    {

        try {
            $overallcount = PTWSubPermit::where('ptw_id', $ptwId)->count();
            $completedcount = PTWSubPermit::where('ptw_id', $ptwId)->where('sub_permit_status', SUBPERMIT_STATUS_APPROVED)->count();

            if ($overallcount == $completedcount) {

                $general_ptw = General::where('id', $ptwId)->first();

                if($general_ptw->ptw_status == PERMIT_STATUS_ADDITIONAL_SP_PENDING){
                    General::where('id', $ptwId)->update(['ptw_status' => PERMIT_STATUS_PTW_APPROVED]);
                }else{
                    General::where('id', $ptwId)->update(['ptw_status' => PERMIT_STATUS_AO_PENDING]);
                }
                
                $permit = General::find($ptwId);

                /**
                 * Send Email Notification
                 */
                $notifywhere = [
                    'company' => $permit->area_of_work,
                ];
                $location = $permit->location;
                $user_role = ROLE_AREA_OWNER;


                $userid_details = User::where($notifywhere)
                    ->whereRaw('FIND_IN_SET(?, role)', [$user_role])
                    ->pluck('id')
                    ->toArray();

                $users = User::where($notifywhere)
                    ->whereRaw('FIND_IN_SET(?, role)', [$user_role])
                    ->get();

                $userids = [];
                $users = [];
                foreach ($userid_details as $id) {
                    $employee = Employee::where('login_id', $id)
                        ->where('emp_location_id', $location)
                        ->first();

                    if ($employee) {
                        $userids[] = $employee->login_id;
                    }
                }

                foreach ($userids as $id) {
                    $user = User::where('id', $id)
                        ->first();

                    if ($user) {
                        $users[] = $user;
                    }
                }


                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptwId) . " ] " .  'Requesting for New PTW Approval';


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
                            'message' => 'New PTW - ' . $permit->ptw_id . ' Submiting for Approval',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/general/view/' . encryptId($permit->id) . '/aoapprove'),
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
                        'message' => 'New PTW - ' . $permit->ptw_id . ' Submiting for Approval',
                    ];
                    mobilePushNotification($userId, $notifydata);
                }
            }
        } catch (\Exception $ex) {
            report($ex);
        }
    }
}

if (!function_exists('subpermitname')) {

    function subpermitname($id)
    {

        $ids = string_to_array($id);

        $subpermitname = PTWSubWorkPermit::whereIn('id', $ids)->pluck('permit_name')->toArray();

        return  array_to_string($subpermitname, ", ");
    }
}

if (!function_exists('ptwGeneralChartData')) {

    function ptwGeneralChartData()
    {

        $chartData = General::select('ptw_general.ptw_status', 'ptw_permit_status.status_name', DB::raw("count(*) as count"))
            ->leftJoin('ptw_permit_status', 'ptw_permit_status.id', 'ptw_general.ptw_status')
            ->groupBy('ptw_general.ptw_status')
            ->get();

        $chartDataArray =  $chartData;

        $NotApproved = $PendingWork = $Closed = $Expired = 0;

        $pendingArray = [
            PERMIT_STATUS_SP_PENDING,
            PERMIT_STATUS_AO_PENDING,
            PERMIT_STATUS_AO_REJECTED,
            PERMIT_STATUS_GHSE_PENDING,
            PERMIT_STATUS_GHSE_REJECTED,
            PERMIT_STATUS_SA_PENDING,
            PERMIT_STATUS_SA_REJECTED,
        ];
        foreach ($chartDataArray as $data) {

            if (in_array($data->ptw_status, $pendingArray)) {

                $NotApproved  += $data->count;
            } else if ($data->ptw_status == PERMIT_STATUS_PTW_APPROVED) {
                $PendingWork  += $data->count;
            } else if ($data->ptw_status == PERMIT_STATUS_PTW_CLOSED) {
                $Closed  += $data->count;
            } else if ($data->ptw_status == PERMIT_STATUS_PTW_EXPIRED) {
                $Expired  += $data->count;
            }
        }

        return [$NotApproved, $PendingWork, $Closed, $Expired];
    }
}

if (!function_exists('ptwSubpermitChartData')) {

    function ptwSubpermitChartData($type)
    {

        switch ($type) {
            case PTW_SUB_PERMIT_GAS:
                $chartData = new Gas;
                break;
            case PTW_SUB_PERMIT_ISOLATION:
                $chartData = new Isolation;
                break;
            case PTW_SUB_PERMIT_SURFACE:
                $chartData = new Surface;
                break;
            case PTW_SUB_PERMIT_HOTWORK:
                $chartData = new Hotwork;
                break;
            case PTW_SUB_PERMIT_WORKTRAFFIC:
                $chartData = new Traffic;
                break;
            case PTW_SUB_PERMIT_LIFTING:
                $chartData = new Lifting;
                break;
            case PTW_SUB_PERMIT_DIVING:
                $chartData = new Diving;
                break;
        }

        $chartData = $chartData->select('ptw_status', 'ptw_sub_permit_status.status_name', DB::raw("count(*) as count"))
            ->leftJoin('ptw_sub_permit_status', 'ptw_sub_permit_status.id', 'ptw_status')
            ->groupBy('ptw_status')
            ->get();

        $chartDataArray =  $chartData;

        $NotApproved = $PendingWork = $Closed = $Expired = 0;

        $pendingArray = [
            SUBPERMIT_STATUS_PENDING,
            SUBPERMIT_STATUS_REJECTED,
        ];
        foreach ($chartDataArray as $data) {

            if (in_array($data->ptw_status, $pendingArray)) {

                $NotApproved  += $data->count;
            } else if ($data->ptw_status == SUBPERMIT_STATUS_APPROVED) {
                $PendingWork  += $data->count;
            } else if ($data->ptw_status == SUBPERMIT_STATUS_CLOSED) {
                $Closed  += $data->count;
            } else if ($data->ptw_status == SUBPERMIT_STATUS_EXPIRED) {
                $Expired  += $data->count;
            }
        }

        return [$NotApproved, $PendingWork, $Closed, $Expired];
    }
}


if (!function_exists('sendNotificationGeneral')) {

    function sendNotificationGeneral($general)
    {

        $reuest = request();

        /**
         * Send Email Notification
         */
        $mailsubject = 'New General PTW Created ';

        /**
         *  Email & Web App Notification
         */


        $email_id = '';
        $userId = [];
        $sendtoname = '';
        $auto_id = '';
        $username = getUsername($general->created_by);
        $primaryId = encryptId($general->id);
        $id = $general->id;
        $createduser = Auth::id();

        $mailsubject = "[PTW Notification - " . PTWID($id) . " ] " . 'New General PTW submited for Approval';

        if ($email_id != '' || $email_id != null) {

            $contentdetails =  $general;
            $contentArray  = $contentdetails->toArray();

            $contentArray['name'] = $sendtoname;
            $contentArray['email_id'] =  $email_id;
            $contentArray['mail_subject'] = $mailsubject;
            $contentArray['auto_id'] = $auto_id;

            Mail::to($contentArray['email_id'])->queue(new GeneralPTWEmail($contentArray));
        }

        /**
         * Send Web notification
         */

        $notificationData = array(
            'notification_type' => 1,
            'module_type' => NOTIFICATION_GENERAL,
            'notification_message' => $mailsubject,
            'mobile_notification' => json_encode(array(
                'title' => $mailsubject,
                'message' => 'New General PTW -  ' . $auto_id . ' created by ' . $username,
                'icon' => 'public/assets/images/notification/ptw.png',
                'id' => $id,
                'module' => NOTIFICATION_GENERAL,
            )),
            'web_link' =>  admin_url('ptw/general/view/' . $primaryId),
            'assigned_user' => array_to_string($userId),
            'created_by' => $createduser,
        );
        notificationSave($notificationData);

        /**
         * Send Mobile Push notification
         */

        $notifydata = [
            'title' => $mailsubject,
            'message' => 'New General PTW' . $auto_id . ' created by ' . $username,
        ];
        mobilePushNotification($userId, $notifydata);
    }
}

/**
 * PTW Chart data
 */

if (!function_exists('PTWChart')) {

    function PTWChart()
    {
        $genearl = new General();
        $chartData =  $genearl->chartData();

        $locationDetails = Location::get();

        $chartDataArray = [];

        if (count($chartData) > 0) {

            foreach ($chartData as $data) {
                $chartDataArray[$data->location_name][$data->status_id] = $data->count;
            }
        }


        $finalChartData = [];

        $permitstatus = PermitStatus::get();

        $subpermit_approval_pending = [];
        $area_owner_approval_pending = [];
        $area_owner_rejected = [];
        $ghse_approval_pending = [];
        $ghse_rejected = [];
        $sa_approval_pending = [];
        $sa_rejected = [];
        $ptw_approved = [];
        $ptw_expired = [];
        $ptw_closed = [];

        foreach ($locationDetails as $location) {

            $locationName = $location->location_name;
            $finalChartData['label'][] = $locationName;

            $subpermit_approval_pending[] = isset($chartDataArray[$locationName][PERMIT_STATUS_SP_PENDING]) ? $chartDataArray[$locationName][PERMIT_STATUS_SP_PENDING] : 0;
            $area_owner_approval_pending[] = isset($chartDataArray[$locationName][PERMIT_STATUS_AO_PENDING]) ? $chartDataArray[$locationName][PERMIT_STATUS_AO_PENDING] : 0;
            $area_owner_rejected[] = isset($chartDataArray[$locationName][PERMIT_STATUS_AO_REJECTED]) ? $chartDataArray[$locationName][PERMIT_STATUS_AO_REJECTED] : 0;
            $ghse_approval_pending[] = isset($chartDataArray[$locationName][PERMIT_STATUS_GHSE_PENDING]) ? $chartDataArray[$locationName][PERMIT_STATUS_GHSE_PENDING] : 0;
            $ghse_rejected[] = isset($chartDataArray[$locationName][PERMIT_STATUS_GHSE_REJECTED]) ? $chartDataArray[$locationName][PERMIT_STATUS_GHSE_REJECTED] : 0;
            $sa_approval_pending[] = isset($chartDataArray[$locationName][PERMIT_STATUS_SA_PENDING]) ? $chartDataArray[$locationName][PERMIT_STATUS_SA_PENDING] : 0;
            $sa_rejected[] = isset($chartDataArray[$locationName][PERMIT_STATUS_SA_REJECTED]) ? $chartDataArray[$locationName][PERMIT_STATUS_SA_REJECTED] : 0;
            $ptw_approved[] = isset($chartDataArray[$locationName][PERMIT_STATUS_PTW_APPROVED]) ? $chartDataArray[$locationName][PERMIT_STATUS_PTW_APPROVED] : 0;
            $ptw_expired[] = isset($chartDataArray[$locationName][PERMIT_STATUS_PTW_EXPIRED]) ? $chartDataArray[$locationName][PERMIT_STATUS_PTW_EXPIRED] : 0;
            $ptw_closed[] = isset($chartDataArray[$locationName][PERMIT_STATUS_PTW_CLOSED]) ? $chartDataArray[$locationName][PERMIT_STATUS_PTW_CLOSED] : 0;
        }

        $finalChartData['data'][PERMIT_STATUS_SP_PENDING]['data'] = $subpermit_approval_pending;
        $finalChartData['data'][PERMIT_STATUS_AO_PENDING]['data'] = $area_owner_approval_pending;
        $finalChartData['data'][PERMIT_STATUS_AO_REJECTED]['data'] = $area_owner_rejected;
        $finalChartData['data'][PERMIT_STATUS_GHSE_PENDING]['data'] = $ghse_approval_pending;
        $finalChartData['data'][PERMIT_STATUS_GHSE_REJECTED]['data'] = $ghse_rejected;
        $finalChartData['data'][PERMIT_STATUS_SA_PENDING]['data'] = $sa_approval_pending;
        $finalChartData['data'][PERMIT_STATUS_SA_REJECTED]['data'] = $sa_rejected;
        $finalChartData['data'][PERMIT_STATUS_PTW_APPROVED]['data'] = $ptw_approved;
        $finalChartData['data'][PERMIT_STATUS_PTW_EXPIRED]['data'] = $ptw_expired;
        $finalChartData['data'][PERMIT_STATUS_PTW_CLOSED]['data'] = $ptw_closed;

        return $finalChartData;
    }
}


if (!function_exists('PTWID')) {

    function PTWID($id)
    {

        $ptwdetails = General::find($id);

        return $ptwdetails->ptw_id;
    }
}

