<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\Inspection\InspectionStatus;
use App\Models\Inspection\InspectionType;
use App\Models\Inspection\JettyLocation;

if (!function_exists('inspectionStatus')) {

    function inspectionStatus($status)
    {
        $statusDetails = InspectionStatus::find($status);

        return  '<span class="' . $statusDetails->bg_color . '">' . $statusDetails->status_name  . '</span>';
    }
}

if (!function_exists('inspectionStatusText')) {

    function inspectionStatusText($status)
    {
        $statusDetails = InspectionStatus::find($status);

        return   $statusDetails->status_name;
    }
}

if (!function_exists('inspectionStatusColorcode')) {

    function inspectionStatusColorcode($status)
    {
        $colorcode = '6c757d';

        switch ($status) {
            case MACHINERY_STATUS_GHSE_APPROVE_PENDING:
                $colorcode = '6c757d';
            case MACHINERY_STATUS_GHSE_REJECTED:
                $colorcode = 'dc3545';
            case MACHINERY_STATUS_HSE_INSP_PENDING:
                $colorcode = '0dcaf0';
            case MACHINERY_STATUS_HSE_INSP_REJECTED:
                $colorcode = 'dc3545';
            case MACHINERY_STATUS_TAG_ISSUED:
                $colorcode = '0dcaf0';
            case MACHINERY_STATUS_ACTIVE:
                $colorcode = '198754';
            case MACHINERY_STATUS_EXPIRED:
                $colorcode = 'dc3545';
        }

        return   $colorcode;
    }
}

if (!function_exists('getInspectionTypedetails')) {

    function getInspectionTypedetails($id)
    {
        $insptypeDetails = InspectionType::find($id);

        return   $insptypeDetails;
    }
}

if (!function_exists('getJettyLocation')) {

    function getJettyLocation($id)
    {
        $jettydetails = JettyLocation::find($id);

        if( $jettydetails  == '' ||  $jettydetails  == null){
            $returnArray = array(
                'location' => '' ,
                'image' => '' ,
            );
        }else{
            $returnArray = array(
                'location' => $jettydetails->jetty_location ,
                'image' => $jettydetails->layout_image ,
            );
        }


        return   $returnArray;
    }
}


