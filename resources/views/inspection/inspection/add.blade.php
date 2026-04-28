@extends('admin.layouts.layout')
@section('title', 'Inspection Add')
@section('pageurl', admin_url('inspection/inspection/list'))

@section('content')

   <div class="container mb-5">
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
                                action="{{ admin_url('inspection/inspection/add/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf

                                        <input type="hidden" name="id"
                                            value="{{ encryptId($inspectionDetails->id) }}">

                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">PART A : INSPECTION DETAILS</h6>
                                        </div>

                                        @php
                                            $user = getuser($inspectionDetails->created_by);
                                        @endphp
                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label font-weight-bold">Location</label>
                                                <div>
                                                    {{ $inspectionDetails->location_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="specific_location" class="form-label font-weight-bold">Specific
                                                    Location</label>
                                                <div>
                                                    {{ $inspectionDetails->specific_loc_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label font-weight-bold">Inspection
                                                    Type</label>
                                                <div>
                                                    {{ $inspectionDetails->inspectiontype_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="inspectiondate" class="form-label font-weight-bold">Inspection
                                                    Date</label>
                                                <div>
                                                    {{ displayDateformat($inspectionDetails->inspection_date) }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label font-weight-bold">Inspection
                                                    Time</label>
                                                <div>
                                                    {{ $inspectionDetails->inspection_time }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label font-weight-bold">Assinged
                                                    To</label>
                                                <div>
                                                    {{ getusername($inspectionDetails->assign_to) }}
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART B: Inspection Type</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label require">Inspection Type</label>
                                                <select name="inspectiontype_default" id="inspectiontype" disabled
                                                    class="form-control select2">
                                                    <option value="">Please Select Inspection Type</option>
                                                    @foreach ($inspectiontypeDetails as $inspectiontype)
                                                        <option @if ($inspectiontype->id == $inspectionDetails->inspection_type) selected @endif
                                                            value="{{ encryptId($inspectiontype->id) }}">
                                                            {{ $inspectiontype->inspectiontype_name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" value="{{ encryptId($inspectionDetails->inspection_type) }}" name="inspectiontype">
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART C: INSPECTION CHECKLIST</h6>
                                        </div>

                                        <div id="inspectionChecklist" style="display: none">

                                            @if ($inspection_type->mark_legend != '' && $inspection_type->mark_legend != null)
                                                <div class="row g-3 px-4 pt-4">
                                                    <div class="col-md-12" style="text-align: center;">
                                                        @php
                                                            $legentarray = string_to_array(
                                                                $inspection_type->mark_legend,
                                                                ',',
                                                            );
                                                        @endphp
                                                        @foreach ($legentarray as $legent)
                                                            <button type="button"
                                                                class="btn btn-secondary mr-2">{{ $legent }}</button>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            @endif

                                            <div class="row g-3 px-4 pt-4">
                                                <div class="" id="checklistTable">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART D: INSPECTED BY </h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

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

                                            @if ($inspectionDetails->inspection_type == INSPECTION_TYPE_FIRST_AID)
                                                <div class="col-md-12 form-input">
                                                    <label for="overallfeedback" class="form-label require">Overall First
                                                        Aid
                                                        Box Condition</label>
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-input">
                                                                <input class="form-check-input " type="radio" required
                                                                    value="Satisfactory" name="overallfeedback"
                                                                    id="Satisfactory">
                                                                <label class="form-check-label"
                                                                    for="Satisfactory">Satisfactory</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-input">
                                                                <input class="form-check-input " type="radio" required
                                                                    value="Require Replacement" name="overallfeedback"
                                                                    id="Require_Replacement">
                                                                <label class="form-check-label"
                                                                    for="Require_Replacement">Require Replacement</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-md-12 form-input">
                                                <label for="inspectionremarks" class="form-label ">Upload
                                                    Documents</label>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <input multiple class="form-control" type="file"
                                                            name="supporting_documents[]" id="supporting_documents_1">
                                                    </div>

                                                </div>
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
                                            title="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
        });


        $(document).on('change', '.othersshow', function() {
            var val = $(this).val();

            $id = $(this).data('id');

            if (val == 'Other') {
                $("#" + $id).show();
            } else {
                $("#" + $id).hide();
                $("#" + $id).val('');
            }
        });


        $(function() {

            $.validator.addMethod("extension", function(value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpg|jpeg|gif|pdf|xlsx|doc|docx|ppt";
                return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
            });

            $('#inspection_add').validate({
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
                    inspectiontype: {
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
                    overallfeedback: {
                        required: true,
                    },
                    inspectionremarks: {
                        required: true,
                    },
                    division: {
                        required: true,
                    },
                    'supporting_documents[]': {
                        extension: "png|jpg|jpeg|gif|pdf|xlsx|doc|docx|ppt",
                        maxfiles: 3
                    }
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
                    inspectiontype: {
                        required: "Please select Inspection Type",
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
                    overallfeedback: {
                        required: 'Please select Overall First Aid Box Condition',
                    },
                    inspectionremarks: {
                        required: 'Please enter Inspection Remarks',
                    },
                    division: {
                        required: 'Please enter division',
                    },
                    'supporting_documents[]': {
                        extension: "Please select valid files",
                        maxfiles: "You can upload maximum 3 files"
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


        $(document).on('change', '#jetty_location', function() {

            var image = $(this).val();
            console.log(image);
            if (image) {

                var selectedOption = $(this).find("option:selected");
                var imgSrc = selectedOption.data("img");

                var imaglink = '{{ admin_url() }}' + imgSrc;


                $("#jetty_location_image").attr("src", imaglink);

                $("#jetty_location_image_div").show();

            } else {

                $("#jetty_location_image_div").hide();
            }
        });


        $(document).on('change', '#building_type', function() {

            var value = $(this).val();

            if (value == 'Others') {

                $('#building_type_other_div').show();

            } else {
                $('#equipment_type_other').val('');
                $('#building_type_other_div').hide();
            }

        });

        $(document).on('change', '#equipment_type', function() {

            var value = $(this).val();

            if (value == 'Others') {

                $('#equipment_type_other_div').show();

            } else {
                $('#equipment_type_other').val('');
                $('#equipment_type_other_div').hide();
            }
        });

        function changeInspection() {

            var inspectiontype = $('#inspectiontype').val();
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
        };

        changeInspection();


        $(document).on('change', '.calculatemark', function() {

            var selectedOption = $(this).val();
            var optionCounts = {
                '1': 0,
                '2': 0,
                '3': 0,
                'NA': 0
            };

            $('.calculatemark:checked').each(function() {
                var option = $(this).val();
                optionCounts[option]++;
            });

            $('#answered-count').text($('.calculatemark:checked').length);
            $('.option-count').each(function() {
                var option = $(this).attr('id').split('_')[1];
                var count = optionCounts[option] * option;
                $(this).text(count);
            });

            var overallCount = optionCounts['1'] + optionCounts['2'] + optionCounts['3'];
            var totalscore = optionCounts['1'] * 1 + optionCounts['2'] * 2 + optionCounts['3'] * 3;
            var overallscore = (totalscore / (overallCount * 3)) * 100;

            if (isNaN(overallscore)) {
                overallscore = 0;
            } else {
                // Math.round(overallscore);
                if (typeof overallscore === 'number' && !Number.isNaN(overallscore) && overallscore % 1 !== 0) {
                    overallscore = overallscore.toFixed(2);
                }
            }


            $('#total_issue_identified').text(overallCount);
            $('#total_score').text(totalscore);
            $('#overall_total_score').text(overallscore);

            $('.finalresult').each(function() {
                $(this).html("&Cross;");
            });

            switch (true) {
                case (overallscore >= 0 && overallscore <= 40):
                    $("#overall_0_40").html("&check;");
                    var range = 1;
                    break;
                case (overallscore > 40 && overallscore <= 80):
                    $("#overall_41_80").html("&check;");
                    var range = 2;
                    break;
                case (overallscore > 80 && overallscore <= 100):
                    $("#overall_81_100").html("&check;");
                    var range = 3;
                    break;
                default:

            }

            $('#total_issue').val(overallCount);
            $('#issue_value_1').val(optionCounts['1']);
            $('#issue_value_2').val(optionCounts['2']);
            $('#issue_value_3').val(optionCounts['3']);
            $('#total_scores').val(totalscore);
            $('#overallscore').val(overallscore);
            $('#scorerange').val(range);

        });


        $(document).on('click', '.deleteImageblock', function() {

            $(this).closest('.addMoreBlock').remove();
            return true;

        });

        $(document).on('click', '.optionchange', function() {

            var dataId = $(this).data('id');
            var datavalue = $(this).val();

            if (datavalue == '1' || datavalue == 'YES') {
                $("#imageupload_" + dataId).show();
            } else {
                $("#imageupload_" + dataId).hide();
            }

        });



        $(document).on('click', '.addMoreButton', function() {

            var rowId = $(this).data('id');
            var count = $('#imageupload_' + rowId + ' .addMoreBlock').length;

            if (count >= 3) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Maximum 3 images only',
                })
                return false;
            }


            var baseUrl = "{{ admin_url() }}"

            var html =
                '<div class="col-md-3 from-input addMoreBlock" style=""><div class="form-group"><div class="fileinput fileinput-new apprFileinput" style="" data-provides="fileinput"><div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" ></div><p class="mini-txt">(png, jpeg, jpg ) <span class="deleteImageblock"> <i class="fa fa-trash" style="cursor:pointer" title="Delete"  ></i> </span></span> </p><div class="file-pop"><span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' +
                baseUrl +
                '/public/assets/images/common/camera.png" style=" width: 30%; "></span><input type="file" name="referenceimage[' +
                rowId + '][]" class="atarfile" accept="image/*"></span></div></div></div></div>';

            $('#imageupload_' + rowId + ' .addMoreRow ').append(html);



            return true;


        });
    </script>
@endpush
