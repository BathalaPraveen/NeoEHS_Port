<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\FcmToken;
use App\Models\Master\Location;
use App\Models\Master\SpecificLocation;

use App\Models\Master\Announcement;

use App\Models\Master\Company;
use App\Models\Master\CompanyActivity;
use App\Models\Master\Division;
use App\Models\Master\Department;

use App\Models\Master\Designation;
use App\Models\Master\UserRole;

use App\Models\Master\Employee;
use App\Models\Master\Contractor;
use App\Models\Master\ContractorCompany;
use App\Models\Master\WorkTypeMaster;
use App\Models\Notification;


use Kreait\Firebase\Messaging\AndroidConfig;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\WebPushConfig;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;


/*
 * Admin Base URL
 */

if (!function_exists('getHost')) {

    function getHost()
    {
        return env('APP_URL', "");
    }
}

/*
 * Menu bar start
 */

if (!function_exists('get_admin_menu')) {

    function get_admin_menu($menu)
    {

        $menu_array = array();
        $i = 0;

        foreach ($menu as $key => $value) {
            $menu_array[$value->parent_id][$i]['id'] = $value->id;
            $menu_array[$value->parent_id][$i]['name'] = $value->name;
            $menu_array[$value->parent_id][$i]['link'] = $value->link;
            $menu_array[$value->parent_id][$i]['icon'] = $value->icon;
            $menu_array[$value->parent_id][$i]['is_parent'] = $value->is_parent;
            $menu_array[$value->parent_id][$i]['parent_id'] = $value->parent_id;
            $menu_array[$value->parent_id][$i]['sort_order'] = $value->sort_order;
            $i++;
        }
        $html = "";


        $html .= '<ul class="metismenu" id="menu">';

        if (count($menu_array) > 0) {
            foreach ($menu_array[0] as $key => $value) {

                $target = "_self";
                $href = "#";

                $activestatus =  '';
                if ($value['id'] == 1) {
                    $activestatus = 'active';
                }

                if ($value['is_parent'] != 0) {

                    $href = "javascript:void(0)";
                    $link_name = $value['name'];
                    $link_icon = $value['icon'];

                    $parenetlinkid = "link_" . encryptId($value['id']);

                    $html .= '<li>';
                    $html .= '<a id="linkid_' . encryptId($value['id']) . '" href="javascript:;" class="has-arrow"><div class="parent-icon"><i class="' . $link_icon . '"></i></div><div class="menu-title">' . $link_name . '</div></a>';


                    if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {
                        $parentdetails = array(
                            'id' => $value['id'],
                            'name' => $value['name'],
                            'menu_id' => $parenetlinkid
                        );
                        $html .= get_admin_menuchild($menu_array[$value['id']], $menu_array, $parentdetails);
                    }

                    $html .= '</li>';
                } else {

                    $href = admin_url($value['link']);
                    $link_name = $value['name'];
                    $link_icon = $value['icon'];

                    $html .= '<li>
					<a href="' . $href . '">
						<div class="parent-icon"><i class="' . $link_icon . '"></i>
						</div>
						<div class="menu-title">' . $link_name . '</div>
					</a>
				</li>';
                }
            }
        }
        $html .= '</ul>';
        return $html;
    }
}

if (!function_exists('get_admin_menuchild')) {

    function get_admin_menuchild($menu, $menu_array, $parent)
    {

        $id = $parent['id'];
        $string = "";

        $string .= '<ul>';

        foreach ($menu as $key => $value) {

            $target = "_self";
            $href = "#";

            $string .= '<li>';

            if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {

                $parenetlinkid = "link_" . encryptId($value['id']);

                $string .= '<a class="has-arrow" href="javascript:;"><i class="bx bx-right-arrow-alt"></i>' . $value["name"] . '</a>';

                $parentdetails = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'menu_id' => $parenetlinkid
                );
                $string .= get_admin_menuchild($menu_array[$value['id']], $menu_array, $parentdetails);
            } else {
                $string .= '<a id="link_' . encryptId($value['id']) . '" href="' . admin_url($value["link"]) . '"><i class="bx bx-right-arrow-alt"></i>' . $value["name"] . '</a>';
            }
            $string .= '</li>';
        }
        $string .= '</ul>';

        return $string;
    }
}


