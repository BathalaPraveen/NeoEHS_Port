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
    |                            Chemical Management                                     |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Chemical Category Master
     */

    Route::get('chemical/master/category/list', 'Chemical\CategoryController@index');
    Route::post('chemical/master/category/list', 'Chemical\CategoryController@index');
    Route::get('chemical/master/category/export/excel', 'Chemical\CategoryController@ExportExcel');
    Route::get('chemical/master/category/export/pdf', 'Chemical\CategoryController@ExportPdf');

    /**
     * Chemical Item Master
     */

    Route::get('chemical/master/item/list', 'Chemical\ItemController@index');
    Route::post('chemical/master/item/list', 'Chemical\ItemController@index');
    Route::get('chemical/master/item/add', 'Chemical\ItemController@Add');
    Route::post('chemical/master/item/add/submit', 'Chemical\ItemController@Store');
    Route::get('chemical/master/item/view/{id}', 'Chemical\ItemController@View');
    Route::get('chemical/master/item/edit/{id}', 'Chemical\ItemController@Edit');
    Route::post('chemical/master/item/edit/submit', 'Chemical\ItemController@Update');
    Route::post('chemical/master/item/unique', 'Chemical\ItemController@Uniquecheck');
    Route::post('chemical/master/item/status', 'Chemical\ItemController@StatusChange');
    Route::post('chemical/master/item/delete', 'Chemical\ItemController@Delete');
    Route::get('chemical/master/item/import', 'Chemical\ItemController@Import');
    Route::post('chemical/master/item/import/submit', 'Chemical\ItemController@ImportSubmit');
    Route::get('chemical/master/item/export/excel', 'Chemical\ItemController@ExportExcel');
    Route::get('chemical/master/item/export/pdf', 'Chemical\ItemController@ExportPdf');
    Route::get('chemical/master/item/list/{activityid}', 'Chemical\ItemController@list');


    /**
     * Chemical Supplier Master
     */

    Route::get('chemical/master/supplier/list', 'Chemical\SupplierController@index');
    Route::post('chemical/master/supplier/list', 'Chemical\SupplierController@index');
    Route::get('chemical/master/supplier/add', 'Chemical\SupplierController@Add');
    Route::post('chemical/master/supplier/add/submit', 'Chemical\SupplierController@Store');
    Route::get('chemical/master/supplier/view/{id}', 'Chemical\SupplierController@View');
    Route::get('chemical/master/supplier/edit/{id}', 'Chemical\SupplierController@Edit');
    Route::post('chemical/master/supplier/edit/submit', 'Chemical\SupplierController@Update');
    Route::post('chemical/master/supplier/unique', 'Chemical\SupplierController@Uniquecheck');
    Route::post('chemical/master/supplier/status', 'Chemical\SupplierController@StatusChange');
    Route::post('chemical/master/supplier/delete', 'Chemical\SupplierController@Delete');
    Route::get('chemical/master/supplier/import', 'Chemical\SupplierController@Import');
    Route::post('chemical/master/supplier/import/submit', 'Chemical\SupplierController@ImportSubmit');
    Route::get('chemical/master/supplier/export/excel', 'Chemical\SupplierController@ExportExcel');
    Route::get('chemical/master/supplier/export/pdf', 'Chemical\SupplierController@ExportPdf');
    Route::get('chemical/master/supplier/list/{activityid}', 'Chemical\SupplierController@list');


    /**
     * Chemical Chemical Master
     */

    Route::get('chemical/master/chemical/list', 'Chemical\ChemicalMasterController@index');
    Route::post('chemical/master/chemical/list', 'Chemical\ChemicalMasterController@index');
    Route::get('chemical/master/chemical/add', 'Chemical\ChemicalMasterController@Add');
    Route::post('chemical/master/chemical/add/submit', 'Chemical\ChemicalMasterController@Store');
    Route::get('chemical/master/chemical/view/{id}', 'Chemical\ChemicalMasterController@View');
    Route::get('chemical/master/chemical/edit/{id}', 'Chemical\ChemicalMasterController@Edit');
    Route::post('chemical/master/chemical/edit/submit', 'Chemical\ChemicalMasterController@Update');
    Route::post('chemical/master/chemical/unique', 'Chemical\ChemicalMasterController@Uniquecheck');
    Route::post('chemical/master/chemical/status', 'Chemical\ChemicalMasterController@StatusChange');
    Route::post('chemical/master/chemical/delete', 'Chemical\ChemicalMasterController@Delete');
    Route::get('chemical/master/chemical/import', 'Chemical\ChemicalMasterController@Import');
    Route::post('chemical/master/chemical/import/submit', 'Chemical\ChemicalMasterController@ImportSubmit');
    Route::get('chemical/master/chemical/export/excel', 'Chemical\ChemicalMasterController@ExportExcel');
    Route::get('chemical/master/chemical/export/pdf', 'Chemical\ChemicalMasterController@ExportPdf');
    Route::get('chemical/master/chemical/list/{activityid}', 'Chemical\ChemicalMasterController@list');


    /**
     * Chemical List
     */

    Route::get('chemical/chemical/list', 'Chemical\ChemicalController@index');
    Route::post('chemical/chemical/list', 'Chemical\ChemicalController@index');
    Route::get('chemical/chemical/add', 'Chemical\ChemicalController@Add');
    Route::post('chemical/chemical/add/submit', 'Chemical\ChemicalController@Store');
    Route::get('chemical/chemical/view/{id}', 'Chemical\ChemicalController@View');
    Route::get('chemical/chemical/edit/{id}', 'Chemical\ChemicalController@Edit');
    Route::post('chemical/chemical/edit/submit', 'Chemical\ChemicalController@Update');

    Route::get('chemical/chemical/approve/{type}/{id}', 'Chemical\ChemicalController@ApproveReject');
    Route::post('chemical/chemical/supervisor/submit', 'Chemical\ChemicalController@SupervisorApproveRejectSubmit');
    Route::post('chemical/chemical/hod/submit', 'Chemical\ChemicalController@HodApproveRejectSubmit');

    Route::post('chemical/chemical/unique', 'Chemical\ChemicalController@Uniquecheck');
    Route::post('chemical/chemical/status', 'Chemical\ChemicalController@StatusChange');
    Route::post('chemical/chemical/delete', 'Chemical\ChemicalController@Delete');
    Route::get('chemical/chemical/import', 'Chemical\ChemicalController@Import');
    Route::post('chemical/chemical/import/submit', 'Chemical\ChemicalController@ImportSubmit');
    Route::get('chemical/chemical/export/excel', 'Chemical\ChemicalController@ExportExcel');
    Route::get('chemical/chemical/export/pdf', 'Chemical\ChemicalController@ExportPdf');
    Route::get('chemical/chemical/list/{activityid}', 'Chemical\ChemicalController@list');
});
