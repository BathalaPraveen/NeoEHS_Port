<?php

namespace App\Http\Controllers\API\PTW;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;
use Exception;

use App\Models\User;
use App\Models\Master\Location;

use App\Models\PTW\PTWActivity;
use App\Models\PTW\PTWCategory;
use App\Models\PTW\PTWItem;

use App\Models\PTW\PTWSubWorkPermit;
use App\Models\PTW\PTWFile;
use App\Models\PTW\PTWSubPermit;

use App\Models\PTW\Surface;
use App\Models\PTW\PermitStatusLog;
use App\Models\PTW\SubpermitStatus;

use App\Mail\PTW\SWPSurfaceEmail;

use App\Http\Controllers\API\PTW\GeneralController;

class SurfaceController extends BaseController
{
    /**
     * UAUC api
     *
     * @return \Illuminate\Http\Response
     */

    private $category;
    private $item;
    private $company;
    private $location;
    private $designation;
    private $contractorCompany;
    private $subworkpermit;
    private $ptwfile;
    private $ptwsubpermit;

    private $surface;
    private $permitstatuslog;
    private $status;

    private $general;

    public function __construct()
    {

        $this->category = new PTWCategory();
        $this->item = new PTWItem();
        $this->location = new Location();
        $this->subworkpermit = new PTWSubWorkPermit();
        $this->ptwfile = new PTWFile();
        $this->ptwsubpermit = new PTWSubPermit();

        $this->surface = new Surface();
        $this->permitstatuslog = new PermitStatusLog();
        $this->status = new SubpermitStatus();

        $this->general = new GeneralController();
    }


    public function list(Request $request)
    {

        if (Auth::user()) {

            $search = '';
            if ($request->has('search')) {
                if ($request->search != '' && $request->search != null) {
                    $search = $request->search;
                }
            }

            $ptw_list_array = $this->surface->select('ptw_sub_permit_surface_penetration.*', 'master_location.location_name',  'users.name');
            $ptw_list_array = $ptw_list_array->leftJoin('master_location', 'ptw_sub_permit_surface_penetration.location', '=', 'master_location.id');
            $ptw_list_array = $ptw_list_array->leftJoin('users', 'ptw_sub_permit_surface_penetration.created_by', '=', 'users.id');


            if ($search != '') {
                $ptw_list_array = $ptw_list_array->orWhere('ptw_id', "LIKE", "%" . $search . "%");
                $ptw_list_array = $ptw_list_array->orWhere('sub_permit_id', "LIKE", "%" . $search . "%");
            }

            if (CheckUserRole(ROLE_CONTRACTORADMIN)) {

                $ptw_list_array = $ptw_list_array->where('ptw_sub_permit_surface_penetration.created_by', Auth::id());
            }

            if (CheckUserRole(ROLE_NORMAL_USER)   || CheckUserRole(ROLE_CONTRACTORUSER)) {

                $ptw_list_array = $ptw_list_array->where('ptw_sub_permit_surface_penetration.created_by', Auth::id());
            }

            $ptw_list_array = $ptw_list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $ptw_list = $ptw_list_array->toArray();

            $data_array = [];
            foreach ($ptw_list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['general_ptw'] = $listdata->ptw_id;
                $data['ptw_id'] = $listdata->sub_permit_id;
                $data['location_name'] = $listdata->location_name;
                $data['username'] = $listdata->name;
                $data['status'] = subpermitStatusName($listdata->ptw_status);
                $data['description'] = $listdata->applicant_remarks;
                $data['status_id'] = $listdata->ptw_status;
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                $data_array[] = $data;
            }

            $ptw_details = [
                'per_page' => $ptw_list['per_page'],
                'current_page' => $ptw_list['current_page'],
                'from' => $ptw_list['from'],
                'to' => $ptw_list['to'],
                'total' => $ptw_list['total'],
                'total_page' => $ptw_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'ptw_details' => $ptw_details
            ];

            return $this->sendResponse($success, 'Surface PTW Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request)
    {

        try {

            if (Auth::user()) {

                $id = $request->id;

                $surface = $this->surface->selectOne($id);

                $surfaceDetails =    $this->general->surfaceView($surface->ptw_id);

                $success = array(
                    'surfaceDetails' => $surfaceDetails,
                );

                return $this->sendResponse($success, 'Surface PTW Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function statupupdate(Request $request)
    {

        try {

            $id = $request->id;
            $permit = $this->surface->find($id);
            $status = $request->status;

            if ($status == 'Approve') {
                $is_reject = 0;
                $ptw_status = SUBPERMIT_STATUS_APPROVED;
            } else if ($status =='Reject') {
                $is_reject = 1;
                $ptw_status = SUBPERMIT_STATUS_REJECTED;
            }

            $ptw_id = $permit->ptw_id;

            $this->surface->statuschange($id, $ptw_status);

            $this->ptwsubpermit->statuschange($ptw_id, PTW_SUB_PERMIT_SURFACE, $ptw_status);

            if ($is_reject == 1) {

                /**
                 * Send Email Notification
                 */

                $notifywhere = array(
                    'id' => $permit->created_by
                );

                $userids = User::where($notifywhere)->pluck('id')->toArray();
                $users = User::where($notifywhere)->get();

                if (count($users) > 0) {

                    foreach ($users as $user) {

                        $email_id = $user->email;

                        $mailsubject = "[PTW Notification - " . PTWID($ptw_id) . " ] " .  'Surface Penetration PTW Request is Rejected';


                        if ($email_id != '' || $email_id != null) {

                            $surfacedetails =  $this->surface->selectOne($permit->id);
                            $surfaceArray  = $surfacedetails->toArray();


                            $surfaceArray['name'] = $user->name;
                            $surfaceArray['email_id'] =  $email_id;
                            $surfaceArray['mail_subject'] = $mailsubject;

                            Mail::to($surfaceArray['email_id'])->queue(new SWPSurfaceEmail($surfaceArray));
                        }
                    }
                }

                if (count($userids) > 0) {

                    /**
                     * Send Web notification
                     */

                    $notificationData = array(
                        'notification_type' => 1,
                        'module_type' => 5,
                        'notification_message' => $mailsubject,
                        'mobile_notification' => json_encode(array(
                            'title' => $mailsubject,
                            'message' => 'Surface Penetration PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                            'icon' => 'public/assets/images/icons/permit_to_work.png',
                            'id' => $permit->id,
                            'module' => 2,
                        )),
                        'web_link' =>  admin_url('ptw/surfacepenetration/edit/' . encryptId($permit->id)),
                        'assigned_user' => array_to_string($userids),
                        'created_by' => Auth::id(),
                    );
                    notificationSave($notificationData);

                    /**
                     * Send Mobile Push notification
                     */

                    $userId = $userids;
                    $notifydata = [
                        'title' => $mailsubject,
                        'message' => 'Surface Penetration PTW - ' . $permit->sub_permit_id . ' is Rejected, Please update and resubmit.',
                    ];
                    mobilePushNotification($userId, $notifydata);
                }
            }

            $insert_array = array(
                'permit_type' => PTW_SUB_PERMIT_SURFACE,
                'ptw_id' => $ptw_id,
                'sub_permit_id' => $id,
                'from_status' => 0,
                'to_status' => $ptw_status,
                'is_reject' => $is_reject,
                'remarks' => $request->remarks,
                'approved_by' => Auth::id(),
            );
            $this->permitstatuslog->create($insert_array);

            permitStatusUpdate($ptw_id);

            $success = array();

            return $this->sendResponse($success, 'Successfully status updated');
        } catch (Exception $ex) {
            dd($ex);
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }
}
