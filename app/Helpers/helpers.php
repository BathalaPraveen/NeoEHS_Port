<?php

use Illuminate\Support\Facades\Auth;


/*
 * Encrypt & Decrypt start
 */

use App\Models\User;
use App\Models\Master\UserRole;
use App\Models\Master\WorkTypeMaster;

if (!function_exists('get_encryptVal')) {

    function get_encryptVal($id)
    {

        return strtr(base64_encode($id), '+/=', '-_,');
    }
}

if (!function_exists('get_decryptVal')) {

    function get_decryptVal($id)
    {
        return base64_decode(strtr($id, '-_,', '+/='));
    }
}

if (!function_exists('DBdateformat')) {

    function DBdateformat($date)
    {

        return date('Y-m-d', strtotime($date));
    }
}

if (!function_exists('DBdatetimeformat')) {

    function DBdatetimeformat($date)
    {

        return date('Y-m-d H:i:s', strtotime($date));
    }
}

if (!function_exists('Displaydateformat')) {

    function Displaydateformat($date)
    {
        if ($date == '' || $date == null  || $date == '1970-01-01') {
            return "";
        } else {
            return date('d-m-Y', strtotime($date));
        }
    }
}

if (!function_exists('Displaytimeformat')) {

    function Displaytimeformat($date)
    {

        return date('H:i A', strtotime($date));
    }
}

if (!function_exists('datastringreplace')) {

    function datastringreplace($date)
    {

        return str_replace("/", "-", $date);
    }
}

if (!function_exists('Displaydatetimeformat')) {

    function Displaydatetimeformat($date)
    {

        return date('d-m-Y H:i:s', strtotime($date));
    }
}

if (!function_exists('todaydate')) {

    function todaydate()
    {

        return date('d-m-Y');
    }
}

if (!function_exists('currenttime')) {

    function currenttime()
    {

        return date('H:i A');
    }
}


if (!function_exists('todayDbdate')) {

    function todayDbdate()
    {

        return date('Y-m-d');
    }
}

if (!function_exists('todaydatetime')) {

    function todaydatetime()
    {

        return date('d-m-Y H:i:s');
    }
}

if (!function_exists('todayDBdatetime')) {

    function todayDBdatetime()
    {

        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('monthyear')) {

    function monthyear()
    {

        return date('F,Y');
    }
}

if (!function_exists('currentyear')) {

    function currentyear()
    {

        return date('Y');
    }
}

if (!function_exists('print_array')) {

    function print_array($data, $exit = true)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        if ($exit)
            exit;
    }
}

if (!function_exists('parseData')) {

    function parseData($results = array(), $postval = '', $retunval = '')
    {
        $results = (is_array($results) && $results != FALSE) ? (object) $results : $results;
        return ($results != FALSE && isset($results->$postval) && ($results->$postval != '')) ? $results->$postval : $retunval;
    }
}

if (!function_exists('userDetails')) {

    function userDetails()
    {

        $request = request();
        $input['useragent'] = $request->server('HTTP_USER_AGENT');
        $input['ip'] = $request->ip();
        return ($input);
    }
}

if (!function_exists('insertUserLog')) {

    function insertUserLog($event = '', $custom_msg = '')
    {
        $request = request();

        if (\Auth::check()) {
            $input['user_id'] = \Auth::id();
        }

        $input['params'] = json_encode($request->all());
        $input['user_agent'] = $request->server('HTTP_USER_AGENT');
        $input['user_ip'] = $request->ip();
        $input['request_type'] = $request->method();
        $input['page_url'] = $request->fullUrl();
        $input['user_event'] = $event;
        $input['custom_msg'] = $custom_msg;

        if ($request->ajax()) {
            $input['is_ajax'] = 'YES';
        }

        DB::table('template_user_page_visit')->insert($input);

        return true;
    }
}

if (!function_exists('string_to_array')) {

    function string_to_array($string, $separate = ',')
    {
        return array_map('trim', explode($separate, $string));
    }
}

if (!function_exists('array_to_string')) {

    function array_to_string($array, $separate = ',')
    {

        return implode($separate, $array);
    }
}

if (!function_exists('merge_two_array')) {

    function merge_two_array($array1, $array2)
    {

        return $array = array_values(array_unique(array_merge($array1, $array2)));
    }
}

if (!function_exists('arrayEncrypt')) {

    function arrayEncrypt($arrayVal)
    {
        return array_map("encryptId", $arrayVal);
    }
}

