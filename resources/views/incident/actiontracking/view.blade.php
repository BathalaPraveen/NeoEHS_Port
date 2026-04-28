@extends('admin.layouts.layout')
@section('title', 'Incident Notification View')
@section('pageurl', admin_url('incident/actiontracking/list'))

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
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Incident
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('incident/actiontracking/list') }}">Incident Notification</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Incident Notification View</li>
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
                                    <h5 class="card-title">Incident Notification View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('incident/actiontracking/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">
                                    @csrf

                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART A : GENERAL INCIDENT INFORMATION</h6>
                                        </div>

                                        <div class="content-block-body">

                                            <div class="row g-3 px-4 pt-4 form-input content-block-row">
                                                <div class="col-md-4">
                                                    <label for="incident_type" class="form-label require">Incident
                                                        Type</label>

                                                    <div>
                                                        {{ getIncidentTypeName($IncidentDetails->incident_type) }}
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="col-md-4">
                                                    <div class=" form-input">
                                                        <label for="emergency_incident_tier"
                                                            class="form-label require">Emergency Incident Tier</label>
                                                        <div>
                                                            {{ getIncidentItemName($IncidentDetails->emergency_incident_tier) }}
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class=" form-input">
                                                        <label for="typeofnotification" class="form-label require">Type
                                                            Of Notification</label>
                                                        <div>
                                                            {{ getIncidentItemName($IncidentDetails->type_of_notification) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class=" form-input">
                                                        <label for="location_" class="form-label require">Location</label>
                                                        <div>
                                                            {{ getIncidentItemName($IncidentDetails->location) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="incidentdate" class="form-label require">Incident
                                                        Date</label>
                                                    <div>
                                                        {{ displayDateformat($IncidentDetails->incident_date) }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime" class="form-label require">Incident
                                                        Time</label>
                                                    <div>
                                                        {{ $IncidentDetails->incident_time }}
                                                    </div>
                                                </div>


                                                <div class="col-md-4 form-input">
                                                    <label for="weather_condition" class="form-label require">Weather
                                                        Condition</label>
                                                    <div>
                                                        {{ getIncidentItemName($IncidentDetails->weather_condition) }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company" class="form-label require">Company</label>
                                                    <div>
                                                        {{ getCompanyName($IncidentDetails->company_id) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="location" class="form-label require">Location</label>
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
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART B : CATEGORY OF INCIDENT</h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">

                                            @php
                                                $category_of_incident = $IncidentDetails->category_of_incident;

                                                if ($category_of_incident != '' && $category_of_incident != null) {
                                                    $categoryofincidentArray = json_decode($category_of_incident, true);
                                                } else {
                                                    $categoryofincidentArray = [];
                                                }

                                            @endphp

                                            @foreach ($categoryofincidentList as $categoryofincident)
                                                <div class="col-md-6">
                                                    <div
                                                        style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">
                                                        {{ $categoryofincident->item_name }}
                                                    </div>
                                                    <div>
                                                        @isset($subcategoryofincidentList[$categoryofincident->id])
                                                            @foreach ($subcategoryofincidentList[$categoryofincident->id] as $subcategoryofincident)
                                                                <div class="">

                                                                    @php
                                                                        $checkvalue = '';
                                                                        if (
                                                                            isset(
                                                                                $categoryofincidentArray[
                                                                                    $categoryofincident->id
                                                                                ][$subcategoryofincident->id],
                                                                            )
                                                                        ) {
                                                                            if (
                                                                                isset(
                                                                                    $categoryofincidentArray[
                                                                                        $categoryofincident->id
                                                                                    ][$subcategoryofincident->id][
                                                                                        'value'
                                                                                    ],
                                                                                )
                                                                            ) {
                                                                                if (
                                                                                    $categoryofincidentArray[
                                                                                        $categoryofincident->id
                                                                                    ][$subcategoryofincident->id][
                                                                                        'value'
                                                                                    ] == 'YES'
                                                                                ) {
                                                                                    $checkvalue = 'checked';
                                                                                }
                                                                            }
                                                                        }

                                                                    @endphp

                                                                    <input type="checkbox"
                                                                        name="category_of_incident[{{ $categoryofincident->id }}][{{ $subcategoryofincident->id }}]['value']"
                                                                        {{ $checkvalue }} disabled
                                                                        id="category_of_incident_{{ encryptId($subcategoryofincident->id) }}"
                                                                        value="YES"
                                                                        data-id="show_others_{{ encryptId($subcategoryofincident->id) }}"
                                                                        class=" @if ($subcategoryofincident->other_params != '' && $subcategoryofincident->other_params != null) othersshow @endif">
                                                                    <label
                                                                        for="category_of_incident_{{ encryptId($subcategoryofincident->id) }}">{{ $subcategoryofincident->subitem_name }}</label>
                                                                    @if ($subcategoryofincident->other_params != '' && $subcategoryofincident->other_params != null)
                                                                        <div id="show_others_{{ encryptId($subcategoryofincident->id) }}"
                                                                            style=" @if ($checkvalue == '') display: none @endif">
                                                                            @php
                                                                                $otherparams = [];
                                                                                $otherparams = json_decode(
                                                                                    $subcategoryofincident->other_params,
                                                                                );

                                                                            @endphp
                                                                            @foreach ($otherparams as $param)
                                                                                <div>
                                                                                    @if ($param->name != '')
                                                                                        <label class="require"
                                                                                            for="">{{ $param->name }}</label>
                                                                                    @endif
                                                                                    @switch($param->type)
                                                                                        @case('text')
                                                                                            <div class="form-input">

                                                                                                @isset($categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id][$param->data_name])
                                                                                                    <div style="margin-left:2rem">
                                                                                                        {{ $categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id][$param->data_name] }}
                                                                                                    </div>
                                                                                                @endisset


                                                                                            </div>
                                                                                        @break

                                                                                        @case('select_single')
                                                                                        @case('select_multiple')
                                                                                            @php
                                                                                                $listitems = string_to_array(
                                                                                                    $param->data_list,
                                                                                                );
                                                                                            @endphp
                                                                                            <div class="form-input">

                                                                                                <div style="margin-left:2rem">
                                                                                                    {{ $categoryofincidentArray[$categoryofincident->id][$subcategoryofincident->id][$param->data_name] }}
                                                                                                </div>

                                                                                            </div>
                                                                                        @break
                                                                                    @endswitch
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART C : CASUALTY/ FATALITY</h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">

                                            <div class="col-md-6">
                                                <div
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">
                                                    Number of Injuries
                                                </div>

                                                @php

                                                    $casuality_details = $IncidentDetails->casuality_details;

                                                    if ($casuality_details != '' && $casuality_details != null) {
                                                        $casualitydetailsArray = json_decode($casuality_details, true);
                                                    } else {
                                                        $casualitydetailsArray = [];
                                                    }

                                                    $staffchecked = isset($casualitydetailsArray['staff']['value'])
                                                        ? 'checked'
                                                        : '';
                                                    $contractorchecked = isset(
                                                        $casualitydetailsArray['contractor']['value'],
                                                    )
                                                        ? 'checked'
                                                        : '';
                                                    $portuserchecked = isset(
                                                        $casualitydetailsArray['portuser']['value'],
                                                    )
                                                        ? 'checked'
                                                        : '';

                                                @endphp
                                                <div>
                                                    <input class="othersshow" data-id="injuries_staff_div"
                                                        {{ $staffchecked }} disabled type="checkbox"
                                                        name="injuries[staff][value]" value="YES"
                                                        id="injuries_staff">
                                                    <label for="injuries_staff">Staff</label>
                                                </div>
                                                <div id="injuries_staff_div"
                                                    style="@if ($staffchecked == '') display: none @endif">

                                                    @foreach ($companyDetails as $company)
                                                        <div class="row mb-1">
                                                            <div class="col-md-3">
                                                                <label for="">{{ $company->company_name }}</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div style="margin-left: 2rem">
                                                                    {{ $casualitydetailsArray['staff'][$company->id] ?? ''}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div>
                                                    <input class="othersshow" data-id="injuries_contractor_div"
                                                        {{ $contractorchecked }} disabled type="checkbox"
                                                        name="injuries[contractor]['value']" value="YES"
                                                        id="injuries_contractor">
                                                    <label for="injuries_contractor">Contractor</label>
                                                </div>
                                                <div id="injuries_contractor_div"
                                                    style="@if ($contractorchecked == '') display: none @endif">
                                                    <div style="margin-left: 2rem">
                                                        {{ $casualitydetailsArray['contractor']['count'] }}
                                                    </div>

                                                </div>
                                                <div>
                                                    <input class="othersshow" data-id="injuries_port_user_div"
                                                        {{ $portuserchecked }} disabled type="checkbox"
                                                        name="injuries[portuser][value]" value="YES"
                                                        id="injuries_port_user">
                                                    <label for="injuries_port_user">Port User</label>
                                                </div>
                                                <div id="injuries_port_user_div"
                                                    style="@if ($portuserchecked == '') display: none @endif">
                                                    <div style="margin-left: 2rem">
                                                        {{ $casualitydetailsArray['portuser']['count'] }}
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">
                                                    Number of Fatalities
                                                </div>

                                                @php

                                                    $fatality_details = $IncidentDetails->fatality_details;

                                                    if ($fatality_details != '' && $fatality_details != null) {
                                                        $fatalitydetailsdetailsArray = json_decode(
                                                            $fatality_details,
                                                            true,
                                                        );
                                                    } else {
                                                        $fatalitydetailsdetailsArray = [];
                                                    }

                                                    $staffchecked = isset(
                                                        $fatalitydetailsdetailsArray['staff']['value'],
                                                    )
                                                        ? 'checked'
                                                        : '';
                                                    $contractorchecked = isset(
                                                        $fatalitydetailsdetailsArray['contractor']['value'],
                                                    )
                                                        ? 'checked'
                                                        : '';
                                                    $portuserchecked = isset(
                                                        $fatalitydetailsdetailsArray['portuser']['value'],
                                                    )
                                                        ? 'checked'
                                                        : '';

                                                @endphp

                                                <div>
                                                    <input class="othersshow" data-id="fatalities_staff_div"
                                                        {{ $staffchecked }} disabled type="checkbox"
                                                        name="fatalities[staff]['value']" value="YES"
                                                        id="fatalities_staff">
                                                    <label for="fatalities_staff">Staff</label>
                                                </div>
                                                <div id="fatalities_staff_div"
                                                    style="@if ($staffchecked == '') display: none @endif">
                                                    @foreach ($companyDetails as $company)
                                                        <div class="row mb-1">
                                                            <div class="col-md-3">
                                                                <label for="">{{ $company->company_name }}</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div style="margin-left: 2rem">
                                                                    {{ $fatalitydetailsdetailsArray['staff'][$company->id] ?? '' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div>
                                                    <input class="othersshow" data-id="fatalities_contractor_div"
                                                        {{ $contractorchecked }} disabled type="checkbox"
                                                        name="fatalities[contractor]['value']" value="YES"
                                                        id="fatalities_contractor"> <label
                                                        for="fatalities_contractor">Contractor</label>
                                                </div>
                                                <div id="fatalities_contractor_div"
                                                    style="@if ($contractorchecked == '') display: none @endif">
                                                    <div style="margin-left: 2rem">
                                                        {{ $fatalitydetailsdetailsArray['contractor']['count'] }}
                                                    </div>

                                                </div>
                                                <div>
                                                    <input class="othersshow" data-id="fatalities_port_user_div"
                                                        {{ $portuserchecked }} disabled type="checkbox"
                                                        name="fatalities[portuser][value]" value="YES"
                                                        id="fatalities_port_user">
                                                    <label for="fatalities_port_user">Port User</label>
                                                </div>
                                                <div id="fatalities_port_user_div"
                                                    style="@if ($portuserchecked == '') display: none @endif">
                                                    <div style="margin-left: 2rem">
                                                        {{ $fatalitydetailsdetailsArray['portuser']['count'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART D : INCIDENT POTENTIAL</h6>
                                    </div>

                                    @php
                                        $incident_potential = string_to_array($IncidentDetails->incident_potential);

                                    @endphp

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row form-input">

                                            <label for="" class="form-label require">INCIDENT
                                                POTENTIAL</label>

                                            @foreach ($incidentpotentialList as $incidentpotential)
                                                <div class="col-md-6 mb-2">
                                                    <input type="checkbox" name="incident_potential[]" required disabled
                                                        @checked(in_array($incidentpotential->id, $incident_potential)) class="validate-checkbox-required"
                                                        required
                                                        id="incident_potential_{{ encryptId($incidentpotential->id) }}"
                                                        value="{{ encryptId($incidentpotential->id) }}">
                                                    <label class="form-label" style="display:contents"
                                                        for="incident_potential_{{ encryptId($incidentpotential->id) }}">{{ $incidentpotential->item_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART E : AUTHORITIES INFORM *if relevant </h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">

                                            @php
                                                $authorities_inform = string_to_array(
                                                    $IncidentDetails->authorities_inform
                                                );

                                            @endphp

                                            <div class="row form-input">
                                                <label for="" class="form-label require">AUTHORITIES
                                                    INFORM </label>

                                                @foreach ($authoritiesinformList as $authoritiesinform)
                                                    <div class="col-md-3 mb-2">
                                                        <input type="checkbox" name="authorities_inform[]" required
                                                            disabled @checked(in_array($authoritiesinform->id, $authorities_inform))
                                                            class="validate-checkbox-required" required
                                                            id="authorities_inform_{{ encryptId($authoritiesinform->id) }}"
                                                            value="{{ encryptId($authoritiesinform->id) }}">
                                                        <label class="form-label"
                                                            for="authorities_inform_{{ encryptId($authoritiesinform->id) }}">{{ $authoritiesinform->item_name }}</label>
                                                    </div>
                                                @endforeach

                                                <div class="col-md-3 mb-2">
                                                    <input type="checkbox" name="authorities_inform[]" disabled
                                                        @checked(in_array('others', $authorities_inform))
                                                        class="validate-checkbox-required othersshow" required
                                                        data-id="authorities_inform_others_div"
                                                        id="authorities_inform_others" value="others">
                                                    <label class="form-label"
                                                        for="authorities_inform_others">Others</label>
                                                </div>
                                                <div class="col-md-3 mb-2 form-input" id="authorities_inform_others_div"
                                                    style="@if (!in_array('others', $authorities_inform)) display: none @endif">
                                                    <div>
                                                        {{ $IncidentDetails->authorities_inform_other }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-input">
                                                    <label for="date_informed" class="form-label require">Date
                                                        Informed</label>
                                                    <div>
                                                        {{ displayDateformat($IncidentDetails->date_of_informed) }}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART F : BRIEF DESCRIPTION OF INCIDENT (Who, What, &
                                            Consequence) </h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="col-md-12 form-input">
                                                {{ $IncidentDetails->brief_description_of_incident }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART G : MITIGATION ACTION </h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="col-md-12 form-input">
                                                {{ $IncidentDetails->mitigation_action }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART H : ADDITIONAL INFORMATION </h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="col-md-12 form-input">
                                                {{ $IncidentDetails->additional_information }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART I : INCIDENT CLASSIFICATION (Refer General
                                            Guidance) </h6>
                                    </div>
                                    @php
                                        $incident_classification = json_decode(
                                            $IncidentDetails->incident_classification,
                                            true,
                                        );

                                    @endphp
                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <tbody>
                                                        @foreach ($incidentclassificationList as $incidentclassification)
                                                            @php
                                                                $selectedvalue = isset(
                                                                    $incident_classification[
                                                                        $incidentclassification->id
                                                                    ],
                                                                )
                                                                    ? $incident_classification[
                                                                        $incidentclassification->id
                                                                    ]
                                                                    : '';
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $incidentclassification->item_name }}</td>

                                                                @foreach (range(1, 5) as $range)
                                                                    <td for=""> <input type="radio"
                                                                            name="incidentclassification[{{ $incidentclassification->id }}]"
                                                                            disabled @checked($selectedvalue == $range)
                                                                            id="incidentclassification_{{ encryptId($incidentclassification->id) }}_{{ $range }}"
                                                                            value="{{ $range }}">
                                                                        <label
                                                                            for="incidentclassification_{{ encryptId($incidentclassification->id) }}_{{ $range }}">
                                                                            {{ $range }}</label>
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="">
                                                <div
                                                    style="background: skyblue;padding: 10px;margin-bottom: 10px;font-weight: bold;">
                                                    General Guidance of Incident Classification
                                                </div>

                                                <table class="table table-bordered table-striped">
                                                    <tr style="font-weight:bold">
                                                        <td>Class</td>
                                                        <td>Rating</td>
                                                        <td>People</td>
                                                        <td>Environment</td>
                                                        <td>Asset</td>
                                                        <td>Reputation</td>
                                                        <td>Security</td>
                                                    </tr>

                                                    @foreach ($classificationList as $key => $value)
                                                        <tr>
                                                            <td>{{ $value[0]->rating_level }}</td>
                                                            <td>{{ $key }}</td>
                                                            @foreach ($value as $row)
                                                                <td>{{ $row->rating_text }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach

                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="content-block">

                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <h6 class="text-white">PART J : Created By </h6>
                                    </div>

                                    <div class="content-block-body">
                                        <div class="row g-3 px-4 pt-4 content-block-row">
                                            <div class="col-md-4 form-input">
                                                <label for="incidenttime" class="form-label require">Name</label>
                                                <div>
                                                    {{ getusername($IncidentDetails->created_by) }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="incidenttime" class="form-label require">Designation</label>
                                                <div>
                                                    {{ getuser($IncidentDetails->created_by)->user_designation_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="incidenttime" class="form-label require">Date and
                                                    Time</label>
                                                {{ displayDatetimeformat($IncidentDetails->created_at) }}
                                            </div>
                                            <div class="col-md-12 form-input">
                                                <label for="incidentremarks" class="form-label require">Incident
                                                    Remarks</label>
                                                <div>
                                                    {{ $IncidentDetails->incident_remarks }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (
                                    $IncidentDetails->incident_status == INCIDENT_NOTIFICATION_STATUS_GHSE_PENDING &&
                                        (CheckUserRole(ROLE_GHSE_APPROVER) ||  CheckUserRole(ROLE_SUPERADMIN) ) &&
                                        isset($approve_status))
                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">Approval </h6>
                                        </div>

                                        <form class="" id="incident_approve" novalidate method="POST"
                                            enctype="multipart/form-data"
                                            action="{{ admin_url('incident/actiontracking/approvereject/submit') }}">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ encryptId($IncidentDetails->id) }}">
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
                                                    <div class="col-md-4 form-input">
                                                        <label for="incident_type" class="form-label require">Incident
                                                            Rating</label>
                                                        <select name="incident_rating" id="incident_rating" required
                                                            class="form-control select2">
                                                            <option value="">Select Incident Rating</option>
                                                            <option value="{{ encryptId(1) }}">1</option>
                                                            <option value="{{ encryptId(2) }}">2</option>
                                                            <option value="{{ encryptId(3) }}">3</option>
                                                            <option value="{{ encryptId(4) }}">4</option>
                                                            <option value="{{ encryptId(5) }}">5</option>
                                                            </option>
                                                        </select>
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
        </div>
        <!--end row-->
    </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(function() {
            $('#incident_approve').validate({
                rules: {
                    incident_rating: {
                        required: true,
                    },
                    remarks: {
                        required: true,
                    },

                },
                messages: {
                    incident_rating: {
                        required: "Please select Incident Rating",
                    },
                    remarks: {
                        required: "Please enter Remarks",
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
    </script>
@endpush
