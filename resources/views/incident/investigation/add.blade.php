@extends('admin.layouts.layout')
@section('title', 'investigation Add')
@section('pageurl', admin_url('incident/investigation/list'))

@push('style')
    <style>
        label {
            font-weight: bold;
        }

        .removeRow {
            cursor: pointer;
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
                                <a href="{{ admin_url('incident/investigation/list') }}">Incident Investigation </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Incident Investigation Add</li>
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
                                    <h5 class="card-title">Incident Investigation</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('incident/investigation/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="investigation_add" novalidate method="POST"
                                enctype="multipart/form-data" action="{{ admin_url('incident/investigation/add/submit') }}">

                                <input type="hidden" name="type" id="type" value="{{ $type }}">
                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($investigation->id) }}">
                                        <div class="content-block">
                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART A : REPORT SUMMARY</h6>
                                            </div>
                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 form-input content-block-row">
                                                    <div class="col-md-4 all">
                                                        <label for="emergency_incident_tier"
                                                            class="form-label require">Incident Title</label>
                                                        <input type="text" class="form-control" name="incident_title"
                                                            required id="incident_title">
                                                    </div>
                                                    <div class="col-md-4 form-input all">
                                                        <label for="incidentdate" class="form-label require">Incident
                                                            Date</label>
                                                        <div>
                                                            {{ displayDateformat($IncidentDetails->incident_date) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input all">
                                                        <label for="incidenttime" class="form-label require">Incident
                                                            Time</label>
                                                        <div>
                                                            {{ $IncidentDetails->incident_time }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row all">
                                                    <div class="col-md-4 form-input">
                                                        <label for="company" class="form-label require">Company</label>
                                                        <div>
                                                            {{ getCompanyName($IncidentDetails->company_id) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="" class="form-label require">Location</label>
                                                        <div>
                                                            {{ getLocationName($IncidentDetails->location_id) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="specific_location" class="form-label require">Specific
                                                            Location</label>
                                                        <div>
                                                            {{ getSpecificLocationName($IncidentDetails->specific_location_id) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-6 form-input minor">
                                                        <label for="" class="form-label require">Employee
                                                            Involved</label>
                                                        <textarea name="employee_involved" id="employee_involved" required class="form-control" rows="5"></textarea>
                                                    </div>

                                                    <div class="col-md-6 form-input minor">
                                                        <label for="" class="form-label require">Witness</label>
                                                        <textarea name="witness" id="witness" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 form-input minor">
                                                        <label for="" class="form-label require">Immediate
                                                            Supervisor</label>
                                                        <textarea name="immediate_supervisor" id="immediate_supervisor" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 form-input minor">
                                                        <label for="" class="form-label require">Immediate Action
                                                            Taken</label>
                                                        <textarea name="immediate_action_taken" id="immediate_action_taken" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART B : INCIDENT DESCRIPTION</h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row all">

                                                    <div class="col-md-12 form-input">
                                                        <label for="" class="form-label require">Brief
                                                            Description</label>
                                                        <textarea name="brief_description" id="brief_description" required class="form-control" rows="10"></textarea>
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
                                                        <label for="" class="form-label require">Initial
                                                            Activity</label>
                                                        <textarea name="initial_activity" id="initial_activity" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 minor form-input">
                                                        <label for="" class="form-label require">Incident
                                                            Occurrence</label>
                                                        <textarea name="incident_occurrence" id="incident_occurrence" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 minor form-input">
                                                        <label for="" class="form-label require">Immediate
                                                            Response</label>
                                                        <textarea name="immediate_response" id="immediate_response" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 all form-input">
                                                        <label for="" class="form-label require">Injury Assessment
                                                            (if applicable)</label>
                                                        <textarea name="injury_assessment" id="injury_assessment" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-4 form-input major">
                                                        <label for="" class="form-label require">No of MC</label>
                                                        <input type="text" class="form-control"
                                                            name="no_of_mc" required id="no_of_mc">
                                                    </div>
                                                    <div class="col-md-12 all">
                                                        <label for="" class="form-label require">Property Damage
                                                            Assessment</label>
                                                        <div class="row">
                                                            <div class="col-md-4 form-input">
                                                                <label for="" class="form-label require">Type of
                                                                    Asset</label>
                                                                <input type="text" class="form-control"
                                                                    name="type_of_asset" required id="type_of_asset">
                                                            </div>
                                                            <div class="col-md-4 form-input">
                                                                <label for="" class="form-label require">Owner of
                                                                    the property</label>
                                                                <input type="text" class="form-control"
                                                                    name="owner_of_the_property" required
                                                                    id="owner_of_the_property">
                                                            </div>
                                                            <div class="col-md-4 form-input">
                                                                <label for="" class="form-label require">Estimated
                                                                    cost</label>
                                                                <input type="text" class="form-control"
                                                                    name="estimated_cost" required id="estimated_cost">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 minor form-input">
                                                        <label for="" class="form-label require">Witness
                                                            Statements</label>
                                                        <textarea name="witness_statements" id="witness_statements" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-6 minor form-input">
                                                        <label for="" class="form-label require">Supervisor's
                                                            Account</label>
                                                        <textarea name="supervisor_account" id="supervisor_account" required class="form-control" rows="5"></textarea>
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
                                                            <input type="text" class="form-control datepicker" required
                                                                id="tl_incident_date" placeholder="Incident Date"
                                                                name="tl_incident_date" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="tl_incident_time" class="form-label require">Incident
                                                            Start Time</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control clockpicker"
                                                                required id="tl_incident_start_time"
                                                                placeholder="Incident Time" name="tl_incident_time"
                                                                readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-clock"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="tl_incident_time" class="form-label require">Incident
                                                            Happen Time</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control clockpicker"
                                                                required id="tl_incident_time" placeholder="Incident Time"
                                                                name="tl_incident_time" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-clock"></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 form-input">
                                                        <label for="" class="form-label require">Chronology
                                                            sequence</label>
                                                        <textarea name="chronology_sequence" id="chronology_sequence" required class="form-control" rows="5"></textarea>
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
                                                        <label for="" class="form-label require">Environment
                                                            Conditions</label>
                                                        <textarea name="environment_conditions" id="environment_conditions" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-input">
                                                        <label for="" class="form-label require">Equipment &
                                                            Tools</label>
                                                        <textarea name="equipment_tools" id="equipment_tools" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-input">
                                                        <label for="" class="form-label require">Employee
                                                            Actions</label>
                                                        <textarea name="employee_actions" id="employee_actions" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="col-md-12 form-input">
                                                        <label for="" class="form-label require">Training &
                                                            Procedures</label>
                                                        <textarea name="training_procedures" id="training_procedures" required class="form-control" rows="5"></textarea>
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
                                                        <label for="underlying_cause"
                                                            class="form-label require">Underlying
                                                            cause</label>
                                                        <textarea name="underlying_cause" id="underlying_cause" required class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-3 form-input">
                                                        <label for="" class="form-label require">Root Cause
                                                            Category</label>
                                                        <select name="root_cause_category" class="select2 form-control"
                                                            required id="root_cause_category">
                                                            <option value="">Select Root Cause Category</option>
                                                            @foreach ($rootcausecategoryList as $rootcausecategory)
                                                                <option value="{{ encryptId($rootcausecategory->id) }}">
                                                                    {{ $rootcausecategory->item_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-12 form-input">
                                                        <label for="root_cause_details"
                                                            class="form-label require">Details</label>
                                                        <textarea name="root_cause_details" id="root_cause_details" required class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-12 form-input">
                                                        <label for="root_cause_recommendation"
                                                            class="form-label require">Recommendation</label>
                                                        <textarea name="root_cause_recommendation" id="root_cause_recommendation" required class="form-control"
                                                            rows="10"></textarea>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <div id="fieldsContainer">
                                                        <div class="row g-3 px-4 pt-4 content-block-row single-row">
                                                            
                                                            <div class=""
                                                                style="background: skyblue; padding: 10px; margin-bottom: 10px; font-weight: bold;">
                                                                Action Parties
                                                            </div>

                                                            <label for="company"
                                                                class="form-label require">Company</label>
                                                            <div class="row company-group">
                                                                @foreach ($companyDetails as $company)
                                                                    <div class="col-md-3">
                                                                        <div class="form-input">
                                                                            <input class="form-check-input company-radio"
                                                                                type="radio" required
                                                                                value="{{ encryptId($company->id) }}"
                                                                                name="action_parties_company[0]"
                                                                                id="action_parties_company_{{ encryptId($company->id) }}_0">
                                                                            <label class="form-check-label"
                                                                                for="action_parties_company_{{ encryptId($company->id) }}_0">{{ $company->company_name }}</label>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label require">Location</label>
                                                                <select name="action_parties_location[0]"
                                                                    class="form-control select2" required>
                                                                    <option value="">Select Location</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label require">Specific Location</label>
                                                                <select name="action_parties_specific_location[0]"
                                                                    class="form-control select2" required>
                                                                    <option value="">Select Specific Location
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label require">Division Name</label>
                                                                <select name="division[0]" class="form-control select2"
                                                                    required>
                                                                    <option value="">Select Division</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label require">Department Name</label>
                                                                <select name="department[0]" class="form-control select2"
                                                                    required>
                                                                    <option value="">Select Department</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label class="form-label require">User</label>
                                                                <select name="user[0]" class="form-control select2"
                                                                    required>
                                                                    <option value="">Select User</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-1 d-flex align-items-end">
                                                                <a class="removeRow">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="px-4 mt-3 d-flex justify-content-end">
                                                            <button type="button" id="addMore"
                                                                class="btn btn-primary ">Add
                                                                </button>
                                                        </div>


                                                </div>
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
                                                                <div class="col-md-12 form-input">
                                                                    <textarea name="lesson_learned_details[]" id="lesson_learned_details" required class="form-control" rows="10"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ms-auto d-flex justify-content-end">
                                                        <button class="btn btn-primary addmorebutton dynamic-add-more"
                                                            data-block='lesson_learned_block'
                                                            data-row='lesson_learned_row' type="button">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="content-block minor">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <div class="d-lg-flex align-items-center ">
                                                    <div class="position-relative">
                                                        <h6 class="text-white">PART H : Conclusion</h6>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <button class="btn btn-primary addmorebutton dynamic-add-more"
                                                            data-block='conclusion_block'
                                                            data-row='conclusion_row' type="button">Add</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">

                                                    <div class="row g-3 px-4 pt-4 content-block-row">
                                                        <div class="col-md-12">
                                                            <label for="conclusion_details"
                                                                class="form-label require">Details</label>
                                                        </div>
                                                        <div class="row" id="conclusion_block">
                                                            <div class="conclusion_row">
                                                                <div class="row">
                                                                    <div class="col-md-11 form-input">
                                                                        <textarea name="conclusion_details[]" id="conclusion_details" required class="form-control" rows="10"></textarea>
                                                                    </div>
                                                                    <div class="col-md-1 form-input">
                                                                        <span class="fa fa-trash removerow"
                                                                            data-block='conclusion_block'
                                                                            data-row='conclusion_row'> </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

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
                                                    <div class="ms-auto">
                                                        <button class="btn btn-primary dynamic-add-more"
                                                            data-block='appendicies_block' data-row='appendicies_row'
                                                            type="button">Add</button>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row " id="appendicies_block">

                                                    <div class="col-md-4 form-input appendicies_row">
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <input type="file" class="form-control"
                                                                    name="appendicies[]" id="appendicies_1">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <span class="fa fa-trash removerow"
                                                                    data-block='appendicies_block'
                                                                    data-row='appendicies_row'> </span>
                                                            </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='tripod_beta_report_block'
                                                                    data-row='tripod_beta_report_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="tripod_beta_report_block" class="row">
                                                        <div class="col-md-4 tripod_beta_report_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="tripod_beta_report[]"
                                                                        id="tripod_beta_report_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='tripod_beta_report_block'
                                                                        data-row='tripod_beta_report_row'> </span>
                                                                </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='witness_statements_block'
                                                                    data-row='witness_statements_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="witness_statements_block" class="row">
                                                        <div class="col-md-4 witness_statements_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="witness_statements[]"
                                                                        id="witness_statements_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='witness_statements_block'
                                                                        data-row='witness_statements_row'> </span>
                                                                </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='photo_videos_block'
                                                                    data-row='photo_videos_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="photo_videos_block" class="row">
                                                        <div class="col-md-4 photo_videos_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="photo_videos[]" id="photo_videos_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='photo_videos_block'
                                                                        data-row='photo_videos_row'> </span>
                                                                </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='equipment_inspection_block'
                                                                    data-row='equipment_inspection_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="equipment_inspection_block" class="row">
                                                        <div class="col-md-4 equipment_inspection_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="equipment_inspection[]"
                                                                        id="equipment_inspection_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='equipment_inspection_block'
                                                                        data-row='equipment_inspection_row'> </span>
                                                                </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='training_records_block'
                                                                    data-row='training_records_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="training_records_block" class="row">
                                                        <div class="col-md-4 training_records_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="training_records[]" id="training_records_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='training_records_block'
                                                                        data-row='training_records_row'> </span>
                                                                </div>
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
                                                            <div class="ms-auto">
                                                                <button class="btn btn-primary dynamic-add-more"
                                                                    data-block='other_records_block'
                                                                    data-row='other_records_row'
                                                                    type="button">Add</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div id="other_records_block" class="row">
                                                        <div class="col-md-4 other_records_row">
                                                            <div class="row mb-3">
                                                                <div class="col-md-11">
                                                                    <input type="file" class="form-control"
                                                                        name="other_records[]" id="other_records_1">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <span class="fa fa-trash removerow"
                                                                        data-block='other_records_block'
                                                                        data-row='other_records_row'> </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART K : Prepared By </h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-4 form-input">
                                                        <label for="incidenttime" class="form-label require">Name</label>
                                                        <input type="text" name="" id=""
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
                                                        <input type="text" name="" id=""
                                                            value="{{ todayDatetime() }}" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-md-12 form-input">
                                                        <label for="investigation_remarks"
                                                            class="form-label require">Investigation
                                                            Remarks</label>
                                                        <textarea name="investigation_remarks" id="investigation_remarks" required class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
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
        document.addEventListener("DOMContentLoaded", function() {
            let maxRows = 10;
            let container = document.getElementById("fieldsContainer");
            let addMoreBtn = document.getElementById("addMore");

            function reinitializeSelect2() {
                $(".select2").select2({
                    width: '100%'
                });
            }

            reinitializeSelect2();

            addMoreBtn.addEventListener("click", function() {
                let rowCount = document.querySelectorAll(".single-row").length;
                if (rowCount < maxRows) {
                    let newIndex = rowCount;

                    let newRow = document.createElement("div");
                    newRow.classList.add("row", "g-3", "px-4", "pt-4", "content-block-row", "single-row");
                    newRow.innerHTML = `
                    <div style="background: skyblue; padding: 10px; margin-bottom: 10px; font-weight: bold;">
                        Action Parties
                    </div>

                    <label class="form-label require">Company</label>
                    <div class="row company-group">
                        @foreach ($companyDetails as $company)
                            <div class="col-md-3">
                                <div class="form-input">
                                    <input class="form-check-input company-radio" type="radio" required
                                        value="{{ encryptId($company->id) }}"
                                        name="action_parties_company[${newIndex}]"
                                        id="action_parties_company_{{ encryptId($company->id) }}_${newIndex}">
                                    <label class="form-check-label"
                                        for="action_parties_company_{{ encryptId($company->id) }}_${newIndex}">{{ $company->company_name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-4">
                        <label class="form-label require">Location</label>
                        <select name="action_parties_location[${newIndex}]" class="form-control select2" required>
                            <option value="">Select Location</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label require">Specific Location</label>
                        <select name="action_parties_specific_location[${newIndex}]" class="form-control select2" required>
                            <option value="">Select Specific Location</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label require">Division Name</label>
                        <select name="division[${newIndex}]" class="form-control select2" required>
                            <option value="">Select Division</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label require">Department Name</label>
                        <select name="department[${newIndex}]" class="form-control select2" required>
                            <option value="">Select Department</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label require">User</label>
                        <select name="user[${newIndex}]" class="form-control select2" required>
                            <option value="">Select User</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <a class="removeRow">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                `;

                    // Append new row
                    container.appendChild(newRow);

                    // Initialize select2 for new row
                    reinitializeSelect2();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Reached!',
                        text: 'Maximum of ' + maxRows + ' rows allowed.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            });

            container.addEventListener("click", function(e) {
                if (e.target.closest(".removeRow")) {
                    let rowCount = document.querySelectorAll(".single-row").length;
                    if (rowCount > 1) {
                        e.target.closest(".single-row").remove();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cannot Remove!',
                            text: 'At least one row must remain.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                }

            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            @if ($type == 'minor')
                $('.minor').show();
                $('.major').hide();
            @else
                $('.minor').hide();
                $('.major').show();
            @endif
        });

        $(function() {
            $('#investigation_add').validate({
                rules: {
                    incident_title: {
                        required: true,
                    },
                    employee_involved: {
                        required: true,
                    },
                    witness: {
                        required: true,
                    },
                    immediate_supervisor: {
                        required: true,
                    },
                    immediate_action_taken: {
                        required: true,
                    },
                    brief_description: {
                        required: true,
                    },
                    initial_activity: {
                        required: true,
                    },
                    incident_occurrence: {
                        required: true,
                    },
                    immediate_response: {
                        required: true,
                    },
                    injury_assessment: {
                        required: true,
                    },
                    type_of_asset: {
                        required: true,
                    },
                    owner_of_the_property: {
                        required: true,
                    },
                    estimated_cost: {
                        required: true,
                    },
                    witness_statements: {
                        required: true,
                    },
                    supervisor_account: {
                        required: true,
                    },
                    tl_incident_date: {
                        required: true,
                    },
                    tl_incident_time: {
                        required: true,
                    },
                    chronology_sequence: {
                        required: true,
                    },
                    environment_conditions: {
                        required: true,
                    },
                    equipment_tools: {
                        required: true,
                    },
                    employee_actions: {
                        required: true,
                    },
                    training_procedures: {
                        required: true,
                    },
                    underlying_cause: {
                        required: true,
                    },
                    root_cause_category: {
                        required: true,
                    },
                    root_cause_details: {
                        required: true,
                    },
                    root_cause_recommendation: {
                        required: true,
                    },
                    action_parties_company: {
                        required: true,
                    },
                    action_parties_location: {
                        required: true,
                    },
                    action_parties_specific_location: {
                        required: true,
                    },
                    lesson_learned_details: {
                        required: true,
                    },
                    conclusion_details: {
                        required: true,
                    },
                    "Lesson_learned_users[]": {
                        required: true,
                    },
                    investigation_remarks: {
                        required: true,
                    },

                },
                messages: {
                    incident_title: {
                        required: "Please enter Incident Title",
                    },
                    employee_involved: {
                        required: "Please enter Employee Involved",
                    },
                    witness: {
                        required: "Please enter Witness"
                    },
                    immediate_supervisor: {
                        required: "Please enter Immediate Supervisor",
                    },
                    immediate_action_taken: {
                        required: "Please enter Immediate Action Taken",
                    },
                    brief_description: {
                        required: "Please enter Brief Description",
                    },
                    initial_activity: {
                        required: "Please enter Initial Activity",
                    },
                    incident_occurrence: {
                        required: "Please enter Incident Occurrence",
                    },
                    immediate_response: {
                        required: "Please enter Immediate Response",
                    },
                    injury_assessment: {
                        required: "Please enter Injury Assessment",
                    },
                    type_of_asset: {
                        required: "Please enter Type of Asset",
                    },
                    owner_of_the_property: {
                        required: "Please enter Owner of the property",
                    },
                    estimated_cost: {
                        required: "Please enter Estimated cost",
                    },
                    witness_statements: {
                        required: "Please enter Witness Statements",
                    },
                    supervisor_account: {
                        required: "Please enter Supervisor's Account",
                    },
                    tl_incident_date: {
                        required: "Please enter Incident Date",
                    },
                    tl_incident_time: {
                        required: "Please enter Incident Time",
                    },
                    chronology_sequence: {
                        required: "Please enter Chronology sequence",
                    },
                    environment_conditions: {
                        required: "Please enter Environment Conditions",
                    },
                    equipment_tools: {
                        required: "Please enter Equipment & Tools",
                    },
                    training_procedures: {
                        required: "Please enter Training & Procedures",
                    },
                    underlying_cause: {
                        required: "Please enter Underlying cause",
                    },
                    root_cause_category: {
                        required: "Please enter Root Cause Category",
                    },
                    root_cause_details: {
                        required: "Please enter Details",
                    },
                    root_cause_recommendation: {
                        required: "Please enter Recommendation",
                    },
                    action_parties_company: {
                        required: "Please select Company",
                    },
                    action_parties_location: {
                        required: "Please select Location",
                    },
                    action_parties_specific_location: {
                        required: "Please select Specific Location",
                    },
                    lesson_learned_details: {
                        required: "Please enter Lesson Learned Details",
                    },
                    conclusion_details: {
                        required: "Please enter Conclusion Details",
                    },
                    "Lesson_learned_users[]": {
                        required: "Please select Name",
                    },
                    investigation_remarks: {
                        required: "Please enter Investigation Remarks",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    $(element).closest(".form-input").addClass("selecterror");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                },
            });
        });


        $("#fieldsContainer").on("change", "input[name^='action_parties_company[']", function() {
            let $row = $(this).closest(".single-row");
            let companyId = $(this).val();

            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('location/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let locationSelect = $row.find("select[name^='action_parties_location[']");
                        let specificLocationSelect = $row.find(
                            "select[name^='action_parties_specific_location[']");

                        locationSelect.empty().append('<option value="">Select Location</option>');
                        $.each(data, function(key, value) {
                            locationSelect.append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });

                        locationSelect.trigger('change.select2');
                        specificLocationSelect.empty().append(
                            '<option value="">Select Specific Location</option>');
                        specificLocationSelect.trigger('change.select2');
                    }
                });

                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let divisionSelect = $row.find("select[name^='division[']");
                        divisionSelect.empty().append('<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            divisionSelect.append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });

                        divisionSelect.trigger('change.select2');
                    }
                });

            } else {
                $row.find("select").each(function() {
                    $(this).empty().append('<option value="">Select</option>').trigger('change.select2');
                });
            }
        });

        // Handle Division Change
        $("#fieldsContainer").on("change", "select[name^='division[']", function() {
            let $row = $(this).closest(".single-row");
            let divisionId = $(this).val();
            let departmentSelect = $row.find("select[name^='department[']");
            let userSelect = $row.find("select[name^='user[']");

            if (divisionId) {
                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        departmentSelect.empty().append('<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            departmentSelect.append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        departmentSelect.trigger('change.select2');
                    }
                });
            }
            departmentSelect.empty().append('<option value="">Select Department</option>').trigger(
                'change.select2');
            userSelect.empty().append('<option value="">Select User</option>').trigger('change.select2');
        });

        // Handle Department Change
        $("#fieldsContainer").on("change", "select[name^='department[']", function() {
            let $row = $(this).closest(".single-row");
            let departmentId = $(this).val();
            let userSelect = $row.find("select[name^='user[']");

            if (departmentId) {
                $.ajax({
                    url: "{{ admin_url('employee/get/department_employee') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        department: departmentId
                    },
                    dataType: 'json',
                    success: function(data) {
                        userSelect.empty().append('<option value="">Select User</option>');
                        $.each(data, function(key, value) {
                            userSelect.append('<option value="' + value.id + '">' + value.name +
                                '</option>');
                        });
                        userSelect.trigger('change.select2');
                    }
                });
            }
            userSelect.empty().append('<option value="">Select User</option>').trigger('change.select2');
        });

        // Handle Location Change
        $("#fieldsContainer").on("change", "select[name^='action_parties_location[']", function() {
            let $row = $(this).closest(".single-row");
            let locationId = $(this).val();
            let specificLocationSelect = $row.find("select[name^='action_parties_specific_location[']");

            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/list/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        specificLocationSelect.empty().append(
                            '<option value="">Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            specificLocationSelect.append('<option value="' + value.id + '">' +
                                value.name + '</option>');
                        });
                        specificLocationSelect.trigger('change.select2');
                    }
                });
            } else {
                specificLocationSelect.empty().append('<option value="">Select Specific Location</option>').trigger(
                    'change.select2');
            }
        });

        $('.othersshow').on('change', function() {

            var type = $(this).attr('type');
            switch (type) {
                case 'checkbox':
                    $id = $(this).data('id');
                    if ($(this).is(':checked')) {
                        $("#" + $id).show();
                    } else {
                        $("#" + $id).hide();
                    }
                    break;
                default:
                    $id = $(this).data('id');
                    if ($(this).val() == 'others') {

                        $("#" + $id).show();
                    } else {
                        $("#" + $id).hide();
                    }
                    break;
            }

        });

        $(document).ready(function() {

            $('.dynamic-add-more').on('click', function() {

                var dynamicBlock = $(this).attr('data-block');
                var dynamicRow = $(this).attr('data-row');

                var rowCount = $("#" + dynamicBlock + " ." + dynamicRow).length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                $(this).attr("disabled", true);
                var newRow = $("." + dynamicRow).first().clone();

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                var newIndex = rowCount + 1;

                newRow.find("input[type='text']").val("");
                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find(
                    "input[type='text'],textarea,input[type='file'],input[type='checkbox'],input[type='radio']"
                ).each(function() {

                    $(this).val("");
                    $(this).removeAttr("aria-describedby");

                    var tagName = $(this).attr("name");

                    // Clear text inputs and textareas
                    if ($(this).is("input[type='text'],textarea")) {
                        $(this).val("");
                        $(this).removeAttr("aria-describedby");
                    }

                    // Clear file inputs
                    if ($(this).is("input[type='file']")) {
                        $(this).val("");
                    }

                    // Uncheck checkboxes
                    if ($(this).is("input[type='checkbox']")) {
                        $(this).prop("checked", false);
                    }

                    // Deselect radio buttons
                    if ($(this).is("input[type='radio']")) {
                        $(this).prop("checked", false);
                    }

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);
                });

                newRow.find("select").each(function() {
                    $(this).removeClass(' select2-hidden-accessible');
                    $(this).removeAttr('data-select2-id');
                    $(this).removeAttr('tabindex');
                    $(this).removeAttr('aria-hidden');
                    $(this).removeAttr('aria-describedby');
                    $(this).find('option').removeAttr('data-select2-id');

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);

                });

                newRow.find(".select2").each(function() {

                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).next(".select2-container").remove();
                        $(this).removeClass("select2-hidden-accessible");
                    } else {
                        $(this).next(".select2-container").remove();
                    }
                });

                newRow.find(".risk_matrix").each(function() {

                    $(this).html("");
                    $(this).removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);
                });

                $("#" + dynamicBlock).append(newRow);

                newRow.find(".select2").select2();

                $(".select2").select2();
                $(this).attr("disabled", false);

            });
        });

        $(document).on('click', '.removerow', function() {

            var dynamicBlock = $(this).attr('data-block');
            var dynamicRow = $(this).attr('data-row');

            var rowCount = $("#" + dynamicBlock + " ." + dynamicRow).length;

            if (rowCount <= 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                })
                return true;
            }
            $(this).closest("." + dynamicRow).remove();

            $("#" + dynamicBlock + "." + dynamicRow).each(function(index) {

                newIndex = index + 1;
                $(this).find("input[type='text']").each(function() {
                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, (newIndex));
                    $(this).attr("id", newId);
                });

                $(this).find("textarea").each(function() {
                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, (newIndex));
                    $(this).attr("id", newId);
                });

                $(this).find("select").select2('destroy');

                $(this).find(".select2").each(function() {

                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).next(".select2-container").remove();
                        $(this).removeClass("select2-hidden-accessible");
                    } else {
                        $(this).next(".select2-container").remove();
                    }
                });

                $(this).find(".select2-container").remove();

                $(this).find("select").each(function() {
                    $(this).removeClass(' select2-hidden-accessible');
                    $(this).removeAttr('data-select2-id');
                    $(this).removeAttr('tabindex');
                    $(this).removeAttr('aria-hidden');
                    $(this).removeAttr('aria-describedby');
                    $(this).find('option').removeAttr('data-select2-id');

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);

                });
                $(this).find(".select2").select2();

                $(".select2").select2();

            });


        });
    </script>
@endpush
