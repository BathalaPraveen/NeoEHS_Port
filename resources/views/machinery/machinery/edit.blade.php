@extends('admin.layouts.layout')
@section('title', 'Machinery Edit')
@section('pageurl', admin_url('machinery/machinery/list'))

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
                                UAUC
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('machinery/machinery/list') }}">Machinery</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Machinery Edit</li>
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
                                    <h5 class="card-title">Machinery Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('machinery/machinery/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="useeuact_edit" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('machinery/machinery/edit/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($machineryDetails->id) }}">
                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">PART A : APPLICANT DETAILS</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">
                                            <p>I hereby to confirm that the information below is true and agree to perform
                                                as follows :</p>
                                            <ol class="p-2 mx-3">
                                                <li>
                                                    Bound by the provisions in the Occupational Safety and Health Act 1994,
                                                    Factories and Machinery Act 1967, Bintulu Port Group Company Safety
                                                    Policy, other relevant government legislation and regulations.
                                                </li>
                                                <li>
                                                    All losses of Bintulu Port Group Company must be borne in full for all
                                                    claims, requests, legal actions, proceedings, orders, costs, losses and
                                                    expenses in any form that Bintulu Port Group Holdings Berhad may
                                                    experience or incur in connection with our use of the equipment
                                                    mentioned in Bintulu Port.
                                                </li>
                                                <li>
                                                    Comply with all the requirement and regulations that have been set.
                                                </li>
                                                <li>
                                                    If the contractor/ port user is found not to comply with the Bintulu
                                                    Port Holdings Berhad Group's safety policy, the Group Safety, Health and
                                                    Environment Division has the right to withdraw the approved Machinery
                                                    Tag at any time.
                                                </li>
                                                <li>
                                                    This notification is valid for the specific operation as presented and
                                                    is not transferable.
                                                </li>
                                                <li>
                                                    Submit all relevant documents as requested.
                                                </li>
                                            </ol>


                                            @php
                                                $user = getuser($machineryDetails->created_by);
                                            @endphp

                                            <div class="row">
                                                <div class="col-md-4 form-input">
                                                    <label for="company_name" class="form-label require">Name of
                                                        Company</label>
                                                    <input type="text" name="company_name" class="form-control"
                                                        id="company_name" readonly required
                                                        value="{{ $user->companyInfo->company_name }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="applicant_name" class="form-label require">Company
                                                        representative/
                                                        applicant</label>
                                                    <input type="text" name="applicant_name" class="form-control"
                                                        readonly id="applicant_name" required value="{{ $user->name }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="job_designation" class="form-label require">Job
                                                        Designation</label>
                                                    <input type="text" name="job_designation" class="form-control"
                                                        readonly id="job_designation"
                                                        value="{{ $user->user_designation_name }}" required>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="tel_number" class="form-label require">No. Tel / Fax</label>
                                                    <input type="text" name="tel_number" class="form-control" readonly
                                                        id="tel_number" value="{{ $user->mobile }}" readonly required>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="id_number" class="form-label require">No. Identification
                                                        Card</label>
                                                    <input type="text" name="id_number" value="{{ $user->id }}"
                                                        readonly class="form-control" id="id_number" required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="dateandtime" class="form-label require">Date & Time</label>
                                                    <input type="text" name="dateandtime" class="form-control"
                                                        id="dateandtime"
                                                        value="{{ displayDatetimeFormat($machineryDetails->created_at) }}"
                                                        readonly required>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="location" class="form-label require">Location</label>
                                                    <select name="location" id="location" class="form-control select2">
                                                        <option>Select Location</option>
                                                        @foreach ($locationDetails as $location)
                                                            <option @if ($location->id == $machineryDetails->location) selected @endif
                                                                value="{{ encryptId($location->id) }}">
                                                                {{ $location->location_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="specific_location" class="form-label require">Specific
                                                        Location</label>
                                                    <select name="specific_location" id="specific_location"
                                                        class="form-control select2">
                                                        <option>Select Specific Location</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART B: MACHINERY LOCATION OF USE</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label require">Area</label>
                                                <input type="text" name="area" id="area" class="form-control"
                                                    value="{{ $machineryDetails->area }}" required>
                                            </div>


                                            <div class="col-md-8 form-input">
                                                <label for="location" class="form-label ">Vessel name (If
                                                    Applicable)</label>
                                                <textarea name="vessel_name" id="vessel_name" class="form-control" rows="3">{{ $machineryDetails->vessel_name }}</textarea>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART C: TYPE OF MACHINERY</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="machinerytype" class="form-label require">TYPE OF
                                                    MACHINERY</label>
                                                <select name="machinerytype" id="machinerytype"
                                                    class="form-control select2">
                                                    <option>Select Machinery Type</option>
                                                    @foreach ($machinerytypeDetails as $machinerytype)
                                                        <option @if ($machineryDetails->machinery_type == $machinerytype->id) selected @endif
                                                            value="{{ encryptId($machinerytype->id) }}">
                                                            {{ $machinerytype->machinery_type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input" id="machinery_type_others_div" @if($machineryDetails->machinery_type != 0) style="display:none" @endif >
                                                <label for="machinery_type_others" class="form-label require">TYPE OF
                                                    MACHINERY Others</label>
                                                <input type="text" name="machinery_type_others" class="form-control" value="{{ $machinerytype->machinery_type_others }}">

                                            </div>

                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART D: PARTICULARS OF MACHINERY</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">
                                            @foreach ($partucularmachineryDetails as $particularmachinery)
                                                @php
                                                    $class = '';

                                                    $classArray = string_to_array($particularmachinery->req_machinery_type);

                                                    foreach ($classArray as $classname) {
                                                        $class .= encryptId($classname) . ' ';
                                                    }
                                                    if ($particularmachinery->input_type == 'date') {
                                                        $readonly = 'readonly';
                                                        $class .= 'datepicker';
                                                        $dataerror = 'Please select the ' . $particularmachinery->particulars_name;
                                                    } else {
                                                        $readonly = '';
                                                        $class .= '';
                                                        $dataerror = 'Please enter the ' . $particularmachinery->particulars_name;
                                                    }
                                                @endphp

                                                @php

                                                    $particularmachineryArray = json_decode($machineryDetails->particularmachinery);

                                                    $id = $particularmachinery->id;

                                                    if ($particularmachinery->input_type == 'date') {
                                                        $value = $particularmachineryArray->$id != null ? displayDateformat($particularmachineryArray->$id) : '';
                                                    } else {
                                                        $value = $particularmachineryArray->$id;
                                                    }
                                                @endphp
                                                <div class="col-md-4 form-input">
                                                    <label for="machinerytype"
                                                        class="form-label custominputlabel ">{{ $particularmachinery->particulars_name }}</label>
                                                    <input type="text" data-error ="{{ $dataerror }}"
                                                        name="particularmachinery[{{ encryptId($particularmachinery->id) }}]"
                                                        {{ $readonly }} value="{{ $value }}"
                                                        class="form-control custominput {{ $class }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART E: SUPPORTING DOCUMENTS</h6>
                                        </div>


                                        <div class="row g-3 px-4 pt-4">
                                            @foreach ($supportingdocumentsDetails as $supportdocument)
                                                @php
                                                    $class = '';

                                                    $classArray = string_to_array($supportdocument->req_machinery_type);

                                                    foreach ($classArray as $classname) {
                                                        $class .= encryptId($classname) . ' ';
                                                    }
                                                    $dataerror = 'Please select the ' . $supportdocument->document_name;
                                                @endphp

                                                <div class="col-md-4 form-input">
                                                    <label for="machinerytype"
                                                        class="form-label custominputlabel">{{ $supportdocument->document_name }}</label>
                                                    <input type="file" data-error="{{ $dataerror }}"
                                                        name="supportdocument[{{ encryptId($supportdocument->id) }}]"
                                                        class="form-control custominput {{ $class }}">
                                                    <br>
                                                    @if (isset($supportDocDetails[$supportdocument->id]))
                                                        <a href="{{ url($supportDocDetails[$supportdocument->id]['file_path']) }}"
                                                            target="_blank">
                                                            {{ $supportDocDetails[$supportdocument->id]['file_orgname'] }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART F: PURPOSE OF MACHINERY BEING USE</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <p>Example : Loading goods into the vessel, Installation /Inspection electrical
                                                appliances, Maintenance work, etc.</p>

                                            <div class="col-md-12 form-input">
                                                <label for="machinerytype" class="form-label require">PURPOSE OF
                                                    USE</label>
                                                <textarea name="purposeofuse" id="purposeofuse" class="form-control" rows="5"> {{ $machineryDetails->purposeofuse }}</textarea>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART H: MACHINERY INSPECTOR FROM GROUP HEALTH, SAFETY
                                                AND ENVIRONMENT DEPARTMENT</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-6 form-input">
                                                <label for="inspectiondate" class="form-label require">Propose
                                                    date of inspection</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control inspectiondatepicker"
                                                        id="inspectiondate" placeholder="Inspection Date"
                                                        value=" {{ displayDateformat($machineryDetails->inspectiondate) }}"
                                                        name="inspectiondate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 form-input">
                                                <label for="inspectiontime" class="form-label require">Propose
                                                    time of inspection</label>

                                                @php
                                                    $inspectionTime = INSPECTION_TIME;
                                                @endphp
                                                <select name="inspectiontime" id="inspectiontime"
                                                    class="form-control select2">
                                                    <option>Select inpection Time</option>
                                                    @foreach ($inspectionTime as $time)
                                                        <option value="{{ $time }}"
                                                            @if ($machineryDetails->inspectiontime == $time) selected @endif>
                                                            {{ $time }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="purposelocationofinspection"
                                                    class="form-label require">Propose location of
                                                    inspection</label>
                                                <textarea name="purposelocationofinspection" id="purposelocationofinspection" class="form-control" rows="5">{{ $machineryDetails->purposelocationofinspection }}</textarea>
                                            </div>


                                        </div>

                                    </div>
                                </div>


                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>

                                        <div class="col-md-12 form-input">
                                            <label for="purposelocationofinspection"
                                                class="form-label require">Remarks</label>
                                            <textarea name="remarks" id="remarks" class="form-control" rows="5"></textarea>
                                        </div>

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
        $(".inspectiondatepicker").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'daysOfWeekDisabled': [0, 6]
            //'datesDisabled':['16-11-2023','17-11-2023']
        });


        $(function() {
            $('#useeuact_edit').validate({
                rules: {
                    reporter_name: {
                        required: true,
                    },
                    reporter_email: {
                        required: true,
                    },
                    reporter_company: {
                        required: true,
                    },
                    reporter_division: {
                        required: true,
                    },
                    reporter_department: {
                        required: true,
                    },
                    dateandtime: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    specific_location: {
                        required: true,
                    },
                    area: {
                        required: true,
                    },
                    machinerytype: {
                        required: true,
                    },
                    machinery_type_others: {
                        required: true,
                    },
                    purposeofuse: {
                        required: true,
                    },
                    inspectiondate: {
                        required: true,
                    },
                    inspectiontime: {
                        required: true,
                    },
                    purposelocationofinspection: {
                        required: true,
                    },


                },
                messages: {
                    reporter_name: {
                        required: "Please enter Reporter Name",
                    },
                    reporter_email: {
                        required: "Please enter Reporter Email",
                    },
                    reporter_company: {
                        required: "Please enter Reporter Company",
                    },
                    reporter_division: {
                        required: "Please enter Reporter Division",
                    },
                    reporter_department: {
                        required: "Please enter Reporter Department",
                    },
                    dateandtime: {
                        required: "Please enter Date & Time",
                    },
                    location: {
                        required: "Please select Location",
                    },
                    specific_location: {
                        required: "Please select Specific Location"
                    },
                    area: {
                        required: "Please select Area",
                    },
                    machinerytype: {
                        required: "Please select Machinery Type",
                    },
                    machinery_type_others: {
                        required: "Please enter Machinery Type Others",
                    },
                    purposeofuse: {
                        required: "Please enter Purpose of Use",
                    },
                    inspectiondate: {
                        required: "Please select Inspection Date",
                    },
                    inspectiontime: {
                        required: "Please select Inspection Time",
                    },
                    purposelocationofinspection: {
                        required: "Please enter the Propose location of inspection",
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


        $('#machinerytype').change(function() {
            var typeid = $(this).val();
            if (typeid) {

                // Remove inputtext and inputfile class names from all inputs
                $(".custominput").removeClass("validate-input-required validate-file-required is-invalid")
                    .removeAttr("required");
                $(".custominputlabel").removeClass("require");

                // Add validation based on the selected dropdown value
                $(".custominput").each(function() {
                    var classes = $(this).attr("class").split(" ");
                    $(this).closest(".form-input").find("span").remove();

                    // Check if the selected value is present in the classes
                    if ($.inArray(typeid.toString(), classes) !== -1) {

                        $(this).closest(".form-input").find("label").addClass("require");
                        // Add inputtext class for text inputs
                        if ($(this).attr("type") === "text") {
                            $(this).addClass("validate-input-required");
                        }

                        // Add inputfile class for file inputs
                        if ($(this).attr("type") === "file") {
                            $(this).addClass("validate-file-required");
                        }
                    }
                });

            } else {
                $(".custominput").removeClass("validate-input-required validate-file-required is-invalid")
                    .removeAttr("required");
                $(".custominputlabel").removeClass("require");
            }
        });
    </script>
@endpush
