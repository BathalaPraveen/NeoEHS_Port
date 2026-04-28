@extends('admin.layouts.layout')
@section('title', 'General PTW Edit')
@section('pageurl', admin_url('ptw/general/list'))

@push('style')
    <style>
        #general_ptw_add {
            color: #000;
        }

        #general_ptw_add .form-check-label {
            display: inline;
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
                            <li class="breadcrumb-item active" aria-current="page">General PTW Edit</li>
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
                                    <h5 class="card-title">General PTW Edit</h5>
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
                                action="{{ admin_url('ptw/general/edit/submit') }}">
                                <input type="hidden" name="id" value="{{ encryptId($general->id) }}">
                                @csrf



                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">SECTION A - APPLICATION</h6>
                                    </div>

                                    <div class="row g-3 px-2 pt-4">
                                        <div class="">
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
                                                            <input type="text" class="form-control" name="contactnumber"
                                                                value="{{ $general->contact_number }}">
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
                                                                    value="{{ displayDateformat($general->created_at) }}"
                                                                    name="dateofapplication" id="dateofapplication" required
                                                                    readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td><label class="require">Date of Commencement</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <div class="input-group date form-input">
                                                                <input type="text" required
                                                                    class="form-control datepicker"
                                                                    value="{{ displayDateformat($general->date_of_commencement) }}"
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
                                                                <input type="text" class="form-control"
                                                                    value="{{ displayDateformat($general->date_of_completion) }}"
                                                                    required name="dateofcompletion" id="dateofcompletion"
                                                                    readonly>
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
                                                                                required
                                                                                value="{{ encryptId($company->id) }}"
                                                                                name="company"
                                                                                @if ($general->area_of_work == $company->id) checked @endif
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
                                                                    required id="location">
                                                                    <option value="">Select Location</option>
                                                                    @foreach ($locationDetails as $location)
                                                                        <option value="{{ encryptId($location->id) }}"
                                                                            @if ($general->location == $location->id) selected @endif>
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
                                                                @foreach ($specificLocation as $slocation)
                                                                    <option value="{{ encryptId($slocation->id) }}"
                                                                        @if ($general->specific_location == $slocation->id) selected @endif>
                                                                        {{ $slocation->specific_loc_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><label class="">Others</label></td>
                                                        <td>:</td>
                                                        <td>
                                                            <textarea name="locationothers" id="locationothers" class="form-control" rows="2">{{ $general->other_location }}</textarea>
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
                                                                        <option value="{{ encryptId($worktype->id) }}"
                                                                            {{ $worktype->id == $general->work_type ? 'selected' : '' }}>
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
                                                                <textarea name="workdescription" id="workdescription" class="form-control" rows="2" required>{{ $general->work_description }}</textarea>
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
                                                            <textarea name="jobhazardanalysis" id="jobhazardanalysis" class="form-control" rows="2">{{ $general->job_hazard_analysis }}</textarea>
                                                        </td>
                                                    </tr> --}}



                                                    <tr>
                                                        <td colspan="9">
                                                            <div class="form-input">
                                                                <input class="form-check-input " type="checkbox"
                                                                    @if ($general->onemonthpermit == 'YES') checked @endif
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
                                    <div class="card-header card-header-inner mb-3">
                                        <h6 class="text-white m-0">SECTION B - HAZARDOUS ACTIVITY / HAZARD</h6>
                                    </div>

                                    @php
                                        $hazardData = json_decode($general->hazard);
                                        if (empty($hazardData) || !isset($hazardData->hazard)) {
                                            $hazardData = (object) ['hazard' => []];
                                        }
                                    @endphp

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-1" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($hazardDetails as $hazard)
                                                    @php
                                                        $params = json_decode($hazard->other_params);
                                                        $hazardId = encryptId($hazard->id);
                                                        $targetId = "hazard_document_$hazardId";
                                                        $isChecked = in_array($hazard->id, $hazardData->hazard);
                                                        $isDisabled = $general->is_draft != 1 ? 'disabled' : '';
                                                    @endphp

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Checkbox -->
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input
                                                                class="form-check-input m-0 radiocheck @if ($hazard->input_type == 2) othersshow @endif"
                                                                type="checkbox" value="{{ $hazardId }}"
                                                                name="hazard[]" {{ $isChecked ? 'checked' : '' }}
                                                                {{ $isDisabled }} data-id="{{ $targetId }}"
                                                                id="checkbox_{{ $hazardId }}">
                                                            {{ $hazard->category_name }}
                                                        </label>

                                                        <!-- Show file if uploaded -->
                                                        @if ($hazard->input_type == 2 && isset($hazardfile[$hazard->id]))
                                                            <div class="mt-1">
                                                                <a href="{{ url($hazardfile[$hazard->id]['file_path']) }}"
                                                                    target="_blank">
                                                                    {{ $hazardfile[$hazard->id]['file_orgname'] }}
                                                                </a>
                                                            </div>
                                                        @endif

                                                        <!-- Conditional file/message -->
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
                                                                    {{ $isDisabled ? 'disabled' : 'required' }}>
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

                                    @php
                                        $documentData = json_decode($general->supporting_documents);
                                        if (!$documentData || !isset($documentData->supportcertificate)) {
                                            $documentData = (object) [
                                                'supportcertificate' => [],
                                                'supportcertificate_data' => '',
                                            ];
                                        }
                                    @endphp

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-1" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($supportCertificate as $certificate)
                                                    @php
                                                        $certId = encryptId($certificate->id);
                                                        $isRequired = $certificate->required == 1;
                                                        $isChecked = isset($supportCertificateFile[$certificate->id]);
                                                        $targetId = "support_$certId";
                                                    @endphp

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Label + Checkbox -->
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0 othersshow" type="checkbox"
                                                                name="supportcertificate[]"
                                                                id="checkbox_{{ $certId }}"
                                                                data-id="{{ $targetId }}"
                                                                value="{{ $certId }}"
                                                                {{ $isChecked ? 'checked' : '' }}
                                                                {{ $isRequired ? 'checked data-required=true ' . ($isChecked ? 'data-required=true' : '') : '' }}>
                                                            {{ $certificate->category_name }}
                                                        </label>

                                                        <!-- Uploaded file (if exists) -->
                                                        @if ($isChecked)
                                                            <div class="mt-1">
                                                                <a href="{{ url($supportCertificateFile[$certificate->id]['file_path']) }}"
                                                                    target="_blank">
                                                                    {{ $supportCertificateFile[$certificate->id]['file_orgname'] }}
                                                                </a>
                                                            </div>
                                                        @endif

                                                        <!-- Input section -->
                                                        <div class="mt-2" id="{{ $targetId }}"
                                                            @if (!$isChecked && !$isRequired) style="display:none;" @endif>

                                                            @if ($certificate->input_type == 1)
                                                                <input type="text" class="form-control form-control-sm"
                                                                    name="supporting_documents[{{ $certificate->id }}]"
                                                                    value="">
                                                            @elseif ($certificate->input_type == 2)
                                                                <input type="file" class="form-control form-control-sm"
                                                                    name="supporting_documents_file[{{ $certificate->id }}]"
                                                                    @if (!$isChecked && !$isRequired) required @endif>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner mb-3">
                                        <h6 class="text-white m-0">SECTION D - PERSONAL PROTECTIVE EQUIPMENT - where
                                            applicable</h6>
                                    </div>

                                    @php
                                        $equipmentData = json_decode($general->equipment_details);
                                        if (!$equipmentData || !isset($equipmentData->equipments)) {
                                            $equipmentData = (object) [
                                                'equipments' => [],
                                                'equipments_others_text' => '',
                                            ];
                                        }
                                    @endphp

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
                                                                @php
                                                                    $itemId = encryptId($euipmentItems['id']);
                                                                    $isChecked = in_array(
                                                                        $euipmentItems['id'],
                                                                        $equipmentData->equipments,
                                                                    );
                                                                    $isRequired = $equipment->required == 1;
                                                                @endphp
                                                                <div class="col-md-3 mb-2">
                                                                    <label
                                                                        class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                                        <input class="form-check-input m-0"
                                                                            type="checkbox" name="equipments[]"
                                                                            value="{{ $itemId }}"
                                                                            id="equipment_{{ $itemId }}"
                                                                            {{ $isChecked ? 'checked' : '' }}
                                                                            @if ($isRequired) checked required onclick="return false;" @endif>
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
                                                                name="equipments[]" value="{{ encryptId(0) }}"
                                                                id="equipment_other" data-id="equipments_others"
                                                                {{ in_array(0, $equipmentData->equipments) ? 'checked' : '' }}>
                                                            Others
                                                        </label>
                                                    </div>
                                                    <div class="col-md-8 mb-2" id="equipments_others"
                                                        @if (!in_array(0, $equipmentData->equipments)) style="display:none;" @endif>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="equipments_others_text"
                                                            value="{{ $equipmentData->equipments_others_text }}"
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

                                    @php
                                        $siteData = json_decode($general->site_preparation);
                                        if (!$siteData || !isset($siteData->sitepreparation)) {
                                            $siteData = (object) [
                                                'sitepreparation' => [],
                                                'sitepreparation_others_text' => '',
                                            ];
                                        }
                                    @endphp

                                    <div class="pt-3">
                                        <div class="ps-3 border-start border-3 pe-1" style="border-color: #0053a1;">
                                            <div class="row">
                                                @foreach ($sitePreparationDetails as $sitePreparation)
                                                    @php
                                                        $siteId = encryptId($sitePreparation->id);
                                                        $isChecked = in_array(
                                                            $sitePreparation->id,
                                                            $siteData->sitepreparation,
                                                        );
                                                    @endphp
                                                    <div class="col-md-4 mb-3">
                                                        <label
                                                            class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                            <input class="form-check-input m-0" type="checkbox"
                                                                name="sitepreparation[]" value="{{ $siteId }}"
                                                                id="sitepreparation_{{ $siteId }}"
                                                                {{ $isChecked ? 'checked' : '' }}>
                                                            {{ $sitePreparation->category_name }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                                {{-- Optional Others --}}
                                                <div class="col-md-4 mb-3">
                                                    <label
                                                        class="form-check-label hazard-label w-100 d-flex align-items-center small">
                                                        <input class="form-check-input m-0 othersshow" type="checkbox"
                                                            value="{{ encryptId(0) }}" name="sitepreparation[]"
                                                            id="sitepreparation_other" data-id="sitepreparation_others"
                                                            {{ in_array(0, $siteData->sitepreparation) ? 'checked' : '' }}>
                                                        Are there any other work activities around this work area?
                                                    </label>
                                                </div>

                                                <div class="col-md-8 mb-3" id="sitepreparation_others"
                                                    @if (!in_array(0, $siteData->sitepreparation)) style="display:none;" @endif>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="sitepreparation_others_text"
                                                        value="{{ $siteData->sitepreparation_others_text }}"
                                                        placeholder="Specify other work activities...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>

                                    <div class="card-header card-header-inner  ">
                                        <h6 class="text-white">SECTION F - JOB SAFETY ANALYSIS</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row g-3 pl-2 pt-4">
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
                                                            <td>{{ $severity['rating'] }}</td>
                                                        @endforeach

                                                    </tr>
                                                    @foreach ($likelihoodDetails as $likelihood)
                                                        <tr>
                                                            <td style="width:10%" class="table-primary ">
                                                                {{ $likelihood->rating }}</td>
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
                                                            @php $i = 1; @endphp
                                                            @foreach ($generalhazardDetails as $generalHazard)
                                                                <tr class="jsa_list">
                                                                    <input type="hidden" name="upload_id[]"
                                                                        value="{{ $generalHazard->id }}">
                                                                    <td class="form-input">
                                                                        <input type="text"
                                                                            name="jsadetails[{{ $i }}][seq_of_bas_job_stp]"
                                                                            id="seq_of_bas_job_stp_{{ $i }}"
                                                                            class="form-control validate-input-required"
                                                                            data-error="Please enter SEQUENCE OF BASIC JOB STEPS"
                                                                            value="{{ $generalHazard->seq_of_bas_job_stp }}">
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <select
                                                                            name="jsadetails[{{ $i }}][hazard_category]"
                                                                            id="hazard_category_{{ $i }}"
                                                                            onchange="getsubcategory(this)"
                                                                            class="form-control select2 validate-select-required"
                                                                            data-error="Please select HAZARD CATEGORY"
                                                                            style="width: 100%;">
                                                                            <option value="">Please Select HAZARD
                                                                                CATEGORY</option>
                                                                            @foreach ($hazardCategoryDetails as $hazardcategory)
                                                                                <option
                                                                                    value="{{ encryptId($hazardcategory->id) }}"
                                                                                    @if ($generalHazard->hazard_category == $hazardcategory->id) selected @endif>
                                                                                    {{ $hazardcategory->category_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <select
                                                                            name="jsadetails[{{ $i }}][hazard_category_incident]"
                                                                            id="hazard_category_incident_{{ $i }}"
                                                                            class="form-control select2 validate-select-required"
                                                                            data-error="Please select HAZARD (POTENTIAL INCIDENT)"
                                                                            onchange="othersshow(this)"
                                                                            style="width: 100%;"
                                                                            data-selected="{{ encryptId($generalHazard->hazard_category_incident) }}">
                                                                            <option value="">Please select HAZARD
                                                                                (POTENTIAL INCIDENT)</option>
                                                                        </select>
                                                                        <input type="text"
                                                                            name="jsadetails[{{ $i }}][hazard_category_incident_other]"
                                                                            id="hazard_category_incident_other_{{ $i }}"
                                                                            class="form-control validate-input-required mt-2"
                                                                            placeholder="Others" style="display: none;">
                                                                        @if ($generalHazard->hazard_category_incident_other != '')
                                                                            <div class="mt-1 text-muted small">
                                                                                {{ $generalHazard->hazard_category_incident_other }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <input type="text"
                                                                            name="jsadetails[{{ $i }}][who_what_harmed]"
                                                                            id="who_what_harmed_{{ $i }}"
                                                                            class="form-control validate-input-required"
                                                                            data-error="Please enter WHO/WHAT MIGHT BE HARMED"
                                                                            value="{{ $generalHazard->who_what_harmed }}">
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <input type="text"
                                                                            name="jsadetails[{{ $i }}][seo_mea_or_rec_act_or_pro]"
                                                                            id="seo_mea_or_rec_act_or_pro_{{ $i }}"
                                                                            class="form-control validate-input-required"
                                                                            data-error="Please enter Product Name"
                                                                            value="{{ $generalHazard->seo_mea_or_rec_act_or_pro }}">
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <select
                                                                            name="jsadetails[{{ $i }}][likelihood]"
                                                                            id="likelihood_{{ $i }}"
                                                                            class="form-control select2 validate-select-required"
                                                                            onchange="calculateRiskmatrix(this)"
                                                                            data-error="Please select LIKELIHOOD">
                                                                            <option value="">Please Select</option>
                                                                            @for ($j = 1; $j <= 5; $j++)
                                                                                <option value="{{ $j }}"
                                                                                    @if ($generalHazard->likelihood == $j) selected @endif>
                                                                                    {{ $j }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <select
                                                                            name="jsadetails[{{ $i }}][severity]"
                                                                            id="jsadetails_{{ $i }}"
                                                                            class="form-control select2 validate-select-required"
                                                                            onchange="calculateRiskmatrix(this)"
                                                                            data-error="Please select SEVERITY">
                                                                            <option value="">Please Select</option>
                                                                            @for ($j = 1; $j <= 5; $j++)
                                                                                <option value="{{ $j }}"
                                                                                    @if ($generalHazard->severity == $j) selected @endif>
                                                                                    {{ $j }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <input type="hidden"
                                                                            name="jsadetails[{{ $i }}][risk_matrix]"
                                                                            id="risk_matrix_{{ $i }}"
                                                                            data-error="Please enter ACTION/ RESPONSIBLE PARTY">
                                                                        <span class="risk_matrix"
                                                                            id="risk_{{ $i }}">
                                                                            @if ($generalHazard->risk_matrix)
                                                                                <span
                                                                                    style="background-color: {{ $riskmatrixDetails[$generalHazard->risk_matrix]['color_code'] }}; border: 1px solid #ccc; height: 35px; padding: 7px; display: block; text-align: center;">
                                                                                    {{ $generalHazard->risk_matrix }}
                                                                                </span>
                                                                            @endif
                                                                        </span>
                                                                    </td>
                                                                    <td class="form-input">
                                                                        <input type="text"
                                                                            name="jsadetails[{{ $i }}][action_responsible]"
                                                                            id="action_responsible_{{ $i }}"
                                                                            class="form-control validate-input-required"
                                                                            data-error="Please enter ACTION/ RESPONSIBLE PARTY"
                                                                            value="{{ $generalHazard->action_responsible }}">
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <span class="fa fa-trash removerow text-danger"
                                                                            style="cursor: pointer;"></span>
                                                                    </td>
                                                                </tr>
                                                                @php $i++; @endphp
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="card-header card-header-inner  mb-3 ">
                                        <h6 class="text-white">SECTION G - PERMIT ISSUANCE</h6>
                                    </div>

                                    <div class="col-md-12">

                                        <div class="m-2 form-input">

                                            <input disabled class="form-check-input" type="checkbox" value="1"
                                                @if ($general->apllication_ack == 1) checked @endif name="accept_terms"
                                                id="accept_terms" required>
                                            <label class="form-check-label" for="accept_terms">I <b>fully
                                                    understand </b>& will <b>ensure compliance</b> with all the
                                                requirements of this permit.</label>
                                        </div>
                                    </div>


                                    <div class="row g-3 px-2 pt-4 mb-3">
                                        <label class="col-sm-2 col-form-label">
                                            Name</label>
                                        <div class="col-sm-4 form-input">
                                            <input type="text" class="form-control" readonly id="username"
                                                value="{{ getUserName($general->created_by) }}">
                                        </div>
                                        <label class="col-sm-2 col-form-label form-input">
                                            Date & Time</label>
                                        <div class="col-sm-4 form-input">
                                            <input type="text" class="form-control" id="dateandtime" readonly
                                                value="{{ displayDateformat($general->created_at) }}" name="dateandtime"
                                                placeholder="">
                                        </div>
                                    </div>

                                    <div class="row mb-2 px-2 pt-4">
                                        <label class="col-sm-2 col-form-label">
                                            Remarks</label>
                                        <div class="col-sm-10">
                                            <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3">{{ $general->application_remarks }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Update">Update</button>
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

        var selectedAreaOwner = `{{ encryptId($general->area_owner) }}`;

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
                            $('#specific_location').append('<option value="' + value.id + '">' +
                                value.name + '</option>');
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
                        $('#area_owner').empty().append('<option value="">Select Area Owner</option>');
                        $.each(data, function(key, value) {
                            var selected = value.id == selectedAreaOwner ? 'selected' : '';
                            $('#area_owner').append('<option value="' + value.id + '" ' +
                                selected + '>' + value.name + '</option>');
                        });
                        $('#area_owner').trigger('change.select2');
                    }
                });
            } else {
                $('#area_owner').empty().append('<option value="">Select Area Owner</option>');
                $('#area_owner').trigger('change.select2');
            }
        });



        var initialSplLocationId = $('#specific_location').val();

        if (initialSplLocationId) {
            $('#specific_location').trigger('change');
        }


        $('#work_type').change(function() {
            var workTypeId = $(this).val();
            var selectedVal = `{{ encryptId($general->supervising_authority) }}`;

            if (workTypeId) {
                $.ajax({
                    url: "{{ admin_url('work_type/getSupervisingAuthority/') }}" + workTypeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#supervising_authority').empty().append(
                            '<option value="">Select Supervising Authority</option>');

                        $.each(data, function(key, value) {
                            var selected = value.id == selectedVal ? 'selected' : '';
                            $('#supervising_authority').append('<option value="' + value.id +
                                '" ' + selected + '>' +
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

        var initialWorkTypeId = $('#work_type').val();

        if (initialWorkTypeId) {
            $('#work_type').trigger('change');
        }


        $(function() {
            $('#general_ptw_add').validate({
                rules: {

                    company: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    dateofcommencement: {
                        required: true,
                    },
                    dateofcompletion: {
                        required: true,
                    },
                    workdescription: {
                        required: true,
                    },
                    "supporting_documents_file[]": {
                        required: true,
                    },
                    accept_terms: {
                        required: true,
                    },
                    applicant_remarks: {
                        //required: true,
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
                        required: "Please selecct Company",
                    },
                    location: {
                        required: "Please select Location",
                    },
                    dateofcommencement: {
                        required: 'Please select the Date of Commencement',
                    },
                    dateofcompletion: {
                        required: 'Please select the Date of Completion',
                    },
                    workdescription: {
                        required: "Please enter work Description",
                    },
                    "supporting_documents_file[]": {
                        required: "Please upload a file",
                    },
                    accept_terms: {
                        required: 'Please accept ',
                    },
                    applicant_remarks: {
                        //required: 'Please enter Remarks',
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

            var selectedIncident = $('#hazard_category_incident_' + rowIndex).data('selected');
            if (categoryId) {
                $.ajax({
                    url: "{{ admin_url('ptw/general/getsubcategory') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        categoryId: categoryId
                    },
                    dataType: 'json',
                    success: function(data) {
                        var $incidentSelect = $('#hazard_category_incident_' + rowIndex);
                        $incidentSelect.empty().append(
                            '<option value="">Please select HAZARD (POTENTIAL INCIDENT)</option>'
                        );
                        console.log(data);
                        $.each(data, function(key, value) {
                            var isSelected = (selectedIncident == value.id) ? 'selected' : '';
                            $incidentSelect.append(
                                '<option value="' + value.id + '" ' + isSelected + '>' + value
                                .name + '</option>'
                            );
                        });

                        $incidentSelect.trigger('change.select2');
                    }
                });
            } else {
                $('#hazard_category_incident_' + rowIndex).empty().append(
                    '<option value="">Please select HAZARD (POTENTIAL INCIDENT)</option>'
                ).trigger('change.select2');
            }
        }

        $(document).ready(function() {
            $('[id^="hazard_category_"]').each(function() {
                getsubcategory(this);
            });
        });



        function othersshow(element) {

            var getvalue = element.value;
            var rowIndex = element.id.split('_').pop();

            if (getvalue == 0 && getvalue != '') {

                $('#hazard_category_incident_other_' + rowIndex).show();

            } else {
                $('#hazard_category_incident_other_' + rowIndex).hide();
            }
        }
    </script>
@endpush
