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


Route::middleware(['is_login'])->group(function () {


    /*___________________________________________________________________________________
    |                                                                                    |
    |                            PTW Management                                       |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * PTW Activity Master
     */

    Route::get('ptw/master/activity/list', 'PTW\PTWActivityController@index');
    Route::post('ptw/master/activity/list', 'PTW\PTWActivityController@index');
    Route::get('ptw/master/activity/export/excel', 'PTW\PTWActivityController@ExportExcel');
    Route::get('ptw/master/activity/export/pdf', 'PTW\PTWActivityController@ExportPdf');

    /**
     * PTW Category Master
     */

    Route::get('ptw/master/category/list', 'PTW\PTWCategoryController@index');
    Route::post('ptw/master/category/list', 'PTW\PTWCategoryController@index');
    Route::get('ptw/master/category/add', 'PTW\PTWCategoryController@Add');
    Route::post('ptw/master/category/add/submit', 'PTW\PTWCategoryController@Store');
    Route::get('ptw/master/category/view/{id}', 'PTW\PTWCategoryController@View');
    Route::get('ptw/master/category/edit/{id}', 'PTW\PTWCategoryController@Edit');
    Route::post('ptw/master/category/edit/submit', 'PTW\PTWCategoryController@Update');
    Route::post('ptw/master/category/unique', 'PTW\PTWCategoryController@Uniquecheck');
    Route::post('ptw/master/category/status', 'PTW\PTWCategoryController@StatusChange');
    Route::post('ptw/master/category/delete', 'PTW\PTWCategoryController@Delete');
    Route::get('ptw/master/category/import', 'PTW\PTWCategoryController@Import');
    Route::post('ptw/master/category/import/submit', 'PTW\PTWCategoryController@ImportSubmit');
    Route::get('ptw/master/category/export/excel', 'PTW\PTWCategoryController@ExportExcel');
    Route::get('ptw/master/category/export/pdf', 'PTW\PTWCategoryController@ExportPdf');
    Route::get('ptw/master/category/list/{activityid}', 'PTW\PTWCategoryController@list');

    /**
     * PTW Item Master
     */

    Route::get('ptw/master/item/list', 'PTW\PTWItemController@index');
    Route::post('ptw/master/item/list', 'PTW\PTWItemController@index');
    Route::get('ptw/master/item/add', 'PTW\PTWItemController@Add');
    Route::post('ptw/master/item/add/submit', 'PTW\PTWItemController@Store');
    Route::get('ptw/master/item/view/{id}', 'PTW\PTWItemController@View');
    Route::get('ptw/master/item/edit/{id}', 'PTW\PTWItemController@Edit');
    Route::post('ptw/master/item/edit/submit', 'PTW\PTWItemController@Update');
    Route::post('ptw/master/item/unique', 'PTW\PTWItemController@Uniquecheck');
    Route::post('ptw/master/item/status', 'PTW\PTWItemController@StatusChange');
    Route::post('ptw/master/item/delete', 'PTW\PTWItemController@Delete');
    Route::get('ptw/master/item/import', 'PTW\PTWItemController@Import');
    Route::post('ptw/master/item/import/submit', 'PTW\PTWItemController@ImportSubmit');
    Route::get('ptw/master/item/export/excel', 'PTW\PTWItemController@ExportExcel');
    Route::get('ptw/master/item/export/pdf', 'PTW\PTWItemController@ExportPdf');



    /**
     * General PTW
     */

    Route::get('ptw/general/list', 'PTW\GeneralController@index');
    Route::post('ptw/general/list', 'PTW\GeneralController@index');
    Route::get('ptw/general/add', 'PTW\GeneralController@Add');
    Route::post('ptw/general/add/submit', 'PTW\GeneralController@Store');
    Route::get('ptw/general/view/{id}', 'PTW\GeneralController@View');
    Route::get('ptw/general/edit/{id}', 'PTW\GeneralController@Edit');
    Route::post('ptw/general/edit/submit', 'PTW\GeneralController@Update');
    Route::post('ptw/general/unique', 'PTW\GeneralController@Uniquecheck');
    Route::post('ptw/general/status', 'PTW\GeneralController@StatusChange');
    Route::post('ptw/general/delete', 'PTW\GeneralController@Delete');
    Route::get('ptw/general/import', 'PTW\GeneralController@Import');
    Route::post('ptw/general/import/submit', 'PTW\GeneralController@ImportSubmit');
    Route::get('ptw/general/export/excel', 'PTW\GeneralController@ExportExcel');
    Route::get('ptw/general/export/pdf', 'PTW\GeneralController@ExportPdf');
    Route::get('ptw/{pdftype}/view/pdf/{id}', 'PTW\GeneralController@ExportViewPdf');


    Route::get('ptw/general/view/{id}/{approvetype}', 'PTW\GeneralController@View');
    Route::post('ptw/general/aoapprovereject/submit', 'PTW\GeneralController@AOApproveRejectSubmit');
    Route::post('ptw/general/ghseapprovereject/submit', 'PTW\GeneralController@GHSEApproveRejectSubmit');
    Route::post('ptw/general/saapprovereject/submit', 'PTW\GeneralController@SAApproveRejectSubmit');
    Route::post('ptw/general/ptwclose/submit', 'PTW\GeneralController@PTWCloseSubmit');
    Route::post('ptw/general/AOreassign/submit', 'PTW\GeneralController@AOReassignSubmit');
    Route::post('ptw/general/SAreassign/submit', 'PTW\GeneralController@SAReassignSubmit');

    Route::post('ptw/general/getsubcategory', 'PTW\GeneralController@Getsubcategory');
    Route::post('ptw/general/hold/submit', 'PTW\GeneralController@holdSubmit');
    Route::post('ptw/general/un_hold/submit', 'PTW\GeneralController@unholdSubmit');

    Route::get('ptw/general/addPTW/{id}', 'PTW\GeneralController@addPTW');
    Route::post('ptw/general/addPTW/submit', 'PTW\GeneralController@addPTWSubmit');



    /**
     * Gas Test PTW
     */

    Route::get('ptw/gastest/list', 'PTW\GasPTWController@index');
    Route::post('ptw/gastest/list', 'PTW\GasPTWController@index');
    Route::get('ptw/gastest/add', 'PTW\GasPTWController@Add');
    Route::get('ptw/gastest/add/{ptwId}', 'PTW\GasPTWController@Add');
    Route::post('ptw/gastest/add/submit', 'PTW\GasPTWController@Store');
    Route::get('ptw/gastest/view/{id}', 'PTW\GasPTWController@View');
    Route::get('ptw/gastest/approvereject/{id}', 'PTW\GasPTWController@ApproveReject');
    Route::post('ptw/gastest/approvereject/submit', 'PTW\GasPTWController@ApproveRejectSubmit');
    Route::get('ptw/gastest/edit/{id}', 'PTW\GasPTWController@Edit');
    Route::post('ptw/gastest/edit/submit', 'PTW\GasPTWController@Update');
    Route::post('ptw/gastest/unique', 'PTW\GasPTWController@Uniquecheck');
    Route::post('ptw/gastest/status', 'PTW\GasPTWController@StatusChange');
    Route::post('ptw/gastest/delete', 'PTW\GasPTWController@Delete');
    Route::get('ptw/gastest/import', 'PTW\GasPTWController@Import');
    Route::post('ptw/gastest/import/submit', 'PTW\GasPTWController@ImportSubmit');
    Route::get('ptw/gastest/export/excel', 'PTW\GasPTWController@ExportExcel');
    Route::get('ptw/gastest/export/pdf', 'PTW\GasPTWController@ExportPdf');
    Route::get('ptw/gastest1/view/pdf/{id}', 'PTW\GasPTWController@ExportViewPdf');


    /**
     * Isolation Certifiacate PTW
     */

    Route::get('ptw/isolation/list', 'PTW\IsolationPTWController@index');
    Route::post('ptw/isolation/list', 'PTW\IsolationPTWController@index');
    Route::get('ptw/isolation/add', 'PTW\IsolationPTWController@Add');
    Route::get('ptw/isolation/add/{ptwId}', 'PTW\IsolationPTWController@Add');
    Route::post('ptw/isolation/add/submit', 'PTW\IsolationPTWController@Store');
    Route::get('ptw/isolation/view/{id}', 'PTW\IsolationPTWController@View');
    Route::get('ptw/isolation/approvereject/{id}', 'PTW\IsolationPTWController@ApproveReject');
    Route::post('ptw/isolation/approvereject/submit', 'PTW\IsolationPTWController@ApproveRejectSubmit');
    Route::get('ptw/isolation/edit/{id}', 'PTW\IsolationPTWController@Edit');
    Route::post('ptw/isolation/edit/submit', 'PTW\IsolationPTWController@Update');
    Route::post('ptw/isolation/unique', 'PTW\IsolationPTWController@Uniquecheck');
    Route::post('ptw/isolation/status', 'PTW\IsolationPTWController@StatusChange');
    Route::post('ptw/isolation/delete', 'PTW\IsolationPTWController@Delete');
    Route::get('ptw/isolation/import', 'PTW\IsolationPTWController@Import');
    Route::post('ptw/isolation/import/submit', 'PTW\IsolationPTWController@ImportSubmit');
    Route::get('ptw/isolation/export/excel', 'PTW\IsolationPTWController@ExportExcel');
    Route::get('ptw/isolation/export/pdf', 'PTW\IsolationPTWController@ExportPdf');
    Route::get('ptw/isolation1/view/pdf/{id}', 'PTW\IsolationPTWController@ExportViewPdf');

    /**
     * Surface Penetration Certificate PTW
     */

    Route::get('ptw/surfacepenetration/list', 'PTW\SurfacePTWController@index');
    Route::post('ptw/surfacepenetration/list', 'PTW\SurfacePTWController@index');
    Route::get('ptw/surfacepenetration/add', 'PTW\SurfacePTWController@Add');
    Route::get('ptw/surfacepenetration/add/{ptwId}', 'PTW\SurfacePTWController@Add');
    Route::post('ptw/surfacepenetration/add/submit', 'PTW\SurfacePTWController@Store');
    Route::get('ptw/surfacepenetration/view/{id}', 'PTW\SurfacePTWController@View');
    Route::get('ptw/surfacepenetration/approvereject/{id}', 'PTW\SurfacePTWController@ApproveReject');
    Route::post('ptw/surfacepenetration/approvereject/submit', 'PTW\SurfacePTWController@ApproveRejectSubmit');
    Route::get('ptw/surfacepenetration/edit/{id}', 'PTW\SurfacePTWController@Edit');
    Route::post('ptw/surfacepenetration/edit/submit', 'PTW\SurfacePTWController@Update');
    Route::post('ptw/surfacepenetration/unique', 'PTW\SurfacePTWController@Uniquecheck');
    Route::post('ptw/surfacepenetration/status', 'PTW\SurfacePTWController@StatusChange');
    Route::post('ptw/surfacepenetration/delete', 'PTW\SurfacePTWController@Delete');
    Route::get('ptw/surfacepenetration/import', 'PTW\SurfacePTWController@Import');
    Route::post('ptw/surfacepenetration/import/submit', 'PTW\SurfacePTWController@ImportSubmit');
    Route::get('ptw/surfacepenetration/export/excel', 'PTW\SurfacePTWController@ExportExcel');
    Route::get('ptw/surfacepenetration/export/pdf', 'PTW\SurfacePTWController@ExportPdf');
    Route::get('ptw/surfacepenetration1/view/pdf/{id}', 'PTW\SurfacePTWController@ExportViewPdf');


    /**
     * Hotwork Certificate PTW
     */

    Route::get('ptw/hotwork/list', 'PTW\HotWorkPTWController@index');
    Route::post('ptw/hotwork/list', 'PTW\HotWorkPTWController@index');
    Route::get('ptw/hotwork/add', 'PTW\HotWorkPTWController@Add');
    Route::get('ptw/hotwork/add/{ptwId}', 'PTW\HotWorkPTWController@Add');
    Route::post('ptw/hotwork/add/submit', 'PTW\HotWorkPTWController@Store');
    Route::get('ptw/hotwork/view/{id}', 'PTW\HotWorkPTWController@View');
    Route::get('ptw/hotwork/approvereject/{id}', 'PTW\HotWorkPTWController@ApproveReject');
    Route::post('ptw/hotwork/approvereject/submit', 'PTW\HotWorkPTWController@ApproveRejectSubmit');
    Route::get('ptw/hotwork/edit/{id}', 'PTW\HotWorkPTWController@Edit');
    Route::post('ptw/hotwork/edit/submit', 'PTW\HotWorkPTWController@Update');
    Route::post('ptw/hotwork/unique', 'PTW\HotWorkPTWController@Uniquecheck');
    Route::post('ptw/hotwork/status', 'PTW\HotWorkPTWController@StatusChange');
    Route::post('ptw/hotwork/delete', 'PTW\HotWorkPTWController@Delete');
    Route::get('ptw/hotwork/import', 'PTW\HotWorkPTWController@Import');
    Route::post('ptw/hotwork/import/submit', 'PTW\HotWorkPTWController@ImportSubmit');
    Route::get('ptw/hotwork/export/excel', 'PTW\HotWorkPTWController@ExportExcel');
    Route::get('ptw/hotwork/export/pdf', 'PTW\HotWorkPTWController@ExportPdf');
    Route::get('ptw/hotwork1/view/pdf/{id}', 'PTW\HotWorkPTWController@ExportViewPdf');


    /**
     * Work Traffic Management Certificate PTW
     */

    Route::get('ptw/worktraffic/list', 'PTW\TraficPTWController@index');
    Route::post('ptw/worktraffic/list', 'PTW\TraficPTWController@index');
    Route::get('ptw/worktraffic/add', 'PTW\TraficPTWController@Add');
    Route::get('ptw/worktraffic/add/{ptwId}', 'PTW\TraficPTWController@Add');
    Route::post('ptw/worktraffic/add/submit', 'PTW\TraficPTWController@Store');
    Route::get('ptw/worktraffic/view/{id}', 'PTW\TraficPTWController@View');
    Route::get('ptw/worktraffic/approvereject/{id}', 'PTW\TraficPTWController@ApproveReject');
    Route::post('ptw/worktraffic/approvereject/submit', 'PTW\TraficPTWController@ApproveRejectSubmit');
    Route::get('ptw/worktraffic/edit/{id}', 'PTW\TraficPTWController@Edit');
    Route::post('ptw/worktraffic/edit/submit', 'PTW\TraficPTWController@Update');
    Route::post('ptw/worktraffic/unique', 'PTW\TraficPTWController@Uniquecheck');
    Route::post('ptw/worktraffic/status', 'PTW\TraficPTWController@StatusChange');
    Route::post('ptw/worktraffic/delete', 'PTW\TraficPTWController@Delete');
    Route::get('ptw/worktraffic/import', 'PTW\TraficPTWController@Import');
    Route::post('ptw/worktraffic/import/submit', 'PTW\TraficPTWController@ImportSubmit');
    Route::get('ptw/worktraffic/export/excel', 'PTW\TraficPTWController@ExportExcel');
    Route::get('ptw/worktraffic/export/pdf', 'PTW\TraficPTWController@ExportPdf');
    Route::get('ptw/worktraffic1/view/pdf/{id}', 'PTW\TraficPTWController@ExportViewPdf');


    /**
     * Lifting Plan PTW
     */

    Route::get('ptw/lifting/list', 'PTW\LiftingPTWController@index');
    Route::post('ptw/lifting/list', 'PTW\LiftingPTWController@index');
    Route::get('ptw/lifting/add', 'PTW\LiftingPTWController@Add');
    Route::get('ptw/lifting/add/{ptwId}', 'PTW\LiftingPTWController@Add');
    Route::post('ptw/lifting/add/submit', 'PTW\LiftingPTWController@Store');
    Route::get('ptw/lifting/view/{id}', 'PTW\LiftingPTWController@View');
    Route::get('ptw/lifting/approvereject/{id}', 'PTW\LiftingPTWController@ApproveReject');
    Route::post('ptw/lifting/approvereject/submit', 'PTW\LiftingPTWController@ApproveRejectSubmit');
    Route::get('ptw/lifting/edit/{id}', 'PTW\LiftingPTWController@Edit');
    Route::post('ptw/lifting/edit/submit', 'PTW\LiftingPTWController@Update');
    Route::post('ptw/lifting/unique', 'PTW\LiftingPTWController@Uniquecheck');
    Route::post('ptw/lifting/status', 'PTW\LiftingPTWController@StatusChange');
    Route::post('ptw/lifting/delete', 'PTW\LiftingPTWController@Delete');
    Route::get('ptw/lifting/import', 'PTW\LiftingPTWController@Import');
    Route::post('ptw/lifting/import/submit', 'PTW\LiftingPTWController@ImportSubmit');
    Route::get('ptw/lifting/export/excel', 'PTW\LiftingPTWController@ExportExcel');
    Route::get('ptw/lifting/export/pdf', 'PTW\LiftingPTWController@ExportPdf');
    Route::get('ptw/lifting1/view/pdf/{id}', 'PTW\LiftingPTWController@ExportViewPdf');


    /**
     * Diving Certificate PTW
     */

    Route::get('ptw/diving/list', 'PTW\DivingPTWController@index');
    Route::post('ptw/diving/list', 'PTW\DivingPTWController@index');
    Route::get('ptw/diving/add', 'PTW\DivingPTWController@Add');
    Route::get('ptw/diving/add', 'PTW\DivingPTWController@Add');
    Route::get('ptw/diving/add/{ptwId}', 'PTW\DivingPTWController@Add');
    Route::post('ptw/diving/add/submit', 'PTW\DivingPTWController@Store');
    Route::get('ptw/diving/view/{id}', 'PTW\DivingPTWController@View');
    Route::get('ptw/diving/approvereject/{id}', 'PTW\DivingPTWController@ApproveReject');
    Route::post('ptw/diving/approvereject/submit', 'PTW\DivingPTWController@ApproveRejectSubmit');
    Route::get('ptw/diving/edit/{id}', 'PTW\DivingPTWController@Edit');
    Route::post('ptw/diving/edit/submit', 'PTW\DivingPTWController@Update');
    Route::post('ptw/diving/unique', 'PTW\DivingPTWController@Uniquecheck');
    Route::post('ptw/diving/status', 'PTW\DivingPTWController@StatusChange');
    Route::post('ptw/diving/delete', 'PTW\DivingPTWController@Delete');
    Route::get('ptw/diving/import', 'PTW\DivingPTWController@Import');
    Route::post('ptw/diving/import/submit', 'PTW\DivingPTWController@ImportSubmit');
    Route::get('ptw/diving/export/excel', 'PTW\DivingPTWController@ExportExcel');
    Route::get('ptw/diving/export/pdf', 'PTW\DivingPTWController@ExportPdf');
    Route::get('ptw/diving1/view/pdf/{id}', 'PTW\DivingPTWController@ExportViewPdf');
});
