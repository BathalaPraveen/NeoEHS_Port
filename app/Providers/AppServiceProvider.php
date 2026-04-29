<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Rules\EmailValidation;

use App\Models\Notification;
use App\Models\NotificationLog;
use App\Models\Master\UserRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        ini_set('memory_limit', '256M'); // or 512M
        Schema::defaultStringLength(255);
        Paginator::useBootstrap();

        Validator::extend('recaptcha', 'App\\Validators\\CustomValidation@validate');
        Validator::extend('emailid', 'App\\Validators\\CustomValidation@emailid');

        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        defined('DAYS') or define('DAYS', $days);

        $days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        defined('SHORT_DAYS') or define('SHORT_DAYS', $days);

        $days = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        defined('MONTH') or define('MONTH', $days);

        $days =  ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        defined('SHORT_MONTH') or define('SHORT_MONTH', $days);


        defined('MENU') or define('MENU', 'template_left_menu');

        defined('ROLE_SUPERADMIN') or define('ROLE_SUPERADMIN', 1);
        defined('ROLE_ADMIN') or define('ROLE_ADMIN', 1);
        defined('ROLE_NORMAL_USER') or define('ROLE_NORMAL_USER', 2);
        defined('ROLE_HSEUSER') or define('ROLE_HSEUSER', 5);

        /**
         * UAUC
         */
        defined('ROLE_UAUC_CREATOR') or define('ROLE_UAUC_CREATOR', 3);
        defined('ROLE_JOBOWNER') or define('ROLE_JOBOWNER', 4);

        /**
         * PTW
         */
        defined('ROLE_CONTRACTORADMIN') or define('ROLE_CONTRACTORADMIN', 6);
        defined('ROLE_CONTRACTORUSER') or define('ROLE_CONTRACTORUSER', 7);
        defined('ROLE_AREA_OWNER') or define('ROLE_AREA_OWNER', 8);
        defined('ROLE_GHSE_APPROVER') or define('ROLE_GHSE_APPROVER', 9);
        defined('ROLE_SUPERVISING_AUTHORITY') or define('ROLE_SUPERVISING_AUTHORITY', 10);
        defined('ROLE_GAS_PERMIT_APPROVER') or define('ROLE_GAS_PERMIT_APPROVER', 11);
        defined('ROLE_ISOLATION_PERMIT_APPROVER') or define('ROLE_ISOLATION_PERMIT_APPROVER', 12);
        defined('ROLE_SURFACE_PERMIT_APPROVER') or define('ROLE_SURFACE_PERMIT_APPROVER', 13);
        defined('ROLE_HOTWORK_PERMIT_APPROVER') or define('ROLE_HOTWORK_PERMIT_APPROVER', 14);
        defined('ROLE_TRAFFIC_PERMIT_APPROVER') or define('ROLE_TRAFFIC_PERMIT_APPROVER', 15);
        defined('ROLE_LIFTING_PERMIT_APPROVER') or define('ROLE_LIFTING_PERMIT_APPROVER', 16);
        defined('ROLE_DIVING_PERMIT_APPROVER') or define('ROLE_DIVING_PERMIT_APPROVER', 17);
        defined('ROLE_CARE_TAKER') or define('ROLE_CARE_TAKER', 18);
        defined('ROLE_CRANE_OPERATOR') or define('ROLE_CRANE_OPERATOR', 19);
        defined('ROLE_HOD') or define('ROLE_HOD', 20);
        defined('ROLE_PTW_CREATOR') or define('ROLE_PTW_CREATOR', 21);
        defined('ROLE_IT_DEPARTMENT') or define('ROLE_IT_DEPARTMENT', 22);

        /**
         * Contarctor
         */

        defined('APPROVED') or define('APPROVED', 1);
        defined('HSE_ACTION_PENDING') or define('HSE_ACTION_PENDING', 2);
        defined('HSE_REJECTED') or define('HSE_REJECTED', 3);
        defined('IT_DEPT_ACTION_PENDING') or define('IT_DEPT_ACTION_PENDING', 4);
        defined('IT_DEPT_REJECTED') or define('IT_DEPT_REJECTED', 5);

        defined('FROM_CON_MASTER') or define('FROM_CON_MASTER', 1);
        defined('FROM_REGISTRATION') or define('FROM_REGISTRATION', 2);

        /**
         * INSPECTION
         */
        defined('ROLE_INSP_CREATOR') or define('ROLE_INSP_CREATOR', 22);
        defined('ROLE_INSP_TSD_REP_CREATOR') or define('ROLE_INSP_TSD_REP_CREATOR', 23);
        defined('ROLE_INSP_MSD_REP_CREATOR') or define('ROLE_INSP_MSD_REP_CREATOR', 24);
        defined('ROLE_INSP_BUILDING_CARETAKER') or define('ROLE_INSP_BUILDING_CARETAKER', 32);

        /**
         * WASTE MANAGEMENT
         */
        defined('ROLE_WASTE_CREATOR') or define('ROLE_WASTE_CREATOR', 25);
        defined('ROLE_WASTE_GHSE_APPROVER') or define('ROLE_WASTE_GHSE_APPROVER', 26);

        /**
         * HIRADC MANAGEMENT
         */
        defined('ROLE_HIRADC_CREATOR') or define('ROLE_HIRADC_CREATOR', 27);
        defined('ROLE_HIRADC_HOD_APPROVER') or define('ROLE_HIRADC_HOD_APPROVER', 28);

        /**
         * CHEMICAL MANAGEMENT
         */
        defined('ROLE_CHEMICAL_REVIEWER') or define('ROLE_CHEMICAL_REVIEWER', 29);
        defined('ROLE_CHEMICAL_SUPERVISOR_APPROVER') or define('ROLE_CHEMICAL_SUPERVISOR_APPROVER', 30);
        defined('ROLE_CHEMICAL_GHSE_APPROVER') or define('ROLE_CHEMICAL_GHSE_APPROVER', 31);
        defined('ROLE_CHEMICAL_HOD') or define('ROLE_CHEMICAL_HOD', 36);


        defined('ROLE_IT_ADMIN') or define('ROLE_IT_ADMIN', 33);
        defined('ROLE_HSE_ADMIN') or define('ROLE_HSE_ADMIN', 34);

        defined('ROLE_LEADERSHIP_TEAM') or define('ROLE_LEADERSHIP_TEAM', 35);



        defined('ADD_DATE') or define('ADD_DATE', 1);
        defined('ADD_MONTH') or define('ADD_MONTH', 2);
        defined('ADD_YEAR') or define('ADD_YEAR', 3);

        defined('MSD_DIVISION') or define('MSD_DIVISION', 19);
        defined('TSD_DIVISION') or define('TSD_DIVISION', 21);





        /**
         * Notification Module ID
         */
        defined('NOTIFICATION_UAUC') or define('NOTIFICATION_UAUC', 1);
        defined('NOTIFICATION_GENERAL') or define('NOTIFICATION_GENERAL', 2);
        defined('NOTIFICATION_GAS') or define('NOTIFICATION_GAS', 3);
        defined('NOTIFICATION_ISOLATION') or define('NOTIFICATION_ISOLATION', 4);
        defined('NOTIFICATION_SURFACE') or define('NOTIFICATION_SURFACE', 5);
        defined('NOTIFICATION_HOTWORK') or define('NOTIFICATION_HOTWORK', 6);
        defined('NOTIFICATION_WORKTRAFFIC') or define('NOTIFICATION_WORKTRAFFIC', 7);
        defined('NOTIFICATION_LIFTING') or define('NOTIFICATION_LIFTING', 8);
        defined('NOTIFICATION_DIVING') or define('NOTIFICATION_DIVING', 9);
        defined('NOTIFICATION_INSPECTION') or define('NOTIFICATION_INSPECTION', 10);
        defined('NOTIFICATION_INCIDENT_NOTIFICATION') or define('NOTIFICATION_INCIDENT_NOTIFICATION', 11);
        defined('NOTIFICATION_HIRADC') or define('NOTIFICATION_HIRADC', 12);
        defined('NOTIFICATION_MACHINERY') or define('NOTIFICATION_MACHINERY', 13);
        defined('NOTIFICATION_CHEMICAL') or define('NOTIFICATION_CHEMICAL', 14);
        defined('NOTIFICATION_WASTE') or define('NOTIFICATION_WASTE', 15);




        View::composer('*', function ($view) {

            /**
             * Left Menu Function
             */

            $mymenu = range(1, 500);
            $menu_permission = [];
            if (Auth::check()) {

                if (CheckUserRole(ROLE_SUPERADMIN)) {

                    $roleIds = string_to_array(Auth::user()->role);
                    $userRoles =  UserRole::whereIn('id', $roleIds)->get();

                    $mymenu = [];
                    foreach ($userRoles as $role) {

                        $permissionArray = ($role->role_permission == "" || $role->role_permission == null) ? [] : string_to_array($role->role_permission);

                        $mymenu = array_unique(array_merge($mymenu, $permissionArray));
                    }

                    $mymenu = range(1, 500);
                    $menu_permission = range(1, 500);
                } else {

                    $roleIds = string_to_array(Auth::user()->role);
                    $userRoles =  UserRole::whereIn('id', $roleIds)->get();

                    $mymenu = [];
                    foreach ($userRoles as $role) {
                        $permissionArray = ($role->role_permission == "" || $role->role_permission == null) ? [] : string_to_array($role->role_permission);

                        $mymenu =   array_unique(array_merge($mymenu, $permissionArray));
                    }
                    $menu_permission = $mymenu;
                }
            }

            $menu = DB::table(MENU)
                ->select('id', 'name', 'namekey', 'link', 'icon', 'parent_id', 'is_parent', 'is_module', 'sort_order')
                ->where('status', 1)
                ->where('trash', 'NO')
                ->whereIn('id', $mymenu)
                ->orderBy('parent_id', 'asc')
                ->orderBy('sort_order', 'asc')
                ->get();

            // Store menu data for potential regeneration with pageurl
            View::share('_menu_data', $menu);
            View::share('_menu_permission', $menu_permission);

            // Generate initial menu (will be regenerated in View Composer if pageurl is available)
            $menu_lsit = get_admin_menu($menu, $menu_permission);

            View::share('left_menu', $menu_lsit);

            if (session()->has('locale')) {
                $langid = session()->get('locale');
            } else {
                $langid = env('APP_LOCALE');
            }

            // $currentlanguage = Language::where('short_name', $langid)->first();
            // View::share('currentlanguage', $currentlanguage);

            // $languageDetails = Language::orderBy('sort_order', 'ASC')->get();
            // View::share('languageDetails', $languageDetails);

            if (Auth::check()) {
                $theme = Auth::user()->theme;
            } else {
                $theme = 'light-skin';
            }

            if ($theme  == '' ||  $theme  == null ||  $theme  == 'light-skin') {
                $themetype = 'light-skin';
            } else {
                $themetype = 'dark-skin';
            }

            View::share('themetype', $themetype);


            /**
             * Notification Function
             */

            $notification_list_array = Notification::select('*')
                ->whereRaw("FIND_IN_SET(?, assigned_user) > 0", [Auth::id()]);

            $notification_list_array = $notification_list_array->orderBy('id', 'DESC')->paginate(20);
            $notification_list = $notification_list_array->toArray();

            $userReadCount = NotificationLog::where('user_id', Auth::id())->count();
            $data_array = [];
            foreach ($notification_list_array as $listdata) {
                $data = [];

                $message =   json_decode($listdata->mobile_notification);
                $viewed_user =   string_to_array($listdata->viewed_user);

                $viewed_status = 0;
                if (in_array(Auth::id(), $viewed_user)) {
                    $viewed_status = 1;
                } else {
                    $viewed_status = 0;
                }

                $data['id'] = $listdata->id;
                $data['title'] =  $message->title;
                $data['message'] = $message->message;
                $data['icon'] = $message->icon;
                $data['web_link'] = $listdata->web_link;
                $data['time'] = timeago($listdata->created_at);
                $data['created_at'] = Displaydatetimeformat($listdata->created_at);
                $data['read_status'] = $viewed_status;

                $data_array[] = $data;
            }
            $unreadCount = $notification_list['total'] - $userReadCount;
            View::share('unreadCount', $unreadCount);
            View::share('notification_list', $data_array);
        });



        View::composer('admin.layouts.layout', function ($view) {
            $pageurl = trim($view->getFactory()->yieldContent('pageurl'));

            if (!$pageurl) {
                return;
            }
            request()->attributes->set('pageurl', $pageurl);
            View::share('pageurl', $pageurl);
            $menu = $view->getData()['_menu_data'] ?? null;
            $menu_permission = $view->getData()['_menu_permission'] ?? [];

            if ($menu) {
                $menu_list = get_admin_menu($menu, $menu_permission, $pageurl);
                $view->with('left_menu', $menu_list);
            }
        });
    }
}

