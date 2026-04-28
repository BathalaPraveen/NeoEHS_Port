@extends('admin.layouts.layout')
@section('title', 'Inspection Add')
@section('pageurl', admin_url('inspection/inspection/list'))

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
                                HSSE Inspection
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('inspection/inspection/list') }}">Inspection</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Inspection Add</li>
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
                                    <h5 class="card-title">Inspection Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('inspection/inspection/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="inspection_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('inspection/inspection/create/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf

                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">PART A : INSPECTION DETAILS</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 ">
                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label require">Inspection Type</label>
                                                <select name="inspectiontype" id="inspectiontype"
                                                    class="form-control select2">
                                                    <option value="">Please Select Inspection Type</option>
                                                    @foreach ($inspectiontypeDetails as $inspectiontype)
                                                        <option value="{{ encryptId($inspectiontype->id) }}">
                                                            {{ $inspectiontype->inspectiontype_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 form-input">
                                            <label for="company" class="form-label require">Company</label>
                                            @foreach ($companyDetails as $company)
                                                <div class="col-md-3">
                                                    <div class="form-input">
                                                        <input class="form-check-input " type="radio" required
                                                            value="{{ encryptId($company->id) }}" name="company"
                                                            id="company_{{ encryptId($company->id) }}">
                                                        <label class="form-check-label"
                                                            for="company_{{ encryptId($company->id) }}">{{ $company->company_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row g-3 px-4 pt-4">
                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label require">Location</label>
                                                <select name="location" id="location" class="form-control select2">
                                                    <option value="">Select Location</option>

                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="specific_location" class="form-label require">Specific
                                                    Location</label>
                                                <select name="specific_location" id="specific_location"
                                                    class="form-control select2">
                                                    <option value="">Select Specific Location</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="inspectiondate" class="form-label require">Inspection
                                                    Date</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control datepicker"
                                                        id="inspectiondate" placeholder="Inspection Date"
                                                        name="inspectiondate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label require">Inspection
                                                    Time</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control clockpicker"
                                                        id="inspectiontime" placeholder="Inspection Time"
                                                        name="inspectiontime" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-clock"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input d-none">
                                                <label for="location" class="form-label require">Assinged To</label>
                                                <input type="hidden" name="assignto" value="{{ encryptId(Auth::id()) }}">
                                            </div>
                                        </div>



                                        <div class="card-header card-header-inner d-none">
                                            <h6 class="text-white">PART B: Inspection Created By</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 d-none">
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label require">Name</label>
                                                <input type="text" name="" id=""
                                                    value="{{ Auth::user()->name }}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label require">Designation</label>
                                                <input type="text" name="" id=""
                                                    value="{{ Auth::user()->user_designation_name }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label require">Date and
                                                    Time</label>
                                                <input type="text" name="" id=""
                                                    value="{{ todayDatetime() }}" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-12 form-input">
                                                <label for="inspectionremarks" class="form-label require">Inspection
                                                    Remarks</label>
                                                <textarea name="inspectionremarks" id="inspectionremarks" class="form-control" rows="5"></textarea>
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
                                            title="Next">Next</button>
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
            $('#inspection_add').validate({
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
                    inspectiontype: {
                        required: true,
                    },
                    inspectiondate: {
                        required: true,
                    },
                    inspectiontime: {
                        required: true,
                    },
                    assignto: {
                        required: true,
                    },
                    inspectionremarks: {
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
                    inspectiontype: {
                        required: "Please select Inspection Type",
                    },
                    inspectiondate: {
                        required: "Please select Inspection Date",
                    },
                    inspectiontime: {
                        required: "Please select Inspection Time",
                    },
                    assignto: {
                        required: "Please select Inspection Time",
                    },
                    inspectionremarks: {
                        required: "Please enter the inspection remarks",
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


        $('#inspectiontype').change(function() {
            var inspectiontype = $(this).val();
            if (inspectiontype != '') {

                $.ajax({
                    url: "{{ admin_url('inspection/inspection/getCheckList') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        inspectiontype: inspectiontype
                    },

                    success: function(data) {
                        $("#checklistTable").html(data);
                        $("#inspectionChecklist").show();
                        $(".select2").select2();
                    }
                });

            } else {
                $("#checklistTable").html("");
                $("#inspectionChecklist").hide();

            }
        });
    </script>
@endpush
