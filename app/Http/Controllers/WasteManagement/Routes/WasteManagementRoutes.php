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
    |                            Waste Management                                        |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Waste Type Master
     */

    Route::get('wastemanagement/master/wastetype/list', 'WasteManagement\WasteTypeController@index');
    Route::post('wastemanagement/master/wastetype/list', 'WasteManagement\WasteTypeController@index');
    Route::get('wastemanagement/master/wastetype/add', 'WasteManagement\WasteTypeController@Add');
    Route::post('wastemanagement/master/wastetype/add/submit', 'WasteManagement\WasteTypeController@Store');
    Route::get('wastemanagement/master/wastetype/view/{id}', 'WasteManagement\WasteTypeController@View');
    Route::get('wastemanagement/master/wastetype/edit/{id}', 'WasteManagement\WasteTypeController@Edit');
    Route::post('wastemanagement/master/wastetype/edit/submit', 'WasteManagement\WasteTypeController@Update');
    Route::post('wastemanagement/master/wastetype/unique', 'WasteManagement\WasteTypeController@Uniquecheck');
    Route::post('wastemanagement/master/wastetype/status', 'WasteManagement\WasteTypeController@StatusChange');
    Route::post('wastemanagement/master/wastetype/delete', 'WasteManagement\WasteTypeController@Delete');
    Route::get('wastemanagement/master/wastetype/import', 'WasteManagement\WasteTypeController@Import');
    Route::post('wastemanagement/master/wastetype/import/submit', 'WasteManagement\WasteTypeController@ImportSubmit');
    Route::get('wastemanagement/master/wastetype/export/excel', 'WasteManagement\WasteTypeController@ExportExcel');
    Route::get('wastemanagement/master/wastetype/export/pdf', 'WasteManagement\WasteTypeController@ExportPdf');
    Route::get('wastemanagement/master/wastetype/list/{activityid}', 'WasteManagement\WasteTypeController@list');


    Route::get('wastemanagement/master/disposaltype/list', 'WasteManagement\DisposalTypeController@index');
    Route::post('wastemanagement/master/disposaltype/list', 'WasteManagement\DisposalTypeController@index');
    Route::get('wastemanagement/master/disposaltype/add', 'WasteManagement\DisposalTypeController@Add');
    Route::post('wastemanagement/master/disposaltype/add/submit', 'WasteManagement\DisposalTypeController@Store');
    Route::get('wastemanagement/master/disposaltype/view/{id}', 'WasteManagement\DisposalTypeController@View');
    Route::get('wastemanagement/master/disposaltype/edit/{id}', 'WasteManagement\DisposalTypeController@Edit');
    Route::post('wastemanagement/master/disposaltype/edit/submit', 'WasteManagement\DisposalTypeController@Update');
    Route::post('wastemanagement/master/disposaltype/unique', 'WasteManagement\DisposalTypeController@Uniquecheck');
    Route::post('wastemanagement/master/disposaltype/status', 'WasteManagement\DisposalTypeController@StatusChange');
    Route::post('wastemanagement/master/disposaltype/delete', 'WasteManagement\DisposalTypeController@Delete');
    Route::get('wastemanagement/master/disposaltype/import', 'WasteManagement\DisposalTypeController@Import');
    Route::post('wastemanagement/master/disposaltype/import/submit', 'WasteManagement\DisposalTypeController@ImportSubmit');
    Route::get('wastemanagement/master/disposaltype/export/excel', 'WasteManagement\DisposalTypeController@ExportExcel');
    Route::get('wastemanagement/master/disposaltype/export/pdf', 'WasteManagement\DisposalTypeController@ExportPdf');
    Route::get('wastemanagement/master/disposaltype/list/{activityid}', 'WasteManagement\DisposalTypeController@list');


    Route::get('wastemanagement/waste/list', 'WasteManagement\WasteCompanyController@index');
    Route::post('wastemanagement/waste/list', 'WasteManagement\WasteCompanyController@index');
    Route::get('wastemanagement/waste/add', 'WasteManagement\WasteCompanyController@Add');
    Route::post('wastemanagement/waste/add/submit', 'WasteManagement\WasteCompanyController@Store');
    Route::get('wastemanagement/waste/view/{id}', 'WasteManagement\WasteCompanyController@View');
    Route::get('wastemanagement/waste/edit/{id}', 'WasteManagement\WasteCompanyController@Edit');
    Route::post('wastemanagement/waste/edit/submit', 'WasteManagement\WasteCompanyController@Update');
    Route::get('wastemanagement/waste/approvereject/{id}', 'WasteManagement\WasteCompanyController@ApproveReject');
    Route::post('wastemanagement/waste/approvereject/submit', 'WasteManagement\WasteCompanyController@ApproveRejectSubmit');
    Route::post('wastemanagement/waste/unique', 'WasteManagement\WasteCompanyController@Uniquecheck');
    Route::post('wastemanagement/waste/status', 'WasteManagement\WasteCompanyController@StatusChange');
    Route::post('wastemanagement/waste/delete', 'WasteManagement\WasteCompanyController@Delete');
    Route::get('wastemanagement/waste/import', 'WasteManagement\WasteCompanyController@Import');
    Route::post('wastemanagement/waste/import/submit', 'WasteManagement\WasteCompanyController@ImportSubmit');
    Route::get('wastemanagement/waste/export/excel', 'WasteManagement\WasteCompanyController@ExportExcel');
    Route::get('wastemanagement/waste/export/pdf', 'WasteManagement\WasteCompanyController@ExportPdf');
    Route::get('wastemanagement/waste/list/{activityid}', 'WasteManagement\WasteCompanyController@list');

    Route::get('wastemanagement/master/item/list', 'WasteManagement\WasteItemController@index');
    Route::post('wastemanagement/master/item/list', 'WasteManagement\WasteItemController@index');
    Route::get('wastemanagement/master/item/add', 'WasteManagement\WasteItemController@Add');
    Route::post('wastemanagement/master/item/add/submit', 'WasteManagement\WasteItemController@Store');
    Route::get('wastemanagement/master/item/edit/{id}', 'WasteManagement\WasteItemController@Edit');
    Route::post('wastemanagement/master/item/edit/submit', 'WasteManagement\WasteItemController@Update');
    Route::post('wastemanagement/master/item/unique', 'WasteManagement\WasteItemController@Uniquecheck');
    Route::post('wastemanagement/master/item/status', 'WasteManagement\WasteItemController@StatusChange');
    Route::post('wastemanagement/master/item/delete', 'WasteManagement\WasteItemController@Delete');
    Route::get('wastemanagement/master/item/import', 'WasteManagement\WasteItemController@Import');
    Route::post('wastemanagement/master/item/import/submit', 'WasteManagement\WasteItemController@ImportSubmit');
    Route::get('wastemanagement/master/item/export/excel', 'WasteManagement\WasteItemController@ExportExcel');
    Route::get('wastemanagement/master/item/export/pdf', 'WasteManagement\WasteItemController@ExportPdf');
    Route::get('wastemanagement/master/item/list/{activityid}', 'WasteManagement\WasteItemController@list');

    Route::get('wastemanagement/master/category/list', 'WasteManagement\WasteCategoryController@index');
    Route::post('wastemanagement/master/category/list', 'WasteManagement\WasteCategoryController@index');
    Route::get('wastemanagement/master/category/export/excel', 'WasteManagement\WasteCategoryController@ExportExcel');
    Route::get('wastemanagement/master/category/export/pdf', 'WasteManagement\WasteCategoryController@ExportPdf');

    Route::get('wastemanagement/master/company/list', 'WasteManagement\WasteCompanyController@index');
    Route::post('wastemanagement/master/company/list', 'WasteManagement\WasteCompanyController@index');
    Route::get('wastemanagement/master/company/add', 'WasteManagement\WasteCompanyController@Add');
    Route::post('wastemanagement/master/company/add/submit', 'WasteManagement\WasteCompanyController@Store');
    Route::get('wastemanagement/master/company/edit/{id}', 'WasteManagement\WasteCompanyController@Edit');
    Route::post('wastemanagement/master/company/edit/submit', 'WasteManagement\WasteCompanyController@Update');
    Route::post('wastemanagement/master/company/unique', 'WasteManagement\WasteCompanyController@Uniquecheck');
    Route::post('wastemanagement/master/company/status', 'WasteManagement\WasteCompanyController@StatusChange');
    Route::post('wastemanagement/master/company/delete', 'WasteManagement\WasteCompanyController@Delete');
    Route::get('wastemanagement/master/company/import', 'WasteManagement\WasteCompanyController@Import');
    Route::post('wastemanagement/master/company/import/submit', 'WasteManagement\WasteCompanyController@ImportSubmit');
    Route::get('wastemanagement/master/company/export/excel', 'WasteManagement\WasteCompanyController@ExportExcel');
    Route::get('wastemanagement/master/company/export/pdf', 'WasteManagement\WasteCompanyController@ExportPdf');



    Route::get('wastemanagement/{company}/wasteregister/list', 'WasteManagement\WasteRegisterController@index');
    Route::post('wastemanagement/{company}/wasteregister/list', 'WasteManagement\WasteRegisterController@index');
    Route::get('wastemanagement/{company}/wasteregister/add', 'WasteManagement\WasteRegisterController@Add');
    Route::post('wastemanagement/{company}/wasteregister/add/submit', 'WasteManagement\WasteRegisterController@Store');
    Route::get('wastemanagement/{company}/wasteregister/edit/{id}', 'WasteManagement\WasteRegisterController@Edit');
    Route::post('wastemanagement/{company}/wasteregister/edit/submit', 'WasteManagement\WasteRegisterController@Update');
    Route::post('wastemanagement/{company}/wasteregister/unique', 'WasteManagement\WasteRegisterController@Uniquecheck');
    Route::post('wastemanagement/{company}/wasteregister/status', 'WasteManagement\WasteRegisterController@StatusChange');
    Route::post('wastemanagement/{company}/wasteregister/delete', 'WasteManagement\WasteRegisterController@Delete');
    Route::get('wastemanagement/{company}/wasteregister/import', 'WasteManagement\WasteRegisterController@Import');
    Route::post('wastemanagement/{company}/wasteregister/import/submit', 'WasteManagement\WasteRegisterController@ImportSubmit');
    Route::get('wastemanagement/{company}/wasteregister/export/excel', 'WasteManagement\WasteRegisterController@ExportExcel');
    Route::get('wastemanagement/{company}/wasteregister/export/pdf', 'WasteManagement\WasteRegisterController@ExportPdf');


    Route::get('wastemanagement/{company}/wasteinventory/list', 'WasteManagement\WasteInventoryController@index');
    Route::post('wastemanagement/{company}/wasteinventory/list', 'WasteManagement\WasteInventoryController@index');
    Route::get('wastemanagement/{company}/wasteinventory/add/list', 'WasteManagement\WasteInventoryController@addindex');
    Route::post('wastemanagement/{company}/wasteinventory/add/list', 'WasteManagement\WasteInventoryController@addindex');
    Route::get('wastemanagement/{company}/wasteinventory/disposal/list', 'WasteManagement\WasteInventoryController@disposalindex');
    Route::post('wastemanagement/{company}/wasteinventory/disposal/list', 'WasteManagement\WasteInventoryController@disposalindex');

    Route::get('wastemanagement/{company}/wasteinventory/add', 'WasteManagement\WasteInventoryController@Add');
    Route::post('wastemanagement/{company}/wasteinventory/add/submit', 'WasteManagement\WasteInventoryController@Store');
    Route::get('wastemanagement/{company}/wasteinventory/disposal', 'WasteManagement\WasteInventoryController@Disposal');
    Route::post('wastemanagement/{company}/wasteinventory/disposal/submit', 'WasteManagement\WasteInventoryController@DisposalStore');
    Route::get('wastemanagement/{company}/wasteinventory/edit/{id}', 'WasteManagement\WasteInventoryController@Edit');
    Route::post('wastemanagement/{company}/wasteinventory/edit/submit', 'WasteManagement\WasteInventoryController@Update');
    Route::post('wastemanagement/{company}/wasteinventory/unique', 'WasteManagement\WasteInventoryController@Uniquecheck');
    Route::post('wastemanagement/{company}/wasteinventory/status', 'WasteManagement\WasteInventoryController@StatusChange');
    Route::post('wastemanagement/{company}/wasteinventory/delete', 'WasteManagement\WasteInventoryController@Delete');
    Route::get('wastemanagement/{company}/wasteinventory/import', 'WasteManagement\WasteInventoryController@Import');
    Route::post('wastemanagement/{company}/wasteinventory/import/submit', 'WasteManagement\WasteInventoryController@ImportSubmit');
    Route::get('wastemanagement/{company}/wasteinventory/export/excel', 'WasteManagement\WasteInventoryController@ExportExcel');
    Route::get('wastemanagement/{company}/wasteinventory/export/pdf', 'WasteManagement\WasteInventoryController@ExportPdf');

    Route::get('wastemanagement/{company}/wasteinventory/add/export/excel', 'WasteManagement\WasteInventoryController@ExportExcelAdd');
    Route::get('wastemanagement/{company}/wasteinventory/add/export/pdf', 'WasteManagement\WasteInventoryController@ExportPdfAdd');
    Route::get('wastemanagement/{company}/wasteinventory/disposal/export/excel', 'WasteManagement\WasteInventoryController@ExportExcelDisposal');
    Route::get('wastemanagement/{company}/wasteinventory/disposal/export/pdf', 'WasteManagement\WasteInventoryController@ExportPdfDisposal');


    Route::get('wastemanagement/{company}/wastecard/list', 'WasteManagement\WasteCardController@index');
    Route::post('wastemanagement/{company}/wastecard/list', 'WasteManagement\WasteCardController@index');
    Route::get('wastemanagement/{company}/wastecard/add', 'WasteManagement\WasteCardController@Add');
    Route::post('wastemanagement/{company}/wastecard/add/submit', 'WasteManagement\WasteCardController@Store');
    Route::get('wastemanagement/{company}/wastecard/view/{id}', 'WasteManagement\WasteCardController@View');
    Route::get('wastemanagement/{company}/wastecard/edit/{id}', 'WasteManagement\WasteCardController@Edit');
    Route::post('wastemanagement/{company}/wastecard/edit/submit', 'WasteManagement\WasteCardController@Update');
    Route::post('wastemanagement/{company}/wastecard/unique', 'WasteManagement\WasteCardController@Uniquecheck');
    Route::post('wastemanagement/{company}/wastecard/status', 'WasteManagement\WasteCardController@StatusChange');
    Route::post('wastemanagement/{company}/wastecard/delete', 'WasteManagement\WasteCardController@Delete');
    Route::get('wastemanagement/{company}/wastecard/import', 'WasteManagement\WasteCardController@Import');
    Route::post('wastemanagement/{company}/wastecard/import/submit', 'WasteManagement\WasteCardController@ImportSubmit');
    Route::get('wastemanagement/{company}/wastecard/export/excel', 'WasteManagement\WasteCardController@ExportExcel');
    Route::get('wastemanagement/{company}/wastecard/export/pdf', 'WasteManagement\WasteCardController@ExportPdf');
    Route::get('wastemanagement/{company}/wastecard/export/pdf/{id}', 'WasteManagement\WasteCardController@ExportViewPdf');



});