if (!function_exists('arrayDecrypt')) {

    function arrayDecrypt($arrayVal)
    {
        if (is_array($arrayVal)) {
            if (count($arrayVal) > 0) {
                return array_map("decryptId", $arrayVal);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}

if (!function_exists('admin_url')) {

    function admin_url($value = "")
    {
        return config('constants.ADMIN_URL') . $value;
    }
}

if (!function_exists('priceRound')) {
    function priceRound($amount)
    {

        return round($amount);
        if (is_float($amount)) {
            return round($amount);
        } else {
            return $amount;
        }
    }
}

if (!function_exists('get_constant')) {

    function get_constant($value)
    {

        return config('constants.' . $value);
    }
}

if (!function_exists('getConstant')) {

    function getConstant($value)
    {

        $user = DB::table('template_constants')->select('value')->where('name', $value)->first();

        if ($user == null) {
            return '';
        } else {
            return $user->value;
        }
    }
}

if (!function_exists('encryptId')) {

    function encryptId($value)
    {

        $action = 'encrypt';
        $string = $value;
        $output = false;
        $encrypt_method = "AES-256-CBC";

        $secret_key = 'P(0p!e@e$k';
        $secret_iv = 'Peop!eDe$k';

        // hash
        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {

            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}

if (!function_exists('decryptId')) {

    function decryptId($encrypted)
    {

        $action = 'decrypt';
        $string = $encrypted;
        $output = false;
        $encrypt_method = "AES-256-CBC";

        $secret_key = 'P(0p!e@e$k';
        $secret_iv = 'Peop!eDe$k';

        // hash
        $key = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = $string;

            try {
                $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
                if ($output  == false) {
                    $output = $string;
                }
            } catch (Exception $ex) {
                $output = $string;
            }
        }

        return $output;
    }
}

if (!function_exists('getUsername')) {

    function getUsername($userid)
    {

        $user = DB::table('users')->select('name')->where('id', $userid)->where('trash', 'NO')->first();

        if ($user == null) {
            return '';
        } else {
            return $user->name;
        }
    }
}

if (!function_exists('getUseremail')) {

    function getUseremail($userid)
    {

        $user = DB::table('users')->select('email')->where('id', $userid)->where('trash', 'NO')->first();

        if ($user == null) {
            return '';
        } else {
            return $user->email;
        }
    }
}

if (!function_exists('getYesNoStatus')) {

    function getYesNoStatus($value)
    {
        $status = "";
        if ($value == 0) {
            $status = "NO";
        } elseif ($value == 1) {
            $status = "YES";
        } else {
            $status = "YES";
        }

        return $status;
    }
}

if (!function_exists('getChecked')) {

    function getChecked($value)
    {
        $status = "";
        if ($value == 0) {
            $status = "";
        } elseif ($value == 1) {
            $status = "checked";
        } else {
            $status = "";
        }

        return $status;
    }
}

if (!function_exists('getCheckedVal')) {

    function getCheckedVal($value, $check)
    {
        $status = "";
        if ($value == $check) {
            $status = "checked";
        } else {
            $status = "";
        }

        return $status;
    }
}

if (!function_exists('getSelected')) {

    function getSelected($value, $check)
    {
        $status = "";
        if ($value != $check) {
            $status = "";
        } elseif ($value == $check) {
            $status = "selected";
        } else {
            $status = "";
        }

        return $status;
    }
}

if (!function_exists('getActive')) {

    function getActive($value)
    {
        $status = "";
        if ($value == 0) {
            $status = "";
        } elseif ($value == 1) {
            $status = "active";
        } else {
            $status = "";
        }

        return $status;
    }
}

if (!function_exists('getCustomValue')) {

    function getCustomValue($table, $column, $value)
    {

        $returnval = DB::table($table)->where('id', $value)->where('trash', 'NO')->first();

        if ($returnval != null)
            return $returnval->$column;
        else
            return '';
    }
}

if (!function_exists('getSingleArray')) {

    function getSingleArray($key, $array_val = [])
    {
        $return_array = array();
        foreach ($array_val as $array) {

            $return_array[] = $array->$key;
        }

        return $return_array;
    }
}

function getMimetype($type)
{

    switch ($type) {
        case "pdf":
            $mime = "application/pdf";
            break;
        case "csv":
            $mime = "text/csv";
            break;
        case "doc":
            $mime = "application/msword";
            break;
        case "docx":
            $mime = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
        case "jpeg":
            $mime = "image/jpeg";
            break;
        case "jpg":
            $mime = "image/jpeg";
            break;
        case "tif":
            $mime = "image/tiff";
            break;
        case "tiff":
            $mime = "image/tiff";
            break;
        case "txt":
            $mime = "text/plain";
            break;
        case "xls":
            $mime = "application/vnd.ms-excel";
            break;
        case "xlsx":
            $mime = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            break;
        case "zip":
            $mime = "application/zip";
            break;
        default:
            $mime = "";
            break;
    }

    return $mime;
}

if (!function_exists('getMultipleValue')) {

    function getMultipleValue($table, $commaVal, $condCol, $dataCol)
    {
        $arrayCond = string_to_array($commaVal);

        $returnVal = DB::table($table)->whereIn($condCol, $arrayCond)->pluck($dataCol);

        $returnVal = array_to_string($returnVal->toArray(), ', ');


        return  $returnVal;
    }
}

if (!function_exists('selectIfInString')) {

    function selectIfInString($value, $commaVal)
    {
        $arrayVal = string_to_array($commaVal);

        if (in_array($value, $arrayVal)) {
            $returnVal = "Selected";
        } else {
            $returnVal = "";
        }

        return  $returnVal;
    }
}

if (!function_exists('selectIfInArray')) {

    function selectIfInArray($value, $arrayVal)
    {

        if (in_array($value, $arrayVal)) {
            $returnVal = "Selected";
        } else {
            $returnVal = "";
        }

        return  $returnVal;
    }
}

if (!function_exists('getDiscountPercent')) {

    function getDiscountPercent($total_amount, $discount_amount)
    {

        if (
            $discount_amount == 0 || $discount_amount == '' || $discount_amount == null ||
            $total_amount == 0 || $total_amount == '' || $total_amount == null
        ) {
            return 0;
        }


        $discount_percent = round(($discount_amount / $total_amount) * 100, 2);
        return  100 - $discount_percent;
    }
}

if (!function_exists('getProfileImage')) {

    function getProfileImage($image)
    {
        if ($image == null || $image == '') {
            return asset('public/assets/images/avatars/default_profile.png');
        } else {
            $file = asset('public/uploads/profile/' . $image);
            if (does_url_exists($file)) {
                return asset('public/uploads/profile/' . $image);
            }
            return asset('public/asset/admin/images/avatars/default_profile.png');
        }
    }
}

if (!function_exists('does_url_exists')) {
    function does_url_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }
}

if (!function_exists('getSequenceno')) {
    function getSequenceno($date, $id)
    {

        $d = strtotime($date);
        $seqno = date("ym", $d) . "0000" . $id;

        return $seqno;
    }
}

if (!function_exists('SanitizeInput')) {
    function SanitizeInput($string = '')
    {
        $returnString = preg_replace('/[^a-zA-Z0-9&-_! ]/s', '', $string);
        return $returnString;
    }
}

if (!function_exists('SanitizeInputArray')) {
    function SanitizeInputArray($input = [])
    {
        $returnArray = [];
        for ($i = 0; $i < count($input); $i++) {
            $returnArray[$i] = preg_replace('/[^a-zA-Z0-9&-_! ]/s', '', $input[$i]);
        }

        return $returnArray;
    }
}

if (!function_exists('getCustomColumn')) {

    function getCustomColumn($table, $columnName, $condCol, $dataCol)
    {
        $returnVal = DB::table($table)->where($condCol, $columnName)->first();

        return $returnVal->$dataCol;
    }
}

if (!function_exists('string_replace_custom')) {

    function string_replace_custom($replace_array, $replace_with, $string)
    {
        $returnVal = $string;
        foreach ($replace_array as $replace) {
            if (str_contains($string, $replace))
                $returnVal = str_replace($replace, $replace_with, $returnVal);
        }
        return $returnVal;
    }
}

if (!function_exists('getSelected')) {

    function getSelected($value, $check)
    {
        $status = "";
        if ($value != $check) {
            $status = "";
        } elseif ($value == $check) {
            $status = "selected";
        } else {
            $status = "";
        }

        return $status;
    }
}

if (!function_exists('getUser')) {

    function getUser($id)
    {
        return User::find($id);
    }
}


if (!function_exists('generateNumberArray')) {

    function generateNumberArray($number, $multiplier = '')
    {
        if ($multiplier  == '') {
            return range(1, $number);
        } else {
            return range(1, $number, $multiplier);
        }
    }
}


if (!function_exists('getUserRoleName')) {

    function getUserRoleName($userid)
    {

        $user =  User::find($userid);

        $userroleid = string_to_array($user->role);

        $roleName = array_to_string(UserRole::whereIn('id', $userroleid)->pluck('role_name')->toArray(), ", ");

        return $roleName;
    }
}

if (!function_exists('getUserRoleId')) {

    function getUserRoleId($userid)
    {

        $user =  User::find($userid);

        $userroleid = string_to_array($user->role);

        $roleids = UserRole::whereIn('id', $userroleid)->pluck('id')->toArray();

        return $roleids;
    }
}


if (!function_exists('isAdmin')) {

    function isAdmin()
    {
        if (in_array(ROLE_SUPERADMIN, getUserRoleId(Auth::id()))) {
            return TRUE;
        }

        return FALSE;
    }
}


if (!function_exists('CheckUserRole')) {

    function CheckUserRole($roleId)
    {

        $user =  User::find(Auth::id());

        $userroleid = string_to_array($user->role);

        $roleids = UserRole::whereIn('id', $userroleid)->pluck('id')->toArray();

        if (in_array($roleId, $roleids)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('checknull')) {

    function checknull($value)
    {

        return $value == null ? "" : $value;
    }
}


if (!function_exists('getEndDate')) {

    function getEndDate($fromdate, $addValue, $type = 1, $endDate = "")
    {

        $fromdate = DateTime::createFromFormat('d-m-Y', $fromdate);

        $futureDateTarget = new DateTime($fromdate->format('Y-m-d'));

        if ($type === 1) {
            $addValue = $addValue - 1;
            $futureDateTarget->modify('+' . $addValue . ' days');
        } elseif ($type === 2) {
            $futureDateTarget->modify('+' . $addValue . ' months');
        } elseif ($type === 3) {
            $futureDateTarget->modify('+' . $addValue . ' years');
        } else {
            return null;
        }

        if ($endDate != '') {
            $endDate = DateTime::createFromFormat('d-m-Y', $endDate);
            if ($endDate && $futureDateTarget > $endDate) {
                $futureDateTarget = $endDate;
            }
        }

        $formattedDate = $futureDateTarget->format('d-m-Y');
        return $formattedDate;
    }
}



if (!function_exists('replaceNullWithEmpty')) {

    function replaceNullWithEmpty(&$item, $key)
    {
        if (is_array($item)) {
            array_walk_recursive($item, 'replaceNullWithEmpty');
        } else {
            $item = ($item === null) ? "" : $item;
        }
    }
}

if (!function_exists('getAllUserName')) {

    function getAllUserName($userids)
    {

        $userid = string_to_array($userids);

        $UserName = array_to_string(User::whereIn('id', $userid)->pluck('name')->toArray(), ", ");

        return $UserName;
    }
}

if (!function_exists('getWorkTypeName')) {
    function getWorkTypeName($id)
    {
        $data = WorkTypeMaster::select('work_type_name')->where('id', $id)->first();

        return $data?->work_type_name ?? null;
    }
}

if (!function_exists('getReassignType')) {
    function getReassignType($type)
    {
        switch ($type) {
            case PTW_AO_REASSIGN:
                return '<span class ="badge bg-primary" >JobOwner Reassign</span>';
                break;
            case PTW_SA_REASSIGN:
                return '<span class ="badge bg-info" > Supervising Authority Reassign</span>';
                break;
            default:
                return '';
                break;
        }
    }
}

if (!function_exists('getContarctorType')) {
    function getContarctorType($type)
    {
        switch ($type) {
            case FROM_CON_MASTER:
                return 'Created from Contractor Company Master';
                break;
            case FROM_REGISTRATION:
                return 'Created from Registration Form';
                break;
            default:
                return '';
                break;
        }
    }
}
if (!function_exists('getContractorCompStatus')) {
    function getContractorCompStatus($status)
    {
        switch ($status) {
            case APPROVED:
                $status_name = '<span class="badge bg-success" style="padding: 0.55em .4em;">Approved</span>';
                break;
            case HSE_ACTION_PENDING:
                $status_name = '<span class="badge bg-info" style="padding: 0.55em .4em;">HSE Department Approval Pending</span>';
                break;
            case HSE_REJECTED:
                $status_name = '<span class="badge bg-danger" style="padding: 0.55em .4em;">HSE Department Rejected</span>';
                break;
            case IT_DEPT_ACTION_PENDING:
                $status_name = '<span class="badge bg-primary" style="padding: 0.55em .4em;">IT Department Approval Pending</span>';
                break;
            case IT_DEPT_REJECTED:
                $status_name = '<span class="badge bg-danger" style="padding: 0.55em .4em;">IT Department Rejected</span>';
                break;
            default:
                return '';
                break;
        }
        return $status_name;
    }
}
if (!function_exists('getContractorCompFilterStatus')) {
    function getContractorCompFilterStatus($status)
    {
        switch ($status) {
            case APPROVED:
                $status_name = 'Approved';
                break;
            case HSE_ACTION_PENDING:
                $status_name = 'HSE Department Approval Pending';
                break;
            case HSE_REJECTED:
                $status_name = 'HSE Department Rejected';
                break;
            case IT_DEPT_ACTION_PENDING:
                $status_name = 'IT Department Approval Pending';
                break;
            case IT_DEPT_REJECTED:
                $status_name = 'IT Department Rejected';
                break;
            default:
                return '';
                break;
        }
        return $status_name;
    }
}

