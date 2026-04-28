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
    |                           Inspection Management                                      |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Inspection Type Master
     */

    Route::get('inspection/master/inspectiontype/list', 'Inspection\InspectionTypeController@index');
    Route::post('inspection/master/inspectiontype/list', 'Inspection\InspectionTypeController@index');
    Route::get('inspection/master/inspectiontype/add', 'Inspection\InspectionTypeController@Add');
    Route::post('inspection/master/inspectiontype/add/submit', 'Inspection\InspectionTypeController@Store');
    Route::get('inspection/master/inspectiontype/view/{id}', 'Inspection\InspectionTypeController@View');
    Route::get('inspection/master/inspectiontype/edit/{id}', 'Inspection\InspectionTypeController@Edit');
    Route::post('inspection/master/inspectiontype/edit/submit', 'Inspection\InspectionTypeController@Update');
    Route::post('inspection/master/inspectiontype/unique', 'Inspection\InspectionTypeController@Uniquecheck');
    Route::post('inspection/master/inspectiontype/status', 'Inspection\InspectionTypeController@StatusChange');
    Route::post('inspection/master/inspectiontype/delete', 'Inspection\InspectionTypeController@Delete');
    Route::get('inspection/master/inspectiontype/import', 'Inspection\InspectionTypeController@Import');
    Route::post('inspection/master/inspectiontype/import/submit', 'Inspection\InspectionTypeController@ImportSubmit');
    Route::get('inspection/master/inspectiontype/export/excel', 'Inspection\InspectionTypeController@ExportExcel');
    Route::get('inspection/master/inspectiontype/export/pdf', 'Inspection\InspectionTypeController@ExportPdf');
    Route::get('inspection/master/inspectiontype/list/{activityid}', 'Inspection\InspectionTypeController@list');


    Route::get('inspection/master/checklistcategory/list', 'Inspection\ChecklistCategoryController@index');
    Route::post('inspection/master/checklistcategory/list', 'Inspection\ChecklistCategoryController@index');
    Route::get('inspection/master/checklistcategory/add', 'Inspection\ChecklistCategoryController@Add');
    Route::post('inspection/master/checklistcategory/add/submit', 'Inspection\ChecklistCategoryController@Store');
    Route::get('inspection/master/checklistcategory/view/{id}', 'Inspection\ChecklistCategoryController@View');
    Route::get('inspection/master/checklistcategory/edit/{id}', 'Inspection\ChecklistCategoryController@Edit');
    Route::post('inspection/master/checklistcategory/edit/submit', 'Inspection\ChecklistCategoryController@Update');
    Route::post('inspection/master/checklistcategory/unique', 'Inspection\ChecklistCategoryController@Uniquecheck');
    Route::post('inspection/master/checklistcategory/status', 'Inspection\ChecklistCategoryController@StatusChange');
    Route::post('inspection/master/checklistcategory/delete', 'Inspection\ChecklistCategoryController@Delete');
    Route::get('inspection/master/checklistcategory/import', 'Inspection\ChecklistCategoryController@Import');
    Route::post('inspection/master/checklistcategory/import/submit', 'Inspection\ChecklistCategoryController@ImportSubmit');
    Route::get('inspection/master/checklistcategory/export/excel', 'Inspection\ChecklistCategoryController@ExportExcel');
    Route::get('inspection/master/checklistcategory/export/pdf', 'Inspection\ChecklistCategoryController@ExportPdf');
    Route::get('inspection/master/checklistcategory/list/{activityid}', 'Inspection\ChecklistCategoryController@list');


    Route::get('inspection/master/checklistitem/list', 'Inspection\ChecklistItemController@index');
    Route::post('inspection/master/checklistitem/list', 'Inspection\ChecklistItemController@index');
    Route::get('inspection/master/checklistitem/add', 'Inspection\ChecklistItemController@Add');
    Route::post('inspection/master/checklistitem/add/submit', 'Inspection\ChecklistItemController@Store');
    Route::get('inspection/master/checklistitem/view/{id}', 'Inspection\ChecklistItemController@View');
    Route::get('inspection/master/checklistitem/edit/{id}', 'Inspection\ChecklistItemController@Edit');
    Route::post('inspection/master/checklistitem/edit/submit', 'Inspection\ChecklistItemController@Update');
    Route::post('inspection/master/checklistitem/unique', 'Inspection\ChecklistItemController@Uniquecheck');
    Route::post('inspection/master/checklistitem/status', 'Inspection\ChecklistItemController@StatusChange');
    Route::post('inspection/master/checklistitem/delete', 'Inspection\ChecklistItemController@Delete');
    Route::get('inspection/master/checklistitem/import', 'Inspection\ChecklistItemController@Import');
    Route::post('inspection/master/checklistitem/import/submit', 'Inspection\ChecklistItemController@ImportSubmit');
    Route::get('inspection/master/checklistitem/export/excel', 'Inspection\ChecklistItemController@ExportExcel');
    Route::get('inspection/master/chectklistitem/export/pdf', 'Inspection\ChecklistItemController@ExportPdf');
    Route::get('inspection/master/checklistitem/list/{activityid}', 'Inspection\ChecklistItemController@list');

    Route::get('inspection/inspection/list', 'Inspection\InspectionController@index');
    Route::post('inspection/inspection/list', 'Inspection\InspectionController@index');
    Route::get('inspection/inspection/create', 'Inspection\InspectionController@Create');
    Route::post('inspection/inspection/create/submit', 'Inspection\InspectionController@CreateSubmit');
    Route::get('inspection/inspection/add/{id}', 'Inspection\InspectionController@Add');
    Route::post('inspection/inspection/getCheckList', 'Inspection\InspectionController@getCheckList');
    Route::post('inspection/inspection/add/submit', 'Inspection\InspectionController@Store');
    Route::get('inspection/inspection/approvereject/{id}', 'Inspection\InspectionController@ApproveReject');
    Route::post('inspection/inspection/approvereject/submit', 'Inspection\InspectionController@ApproveRejectSubmit');


    Route::get('inspection/inspection/view/{id}', 'Inspection\InspectionController@View');
    Route::get('inspection/inspection/edit/{id}', 'Inspection\InspectionController@Edit');
    Route::post('inspection/inspection/edit/submit', 'Inspection\InspectionController@Update');
    Route::post('inspection/inspection/unique', 'Inspection\InspectionController@Uniquecheck');
    Route::post('inspection/inspection/status', 'Inspection\InspectionController@StatusChange');
    Route::post('inspection/inspection/delete', 'Inspection\InspectionController@Delete');
    Route::get('inspection/inspection/import', 'Inspection\InspectionController@Import');
    Route::post('inspection/inspection/import/submit', 'Inspection\InspectionController@ImportSubmit');
    Route::get('inspection/inspection/export/excel', 'Inspection\InspectionController@ExportExcel');
    Route::get('inspection/inspection/export/pdf', 'Inspection\InspectionController@ExportPdf');
    Route::get('inspection/inspection/view/pdf/{id}', 'Inspection\InspectionController@ExportViewPdf');
    Route::get('inspection/inspection/list/{activityid}', 'Inspection\InspectionController@list');

    Route::get('inspection/inspection/add/audittype', 'Inspection\InspectionController@AddAudit');

});
