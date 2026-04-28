@extends('admin.layouts.layout')
@section('title', 'Isolation Certificate Add')
@section('pageurl', admin_url('ptw/isolation/list'))

@push('style')
    <style>
        #isolation_ptw_add {
            color: #000;
        }

        #isolation_ptw_add .form-check-label {
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
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('ptw/isolation/list') }}">Isolation Certificate</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Isolation Certificate Add</li>
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
                                    <h5 class="card-title">Isolation Certificate Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/isolation/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="isolation_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/isolation/add/submit') }}">
                                @csrf

                                <input type="hidden" name="ptwid" value="{{ encryptId($ptwid) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label for="" class=" require">Location</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td style="width:35%;">
                                                        <div class=" form-input">
                                                            <select name="location" class="form-control select2" required
                                                                @if (isset($general->location)) disabled @endif
                                                                id="location">
                                                                <option value="">Select Location</option>
                                                                @foreach ($locationDetails as $location)
                                                                    <option value="{{ encryptId($location->id) }}"
                                                                        @if ($location->id == $general?->location) selected @endif>
                                                                        {{ $location->location_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    {{-- <td style="width:15%">
                                                        <label class=" require">
                                                            Duration of Isolation</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td style="width:35%;" class="form-input">
                                                        <input type="text" name="durationofisolation" required
                                                            id="durationofisolation" class="form-control">
                                                    </td> --}}

                                                    <td>
                                                        <label class="require">
                                                            What do Isolate</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <textarea name="whatdoisolate" id="whatdoisolate" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="require">
                                                            Source of Energy / Flow to Isolate </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <textarea name="sourceofenergy" id="sourceofenergy" class="form-control" required rows="3"></textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="  require">
                                                            Work start Date
                                                        </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group  ">
                                                            <input type="text" class="form-control workstartdate "
                                                                required id="workstartdate" name="workstartdate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="  require">
                                                            Work End Date
                                                        </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group  ">
                                                            <input type="text" class="form-control  " required
                                                                id="workenddate" name="workenddate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td colspan="3"></td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label class="require">
                                                            Work Description</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td colspan="4">
                                                        <div class="form-input">
                                                            <textarea name="workdescription" id="workdescription" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">PPE (Compulsary)</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">

                                            @foreach ($ppelist as $ppe)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ encryptId($ppe->id) }}" name="ppelist[]"
                                                            id="checkbox_{{ encryptId($ppe->id) }}">
                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($ppe->id) }}">{{ $ppe->category_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">

                                        <div class="d-lg-flex align-items-center gap-3">

                                            <div class="position-relative">
                                                <h6 class="text-white">Isolation Detail</h6>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-primary" type="button"
                                                    id="isolationAdd">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="table-responsive">
                                            <table class="table" id="isolation">
                                                <thead>
                                                    <tr>
                                                        <td>Isolation Point</td>
                                                        <td>Lock & Tag Out No.</td>
                                                        <td>Time</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="isolationmain">
                                                        <td class="form-input">
                                                            <input type="text" name="isolation[1][point]"
                                                                class="form-control validate-input-required"
                                                                id="isolation_point_1">
                                                        </td>
                                                        <td class="form-input">
                                                            <input type="text" name="isolation[1][lock]"
                                                                class="form-control validate-input-required"
                                                                id="isolation_lock_1">
                                                        </td>
                                                        <td class="form-input">
                                                            <div class="input-group clockpicker" data-placement="bottom"
                                                                data-align="bottom" data-autoclose="true">
                                                                <input type="text" id="isolation_time_1" required
                                                                    class="form-control validate-input-required" readonly
                                                                    placeholder="" name="isolation[1][time]" />
                                                                <span class="input-group-addon input-group-text">
                                                                    <i class="bi bi-clock"></i>
                                                                </span>

                                                        </td>
                                                        <td>
                                                            <i class="fa fa-trash isolationRemove"
                                                                style="cursor: pointer"></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Lock Out / Tag Out Applied by
                                            </label>
                                            <div class="col-md-4">
                                                <div class="m-2 form-input">
                                                    <input type="text" name="loockoutapplied" id="loockoutapplied"
                                                        required class="form-control">
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label require">
                                                IC No/Body Pass No
                                            </label>
                                            <div class="col-md-4">
                                                <div class="m-2 form-input">
                                                    <input type="text" name="icno" id="icno" required
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">

                                            <div class="col-md-12">
                                                <div class="m-2">
                                                    I <u><b>{{ Auth::user()->name }}</b></u> Confirmed that the energy /
                                                    flow has been
                                                    fully isolated and secured.

                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Isolation Daily Check</h6>
                                    </div>
                                    <div class="row g-3 p-4">
                                        @php
                                            $days = DAYS;
                                        @endphp

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td></td>
                                                        @foreach ($days as $day)
                                                            <td>{{ $day }}</td>
                                                        @endforeach
                                                        <td>Status</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (generateNumberArray(7) as $intervel)
                                                        <tr>
                                                            <td> Tag no {{ $intervel }}</td>
                                                            @foreach ($days as $day)
                                                                <td>
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="isolatiodailycheck[{{ $intervel }}][{{ $day }}]">
                                                                </td>
                                                            @endforeach
                                                            <td><input type="text"
                                                                    name="isolatiodailycheck[{{ $intervel }}][status]"
                                                                    class="form-control"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label ">
                                                Remarks :
                                            </label>
                                            <div class="col-md-10">
                                                <div class="m-2">
                                                    <textarea name="isolationremarks" id="isolationremarks" class="form-control" rows="5"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                    </div>


                                    <div class="row g-3 p-4">
                                        <div class="col-md-12">

                                            <div class="m-2 form-input">

                                                <input class="form-check-input" type="checkbox" value="1"
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
                                                    value="{{ Auth::user()->name }}" readonly>
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
                                            <div class="col-sm-10 form-input">
                                                <textarea name="applicant_remarks" required id="applicant_remarks" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        @php
                                            if ($nextpermit != '' && $nextpermit != null) {
                                                $text = 'Next';
                                            } else {
                                                $text = 'Submit';
                                            }

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
            $('#isolation_ptw_add').validate({
                rules: {

                    location: {
                        required: true,
                    },
                    durationofisolation: {
                        required: true,
                    },
                    dateandtime: {
                        required: true,
                    },
                    workdescription: {
                        required: true,
                    },
                    whatdoisolate: {
                        required: true,
                    },
                    sourceofenergy: {
                        required: true,
                    },
                    loockoutapplied: {
                        required: true,
                    },
                    icno: {
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
                        required: "Please select the Location",
                    },
                    durationofisolation: {
                        required: "Please enter Duration of Isolation",
                    },
                    dateandtime: {
                        required: "Please enter Date & Time",
                    },
                    workdescription: {
                        required: "Please enter Work Description",
                    },
                    whatdoisolate: {
                        required: "Please enter What do Isolate",
                    },
                    sourceofenergy: {
                        required: "Please enter Source of Energy",
                    },
                    loockoutapplied: {
                        required: "Please enter Lock Out / Tag Out Applied by",
                    },
                    icno: {
                        required: "Please enter IC No/Body Pass No",
                    },
                    accept_terms: {
                        required: "Please Accept",
                    },
                    applicant_remarks: {
                        required: "Please enter the Remarks",
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




        $(document).on('change', '#workstartdate', function() {


            // Get selected date from datepicker
            var selectedDate = $('#workstartdate').val();

            if (selectedDate == '')
                return true;

            var newDate = getEndDate(selectedDate, {{ VALIDITY_ISOLATION }}, {{ ADD_DATE }},
                '{{ displayDateformat($general->date_of_completion) }}');
            $('#workenddate').val(newDate);


        });


        $(document).ready(function() {

            $(".workstartdate").datepicker({
                'format': "dd-mm-yyyy",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
                'startDate': '{{ displayDateformat($general->date_of_commencement) }}',
                'endDate': '{{ displayDateformat($general->date_of_completion) }}',
            });


            $('#isolationAdd').on('click', function() {

                var rowCount = $("#isolation tbody tr").length;

                if (rowCount >= 10) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".isolationmain").first().clone();
                newRow.find("input[type='text']").val("");

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find("input[type='text']").each(function() {
                    var newIndex = rowCount + 1; // Increment the index

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/); // Use a regular expression to extract the field name

                    var errormessage = 'Please enter value';
                    if (matches) {
                        var fieldName = matches[1];
                        errormessage = 'Please enter ' + fieldName;
                    }

                    var newName = oldName.replace(/\d+/, newIndex); // Replace the index
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex); // Replace the index
                    $(this).attr("id", newName);

                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: errormessage
                        }
                    });




                });

                $("#isolation tbody").append(newRow);

                timepickercall();
            });

        });

        $(document).on('click', '.isolationRemove', function() {

            if ($("#isolation tbody tr").length > 1) {
                $(this).closest("tr").remove();

                $("#isolation tbody tr").each(function(index) {
                    $(this).find("input[type='text']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (index + 1) +
                            ']'); // Update the index
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (index + 1)); // Update the index
                        $(this).attr("id", newId);
                    });
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record requierd',
                })
                return true;
            }


        });
    </script>
@endpush
