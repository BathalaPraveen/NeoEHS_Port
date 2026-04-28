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
    |                            ATAR Management                                         |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Machinery Type Master
     */

    Route::get('machinery/master/machinerytype/list', 'Machinery\MachineryTypeController@index');
    Route::post('machinery/master/machinerytype/list', 'Machinery\MachineryTypeController@index');
    Route::get('machinery/master/machinerytype/add', 'Machinery\MachineryTypeController@Add');
    Route::post('machinery/master/machinerytype/add/submit', 'Machinery\MachineryTypeController@Store');
    Route::get('machinery/master/machinerytype/view/{id}', 'Machinery\MachineryTypeController@View');
    Route::get('machinery/master/machinerytype/edit/{id}', 'Machinery\MachineryTypeController@Edit');
    Route::post('machinery/master/machinerytype/delete', 'Machinery\MachineryTypeController@Delete');
    Route::post('machinery/master/machinerytype/edit/submit', 'Machinery\MachineryTypeController@Update');
    Route::get('machinery/master/machinerytype/export/excel', 'Machinery\MachineryTypeController@ExportExcel');
    Route::get('machinery/master/machinerytype/export/pdf', 'Machinery\MachineryTypeController@ExportPdf');


    /**
     * Machinery
     */

    Route::get('machinery/machinery/list', 'Machinery\MachineryController@index');
    Route::post('machinery/machinery/list', 'Machinery\MachineryController@index');
    Route::get('machinery/machinery/add', 'Machinery\MachineryController@Add');
    Route::post('machinery/machinery/add/submit', 'Machinery\MachineryController@Store');
    Route::get('machinery/machinery/approvereject/{id}', 'Machinery\MachineryController@ApproveReject');
    Route::post('machinery/machinery/approvereject/submit', 'Machinery\MachineryController@ApproveRejectSubmit');
    Route::get('machinery/machinery/inspectionupdate/{id}', 'Machinery\MachineryController@Inspection');
    Route::post('machinery/machinery/inspectionupdate/submit', 'Machinery\MachineryController@InspectionSubmit');
    Route::get('machinery/machinery/view/{id}', 'Machinery\MachineryController@View');
    Route::get('machinery/machinery/edit/{id}', 'Machinery\MachineryController@Edit');
    Route::post('machinery/machinery/edit/submit', 'Machinery\MachineryController@Update');
    Route::get('machinery/machinery/export/excel', 'Machinery\MachineryController@ExportExcel');
    Route::get('machinery/machinery/export/pdf', 'Machinery\MachineryController@ExportPdf');
    Route::get('machinery/machinery/view/pdf/{id}', 'Machinery\MachineryController@ExportViewPdf');



});
