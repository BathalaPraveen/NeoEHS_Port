@extends('admin.layouts.layout')
@section('title', 'General PTW View')
@section('pageurl', admin_url('ptw/general/list'))

@push('style')
    <style>
        #general_ptw_add {
            color: #000;
        }

        #general_ptw_add .form-check-label {
            display: inline;
        }

        .col-form-label {
            font-weight: 500;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .ptwdetails label {
            font-weight: bold;
        }

        .jsa_list {
            border: 1px dotted #ccc;
            padding: 10px;
            margin-bottom: 5px;
        }

        .jsa_list:nth-child(even) {
            background-color: #cfcfcf70;
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
                                <a href="{{ admin_url('ptw/general/list') }}">General PTW</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">General PTW View</li>
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
                                    <h5 class="card-title">General PTW View - {{ $general->ptw_id }}</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/general/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            @include('ptw.general.ptw_steps')

                            <div class=" border rounded ptwdetails">
                                <div class="card-header card-header-inner  mb-3 mt-3">
                                    <h6 class="text-white">SECTION A - APPLICATION</h6>
                                </div>

                                <div class="row g-3 px-4 pt-1">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-striped">
                                            <tbody>
                                                <tr>
                                                    <td><label class="require">Name @if ($isContractor == 1)
                                                                / Contractor Company
                                                            @endif
                                                        </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>{{ getusername($general->created_by) }} @if ($isContractor == 1)
                                                            / {{ $contractorCompanyName }}
                                                        @endif
                                                    </td>
                                                    <td><label class="require">Comapny</label></td>
                                                    <td>:</td>
                                                    <td>{{ getCompanyName(getUser($general->created_by)?->company) }}
                                                    </td>
                                                    <td><label class="require">Designation</label></td>
                                                    <td>:</td>
                                                    <td>{{ getUser($general->created_by)?->user_designation_name }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td><label class="">Contact Number</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $general->contact_number }}

                                                    </td>
                                                    <td><label class="require">Email</label></td>
                                                    <td>:</td>
                                                    <td>{{ getUser($general->created_by)?->email }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><label class="">Date of Application</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        <div>
                                                            {{ displayDateformat($general->date_of_application) }}
                                                        </div>


                                                    </td>
                                                    <td><label class="">Date of Commencement</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        <div>
                                                            {{ displayDateformat($general->date_of_commencement) }}
                                                        </div>


                                                    </td>
                                                    <td><label class="">Date of Completion</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        <div>
                                                            {{ displayDateformat($general->date_of_completion) }}
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <label class="require">
                                                            Area of Work (Tick where
                                                            applicable)
                                                        </label>

                                                    </td>
                                                    <td> : </td>
                                                    <td colspan="4">
                                                        <div class="row">
                                                            @foreach ($companyDetails as $company)
                                                                <div class="col-md-3">
                                                                    <div class="form-input">

                                                                        @if ($general->area_of_work == $company->id)
                                                                            <i class="fa-solid fa-check"
                                                                                style="color: #267709;"></i>
                                                                        @else
                                                                            <i class="fa fa-dot-circle-o"
                                                                                style="color: #f72626;"></i>
                                                                        @endif


                                                                        <label class="form-check-label"
                                                                            for="company_{{ encryptId($company->id) }}">{{ $company->company_name }}</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label class="require">Location</label> </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            {{ getLocationName($general->location) }}

                                                        </div>

                                                    </td>
                                                    <td><label class="">Specific Location</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ getSpecificLocationName($general->specific_location) }}

                                                    </td>
                                                    <td><label class="">Others</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $general->other_location }}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><label class="require">Area Owner</label> </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            {{ getUserName($general->area_owner) }}

                                                        </div>

                                                    </td>
                                                    <td><label class="">Work Type</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ getWorkTypeName($general->work_type) }}

                                                    </td>
                                                    <td><label class="">Supervising Authority</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ getUserName($general->supervising_authority) }}

                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td colspan="1">
                                                        <label class="require">Work Description</label>
                                                    </td>
                                                    <td> : </td>
                                                    <td colspan="7">
                                                        <div class="form-input">
                                                            {{ $general->work_description }}
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- <tr>
                                                    <td colspan="1">
                                                        <label class="">
                                                            Job Hazard Analysis
                                                        </label>

                                                    </td>
                                                    <td> : </td>
                                                    <td colspan="7">
                                                        {{ $general->job_hazard_analysis }}

                                                    </td>
                                                </tr> --}}



                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <hr>

                                <div class="card-header card-header-inner  mb-3 ">
                                    <h6 class="text-white"> SECTION B - HAZARDOUS ACTIVITY / HAZARD</h6>
                                </div>
                                <div class="row g-3 px-4 pt-1">

                                    @php

                                        $hazardData = json_decode($general->hazard);

                                        if ($hazardData == '' || $hazardData == null) {
                                            $hazardData = new stdClass();
                                            $hazardData->hazard = [];
                                            $hazardData->hazard_others_text = '';
                                        }

                                    @endphp

                                    <div class=" mb-3 div-striped">
                                        <div class="row">
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($hazardDetails as $hazard)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">

                                                        </span>

                                                        @if (in_array($hazard->id, $hazardData->hazard))
                                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                        @else
                                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                        @endif


                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($hazard->id) }}">{{ $hazard->category_name }}</label>
                                                    </div>
                                                    <div class="px-2">
                                                        @if ($hazard->input_type == 2)
                                                            @if (isset($hazardfile[$hazard->id]))
                                                                <div>
                                                                    <a href="{{ url($hazardfile[$hazard->id]['file_path']) }}"
                                                                        target="_blank">{{ $hazardfile[$hazard->id]['file_orgname'] }}</a>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($i % 4 == 0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach

                                            <div class="col-md-3">

                                                <div class="m-2">
                                                    <span style="">

                                                    </span>

                                                    @if (in_array(0, $hazardData->hazard))
                                                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                    @else
                                                        <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                    @endif

                                                    <label class="form-check-label" for="hazard_others">Others
                                                        @if (in_array(0, $hazardData->hazard))
                                                            - {{ $hazardData->hazard_others_text }}
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="card-header card-header-inner  mb-3 ">
                                    <h6 class="text-white">SECTION C - SUPPORTING CERTIFICATE / DOCUMENT - where
                                        applicable</h6>
                                </div>


                                <div class="row g-3 px-4 pt-1">

                                    @php

                                        $documentData = json_decode($general->supporting_documents);

                                        if ($documentData == '' || $documentData == null) {
                                            $documentData = new stdClass();
                                            $documentData->supportcertificate = [];
                                            $documentData->supportcertificate_data = '';
                                        }

                                    @endphp

                                    <div class="div-striped">

                                        @php
                                            $i = 1;
                                        @endphp

                                        <div class="row ">
                                            @foreach ($supportCertificate as $certificate)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">

                                                        </span>


                                                        @if (in_array($certificate->id, $documentData->supportcertificate))
                                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                        @else
                                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                        @endif

                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($certificate->id) }}">{{ $certificate->category_name }}
                                                            @php
                                                                $col_name = $certificate->id;
                                                            @endphp

                                                            @if ($certificate->input_type == 1)
                                                                @if (in_array($certificate->id, $documentData->supportcertificate))
                                                                    <div class="font-weight-bold">
                                                                        {{ $documentData->supportcertificate_data->$col_name }}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                @if (isset($supportCertificateFile[$certificate->id]))
                                                                    <div>
                                                                        <a href="{{ url($supportCertificateFile[$certificate->id]['file_path']) }}"
                                                                            target="_blank">{{ $supportCertificateFile[$certificate->id]['file_orgname'] }}</a>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                                @if ($i % 4 == 0)
                                        </div>
                                        <div class="row">
                                            @endif
                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach



                                        </div>

                                    </div>
                                </div>
                                <hr>


                                <div class="card-header card-header-inner  mb-3 ">
                                    <h6 class="text-white">SECTION D - PERSONAL PROTECTIVE EQUIPMENT - where
                                        applicable</h6>
                                </div>
                                <div class="row g-3 px-4 pt-1">

                                    @php
                                        $equipmentData = $general->equipment_details;

                                        if ($equipmentData == '' || $equipmentData == null) {
                                            $equipmentData = new stdClass();
                                            $equipmentData->equipments = [];
                                            $equipmentData->equipments_others_text = '';
                                        }

                                    @endphp

                                    <div class=" mb-3">
                                        @foreach ($protectiveEquipment as $equipment)
                                            <div class="col-md-12">
                                                <div class="row" style="background-color: #ccc;font-weight:bold;">
                                                    <div class="m-2">
                                                        <div style="text-decoration:underline">
                                                            {{ $equipment->category_name }}
                                                        </div>
                                                    </div>
                                                </div>

                                                @php
                                                    // Decode JSON string to object
                                                    $equipmentData = json_decode($general->equipment_details);

                                                    // Fallback if decoding fails or equipments not set
                                                    if (
                                                        !is_object($equipmentData) ||
                                                        !isset($equipmentData->equipments)
                                                    ) {
                                                        $equipmentData = new stdClass();
                                                        $equipmentData->equipments = [];
                                                    }
                                                @endphp
 
                                                <div class="row mb-3">
                                                    @if (isset($protectiveEquipmentItems[$equipment->id]))
                                                        @foreach ($protectiveEquipmentItems[$equipment->id] as $euipmentItems)
                                                            <div class="col-md-3">
                                                                <div class="m-2">
                                                                    @if (in_array($euipmentItems['id'], $equipmentData->equipments))
                                                                        <i class="fa-solid fa-check"
                                                                            style="color: #267709;"></i>
                                                                    @else
                                                                        <i class="fa fa-dot-circle-o"
                                                                            style="color: #f72626;"></i>
                                                                    @endif

                                                                    <label class="form-check-label"
                                                                        for="equipment_{{ encryptId($euipmentItems['id']) }}">
                                                                        {{ $euipmentItems['item_name'] }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>

                                            </div>
                                        @endforeach

                                        <div class="col-md-3">

                                            <div class="m-2">
                                                <span style="">

                                                </span>

                                                @if (in_array(0, $equipmentData->equipments))
                                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                @else
                                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                @endif

                                                <label class="form-check-label" for="equipment_other">Others

                                                    @if (in_array(0, $equipmentData->equipments))
                                                        -
                                                        {{ $equipmentData->equipments_others_text }}
                                                    @endif

                                                </label>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <hr>

                                <div class="card-header card-header-inner  mb-3 ">
                                    <h6 class="text-white">SECTION E - WORK SITE PREPARATION / PRECAUTIONS - where
                                        applicable</h6>
                                </div>
                                <div class="row g-3 px-4 pt-1">

                                    @php
                                        $siteData = json_decode($general->site_preparation);

                                        if ($siteData == '' || $siteData == null) {
                                            $siteData = new stdClass();
                                            $siteData->sitepreparation = [];
                                            $siteData->sitepreparation_others_text = '';
                                        }
                                    @endphp
                                    <div class="div-striped mb-3">
                                        <div class="row">
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($sitePreparationDetails as $sitePreparation)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">

                                                        </span>

                                                        @if (in_array($sitePreparation->id, $siteData->sitepreparation))
                                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                        @else
                                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                        @endif

                                                        <label class="form-check-label"
                                                            for="sitepreparation_{{ encryptId($sitePreparation->id) }}">{{ $sitePreparation->category_name }}</label>

                                                    </div>
                                                </div>

                                                @if ($i % 4 == 0)
                                        </div>
                                        <div class="row">
                                            @endif

                                            @php
                                                $i++;
                                            @endphp
                                            @endforeach

                                            <div class="col-md-3">

                                                <div class="m-2">
                                                    <span style="">

                                                    </span>

                                                    @if (in_array(0, $siteData->sitepreparation))
                                                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                                                    @else
                                                        <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                    @endif


                                                    {{-- <label class="form-check-label" for="sitepreparation_other">Are there
                                                        any other work activities around this work area
                                                        @if (in_array(0, $siteData->sitepreparation))
                                                            - {{ $siteData->sitepreparation_others_text }}
                                                        @endif
                                                    </label> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="card-header card-header-inner  ">
                                    <h6 class="text-white">SECTION F - JOB SAFETY ANALYSIS</h6>
                                </div>

                                <div class="row g-3 pl-2 pt-4">
                                    <div class="row pl-3">

                                        <div class="col-md-6">

                                            <div class="row">
                                                <h6 class="bold">LikeliHood</h6>
                                            </div>

                                            <div class="">

                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <th>LIKELIHOOD</th>
                                                        <th>EXAMPLE</th>
                                                        <th>RATING</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($likelihoodDetails as $likelihood)
                                                            <tr>
                                                                <td>{{ $likelihood->name }}</td>
                                                                <td>{{ $likelihood->example }}</td>
                                                                <td>{{ $likelihood->rating }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <h6 class="bold">Severity</h6>
                                            </div>

                                            <div class="">

                                                <table class="table table-bordered table-striped w-100">
                                                    <thead>
                                                        <th>SEVERITY</th>
                                                        <th>EXAMPLE</th>
                                                        <th>RATING</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($severityDetails as $severity)
                                                            <tr>
                                                                <td>{{ $severity->name }}</td>
                                                                <td>{{ $severity->example }}</td>
                                                                <td>{{ $severity->rating }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="row">
                                            <h6 class="bold">Risk Matrix</h6>
                                        </div>
                                        <div class="row mt-3 mx-3">
                                            <table class="table table-bordered table-striped">
                                                <tr>
                                                    <td></td>
                                                    <td colspan="{{ count($severityDetails) }}"
                                                        style="text-align: center ; font-weight:bold">
                                                        Severity(S)
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="text-align: center ; font-weight:bold">Likelihood(L)
                                                    </td>
                                                    @foreach (array_reverse($severityDetails->toArray()) as $severity)
                                                        <td>{{ $severity['rating'] }}</td>
                                                    @endforeach

                                                </tr>
                                                @foreach ($likelihoodDetails as $likelihood)
                                                    <tr>
                                                        <td style="width:10%">{{ $likelihood->rating }}</td>
                                                        @foreach (array_reverse($severityDetails->toArray()) as $severity)
                                                            @php
                                                                $value = $likelihood->rating * $severity['rating'];
                                                            @endphp
                                                            <td
                                                                style="background-color:{{ $riskmatrixDetails[$value]['color_code'] }}">
                                                                {{ $value }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>

                                            <hr>

                                            <div class="mb-2">
                                                <div class="d-lg-flex align-items-center ">

                                                    <div class="position-relative">
                                                        <h6 class="bold">JOB SAFETY ANALYSIS</h6>
                                                    </div>
                                                    <div class="ms-auto">
                                                        {{-- <button class="btn btn-primary" type="button"
                                                            id="addmore">Add</button> --}}
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div id="jsadetails">

                                                <div style="overflow-x: auto;">
                                                    <table class="table table-bordered"
                                                        style="min-width: 1500px; table-layout: fixed;">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th style="width: 200px;">SEQUENCE OF BASIC JOB STEPS</th>
                                                                <th style="width: 200px;">HAZARD CATEGORY</th>
                                                                <th style="width: 200px;">HAZARD (POTENTIAL INCIDENT)</th>
                                                                <th style="width: 200px;">WHO/WHAT MIGHT BE HARMED</th>
                                                                <th style="width: 200px;">CONTROL MEASURES OR RECOMMENDED
                                                                    ACTION</th>
                                                                <th style="width: 120px;">LIKELIHOOD</th>
                                                                <th style="width: 120px;">SEVERITY</th>
                                                                <th style="width: 150px;">RISK</th>
                                                                <th style="width: 250px;">ACTION / RESPONSIBLE PARTY</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($generalhazardDetails as $generalHazard)
                                                                <tr>
                                                                    <td>{{ $generalHazard->seq_of_bas_job_stp }}</td>
                                                                    <td>{{ $generalHazard->category_name }}</td>
                                                                    <td>
                                                                        {{ $generalHazard->subcategory_name }}
                                                                        @if ($generalHazard->hazard_category_incident_other)
                                                                            <div class="mt-1 text-muted small">
                                                                                {{ $generalHazard->hazard_category_incident_other }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $generalHazard->who_what_harmed }}</td>
                                                                    <td>{{ $generalHazard->seo_mea_or_rec_act_or_pro }}
                                                                    </td>
                                                                    <td>{{ $generalHazard->likelihood }}</td>
                                                                    <td>{{ $generalHazard->severity }}</td>
                                                                    <td>
                                                                        <span class="risk_matrix"
                                                                            id="risk_{{ $loop->iteration }}">
                                                                            @if ($generalHazard->risk_matrix)
                                                                                <span
                                                                                    style="background-color: {{ $riskmatrixDetails[$generalHazard->risk_matrix]['color_code'] }}; border:1px solid #ccc; height:35px; padding: 7px; width: 100px; display: block; text-align: center;">
                                                                                    {{ $generalHazard->risk_matrix }}
                                                                                </span>
                                                                            @endif

                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $generalHazard->action_responsible }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="card-header card-header-inner  mb-3 ">
                                    <h6 class="text-white">SECTION G - PERMIT ISSUANCE</h6>
                                </div>
                                <div class="row g-3 px-4 pt-1">

                                    <div class="col-md-12">

                                        <div class="m-2 form-input">

                                            <i class="fa-solid fa-check" style="color: #267709;"></i>

                                            <label class="form-check-label" for="accept_terms">I <b>fully
                                                    understand </b>& will <b>ensure compliance</b> with all the
                                                requirements of this permit.</label>
                                        </div>
                                    </div>

                                    <div class="row mb-3 mt-3">
                                        <label class="col-sm-2 col-form-label">
                                            Name</label>
                                        <div class="col-sm-4 form-input">
                                            {{ getusername($general->created_by) }}
                                        </div>
                                        <label class="col-sm-2 col-form-label form-input">
                                            Date & Time</label>
                                        <div class="col-sm-4 form-input">
                                            {{ displayDateformat($general->created_at) }}
                                        </div>
                                    </div>

                                    {{-- <div class="row mb-2">
                                        <label class="col-sm-2 col-form-label">
                                            Remarks</label>
                                        <div class="col-sm-10">
                                            {{ $general->application_remarks }}
                                        </div>
                                    </div> --}}
                                </div>

                                @if ($general->hold_by != null)
                                    <div class="card-header card-header-inner  mb-3 ">
                                        <h6 class="text-white">PTW Hold Details</h6>
                                    </div>
                                    <div class="row g-3 px-4 pt-1">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">Hold/Freeze By</label>
                                            <p>{{ getUserName($general->hold_by) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="" class="form-label">Hold/Freeze At</label>
                                            <p>{{ DisplayDateFormat($general->hold_at) }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="" class="form-label">Hold/Freeze Remarks</label>
                                            <p>{{ $general->hold_remarks }}</p>
                                        </div>

                                    </div>
                                @endif

                                @if ($general->unhold_by != null && $general->ptw_status != PERMIT_STATUS_PTW_HOLD)
                                    <div class="card-header card-header-inner  mb-3 ">
                                        <h6 class="text-white">PTW Un-Hold Details</h6>
                                    </div>
                                    <div class="row g-3 px-4 pt-1">
                                        <div class="col-md-4">
                                            <label for="" class="form-label">UnHold By</label>
                                            <p>{{ getUserName($general->unhold_by) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="" class="form-label">UnHold At</label>
                                            <p>{{ DisplayDateFormat($general->unhold_at) }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="" class="form-label">UnHold Remarks</label>
                                            <p>{{ $general->unhold_remarks }}</p>
                                        </div>

                                    </div>
                                @endif

                                @if (count($subpermitDetails) > 0)
                                    <hr>
                                    <div class="card-header card-header-inner  mb-3 ">
                                        <h6 class="text-white">Sub Work Permit</h6>
                                    </div>

                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                        @foreach ($subpermitDetails as $subpermit)
                                            @php
                                                $i = 1;
                                                $pagename =
                                                    'ptw.pages.' .
                                                    str_replace(' ', '', strtolower($subpermit->permit_name));
                                                $pagenameValue = str_replace(
                                                    ' ',
                                                    '',
                                                    strtolower($subpermit->permit_name),
                                                );
                                                switch ($subpermit->sub_permit_id) {
                                                    case PTW_SUB_PERMIT_GAS:
                                                        $applyurl = admin_url(
                                                            'ptw/gastest/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_ISOLATION:
                                                        $applyurl = admin_url(
                                                            'ptw/isolation/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_SURFACE:
                                                        $applyurl = admin_url(
                                                            'ptw/surfacepenetration/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_HOTWORK:
                                                        $applyurl = admin_url(
                                                            'ptw/hotwork/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_WORKTRAFFIC:
                                                        $applyurl = admin_url(
                                                            'ptw/worktraffic/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_LIFTING:
                                                        $applyurl = admin_url(
                                                            'ptw/lifting/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                    case PTW_SUB_PERMIT_DIVING:
                                                        $applyurl = admin_url(
                                                            'ptw/diving/add/' . encryptId($general->id),
                                                        );
                                                        break;
                                                }
                                            @endphp
                                            <div class="accordion-item">
                                                <h2 class="accordion-header"
                                                    id="panelsStayOpen-heading-{{ $pagenameValue }}">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#panelsStayOpen-{{ $pagenameValue }}"
                                                        aria-expanded="false"
                                                        aria-controls="panelsStayOpen-{{ $pagenameValue }}">
                                                        {{ $subpermit->permit_name }} <span class="mx-2"></span>
                                                        {!! subpermitStatus($subpermit->sub_permit_status) !!}
                                                    </button>
                                                </h2>
                                                <div id="panelsStayOpen-{{ $pagenameValue }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="panelsStayOpen-heading-{{ $pagenameValue }}">
                                                    <div class="accordion-body">
                                                        @if ($subpermit->sub_permit_status != 0)
                                                            @include($pagename)
                                                        @else
                                                            @include('ptw.pages.nodata')
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </div>
                                    <hr>
                                @endif

                                @if (count($generalpermitStatusLog) > 0)
                                    <hr>
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">APPROVAL</h6>
                                    </div>
                                    @foreach ($generalpermitStatusLog as $statusLog)
                                        <div class="row  px-3">
                                            <div class="col-md-12">
                                                <table class="table mb-0 table-borderless">
                                                    <tbody>
                                                        <tr style="background-color: #aaa">
                                                            <td colspan="6" style="font-weight:500;"> Status -
                                                                {!! permitStatus($statusLog->to_status) !!} </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 10%">Name</th>
                                                            <td style="width: 5%">:</td>
                                                            <td style="width: 30%">
                                                                {{ getusername($statusLog->approved_by) }}</td>
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

                                @if (count($reassignLog) > 0)
                                    <hr>
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Re-Assign Log</h6>
                                    </div>
                                    <div class="row  px-3">
                                        <div class="col-md-12">
                                            <table class="table mb-0 table-striped table-bordered datatable-list">
                                                <tbody>
                                                    <tr class="table-primary">
                                                        <th>SNo</th>
                                                        <th>Action</th>
                                                        <th>From Assigned Person</th>
                                                        <th>Assigned To</th>
                                                        <th>Assigned At</th>
                                                        <th>Remarks</th>
                                                    </tr>
                                                    @foreach ($reassignLog as $log)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{!! getReassignType($log->type) !!}</td>
                                                            <td>{{ getUserName($log->from_assigned_person) }}</td>
                                                            <td>{{ getUserName($log->assign_to) }}</td>
                                                            <td>{{ displayDateTimeformat($log->created_at) }}</td>
                                                            <td>{{ $log->reassign_remarks }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                @if (
                                    $general->ptw_status == PERMIT_STATUS_AO_PENDING &&
                                        ($general->area_owner == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'aoapprove')
                                        <form action="{{ admin_url('ptw/general/aoapprovereject/submit') }}"
                                            method="POST">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Approve / Reject</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control" name="approvedby"
                                                                id="approvedby" value="{{ Auth::user()->name }}"
                                                                readonly>


                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control"
                                                                name="approveddate" id="approveddate"
                                                                value="{{ todayDate() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                            type="submit" name="reject" value="yes"
                                                            title="submit">Reject</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="approve" value="yes" data-bs-toggle="tooltip"
                                                            title="Approve">Approve</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif

                                @if (
                                    $general->ptw_status == PERMIT_STATUS_GHSE_PENDING &&
                                        (CheckUserRole(ROLE_GHSE_APPROVER) || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'ghseapprove')
                                        <form action="{{ admin_url('ptw/general/ghseapprovereject/submit') }}"
                                            method="POST">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Approve / Reject</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control" name="approvedby"
                                                                id="approvedby" value="{{ Auth::user()->name }}"
                                                                readonly>


                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control"
                                                                name="approveddate" id="approveddate"
                                                                value="{{ todayDate() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                            type="submit" name="reject" value="yes"
                                                            title="submit">Reject</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="approve" value="yes" data-bs-toggle="tooltip"
                                                            title="Approve">Approve</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif

                                @if (
                                    $general->ptw_status == PERMIT_STATUS_SA_PENDING &&
                                        ($general->supervising_authority == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'saapprove')
                                        <form action="{{ admin_url('ptw/general/saapprovereject/submit') }}"
                                            method="POST">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Approve / Reject</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control" name="approvedby"
                                                                id="approvedby" value="{{ Auth::user()->name }}"
                                                                readonly>


                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control"
                                                                name="approveddate" id="approveddate"
                                                                value="{{ todayDate() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                            type="submit" name="reject" value="yes"
                                                            title="submit">Reject</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="approve" value="yes" data-bs-toggle="tooltip"
                                                            title="Approve">Approve</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif

                                @if (
                                    $general->ptw_status == PERMIT_STATUS_PTW_APPROVED &&
                                        ($general->created_by || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'close')
                                        <form action="{{ admin_url('ptw/general/ptwclose/submit') }}" method="POST">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Approve / Reject</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control" name="approvedby"
                                                                id="approvedby" value="{{ Auth::user()->name }}"
                                                                readonly>
                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control"
                                                                name="approveddate" id="approveddate"
                                                                value="{{ todayDate() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="approve" value="yes" data-bs-toggle="tooltip"
                                                            title="Close">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif

                                {{-- reassign --}}
                                @if (
                                    $general->ptw_status == PERMIT_STATUS_AO_PENDING &&
                                        ($general->area_owner == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'reassign')
                                        <form action="{{ admin_url('ptw/general/AOreassign/submit') }}" method="POST"
                                            id="AOreassign">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Area Owner Reassign</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <input type="text" class="form-control"
                                                                value="{{ Auth::user()->name }}" readonly>
                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <input type="text" class="form-control"
                                                                value="{{ todayDateTime() }}" readonly>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label form-input require">
                                                            Assign To</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <select name="reassigned_area_owner"
                                                                id="reassigned_area_owner" class="form-control select2">
                                                                <option value="">Select Area Owner</option>
                                                                @foreach ($job_owners as $job_owner)
                                                                    <option value="{{ encryptId($job_owner) }}">
                                                                        {{ getUserName($job_owner) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10 form-input">
                                                            <textarea name="reassign_remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button type="reset" class="btn btn-danger "
                                                            data-bs-toggle="tooltip" title="Reset">Reset</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            data-bs-toggle="tooltip" title="Submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif

                                @if (
                                    $general->ptw_status == PERMIT_STATUS_SA_PENDING &&
                                        ($general->supervising_authority == Auth::id() || isAdmin() || CheckUserRole(ROLE_HSEUSER)))
                                    @if (isset($approvetype) && $approvetype == 'reassign')
                                        <form action="{{ admin_url('ptw/general/SAreassign/submit') }}" method="POST"
                                            id="SAreassign">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Supervising Authority Reassign</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($general->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <input type="text" class="form-control"
                                                                value="{{ Auth::user()->name }}" readonly>
                                                        </div>
                                                        <label class="col-sm-2 col-form-label form-input">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <input type="text" class="form-control"
                                                                value="{{ todayDateTime() }}" readonly>
                                                        </div>

                                                        <label class="col-sm-2 col-form-label form-input require">
                                                            Assign To</label>
                                                        <div class="col-sm-4 form-input mb-3">
                                                            <select name="reassigned_supervising_authority"
                                                                id="reassigned_supervising_authority"
                                                                class="form-control select2">
                                                                <option value="">Select Supervising Authority
                                                                </option>
                                                                @foreach ($supervising_authority as $sa)
                                                                    <option value="{{ encryptId($sa) }}">
                                                                        {{ getUserName($sa) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 ">
                                                        <label class="col-sm-2 col-form-label require">
                                                            Remarks</label>
                                                        <div class="col-sm-10 form-input">
                                                            <textarea name="reassign_remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button type="reset" class="btn btn-danger "
                                                            data-bs-toggle="tooltip" title="Reset">Reset</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            data-bs-toggle="tooltip" title="Submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
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
    <script type="text/javascript">
        $(function() {

            $('#AOreassign').validate({
                rules: {
                    reassigned_area_owner: {
                        required: true,
                    },
                    reassign_remarks: {
                        required: true,
                    },
                },
                messages: {
                    reassigned_area_owner: {
                        required: "Please Select Area Owner",
                    },
                    reassign_remarks: {
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
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });

            $('#SAreassign').validate({
                rules: {
                    reassigned_supervising_authority: {
                        required: true,
                    },
                    reassign_remarks: {
                        required: true,
                    },
                },
                messages: {
                    reassigned_supervising_authority: {
                        required: "Please Select Supervising Authority",
                    },
                    reassign_remarks: {
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
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endpush
