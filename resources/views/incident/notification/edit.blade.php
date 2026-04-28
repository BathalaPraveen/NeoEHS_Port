@extends('admin.layouts.layout')
@section('title', 'Incident Notification Edit')
@section('pageurl', admin_url('incident/notification/list'))

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
                                <a href="{{ admin_url('incident/notification/list') }}">Incident Notification</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Incident Notification Edit</li>
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
                                    <h5 class="card-title">Incident Notification Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('incident/notification/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="incident_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('incident/notification/edit/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" value="{{ encryptId($IncidentDetails->id) }}" name="id">
                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART A : GENERAL INCIDENT INFORMATION</h6>
                                            </div>

                                            <div class="content-block-body">

                                                <div class="row g-3 px-4 pt-4 form-input content-block-row">
                                                    <div class="col-md-4">
                                                        <label for="incident_type" class="form-label require">Incident
                                                            Type</label>
                                                        <select name="incident_type" id="incident_type" required
                                                            class="form-control select2">
                                                            <option value="">Select Incident Type</option>
                                                            <option @selected($IncidentDetails->incident_type == 1)
                                                                value="{{ encryptId(1) }}">Near Miss</option>
                                                            <option @selected($IncidentDetails->incident_type == 2)
                                                                value="{{ encryptId(2) }}">Accident</option>
                                                            </option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="row g-3 px-4 pt-4 content-block-row">

                                                    <div class="col-md-4">
                                                        <div class="row form-input">
                                                            <label for="emergency_incident_tier"
                                                                class="form-label require">Emergency Incident Tier</label>
                                                            @foreach ($emergencyincidenttireList as $emergencyincidenttire)
                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <input class="form-check-input " type="radio"
                                                                            @checked($IncidentDetails->emergency_incident_tier == $emergencyincidenttire->id) required
                                                                            value="{{ encryptId($emergencyincidenttire->id) }}"
                                                                            name="emergency_incident_tier"
                                                                            id="emergency_incident_tier_{{ encryptId($emergencyincidenttire->id) }}">
                                                                        <label class="form-check-label"
                                                                            for="emergency_incident_tier_{{ encryptId($emergencyincidenttire->id) }}">{{ $emergencyincidenttire->item_name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row form-input">
                                                            <label for="typeofnotification" class="form-label require">Type
                                                                Of Notification</label>
                                                            @foreach ($typeofnotificationList as $typeofnotification)
                                                                <div class="col-md-6">
                                                                    <div class="">
                                                                        <input class="form-check-input " type="radio"
                                                                            @checked($IncidentDetails->type_of_notification == $typeofnotification->id) required
                                                                            value="{{ encryptId($typeofnotification->id) }}"
                                                                            name="typeofnotification"
                                                                            id="typeofnotification_{{ encryptId($typeofnotification->id) }}">
                                                                        <label class="form-check-label"
                                                                            for="typeofnotification_{{ encryptId($typeofnotification->id) }}">{{ $typeofnotification->item_name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row form-input">
                                                            <label for="location_"
                                                                class="form-label require">Location</label>
                                                            @foreach ($locationList as $location)
                                                                <div class="col-md-6">
                                                                    <div class="">
                                                                        <input class="form-check-input " type="radio"
                                                                            @checked($IncidentDetails->location == $location->id) required
                                                                            value="{{ encryptId($location->id) }}"
                                                                            name="inc_location"
                                                                            id="location_{{ encryptId($location->id) }}">
                                                                        <label class="form-check-label"
                                                                            for="location_{{ encryptId($location->id) }}">{{ $location->item_name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>


                                                    <div class="row content-block-row">

                                                        <div class="col-md-4 form-input">
                                                            <label for="incidentdate" class="form-label require">Incident
                                                                Date</label>
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control datepicker"
                                                                    value="{{ displayDateformat($IncidentDetails->incident_date) }}"
                                                                    id="incidentdate" placeholder="Incident Date"
                                                                    name="incidentdate" readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="incidenttime" class="form-label require">Incident
                                                                Time</label>
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control clockpicker"
                                                                    value="{{ $IncidentDetails->incident_time }}"
                                                                    id="incidenttime" placeholder="Incident Time"
                                                                    name="incidenttime" readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-clock"></span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 form-input">
                                                            <label for="weather_condition"
                                                                class="form-label require">Weather Condition</label>
                                                            <select name="weather_condition" id="weather_condition"
                                                                required data-id="wether_other"
                                                                class="form-control select2 othersshow">
                                                                <option value="">Select Weather Condition</option>
                                                                @foreach ($weatherconditionList as $weathercondition)
                                                                    <option @selected($IncidentDetails->weather_condition == $weathercondition->id)
                                                                        value="{{ encryptId($weathercondition->id) }}">
                                                                        {{ $weathercondition->item_name }}</option>
                                                                @endforeach
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>


                                            </div>
                                            <div class="row g-3 px-4 pt-4 form-input content-block-row">
                                                <label for="company" class="form-label require">Company</label>
                                                @foreach ($companyDetails as $company)
                                                    <div class="col-md-3">
                                                        <div class="">
                                                            <input class="form-check-input " type="radio" required
                                                                @checked($IncidentDetails->company_id == $company->id)
                                                                value="{{ encryptId($company->id) }}" name="company"
                                                                id="company_{{ encryptId($company->id) }}">
                                                            <label class="form-check-label"
                                                                for="company_{{ encryptId($company->id) }}">{{ $company->company_name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="col-md-4 form-input">
                                                    <label for="location" class="form-label require">Location</label>
                                                    <select name="location" id="location" required
                                                        class="form-control select2">
                                                        <option value="">Select Location</option>

                                                        @foreach ($locationDetails as $location)
                                                            <option  @selected($IncidentDetails->location_id == $location->id) value="{{ encryptId($location->id) }}">
                                                                {{ $location->location_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="specific_location" class="form-label require">Specific
                                                        Location</label>

                                                    <select name="specific_location" id="specific_location" required
                                                        class="form-control select2">
                                                        <option value="">Select Specific Location</option>
                                                        @foreach ($specificlocationDetails as $specificlocation)
                                                        <option  @selected($IncidentDetails->specific_location_id == $specificlocation->id) value="{{ encryptId($specificlocation->id) }}">
                                                            {{ $specificlocation->specific_loc_name }}</option>
                                                    @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="content-block">

                                        <div class="card-header card-header-inner mt-3 content-block-header">
                                            <h6 class="text-white">PART B : CATEGORY OF INCIDENT</h6>
                                        </div>

                                        @php
                                            $category_of_incident = $IncidentDetails->category_of_incident;

                                            if ($category_of_incident != '' && $category_of_incident != null) {
                                                $categoryofincidentArray = json_decode($category_of_incident, true);
                                            } else {
                                                $categoryofincidentArray = [];
                                            }

                                        @endphp


                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

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
                                                                            name="category_of_incident[{{ $categoryofincident->id }}][{{ $subcategoryofincident->id }}][value]"
                                                                            id="category_of_incident_{{ encryptId($subcategoryofincident->id) }}"
                                                                            {{ $checkvalue }} value="YES"
                                                                            data-id="show_others_{{ encryptId($subcategoryofincident->id) }}"
                                                                            class=" @if ($subcategoryofincident->other_params != '' && $subcategoryofincident->other_params != null) othersshow @endif">
                                                                        <label
                                                                            for="category_of_incident_{{ encryptId($subcategoryofincident->id) }}">{{ $subcategoryofincident->subitem_name }}</label>
                                                                        @if ($subcategoryofincident->other_params != '' && $subcategoryofincident->other_params != null)
                                                                            <div id="show_others_{{ encryptId($subcategoryofincident->id) }}"
                                                                                style="@if ($checkvalue == '') display: none @endif">
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
                                                                                                @php
                                                                                                    if (
                                                                                                        isset(
                                                                                                            $categoryofincidentArray[
                                                                                                                $categoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $subcategoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $param
                                                                                                                    ->data_name
                                                                                                            ],
                                                                                                        )
                                                                                                    ) {
                                                                                                        $value =
                                                                                                            $categoryofincidentArray[
                                                                                                                $categoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $subcategoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $param
                                                                                                                    ->data_name
                                                                                                            ];
                                                                                                    } else {
                                                                                                        $value = '';
                                                                                                    }

                                                                                                @endphp

                                                                                                <div class="form-input">
                                                                                                    <input class="form-control"
                                                                                                        required type="text"
                                                                                                        value="{{ $value }}"
                                                                                                        name="category_of_incident[{{ $categoryofincident->id }}][{{ $subcategoryofincident->id }}][{{ $param->data_name }}]"
                                                                                                        id="{{ $param->data_name }}">
                                                                                                </div>
                                                                                            @break

                                                                                            @case('select_single')
                                                                                            @case('select_multiple')
                                                                                                @php
                                                                                                    if (
                                                                                                        isset(
                                                                                                            $categoryofincidentArray[
                                                                                                                $categoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $subcategoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $param
                                                                                                                    ->data_name
                                                                                                            ],
                                                                                                        )
                                                                                                    ) {
                                                                                                        $value =
                                                                                                            $categoryofincidentArray[
                                                                                                                $categoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $subcategoryofincident
                                                                                                                    ->id
                                                                                                            ][
                                                                                                                $param
                                                                                                                    ->data_name
                                                                                                            ];
                                                                                                    } else {
                                                                                                        $value = '';
                                                                                                    }

                                                                                                @endphp

                                                                                                @php
                                                                                                    $listitems = string_to_array(
                                                                                                        $param->data_list,
                                                                                                    );
                                                                                                @endphp
                                                                                                <div class="form-input">
                                                                                                    <select
                                                                                                        name="category_of_incident[{{ $categoryofincident->id }}][{{ $subcategoryofincident->id }}][{{ $param->data_name }}]"
                                                                                                        required
                                                                                                        class="form-control select2"
                                                                                                        style="width:100%;"
                                                                                                        id="">
                                                                                                        <option value="">
                                                                                                            Select
                                                                                                            {{ $param->name }}
                                                                                                        </option>
                                                                                                        @foreach ($listitems as $list)
                                                                                                            <option
                                                                                                                @selected($value == $list)
                                                                                                                value="{{ $list }}">
                                                                                                                {{ $list }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>
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
                                                            $casualitydetailsArray = json_decode(
                                                                $casuality_details,
                                                                true,
                                                            );
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
                                                        <input {{ $staffchecked }} class="othersshow"
                                                            data-id="injuries_staff_div" type="checkbox"
                                                            name="injuries[staff][value]" value="YES"
                                                            id="injuries_staff">
                                                        <label for="injuries_staff">Staff</label>
                                                    </div>
                                                    <div id="injuries_staff_div"
                                                        style="@if ($staffchecked == '') display: none @endif">
                                                        @foreach ($companyDetails as $company)
                                                            <div class="row mb-1">
                                                                <div class="col-md-3">
                                                                    <label
                                                                        for="">{{ $company->company_name }}</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $casualitydetailsArray['staff'][$company->id] }}"
                                                                        name="injuries[staff][{{ $company->id }}]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div>
                                                        <input class="othersshow" data-id="injuries_contractor_div"
                                                            {{ $contractorchecked }} type="checkbox"
                                                            name="injuries[contractor][value]" value="YES"
                                                            id="injuries_contractor">
                                                        <label for="injuries_contractor">Contractor</label>
                                                    </div>
                                                    <div id="injuries_contractor_div"
                                                        style="@if ($contractorchecked == '') display: none @endif">
                                                        <input type="text" name="injuries[contractor][count]"
                                                            value="{{ $casualitydetailsArray['contractor']['count'] }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div>
                                                        <input class="othersshow" data-id="injuries_port_user_div"
                                                            {{ $portuserchecked }} type="checkbox"
                                                            name="injuries[portuser][value]" value="YES"
                                                            id="injuries_port_user">
                                                        <label for="injuries_port_user">Port User</label>
                                                    </div>
                                                    <div id="injuries_port_user_div"
                                                        style="@if ($portuserchecked == '') display: none @endif">
                                                        <input type="text" name="injuries[portuser][count]"
                                                            value="{{ $casualitydetailsArray['portuser']['count'] }}"
                                                            class="form-control" id="">
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
                                                            {{ $staffchecked }} type="checkbox"
                                                            name="fatalities[staff][value]" value="YES"
                                                            id="fatalities_staff">
                                                        <label for="fatalities_staff">Staff</label>
                                                    </div>
                                                    <div id="fatalities_staff_div"
                                                        style="@if ($staffchecked == '') display: none @endif">
                                                        @foreach ($companyDetails as $company)
                                                            <div class="row mb-1">
                                                                <div class="col-md-3">
                                                                    <label
                                                                        for="">{{ $company->company_name }}</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $fatalitydetailsdetailsArray['staff'][$company->id] }}"
                                                                        name="fatalities[staff][{{ $company->id }}]"
                                                                        id="">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div>
                                                        <input class="othersshow" data-id="fatalities_contractor_div"
                                                            {{ $contractorchecked }} type="checkbox"
                                                            name="fatalities[contractor][value]" value="YES"
                                                            id="fatalities_contractor"> <label
                                                            for="fatalities_contractor">Contractor</label>
                                                    </div>
                                                    <div id="fatalities_contractor_div"
                                                        style="@if ($contractorchecked == '') display: none @endif">
                                                        <input type="text" name="fatalities[contractor][count]"
                                                            value="{{ $fatalitydetailsdetailsArray['contractor']['count'] }}"
                                                            class="form-control" id="">
                                                    </div>
                                                    <div>
                                                        <input class="othersshow" data-id="fatalities_port_user_div"
                                                            {{ $portuserchecked }} type="checkbox"
                                                            name="fatalities[portuser][value]" value="YES"
                                                            id="fatalities_port_user">
                                                        <label for="fatalities_port_user">Port User</label>
                                                    </div>
                                                    <div id="fatalities_port_user_div"
                                                        style="@if ($portuserchecked == '') display: none @endif">
                                                        <input type="text" name="fatalities[portuser][count]"
                                                            value="{{ $fatalitydetailsdetailsArray['portuser']['count'] }}"
                                                            class="form-control" id="">
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
                                                        <input type="checkbox" name="incident_potential[]" required
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

                                        @php
                                            $authorities_inform = string_to_array($IncidentDetails->authorities_inform);

                                        @endphp

                                        <div class="content-block-body">
                                            <div class="row g-3 px-4 pt-4 content-block-row">

                                                <div class="row form-input">
                                                    <label for="" class="form-label require">AUTHORITIES
                                                        INFORM </label>

                                                    @foreach ($authoritiesinformList as $authoritiesinform)
                                                        <div class="col-md-3 mb-2">
                                                            <input type="checkbox" name="authorities_inform[]" required
                                                                @checked(in_array($authoritiesinform->id, $authorities_inform))
                                                                class="validate-checkbox-required" required
                                                                id="authorities_inform_{{ encryptId($authoritiesinform->id) }}"
                                                                value="{{ encryptId($authoritiesinform->id) }}">
                                                            <label class="form-label"
                                                                for="authorities_inform_{{ encryptId($authoritiesinform->id) }}">{{ $authoritiesinform->item_name }}</label>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-md-3 mb-2">
                                                        <input type="checkbox" name="authorities_inform[]"
                                                            class="validate-checkbox-required othersshow" required
                                                            @checked(in_array('others', $authorities_inform))
                                                            data-id="authorities_inform_others_div"
                                                            id="authorities_inform_others" value="others">
                                                        <label class="form-label"
                                                            for="authorities_inform_others">Others</label>
                                                    </div>
                                                    <div class="col-md-3 mb-2 form-input"
                                                        id="authorities_inform_others_div"
                                                        style="@if (!in_array('others', $authorities_inform)) display: none @endif">
                                                        <input type="text" name="authorities_inform_others_text"
                                                            required class="form-control"
                                                            value="{{ $IncidentDetails->authorities_inform_other }}"
                                                            id="authorities_inform_others_text">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 form-input">
                                                        <label for="date_informed" class="form-label require">Date
                                                            Informed</label>
                                                        <div class="input-group date">
                                                            <input type="text" class="form-control datepicker" required
                                                                value="{{ displayDateformat($IncidentDetails->date_of_informed) }}"
                                                                id="date_informed" placeholder="Date Informed"
                                                                name="date_informed" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
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
                                                    <textarea name="brief_description" id="brief_description" required class="form-control" rows="10">{{ $IncidentDetails->brief_description_of_incident }}</textarea>
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
                                                    <textarea name="mitigation_action" id="mitigation_action" required class="form-control" rows="10">{{ $IncidentDetails->mitigation_action }}</textarea>
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
                                                    <textarea name="additional_information" id="additional_information" required class="form-control" rows="10">{{ $IncidentDetails->additional_information }}</textarea>
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
                                                                                @checked($selectedvalue == $range)
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
                                                    <input type="text" name="" id=""
                                                        value="{{ getusername($IncidentDetails->created_by) }}"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime"
                                                        class="form-label require">Designation</label>
                                                    <input type="text" name="" id=""
                                                        value=" {{ getuser($IncidentDetails->created_by)->user_designation_name }}"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="incidenttime" class="form-label require">Date and
                                                        Time</label>
                                                    <input type="text" name="" id=""
                                                        value="{{ displayDatetimeformat($IncidentDetails->created_at) }}"
                                                        class="form-control" readonly>
                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="incidentremarks" class="form-label require">Incident
                                                        Remarks</label>
                                                    <textarea name="incident_remarks" id="incident_remarks" class="form-control" rows="5">{{ $IncidentDetails->incident_remarks }}</textarea>
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
    <script type="text/javascript">
        $(function() {
            $('#incident_add').validate({
                rules: {
                    incident_type: {
                        required: true,
                    },
                    emergency_incident_tier: {
                        required: true,
                    },
                    typeofnotification: {
                        required: true,
                    },
                    inc_location: {
                        required: true,
                    },
                    incidentdate: {
                        required: true,
                    },
                    incidenttime: {
                        required: true,
                    },
                    weather_condition: {
                        required: true,
                    },
                    wether_other: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    specific_location: {
                        required: true,
                    },
                    "incident_potential[]": {
                        required: true,
                    },
                    "authorities_inform[]": {
                        required: true,
                    },
                    authorities_inform_others_text: {
                        required: true,
                    },
                    date_informed: {
                        required: true,
                    },
                    brief_description: {
                        required: true,
                    },
                    mitigation_action: {
                        required: true,
                    },
                    additional_information: {
                        required: true,
                    },
                    incident_remarks: {
                        required: true,
                    },

                },
                messages: {
                    incident_type: {
                        required: "Please select Incident Type",
                    },
                    emergency_incident_tier: {
                        required: "Please select Emergency Incident Tier",
                    },
                    typeofnotification: {
                        required: "Please select Type Of Notification"
                    },
                    inc_location: {
                        required: "Please select Location",
                    },
                    incidentdate: {
                        required: "Please select Incident Date",
                    },
                    incidenttime: {
                        required: "Please select Incident Time",
                    },
                    weather_condition: {
                        required: "Please select the Weather Condition",
                    },
                    wether_other: {
                        required: "Please enter the Weather Condition Other",
                    },
                    company: {
                        required: "Please select Company",
                    },
                    location: {
                        required: "Please select Location",
                    },
                    specific_location: {
                        required: "Please select Specific Location",
                    },
                    "incident_potential[]": {
                        required: "Please select Incident Potential",
                    },
                    "authorities_inform[]": {
                        required: "Please select Authorities Inform",
                    },
                    authorities_inform_others_text: {
                        required: "Please enter other Authorities Inform",
                    },
                    date_informed: {
                        required: "Please select Date Informed",
                    },
                    brief_description: {
                        required: "Please enter the Brief Description Of Incident",
                    },
                    mitigation_action: {
                        required: "Please enter the Mitigation Action",
                    },
                    additional_information: {
                        required: "Please enter the Additional Information",
                    },
                    incident_remarks: {
                        required: "Please enter the Remarks",
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


        $('input[name=company]').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('location/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#location').empty().append(
                            '<option value="">Select Location</option>');
                        $.each(data, function(key, value) {
                            $('#location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#location').trigger('change.select2');

                        $('#specific_location').empty().append(
                            '<option value="">Select Specific Location</option>');
                        $('#specific_location').trigger('change.select2');
                    }
                });
            } else {
                $('#location').empty().append('<option value="">Select Location</option>');
                $('#location').trigger('change.select2');
                $('#specific_location').empty().append('<option value="">Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
            }
        });


        $('#location').change(function() {
            var locationId = $(this).val();
            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/list/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#specific_location').empty().append(
                            '<option >Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            $('#specific_location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#specific_location').trigger('change.select2');
                    }
                });
            } else {
                $('#specific_location').empty().append('<option >Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
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
    </script>
@endpush
