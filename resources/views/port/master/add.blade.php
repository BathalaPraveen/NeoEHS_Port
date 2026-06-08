@extends('admin.layouts.layout')
@section('title', 'Add Port Security Auccess')
@section('pageurl', admin_url('portsecurity/master/list'))

@push('style')
    <style>
        input[type="text"] {
            text-transform: uppercase;
        }

        textarea {
            text-transform: uppercase;
        }

        .col-md-3 label {
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
                                Port Security Auccess
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('portsecurity/master/list') }}">Port Security Auccess List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Add Port Security Auccess</li>
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
                                    <h5 class="card-title">Add Port Security Auccess</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('portsecurity/master/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="port_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('portsecurity/master/add/submit') }}">

                                <div class="p-4 border rounded ">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white text-uppercase">Port Security Access</h6>
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
        function validateFileSize(input) {
            const maxSize = 20 * 1024 * 1024;
            const parentDiv = input.closest(".imageuploadarea");
            const errorMsg = parentDiv.querySelector(".fileError");

            if (input.files.length > 0) {
                const file = input.files[0];
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: "error",
                        title: "File Too Large",
                        text: "File size must be below 20MB.",
                    });

                    input.value = "";
                    errorMsg.classList.remove("d-none");
                } else {
                    errorMsg.classList.add("d-none");
                }
            }
        }

        $("#hazard_div").hide();
        $("#immidiate_action").hide();

        $(function() {
            $('#port_add').validate({
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
                    uauc_category: {
                        required: true,
                    },
                    uauc_category_po: {
                        required: true,
                    },
                    hse_hazard: {
                        required: true,
                    },
                    usee_remarks: {
                        required: true,
                    },
                    action_taken: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                    division: {
                        required: true,
                    },
                    department: {
                        required: true,
                    },
                    job_owner: {
                        required: true,
                    },
                    infringement: {
                        required: true,
                    },
                    uact_remarks: {
                        required: true,
                    },
                    other_speclocation: {
                        required: true,
                    },
                    ssds_serial_number: {
                        required: true,
                    },
                    job_owner_name: {
                        required: true,
                    },
                    // 'uactimage[]': {
                    //     required: true,
                    // }

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
                    uauc_category: {
                        required: "Please select UAUC Category",
                    },
                    uauc_category_po: {
                        required: "Please select UAUC Category",
                    },
                    hse_hazard: {
                        required: "Please select HSE Hazard",
                    },
                    usee_remarks: {
                        required: "Please enter U-See Description",
                    },
                    action_taken: {
                        required: "Please select Action Taken",
                    },
                    company: {
                        required: "Please select Company",
                    },
                    division: {
                        required: "Please select Division",
                    },
                    department: {
                        required: "Please select Department",
                    },
                    job_owner: {
                        required: "Please select Job Owner",
                    },
                    infringement: {
                        required: "Please select Infringement",
                    },
                    uact_remarks: {
                        required: "Please enter U-ACT Description",
                    },
                    other_speclocation: {
                        required: "Please enter Other Location",
                    },
                    ssds_serial_number: {
                        required: "Please enter the SSDS Serial Number",
                    },
                    job_owner_name: {
                        required: "Job Owner is required",
                    },
                    // 'uactimage[]': {
                    //     required: "Please select Image",
                    // },

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

            $('#job_owner_name').val('');
            $('#job_owner').empty().append('<option value=""></option>');
            $('#job_owner').trigger('change.select2');
        });

        window.onbeforeunload = function(event) {
            //return confirm("Confirm refresh");
        };
    </script>
@endpush
