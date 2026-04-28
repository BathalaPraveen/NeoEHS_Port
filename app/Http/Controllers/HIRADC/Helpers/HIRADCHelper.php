<?php

use Illuminate\Support\Facades\DB;
use App\Models\HIRADC\ProcessTypeDetails;
use App\Models\HIRADC\RiskMatrix;
use App\Models\HIRADC\ProcessType;

if (!function_exists('hazardriskcolor')) {

    function hazardriskcolor($rating)
    {
        $riskrating =  RiskMatrix::where('rating', $rating)->first();

        return $riskrating->color_code;
    }
}

if (!function_exists('getProcesstypeId')) {

    function getProcesstypeId($name)
    {
        $processtype =  ProcessType::where('process_type_name', $name)->first();

        return $processtype->id;
    }
}


if (!function_exists('mainStatus')) {

    function mainStatus($id)
    {

        $status = '';

        switch ($id) {
            case "1":
                $status = '<span class="badge bg-info text-dark">Pending</span>';
                break;
            case "2":
                $status = '<span class="badge bg-success">Approved</span>';
                break;
            case "3":
                $status = '<span class="badge bg-danger">Rejected</span>';
                break;
        }
        return  $status;
    }
}

if (!function_exists('mainStatusName')) {

    function mainStatusName($id)
    {

        $status = '';

        switch ($id) {
            case "1":
                $status = 'Pending';
                break;
            case "2":
                $status = 'Approved';
                break;
            case "3":
                $status = 'Rejected';
                break;
        }
        return  $status;
    }
}

if (!function_exists('mainStatusColor')) {

    function mainStatusColor($id)
    {

        $status = '';

        switch ($id) {
            case "1":
                $status = '17a2b8';
                break;
            case "2":
                $status = '28a745';
                break;
            case "3":
                $status = 'dc3545';
                break;
        }
        return  $status;
    }
}

if (!function_exists('hazardriskLevel')) {

    function hazardriskLevel($rating)
    {
        if ($rating <= 4) {
            $level = 'L';
        } else if ($rating <= 12) {
            $level = 'M';
        } else if ($rating > 12) {
            $level = 'H';
        }

        return $level;
    }
}

if (!function_exists('getProcesstypeId')) {

    function getProcesstypeId($name)
    {
        $processtype =  ProcessType::where('process_type_name', $name)->first();

        return $processtype->id;
    }
}

if (!function_exists('getProcesstypeId')) {

    function getProcesstypeId($name)
    {
        $processtype =  ProcessType::where('process_type_name', $name)->first();

        return $processtype->id;
    }
}

if (!function_exists('getProcesstypeId')) {

    function getProcesstypeId($name)
    {
        $processtype =  ProcessType::where('process_type_name', $name)->first();

        return $processtype->id;
    }
}

if (!function_exists('getProcesstypeId')) {

    function getProcesstypeId($name)
    {
        $processtype =  ProcessType::where('process_type_name', $name)->first();

        return $processtype->id;
    }
}
