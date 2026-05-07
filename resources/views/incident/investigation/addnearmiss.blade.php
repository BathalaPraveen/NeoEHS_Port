@extends('admin.layouts.layout')
@section('title', 'investigation Add')
@section('pageurl', admin_url('incident/investigation/list'))

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
                                <a href="{{ admin_url('incident/investigation/list') }}">Near Miss Report</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Near Miss Report Add</li>
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
                                    <h5 class="card-title">Near Miss Report Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('incident/investigation/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="incident_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('incident/investigation/nearmiss/add/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf

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
                                                            {{ displayDateformat($IncidentDetails->incident_date) }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input all">
                                                        <label for="incident_time" class="form-label require">Incident
                                                            Time</label>
                                                        <div>
                                                            {{ $IncidentDetails->incident_time }}
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="id" id="id"
                                                        value="{{ encryptId($investigation_id) }}">
                                                </div>
                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">
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

                                                <div class="col-md-6 form-input">
                                                    <label for="employee_involved" class="form-label require">Employee
                                                        Involved</label>
                                                    <textarea name="employee_involved" id="employee_involved" class="form-control" rows="5" required></textarea>
                                                </div>

                                                <div class="col-md-6 form-input">
                                                    <label for="immediate_supervisor" class="form-label require">Immediate
                                                        Supervisor</label>
                                                    <textarea name="immediate_supervisor" id="immediate_supervisor" class="form-control" rows="5" required></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>

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
                                                    <textarea name="description_of_hazard" id="description_of_hazard" class="form-control" rows="10" required></textarea>
                                                </div>
                                                <div class="col-md-12 form-input">
                                                    <label for="immediate_action" class="form-label require">Immediate
                                                        Action</label>
                                                    <textarea name="immediate_action" id="immediate_action" class="form-control" rows="10" required></textarea>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="nearmiss_status" class="form-label require">Status</label>
                                                    <select name="nearmiss_status" id="nearmiss_status" required
                                                        class="form-control select2">
                                                        <option value="1">Open</option>
                                                        <option value="0">Closed</option>
                                                    </select>
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
                                                    <label for="location" class="form-label require">Action
                                                        Taken</label>
                                                    <textarea name="action_taken" id="action_taken" required class="form-control" rows="10"></textarea>
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
                                                    </div>
                                                </div>

                                                <div class="why-container">
                                                    <div class="col-md-12">
                                                        <textarea name="why_why_analysis[0]" id="why_why_analysis_1" class="form-control" rows="5" required></textarea>
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button type="button" id="addMoreWhy"
                                                            class="btn btn-primary">Add More</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 px-4 pt-4 content-block-row">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-12">
                                                        <label for="root_cause" class="form-label require">Root
                                                            Cause</label>
                                                        <textarea name="root_cause" id="root_cause" required class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-3 form-input">
                                                        <label for="root_cause_category" class="form-label require">Root
                                                            Cause Category</label>
                                                        <select name="root_cause_category" class="select2 form-control"
                                                            id="root_cause_category">
                                                            <option value="">Select Root Cause Category</option>
                                                            @foreach ($rootcausecategoryList as $rootcausecategory)
                                                                <option value="{{ encryptId($rootcausecategory->id) }}">
                                                                    {{ $rootcausecategory->item_name }}</option>
                                                            @endforeach
                                                        </select>
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
    <script type="text/javascript">
        $(function() {

            let whyCount = 1;

            $("#addMoreWhy").click(function() {
                whyCount++;

                let newWhyHtml = `
                    <div class="why-block row" data-index="${whyCount}">
                        <div class="col-md-12" style="text-align: center;font-size: 40px;">
                            <div class="arrow-div"><i class="fas fa-arrow-down"></i></div>
                        </div>
                        <div class="col-md-11">
                            <textarea name="why_why_analysis[${whyCount}]" id="why_why_analysis_${whyCount}" class="form-control" rows="5" required></textarea>
                            
                        </div>
                        <div class="col-md-1"><a class="remove-why" style="margin-top: 10px;">
                                <i class="fas fa-trash"></i>
                            </a></div>
                    </div>
                `;

                $(".why-container").append(newWhyHtml);
            });

            $(".why-container").on("click", ".remove-why", function() {
                $(this).closest(".why-block").remove();

            });

            $('#incident_add').validate({
                rules: {
                    company: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    specific_location: {
                        required: true,
                    },
                    incidenttype: {
                        required: true,
                    },
                    incidentdate: {
                        required: true,
                    },
                    incidenttime: {
                        required: true,
                    },
                    assignto: {
                        required: true,
                    },
                    incidentremarks: {
                        required: true,
                    },
                },
                messages: {
                    company: {
                        required: "Please select Company",
                    },
                    location: {
                        required: "Please select Location",
                    },
                    specific_location: {
                        required: "Please select Specific Location"
                    },
                    incidenttype: {
                        required: "Please select Inspection Type",
                    },
                    incidentdate: {
                        required: "Please select Inspection Date",
                    },
                    incidenttime: {
                        required: "Please select Inspection Time",
                    },
                    assignto: {
                        required: "Please select Inspection Time",
                    },
                    incidentremarks: {
                        required: "Please enter the incident remarks",
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


        $('#incident_type').change(function() {
            var incident_type = $(this).val();

            if (incident_type == 'encryptId(1)') {

            }

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
