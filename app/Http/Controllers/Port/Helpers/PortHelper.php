<?php

use App\Models\Port\SecurityMaster;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('getsequenceforport')) {

    function getsequenceforport($type)
    {
        switch ($type) {
            case 'port_unique_id':
                $count = SecurityMaster::withoutGlobalScopes()->count();
                $count = $count + 1;
                $sequence = 'PORT-' . getautogen($count);
                break;
            default:
                $sequence = Str::random(5);
                break;
        }
        return $sequence;
    }
}