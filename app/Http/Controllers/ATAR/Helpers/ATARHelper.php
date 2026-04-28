<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\Master\Location;
use App\Models\ATAR\UAUC;
use App\Models\ATAR\Infringement;
use App\Models\ATAR\AtarTypes;
use App\Models\ATAR\HSEHazard;
use App\Models\ATAR\ZefaRules;

/**
 * UAUC Status Count
 */

if (!function_exists('uaucStatusCount')) {

    function uaucStatusCount($type = '')
    {
        $uauc = new UAUC();

        if( CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_AREA_OWNER) || CheckUserRole(ROLE_SUPERVISING_AUTHORITY) || CheckUserRole(ROLE_HSEUSER) || CheckUserRole(ROLE_JOBOWNER) ) {

        }else{
            $uauc->where('created_by', Auth::id());
        }

        return $uauc->statusCount($type);
    }
}


/**
 * UAUC Chart data
 */

if (!function_exists('UAUCChart')) {

    function UAUCChart()
    {
        $uauc = new UAUC();
        $chartData =  $uauc->chartData();

        $locationDetails = Location::get();

        $chartDataArray = [];

        if (count($chartData) > 0) {

            foreach ($chartData as $data) {
                $chartDataArray[$data->location_name][$data->atar_type] = $data->count;
            }
        }

        $finalChartData = [];
        $safeact = [];
        $safecont = [];
        $unsafeact = [];
        $unsafecont = [];
        foreach ($locationDetails as $location) {

            $locationName = $location->location_name;
            $finalChartData['label'][] = $locationName;

            /**
             * Safe Act
             */
            if (isset($chartDataArray[$locationName][UAUC_SA_NAME])) {
                $safeact[] = $chartDataArray[$locationName][UAUC_SA_NAME];
            } else {
                $safeact[] = 0;
            }

            /**
             * Safe Condition
             */
            if (isset($chartDataArray[$locationName][UAUC_SC_NAME])) {
                $safecont[] = $chartDataArray[$locationName][UAUC_SC_NAME];
            } else {
                $safecont[] = 0;
            }

            /**
             * Safe Act
             */
            if (isset($chartDataArray[$locationName][UAUC_USA_NAME])) {
                $unsafeact[] = $chartDataArray[$locationName][UAUC_USA_NAME];
            } else {
                $unsafeact[] = 0;
            }

            /**
             * Safe Condition
             */
            if (isset($chartDataArray[$locationName][UAUC_USC_NAME])) {
                $unsafecont[] = $chartDataArray[$locationName][UAUC_USC_NAME];
            } else {
                $unsafecont[] = 0;
            }
        }

        // $finalChartData['data']['safeact']['name'] = UAUC_SA_NAME;
        $finalChartData['data']['safeact']['data'] = $safeact;

        //$finalChartData['data']['safecont']['name'] = UAUC_SC_NAME;
        $finalChartData['data']['safecont']['data'] = $safecont;

        // $finalChartData['data']['unsafeact']['name'] = UAUC_USA_NAME;
        $finalChartData['data']['unsafeact']['data'] = $unsafeact;

        // $finalChartData['data']['unsafecont']['name'] = UAUC_USC_NAME;
        $finalChartData['data']['unsafecont']['data'] = $unsafecont;

        return $finalChartData;
    }
}

if (!function_exists('getinfrIngementName')) {

    function getinfrIngementName($id)
    {
        $data = Infringement::find($id);
        return $data->infringement_no . " - " . $data->type_of_infringement;
    }
}

if (!function_exists('getuauccategoryname')) {

    function getuauccategoryname($id)
    {
        $uauccategory = new AtarTypes();
        $categoryname =   $uauccategory->find($id);

        return $categoryname->atar_type;
    }
}

if (!function_exists('getHscHazardname')) {

    function getHscHazardname($id)
    {
        $HscHazard = new HSEHazard();
        $HscHazardname =   $HscHazard->find($id);

        return $HscHazardname->hse_hazard;
    }
}

if (!function_exists('getinfringementName')) {
    function getinfringementName($id)
    {
        $infringement = Infringement::find($id);

        return $infringement ? $infringement->type_of_infringement : 'Unknown Infringement';
    }
}

if (!function_exists('getZefaName')) {
    function getZefaName($id)
    {

        $HscHazard = new HSEHazard();
        $HscHazardname =   $HscHazard->find($id);

        $id = $HscHazardname->zefa_rule;

        $zefa = ZefaRules::find($id);

        return $zefa ? $zefa->zefa_rule : 'Unknown zefa';
    }
}
