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
     * ATAR Type Master
     */

    Route::get('atar/master/atar/list', 'ATAR\AtarTypeController@index');
    Route::post('atar/master/atar/list', 'ATAR\AtarTypeController@index');
    Route::post('atar/master/atar/list/{search}', 'ATAR\AtarTypeController@index');
    Route::get('atar/master/atar/export/excel', 'ATAR\AtarTypeController@ExportExcel');
    Route::get('atar/master/atar/export/pdf', 'ATAR\AtarTypeController@ExportPdf');


    /**
     * ZeFA Rules Master
     */

    Route::get('atar/master/zefa/list', 'ATAR\ZefaRulesController@index');
    Route::post('atar/master/zefa/list', 'ATAR\ZefaRulesController@index');
    Route::get('atar/master/zefa/add', 'ATAR\ZefaRulesController@Add');
    Route::post('atar/master/zefa/add/submit', 'ATAR\ZefaRulesController@Store');
    Route::get('atar/master/zefa/view/{id}', 'ATAR\ZefaRulesController@View');
    Route::get('atar/master/zefa/edit/{id}', 'ATAR\ZefaRulesController@Edit');
    Route::post('atar/master/zefa/delete', 'ATAR\ZefaRulesController@Delete');
    Route::post('atar/master/zefa/edit/submit', 'ATAR\ZefaRulesController@Update');
    Route::get('atar/master/zefa/export/excel', 'ATAR\ZefaRulesController@ExportExcel');
    Route::get('atar/master/zefa/export/pdf', 'ATAR\ZefaRulesController@ExportPdf');


    /**
     * HSE Hazard Master
     */

    Route::get('atar/master/hsehazard/list', 'ATAR\HSEHazardController@index');
    Route::post('atar/master/hsehazard/list', 'ATAR\HSEHazardController@index');
    Route::get('atar/master/hsehazard/add', 'ATAR\HSEHazardController@Add');
    Route::post('atar/master/hsehazard/add/submit', 'ATAR\HSEHazardController@Store');
    Route::get('atar/master/hsehazard/view/{id}', 'ATAR\HSEHazardController@View');
    Route::get('atar/master/hsehazard/edit/{id}', 'ATAR\HSEHazardController@Edit');
    Route::post('atar/master/hsehazard/delete', 'ATAR\HSEHazardController@Delete');
    Route::post('atar/master/hsehazard/edit/submit', 'ATAR\HSEHazardController@Update');
    Route::get('atar/master/hsehazard/export/excel', 'ATAR\HSEHazardController@ExportExcel');
    Route::get('atar/master/hsehazard/export/pdf', 'ATAR\HSEHazardController@ExportPdf');
    Route::get('atar/master/hsehazard/list/{useeId}', 'ATAR\HSEHazardController@List');

    /**
     * Infringement Master
     */

    Route::get('atar/master/infringement/list', 'ATAR\InfringementController@index');
    Route::post('atar/master/infringement/list', 'ATAR\InfringementController@index');
    Route::get('atar/master/infringement/add', 'ATAR\InfringementController@Add');
    Route::post('atar/master/infringement/add/submit', 'ATAR\InfringementController@Store');
    Route::get('atar/master/infringement/view/{id}', 'ATAR\InfringementController@View');
    Route::get('atar/master/infringement/edit/{id}', 'ATAR\InfringementController@Edit');
    Route::post('atar/master/infringement/delete', 'ATAR\InfringementController@Delete');
    Route::post('atar/master/infringement/edit/submit', 'ATAR\InfringementController@Update');
    Route::get('atar/master/infringement/export/excel', 'ATAR\InfringementController@ExportExcel');
    Route::get('atar/master/infringement/export/pdf', 'ATAR\InfringementController@ExportPdf');
    Route::get('atar/master/infringement/list/{useeId}', 'ATAR\InfringementController@List');


    /**
     * UAUC New
     */

    Route::get('atar/uauc/list', 'ATAR\UAUCController@index');
    Route::post('atar/uauc/list', 'ATAR\UAUCController@index');
    Route::get('atar/uauc/list/{search}', 'ATAR\UAUCController@index');
    Route::get('atar/uauc/add', 'ATAR\UAUCController@Add');
    Route::post('atar/uauc/add/submit', 'ATAR\UAUCController@Store');
    Route::get('atar/uauc/view/{id}', 'ATAR\UAUCController@View');
    Route::get('atar/uauc/edit/{id}', 'ATAR\UAUCController@Edit');
    Route::post('atar/uauc/edit/submit', 'ATAR\UAUCController@Update');
    Route::get('atar/uauc/export/excel', 'ATAR\UAUCController@ExportExcel');
    Route::get('atar/uauc/export/pdf', 'ATAR\UAUCController@ExportPdf');
    Route::get('atar/uauc/view/pdf/{id}', 'ATAR\UAUCController@ExportViewPdf');
    Route::post('atar/uauc/delete', 'ATAR\UAUCController@Delete');
    Route::get('atar/uauc/remainder', 'Cron\CronController@UAUCRemainder');
    Route::post('atar/uauc/hse/submit', 'ATAR\UAUCController@hseSubmit');


    /**
     * UAUC Chart
     */

    Route::get('uauc/chart/getUAUCCountChartData', 'ATAR\UAUCChartController@getUAUCCountChartData');
    Route::get('uauc/chart/getUAUCCategoryChartData', 'ATAR\UAUCChartController@getUAUCCategoryChartData');
    Route::get('uauc/chart/getHSCHazardChartData', 'ATAR\UAUCChartController@getHSCHazardChartData');
    Route::get('uauc/chart/getCorrectiveActionChartData', 'ATAR\UAUCChartController@getCorrectiveActionChartData');
    Route::get('uauc/chart/getZeFAChartData', 'ATAR\UAUCChartController@getZeFAChartData');
    Route::get('uauc/chart/getInfringementData', 'ATAR\UAUCChartController@getInfringementData');

});
