<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('test', 'TestController@index');
Route::get('test/{batch}', 'TestController@index');
Route::get('test/{testvalue}/test/{testvalue1}', 'TestController@index1');
Route::get('cache', function () {
    Artisan::call('optimize:clear');
    return 'Routes cache cleared';
});

Route::get('migrate', function () {
    Artisan::call('migrate');
    return 'Table migrated';
});

Route::get('/seed', function () {
    Artisan::call('db:seed');
    return 'Seeding completed';
});

Route::get('/seed/{className}', function ($className) {
    Artisan::call('db:seed', ['--class' => $className]);
    return 'Seeding completed for ' . $className;
});


Route::get('queuehigh', 'Cron\CronController@queueHigh');
Route::get('queuedefault', 'Cron\CronController@queueDefault');
Route::get('queueemail', 'Cron\CronController@queueEmail');
Route::get('queueempimport', 'Cron\CronController@queueEmpImport');
Route::get('queueconimport', 'Cron\CronController@queueConImport');


Route::middleware(['UserLog'])->group(function () {

    Route::get('/', function () {
        return redirect('login');
    });

    Route::get('Account_Activate/{token}', 'Admin\LoginController@Account_Activate');
    Route::post('SubmitAccountActivate', 'Admin\LoginController@SubmitAccountActivate');

    Route::get('login', 'Auth\LoginController@login')->name('login');
    Route::post('logintry', 'Admin\LoginController@authenticate');
    Route::post('logout', 'Admin\LoginController@logout');
    Route::get('contractor/registration', 'Admin\LoginController@contractorRegistration');
    Route::post('contractor/registration/submit', 'Admin\LoginController@contractorRegistrationSubmit');

    Route::get('password/forgot', 'Admin\LoginController@forgotPassword');
    Route::Post('password/forgot/submit', 'Admin\LoginController@sendOTP')->name('resetpasswordSend');
    Route::get('password/otp', 'Admin\LoginController@passwordOTP');
    Route::Post('password/otp/submit', 'Admin\LoginController@passwordOTPSubmit');
    Route::get('password/finalreset/form', 'Admin\LoginController@passwordReset');
    Route::Post('password/finalreset/submit', 'Admin\LoginController@passwordResetSubmit');

    Route::get('auth/microsoft', 'Admin\LoginController@redirectToMicrosoft');
    Route::get('auth/microsoft/callback', 'Admin\LoginController@handleMicrosoftCallback');

    Route::post('contractor/company/roc_unique', 'Master\ContractorCompanyController@ROCUniquecheck');


    Route::middleware(['is_login'])->group(function () {
        //->middleware(['checkPermission:dashboard,view'])

        Route::get('home', 'Admin\AdminController@home');
        Route::get('nopermission', 'Admin\AdminController@nopermission');
        Route::get('announcement', 'Admin\AdminController@announcement');
        Route::get('hsebulletin', 'Admin\AdminController@hsebulletin');
        Route::get('settings', 'Admin\AdminController@settings');

        Route::get('dashboard', 'Admin\AdminController@index');

        Route::get('profile', 'Admin\AdminController@profileView');
        Route::post('profile/image/update', 'Admin\AdminController@profileUpdate');

        Route::post('profile/password/update', 'Admin\AdminController@changeProfilePassword');


        /*___________________________________________________________________________________
        |                                                                                    |
        |                            Master Management                                       |
        |                                                                                    |
        |___________________________________________________________________________________*/


        Route::get('location/list/{companyId}', 'Master\LocationController@list');
        Route::get('specificlocation/list/{locationId}', 'Master\SpecificLocationController@list');
        Route::get('division/list/{companyId}', 'Master\DivisionController@list');
        Route::get('department/list/{divisionId}', 'Master\DepartmentController@list');
        Route::get('employee/list/{departmentId}', 'Master\EmployeeController@list');
        Route::post('employee/get/{userrole}', 'Master\EmployeeController@getUser');
        Route::get('employee/change_details', 'Master\EmployeeController@change_details');
        Route::post('employee/change_details/submit', 'Master\EmployeeController@change_details_submit');
        Route::get('employee/getEmpDetails/{id}', 'Master\EmployeeController@getEmpDetails');
        Route::get('specificlocation/getAreaOwner/{id}', 'Master\SpecificLocationController@getAreaOwner');
        Route::get('work_type/getSupervisingAuthority/{id}', 'Master\WorkTypeMasterController@getSupervisingAuthority');



        Route::middleware(['is_admin'])->group(function () {
            /**
             * Location Master
             */

            Route::get('location/list', 'Master\LocationController@index');
            Route::post('location/list', 'Master\LocationController@index');
            Route::get('location/add', 'Master\LocationController@Add');
            Route::post('location/add/submit', 'Master\LocationController@Store');
            Route::get('location/view/{id}', 'Master\LocationController@View');
            Route::get('location/edit/{id}', 'Master\LocationController@Edit');
            Route::post('location/edit/submit', 'Master\LocationController@Update');
            Route::post('location/unique', 'Master\LocationController@Uniquecheck');
            Route::post('location/status', 'Master\LocationController@StatusChange');
            Route::post('location/delete', 'Master\LocationController@Delete');
            Route::get('location/import', 'Master\LocationController@Import');
            Route::post('location/import/submit', 'Master\LocationController@ImportSubmit');
            Route::get('location/export/excel', 'Master\LocationController@ExportExcel');
            Route::get('location/export/pdf', 'Master\LocationController@ExportPdf');

            Route::get('work_type/list', 'Master\WorkTypeMasterController@index');
            Route::post('work_type/list', 'Master\WorkTypeMasterController@index');
            Route::get('work_type/add', 'Master\WorkTypeMasterController@Add');
            Route::post('work_type/add/submit', 'Master\WorkTypeMasterController@Store');
            Route::get('work_type/view/{id}', 'Master\WorkTypeMasterController@View');
            Route::get('work_type/edit/{id}', 'Master\WorkTypeMasterController@Edit');
            Route::post('work_type/edit/submit', 'Master\WorkTypeMasterController@Update');
            Route::post('work_type/unique', 'Master\WorkTypeMasterController@Uniquecheck');
            Route::post('work_type/status', 'Master\WorkTypeMasterController@StatusChange');
            Route::post('work_type/delete', 'Master\WorkTypeMasterController@Delete');
            Route::get('work_type/import', 'Master\WorkTypeMasterController@Import');
            Route::post('work_type/import/submit', 'Master\WorkTypeMasterController@ImportSubmit');
            Route::get('work_type/export/excel', 'Master\WorkTypeMasterController@ExportExcel');
            Route::get('work_type/export/pdf', 'Master\WorkTypeMasterController@ExportPdf');

            Route::get('activity_type/list', 'Master\CompanyActivityController@index');
            Route::post('activity_type/list', 'Master\CompanyActivityController@index');
            Route::get('activity_type/add', 'Master\CompanyActivityController@Add');
            Route::post('activity_type/add/submit', 'Master\CompanyActivityController@Store');
            Route::get('activity_type/view/{id}', 'Master\CompanyActivityController@View');
            Route::get('activity_type/edit/{id}', 'Master\CompanyActivityController@Edit');
            Route::post('activity_type/edit/submit', 'Master\CompanyActivityController@Update');
            Route::post('activity_type/unique', 'Master\CompanyActivityController@Uniquecheck');
            Route::post('activity_type/status', 'Master\CompanyActivityController@StatusChange');
            Route::post('activity_type/delete', 'Master\CompanyActivityController@Delete');
            Route::get('activity_type/import', 'Master\CompanyActivityController@Import');
            Route::post('activity_type/import/submit', 'Master\CompanyActivityController@ImportSubmit');
            Route::get('activity_type/export/excel', 'Master\CompanyActivityController@ExportExcel');
            Route::get('activity_type/export/pdf', 'Master\CompanyActivityController@ExportPdf');



            /**
             * Specific Location Master
             */

            Route::get('specificlocation/list', 'Master\SpecificLocationController@index');
            Route::post('specificlocation/list', 'Master\SpecificLocationController@index');
            Route::get('specificlocation/add', 'Master\SpecificLocationController@Add');
            Route::post('specificlocation/add/submit', 'Master\SpecificLocationController@Store');
            Route::get('specificlocation/view/{id}', 'Master\SpecificLocationController@View');
            Route::get('specificlocation/edit/{id}', 'Master\SpecificLocationController@Edit');
            Route::post('specificlocation/edit/submit', 'Master\SpecificLocationController@Update');
            Route::post('specificlocation/unique', 'Master\SpecificLocationController@Uniquecheck');
            Route::post('specificlocation/status', 'Master\SpecificLocationController@StatusChange');
            Route::post('specificlocation/delete', 'Master\SpecificLocationController@Delete');
            Route::get('specificlocation/import', 'Master\SpecificLocationController@Import');
            Route::post('specificlocation/import/submit', 'Master\SpecificLocationController@ImportSubmit');
            Route::get('specificlocation/export/excel', 'Master\SpecificLocationController@ExportExcel');
            Route::get('specificlocation/export/pdf', 'Master\SpecificLocationController@ExportPdf');



            /**
             * Company Master
             */

            Route::get('company/list', 'Master\CompanyController@index');
            Route::post('company/list', 'Master\CompanyController@index');
            Route::get('company/add', 'Master\CompanyController@Add');
            Route::post('company/add/submit', 'Master\CompanyController@Store');
            Route::get('company/view/{id}', 'Master\CompanyController@View');
            Route::get('company/edit/{id}', 'Master\CompanyController@Edit');
            Route::post('company/edit/submit', 'Master\CompanyController@Update');
            Route::post('company/unique', 'Master\CompanyController@Uniquecheck');
            Route::post('company/status', 'Master\CompanyController@StatusChange');
            Route::post('company/delete', 'Master\CompanyController@Delete');
            Route::get('company/import', 'Master\CompanyController@Import');
            Route::post('company/import/submit', 'Master\CompanyController@ImportSubmit');
            Route::get('company/export/excel', 'Master\CompanyController@ExportExcel');
            Route::get('company/export/pdf', 'Master\CompanyController@ExportPdf');
            Route::post('company/roc_unique', 'Master\CompanyController@ROCUniquecheck');


            /**
             * Division Master
             */

            Route::get('division/list', 'Master\DivisionController@index');
            Route::post('division/list', 'Master\DivisionController@index');
            Route::get('division/add', 'Master\DivisionController@Add');
            Route::post('division/add/submit', 'Master\DivisionController@Store');
            Route::get('division/view/{id}', 'Master\DivisionController@View');
            Route::get('division/edit/{id}', 'Master\DivisionController@Edit');
            Route::post('division/edit/submit', 'Master\DivisionController@Update');
            Route::post('division/unique', 'Master\DivisionController@Uniquecheck');
            Route::post('division/status', 'Master\DivisionController@StatusChange');
            Route::post('division/delete', 'Master\DivisionController@Delete');
            Route::get('division/import', 'Master\DivisionController@Import');
            Route::post('division/import/submit', 'Master\DivisionController@ImportSubmit');
            Route::get('division/export/excel', 'Master\DivisionController@ExportExcel');
            Route::get('division/export/pdf', 'Master\DivisionController@ExportPdf');




            /**
             * Department Master
             */

            Route::get('department/list', 'Master\DepartmentController@index');
            Route::post('department/list', 'Master\DepartmentController@index');
            Route::get('department/add', 'Master\DepartmentController@Add');
            Route::post('department/add/submit', 'Master\DepartmentController@Store');
            Route::get('department/view/{id}', 'Master\DepartmentController@View');
            Route::get('department/edit/{id}', 'Master\DepartmentController@Edit');
            Route::post('department/edit/submit', 'Master\DepartmentController@Update');
            Route::post('department/unique', 'Master\DepartmentController@Uniquecheck');
            Route::post('department/status', 'Master\DepartmentController@StatusChange');
            Route::post('department/delete', 'Master\DepartmentController@Delete');
            Route::get('department/import', 'Master\DepartmentController@Import');
            Route::post('department/import/submit', 'Master\DepartmentController@ImportSubmit');
            Route::get('department/export/excel', 'Master\DepartmentController@ExportExcel');
            Route::get('department/export/pdf', 'Master\DepartmentController@ExportPdf');



            /**
             * Designation Master
             */

            Route::get('designation/list', 'Master\DesignationController@index');
            Route::post('designation/list', 'Master\DesignationController@index');
            Route::get('designation/add', 'Master\DesignationController@Add');
            Route::post('designation/add/submit', 'Master\DesignationController@Store');
            Route::get('designation/view/{id}', 'Master\DesignationController@View');
            Route::get('designation/edit/{id}', 'Master\DesignationController@Edit');
            Route::post('designation/edit/submit', 'Master\DesignationController@Update');
            Route::post('designation/unique', 'Master\DesignationController@Uniquecheck');
            Route::post('designation/status', 'Master\DesignationController@StatusChange');
            Route::post('designation/delete', 'Master\DesignationController@Delete');
            Route::get('designation/import', 'Master\DesignationController@Import');
            Route::post('designation/import/submit', 'Master\DesignationController@ImportSubmit');
            Route::get('designation/export/excel', 'Master\DesignationController@ExportExcel');
            Route::get('designation/export/pdf', 'Master\DesignationController@ExportPdf');


            /**
             * User Role Master
             */

            Route::get('user/role/list', 'Master\UserRoleController@index');
            Route::post('user/role/list', 'Master\UserRoleController@index');
            Route::get('user/role/add', 'Master\UserRoleController@Add');
            Route::post('user/role/add/submit', 'Master\UserRoleController@Store');
            Route::get('user/role/view/{id}', 'Master\UserRoleController@View');
            Route::get('user/role/edit/{id}', 'Master\UserRoleController@Edit');
            Route::post('user/role/edit/submit', 'Master\UserRoleController@Update');
            Route::post('user/role/unique', 'Master\UserRoleController@Uniquecheck');
            Route::post('user/role/status', 'Master\UserRoleController@StatusChange');
            Route::post('user/role/delete', 'Master\UserRoleController@Delete');
            Route::get('user/role/import', 'Master\UserRoleController@Import');
            Route::post('user/role/import/submit', 'Master\UserRoleController@ImportSubmit');
            Route::get('user/role/export/excel', 'Master\UserRoleController@ExportExcel');
            Route::get('user/role/export/pdf', 'Master\UserRoleController@ExportPdf');


            /**
             * Employee Master
             */

            Route::get('employee/list', 'Master\EmployeeController@index');
            Route::post('employee/list', 'Master\EmployeeController@index');
            Route::get('employee/add', 'Master\EmployeeController@Add');
            Route::post('employee/add/submit', 'Master\EmployeeController@Store');
            Route::get('employee/view/{id}', 'Master\EmployeeController@View');
            Route::get('employee/edit/{id}', 'Master\EmployeeController@Edit');
            Route::post('employee/edit/submit', 'Master\EmployeeController@Update');
            Route::get('employee/passwordchange/{id}', 'Master\EmployeeController@PasswordUpdate');
            Route::post('employee/passwordchange/submit', 'Master\EmployeeController@PasswordUpdateSubmit');
            Route::post('employee/unique', 'Master\EmployeeController@Uniquecheck');
            Route::post('employee/status', 'Master\EmployeeController@StatusChange');
            Route::post('employee/delete', 'Master\EmployeeController@Delete');
            Route::get('employee/import', 'Master\EmployeeController@Import');
            Route::post('employee/import/submit', 'Master\EmployeeController@ImportSubmit');
            Route::get('employee/export/excel', 'Master\EmployeeController@ExportExcel');
            Route::get('employee/export/pdf', 'Master\EmployeeController@ExportPdf');



            /**
             * Contractor Company Master
             */

            Route::get('contractor/company/list', 'Master\ContractorCompanyController@index');
            Route::post('contractor/company/list', 'Master\ContractorCompanyController@index');
            Route::get('contractor/company/add', 'Master\ContractorCompanyController@Add');
            Route::post('contractor/company/add/submit', 'Master\ContractorCompanyController@Store');
            Route::get('contractor/company/view/{id}', 'Master\ContractorCompanyController@View');
            Route::get('contractor/company/approval/{id}', 'Master\ContractorCompanyController@approval');
            Route::get('contractor/company/edit/{id}', 'Master\ContractorCompanyController@Edit');
            Route::post('contractor/company/edit/submit', 'Master\ContractorCompanyController@Update');
            Route::post('contractor/company/unique', 'Master\ContractorCompanyController@Uniquecheck');
            Route::post('contractor/company/status', 'Master\ContractorCompanyController@StatusChange');
            Route::post('contractor/company/delete', 'Master\ContractorCompanyController@Delete');
            Route::get('contractor/company/import', 'Master\ContractorCompanyController@Import');
            Route::post('contractor/company/import/submit', 'Master\ContractorCompanyController@ImportSubmit');
            Route::get('contractor/company/export/excel', 'Master\ContractorCompanyController@ExportExcel');
            Route::get('contractor/company/export/pdf', 'Master\ContractorCompanyController@ExportPdf');

            Route::post('contractor/company/hse_approval/submit', 'Master\ContractorCompanyController@hse_approval');
            Route::post('contractor/company/it_approval/submit', 'Master\ContractorCompanyController@it_approval');

            /**
             * Contractor Master
             */

            Route::get('contractor/list', 'Master\ContractorController@index');
            Route::post('contractor/list', 'Master\ContractorController@index');
            Route::get('contractor/add', 'Master\ContractorController@Add');
            Route::post('contractor/add/submit', 'Master\ContractorController@Store');
            Route::get('contractor/view/{id}', 'Master\ContractorController@View');
            Route::get('contractor/edit/{id}', 'Master\ContractorController@Edit');
            Route::post('contractor/edit/submit', 'Master\ContractorController@Update');
            Route::post('contractor/unique', 'Master\ContractorController@Uniquecheck');
            Route::post('contractor/status', 'Master\ContractorController@StatusChange');
            Route::post('contractor/delete', 'Master\ContractorController@Delete');
            Route::get('contractor/import', 'Master\ContractorController@Import');
            Route::post('contractor/import/submit', 'Master\ContractorController@ImportSubmit');
            Route::get('contractor/export/excel', 'Master\ContractorController@ExportExcel');
            Route::get('contractor/export/pdf', 'Master\ContractorController@ExportPdf');
            Route::get('contractor/passwordchange/{id}', 'Master\ContractorController@PasswordUpdate');
            Route::post('contractor/passwordchange/submit', 'Master\ContractorController@PasswordUpdateSubmit');


            /**
             * File Upload Error Log
             */
            Route::get('userlog/list', 'Master\UserLogController@index');
            Route::post('userlog/list', 'Master\UserLogController@index');
            Route::get('userlog/export/excel', 'Master\UserLogController@ExportExcel');

            /**
             * File Upload Error Log
             */
            Route::get('user/permission/list', 'Master\UserPermissionController@index');
            Route::post('user/permission/get', 'Master\UserPermissionController@getUserPermission');
            Route::post('user/permission/update', 'Master\UserPermissionController@updateUserPermission');

            /**
             * File Upload Error Log
             */
            Route::get('uploadlog/list', 'Master\UploadLogController@index');
            Route::post('uploadlog/list', 'Master\UploadLogController@index');
            Route::get('uploadlog/list/{logid}', 'Master\UploadLogController@view');
            Route::post('uploadlog/list/{logid}', 'Master\UploadLogController@view');
            Route::get('uploadlog/download/{logid}', 'Master\UploadLogController@download');
            Route::get('uploadlog/export/excel/{logid}', 'Master\UploadLogController@ExportExcel');

            /**
             * Dashboard Slider
             */
            Route::get('settings/slider', 'Master\SliderController@index');
            Route::post('settings/slider/store', 'Master\SliderController@store');
            Route::post('settings/slider/delete', 'Master\SliderController@delete');


            /**
             * Dashboard Announcement
             */
            Route::get('settings/announcement/list', 'Master\AnnouncementController@index');
            Route::post('settings/announcement/list', 'Master\AnnouncementController@index');
            Route::get('settings/announcement/add', 'Master\AnnouncementController@add');
            Route::post('settings/announcement/add/submit', 'Master\AnnouncementController@store');
            Route::get('settings/announcement/edit/{id}', 'Master\AnnouncementController@edit');
            Route::post('settings/announcement/edit/submit', 'Master\AnnouncementController@update');
            Route::post('settings/announcement/delete', 'Master\AnnouncementController@delete');
            Route::get('settings/announcement/export/excel', 'Master\AnnouncementController@ExportExcel');
            Route::get('settings/announcement/export/pdf', 'Master\AnnouncementController@ExportPdf');
        });

        /**
         * Notification
         */

        Route::get('notification/list', 'Admin\NotificationController@notificationList');
        Route::post('notification/list', 'Admin\NotificationController@notificationList');
        Route::get('notification/read/{id}', 'Admin\NotificationController@notificationRead');
        Route::get('notification/readall', 'Admin\NotificationController@notificationAllRead');
        Route::get('notification/view/{id}', 'Admin\NotificationController@notificationView');
    });




    Auth::routes();
});
