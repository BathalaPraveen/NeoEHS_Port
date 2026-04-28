@extends('admin.layouts.layout')
@section('title', 'Machinery View')
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
                            <li class="breadcrumb-item active" aria-current="page">Machinery View</li>
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
                                    <h5 class="card-title">Machinery View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('machinery/machinery/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">
                                    @csrf

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
                                                <label for="company_name" class="form-label font-weight-bold">Name of
                                                    Company</label>
                                                <input type="text" name="company_name" class="form-control"
                                                    id="company_name" readonly required
                                                    value="{{ $user->companyInfo->company_name }}">
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="applicant_name" class="form-label font-weight-bold">Company
                                                    representative/
                                                    applicant</label>
                                                <input type="text" name="applicant_name" class="form-control" readonly
                                                    id="applicant_name" required value="{{ $user->name }}">
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="job_designation" class="form-label font-weight-bold">Job
                                                    Designation</label>
                                                <input type="text" name="job_designation" class="form-control" readonly
                                                    id="job_designation"
                                                    value="{{ $user->user_designation_name }}" required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="tel_number" class="form-label font-weight-bold">No. Tel /
                                                    Fax</label>
                                                <input type="text" name="tel_number" class="form-control" readonly
                                                    id="tel_number" value="{{ $user->mobile }}" readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="id_number" class="form-label font-weight-bold">No.
                                                    Identification
                                                    Card</label>
                                                <input type="text" name="id_number" value="{{ $user->id }}" readonly
                                                    class="form-control" id="id_number" required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="dateandtime" class="form-label font-weight-bold">Date &
                                                    Time</label>
                                                <input type="text" name="dateandtime" class="form-control"
                                                    id="dateandtime"
                                                    value="{{ displayDatetimeFormat($machineryDetails->created_at) }}"
                                                    readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label font-weight-bold">Location</label>
                                                <div>
                                                    {{ $machineryDetails->location_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="specific_location" class="form-label font-weight-bold">Specific
                                                    Location</label>
                                                <div>
                                                    {{ $machineryDetails->specific_loc_name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART B: MACHINERY LOCATION OF USE</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label font-weight-bold">Area</label>
                                            <div>
                                                {{ $machineryDetails->area }}
                                            </div>

                                        </div>


                                        <div class="col-md-8 form-input">
                                            <label for="location" class="form-label font-weight-bold">Vessel name (If
                                                Applicable)</label>
                                            <div>
                                                {{ $machineryDetails->vessel_name }}
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART C: TYPE OF MACHINERY</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-4 form-input">
                                            <label for="machinerytype" class="form-label font-weight-bold">TYPE OF
                                                MACHINERY</label>
                                            <div>
                                                {{ $machineryDetails->machinery_type_name }}
                                            </div>
                                        </div>

                                        @if($machineryDetails->machinery_type == 0)

                                        <div class="col-md-4 form-input">
                                            <label for="machinerytype" class="form-label font-weight-bold">TYPE OF
                                                MACHINERY Others</label>
                                            <div>
                                                {{ $machineryDetails->machinery_type_others }}
                                            </div>
                                        </div>


                                        @endif

                                    </div>
                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART D: PARTICULARS OF MACHINERY</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">
                                        @foreach ($partucularmachineryDetails as $particularmachinery)
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
                                                    class="form-label custominputlabel font-weight-bold ">{{ $particularmachinery->particulars_name }}</label>
                                                <div>
                                                    {{ $value }}
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART E: SUPPORTING DOCUMENTS</h6>
                                    </div>


                                    <div class="row g-3 px-4 pt-4">
                                        @foreach ($supportingdocumentsDetails as $supportdocument)
                                            <div class="col-md-4 form-input">
                                                <label for="machinerytype"
                                                    class="form-label custominputlabel">{{ $supportdocument->document_name }}</label>
                                                <div>
                                                    @if (isset($supportDocDetails[$supportdocument->id]))
                                                        <a href="{{ url($supportDocDetails[$supportdocument->id]['file_path']) }}"
                                                            target="_blank">
                                                            {{ $supportDocDetails[$supportdocument->id]['file_orgname'] }}
                                                        </a>
                                                    @endif
                                                </div>
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
                                            <label for="machinerytype" class="form-label font-weight-bold">PURPOSE OF
                                                USE</label>

                                            <div>
                                                {{ $machineryDetails->purposeofuse }}
                                            </div>

                                        </div>

                                    </div>
                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART H: MACHINERY INSPECTOR FROM GROUP HEALTH, SAFETY
                                            AND ENVIRONMENT DEPARTMENT</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-6 form-input">
                                            <label for="inspectiondate" class="form-label font-weight-bold">Propose
                                                date of inspection</label>
                                            <div>
                                                {{ displayDateformat($machineryDetails->inspectiondate) }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-input">
                                            <label for="inspectiontime" class="form-label font-weight-bold">Propose
                                                time of inspection</label>
                                            <div>
                                                {{ $machineryDetails->inspectiontime }}
                                            </div>

                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="purposelocationofinspection"
                                                class="form-label font-weight-bold">Propose location of
                                                inspection</label>
                                            <div>
                                                {{ $machineryDetails->purposelocationofinspection }}
                                            </div>

                                        </div>

                                    </div>

                                    @if ($machineryDetails->machinery_tag != null)
                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">Inspection Details</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-1">
                                            <label class="col-sm-2  font-weight-bold">
                                                Machinery Tag</label>
                                            <div class="col-sm-4 form-input">
                                                {{ $machineryDetails->machinery_tag }}
                                            </div>
                                            <label class="col-sm-2  form-input font-weight-bold">
                                                Checklist </label>
                                            <div class="col-sm-4 form-input">
                                                @if ($machineryDetails->inspection_checklist != null)
                                                    <a href="{{ url($inspectionFiles[$machineryDetails->inspection_checklist]['file_path']) }}"
                                                        target="_blank">
                                                        {{ $inspectionFiles[$machineryDetails->inspection_checklist]['file_orgname'] }}
                                                    </a>
                                                @endif
                                            </div>
                                            <label class="col-sm-2  font-weight-bold">
                                                Expired</label>
                                            <div class="col-sm-4 form-input">
                                                {{ displayDateformat($machineryDetails->expiry_date) }}
                                            </div>
                                        </div>
                                    @endif


                                    @if (count($statuslogs) > 0)
                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">APPROVAL</h6>
                                        </div>
                                        @foreach ($statuslogs as $statusLog)
                                            <div class="row  px-3">
                                                <div class="col-md-12">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr style="background-color: #aaa">
                                                                <td colspan="6" style="font-weight:500;"> Status -
                                                                    {!! machhineryStatus($statusLog->to_status) !!} </td>
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


                                    @if (isset($approvereject))
                                        @if ($machineryDetails->machinery_status == MACHINERY_STATUS_GHSE_APPROVE_PENDING)
                                            <form action="{{ admin_url('machinery/machinery/approvereject/submit') }}"
                                                method="POST">
                                                <div class=" border rounded">
                                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                                        <h6 class="text-white">Approve / Reject</h6>
                                                    </div>
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ encryptId($machineryDetails->id) }}">
                                                    <div class="row g-3 px-2 pt-4">

                                                        <div class="row mb-3 mt-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                Name</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="text" class="form-control"
                                                                    name="approvedby" id="approvedby"
                                                                    value="{{ Auth::user()->name }}" readonly>

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
                                                            <button class="btn btn-primary " id="btnsubmit"
                                                                type="submit" name="approve" value="yes"
                                                                data-bs-toggle="tooltip" title="Approve">Approve</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif

                                    @if (isset($inspection))
                                        @if ($machineryDetails->machinery_status == MACHINERY_STATUS_HSE_INSP_PENDING)
                                            <form action="{{ admin_url('machinery/machinery/inspectionupdate/submit') }}"
                                                enctype="multipart/form-data" method="POST">
                                                <div class=" border rounded">
                                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                                        <h6 class="text-white">Inspection Update</h6>
                                                    </div>
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ encryptId($machineryDetails->id) }}">
                                                    <div class="row g-3 px-2 pt-4">

                                                        <div class="row mb-3 mt-3">
                                                            <label class="col-sm-2 col-form-label require">
                                                                Machinery Entry Tag Number</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="text" class="form-control"
                                                                    name="machinerytag" id="machinerytag" required>

                                                            </div>
                                                            <label class="col-sm-2 col-form-label form-input">
                                                                Inspection Checklist</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="file" class="form-control"
                                                                    name="inspectionchecklist" id="inspectionchecklist">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3 mt-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                Name</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="text" class="form-control"
                                                                    name="approvedby" id="approvedby"
                                                                    value="{{ Auth::user()->name }}" readonly>

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
                                                            <button class="btn btn-primary " id="btnsubmit"
                                                                type="submit" name="approve" value="yes"
                                                                data-bs-toggle="tooltip" title="Approve">Approve</button>
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
            $('#useeuact_add').validate({
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
                $(".custominputlabel").removeClass("font-weight-bold");

                // Add validation based on the selected dropdown value
                $(".custominput").each(function() {
                    var classes = $(this).attr("class").split(" ");
                    $(this).closest(".form-input").find("span").remove();

                    // Check if the selected value is present in the classes
                    if ($.inArray(typeid.toString(), classes) !== -1) {

                        $(this).closest(".form-input").find("label").addClass("font-weight-bold");
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
                $(".custominputlabel").removeClass("font-weight-bold");
            }
        });
    </script>
@endpush
