@extends('admin.layouts.layout')
@section('title', 'Worksite Traffic Management Certificate Add')
@section('pageurl', admin_url('ptw/worktraffic/list'))

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
                                <a href="{{ admin_url('ptw/worktraffic/list') }}">Worksite Traffic Management Certificate</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Worksite Traffic Management Certificate
                                Add</li>
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
                                    <h5 class="card-title">Worksite Traffic Management Certificate Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/worktraffic/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="general_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/worktraffic/edit/submit') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ encryptId($traffic->id) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Location</label>
                                            <div class="col-sm-4 form-input">
                                                <select name="location" class="form-control select2" required
                                                    @if (isset($general->location)) disabled @endif id="location">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locationDetails as $location)
                                                        <option value="{{ encryptId($location->id) }}"
                                                            @if ($location->id == $general?->location) selected @endif>
                                                            {{ $location->location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Work Description :
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <textarea name="workdescription" id="workdescription" required class="form-control" rows="3">{{ $traffic->workdescription }}</textarea>
                                            </div>
                                            <label class="col-sm-2 col-form-label require">
                                                Reason(s) for closing the road(s):
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <textarea name="reasonclosing" id="reasonclosing" class="form-control" required rows="3">{{ $traffic->reasonclosing }}</textarea>
                                            </div>
                                        </div>


                                        <div class="row mb-2">
                                            {{-- <label class="col-sm-2 col-form-label require">
                                                Period or duration for closing the road(s) :
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <textarea name="periodorduratio" id="periodorduratio" required class="form-control" rows="3">{{ $traffic->periodorduratio }}</textarea>
                                            </div> --}}
                                            <label class="col-sm-2 col-form-label require">
                                                Work Start Date
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <div class="input-group  ">
                                                    <input type="text" class="form-control workstartdate "
                                                        value="{{ displayDateformat($traffic->workstartdate) }}" required id="workstartdate"
                                                        name="workstartdate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label require">
                                                Work End Date
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <div class="input-group  ">
                                                    <input type="text" class="form-control  " required
                                                        value="{{ displayDateformat($traffic->workenddate) }}" id="workenddate"
                                                        name="workenddate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">SKETCH or PLOT-PLAN THE TRAFFIC FLOW MANAGEMENT AT THE
                                            WORKSITE (Please attach attachment(s) if applicable)</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">
                                            <label class="col-sm-3 col-form-label require">
                                                Upload Plan</label>
                                            <div class="col-md-3 form-input">
                                                <div class="m-2">
                                                    <input type="file" name="uploadplan" class="form-control"
                                                        id="uploadplan">
                                                </div>
                                                <div class="px-2">
                                                    @foreach ($trafficplandocument as $document)
                                                        <div>
                                                            <a target="_blank"
                                                                href="{{ url($document['file_path']) }}">{{ $document['file_orgname'] }}</a>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>


                                        </div>


                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORKSITE TRAFFIC MANAGEMENT DETAILS</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="col-md-2 require">
                                            Lighting :
                                        </div>

                                        <div class="col-md-10 form-input">

                                            @foreach ($wtmlight as $light)
                                                <input class="form-check-input" type="checkbox" name="lighting[]"
                                                @if (in_array($light->id, json_decode($traffic->lighting))) checked @endif
                                                    value="{{ encryptId($light->id) }}"
                                                    id="light_{{ encryptId($light->id) }}" required>
                                                <label class="form-check-label"
                                                    for="light_{{ encryptId($light->id) }}">{{ $light->category_name }}</label>
                                            @endforeach

                                        </div>


                                        <div class="col-md-10 form-input">

                                            @foreach ($wtmotherdetails as $wtmother)
                                                <input class="form-check-input" type="checkbox" name="wtmother[]"
                                                @if (in_array($wtmother->id, json_decode($traffic->wtmother))) checked @endif
                                                    value="{{ encryptId($wtmother->id) }}"
                                                    id="wtmother_{{ encryptId($wtmother->id) }}" required>
                                                <label class="form-check-label"
                                                    for="wtmother_{{ encryptId($wtmother->id) }}">{{ $wtmother->category_name }}</label>
                                            @endforeach

                                        </div>

                                        <div class="col-md-12">
                                            <div>Others</div>
                                            <textarea name="wtmothers" id="wtmothers" class="form-control" rows="3">{{ $traffic->wtmothers }}</textarea>
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
                                    </div>
                                    <div class="row g-3 p-4">
                                        <p>We hereby have checked the site / studied the layout drawings and certify that
                                            the </p>
                                        <p>worksite traffic management proposed under Permit to Work number
                                            <input type="text" name="workpermitnymber" value="{{ $traffic->workpermitnymber }}" id="workpermitnymber">
                                            dated <input type="text" name="workpermitdate" readonly value="{{ displayDateformat($traffic->workpermitdate) }}"
                                                id="workpermitdate" class="datepicker"> can be carried
                                            out:
                                        </p>

                                        <hr>

                                        <p>a) Without risk of damage to any underground services</p>
                                        <p>b) Provided that the following additional controls / alternative route are taken
                                            to prevent damages to the equipment/services specified below:</p>
                                        <p>c) With the compliance to traffic security rules & regulation</p>
                                        <p>d) Provide that the following additional controls / alternative route are taken
                                            to prevent damages to the equipment/services specified below:</p>
                                        <textarea name="otherserice" id="otherserice" class="form-control" rows="4">{{ $traffic->otherserice }}</textarea>
                                    </div>


                                    <div class="row g-3 p-4">
                                        <div class="col-md-12">
                                            <div class="m-2 form-input">
                                                <input class="form-check-input" type="checkbox" value="1" checked
                                                    name="accept_terms" id="accept_terms" required>
                                                <label class="form-check-label" for="accept_terms">I <b>fully
                                                        understand </b>& will <b>ensure compliance</b> with all the
                                                    requirements of this permit.</label>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-3">
                                            <label class="col-sm-2 col-form-label">
                                                Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="applieduser"
                                                    value="{{ getusername($traffic->created_by) }}" readonly>
                                            </div>
                                            <label class="col-sm-2 col-form-label form-input">
                                                Date & Time</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="dataandtime"
                                                    name="dataandtime" placeholder="" value="{{ todaydatetime() }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Remarks</label>
                                            <div class="col-sm-10">
                                                <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3">{{ $traffic->applicant_remarks }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        @php
                                            $text = 'Update';

                                        @endphp
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                            data-bs-toggle="tooltip"
                                            title="{{ $text }}">{{ $text }}</button>
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

                    Location: {
                        required: true,
                    },
                    workdescription: {
                        required: true,
                    },
                    reasonclosing: {
                        required: true,
                    },
                    periodorduratio: {
                        required: true,
                    },
                    datetime: {
                        required: true,
                    },
                    uploadplan: {
                        // required: true,
                    },
                    "lighting[]": {
                        required: true,
                    },
                    "wtmother[]": {
                        required: true,
                    },
                    accept_terms: {
                        required: true,
                    },
                    applicant_remarks: {
                        required: true,
                    },

                },
                messages: {
                    Location: {
                        required: "Please select Location",
                    },
                    workdescription: {
                        required: "Please enter Work Description",
                    },
                    reasonclosing: {
                        required: "Please enter Reason(s) for closing the road(s)",
                    },
                    periodorduratio: {
                        required: "Please enter Period or duration for closing the road(s)",
                    },
                    datetime: {
                        required: "Please enter Date & Time",
                    },
                    uploadplan: {
                        required: "Please upload Plan",
                    },
                    "lighting[]": {
                        required: "Please select Lighting",
                    },
                    "wtmother[]": {
                        required: "Please select",
                    },
                    accept_terms: {
                        required: "Please Accept",
                    },
                    applicant_remarks: {
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
                    $(element).closest(".form-input").addClass("selecterror");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                },
            });

        });


        $(".workstartdate").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'startDate': '{{ displayDateformat($general->date_of_commencement) }}',
            'endDate': '{{ displayDateformat($general->date_of_completion) }}',
        });

        $(document).on('change', '#workstartdate', function() {


            // Get selected date from datepicker
            var selectedDate = $('#workstartdate').val();

            if (selectedDate == '')
                return true;

            var newDate = getEndDate(selectedDate, {{ VALIDITY_TRAFFIC }}, {{ ADD_DATE }},
                '{{ displayDateformat($general->date_of_completion) }}');
            $('#workenddate').val(newDate);


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

            $('.radiocheck').on('change', function() {

                if ($(this).is(':checked')) {
                    $('.radiocheck[name="' + $(this).attr('name') + '"]').not(this).prop('checked',
                        false);
                    $('#btnsubmit').text('Next');
                } else {
                    $('#btnsubmit').text('Submit');

                }
            });

            $('.companycheck').on('change', function() {

                if ($(this).is(':checked')) {
                    $('.companycheck[name="' + $(this).attr('name') + '"]').not(this).prop('checked',
                        false);
                }
            });




        });
    </script>
@endpush