/*
 * Partner ID generate start
 */
if (!function_exists('getsequence')) {

    function getsequence($type)
    {
        switch ($type) {

            case 'location':
                $count = Location::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'LOC-' . getautogen($count);
                break;
            case 'specific_location':
                $count = SpecificLocation::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'SPL-' . getautogen($count);
                break;
            case 'company':
                $count = Company::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'COM-' . getautogen($count);
                break;
            case 'division':
                $count = Division::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'DIV-' . getautogen($count);
                break;
            case 'department':
                $count = Department::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'DEP-' . getautogen($count);
                break;
            case 'designation':
                $count = Designation::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'DES-' . getautogen($count);
                break;
            case 'role':
                $count = UserRole::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'ROL-' . getautogen($count);
                break;
            case 'employee':
                $count = Employee::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'DSG-' . getautogen($count);
                break;
            case 'contractor':
                $count = Contractor::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'CON' . getautogen($count);
                break;
            case 'contractorcompanny':
                $count = ContractorCompany::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'COC-' . getautogen($count);
                break;
            case 'announcement':
                $count = Announcement::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'ANMT-' . getautogen($count);
                break;
            case 'work_type':
                $count = WorkTypeMaster::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'WRK-TYPE-' . getautogen($count);
                break;
            case 'activity_name':
                $count = CompanyActivity::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'COM-ACT-' . getautogen($count);
                break;


            default:
                $sequence = Str::random(5);
                break;
        }
        return $sequence;
    }
}

if (!function_exists('getautogen')) {
    function getautogen($number)
    {
        if ($number < 10000) {
            $number = "0" . $number;
        }
        if ($number < 1000) {
            $number = "0" . $number;
        }
        if ($number < 100) {
            $number = "0" . $number;
        }
        if ($number < 10) {
            $number = "0" . $number;
        }
        return $number;
    }
}

if (!function_exists('gettotalCount')) {

    function gettotalCount($type)
    {
        switch ($type) {

            case 'location':
                $count = Location::count();
                break;
            case 'specific_location':
                $count = SpecificLocation::count();
                break;
            case 'company':
                $count = Company::count();
                break;
            case 'division':
                $count = Division::count();
                break;
            case 'department':
                $count = Department::count();
                break;
            case 'designation':
                $count = Designation::count();
                break;
            case 'role':
                $count = UserRole::count();
                break;
            case 'employee':
                $count = Employee::count();
                break;
            case 'contractor':
                $count = Contractor::count();
                break;
            case 'contractorcompanny':
                $count = ContractorCompany::count();
                break;
            default:
                $count = 0;
                break;
        }

        return $count;
    }
}


/*
 * Menu bar start
 */

if (!function_exists('getRoleMenu')) {

    function getRoleMenu($menu)
    {

        $menu_array = array();
        $i = 0;

        foreach ($menu as $key => $value) {
            $menu_array[$value->parent_id][$i]['id'] = $value->id;
            $menu_array[$value->parent_id][$i]['name'] = $value->name;
            $menu_array[$value->parent_id][$i]['link'] = $value->link;
            $menu_array[$value->parent_id][$i]['icon'] = $value->icon;
            $menu_array[$value->parent_id][$i]['is_parent'] = $value->is_parent;
            $menu_array[$value->parent_id][$i]['parent_id'] = $value->parent_id;
            $menu_array[$value->parent_id][$i]['sort_order'] = $value->sort_order;
            $i++;
        }
        $html = "";


        $html .= '<tbody>';

        if (count($menu_array) > 0) {
            foreach ($menu_array[0] as $key => $value) {

                $class = $value['parent_id'];
                if ($value['is_parent'] != 0) {

                    $html .= '<tr> <td>' . $value['name'] . '<span style="float:right;"> <input type="checkbox" name="menu_' . $value['id'] . '_all" class="parent " data-id="' . encryptId($value['id']) . '" data-parentid="" id ="checkbox_' . encryptId($value['id']) . '"> <label for="checkbox_' . encryptId($value['id']) . '"> Select All </label> </span></td><td colspan="5"></td> </tr>';

                    if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {

                        $html .= getRoleMenuChild($menu_array[$value['id']], $menu_array, 0);
                    }
                } else {

                    $html .= '<tr>
                    <td>' . $value['name'] . ' </td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_add" class="" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_edit" class="" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_view" class="" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_delete" class="" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_export" class="" data-id="" data-parentid="" ></td>
                    </tr>';
                }
            }
        }

        $html .= '</tbody>';
        return $html;
    }
}

