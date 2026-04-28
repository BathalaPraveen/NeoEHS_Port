@extends('admin.layouts.layout')
@section('title', 'SURFACE PENETRATION CERTIFICATE Add')
@section('pageurl', admin_url('ptw/surfacepenetration/list'))

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
                                <a href="{{ admin_url('ptw/surfacepenetration/list') }}">SURFACE PENETRATION CERTIFICATE</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">SURFACE PENETRATION CERTIFICATE Add</li>
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
                                    <h5 class="card-title">SURFACE PENETRATION CERTIFICATE Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/surfacepenetration/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="general_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/surfacepenetration/add/submit') }}">
                                @csrf
                                <input type="hidden" name="ptwid" value="{{ encryptId($ptwid) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-1">

                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="  require">
                                                            Location</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
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
                                                    <td> <label class="require">
                                                            Excavation hazardous area</label></td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <div>
                                                                <input class="form-check-input" type="radio"
                                                                    value="Hazardous" name="hazardousarea"
                                                                    id="checkbox_Hazardous">
                                                                <label class="form-check-label"
                                                                    for="checkbox_Hazardous">Hazardous</label>
                                                            </div>
                                                            <div>
                                                                <input class="form-check-input" type="radio"
                                                                    value="Non-Hazardous" name="hazardousarea"
                                                                    id="checkbox_Non_Hazardous">
                                                                <label class="form-check-label"
                                                                    for="checkbox_Non_Hazardous">Non-Hazardous</label>
                                                            </div>


                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="">
                                                            Trial excavation carried out</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <input class="form-check-input" type="checkbox" value="YES"
                                                                name="trailexcavation" id="trailexcavation">
                                                            <label class="form-check-label"
                                                                for="trailexcavation">Hazardous</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="require">
                                                            Max excavation depth / length</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">

                                                            <textarea name="maxexcavationdepth" id="maxexcavationdepth" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="require">
                                                            Max excavation deep</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <textarea name="maxexcavationdeep" id="maxexcavationdeep" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="">Result from Trial </label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="form-input">
                                                            <textarea name="resulttrailfrom" id="resulttrailfrom" class="form-control" rows="3"></textarea>
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
                                                    <td  class="form-input">
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
                                                        <label class="require">Work Description</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td colspan="7">
                                                        <div class="form-input">
                                                            <textarea name="workdescription" id="workdescription" class="form-control" rows="3"></textarea>
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
                                    <div class="row g-3 px-2 pt-1">

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

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label ">
                                                Others
                                            </label>
                                            <div class="col-md-10">
                                                <div class="m-2">
                                                    <textarea name="ppeothers" id="ppeothers" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">EQUIPMENT</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-1">
                                        <div class="row mb-2">
                                            @foreach ($equipments as $equipment)
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
                                            <label class="col-sm-2 col-form-label ">
                                                Others
                                            </label>
                                            <div class="col-md-10">
                                                <div class="m-2">
                                                    <textarea name="equipmentothers" id="equipmentothers" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ADDITIONAL REQUIREMENTS</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-1">
                                        <div class="row mb-2">
                                            @foreach ($aditionalrequierments as $requierments)
                                                <div class="col-md-3">

                                                    <div class="m-2">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ encryptId($requierments->id) }}"
                                                            name="addrequierments[]"
                                                            id="checkbox_{{ encryptId($requierments->id) }}">
                                                        <label class="form-check-label"
                                                            for="checkbox_{{ encryptId($requierments->id) }}">{{ $requierments->category_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label ">
                                                Others
                                            </label>
                                            <div class="col-md-10">
                                                <div class="m-2">
                                                    <textarea name="requiermentsothers" id="requiermentsothers" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>



                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
                                    </div>

                                    <div class="row g-3 px-2 pt-1">
                                        <div class="col-md-12">
                                            <p>We hereby have checked the site / studied the
                                                layout drawings and certify that the surface penetration proposed under
                                                Permit to Work number
                                                <input type="text" name="accept_worknumber" id=""
                                                    class=""> dated <input class="datepicker" readonly type="text" name="accept_work_date"
                                                    class="">
                                                can be carried out:
                                            </p>
                                            <p>a) * Without risk of damage to any underground services</p>
                                            <p>b) * Provided that the following additional controls are taken to prevent
                                                damages to the equipment/services specified below:</p>

                                            <textarea name="accept_work_remarks" rows="3" class="form-control"></textarea>
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
            $('#general_ptw_add').validate({
                rules: {

                    location: {
                        required: true,
                    },
                    hazardousarea: {
                        required: true,
                    },
                    maxexcavationdepth: {
                        required: true,
                    },
                    maxexcavationdeep: {
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
                        required: "Please select the Location",
                    },
                    hazardousarea: {
                        required: "Please select Excavation hazardous area",
                    },
                    maxexcavationdepth: {
                        required: "Please enter Max excavation depth / length",
                    },
                    maxexcavationdeep: {
                        required: "Please enter Max excavation deep",
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

            var newDate = getEndDate(selectedDate, {{ VALIDITY_SURFACE }}, {{ ADD_DATE }},'{{ displayDateformat($general->date_of_completion) }}');
            $('#workenddate').val(newDate);


        });



        $(document).on('click', '.isolationRemove', function() {



            if ($("#isolation tbody tr").length > 1) {
                $(this).closest("tr").remove();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record requierd',
                })
                return true;
            }


        });



        $(document).ready(function() {


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
                $("#isolation tbody").append(newRow);


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
    </script>
@endpush
