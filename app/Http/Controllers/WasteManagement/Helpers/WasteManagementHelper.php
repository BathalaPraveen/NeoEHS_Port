<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;

use App\Models\WasteManagement\WasteStatus;
use App\Models\WasteManagement\WasteStatusLog;
use App\Models\WasteManagement\WasteItem;
use App\Models\WasteManagement\DisposalType;

use App\Models\Master\Company;

if (!function_exists('wasteStatus')) {

    function wasteStatus($status)
    {
        $statusDetails = WasteStatus::find($status);

        return  '<span class="' . $statusDetails->bg_colors . '">' . $statusDetails->waste_status  . '</span>';
    }
}

if (!function_exists('getCompanyId')) {

    function getCompanyId($companyname)
    {
        $companyname = strtoupper($companyname);
        $companyDetails = Company::where('company_shortname',$companyname)->first();
        if($companyDetails){
            return $companyDetails->id;
        }
        return null;
    }
}

if (!function_exists('getItemName')) {

    function getItemName($id)
    {

        $Itemdetails = WasteItem::where('id',$id)->first();

        return $Itemdetails?->item_name  ;

    }
}

if (!function_exists('getpackageName')) {

    function getpackageName($id)
    {

        $packagedetails = DisposalType::where('id',$id)->first();

        return $packagedetails?->disposaltype_name;

    }
}


if (!function_exists('getpackageweight')) {

    function getpackageweight($id)
    {

        $packagedetails = DisposalType::where('id',$id)->first();

        return $packagedetails->packaging_capacity;

    }
}