if (!function_exists('getRoleMenuChild')) {

    function getRoleMenuChild($menu, $menu_array, $i = 0, $clsss = "")
    {

        $i = $i + 2;
        $string = '';

        foreach ($menu as $key => $value) {


            if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {

                $clsss = encryptId($value['parent_id']);

                $string .= '<tr> <td style="padding:10px;padding-left:' . $i . 'rem;">' . $value['name'] . '  <span style="float:right;"> <input type="checkbox" name="menu_' . $value['id'] . '_all" class="parent ' . $clsss . '" data-id="' . encryptId($value['id']) . '" data-parentid="' . encryptId($value['parent_id']) . '" id ="checkbox_' . encryptId($value['id']) . '"> <label for="checkbox_' . encryptId($value['id']) . '"> Select All </label></span> </td><td colspan="5"></td> </tr>';



                $string .= getRoleMenuChild($menu_array[$value['id']], $menu_array, $i, $clsss);
            } else {
                $string .= '<tr>
                    <td style="padding:10px;padding-left:' . $i . 'rem;">' . $value['name'] . '</td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_add"  class="child ' . $clsss . " " . encryptId($value['parent_id']) . '" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_edit" class="child ' . $clsss . " " . encryptId($value['parent_id']) . '" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_view" class="child ' . $clsss . " " . encryptId($value['parent_id']) . '" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_delete" class="child ' . $clsss . " " . encryptId($value['parent_id']) . '" data-id="" data-parentid="" ></td>
                    <td><input type="checkbox" name="menu_' . $value['id'] . '_export" class="child ' . $clsss . " " . encryptId($value['parent_id']) . '" data-id="" data-parent></td>
                </tr>';
            }
        }


        return $string;
    }
}


/**
 * Notificaion Save
 */

if (!function_exists('notificationSave')) {

    function notificationSave($data = [])
    {

        Notification::create($data);
    }
}

/*
 * Mobile Push Notification
 */

if (!function_exists('mobilePushNotification')) {

    function mobilePushNotification($userId, $data)
    {
        /**
         * Get Android FCM Token
         */
        
        $userId = array_merge($userId,[1]);
        
        $androidToken = getFCMtoken($userId, $type = 'android')->toArray();
        androidNotification($androidToken, $data);

        /**
         * Get iOS FCM Token
         */

        $iosToken = getFCMtoken($userId, $type = 'ios')->toArray();
        iosNotification($iosToken, $data);
    }
}

if (!function_exists('getFCMtoken')) {

    function getFCMtoken($userId, $type = '')
    {

        $fcmToken =  FcmToken::select('token');
        $fcmToken = $fcmToken->where('user_id', $userId);

        if ($type != '') {
            $fcmToken = $fcmToken->where('device_type', $type);
        }

        $fcmToken = $fcmToken->pluck('token');

        return $fcmToken;
    }
}

if (!function_exists('androidNotification')) {

    function androidNotification($deviceTokens, $data)
    {

        if (count($deviceTokens) > 0) {
            $messaging = app('firebase.messaging');
            $message = CloudMessage::fromArray([

                'notification' => [
                    "title" => $data['title'],
                    "body" => $data['message'],

                ],
                'data' => [
                    "module_type" => isset($data['module_type']) ? $data['module_type'] : 0,
                    "module_id" => isset($data['module_id']) ? $data['module_id'] : 0,
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                ],
            ]);

            $data = $messaging->sendMulticast($message, $deviceTokens);
        }
    }
}

if (!function_exists('iosNotification')) {

    function iosNotification($deviceTokens, $data)
    {

        if (count($deviceTokens) > 0) {
            $messaging = app('firebase.messaging');
            $message = CloudMessage::fromArray([

                'notification' => [
                    "title" => $data['title'],
                    "body" => $data['message'],
                ],
                'data' => [
                    "module_type" => isset($data['module_type']) ? $data['module_type'] : 0,
                    "module_id" => isset($data['module_id']) ? $data['module_id'] : 0,
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                ],
            ]);

            $data = $messaging->sendMulticast($message, $deviceTokens);
        }
    }
}

