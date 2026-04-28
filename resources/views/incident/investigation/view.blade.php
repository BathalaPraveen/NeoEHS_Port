@extends('admin.layouts.layout')
@section('title', 'Incident View')
@section('pageurl', admin_url('incident/investigation/nearmiss'))

@push('style')
    <style>
        label {
            font-weight: bold;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Incident
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('incident/investigation/list') }}">Incident List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Incident View</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body">
                            <div class="d-lg-flex align-items-center gap-3">
                                <div class="position-relative">
                                    <h5 class="card-title">Incident View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('incident/investigation/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">
                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART A : REPORT SUMMARY</h6>
                                        </div>

                                        <div class="content-block-body">

                                            <div class="row g-3 px-4 pt-4 form-input content-block-row">

                                                <div class="col-md-4 form-input all">
                                                    <label for="incident_date" class="form-label require">Incident
                                                        Date</label>
                                                    <div>
                                                        {{ displayDateformat($investigation->incident_date) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-input all">
                                                    <label for="incident_time" class="form-label require">Incident
                                                        Time</label>
                                                    <div>
                                                        {{ $investigation->incident_time }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="col-md-4 form-input">
                                                <label for="company" class="form-label require">Company</label>
                                                <div>
                                                    {{ getCompanyName($investigation->company_id) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="" class="form-label require">Location</label>
                                                <div>
                                                    {{ getLocationName($investigation->location_id) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="specific_location" class="form-label require">Specific
                                                    Location</label>
                                                <div>
                                                    {{ getSpecificLocationName($investigation->specific_location_id) }}
                                                </div>
                                            </div>
                                        </div>

                                        @if ($nearMissDetails != null && $nearMissDetails != '')
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="col-md-4 form-input">
                                                    <label for="employee_involved" class="form-label require">Employee
                                                        Involved</label>
                                                    <p>{{ $nearMissDetails->employee_involved }}</p>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="immediate_supervisor" class="form-label require">Immediate
                                                        Supervisor</label>
                                                    <p>{{ $nearMissDetails->immediate_supervisor }}</p>

                                                </div>
                                            </div>
                                        @endif

                                        @if ($accidentDetails != null && $accidentDetails != '')
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-4 form-input minor">
                                                    <label for="" class="form-label require">Employee
                                                        Involved</label>
                                                    <p>{{ $accidentDetails->employee_involved }}</p>
                                                </div>

                                                <div class="col-md-4 form-input minor">
                                                    <label for="witness" class="form-label require">Witness</label>
                                                    <p>{{ $accidentDetails->witness }}</p>

                                                </div>
                                                <div class="col-md-4 form-input minor">
                                                    <label for="immediate_supervisor" class="form-label require">Immediate
                                                        Supervisor</label>
                                                    <p>{{ $accidentDetails->immediate_supervisor }}</p>

                                                </div>
                                                <div class="col-md-4 form-input minor">
                                                    <label for="immediate_action_taken" class="form-label require">Immediate
                                                        Action
                                                        Taken</label>
                                                    <p>{{ $accidentDetails->immediate_action_taken }}</p>

                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <hr>
                                </div>
                                @if ($investigation_details->investigator_company != null && $investigation_details->investigator_company != '')
                                    <div class="accident-block">
                                        <div class=" border rounded ">
                                            <div class="">
                                                <div class="content-block">
                                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                                        <h6 class="text-white">Assigned User</h6>
                                                    </div>

                                                    <div class="content-block-body">

                                                        <div class="row g-3 px-4 pt-4 content-block-row all">

                                                            <div class="col-md-4 form-input">
                                                                <label for="company"
                                                                    class="form-label require">Company</label>
                                                                <p>{{ getcompanyName($investigation_details->investigator_company) }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 form-input">
                                                                <label for="division"
                                                                    class="form-label require">Division</label>
                                                                <p>{{ getdivisionName($investigation_details->investigator_division) }}
                                                                </p>

                                                            </div>

                                                            <div class="col-md-4 form-input">
                                                                <label for="department"
                                                                    class="form-label require">Department</label>
                                                                <p>{{ getdepartmentName($investigation_details->investigator_department) }}
                                                                </p>

                                                            </div>

                                                            <div class="col-md-4 form-input">
                                                                <label for="user"
                                                                    class="form-label require">User</label>
                                                                <p>{{ getusername($investigation_details->investigator_id) }}
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <div class="content-block">

                                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                                        <h6 class="text-white">Assigned By </h6>
                                                    </div>

                                                    <div class="content-block-body">
                                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                                            <div class="col-md-4 form-input">
                                                                <label for="incidenttime"
                                                                    class="form-label require">Name</label>
                                                                <p>{{ getuser($investigation_details->created_by)->name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 form-input">
                                                                <label for="incidenttime"
                                                                    class="form-label require">Designation</label>
                                                                <p>{{ getuser($investigation_details->created_by)->user_designation_name }}
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4 form-input">
                                                                <label for="incidenttime" class="form-label require">Date
                                                                    and
                                                                    Time</label>
                                                                <p>{{ displaydateformat($investigation_details->created_at) }}
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($nearMissDetails != null && $nearMissDetails != '')
                                    <div class="nearmiss-block">
                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART B : INFORMATION</h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-12 form-input">
                                                        <label for="description_of_hazard"
                                                            class="form-label require">Description of
                                                            Hazard</label>
                                                        <p>{{ $nearMissDetails->description_of_hazard }}</p>

                                                    </div>
                                                    <div class="col-md-12 form-input">
                                                        <label for="immediate_action" class="form-label require">Immediate
                                                            Action</label>
                                                        <p>{{ $nearMissDetails->immediate_action }}</p>

                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="nearmiss_status"
                                                            class="form-label require">Status</label>

                                                        <p>{{ getNearMissStatus($nearMissDetails->nearmiss_status) }}</p>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART D : CORRECTIVE ACTION</h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-12 form-input">
                                                        <label for="action_taken" class="form-label require">Action
                                                            Taken</label>
                                                        <p>{{ $nearMissDetails->action_taken }}</p>

                                                    </div>
                                                    {{-- <div class="col-md-4 form-input">
                                                        <label for="status" class="form-label require">Action Parties</label>
                                                        <select name="status" id="status"
                                                            class="form-control select2">
                                                            <option value="">Select Action Parties</option>
                                                            <option value="1">Test</option>
                                                        </select>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART C : NEAR MISS REPORTING (Root Cause Analysis)
                                                </h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="mt-1 content-block-header"
                                                        style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                        <div class="d-lg-flex align-items-center ">
                                                            <div class="position-relative">
                                                                <h6 class="text-black">Why</h6>
                                                            </div>
                                                            {{-- <div class="ms-auto">
                                                                <button class="btn btn-primary" type="button" id="addmore">Add</button>
                                                            </div> --}}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 border p-3 pt-4">
                                                        <p class="text-center">{{ $why_why_analysis[0] }}</p>
                                                    </div>
                                                    @foreach ($why_why_analysis as $key => $why)
                                                        <div class="col-md-12 "
                                                            style="text-align: center;font-size: 40px;">
                                                            <div class="arraow-div"><i class="fas fa-arrow-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 border p-3 pt-4">
                                                            <p class="text-center">{{ $why_why_analysis[$key] }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="row g-3 px-4 pt-4 content-block-row">
                                                        <div class="col-md-12">
                                                            <label for="root_cause" class="form-label require">Root
                                                                Cause</label>
                                                            <p>{{ $nearMissDetails->root_cause }}</p>

                                                        </div>
                                                    </div>
                                                    <div class="row g-3 px-4 pt-4 content-block-row">
                                                        <div class="col-md-3 form-input">
                                                            <label for="root_cause_category"
                                                                class="form-label require">Root
                                                                Cause Category</label>
                                                            <p>{{ getIncidentItemSubName($nearMissDetails->root_cause_category) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="content-block">

                                                <div class="card-header card-header-inner mt-3 content-block-header">
                                                    <h6 class="text-white">PART E : REPORTER </h6>
                                                </div>

                                                <div class="content-block-body">
                                                    <div class="row g-3 px-4 pt-4 content-block-row">
                                                        <div class="col-md-4 form-input">
                                                            <label for="incidenttime"
                                                                class="form-label require">Name</label>
                                                            <p>{{ getuser($nearMissDetails->created_by)->name }}</p>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="incidenttime"
                                                                class="form-label require">Designation</label>
                                                            <p>{{ getuser($nearMissDetails->created_by)->user_designation_name }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="incidenttime" class="form-label require">Date and
                                                                Time</label>
                                                            <p>{{ displaydateformat($nearMissDetails->created_at) }}</p>
                                                        </div>
                                                        <div class="col-md-12 form-input">
                                                            <label for="investigation_remarks"
                                                                class="form-label require">Investigation
                                                                Remarks</label>
                                                            <p>{{ $nearMissDetails->investigation_remarks }}</p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($accidentDetails != null && $accidentDetails != '')

                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART B : INCIDENT DESCRIPTION</h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row all">

                                                <div class="col-md-12 form-input">
                                                    <label for="brief_description" class="form-label require">Brief
                                                        Description</label>
                                                    <p>{{ $accidentDetails->brief_description }}</p>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART C : SEQUENCE OF EVENTS</h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="col-md-6 minor form-input">
                                                    <label for="initial_activity" class="form-label require">Initial
                                                        Activity</label>
                                                    <p>{{ $accidentDetails->initial_activity }}</p>
                                                </div>
                                                <div class="col-md-6 minor form-input">
                                                    <label for="incident_occurrence" class="form-label require">Incident
                                                        Occurrence</label>
                                                    <p>{{ $accidentDetails->incident_occurrence }}</p>
                                                </div>
                                                <div class="col-md-6 minor form-input">
                                                    <label for="immediate_response" class="form-label require">Immediate
                                                        Response</label>
                                                    <p>{{ $accidentDetails->immediate_response }}</p>
                                                </div>
                                                <div class="col-md-6 all form-input">
                                                    <label for="injury_assessment" class="form-label require">Injury
                                                        Assessment
                                                        (if applicable)</label>
                                                    <p>{{ $accidentDetails->injury_assessment }}</p>
                                                </div>
                                                <div class="col-md-4 form-input major">
                                                    <label for="" class="form-label require">No of MC</label>
                                                    <p>{{ $accidentDetails->no_of_mc }}</p>
                                                </div>
                                                <div class="col-md-12 all">
                                                    <label for="" class="form-label require">Property Damage
                                                        Assessment</label>
                                                    <div class="row">
                                                        <div class="col-md-4 form-input">
                                                            <label for="type_of_asset" class="form-label require">Type of
                                                                Asset</label>
                                                            <p>{{ $accidentDetails->type_of_asset }}</p>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="owner_of_the_property"
                                                                class="form-label require">Owner of
                                                                the property</label>
                                                            <p>{{ $accidentDetails->owner_of_the_property }}</p>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="estimated_cost"
                                                                class="form-label require">Estimated
                                                                cost</label>
                                                            <p>{{ $accidentDetails->estimated_cost }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 minor form-input">
                                                    <label for="witness_statements" class="form-label require">Witness
                                                        Statements</label>
                                                    <p>{{ $accidentDetails->witness_statements }}</p>
                                                </div>
                                                <div class="col-md-6 minor form-input">
                                                    <label for="supervisor_account"
                                                        class="form-label require">Supervisor's
                                                        Account</label>
                                                    <p>{{ $accidentDetails->supervisor_account }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block minor">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART D : TIMELINE OF EVENTS</h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="col-md-4 form-input ">
                                                    <label for="tl_incident_date" class="form-label require">Incident
                                                        Date</label>
                                                    <div class="input-group date">
                                                        <p>{{ displaydateformat($accidentDetails->tl_incident_date) }}</p>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="tl_incident_start_time"
                                                        class="form-label require">Incident Start
                                                        Time</label>
                                                    <div class="input-group date">
                                                        <p>{{ $accidentDetails->tl_incident_start_time }}</p>

                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="tl_incident_time" class="form-label require">Incident
                                                        Happen
                                                        Time</label>
                                                    <div class="input-group date">
                                                        <p>{{ $accidentDetails->tl_incident_time }}</p>

                                                    </div>
                                                </div>

                                                <div class="col-md-12 form-input">
                                                    <label for="chronology_sequence" class="form-label require">Chronology
                                                        sequence</label>
                                                    <p>{{ $accidentDetails->chronology_sequence }}</p>

                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block minor">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART E : CONTRIBUTING FACTORS </h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="col-md-12 form-input">
                                                    <label for="environment_conditions"
                                                        class="form-label require">Environment
                                                        Conditions</label>
                                                    <p>{{ $accidentDetails->environment_conditions }}</p>

                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="equipment_tools" class="form-label require">Equipment &
                                                        Tools</label>
                                                    <p>{{ $accidentDetails->equipment_tools }}</p>

                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="employee_actions" class="form-label require">Employee
                                                        Actions</label>
                                                    <p>{{ $accidentDetails->employee_actions }}</p>

                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="training_procedures" class="form-label require">Training &
                                                        Procedures</label>
                                                    <p>{{ $accidentDetails->training_procedures }}</p>

                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block all">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART F : ROOT CAUSE ANALYSIS </h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-12 form-input">
                                                    <label for="underlying_cause" class="form-label require">Underlying
                                                        cause</label>
                                                    <p>{{ $accidentDetails->underlying_cause }}</p>

                                                </div>
                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-3 form-input">
                                                    <label for="root_cause_category" class="form-label require">Root Cause
                                                        Category</label>
                                                    <p>{{ getIncidentItemSubName($accidentDetails->root_cause_category) }}
                                                    </p>

                                                </div>
                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-12 form-input">
                                                    <label for="root_cause_details"
                                                        class="form-label require">Details</label>
                                                    <p>{{ $accidentDetails->root_cause_details }}</p>

                                                </div>
                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-12 form-input">
                                                    <label for="root_cause_recommendation"
                                                        class="form-label require">Recommendation</label>
                                                    <p>{{ $accidentDetails->root_cause_recommendation }}</p>

                                                </div>
                                            </div>

                                            @foreach ($action_parties_company as $key => $company)
                                                <div class="row g-3 px-4 pt-4 form-input content-block-row">


                                                    <div class=""
                                                        style="background: skyblue;padding: 10px;font-weight: bold;">
                                                        Action Parties
                                                    </div>

                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row">

                                                    <div class="col-md-4 form-input">
                                                        <label for="action_parties_company"
                                                            class="form-label require">Company</label>
                                                        <p>{{ getcompanyName(decryptId($action_parties_company[$key])) }}
                                                        </p>

                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="action_parties_location"
                                                            class="form-label require">Location</label>
                                                        <p>{{ getLocationName(decryptId($action_parties_location[$key])) }}
                                                        </p>

                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="action_parties_specific_location"
                                                            class="form-label require">Specific
                                                            Location</label>
                                                        <p>{{ getSpecificLocationName(decryptId($action_parties_specific_location[$key])) }}
                                                        </p>

                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="division" class="form-label require">Division
                                                            Name</label>
                                                        <p>{{ getdivisionName(decryptId($division[$key])) }}</p>

                                                    </div>


                                                    <div class="col-md-4 form-input">
                                                        <label for="department" class="form-label require">Department
                                                            Name</label>
                                                        <p>{{ getdepartmentName(decryptId($department[$key])) }}</p>

                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="user" class="form-label require">User</label>
                                                        <p>{{ getusername(decryptId($user[$key])) }}</p>

                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block all">

                                        <div class="card-header card-header-inner mt-3 content-block-header">

                                            <div class="d-lg-flex align-items-center ">

                                                <div class="position-relative">
                                                    <h6 class="text-white">PART G : Lesson Learned</h6>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-12">
                                                    <label for="specific_location"
                                                        class="form-label require">Details</label>
                                                </div>
                                                <div class="row" id="lesson_learned_block">
                                                    <div class="lesson_learned_row">
                                                        <div class="row">
                                                            @foreach ($lesson_learned_details as $lesson_learned_detail)
                                                                <div class="col-md-11 form-input">
                                                                    <p>{{ $lesson_learned_detail }}</p>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block minor">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART H : Conclusion </h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                @foreach ($conclusion_details as $conclusion)
                                                    <div class="col-md-12 form-input">
                                                        <label for="conclusion_details"
                                                            class="form-label require">Details</label>
                                                        <p>{{ $conclusion }}</p>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="content-block all">

                                        <div class="card-header card-header-inner mt-3 content-block-header">

                                            <div class="d-lg-flex align-items-center ">
                                                <div class="position-relative">
                                                    <h6 class="text-white">PART I : Appendicies</h6>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row " id="appendicies_block">

                                                <div class="col-md-4 form-input appendicies_row">
                                                    <div class="row">

                                                        @if (count($appendicies_file) > 0)
                                                            <div class="row mt-2">
                                                                <div class="col-md-3 bold block">
                                                                    Uploads
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        @foreach ($appendicies_file as $file)
                                                                            <div class="col-md-9 form-input image-box">
                                                                                @php
                                                                                    $extension = strtolower(
                                                                                        $file->file_extension,
                                                                                    );
                                                                                @endphp

                                                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                    <a href="{{ url($file->file_path) }}"
                                                                                        data-lightbox="final">
                                                                                        <img src="{{ url($file->file_path) }}"
                                                                                            alt="Uploaded Image"
                                                                                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                    </a>
                                                                                @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                    <video width="100%" controls>
                                                                                        <source
                                                                                            src="{{ url($file->file_path) }}"
                                                                                            type="video/{{ $extension }}">
                                                                                        Your browser does not support the
                                                                                        video tag.
                                                                                    </video>
                                                                                @elseif (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                    <a href="{{ url($file->file_path) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-primary btn-sm">
                                                                                        View Document
                                                                                        ({{ strtoupper($extension) }})
                                                                                    </a>
                                                                                @else
                                                                                    <a href="{{ url($file->file_path) }}"
                                                                                        download
                                                                                        class="btn btn-dark btn-sm">
                                                                                        Download File
                                                                                        ({{ strtoupper($extension) }})
                                                                                    </a>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-block all">
                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <div class="d-lg-flex align-items-center ">
                                                <div class="position-relative">
                                                    <h6 class="text-white">PART J : Document Submission</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Tripod Beta Report</h6>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div id="tripod_beta_report_block" class="row">
                                                    <div class="col-md-4 tripod_beta_report_row">
                                                        <div class="row">

                                                            @if (count($tripod_beta_report_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($tripod_beta_report_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif


                                                        </div>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Witness Statements</h6>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div id="witness_statements_block" class="row">
                                                    <div class="col-md-4 witness_statements_row">
                                                        <div class="row">

                                                            @if (count($witness_statements_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($witness_statements_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif


                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Photos or Videos</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="photo_videos_block" class="row">
                                                    <div class="col-md-4 photo_videos_row">
                                                        <div class="row">

                                                            @if (count($photo_videos_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($photo_videos_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Equipment Inspection Records (if
                                                                applicable)</h6>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div id="equipment_inspection_block" class="row">
                                                    <div class="col-md-4 equipment_inspection_row">
                                                        <div class="row">

                                                            @if (count($equipment_inspection_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($equipment_inspection_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Training Records (if applicable)
                                                            </h6>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div id="training_records_block" class="row">
                                                    <div class="col-md-4 training_records_row">
                                                        <div class="row">

                                                            @if (count($training_records_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($training_records_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="mt-1 content-block-header"
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">

                                                    <div class="d-lg-flex align-items-center ">

                                                        <div class="position-relative">
                                                            <h6 class="text-black">Others</h6>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div id="other_records_block" class="row">
                                                    <div class="col-md-4 other_records_row">
                                                        <div class="row">

                                                            @if (count($other_records_files) > 0)
                                                                <div class="row mt-2">
                                                                    <div class="col-md-3 bold block">
                                                                        Uploads
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            @foreach ($other_records_files as $file)
                                                                                <div class="col-md-9 form-input image-box">
                                                                                    @php
                                                                                        $extension = strtolower(
                                                                                            $file->file_extension,
                                                                                        );
                                                                                    @endphp

                                                                                    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            data-lightbox="final">
                                                                                            <img src="{{ url($file->file_path) }}"
                                                                                                alt="Uploaded Image"
                                                                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                                        </a>
                                                                                    @elseif(in_array($extension, ['mp4', 'webm', 'ogg']))
                                                                                        <video width="100%" controls>
                                                                                            <source
                                                                                                src="{{ url($file->file_path) }}"
                                                                                                type="video/{{ $extension }}">
                                                                                            Your browser does not support
                                                                                            the
                                                                                            video tag.
                                                                                        </video>
                                                                                    @elseif(in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'pdf']))
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            target="_blank"
                                                                                            class="btn btn-primary btn-sm">
                                                                                            View Document
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="{{ url($file->file_path) }}"
                                                                                            download
                                                                                            class="btn btn-dark btn-sm">
                                                                                            Download File
                                                                                            ({{ strtoupper($extension) }})
                                                                                        </a>
                                                                                    @endif
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART K : Created By </h6>
                                        </div>

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime" class="form-label require">Name</label>

                                                    <p>{{ getuser($accidentDetails->created_by)->name }}</p>

                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime"
                                                        class="form-label require">Designation</label>

                                                    <p>{{ getuser($accidentDetails->created_by)->user_designation_name }}
                                                    </p>

                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime" class="form-label require">Date and
                                                        Time</label>

                                                    <p>{{ displaydateformat($accidentDetails->created_at) }}</p>

                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="investigation_remarks"
                                                        class="form-label require">Investigation
                                                        Remarks</label>
                                                    <p>{{ $accidentDetails->investigation_remarks }}</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                                @if (count($statuslogs) > 0)
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Status Log</h6>
                                    </div>
                                    @foreach ($statuslogs as $statusLog)
                                        <div class="row  px-3">
                                            <div class="col-md-12">
                                                <table class="table mb-0 table-borderless">
                                                    <tbody>
                                                        <tr style="background-color: #aaa">
                                                            <td colspan="6" style="font-weight:500;"> Status -
                                                                {!! incidentInvestigationStatus($statusLog->to_status) !!} </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 10%">Name</th>
                                                            <td style="width: 5%">:</td>
                                                            <td style="width: 30%">
                                                                {{ getusername($statusLog->created_by) }}</td>
                                                            <th style="width: 10%">Date</th>
                                                            <td style="width: 5%">:</td>
                                                            <td style="width: 30%">
                                                                {{ displayDateTimeformat($statusLog->created_at) }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Description</th>
                                                            <td>:</td>
                                                            <td colspan="4">{{ $statusLog->remarks }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                @if (
                                    $investigation_details->investigation_status == INCIDENT_INVESTIGATION_NEARMISS_ADDED &&
                                        (CheckUserRole(ROLE_GHSE_APPROVER) || CheckUserRole(ROLE_SUPERADMIN)) &&
                                        isset($approve_status))
                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">Approval </h6>
                                        </div>

                                        <form class="" id="incident_approve" novalidate method="POST"
                                            enctype="multipart/form-data"
                                            action="{{ admin_url('incident/investigation/approvereject/submit') }}">
                                            @csrf
                                            <input type="hidden" name="id" id="id"
                                                value="{{ encryptId($investigation_details->id) }}">
                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-4 form-input">
                                                        <label for="approved_by" class="form-label require">Name</label>
                                                        <input type="text" name="approved_by" id="approved_by"
                                                            value="{{ Auth::user()->name }}" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="incidenttime"
                                                            class="form-label require">Designation</label>
                                                        <input type="text" name="" id=""
                                                            value="{{ Auth::user()->user_designation_name }}"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="incidenttime" class="form-label require">Date and
                                                            Time</label>
                                                        <input type="text" name="approved_at" id="approved_at"
                                                            value="{{ todayDatetime() }}" class="form-control" readonly>
                                                    </div>

                                                    <div class="col-md-12 form-input">
                                                        <label for="incident_type"
                                                            class="form-label require">Remarks</label>
                                                        <textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row card-bottom">
                                                <div class="col-12 mt-2 mb-3">
                                                    <hr>
                                                    <button name="reject" type="submit" class="btn btn-danger "
                                                        data-bs-toggle="tooltip" title="Reject">Reject</button>
                                                    <button class="btn btn-primary " name="approve" type="submit"
                                                        data-bs-toggle="tooltip" title="Approve">Approve</button>
                                                </div>
                                            </div>
                                        </form>
                                        <hr>
                                    </div>
                                @endif


                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@stop

@push('script')
    <script>
        $(document).ready(function() {
            @if ($type == 'minor')
                $('.minor').show();
                $('.major').hide();
            @else
                $('.minor').hide();
                $('.major').show();
            @endif
        });
    </script>
@endpush
