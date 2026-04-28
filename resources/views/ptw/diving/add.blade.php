@extends('admin.layouts.layout')
@section('title', 'Diving Certificate Add')
@section('pageurl', admin_url('ptw/diving/list'))

@push('style')
    <style>
        #diving_ptw_add {
            color: #000;
        }

        #diving_ptw_add .form-check-label {
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
                                <a href="{{ admin_url('ptw/diving/list') }}">Diving Certificate</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Diving Certificate Add</li>
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
                                    <h5 class="card-title">Diving Certificate Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/diving/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="diving_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/diving/add/submit') }}">
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
                                                    <td><label class="require">Work Description</label></td>
                                                    <td>:</td>
                                                    <td colspan="7" class="form-input">
                                                        <textarea name="workdescription" id="workdescription" class="form-control" required rows="3"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Location</td>
                                                    <td>:</td>
                                                    <td class="form-input">
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
                                                    </td>
                                                    <td><label class="require">Estimation Diving Deep</label></td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <input type="text" name="divingdeep" id="divingdeep" required
                                                            class="form-control">
                                                    </td>

                                                    <td>
                                                        <label class="require">Work Start Date</label>
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
                                                    <td><label class="require">Work End Date</label></td>
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


                                                    <td> <label class="require">Date</label></td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group date ">
                                                            <input type="text" class="form-control datepicker " required
                                                                id="date" name="date" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td> <label class="require">Time Start</label></td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group clockpicker" data-placement="bottom"
                                                            data-align="bottom" data-autoclose="true">
                                                            <input type="text" id="time" required
                                                                class="form-control " readonly placeholder=""
                                                                name="time" />
                                                            <span class="input-group-addon input-group-text">
                                                                <i class="bi bi-clock"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td> <label class="require">Time End</label></td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <div class="input-group clockpicker" data-placement="bottom"
                                                            data-align="bottom" data-autoclose="true">
                                                            <input type="text" id="estimationtime" required
                                                                class="form-control " readonly placeholder=""
                                                                name="estimationtime" />
                                                            <span class="input-group-addon input-group-text">
                                                                <i class="bi bi-clock"></i>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td><label class="require">Applied Date & Time</label></td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <input type="text" name="applieddatetime" id="applieddatetime"
                                                            required class="form-control" value="{{ todaydatetime() }}"
                                                            readonly>
                                                    </td>
                                                </tr>
                                                <tr>



                                                </tr>



                                            </tbody>
                                        </table>

                                    </div>

                                    <hr>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Equipment / Gear</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">

                                            @foreach ($equipmentgear as $equipment)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ encryptId($equipment->id) }}" name="equipment[]"
                                                            id="checkbox_{{ encryptId($equipment->id) }}">
                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($equipment->id) }}">{{ $equipment->category_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    Others
                                                </div>
                                            </div>
                                            <div class="col-md-11">
                                                <div class="m-2">
                                                    <textarea name="equipmentothers" id="equipmentothers" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Diving/Site Preparation</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">

                                            <table class="table table-bordered">
                                                <tbody>
                                                    @foreach ($divingsitepreparation as $sitepreparation)
                                                        <tr>
                                                            <td>
                                                                <label class="form-check-label"
                                                                    for="checkbox_{{ encryptId($sitepreparation->id) }}">{{ $sitepreparation->category_name }}</label>
                                                            </td>
                                                            <td style="width:5%"> <input class="form-check-input"
                                                                    type="checkbox"
                                                                    value="{{ encryptId($sitepreparation->id) }}"
                                                                    name="sitepreparation[]"
                                                                    id="checkbox_{{ encryptId($sitepreparation->id) }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                    </div>



                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <div class="d-lg-flex align-items-center gap-3">
                                            <div class="position-relative">
                                                <h6 class="text-white">Diver(s) Detail</h6>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-primary" type="button"
                                                    id="driverdetailsAdd">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="table-responsive">
                                            <table class="table" id="driverdetails">
                                                <thead>
                                                    <tr>
                                                        <td>Name</td>
                                                        <td>IC no /Pass No</td>
                                                        <td>Competency</td>
                                                        <td>Health Fitness</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="driverdetails">
                                                        <td class="form-input">
                                                            <input type="text" name="divers[1][name]"
                                                                data-error="Please enter Name" id="drivers_name_1"
                                                                class="form-control validate-input-required">
                                                        </td>
                                                        <td class="form-input">
                                                            <input type="text" name="divers[1][idnumber]"
                                                                data-error="Please enter IC no /Pass No"
                                                                id="drivers_idnumber_1"
                                                                class="form-control validate-input-required">
                                                        </td>
                                                        <td class="form-input">
                                                            <input type="text" name="divers[1][competency]"
                                                                data-error="Please enter Competency"
                                                                id="drivers_competency_1"
                                                                class="form-control validate-input-required">
                                                        </td>
                                                        <td class="form-input">
                                                            <input type="text" name="divers[1][healthfitness]"
                                                                data-error="Please enter Health Fitness"
                                                                id="drivers_healthfitness_1"
                                                                class="form-control validate-input-required">
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-trash driverdetailsRemove"
                                                                style="cursor: pointer"></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
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
                                                <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3"></textarea>
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
            $('#diving_ptw_add').validate({
                rules: {
                    location: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    time: {
                        required: true,
                    },
                    estimationtime: {
                        required: true,
                    },
                    divingdeep: {
                        required: true,
                    },
                    workdescription: {
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
                    date: {
                        required: "Please select Date",
                    },
                    time: {
                        required: "Please select Start Time",
                    },
                    estimationtime: {
                        required: "Please enter Estimateion time for Diving",
                    },
                    divingdeep: {
                        required: "Please enter Estimation Diving Deep",
                    },
                    workdescription: {
                        required: "Please enter Work Description",
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

            var newDate = getEndDate(selectedDate, {{ VALIDITY_DIVING }}, {{ ADD_DATE }},
                '{{ displayDateformat($general->date_of_completion) }}');
            $('#workenddate').val(newDate);


        });



        $(document).ready(function() {


            $('#driverdetailsAdd').on('click', function() {

                var rowCount = $("#driverdetails tbody tr").length;

                if (rowCount >= 10) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".driverdetails").first().clone();
                newRow.find("input[type='text']").val("");

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                newRow.find("input[type='text']").removeAttr("aria-describedby");

                // Increment the index in the name attributes
                newRow.find("input[type='text']").each(function() {
                    var newIndex = rowCount + 1; // Increment the index

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/); // Use a regular expression to extract the field name

                    var errormessage = 'Please enter the value';
                    if (matches) {
                        var fieldName = matches[1];
                        errormessage = 'Please enter the ' + fieldName;
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


                $("#driverdetails tbody").append(newRow);


            });




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


        $(document).on('click', '.driverdetailsRemove', function() {



            if ($("#driverdetails tbody tr").length > 1) {
                $(this).closest("tr").remove();

                // Reorder the name attributes of the remaining rows
                $("#driverdetails tbody tr").each(function(index) {
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