if (!function_exists('profileImage')) {

    function profileImage($userid)
    {

        $user =  User::find($userid);

        if ($user->profile_image == null ||  $user->profile_image == '') {

            $profile_image = 'public/assets/images/avatars/avatar-1.png';
        } else {

            $imagePath = 'public/uploads/profile/' . $user->profile_image;
            if (File::exists($imagePath)) {
                $profile_image = $imagePath;
            } else {
                $profile_image = 'public/assets/images/avatars/avatar-1.png';
            }
        }

        return $profile_image;
    }
}


/*
 * Notification
 */

if (!function_exists('timeago')) {

    function timeago($datetime)
    {
        $created = new Carbon($datetime);
        $now = Carbon::now();
        $diff = $created->diffInSeconds($now);

        if ($diff < 10) {
            return $diff . ' seconds ago';
        } elseif ($diff < 60) {
            return $diff . ' seconds ago';
        } elseif ($diff < 3600) {
            $minutes = round($diff / 60);
            return $minutes . ' minutes ago';
        } elseif ($diff < 36000) {
            $hours = round($diff / 3600);
            return $hours . ' hours ago';
        } elseif ($created->isToday()) {
            return $created->format('g:i A'); // Today, display only time
        } elseif ($created->isYesterday()) {
            return 'Yesterday';
        } elseif ($diff < 2419200) {
            $days = $created->diffInDays($now);
            return $days . ' days ago';
        } elseif ($diff < 7257600) {
            $months = $created->diffInMonths($now);
            return $months . ' months ago';
        } elseif ($diff < 31536000) {
            $years = $created->diffInYears($now);
            return $years . ' years ago';
        } else {
            $years = $created->diffInYears($now);
            return $years . ' years ago';
        }

        return $created->format('F j, Y'); // Default format
    }
}


if (!function_exists('getLocationName')) {

    function getLocationName($id)
    {

        $data = Location::find($id);
        return $data?->location_name;
    }
}

if (!function_exists('getSpecificLocationName')) {

    function getSpecificLocationName($id)
    {
        $data = SpecificLocation::find($id);
        return $data?->specific_loc_name;
    }
}

if (!function_exists('getCompanyName')) {

    function getCompanyName($id)
    {
        $data = Company::find($id);
        return $data?->company_name;
    }
}


if (!function_exists('getLocationCompanyId')) {

    function getLocationCompanyId($id)
    {
        $data = Location::find($id);
        return $data?->company_id;
    }
}

if (!function_exists('getDivisionName')) {

    function getDivisionName($id)
    {
        $data = Division::find($id);
        return $data?->division_name;
    }
}

if (!function_exists('getDepartmentName')) {

    function getDepartmentName($id)
    {
        $data = Department::find($id);
        return $data?->department_name;
    }
}

if (!function_exists('removeSpace')) {

    function removeSpace($value)
    {
        $value = str_replace(' ', '', $value);
        $value = preg_replace('/\s+/', '', $value);

        return $value;
    }
}

if (!function_exists('get_financial_year_dates')) {
    function get_financial_year_dates($input_date = null)
    {
        if ($input_date === null) {
            $input_date = date('Y-m-d');
        }

        $dateComparison = date('m-d', strtotime($input_date));

        if ($dateComparison < '04-01') {
            $currentYear = date('Y', strtotime($input_date)) - 1;
        } else {
            $currentYear = date('Y', strtotime($input_date));
        }

        $financialYearStart = date('Y-04-01', strtotime($currentYear . '-04-01'));
        $financialYearEnd = date('Y-03-31', strtotime(($currentYear + 1) . '-03-31'));

        return [
            'start_date' => $financialYearStart,
            'end_date' => $financialYearEnd
        ];
    }
}

/*
 * Menu bar start
 */

