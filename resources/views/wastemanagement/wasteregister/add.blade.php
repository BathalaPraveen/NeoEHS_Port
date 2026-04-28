@extends('admin.layouts.layout')
@section('title', 'Waste Registered Add')
@section('pageurl', admin_url('wastemanagement/' . $companyname . '/wasteregister/list'))

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
                                Waste Management
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/list') }}">Waste
                                    Registered</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Waste Registered Add</li>
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
                                    <h5 class="card-title">Waste Registered Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/list') }}"
                                        data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="useeuact_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/add/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="companyname" value="{{ $companyname }}">
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">New Waste Registration</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 mb-3">

                                            <div class="col-md-4 form-input">
                                                <label for="waste_code" class="form-label require">Waste Code</label>
                                                <select name="waste_code" id="waste_code" class="form-control select2">
                                                    <option value="">Please Select Waste Code</option>
                                                    @foreach ($wastetypeList as $wastetype)
                                                        <option value="{{ encryptId($wastetype->id) }}"
                                                            data-name='{{ $wastetype->wastetype_name }}'>
                                                            {{ $wastetype->wastetype_id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="waste_name" class="form-label require">Waste Name</label>
                                                <input type="text" name="waste_name" id="waste_name" class="form-control"
                                                    readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="waste_form" class="form-label require">Waste Form</label>
                                                <select name="waste_form" id="waste_form" class="form-control select2">
                                                    <option value="">Please Select Waste Form</option>
                                                    @foreach ($wasteformList as $wasteform)
                                                        <option value="{{ encryptId($wasteform->id) }}">
                                                            {{ $wasteform->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="notification_date" class="form-label require">Notification
                                                    Date</label>
                                                <div class="input-group">
                                                    <input type="text" name="notification_date" id="notification_date"
                                                        readonly="" class="form-control  notificationdate">

                                                    <div class="input-group-append" id="inspectiondate-show">
                                                        <span class="input-group-text fas fa-calendar"
                                                            style="height:37px;padding-top:10px;cursor: pointer;"></span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="notification_no" class="form-label require">Notification
                                                    No.</label>
                                                <input type="text" name="notification_no" id="notification_no"
                                                    class="form-control" required>
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
        $('#waste_code').change(function() {
            var wastetypeId = $(this).val();
            if (wastetypeId != '') {
                var selectedOption = this.options[this.selectedIndex];
                var dataname = selectedOption.getAttribute('data-name');
                $('#waste_name').val(dataname);
            } else {
                $('#waste_name').val("");
            }
        });


        $(document).ready(function() {
            $(".notificationdate").datepicker({

                format: "dd-mm-yyyy",
                autoclose: true,
                orientation: "bottom",
                todayHighlight: true,

            });
            $("#inspectiondate-show").on("click", function() {
                $(".notificationdate").datepicker("show");
            });
        });


        $(function() {
            $('#useeuact_add').validate({
                rules: {
                    waste_code: {
                        required: true,
                    },
                    waste_name: {
                        required: true,
                    },
                    waste_form: {
                        required: true,
                    },
                    notification_date: {
                        required: true,
                    },
                    notification_no: {
                        required: true,
                    },



                },
                messages: {
                    waste_code: {
                        required: "Please select Waste Code",
                    },
                    waste_name: {
                        required: "Waste Name is required",
                    },
                    waste_form: {
                        required: "Please select Waste form",
                    },
                    notification_date: {
                        required: "Please select Notification date",
                    },
                    notification_no: {
                        required: "Please enter Notification No",
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
    </script>
@endpush
