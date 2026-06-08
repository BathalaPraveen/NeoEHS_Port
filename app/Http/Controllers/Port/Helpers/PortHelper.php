<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;



if (!function_exists('getIdType')) {

    function getIdType($id)
    {
        $id_type = '';

        switch ($id) {
            case 1:
                $id_type = 'IC NO';
                break;
            case 2:
                $id_type = 'Passport No';
                break;
        }
        return $id_type;
    }
}





















if (!function_exists('incidentStatus')) {

    function incidentStatus($id)
    {

        $status = '';

        switch ($id) {
            case INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING:
                $status = '<span class="badge bg-info">Pending</span>';
                break;
            case INCIDENT_NOTIFICATION_STATUS_GHSE_APPROVED:
                $status = '<span class="badge bg-success">Approved</span>';
                break;
            case INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED:
                $status = '<span class="badge bg-danger">Rejected</span>';
                break;
            case INCIDENT_INVESTIGATION_NEARMISS_ADDED:
                $status = '<span class="badge bg-success">NearMiss Added</span>';
                break;
        }
        return  $status;
    }
}

if (!function_exists('incidentStatusText')) {

    function incidentStatusText($id)
    {

        $status = '';

        switch ($id) {
            case INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING:
                $status = 'Pending';
                break;
            case INCIDENT_NOTIFICATION_STATUS_GHSE_APPROVED:
                $status = 'Approved';
                break;
            case INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED:
                $status = 'Rejected';
                break;
            case INCIDENT_INVESTIGATION_NEARMISS_ADDED:
                $status = '>NearMiss Added';
                break;
        }
        return  $status;
    }
}



if (!function_exists('getIncidentCategoryName')) {

    function getIncidentCategoryName($id)
    {

        $category = IncidentCategory::find($id);
        $category_name = $category->category_name;
        return $category_name;
    }
}


if (!function_exists('getIncidentItemName')) {

    function getIncidentItemName($id)
    {
        $item = IncidentItem::find($id);
        $item_name = $item?->item_name;
        return $item_name;
    }
}

if (!function_exists('getIncidentItemSubName')) {

    function getIncidentItemSubName($id)
    {
        $item = IncidentItem::find($id);
        $item_name = $item?->item_name;
        return $item_name;
    }
}


if (!function_exists('getIncidentTypeName')) {

    function getIncidentTypeName($id)
    {
        $incident_type = '';

        switch ($id) {
            case 1:
                $incident_type = 'Near Miss';
                break;
            case 2:
                $incident_type = 'Accident';
                break;
        }
        return $incident_type;
    }
}


if (!function_exists('incidentInvestigationStatus')) {

    function incidentInvestigationStatus($id)
    {

        $status = '';

        switch ($id) {
            case INCIDENT_INVESTIGATION_STATUS_NOT_ASSIGNED:
                $status = '<span class="badge bg-info">Not Assigned</span>';
                break;
            case INCIDENT_INVESTIGATION_STATUS_PENDING:
                $status = '<span class="badge bg-info">Investigation Pending</span>';
                break;
            case INCIDENT_INVESTIGATION_STATUS_INVESTIGATION_COMPLETED:
                $status = '<span class="badge bg-success">Investigation Completed</span>';
                break;
            case INCIDENT_INVESTIGATION_STATUS_GHSE_APPROVED:
                $status = '<span class="badge bg-success">Approved</span>';
                break;
            case INCIDENT_NOTIFICATION_STATUS_GHSE_REJECTED:
                $status = '<span class="badge bg-danger">Rejected</span>';
                break;
            case INCIDENT_INVESTIGATION_NEARMISS_ADDED:
                $status = '<span class="badge bg-success">NearMiss Added</span>';
                break;
        }
        return  $status;
    }
}