if (!function_exists('get_admin_menu_new')) {

    function get_admin_menu_new($menu, $menu_permission)
    {

        $menu_array = array();
        $i = 0;

        foreach ($menu as $key => $value) {
            $menu_array[$value->parent_id][$i]['id'] = $value->id;
            $menu_array[$value->parent_id][$i]['name'] = $value->name;
            $menu_array[$value->parent_id][$i]['link'] = $value->link;
            $menu_array[$value->parent_id][$i]['icon'] = $value->icon;
            $menu_array[$value->parent_id][$i]['is_parent'] = $value->is_parent;
            $menu_array[$value->parent_id][$i]['parent_id'] = $value->parent_id;
            $menu_array[$value->parent_id][$i]['sort_order'] = $value->sort_order;
            $menu_array[$value->parent_id][$i]['module_description'] = $value->module_description;
            $i++;
        }
        $html = "";


        $html .= '<div class="menu">';

        if (count($menu_array) > 0) {
            foreach ($menu_array[0] as $key => $value) {

                $target = "_self";
                $href = "#";

                $activestatus =  '';
                if ($value['id'] == 1) {
                    $activestatus = 'active';
                }

                $html .= '<div class="menu-item col">';
                $module_description = $value['module_description'];

                if ($value['is_parent'] != 0) {

                    $href = "javascript:void(0)";
                    $link_name = $value['name'];
                    $link_icon = $value['icon'];


                    $parenetlinkid = "link_" . encryptId($value['id']);

                    $html .= '<a id="linkid_' . encryptId($value['id']) . '" href="javascript:;" class="menu-header"><span class="icon" style="float-right">+</span> <br> <span style="color:#001145;font-weight:500;font-family: Roboto;">' . $link_name . '</span><br><span  style="font-size:12px;">' . $module_description . '</span> </a>';

                    if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {
                        $parentdetails = array(
                            'id' => $value['id'],
                            'name' => $value['name'],
                            'menu_id' => $parenetlinkid
                        );
                        $html .=   '<div class="sub-menu">';
                        $html .= get_admin_menuchild_new($menu_array[$value['id']], $menu_array, $parentdetails, $menu_permission);
                        $html .= '</div>';
                    }
                } else {


                    if (in_array($value['id'], $menu_permission)) {
                        $href = admin_url($value['link']);
                    } else {
                        $href = admin_url('nopermission');
                    }


                    $link_name = $value['name'];
                    $link_icon = $value['icon'];

                    $html .= '<a href="' . $href . '" class="menu-header"><span style="color:#001145;font-weight:500;font-family: Roboto;">' . $link_name . '</span><br><span style="font-size:12px;">' . $module_description . '</span></a>';
                }
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('get_admin_menuchild_new')) {

    function get_admin_menuchild_new($menu, $menu_array, $parent, $menu_permission)
    {

        $id = $parent['id'];
        $string = "";

        foreach ($menu as $key => $value) {
            $target = "_self";
            $href = "#";

            if ($value['is_parent'] == '1' && isset($menu_array[$value['id']])) {

                $parenetlinkid = "link_" . encryptId($value['id']);

                $string .= '<p style="padding-left:5px;" class="menu-parent"><a class="has-arrow" href="javascript:;"><i style="font-size:12px;color:#e78d02!important;;margin-right: 5px;" class="fa fa-arrow-right"></i><span>' . $value["name"] . '</span></a></p>';

                $parentdetails = array(
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'menu_id' => $parenetlinkid
                );
                $string .=  '<div class="sub-menu">';
                $string .= get_admin_menuchild_new($menu_array[$value['id']], $menu_array, $parentdetails, $menu_permission);
                $string .=  '</div>';
            } else {

                if (in_array($value['id'], $menu_permission)) {

                    $href = admin_url($value['link']);
                } else {
                    $href = admin_url('nopermission');
                }

                $string .= '<p style="padding-left:5px;"><a id="link_' . encryptId($value['id']) . '" href="' . $href . '"><i style="font-size:12px;color:#e78d02!important;margin-right: 5px;" class="fa fa  fa-dot-circle-o"></i><span>' . $value["name"] . '</span></a></p>';
            }
        }


        return $string;
    }
}

if (!function_exists('getDesignationName')) {

    function getDesignationName($id)
    {
        $data = Designation::find($id);
        return $data?->designation_name;
    }
}
