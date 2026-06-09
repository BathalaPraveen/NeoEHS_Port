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
    |                           Port Security Access                                      |
    |                                                                                    |
    |___________________________________________________________________________________*/


    /**
     * Port Security
     */

    Route::get('portsecurity/master/list', 'Port\PortSecurityMasterController@index');
    Route::post('portsecurity/master/list', 'Port\PortSecurityMasterController@index');
    Route::get('portsecurity/master/view/{id}', 'Port\PortSecurityMasterController@View');
    Route::post('portsecurity/master/delete', 'Port\PortSecurityMasterController@Delete');
    Route::get('portsecurity/master/export/excel', 'Port\PortSecurityMasterController@ExportExcel');
    Route::get('portsecurity/master/export/pdf', 'Port\PortSecurityMasterController@ExportPdf');
    Route::get('portsecurity/master/add', 'Port\PortSecurityMasterController@Add');
    Route::post('portsecurity/master/add/submit', 'Port\PortSecurityMasterController@Store');
    Route::get('portsecurity/master/edit/{id}', 'Port\PortSecurityMasterController@Edit');


    Route::get('portsecurity/security_access/list', 'Port\PortSecurityController@index');
    Route::post('portsecurity/security_access/list', 'Port\PortSecurityController@index');
    Route::get('portsecurity/security_access/view/{id}', 'Port\PortSecurityController@View');
    Route::get('portsecurity/security_access/export/excel', 'Port\PortSecurityController@ExportExcel');
    Route::get('portsecurity/security_access/export/pdf', 'Port\PortSecurityController@ExportPdf');
    Route::get('portsecurity/security_access/pdf/{id}', 'Port\PortSecurityController@ExportViewPdf');


});
