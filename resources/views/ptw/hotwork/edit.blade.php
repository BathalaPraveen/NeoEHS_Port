@extends('admin.layouts.layout')
@section('title', 'Hotwork PTW Edit')
@section('pageurl', admin_url('ptw/hotwork/list'))

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
                                <a href="{{ admin_url('ptw/hotwork/list') }}">Hotwork PTW</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Hotwork PTW Edit</li>
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
                                    <h5 class="card-title">Hotwork PTW Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/hotwork/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="general_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/hotwork/edit/submit') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ encryptId($hotwork->id) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-1">

                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td style="width:20%;">
                                                        <label class="require">
                                                            Location</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <select name="location" class="form-control select2" required
                                                                @if (isset($general->location)) disabled @endif
                                                                id="location">
                                                                <option value="">Select Loaction</option>
                                                                @foreach ($locationDetails as $location)
                                                                    <option value="{{ encryptId($location->id) }}"
                                                                        @if ($location->id == $general?->location) selected @endif>
                                                                        {{ $location->location_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <label class="require">
                                                            Hotwork type (if aplicable refer to Hotwork Certificate)</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td style="width:25%">
                                                        <div class="form-input">
                                                            <div class="">
                                                                <input class="form-check-input " type="radio" required
                                                                    @if ($hotwork->hotworktype == 'YES') checked @endif
                                                                    value="YES" name="hotworktype" id="hotwork_type_yes">
                                                                <label class="form-check-label"
                                                                    for="hotwork_type_yes">YES</label>
                                                            </div>
                                                            <div class="">
                                                                <input class="form-check-input " type="radio" required
                                                                    @if ($hotwork->hotworktype != 'YES') checked @endif
                                                                    value="NO" name="hotworktype" id="hotwork_type_no">
                                                                <label class="form-check-label"
                                                                    for="hotwork_type_no">NO</label>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="require">
                                                            Location (if Hotwork is conducted on vessel, please write vessel name/ location of vessel):</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td colspan="4">
                                                        <div class="form-input">
                                                            <textarea name="locationmarine" required id="locationmarine" rows="3" class="form-control">{{ $hotwork->locationmarine }}</textarea>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="  require">
                                                            Work start Date
                                                        </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group  ">
                                                            <input type="text" class="form-control workstartdate "
                                                                value="{{ displayDateformat($hotwork->workstartdate) }}"
                                                                required id="workstartdate" name="workstartdate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <label class="  require">
                                                            Work End Date
                                                        </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group  ">
                                                            <input type="text" class="form-control  " required
                                                                value="{{ displayDateformat($hotwork->workenddate) }}"
                                                                id="workenddate" name="workenddate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="require">
                                                            Work Description</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td colspan="4">
                                                        <div class="form-input">
                                                            <textarea name="workdescription" id="workdescription" rows="3" required class="form-control">{{ $hotwork->workdescription }}</textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mb-2">
                                            <div>
                                                <label class="require">Type of Hot Work operation</label>
                                            </div>
                                            <div class="row form-input">
                                                @php
                                                    $hotworkoperationArray = json_decode($hotwork->hotworkoperation);
                                                @endphp
                                                @foreach ($hotworkoperation as $hotworkoperation)
                                                    <div class="col-md-3 ">
                                                        <div class="">
                                                            <input class="form-check-input " type="checkbox" required
                                                                @if (in_array($hotworkoperation->id, $hotworkoperationArray)) checked @endif
                                                                value="{{ encryptId($hotworkoperation->id) }}"
                                                                name="hotworkoperation[]"
                                                                id="hotwork_type_{{ encryptId($hotworkoperation->id) }}">
                                                            <label class="form-check-label"
                                                                for="hotwork_type_{{ encryptId($hotworkoperation->id) }}">{{ $hotworkoperation->category_name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">Precautions</h6>
                                        </div>
                                        <div class="row g-3 px-2 pt-1">
                                            <div class="row mb-2">
                                                <table class="table">
                                                    <tbody>


                                                        @php
                                                            $i = 1;
                                                            $precautionsArray = json_decode($hotwork->precautions);

                                                        @endphp

                                                        <tr>
                                                            @foreach ($precautionslist as $precautions)
                                                                @php
                                                                    $id = $precautions->id;
                                                                @endphp
                                                                <td style="width:40%">
                                                                    <p>{{ $precautions->category_name }}</p>
                                                                </td>
                                                                <td style="width:10%" class="form-input">
                                                                    <input class="form-check-input validate-radio-required"
                                                                        @if ($precautionsArray->$id == 'YES') checked @endif
                                                                        type="radio" value="YES"
                                                                        name="precautions[{{ $precautions->id }}]"
                                                                        id="hotwork_type_yes_{{ encryptId($precautions->id) }}">
                                                                    <label class="form-check-label"
                                                                        for="hotwork_type_yes_{{ encryptId($precautions->id) }}">YES</label>
                                                                    <input class="form-check-input validate-radio-required"
                                                                        @if ($precautionsArray->$id != 'YES') checked @endif
                                                                        type="radio" value="NA"
                                                                        name="precautions[{{ $precautions->id }}]"
                                                                        id="hotwork_type_na_{{ encryptId($precautions->id) }}">
                                                                    <label class="form-check-label"
                                                                        for="hotwork_type_na_{{ encryptId($precautions->id) }}">N/A</label>
                                                                </td>

                                                                @if ($i % 2 == 0)
                                                        </tr>
                                                        <tr>
                                                            @endif

                                                            @php
                                                                $i++;
                                                            @endphp
                                                            @endforeach
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="row g-3 px-2 pt-1">
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
                                                        value="{{ getusername($hotwork->created_by) }}" readonly>
                                                </div>
                                                <label class=" col-sm-2 form-input">
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
                                                <div class="col-sm-10 form-input">
                                                    <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3">{{ $hotwork->applicant_remarks }}</textarea>
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
                    location: {

                    },
                    datetime: {
                        required: true,
                    },
                    hotworktype: {
                        required: true,
                    },
                    locationmarine: {
                        required: true,
                    },
                    workdescription: {
                        required: true,
                    },
                    "hotworkoperation[]": {
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
                    location: {
                        required: "Please select Location",
                    },
                    datetime: {
                        required: "Please select Date & Time",
                    },
                    hotworktype: {
                        required: "Please select Hotwork type",
                    },
                    locationmarine: {
                        required: "Please enter Location (Marine) - Vessel's Name / Location of Vessel",
                    },
                    workdescription: {
                        required: "Please enter Work Description",
                    },
                    "hotworkoperation[]": {
                        required: "Please select Type of Hot Work operation",
                    },
                    accept_terms: {
                        required: "Please Accept ",
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

            var newDate = getEndDate(selectedDate, {{ VALIDITY_HOTWORK }}, {{ ADD_DATE }},
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
