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
    |                            HIRADC Management                                     |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * HIRADC Document Type Master
     */

    Route::get('hiradc/master/documenttype/list', 'HIRADC\DocumentTypeController@index');
    Route::post('hiradc/master/documenttype/list', 'HIRADC\DocumentTypeController@index');
    Route::get('hiradc/master/documenttype/add', 'HIRADC\DocumentTypeController@Add');
    Route::post('hiradc/master/documenttype/add/submit', 'HIRADC\DocumentTypeController@Store');
    Route::get('hiradc/master/documenttype/view/{id}', 'HIRADC\DocumentTypeController@View');
    Route::get('hiradc/master/documenttype/edit/{id}', 'HIRADC\DocumentTypeController@Edit');
    Route::post('hiradc/master/documenttype/edit/submit', 'HIRADC\DocumentTypeController@Update');
    Route::post('hiradc/master/documenttype/unique', 'HIRADC\DocumentTypeController@Uniquecheck');
    Route::post('hiradc/master/documenttype/status', 'HIRADC\DocumentTypeController@StatusChange');
    Route::post('hiradc/master/documenttype/delete', 'HIRADC\DocumentTypeController@Delete');
    Route::get('hiradc/master/documenttype/import', 'HIRADC\DocumentTypeController@Import');
    Route::post('hiradc/master/documenttype/import/submit', 'HIRADC\DocumentTypeController@ImportSubmit');
    Route::get('hiradc/master/documenttype/export/excel', 'HIRADC\DocumentTypeController@ExportExcel');
    Route::get('hiradc/master/documenttype/export/pdf', 'HIRADC\DocumentTypeController@ExportPdf');
    Route::post('hiradc/master/documenttype/datalist', 'HIRADC\DocumentTypeController@list');

    /**
     * HIRADC Document Type Category Master
     */

    Route::get('hiradc/master/documentcategory/list', 'HIRADC\DocuemntTypeCategoryController@index');
    Route::post('hiradc/master/documentcategory/list', 'HIRADC\DocuemntTypeCategoryController@index');
    Route::get('hiradc/master/documentcategory/add', 'HIRADC\DocuemntTypeCategoryController@Add');
    Route::post('hiradc/master/documentcategory/add/submit', 'HIRADC\DocuemntTypeCategoryController@Store');
    Route::get('hiradc/master/documentcategory/view/{id}', 'HIRADC\DocuemntTypeCategoryController@View');
    Route::get('hiradc/master/documentcategory/edit/{id}', 'HIRADC\DocuemntTypeCategoryController@Edit');
    Route::post('hiradc/master/documentcategory/edit/submit', 'HIRADC\DocuemntTypeCategoryController@Update');
    Route::post('hiradc/master/documentcategory/unique', 'HIRADC\DocuemntTypeCategoryController@Uniquecheck');
    Route::post('hiradc/master/documentcategory/status', 'HIRADC\DocuemntTypeCategoryController@StatusChange');
    Route::post('hiradc/master/documentcategory/delete', 'HIRADC\DocuemntTypeCategoryController@Delete');
    Route::get('hiradc/master/documentcategory/import', 'HIRADC\DocuemntTypeCategoryController@Import');
    Route::post('hiradc/master/documentcategory/import/submit', 'HIRADC\DocuemntTypeCategoryController@ImportSubmit');
    Route::get('hiradc/master/documentcategory/export/excel', 'HIRADC\DocuemntTypeCategoryController@ExportExcel');
    Route::get('hiradc/master/documentcategory/export/pdf', 'HIRADC\DocuemntTypeCategoryController@ExportPdf');
    Route::post('hiradc/master/documentcategory/datalist', 'HIRADC\DocuemntTypeCategoryController@list');





    /**
     * HIRADC Document Type Category Master
     */

    Route::get('hiradc/hazardlist/{type}/list', 'HIRADC\HazardListController@index');
    Route::post('hiradc/hazardlist/{type}/list', 'HIRADC\HazardListController@index');
    Route::get('hiradc/hazardlist/{type}/add', 'HIRADC\HazardListController@Add');
    Route::post('hiradc/hazardlist/{type}/add/submit', 'HIRADC\HazardListController@Store');
    Route::get('hiradc/hazardlist/{type}/view/{id}', 'HIRADC\HazardListController@View');
    Route::get('hiradc/hazardlist/{type}/edit/{id}', 'HIRADC\HazardListController@Edit');
    Route::post('hiradc/hazardlist/{type}/edit/submit', 'HIRADC\HazardListController@Update');
    Route::post('hiradc/hazardlist/{type}/unique', 'HIRADC\HazardListController@Uniquecheck');
    Route::post('hiradc/hazardlist/{type}/status', 'HIRADC\HazardListController@StatusChange');
    Route::post('hiradc/hazardlist/{type}/delete', 'HIRADC\HazardListController@Delete');
    Route::get('hiradc/hazardlist/{type}/import', 'HIRADC\HazardListController@Import');
    Route::post('hiradc/hazardlist/{type}/import/submit', 'HIRADC\HazardListController@ImportSubmit');
    Route::get('hiradc/hazardlist/{type}/export/excel', 'HIRADC\HazardListController@ExportExcel');
    Route::get('hiradc/hazardlist/{type}/export/pdf', 'HIRADC\HazardListController@ExportPdf');






    /**
     * HIRADC HIRADC Master
     */

    // Route::get('hiradc/master/HIRADC/list', 'HIRADC\HIRARCMasterController@index');
    // Route::post('hiradc/master/HIRADC/list', 'HIRADC\HIRARCMasterController@index');
    // Route::get('hiradc/master/HIRADC/add', 'HIRADC\HIRARCMasterController@Add');
    // Route::post('hiradc/master/HIRADC/add/submit', 'HIRADC\HIRARCMasterController@Store');
    // Route::get('hiradc/master/HIRADC/view/{id}', 'HIRADC\HIRARCMasterController@View');
    // Route::get('hiradc/master/HIRADC/edit/{id}', 'HIRADC\HIRARCMasterController@Edit');
    // Route::post('hiradc/master/HIRADC/edit/submit', 'HIRADC\HIRARCMasterController@Update');
    // Route::post('hiradc/master/HIRADC/unique', 'HIRADC\HIRARCMasterController@Uniquecheck');
    // Route::post('hiradc/master/HIRADC/status', 'HIRADC\HIRARCMasterController@StatusChange');
    // Route::post('hiradc/master/HIRADC/delete', 'HIRADC\HIRARCMasterController@Delete');
    // Route::get('hiradc/master/HIRADC/import', 'HIRADC\HIRARCMasterController@Import');
    // Route::post('hiradc/master/HIRADC/import/submit', 'HIRADC\HIRARCMasterController@ImportSubmit');
    // Route::get('hiradc/master/HIRADC/export/excel', 'HIRADC\HIRARCMasterController@ExportExcel');
    // Route::get('hiradc/master/HIRADC/export/pdf', 'HIRADC\HIRARCMasterController@ExportPdf');
    // Route::get('hiradc/master/HIRADC/list/{activityid}', 'HIRADC\HIRARCMasterController@list');


    /**
     * HIRADC List
     */

    Route::get('hiradc/hiradc/list', 'HIRADC\HIRADCController@index');
    Route::post('hiradc/hiradc/list', 'HIRADC\HIRADCController@index');
    Route::get('hiradc/hiradc/add', 'HIRADC\HIRADCController@Add');
    Route::post('hiradc/hiradc/add/submit', 'HIRADC\HIRADCController@Store');
    Route::get('hiradc/hiradc/view/{id}', 'HIRADC\HIRADCController@View');
    Route::get('hiradc/hiradc/edit/{id}', 'HIRADC\HIRADCController@Edit');
    Route::post('hiradc/hiradc/edit/submit', 'HIRADC\HIRADCController@Update');

    Route::get('hiradc/hiradc/approve/{type}/{id}', 'HIRADC\HIRADCController@ApproveReject');
    Route::post('hiradc/hiradc/approve/submit', 'HIRADC\HIRADCController@SupervisorApproveRejectSubmit');

    Route::post('hiradc/hiradc/ghse/submit', 'HIRADC\HIRADCController@GHSEApproveRejectSubmit');

    Route::post('hiradc/hiradc/unique', 'HIRADC\HIRADCController@Uniquecheck');
    Route::post('hiradc/hiradc/status', 'HIRADC\HIRADCController@StatusChange');
    Route::post('hiradc/hiradc/delete', 'HIRADC\HIRADCController@Delete');
    Route::get('hiradc/hiradc/import', 'HIRADC\HIRADCController@Import');
    Route::post('hiradc/hiradc/import/submit', 'HIRADC\HIRADCController@ImportSubmit');
    Route::get('hiradc/hiradc/export/excel', 'HIRADC\HIRADCController@ExportExcel');
    Route::get('hiradc/hiradc/export/pdf', 'HIRADC\HIRADCController@ExportPdf');
    Route::get('hiradc/hiradc/list/{activityid}', 'HIRADC\HIRADCController@list');
});
