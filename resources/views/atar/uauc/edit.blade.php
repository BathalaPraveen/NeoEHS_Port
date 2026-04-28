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
                            <form id="general_ptw_add" novalidate method="POST"
                                action="{{ admin_url('ptw/general/edit/submit') }}">
                                <input type="hidden" name="id" value="{{ encryptId($general->id) }}">
                                @csrf
                                @php
                                    $i = 1;
                                @endphp

                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">SECTION A - APPLICATION</h6>
                                    </div>
                                    <div class="row g-3 p-4">
                                        <div class="row mb-3">
                                            <div class="col-md-3 require">{{ $i++ }}.Area of Work (Tick where
                                                applicable)</div>
                                            <div class="col-md-9">
                                                <div class="row form-input">
                                                    @foreach ($companyDetails as $company)
                                                        <div class="col-md-3">
                                                            <div class="m-2">

                                                                @php
                                                                    $workingcompany = string_to_array($general->area_of_work);
                                                                @endphp

                                                                <input class="form-check-input" type="checkbox" required
                                                                    @if (in_array($company->id, $workingcompany)) checked @endif
                                                                    value="{{ encryptId($company->id) }}" name="company[]"
                                                                    id="company_{{ encryptId($company->id) }}">
                                                                <label class="form-check-label"
                                                                    for="company_{{ encryptId($company->id) }}">{{ $company->company_name }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Applicant Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="applicant_name"
                                                    name="applicant_name" value="" required>
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                NRIC/Passport No</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="passport_number"
                                                    name="passport_number" value="" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Contact / HP No.</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="contact_number"
                                                    name="contact_number" value="" required>
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Office No.</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="office_number" required
                                                    name="office_number" value="">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                E-mail</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    required value="">
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Designation</label>
                                            <div class="col-sm-4 form-input">
                                                <select name="designation" id="designation" class="from-control select2"
                                                    required style="width: 100%" style="">
                                                    <option value="">Select Designation</option>
                                                    @foreach ($designationDetails as $designation)
                                                        <option value="{{ encryptId($designation->id) }}">
                                                            {{ $designation->designation_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Company</label>
                                            <div class="col-sm-4 form-input">
                                                <select name="" class="form-control select2" id="company" required
                                                    name="company">
                                                    <option value="">Select Company</option>
                                                    @foreach ($contractorCompanyDetails as $contractorCompany)
                                                        <option value="{{ encryptId($contractorCompany->id) }}">
                                                            {{ $contractorCompany->con_comp_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Work
                                                Description</label>
                                            <div class="col-sm-10 form-input">
                                                <textarea name="work_desc" id="work_desc" class="form-control" rows="3" required>{{ $general->work_description }}</textarea>
                                            </div>
                                        </div>


                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Location (Please Attach Plan/Drawing where applicable)</label>
                                            <div class="col-sm-4 form-input">
                                                <select name="location" class="form-control select2" required
                                                    id="location">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locationDetails as $location)
                                                        <option value="{{ encryptId($location->id) }}"
                                                            @if ($general->location == $location->id) selected @endif>
                                                            {{ $location->location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Date of Commencement / Resumption</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control datepicker"
                                                    id="date_commencement" required name="date_commencement"
                                                    value="{{ displayDateformat($general->date_of_commencement) }}">
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Date of Completion</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control datepicker"
                                                    id="date_completion" required name="date_completion"
                                                    value="{{ displayDateformat($general->date_of_completion) }}">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Officer in-charge Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="officer_name" required
                                                    name="officer_name" value="{{ $general->incharge_name }}">
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Applicant Signature</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="applicaion_signature"
                                                    required name="applicaion_signature" value="">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Date of Application</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control datepicker"
                                                    id="date_of_applicaion" required name="date_of_applicaion"
                                                    value="{{ displayDateformat($general->date_of_application) }}">
                                            </div>
                                            <label class="col-sm-2 col-form-label require">{{ $i++ }}.
                                                Company Stamp / Seal</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="company_stamp"
                                                    name="company_stamp" required>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner  mb-3 ">
                                            <h6 class="text-white"> SECTION B - HAZARDOUS ACTIVITY / HAZARD</h6>
                                        </div>

                                        @php

                                            $hazardData = json_decode($general->hazard);

                                            if ($hazardData == '' || $hazardData == null) {
                                                $hazardData = new stdClass();
                                                $hazardData->hazard = [];
                                                $hazardData->hazard_others_text = '';
                                            }

                                        @endphp

                                        <div class="row mb-3">
                                            @foreach ($hazardDetails as $hazard)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">
                                                            {{ $i++ }}.
                                                        </span>
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ encryptId($hazard->id) }}" name="hazard[]"
                                                            @if (in_array($hazard->id, $hazardData?->hazard)) checked @endif
                                                            id="checkbox_{{ encryptId($hazard->id) }}">
                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($hazard->id) }}">{{ $hazard->category_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-md-3">

                                                <div class="m-2">
                                                    <span style="">
                                                        {{ $i++ }}.
                                                    </span>
                                                    <input class="form-check-input othersshow" type="checkbox"
                                                        @if (in_array(0, $hazardData->hazard)) checked @endif
                                                        value="{{ encryptId(0) }}" name="hazard[]"
                                                        data-id="hazard_others">
                                                    <label class="form-check-label" for="hazard_others">Others</label>
                                                </div>

                                                <div @if (!in_array(0, $hazardData->hazard)) style="display:none" @endif
                                                    class="othersadd" id="hazard_others">
                                                    <input type="text" class="form-control" name="hazard_others_text"
                                                        value="{{ $hazardData->hazard_others_text }}">
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner  mb-3 ">
                                            <h6 class="text-white">SECTION C - SUPPORTING CERTIFICATE / DOCUMENT - where
                                                applicable</h6>
                                        </div>

                                        @php

                                            $documentData = json_decode($general->supporting_documents);

                                            if ($documentData == '' || $documentData == null) {
                                                $documentData = new stdClass();
                                                $documentData->supportcertificate = [];
                                                $documentData->supportcertificate_data = '';
                                            }

                                        @endphp

                                        <div class="row mb-3">
                                            @foreach ($supportCertificate as $certificate)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">
                                                            {{ $i++ }}.
                                                        </span>
                                                        <input class="form-check-input othersshow" type="checkbox"
                                                            data-id="support_{{ $certificate->id }}"
                                                            value="{{ encryptId($certificate->id) }}"
                                                            @if (in_array($certificate->id, $documentData->supportcertificate)) checked @endif
                                                            name="supportcertificate[]"
                                                            id="checkbox_{{ encryptId($certificate->id) }}">
                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($certificate->id) }}">{{ $certificate->category_name }}</label>
                                                    </div>
                                                    @php
                                                        $col_name = $certificate->id;
                                                       $value =  isset($documentData->supportcertificate_data->$col_name) ? $documentData->supportcertificate_data->$col_name : "";
                                                    @endphp

                                                    <div @if (!in_array($certificate->id, $documentData->supportcertificate)) style="display:none" @endif
                                                        class="" id="support_{{ $certificate->id }}">
                                                        <input type="text" class="form-control"
                                                            name="supporting_documents[{{ $certificate->id }}]"
                                                            value="{{$value  }}">
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-md-3">

                                                <div class="m-2">
                                                    <span style="">
                                                        {{ $i++ }}.
                                                    </span>
                                                    <input class="form-check-input othersshow" type="checkbox"
                                                        value="{{ encryptId(0) }}" data-id="support_others"
                                                        @if (in_array(0, $documentData->supportcertificate)) checked @endif
                                                        name="supportcertificate[]" id="supportcertificate_others">
                                                    <label class="form-check-label"
                                                        for="supportcertificate_others">Others</label>
                                                </div>
                                                <div @if (!in_array(0, $documentData->supportcertificate)) style="display:none" @endif
                                                    class="othersadd" id="support_others">
                                                    @php
                                                        $col_name = '0';
                                                        $value = isset($documentData->supportcertificate_data->$col_name) ? $documentData->supportcertificate_data->$col_name : '';
                                                    @endphp
                                                    <input type="text" class="form-control"
                                                        name="supporting_documents[0]" value="{{ $value }}">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner  mb-3 ">
                                            <h6 class="text-white">SECTION D - PERSONAL PROTECTIVE EQUIPMENT - where
                                                applicable</h6>
                                        </div>

                                        @php
                                            $equipmentData = json_decode($general->equipment_details);

                                            if ($equipmentData == '' || $equipmentData == null) {
                                                $equipmentData = new stdClass();
                                                $equipmentData->equipments = [];
                                                $equipmentData->equipments_others_text = '';
                                            }

                                        @endphp

                                        <div class="row mb-3">
                                            @foreach ($protectiveEquipment as $equipment)
                                                <div class="col-md-12">

                                                    <div class="m-2">
                                                        <div style="text-decoration:underline">
                                                            {{ $i++ }}. {{ $equipment->category_name }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        @if (isset($protectiveEquipmentItems[$equipment->id]))
                                                            @foreach ($protectiveEquipmentItems[$equipment->id] as $euipmentItems)
                                                                <div class="col-md-3">

                                                                    <div class="m-2">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            @if (in_array($euipmentItems['id'], $equipmentData->equipments)) checked @endif
                                                                            value="{{ encryptId($euipmentItems['id']) }}"
                                                                            name="equipments[]"
                                                                            id="equipment_{{ encryptId($euipmentItems['id']) }}">
                                                                        <label class="form-check-label"
                                                                            for="equipment_{{ encryptId($euipmentItems['id']) }}">{{ $euipmentItems['item_name'] }}</label>
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
                                                        {{ $i++ }}.
                                                    </span>
                                                    <input class="form-check-input othersshow" type="checkbox"
                                                        @if (in_array(0, $equipmentData->equipments)) checked @endif
                                                        value="{{ encryptId(0) }}" data-id="equipments_others"
                                                        name="equipments[]" id="equipment_other">
                                                    <label class="form-check-label" for="equipment_other">Others</label>
                                                </div>
                                                <div @if (!in_array(0, $equipmentData->equipments)) style="display:none" @endif
                                                    class="othersadd" id="equipments_others">
                                                    <input type="text" class="form-control"
                                                        name="equipments_others_text"
                                                        value="{{ $equipmentData->equipments_others_text }}">
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner  mb-3 ">
                                            <h6 class="text-white">SECTION E - WORK SITE PREPARATION / PRECAUTIONS - where
                                                applicable</h6>
                                        </div>
                                        @php
                                            $siteData = json_decode($general->site_preparation);

                                            if ($siteData == '' || $siteData == null) {
                                                $siteData = new stdClass();
                                                $siteData->sitepreparation = [];
                                                $siteData->sitepreparation_others_text = '';
                                            }

                                        @endphp
                                        <div class="row mb-3">
                                            @foreach ($sitePreparationDetails as $sitePreparation)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <span style="">
                                                            {{ $i++ }}.
                                                        </span>
                                                        <input class="form-check-input" type="checkbox"
                                                            @if (in_array($sitePreparation->id, $siteData->sitepreparation)) checked @endif
                                                            value="{{ encryptId($sitePreparation->id) }}"
                                                            name="sitepreparation[]"
                                                            id="sitepreparation_{{ encryptId($sitePreparation->id) }}">
                                                        <label class="form-check-label"
                                                            for="sitepreparation_{{ encryptId($sitePreparation->id) }}">{{ $sitePreparation->category_name }}</label>

                                                        @php
                                                            if ($i == 71) {
                                                                $i += 7;
                                                            }
                                                        @endphp
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-md-3">

                                                <div class="m-2">
                                                    <span style="">
                                                        {{ $i++ }}.
                                                    </span>
                                                    <input class="form-check-input othersshow" type="checkbox"
                                                        @if (in_array(0, $siteData->sitepreparation)) checked @endif
                                                        value="{{ encryptId(0) }}" data-id="sitepreparation_others"
                                                        name="sitepreparation[]" id="sitepreparation_other">
                                                    <label class="form-check-label" for="sitepreparation_other">Are there
                                                        any other work activities around this work area</label>
                                                </div>
                                                <div @if (!in_array(0, $siteData->sitepreparation)) style="display:none" @endif
                                                    class="othersadd" id="sitepreparation_others">
                                                    <input type="text" class="form-control"
                                                        name="sitepreparation_others_text"
                                                        value="{{ $siteData->sitepreparation_others_text }}">
                                                </div>

                                            </div>

                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner  mb-3 ">
                                            <h6 class="text-white">SECTION F - PERMIT ISSUANCE</h6>
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


                                        <div class="row mb-3 mt-3">
                                            <label class="col-sm-2 col-form-label">
                                                Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" readonly id="username"
                                                    value="{{ $general->apllication_ack }}">
                                            </div>
                                            <label class="col-sm-2 col-form-label form-input">
                                                Date & Time</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="dateandtime" readonly
                                                    value="{{ displayDateformat($general->created_at) }}"
                                                    name="dateandtime" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label">
                                                Remarks</label>
                                            <div class="col-sm-10">

                                                <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3">{{ $general->application_remarks }}</textarea>
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
        $(function() {
            $('#general_ptw_add').validate({
                rules: {

                    company_id: {
                        required: true,
                    },
                    company_name: {
                        required: true,
                    },
                    company_shortname: {
                        required: true,
                    },

                },
                messages: {
                    company_id: {
                        required: "Please enter Company ID",
                    },
                    company_name: {
                        required: "Please enter Company Name",
                    },
                    company_shortname: {
                        required: "Please enter Company Short Description",
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


        $(document).ready(function() {

            $('.othersshow').on('click', function() {

                $id = $(this).data('id');

                if ($(this).is(':checked')) {

                    $("#" + $id).show();
                } else {
                    $("#" + $id).hide();
                }
            });
        });
    </script>
@endpush
