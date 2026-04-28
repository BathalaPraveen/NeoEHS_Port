<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Chemical\ChemicalCategory;
use App\Models\Chemical\ChemicalItem;
use App\Models\Chemical\ChemicalList;
use App\Models\Chemical\ChemicalListDetails;
use App\Models\Chemical\ChemicalMaster;
use App\Models\Chemical\Supplier;
use App\Models\Chemical\ChemicalStatus;
use App\Models\Chemical\ChemicalStatusLog;
use App\Models\Chemical\HazardClassification;
use App\Models\Master\CompanyActivity;

if (!function_exists('chemicalStatus')) {

    function chemicalStatus($status)
    {
        $statusDetails = ChemicalStatus::find($status);

        switch ($status) {
            case "1":
                $status_name = '<span class="badge bg-primary" style="padding: 0.55em .4em; ">Supervisor Review - Pending</span>';
                break;
            case "2":
                $status_name = '<span class="badge bg-danger" style="padding: 0.55em .4em; ">Supervisor Review - Rejected</span>';
                break;
            case "3":
                $status_name = '<span class="badge bg-info" style="padding: 0.55em .4em; "> Acknowledgment - Pending</span>';
                break;
            case "4":
                $status_name = '<span class="badge bg-success" style="padding: 0.55em .4em; "> Acknowledgment  - Completed</span>';
                break;
            default:
                $status_name = "";
                break;
        }
        return $status_name;
    }
}

if (!function_exists('chemicalStatusName')) {

    function chemicalStatusName($status)
    {
        $statusDetails = ChemicalStatus::find($status);

        return  $statusDetails->chemical_status;
    }
}

if (!function_exists('getChemicalItem')) {

    function getChemicalItem($id)
    {
        $ids = string_to_array($id);
        $itemDetails = ChemicalItem::whereIn('id', $ids)->pluck('item_name')->toArray();

        $items = array_to_string($itemDetails, ", ");
        return $items;
    }
}


if (!function_exists('getHazardItem')) {

    function getHazardItem($id)
    {
        $ids = string_to_array($id);
        $itemDetails = HazardClassification::whereIn('id', $ids)->pluck('hazard_classification')->toArray();

        $items = array_to_string($itemDetails, ", ");
        return $items;
    }
}


if (!function_exists('getChemical')) {

    function getChemical($id)
    {
        $ids = string_to_array($id);
        $chemicalDetails = ChemicalMaster::whereIn('id', $ids)->pluck('chemical_name')->toArray();

        $chemical = array_to_string($chemicalDetails, ", ");
        return $chemical;
    }
}

if (!function_exists('getSupplier')) {

    function getSupplier($id)
    {
        $ids = string_to_array($id);
        $supplierDetails = Supplier::whereIn('id', $ids)->pluck('supplier_name')->toArray();

        $supplier = array_to_string($supplierDetails, ", ");
        return $supplier;
    }
}

if (!function_exists('getCompany_activity')) {

    function getCompany_activity($id)
    {
        $ids = string_to_array($id);
        $company_activity = CompanyActivity::whereIn('id', $ids)->pluck('activity_name')->toArray();

        $company_activity = array_to_string($company_activity, ", ");
        return $company_activity;
    }
}

if (!function_exists('getSupplierDetails')) {

    function getSupplierDetails($supplierId)
    {
        if (!$supplierId) {
            return null;
        }

        $supplier = Supplier::where('id', $supplierId)
            ->where('status', 1)
            ->select('id', 'supplier_name', 'address', 'contact_no')
            ->first();

        return $supplier ?: null;
    }
}

function Displayuocunit($uocunit)
{

    switch ($uocunit) {
        case "1":
            $status_name = 'Kg';
            break;
        case "2":
            $status_name = 'Tonne';
            break;
        case "3":
            $status_name = 'Litre';
            break;
        default:
            $status_name = "";
            break;
    }

    return $status_name;
}

