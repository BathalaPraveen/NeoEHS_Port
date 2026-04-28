@extends('admin.layouts.layout')
@section('title', 'General PTW Add')
@section('pageurl', admin_url('ptw/general/list'))

@push('style')
    <style>
        #general_ptw_add {
            color: #000;
        }

        #general_ptw_add .form-check-label {
            display: inline;
        }

        table label {
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

        .hazard-label {
            background-color: #e8f0fa;
            border: 1px solid #cbd9e9;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            gap: 8px;
            cursor: pointer;
        }

        .hazard-label:hover {
            background-color: #d6e4f2;
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
                            <li class="breadcrumb-item active" aria-current="page">General PTW Add</li>
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
                                    <h5 class="card-title">General PTW Add</h5>
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

                            <form id="general_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/general/add/submit') }}">
                                @csrf


                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mt-3">
                                        <h6 class="text-white">SECTION A - APPLICATION</h6>
                                    </div>
                                    <div class="row g-3 px-4 pt-4">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-striped">
                                                <tbody>
                                                    <tr>
                                                        <td><label class="require">Name</label></td>
                                                        <td>:</td>
                                                        <td>{{ Auth::user()->name }}</td>
                                                        <td><label class="require">Company</label></td>
                                                        <td>:</td>
                                                        <td>{{ getCompanyName(Auth::user()->company) }}</td>
                                                        <td><label class="require">Designation</label></td>
                                                        <td>:</td>
                                                        <td>{{ Auth::user()->user_designation_name }}</td>

                                                    </tr>
                                                    <tr>

                                                        <td><label class="">Contact Number</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <input type="text" class="form-control" name="contactnumber">
                                                        </td>

                                                        <td><label class="require">Email</label></td>
                                                        <td>:</td>
                                                        <td>{{ Auth::user()->email }}</td>


                                                    </tr>

                                                    <tr>
                                                        <td><label class="require">Date of Application</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control"
                                                                    value="{{ todaydate() }}" name="dateofapplication"
                                                                    id="dateofapplication" readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td><label class="require">Date of Commencement</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="input-group date form-input">
                                                                <input type="text"
                                                                    class="form-control datepickerthreemonth"
                                                                    id="dateofcommencement" name="dateofcommencement"
                                                                    readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><label class="require">Date of Completion</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="input-group date form-input">
                                                                <input type="text" class="form-control" value=""
                                                                    name="dateofcompletion" id="dateofcompletion" readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
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
                                                                            <input class="form-check-input " type="radio"
                                                                                value="{{ encryptId($company->id) }}"
                                                                                name="company"
                                                                                id="company_{{ encryptId($company->id) }}">
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
                                                                <select name="location" class="form-control select2"
                                                                    id="location">
                                                                    <option value="">Select Location</option>
                                                                    @foreach ($locationDetails as $location)
                                                                        <option value="{{ encryptId($location->id) }}">
                                                                            {{ $location->location_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td><label class="">Specific Location</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <select name="specific_location" id="specific_location"
                                                                class="form-control select2">
                                                                <option value="">Select Specific Location</option>
                                                            </select>
                                                        </td>
                                                        <td><label class="">Others</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <textarea name="locationothers" id="locationothers" class="form-control" rows="2" style="width:auto"></textarea>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><label class="require">Area Owner:</label> </td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="form-input">
                                                                <select name="area_owner" id="area_owner"
                                                                    class="form-control select2">
                                                                    <option value="">Select Area Owner</option>
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td><label class="require">Work Type:</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="form-input">

                                                                <select name="work_type" id="work_type"
                                                                    class="form-control select2">
                                                                    <option value="">Select Work Type</option>
                                                                    @foreach ($workTypeDetails as $worktype)
                                                                        <option value="{{ encryptId($worktype->id) }}">
                                                                            {{ $worktype->work_type_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </td>
                                                        <td><label class="require">Supervising Authority:</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="form-input">

                                                                <select name="supervising_authority"
                                                                    id="supervising_authority"
                                                                    class="form-control select2">
                                                                    <option value="">Select Supervising Authority
                                                                    </option>
                                                                </select>
                                                            </div>

                                                        </td>

                                                    </tr>


                                                    <tr>
                                                        <td colspan="1">
                                                            <label class="require">Work Description</label>

                                                        </td>
                                                        <td> : </td>
                                                        <td colspan="7">
                                                            <div class="form-input">
                                                                <textarea name="workdescription" id="workdescription" class="form-control" rows="2" required></textarea>
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
                                                            <textarea name="jobhazardanalysis" id="jobhazardanalysis" class="form-control" rows="2"></textarea>
                                                        </td>
                                                    </tr> --}}

                                                    <tr>
                                                        <td colspan="9">
                                                            <div class="form-input">
                                                                <input class="form-check-input " type="checkbox"
                                                                    value="YES" name="onemonthvalidity"
                                                                    id="onemonthvalidity">
                                                                <label class="form-check-label"
                                                                    for="onemonthvalidity">Obtained authorization from the
                                                                    Supervising Authority (Job Owner) for a one-month
                                                                    validity extension of the PTW (Permit to Work)
                                                                    application.</label>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Section Header -->


                                    <div class="card-header card-header-inner">
                                        <h6 class="text-white m-0">SECTION B - HAZARDOUS ACTIVITY / HAZARD</h6>
                                    </div>

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-2" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($hazardDetails as $hazard)
                                                    @php
                                                        $params = json_decode($hazard->other_params);
                                                        $hazardId = encryptId($hazard->id);
                                                        $targetId = "hazard_document_$hazardId";
                                                    @endphp

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Hazard Option -->
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input
                                                                class="form-check-input m-0 radiocheck @if ($hazard->input_type == 2) othersshow @endif"
                                                                type="checkbox" value="{{ $hazardId }}"
                                                                name="hazard[]"
                                                                data-subid="{{ encryptId($params->permit) }}"
                                                                data-id="{{ $targetId }}"
                                                                id="checkbox_{{ $hazardId }}">
                                                            {{ $hazard->category_name }}
                                                        </label>

                                                        <!-- Conditional Message / File Input -->
                                                        <div id="{{ $targetId }}" class="mt-2"
                                                            @if ($hazard->required == 0) style="display:none;" @endif>

                                                            @isset($params->message)
                                                                <label
                                                                    class="form-label small text-muted">{{ $params->message }}</label>
                                                            @endisset

                                                            @if ($hazard->input_type == 2)
                                                                <input type="file"
                                                                    class="form-control form-control-sm mt-1"
                                                                    name="hazard_document_file[{{ $hazard->id }}]"
                                                                    required>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="card-header card-header-inner mb-3">
                                        <h6 class="text-white m-0">SECTION C - SUPPORTING CERTIFICATE / DOCUMENT - where
                                            applicable</h6>
                                    </div>

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-2" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($supportCertificate as $certificate)
                                                    @php
                                                        $certId = encryptId($certificate->id);
                                                        $targetId = "support_$certId";
                                                        $isRequired = $certificate->required == 1;
                                                    @endphp

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Checkbox with label -->
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0 othersshow" type="checkbox"
                                                                value="{{ $certId }}" name="supportcertificate[]"
                                                                id="checkbox_{{ $certId }}"
                                                                data-id="{{ $targetId }}"
                                                                {{ $isRequired ? 'checked data-required=true' : '' }}>
                                                            {{ $certificate->category_name }}
                                                        </label>

                                                        <!-- Input field -->
                                                        <div class="mt-2" id="{{ $targetId }}"
                                                            @if (!$isRequired) style="display:none;" @endif>
                                                            @if ($certificate->input_type == 1)
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="supporting_documents[{{ $certificate->id }}]"
                                                                    required>
                                                                <span class="text-muted small d-block mt-1">(jpeg, jpg,
                                                                    png, doc, docx, pdf, xls, xlsx, ppt, pptx)</span>
                                                            @elseif ($certificate->input_type == 2)
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="supporting_documents_file[{{ $certificate->id }}]"
                                                                    required>
                                                                <span class="text-danger small d-block mt-1">(jpeg, jpg,
                                                                    png, doc, docx, pdf, xls, xlsx, ppt, pptx)</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <!-- Section Header -->
                                    <div class="card-header card-header-inner">
                                        <h6 class="text-white m-0">SECTION D - PERSONAL PROTECTIVE EQUIPMENT - where
                                            applicable</h6>
                                    </div>

                                    <div class="pt-3">
                                        <div class="px-2">

                                            @foreach ($protectiveEquipment as $equipment)
                                                <div class="mb-3 ps-3 border-start border-3"
                                                    style="border-color: #0053a1;">
                                                    <div class="fw-semibold text-uppercase mb-2 text-dark">
                                                        {{ $equipment->category_name }}
                                                    </div>

                                                    @if (isset($protectiveEquipmentItems[$equipment->id]))
                                                        <div class="row">
                                                            @foreach ($protectiveEquipmentItems[$equipment->id] as $euipmentItems)
                                                                <div class="col-md-3 mb-2">
                                                                    <label
                                                                        class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                                        <input class="form-check-input m-0"
                                                                            type="checkbox"
                                                                            value="{{ encryptId($euipmentItems['id']) }}"
                                                                            name="equipments[]"
                                                                            @if ($equipment->required == 1) checked disabled @endif>
                                                                        {{ $euipmentItems['item_name'] }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                            <!-- Others -->
                                            <div class="ps-3 border-start border-3" style="border-color: #0053a1;">
                                                <div class="fw-semibold text-uppercase mb-2 text-dark small">Others</div>
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 mb-2">
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0 othersshow" type="checkbox"
                                                                value="{{ encryptId(0) }}" data-id="equipments_others"
                                                                name="equipments[]" id="equipment_other">
                                                            Others
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8 mb-2" id="equipments_others"
                                                        style="display: none;">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="equipments_others_text"
                                                            placeholder="Specify other equipment">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <hr>
                                    <div class="card-header card-header-inner mb-3">
                                        <h6 class="text-white m-0">SECTION E - WORK SITE PREPARATION / PRECAUTIONS - where
                                            applicable</h6>
                                    </div>

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-2" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($sitePreparationDetails as $sitePreparation)
                                                    @php
                                                        $siteId = encryptId($sitePreparation->id);
                                                    @endphp
                                                    <div class="col-md-4 mb-3">
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                value="{{ $siteId }}" name="sitepreparation[]"
                                                                id="sitepreparation_{{ $siteId }}">
                                                            {{ $sitePreparation->category_name }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                                <!-- Optional: Add "Others" -->
                                                {{-- 
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0 othersshow"
                                                                type="checkbox"
                                                                value="{{ encryptId(0) }}"
                                                                name="sitepreparation[]"
                                                                id="sitepreparation_other"
                                                                data-id="sitepreparation_others">
                                                            Are there any other work activities around this work area?
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8 mb-3" id="sitepreparation_others" style="display:none;">
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="sitepreparation_others_text"
                                                            placeholder="Specify other activities...">
                                                    </div>
                                                    --}}
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="card-header card-header-inner  ">
                                        <h6 class="text-white">SECTION F - JOB SAFETY ANALYSIS</h6>
                                    </div>

                                    {{-- <div class="row p-3 mt-2">
                                        <div class="form-input">
                                            <input class="form-check-input " type="radio" required value="YES"
                                                onchange="jsestatuschange('YES')" name="jsa_status" id="jse_status_yes"
                                                checked>
                                            <label class="form-check-label" for="jse_status_yes">Yes</label>
                                            &nbsp;&nbsp;
                                            <input class="form-check-input " type="radio" required value="NO"
                                                onchange="jsestatuschange('NO')" name="jsa_status" id="jse_status_no">
                                            <label class="form-check-label" for="jse_status_no">No</label>
                                        </div>
                                        <hr>
                                    </div> --}}

                                    <div class="clearfix"></div>
                                    <div class="row g-3 pl-2 pt-4 mt-1" id="jse_status_div">
                                        <div class="row pl-3">
                                            <div class="row mb-3">
                                                <!-- Likelihood Table -->
                                                <div class="col-md-6 d-flex flex-column jsutify-content-between">
                                                    <h6 class="fw-bold">Likelihood</h6>
                                                    <div class="flex-grow-1 border rounded overflow-hidden">
                                                        <table class="table table-bordered mb-0 h-100">
                                                            <thead>
                                                                <tr class="table-primary ">
                                                                    <th style="text-align: center">LIKELIHOOD</th>
                                                                    <th style="text-align: center">EXAMPLE</th>
                                                                    <th style="text-align: center">RATING</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($likelihoodDetails as $likelihood)
                                                                    <tr>
                                                                        <td style="text-align: center">
                                                                            {{ $likelihood->name }}</td>
                                                                        <td style="text-align: center">
                                                                            {{ $likelihood->example }}</td>
                                                                        <td style="text-align: center">
                                                                            {{ $likelihood->rating }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <!-- Severity Table -->
                                                <div class="col-md-6 d-flex flex-column">
                                                    <h6 class="fw-bold">Severity</h6>
                                                    <div class="flex-grow-1 border rounded overflow-hidden">
                                                        <table class="table table-bordered mb-0 h-100">
                                                            <thead style="background-color: #e8f0fa;">
                                                                <tr class="table-primary ">
                                                                    <th style="text-align: center">SEVERITY</th>
                                                                    <th style="text-align: center">EXAMPLE</th>
                                                                    <th style="text-align: center">RATING</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($severityDetails as $severity)
                                                                    <tr>
                                                                        <td style="text-align: center">
                                                                            {{ $severity->name }}</td>
                                                                        <td style="text-align: center">
                                                                            {{ $severity->example }}</td>
                                                                        <td style="text-align: center">
                                                                            {{ $severity->rating }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <h6 class="bold">Risk Matrix</h6>
                                            </div>
                                            <div class="row mt-3 mx-3">
                                                <table class="table table-bordered table-striped">
                                                    <tr class="table-primary ">
                                                        <td></td>
                                                        <td colspan="{{ count($severityDetails) }}"
                                                            style="text-align: center ; font-weight:bold">
                                                            Severity(S)
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: center ; font-weight:bold"
                                                            class="table-primary ">Likelihood(L)
                                                        </td>
                                                        @foreach (array_reverse($severityDetails->toArray()) as $severity)
                                                            <td style="text-align: center">{{ $severity['rating'] }}</td>
                                                        @endforeach

                                                    </tr>
                                                    @foreach ($likelihoodDetails as $likelihood)
                                                        <tr>
                                                            <td style="width:10%;text-align: center ;"
                                                                class="table-primary ">
                                                                {{ $likelihood->rating }}</td>
                                                            @foreach (array_reverse($severityDetails->toArray()) as $severity)
                                                                @php
                                                                    $value = $likelihood->rating * $severity['rating'];
                                                                @endphp
                                                                <td
                                                                    style="background-color:{{ $riskmatrixDetails[$value]['color_code'] }};text-align: center ;">
                                                                    {{ $value }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </table>

                                                <hr>

                                                <div class="mb-2">
                                                    <div class="d-lg-flex align-items-center">
                                                        <h6 class="bold">JOB SAFETY ANALYSIS</h6>
                                                        <div class="ms-auto">
                                                            <button class="btn btn-primary" type="button"
                                                                id="addmore">Add</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div style="overflow-x: auto; width: 100%;">
                                                    <table class="table table-bordered text-nowrap"
                                                        style="min-width: 2000px;">
                                                        <thead class="text-center align-middle">
                                                            <tr>
                                                                <th style="width: 300px;">SEQ OF JOB STEPS</th>
                                                                <th style="width: 180px;">HAZARD CATEGORY</th>
                                                                <th style="width: 200px;">HAZARD (INCIDENT)</th>
                                                                <th style="width: 200px;">WHO/WHAT HARMED</th>
                                                                <th style="width: 200px;">CONTROL MEASURES</th>
                                                                <th style="width: 120px;">LIKELIHOOD</th>
                                                                <th style="width: 120px;">SEVERITY</th>
                                                                <th style="width: 120px;">RISK</th>
                                                                <th style="width: 200px;">ACTION PARTY</th>
                                                                <th style="width: 80px;">Remove</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="jsadetails">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <tr class="jsa_list">
                                                                    <td>
                                                                        <div class="form-input">
                                                                            <input type="text"
                                                                                name="jsadetails[{{ $i }}][seq_of_bas_job_stp]"
                                                                                id="seq_of_bas_job_stp_{{ $i }}"
                                                                                data-error="Please enter SEQUENCE OF BASIC JOB STEPS"
                                                                                class="form-control validate-input-required">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">
                                                                            <select
                                                                                name="jsadetails[{{ $i }}][hazard_category]"
                                                                                id="hazard_category_{{ $i }}"
                                                                                onchange="getsubcategory(this)"
                                                                                data-error="Please select HAZARD CATEGORY"
                                                                                class="form-control select2 validate-select-required">
                                                                                <option value="">Select</option>
                                                                                @foreach ($hazardCategoryDetails as $hazardcategory)
                                                                                    <option
                                                                                        value="{{ encryptId($hazardcategory->id) }}">
                                                                                        {{ $hazardcategory->category_name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">
                                                                            <select
                                                                                name="jsadetails[{{ $i }}][hazard_category_incident]"
                                                                                id="hazard_category_incident_{{ $i }}"
                                                                                onchange="othersshow(this)"
                                                                                data-error="Please select HAZARD (POTENTIAL INCIDENT)"
                                                                                class="form-control select2 validate-select-required">
                                                                                <option value="">Select</option>
                                                                            </select>
                                                                            <input type="text"
                                                                                name="jsadetails[{{ $i }}][hazard_category_incident_other]"
                                                                                id="hazard_category_incident_other_{{ $i }}"
                                                                                class="form-control mt-2 validate-input-required"
                                                                                placeholder="Others"
                                                                                style="display:none;">
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <input type="text"
                                                                                name="jsadetails[{{ $i }}][who_what_harmed]"
                                                                                id="who_what_harmed_{{ $i }}"
                                                                                data-error="Please enter WHO/WHAT MIGHT BE HARMED"
                                                                                class="form-control validate-input-required">
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <input type="text"
                                                                                name="jsadetails[{{ $i }}][seo_mea_or_rec_act_or_pro]"
                                                                                id="seo_mea_or_rec_act_or_pro_{{ $i }}"
                                                                                data-error="Please enter Product Name"
                                                                                class="form-control validate-input-required">
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <select
                                                                                name="jsadetails[{{ $i }}][likelihood]"
                                                                                id="likelihood_{{ $i }}"
                                                                                data-error="Please select LIKELIHOOD"
                                                                                onchange="calculateRiskmatrix(this)"
                                                                                class="form-control select2 validate-select-required">
                                                                                <option value="">Select</option>
                                                                                @for ($j = 1; $j <= 5; $j++)
                                                                                    <option value="{{ $j }}">
                                                                                        {{ $j }}</option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <select
                                                                                name="jsadetails[{{ $i }}][severity]"
                                                                                id="jsadetails_{{ $i }}"
                                                                                data-error="Please select SEVERITY"
                                                                                onchange="calculateRiskmatrix(this)"
                                                                                class="form-control select2 validate-select-required">
                                                                                <option value="">Select</option>
                                                                                @for ($j = 1; $j <= 5; $j++)
                                                                                    <option value="{{ $j }}">
                                                                                        {{ $j }}</option>
                                                                                @endfor
                                                                            </select>
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <input type="hidden"
                                                                                name="jsadetails[{{ $i }}][risk_matrix]"
                                                                                id="risk_matrix_{{ $i }}">
                                                                            <span class="risk_matrix"
                                                                                id="risk_{{ $i }}">
                                                                                <span
                                                                                    style="border:1px solid #ccc; height:35px; padding:7px; display:block; text-align:center;"></span>
                                                                            </span>
                                                                        </div>

                                                                    </td>
                                                                    <td>
                                                                        <div class="form-input">

                                                                            <input type="text"
                                                                                name="jsadetails[{{ $i }}][action_responsible]"
                                                                                id="action_responsible_{{ $i }}"
                                                                                data-error="Please enter ACTION/ RESPONSIBLE PARTY"
                                                                                class="form-control validate-input-required">
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <span class="fa fa-trash removerow text-danger"
                                                                            style="cursor: pointer;"></span>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="card-header card-header-inner  ">
                                        <h6 class="text-white">SECTION G - PERMIT ISSUANCE</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-4">
                                        <div class="col-md-12">

                                            <div class="m-2 form-input">

                                                <input class="form-check-input" type="checkbox" value="1"
                                                    name="accept_terms" id="accept_terms" required>
                                                <label class="form-check-label require" for="accept_terms">I <b>fully
                                                        understand </b>& will <b>ensure compliance</b> with all the
                                                    requirements of this permit.</label>
                                            </div>
                                        </div>


                                        <div class="row mt-3">
                                            <label class="col-sm-2 col-form-label require">
                                                Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control"
                                                    value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                            <label class="col-sm-2 col-form-label form-input require">
                                                Date & Time</label>
                                            <div class="col-sm-4 form-input">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control"
                                                        value="{{ todaydate() }}" name="dateofapplication" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Remarks</label>
                                            <div class="col-sm-10 form-input">
                                                <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div> --}}


                                    </div>
                                </div>
                                <div class="row card-bottom">
                                    <div class="col-12 mt-2">
                                        <hr>

                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                            data-bs-toggle="tooltip" title="Submit" name="submit">Submit</button>
                                        <button class="btn btn-warning " id="btndraft" type="submit"
                                            data-bs-toggle="tooltip" title="Draft" name="draft">Draft</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[data-required="true"]').forEach(function(checkbox) {
                checkbox.addEventListener('click', function(e) {
                    // If trying to uncheck, prevent it
                    if (!checkbox.checked) {
                        e.preventDefault();
                        checkbox.checked = true;
                    }
                });
            });
        });
        
        $(".datepickerthreemonth").datepicker({
            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'startDate': '{{ todaydate() }}',
            'endDate': '{{ date('d-m-Y', strtotime('+3 Months')) }}',
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
                            '<option value="">Select Specific Location</option>');
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
                $('#specific_location').empty().append('<option value="">Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
            }
        });

        $('#specific_location').change(function() {
            var locationId = $(this).val();

            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/getAreaOwner/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#area_owner').empty().append(
                            '<option value="">Select Area Owner</option>');
                        $.each(data, function(key, value) {
                            $('#area_owner').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#area_owner').trigger('change.select2');
                    }
                });
            } else {
                $('#area_owner').empty().append('<option value="">Select Area Owner</option>');
                $('#area_owner').trigger('change.select2');
            }
        });

        $('#work_type').change(function() {
            var workTypeId = $(this).val();

            if (workTypeId) {
                $.ajax({
                    url: "{{ admin_url('work_type/getSupervisingAuthority/') }}" + workTypeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#supervising_authority').empty().append(
                            '<option value="">Select Supervising Authority</option>');
                        $.each(data, function(key, value) {
                            $('#supervising_authority').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#supervising_authority').trigger('change.select2');
                    }
                });
            } else {
                $('#supervising_authority').empty().append(
                    '<option value="">Select Supervising Authority</option>');
                $('#supervising_authority').trigger('change.select2');
            }
        });

        $(document).ready(function() {

            $('#btnsubmit').on('click', function(e) {

                $('#general_ptw_add').validate({
                    rules: {
                        company: {
                            required: true
                        },
                        location: {
                            required: true
                        },
                        dateofcommencement: {
                            required: true
                        },
                        dateofcompletion: {
                            required: true
                        },
                        workdescription: {
                            required: true
                        },
                        "supporting_documents_file[]": {
                            required: true,
                            extension: "jpeg|jpg|png|doc|docx|pdf|xls|xlsx|ppt|pptx"
                        },
                        accept_terms: {
                            required: true
                        },
                        area_owner: {
                            required: true
                        },
                        work_type: {
                            required: true
                        },
                        supervising_authority: {
                            required: true
                        },
                    },
                    messages: {
                        company: {
                            required: "Please select Company"
                        },
                        location: {
                            required: "Please select Location"
                        },
                        dateofcommencement: {
                            required: 'Please select the Date of Commencement'
                        },
                        dateofcompletion: {
                            required: 'Please select the Date of Completion'
                        },
                        workdescription: {
                            required: "Please enter work Description"
                        },
                        "supporting_documents_file[]": {
                            required: "Please upload a file",
                            extension: "Only allowed: jpeg, jpg, png, doc, docx, pdf, xls, xlsx, ppt, pptx"
                        },
                        accept_terms: {
                            required: 'Please accept the terms'
                        },
                        area_owner: {
                            required: 'Please Select Area Owner'
                        },
                        work_type: {
                            required: 'Please Select Work Type'
                        },
                        supervising_authority: {
                            required: 'Please Select Supervising Authority'
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-input').append(error);
                    },
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                        $(element).closest(".form-input").addClass("selecterror");
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                        $(element).closest(".form-input").removeClass("selecterror");
                    }
                });
            });

            $('#btndraft').on('click', function() {
                $('#general_ptw_add').off('submit');
                $('#general_ptw_add')[0].submit();
            });
        });



        $('#dateofcommencement').on('changeDate', function(e) {
            UpdateDate();
        });

        // Handle checkbox change
        $('#onemonthvalidity').change(function() {
            UpdateDate();
        });

        function UpdateDate() {

            // Get selected date from datepicker
            var selectedDate = $('#dateofcommencement').val();

            if (selectedDate == '')
                return true;

            // Check if "Add 7 Days" checkbox is checked
            if (!$('#onemonthvalidity').is(':checked')) {
                var newDate = getEndDate(selectedDate, {{ VALIDITY_GENERAL }});
                $('#dateofcompletion').val(newDate);
            }
            // Check if "Add 30 Days" checkbox is checked
            else {
                var newDate = getEndDate(selectedDate, {{ VALIDITY_GENERAL_MONTH }});
                $('#dateofcompletion').val(newDate);
            }

        }

        $(document).ready(function() {

            $('.othersshow').on('click', function() {

                $id = $(this).data('id');

                if ($(this).is(':checked')) {

                    $("#" + $id).show();
                } else {
                    $("#" + $id).hide();
                }
            });

            $('.radiocheck').on('change', function() {

                var subpermitLength = $('.radiocheck[name="' + $(this).attr('name') + '"]:checked').length;
                if (subpermitLength > 0) {
                    $('#btnsubmit').text('Next');
                    $('#btnsubmit').attr('title', 'Next');
                    $('#btnsubmit').attr('data-bs-original-title', 'Next');

                } else {
                    $('#btnsubmit').text('Submit');
                    $('#btnsubmit').attr('title', 'Submit');
                    $('#btnsubmit').attr('data-bs-original-title', 'Submit');

                }
            });

            $('.companycheck').on('change', function() {

                if ($(this).is(':checked')) {
                    $('.companycheck[name="' + $(this).attr('name') + '"]').not(this).prop('checked',
                        false);
                }
            });
        });

        $(document).ready(function() {
            $('#addmore').on('click', function() {

                $('#addmore').attr("disabled", true);
                var rowCount = $("#jsadetails .jsa_list").length;

                if (rowCount >= 50) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 50 records only add',
                    })
                    return true;
                }

                var newRow = $(".jsa_list").first().clone();

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                var newIndex = rowCount + 1;

                newRow.find("input[type='text']").val("");
                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find("input[type='text']").each(function() {

                    $(this).val("");
                    $(this).removeAttr("aria-describedby");

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

                $("#jsadetails").append(newRow);

                newRow.find(".select2").select2();

                $(".select2").select2();
                $('#addmore').attr("disabled", false);

            });
        });

        $(document).on('click', '.removerow', function() {
            if ($("#jsadetails .jsa_list").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".jsa_list").remove();

                $("#jsadetails .jsa_list").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find(".risk_matrix").each(function() {

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);
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
                });
                $(".select2").select2();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });

        function calculateRiskmatrix(element) {

            var rowIndex = element.id.split('_').pop();

            var likelihoodValue = $('#likelihood_' + rowIndex).val();
            var severityValue = $('#jsadetails_' + rowIndex).val();

            if (likelihoodValue !== '' && severityValue !== '') {

                var riskValue = parseInt(likelihoodValue) * parseInt(severityValue);

                var riskmartixarray = @json($riskmatrixDetails);
                var colorCode = riskmartixarray[riskValue].color_code;

                console.log(riskmartixarray, colorCode);

                var outtext = '<span style="background-color:' + colorCode +
                    ';padding:7px;width:100px;display:block;text-align:center;">' + riskValue + '</span>';

                $('#risk_' + rowIndex).html(outtext);
            } else {
                outtext =
                    ' <span style="border:1px solid #ccc; height:35px; padding: 7px;width: 100px;display: block;text-align: center;"> </span>';
                $('#risk_' + rowIndex).html(outtext);
            }
        }

        function getsubcategory(element) {

            var rowIndex = element.id.split('_').pop();

            var categoryId = $('#hazard_category_' + rowIndex).val();
            // var subpermit = $('input[name="hazard[]"]:checked').map(function() {
            //     return $(this).attr('data-subid');
            // }).get();

            if (categoryId) {

                $.ajax({
                    url: "{{ admin_url('ptw/general/getsubcategory') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        categoryId: categoryId,
                        // subpermitId: subpermit,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#hazard_category_incident_' + rowIndex).empty().append(
                            '<option value="">Please select HAZARD (POTENTIAL INCIDENT)</option>');
                        $.each(data, function(key, value) {
                            $('#hazard_category_incident_' + rowIndex).append('<option value="' +
                                value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#hazard_category_incident_' + rowIndex).trigger('change.select2');
                    }
                });
            } else {
                $('#hazard_category_incident_' + rowIndex).empty().append(
                    '<option value="">Please select HAZARD (POTENTIAL INCIDENT)</option>');
                $('#hazard_category_incident_' + rowIndex).trigger('change.select2');
            }

        }

        function othersshow(element) {

            var getvalue = element.value;
            var rowIndex = element.id.split('_').pop();

            if (getvalue == 0 && getvalue != '') {

                $('#hazard_category_incident_other_' + rowIndex).show();

            } else {
                $('#hazard_category_incident_other_' + rowIndex).hide();
            }
        }


        function jsestatuschange(value) {

            if (value == 'YES') {
                $("#jse_status_div").show();
            } else {
                $("#jse_status_div").hide();
            }
        }
    </script>
@endpush
