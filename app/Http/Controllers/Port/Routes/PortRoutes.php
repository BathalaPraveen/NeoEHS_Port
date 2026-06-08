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


Route::middleware(['web', 'is_login'])->group(function () {


    /*___________________________________________________________________________________
    |                                                                                    |
    |                            Incident Management                                        |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Incident Master Category
     */

    Route::get('portsecurity/master/list', 'Port\PortSecurityMasterController@index');
    Route::post('portsecurity/master/list', 'Port\PortSecurityMasterController@index');
    Route::get('portsecurity/master/view/{id}', 'Port\PortSecurityMasterController@View');
    Route::post('portsecurity/master/delete', 'Port\PortSecurityMasterController@Delete');
    Route::get('portsecurity/master/export/excel', 'Port\PortSecurityMasterController@ExportExcel');
    Route::get('portsecurity/master/export/pdf', 'Port\PortSecurityMasterController@ExportPdf');
    Route::get('portsecurity/master/add', 'Port\PortSecurityMasterController@Add');
    Route::post('portsecurity/master/add/submit', 'Port\PortSecurityMasterController@Store');



























    Route::get('portsecurity/security_access/list', 'Port\PortSecurityController@index');
    Route::post('portsecurity/security_access/list', 'Port\PortSecurityController@index');
    Route::get('portsecurity/security_access/view/{id}', 'Port\PortSecurityController@View');
    Route::get('portsecurity/security_access/export/excel', 'Port\PortSecurityController@ExportExcel');
    Route::get('portsecurity/security_access/export/pdf', 'Port\PortSecurityController@ExportPdf');




    Route::post('incident/master/category/list', 'Incident\IncidentCategoryController@index');
    Route::get('incident/master/category/add', 'Incident\IncidentCategoryController@Add');
    Route::post('incident/master/category/add/submit', 'Incident\IncidentCategoryController@Store');
    Route::get('incident/master/category/view/{id}', 'Incident\IncidentCategoryController@View');
    Route::get('incident/master/category/edit/{id}', 'Incident\IncidentCategoryController@Edit');
    Route::post('incident/master/category/edit/submit', 'Incident\IncidentCategoryController@Update');
    Route::post('incident/master/category/unique', 'Incident\IncidentCategoryController@Uniquecheck');
    Route::post('incident/master/category/status', 'Incident\IncidentCategoryController@StatusChange');

    Route::get('incident/master/category/import', 'Incident\IncidentCategoryController@Import');
    Route::post('incident/master/category/import/submit', 'Incident\IncidentCategoryController@ImportSubmit');


    /**
     * Incident Master Item
     */

    Route::get('incident/master/item/list', 'Incident\IncidentItemController@index');
    Route::post('incident/master/item/list', 'Incident\IncidentItemController@index');
    Route::get('incident/master/item/add', 'Incident\IncidentItemController@Add');
    Route::post('incident/master/item/add/submit', 'Incident\IncidentItemController@Store');
    Route::get('incident/master/item/view/{id}', 'Incident\IncidentItemController@View');
    Route::get('incident/master/item/edit/{id}', 'Incident\IncidentItemController@Edit');
    Route::post('incident/master/item/edit/submit', 'Incident\IncidentItemController@Update');
    Route::post('incident/master/item/unique', 'Incident\IncidentItemController@Uniquecheck');
    Route::post('incident/master/item/status', 'Incident\IncidentItemController@StatusChange');
    Route::post('incident/master/item/delete', 'Incident\IncidentItemController@Delete');
    Route::get('incident/master/item/import', 'Incident\IncidentItemController@Import');
    Route::post('incident/master/item/import/submit', 'Incident\IncidentItemController@ImportSubmit');
    Route::get('incident/master/item/export/excel', 'Incident\IncidentItemController@ExportExcel');
    Route::get('incident/master/item/export/pdf', 'Incident\IncidentItemController@ExportPdf');
    Route::get('incident/master/item/list/{id}', 'Incident\IncidentItemController@list');

    /**
     * Incident Master Item
     */

    Route::get('incident/master/subitem/list', 'Incident\IncidentSubItemController@index');
    Route::post('incident/master/subitem/list', 'Incident\IncidentSubItemController@index');
    Route::get('incident/master/subitem/add', 'Incident\IncidentSubItemController@Add');
    Route::post('incident/master/subitem/add/submit', 'Incident\IncidentSubItemController@Store');
    Route::get('incident/master/subitem/view/{id}', 'Incident\IncidentSubItemController@View');
    Route::get('incident/master/subitem/edit/{id}', 'Incident\IncidentSubItemController@Edit');
    Route::post('incident/master/subitem/edit/submit', 'Incident\IncidentSubItemController@Update');
    Route::post('incident/master/subitem/unique', 'Incident\IncidentSubItemController@Uniquecheck');
    Route::post('incident/master/subitem/status', 'Incident\IncidentSubItemController@StatusChange');
    Route::post('incident/master/subitem/delete', 'Incident\IncidentSubItemController@Delete');
    Route::get('incident/master/subitem/import', 'Incident\IncidentSubItemController@Import');
    Route::post('incident/master/subitem/import/submit', 'Incident\IncidentSubItemController@ImportSubmit');
    Route::get('incident/master/subitem/export/excel', 'Incident\IncidentSubItemController@ExportExcel');
    Route::get('incident/master/subitem/export/pdf', 'Incident\IncidentSubItemController@ExportPdf');



    /**
     * Incident Initial Notification Item
     */

    Route::get('incident/notification/list', 'Incident\IncidentNotificationController@index');
    Route::post('incident/notification/list', 'Incident\IncidentNotificationController@index');
    Route::get('incident/notification/add', 'Incident\IncidentNotificationController@Add');
    Route::post('incident/notification/add/submit', 'Incident\IncidentNotificationController@Store');
    Route::get('incident/notification/view/{id}', 'Incident\IncidentNotificationController@View');
    Route::get('incident/notification/approvereject/{id}', 'Incident\IncidentNotificationController@aproveReject');
    Route::post('incident/notification/approvereject/submit', 'Incident\IncidentNotificationController@ApproveRejectSubmit');

    Route::get('incident/notification/edit/{id}', 'Incident\IncidentNotificationController@Edit');
    Route::post('incident/notification/edit/submit', 'Incident\IncidentNotificationController@Update');
    Route::post('incident/notification/unique', 'Incident\IncidentNotificationController@Uniquecheck');
    Route::post('incident/notification/status', 'Incident\IncidentNotificationController@StatusChange');
    Route::post('incident/notification/delete', 'Incident\IncidentNotificationController@Delete');
    Route::get('incident/notification/import', 'Incident\IncidentNotificationController@Import');
    Route::post('incident/notification/import/submit', 'Incident\IncidentNotificationController@ImportSubmit');
    Route::get('incident/notification/export/excel', 'Incident\IncidentNotificationController@ExportExcel');
    Route::get('incident/notification/export/pdf', 'Incident\IncidentNotificationController@ExportPdf');
    Route::get('incident/notification/get-open-close', 'Incident\IncidentNotificationController@getIncidentOpenClose');


    /**
     * Incident Initial Notification Item
     */

    Route::get('incident/investigation/list', 'Incident\IncidentInvestigationController@index');
    Route::post('incident/investigation/list', 'Incident\IncidentInvestigationController@index');
    Route::get('incident/investigation/assignuser/{id}', 'Incident\IncidentInvestigationController@AssignUser');
    Route::post('incident/investigation/assignuser/submit', 'Incident\IncidentInvestigationController@AssignUserSubmit');

    Route::get('incident/investigation/accident/{type}/{id}', 'Incident\IncidentInvestigationController@Add');
    Route::get('incident/investigation/nearmiss/{id}', 'Incident\IncidentInvestigationController@AddNearMiss');
    Route::post('incident/investigation/nearmiss/add/submit', 'Incident\IncidentInvestigationController@nearMissSubmit');

    Route::post('incident/investigation/add/submit', 'Incident\IncidentInvestigationController@Store');
    Route::get('incident/investigation/view/{id}', 'Incident\IncidentInvestigationController@View');
    Route::get('incident/investigation/edit/{id}', 'Incident\IncidentInvestigationController@Edit');
    Route::post('incident/investigation/edit/submit', 'Incident\IncidentInvestigationController@Update');
    Route::post('incident/investigation/unique', 'Incident\IncidentInvestigationController@Uniquecheck');
    Route::post('incident/investigation/status', 'Incident\IncidentInvestigationController@StatusChange');
    Route::post('incident/investigation/delete', 'Incident\IncidentInvestigationController@Delete');
    Route::get('incident/investigation/import', 'Incident\IncidentInvestigationController@Import');
    Route::post('incident/investigation/import/submit', 'Incident\IncidentInvestigationController@ImportSubmit');
    Route::get('incident/investigation/export/excel', 'Incident\IncidentInvestigationController@ExportExcel');
    Route::get('incident/investigation/export/pdf', 'Incident\IncidentInvestigationController@ExportPdf');

    Route::get('incident/investigation/approvereject/{id}', 'Incident\IncidentInvestigationController@ApproveReject');
    Route::post('incident/investigation/approvereject/submit', 'Incident\IncidentInvestigationController@ApproveRejectSubmit');


    /**
     * Incident Action Tracking
     */
    Route::get('incident/actiontracking/list', 'Incident\IncidentActionTrackingController@index');
    Route::post('incident/actiontracking/list', 'Incident\IncidentActionTrackingController@index');
    Route::get('incident/actiontracking/update', 'Incident\IncidentActionTrackingController@Add');
    Route::post('incident/actiontracking/update/submit', 'Incident\IncidentActionTrackingController@Store');
    Route::get('incident/actiontracking/view/{id}', 'Incident\IncidentActionTrackingController@View');
    Route::get('incident/actiontracking/approvereject/{id}', 'Incident\IncidentActionTrackingController@aproveReject');
    Route::post('incident/actiontracking/approvereject/submit', 'Incident\IncidentActionTrackingController@ApproveRejectSubmit');



});
