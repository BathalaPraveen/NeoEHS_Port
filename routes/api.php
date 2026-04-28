<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('v1')->group(function () {

    Route::post('login', 'API\LoginController@login');

    Route::post('password/forgot', 'API\LoginController@forgotPassword');
    Route::post('password/otp', 'API\LoginController@passwordOtp');
    Route::post('password/change', 'API\LoginController@passwordChange');

    Route::middleware(['auth:api', 'extendAccessTokenExpiration'])->group(function () {

        Route::get('user/profile', 'API\LoginController@userProfile');
        Route::get('dashboard', 'API\DashboardController@index');
        Route::post('logout', 'API\LoginController@logout');

        Route::post('notification', 'API\DashboardController@notification');
        Route::post('notification/update', 'API\DashboardController@notificationUpdate');


        /**
         * Master Routes
         */

        Route::post('master/company/list', 'API\MasterController@company');
        Route::post('master/division/list', 'API\MasterController@division');
        Route::post('master/department/list', 'API\MasterController@department');

        Route::post('master/location/list', 'API\MasterController@location');
        Route::post('master/specificlocation/list', 'API\MasterController@specificLocation');

        Route::post('master/user/jobowner/list', 'API\MasterController@jobOwner');
        Route::post('master/user/jobowner/name', 'API\MasterController@jobOwnerName');


        /**
         * UAUC Routes
         */

        Route::post('uauc/list', 'API\UAUCController@list');
        Route::get('uauc/add', 'API\UAUCController@add');
        Route::post('uauc/hsehazard', 'API\UAUCController@hseHazard');
        Route::post('uauc/infringement', 'API\UAUCController@infringement');
        Route::post('uauc/store', 'API\UAUCController@store');
        Route::post('uauc/view', 'API\UAUCController@view');
        Route::post('uauc/statuslist', 'API\UAUCController@statuslist');
        Route::post('uauc/statusupdate', 'API\UAUCController@statusupdate');
        Route::post('uauc/hseSubmit', 'API\UAUCController@hseSubmit');



        /**
         * PTW Routes
         */

        Route::get('ptw/generalstatus', 'API\PTW\GeneralController@generalstatus');
        Route::get('ptw/subpermitstatus', 'API\PTW\GeneralController@subpermitstatus');

        Route::post('ptw/general/aostatus/update', 'API\PTW\GeneralController@AOApproveRejectSubmit');
        Route::post('ptw/general/ghsestatus/update', 'API\PTW\GeneralController@GHSEApproveRejectSubmit');
        Route::post('ptw/general/sastatus/update', 'API\PTW\GeneralController@SAApproveRejectSubmit');
        Route::post('ptw/general/status/close', 'API\PTW\GeneralController@PTWCloseSubmit');

        Route::post('ptw/general/AOreassign/submit', 'PTW\GeneralController@AOReassignSubmit');
        Route::post('ptw/general/SAreassign/submit', 'PTW\GeneralController@SAReassignSubmit');

        /**
         * General PTW Routes
         */
        Route::post('ptw/general/list', 'API\PTW\GeneralController@list');
        Route::post('ptw/general/view', 'API\PTW\GeneralController@view');
        Route::post('ptw/general/status/update', 'API\PTW\GeneralController@statupupdate');

        /**
         * Gas PTW Routes
         */
        Route::post('ptw/gas/list', 'API\PTW\GasController@list');
        Route::post('ptw/gas/view', 'API\PTW\GasController@view');
        Route::post('ptw/gas/status/update', 'API\PTW\GasController@statupupdate');

        /**
         * Isolation PTW Routes
         */
        Route::post('ptw/isolation/list', 'API\PTW\IsolationController@list');
        Route::post('ptw/isolation/view', 'API\PTW\IsolationController@view');
        Route::post('ptw/isolation/status/update', 'API\PTW\IsolationController@statupupdate');

        /**
         * Surface PTW Routes
         */
        Route::post('ptw/surface/list', 'API\PTW\SurfaceController@list');
        Route::post('ptw/surface/view', 'API\PTW\SurfaceController@view');
        Route::post('ptw/surface/status/update', 'API\PTW\SurfaceController@statupupdate');

        /**
         * Hotwork PTW Routes
         */
        Route::post('ptw/hotwork/list', 'API\PTW\HotworkController@list');
        Route::post('ptw/hotwork/view', 'API\PTW\HotworkController@view');
        Route::post('ptw/hotwork/status/update', 'API\PTW\HotworkController@statupupdate');

        /**
         * Work Traffic PTW Routes
         */
        Route::post('ptw/worktraffic/list', 'API\PTW\WorkTrafficController@list');
        Route::post('ptw/worktraffic/view', 'API\PTW\WorkTrafficController@view');
        Route::post('ptw/worktraffic/status/update', 'API\PTW\WorkTrafficController@statupupdate');

        /**
         * Lifting PTW Routes
         */
        Route::post('ptw/lifting/list', 'API\PTW\LiftingController@list');
        Route::post('ptw/lifting/view', 'API\PTW\LiftingController@view');
        Route::post('ptw/lifting/status/update', 'API\PTW\LiftingController@statupupdate');

        /**
         * Diving PTW Routes
         */
        Route::post('ptw/diving/list', 'API\PTW\DivingController@list');
        Route::post('ptw/diving/view', 'API\PTW\DivingController@view');
        Route::post('ptw/diving/status/update', 'API\PTW\DivingController@statupupdate');



        /**
         * Machinery Management Routes
         */
        Route::post('machinery/machinery/list', 'API\MachineryController@list');
        Route::post('machinery/machinery/view', 'API\MachineryController@view');
        Route::get('machinery/machinery/statuslist', 'API\MachineryController@statuslist');

        /**
         * Inspection Management Routes
         */
        Route::post('inspection/inspection/list', 'API\InspectionController@list');
        Route::post('inspection/inspection/view', 'API\InspectionController@view');
        Route::post('inspection/inspection/create', 'API\InspectionController@create');
        Route::post('inspection/inspection/create/submit', 'API\InspectionController@createsubmit');
        Route::post('inspection/inspection/add', 'API\InspectionController@add');
        Route::post('inspection/inspection/add/submit', 'API\InspectionController@addsubmit');
        Route::get('inspection/inspection/statuslist', 'API\InspectionController@statuslist');

        /**
         * Chemical Management Routes
         */

        Route::post('chemical/list', 'API\Chemical\ChemicalController@list');
        Route::post('chemical/view', 'API\Chemical\ChemicalController@view');

        /**
         * Waste Management Routes
         */

        Route::post('wastemanagement/wasteregister/list', 'API\Waste\WasteRegisterController@list');
        Route::post('wastemanagement/wasteregister/view', 'API\Waste\WasteRegisterController@view');

        Route::post('wastemanagement/wastecard/list', 'API\Waste\WasteCardController@list');
        Route::post('wastemanagement/wastecard/view', 'API\Waste\WasteCardController@view');

        Route::post('wastemanagement/wasteinventory/list', 'API\Waste\WasteInventoryController@list');
        Route::post('wastemanagement/wasteinventory/view', 'API\Waste\WasteInventoryController@view');

        Route::post('wastemanagement/wasteinventory/add/list', 'API\Waste\WasteAddController@list');
        Route::post('wastemanagement/wasteinventory/add/view', 'API\Waste\WasteAddController@view');

        Route::post('wastemanagement/wasteinventory/disposal/list', 'API\Waste\WasteDisposalController@list');
        Route::post('wastemanagement/wasteinventory/disposal/view', 'API\Waste\WasteDisposalController@view');

        /**
         * HIRADC Management Routes
         */

        Route::post('hiradc/list', 'API\HIRADC\HIRADCController@list');
        Route::post('hiradc/view', 'API\HIRADC\HIRADCController@view');

        /**
         * Incident Management Routes
         */
        Route::post('incident/notification/list', 'API\Incident\IncidentNotificationController@list');
        Route::post('incident/notification/view', 'API\Incident\IncidentNotificationController@view');
        Route::get('incident/notification/add', 'API\Incident\IncidentNotificationController@add');
        Route::post('incident/notification/add/submit', 'API\Incident\IncidentNotificationController@addsubmit');
        Route::post('incident/notification/add', 'API\Incident\IncidentNotificationController@add');
        Route::post('incident/notification/add/submit', 'API\Incident\IncidentNotificationController@addsubmit');
        Route::get('incident/notification/statuslist', 'API\Incident\IncidentNotificationController@statuslist');


        /**
         * Announcement Master Routes
         */

        Route::post('announcement/list', 'API\AnnouncementController@list');
        Route::post('announcement/view', 'API\AnnouncementController@view');
    });
});
