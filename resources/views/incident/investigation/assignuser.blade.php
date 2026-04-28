@extends('admin.layouts.layout')
@section('title', 'investigation Assign User')
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
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Incident
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('incident/investigation/list') }}">Incident Investigation</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Incident Investigation Assign User</li>
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
                                    <h5 class="card-title">Incident Investigation Assign User</h5>
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
                                action="{{ admin_url('incident/investigation/assignuser/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($investigation_id) }}">
                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART A : Assign User</h6>
                                            </div>

                                            <div class="content-block-body">

                                                <div class="row g-3 px-4 pt-4 content-block-row all">

                                                    <div class="col-md-4 form-input">
                                                        <label for="company" class="form-label require">Company</label>
                                                        <select name="company" id="company" class="form-control select2">
                                                            <option value="">Select Company</option>
                                                            @foreach ($companyDetails as $company)
                                                                <option value="{{ encryptId($company->id) }}">
                                                                    {{ $company->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="division" class="form-label require">Division</label>
                                                        <select name="division" id="division" class="form-control select2">
                                                            <option value="">Select Division</option>

                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="department"
                                                            class="form-label require">Department</label>
                                                        <select name="department" id="department"
                                                            class="form-control select2">
                                                            <option value="">Select Department</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="user" class="form-label require">User</label>
                                                        <select name="user" id="user" class="form-control select2">
                                                            <option value="">Select User</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>



                                        <div class="content-block">

                                            <div class="card-header card-header-inner mt-3 content-block-header">
                                                <h6 class="text-white">PART B : Assigned By </h6>
                                            </div>

                                            <div class="content-block-body">
                                                <div class="row g-3 px-4 pt-4 content-block-row">
                                                    <div class="col-md-4 form-input">
                                                        <label for="incidenttime" class="form-label require">Name</label>
                                                        <input type="text" name="" id=""
                                                            value="{{ Auth::user()->name }}" class="form-control" readonly>
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
                                                        <label for="incidenttime"
                                                            class="form-label require">Remarks</label>
                                                            <textarea name="remarks" id="remarks" rows="5" class="form-control"></textarea>
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

        $('#company').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#division').empty().append(
                            '<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#division').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });


                    }
                });
            }
            $('#division').empty().append('<option value="">Select Division</option>');
            $('#division').trigger('change.select2');

            $('#department').empty().append('<option value="">Select Department</option>');
            $('#department').trigger('change.select2');

            $('#user').empty().append('<option value="">Select User</option>');
            $('#user').trigger('change.select2');
        });

        $('#division').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {

                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#department').empty().append(
                            '<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#department').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });
                    }
                });
            }
            $('#department').empty().append('<option value="">Select Department</option>');
            $('#department').trigger('change.select2');

            $('#user').empty().append('<option value="">Select User</option>');
            $('#user').trigger('change.select2');


        });

        $('#department').change(function() {
            var department_id = $(this).val();
            if (department_id) {
                $.ajax({
                    url: "{{ admin_url('employee/get/job_owner') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: {
                        department: department_id,
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#user').empty();
                        $('#user').empty().append('<option value="">Select User</option>');
                        $.each(data, function(key, value) {
                            $('#user').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });
                        $('#user').trigger('change.select2');

                    }
                });
            }



        });
    </script>
@endpush
