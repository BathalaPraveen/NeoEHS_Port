<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;

use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;


use App\Models\Master\Announcement;




class AnnouncementController extends BaseController
{
    /**
     * Machinery api
     *
     * @return \Illuminate\Http\Response
     */

    private $announcement;


    public function __construct()
    {

        $this->announcement = new Announcement();
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

            $announcement_list_array = $this->announcement->select('*');

            if ($search != '') {
                $announcement_list_array = $announcement_list_array->orWhere('announcement_title', "LIKE", "%" . $search . "%");
                $announcement_list_array = $announcement_list_array->orWhere('announcement_content', "LIKE", "%" . $search . "%");
            }

            $announcement_list_array = $announcement_list_array->orderBy('id', 'DESC')->paginate($request->input('per_page', 10));

            $announcement_list = $announcement_list_array->toArray();

            $data_array = [];
            foreach ($announcement_list_array as $listdata) {
                $data = [];

                $data['id'] = $listdata->id;
                $data['announcement_id'] = $listdata->announcement_id;
                $data['announcement_title'] = $listdata->announcement_title;
                $data['announcement_content'] = $listdata->announcement_content;
                $data['timeago'] = timeago($listdata->created_at);
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);

                $data_array[] = $data;
            }

            $announcement_details = [
                'per_page' => $announcement_list['per_page'],
                'current_page' => $announcement_list['current_page'],
                'from' => $announcement_list['from'],
                'to' => $announcement_list['to'],
                'total' => $announcement_list['total'],
                'total_page' => $announcement_list['last_page'],
                'list' => $data_array,
            ];

            $success = [
                'announcement_details' => $announcement_details
            ];

            return $this->sendResponse($success, 'Announcement Details');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }

    public function view(Request $request): JsonResponse
    {

        try {

            if (Auth::user()) {

                $id = $request->id;

                $announcementDetails = $this->announcement->selectOne($id);

                $success = array(
                    'announcement_id' => $announcementDetails->announcement_id ,
                    'announcement_title' => $announcementDetails->announcement_title ,
                    'announcement_content' => $announcementDetails->announcement_content ,
                );

                return $this->sendResponse($success, 'Announcement Details');
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
            }
        } catch (Exception $ex) {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 401);
        }
    }


}
