<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\Machinery\MachineryStatus;



if (!function_exists('machhineryStatus')) {

    function machhineryStatus($status)
    {
        $statusDetails = MachineryStatus::find($status);

        return  '<span class="' . $statusDetails->bg_color . '">' . $statusDetails->status_name  . '</span>';
    }
}

if (!function_exists('machhineryStatusText')) {

    function machhineryStatusText($status)
    {
        $statusDetails = MachineryStatus::find($status);

        return   $statusDetails->status_name;
    }
}

if (!function_exists('machhineryStatusColorcode')) {

    function machhineryStatusColorcode($status)
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
