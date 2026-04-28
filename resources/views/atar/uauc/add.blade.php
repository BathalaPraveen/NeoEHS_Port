@extends('admin.layouts.layout')
@section('title', 'UAUC New')
@section('pageurl', admin_url('atar/uauc/add'))

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
                                UAUC
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('atar/uauc/list') }}">UAUC</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">UAUC New</li>
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
                                    <h5 class="card-title">UAUC New</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('atar/uauc/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="useeuact_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('atar/uauc/add/submit') }}">

                                <div class="p-4 border rounded ">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white text-uppercase">General Information</h6>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label require">Reporter Name</label>
                                            <input type="text" name="reporter_name" class="form-control" readonly
                                                id="reporter_name" value="{{ Auth::user()->name }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label require">Email</label>
                                            <input type="text" name="reporter_email" class="form-control" readonly
                                                id="reporter_name" value="{{ Auth::user()->email }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label require">Company</label>
                                            <input type="text" name="reporter_company" class="form-control" readonly
                                                id="reporter_name" value="{{ Auth::user()->companyInfo->company_name }}"
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label require">Division</label>
                                            <input type="text" name="reporter_division" class="form-control" readonly
                                                id="reporter_name" value="{{ Auth::user()->divisionInfo->division_name }}"
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label require">Department</label>
                                            <input type="text" name="reporter_department" class="form-control" readonly
                                                id="reporter_name"
                                                value="{{ Auth::user()->departmentInfo->department_name }}" required>
                                        </div>
                                        <hr>
                                        <div class="card-header card-header-inner mb-2">
                                            <h6 class="text-white text-uppercase">UAUC INFORMATION</h6>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="dateandtime" class="form-label require">Date</label>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <div class="input-group date form-input">
                                                    <input type="text" required=""
                                                        class="form-control todaymaxdatepicker" id="dateandtime"
                                                        name="dateandtime" readonly="">
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="location" class="form-label require">Location</label>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <select name="location" id="location" class="form-control select2">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locationDetails as $location)
                                                        <option value="{{ encryptId($location->id) }}">
                                                            {{ $location->location_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="specific_location" class="form-label require">Specific
                                                    Location</label>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <select name="specific_location" id="specific_location"
                                                    class="form-control select2">
                                                    <option value="">Select Specific Location</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input" id="other_speclocation_div"
                                                style="display:none">
                                                <input type="text" name="other_speclocation" id="other_speclocation"
                                                    placeholder="Other Location" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label require">UAUC Category</label>
                                            </div>
                                            <div class="col-md-9 form-input">
                                                <div class="p-2">
                                                    <input type="radio" name="uauc_category"
                                                        onchange="toggleDiv('{{ encryptId(1) }}')"
                                                        id="uauc_category_po_sa" value="{{ encryptId(1) }}">
                                                    <label for="uauc_category_po_sa">Safe Act</label>
                                                </div>
                                                <div class="p-2">
                                                    <input type="radio" name="uauc_category"
                                                        onchange="toggleDiv('{{ encryptId(2) }}')"
                                                        id="uauc_category_po_sc" value="{{ encryptId(2) }}">
                                                    <label for="uauc_category_po_sc">Safe Condition</label>
                                                </div>

                                                <div class="p-2">
                                                    <input type="radio" name="uauc_category" id="uauc_category_ua"
                                                        onchange="toggleDiv('{{ encryptId(3) }}')"
                                                        value="{{ encryptId(3) }}">
                                                    <label for="uauc_category_ua">Unsafe Act</label>
                                                </div>
                                                <div class="p-2">
                                                    <input type="radio" name="uauc_category" id="uauc_category_uc"
                                                        onchange="toggleDiv('{{ encryptId(4) }}')"
                                                        value="{{ encryptId(4) }}">
                                                    <label for="uauc_category_uc">Unsafe Condition</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3" id="hazard_div">
                                            <div class="col-md-3">
                                                <label for="hse_hazard" class="form-label require bold">Hazard / HSE
                                                    issues</label>
                                            </div>
                                            <div class="col-md-9 form-input">
                                                <select name="hse_hazard" id="hse_hazard" class="form-control select2">
                                                    <option value="">Select HSE Hazard</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3" id="zefaView" style="display: none">
                                            <div class="col-md-3">
                                                <label for="zefa" class="form-label bold">ZeFA Rule</label>
                                            </div>
                                            <div class="col-md-9 form-input">
                                                <div id="zefa"></div>
                                            </div>
                                        </div>

                                        <div class="row mb-3" id="messageView" style="display: none">
                                            <div class="col-md-3">
                                                <label for="message" class="form-label bold">Description</label>
                                            </div>
                                            <div class="col-md-9 form-input">
                                                <div id="message"></div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="usee_remarks" class="form-label require bold">Describe what
                                                    you see</label>
                                            </div>
                                            <div class="col-md-9 form-input">
                                                <div style="font-style: italic; ">
                                                    <div class="bold">Example:</div>
                                                    <div>The lifting work area has been barricaded and signage has been
                                                        displayed to alert workers/users in that area.</div>
                                                </div>
                                                <textarea name="usee_remarks" id="usee_remarks" class="form-control" rows="5"
                                                    placeholder="Enter your answer"></textarea>
                                            </div>
                                        </div>

                                        <div id="positiveImages">
                                            <div class="col-md-12">
                                                <div class="float-end">
                                                    <button type="button" class="badge bg-success addMorcerti1">Add
                                                        More</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label require">Upload</label>
                                                    </div>
                                                    <div class="col-md-8 form-input">
                                                        <div class="row addMorecompet1">
                                                            <div class="col-md-12 form-input imageuploadarea">
                                                                <div class="fileinput fileinput-new apprFileinput"
                                                                    style="  " data-provides="fileinput">
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight"
                                                                        data-trigger="fileinput">
                                                                    </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg, mp4)</p>
                                                                    <div class="file-pop">
                                                                        <span class="text-green btn-file">
                                                                            <span class="photo fileinput-new"
                                                                                title="Add Image">
                                                                                <img class="imgupload"
                                                                                    src='{{ admin_url('public/assets/images/common/camera.png') }}'
                                                                                    style=" width: 30%; " />
                                                                            </span>
                                                                            <span class="fileinput-exists"
                                                                                title="Add Image"></span>
                                                                            <input type="file" name="uactimage[]"
                                                                                class='atarfile'
                                                                                accept="image/*,video/mp4"
                                                                                onchange="validateFileSize(this)">
                                                                        </span>

                                                                        <button type="button" name="re"
                                                                            class="btn btn-nothing text-maroon fileinput-exists"
                                                                            data-dismiss="fileinput"
                                                                            title="Remove Image"><i
                                                                                class="fa fa-times-circle-o"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                    <p class="text-danger mini-txt d-none fileError">
                                                                        File size must be below
                                                                        20MB.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row " id="action_taken_div" style="display: none">

                                            <div class="card-header card-header-inner mb-3 ">
                                                <h6 class="text-white text-uppercase">Corrective Action </h6>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="zefa" class="form-label bold">Action Taken</label>
                                                </div>
                                                <div class="col-md-9 form-input">
                                                    @foreach ($atartypeactDetails as $atartype)
                                                        <div class="row">
                                                            <div class="col-md-6 form-input mt-1 mb-3">

                                                                <label for="action_taken_{{ encryptId($atartype->id) }}">
                                                                    <input type="radio" name="action_taken"
                                                                        id="action_taken_{{ encryptId($atartype->id) }}"
                                                                        onchange="actionTaken('{{ encryptId($atartype->id) }}')"
                                                                        value="{{ encryptId($atartype->id) }}">
                                                                    {{ $atartype->atar_type }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div id="immidiate_action" style="display: none">

                                                <div class="row mb-3" id="uact_remarks_div">
                                                    <div class="col-md-3">
                                                        <label for="uact_remarks"
                                                            class="form-label require ">Description</label>
                                                    </div>
                                                    <div class="col-md-9 form-input">
                                                        <textarea name="uact_remarks" id="uact_remarks" class="form-control" rows="5"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-3" style="display: none">

                                                    <div class="col-md-12">
                                                        <div class="float-end">
                                                            <button type="button"
                                                                class="badge bg-success addMorcerti1">Add
                                                                More</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label ">Upload</label>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <div class="row addMorecompet1">
                                                            <div class="col-md-12 form-input imageuploadarea">
                                                                <div class="fileinput fileinput-new apprFileinput"
                                                                    style="  " data-provides="fileinput">
                                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight"
                                                                        data-trigger="fileinput">
                                                                    </div>
                                                                    <p class="mini-txt">(png, jpeg, jpg ,mp4)</p>
                                                                    <div class="file-pop">
                                                                        <span class="text-green btn-file">
                                                                            <span class="photo fileinput-new"
                                                                                title="Add Image">
                                                                                <img class="imgupload"
                                                                                    src='{{ admin_url('public/assets/images/common/camera.png') }}'
                                                                                    style=" width: 30%; " />
                                                                            </span>
                                                                            <span class="fileinput-exists"
                                                                                title="Add Image"></span>
                                                                            <input type="file" name="uactimage[]"
                                                                                class='atarfile'
                                                                                accept="image/*,video/mp4" onchange="validateFileSize(this)">
                                                                        </span>

                                                                        <button type="button" name="re"
                                                                            class="btn btn-nothing text-maroon fileinput-exists"
                                                                            data-dismiss="fileinput"
                                                                            title="Remove Image"><i
                                                                                class="fa fa-times-circle-o"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>

                                                                    <p class="text-danger mini-txt d-none fileError">
                                                                        File size must be below
                                                                        20MB.</p>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="violators_email_div" style="display: none">

                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label for="job_owner" class="form-label ">Violator's Email
                                                                ID</label>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <input type="email" name="violators_email"
                                                                class="form-control" id="violators_email">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label for="infringement"
                                                                class="form-label require">Infringement</label>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <select name="infringement" id="infringement"
                                                                class="form-control select2" required>
                                                                <option value="">Select Infringement</option>
                                                                @foreach ($infringementList as $infringement)
                                                                    <option value="{{ encryptId($infringement->id) }}">
                                                                        {{ $infringement->infringement_no }} -
                                                                        {{ $infringement->type_of_infringement }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-3">
                                                            <label for="infringement" class="form-label require">SSDS
                                                                Serial Number</label>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <input type="text" name="ssds_serial_number"
                                                                class="form-control" id="ssds_serial_number">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" id="action_taken_report_to" style="display: none">
                                                <div class="card-header card-header-inner mb-3 ">
                                                    <h6 class="text-white text-uppercase">Responsibility </h6>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="company" class="form-label require">Company
                                                            Name</label>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <select name="company" id="company"
                                                            class="form-control select2" required>
                                                            <option value="">Select Company</option>
                                                            @foreach ($companyDetails as $company)
                                                                <option value="{{ encryptId($company->id) }}">
                                                                    {{ $company->company_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="division" class="form-label require">Division
                                                            Name</label>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <select name="division" id="division"
                                                            class="form-control select2" required>
                                                            <option value="">Select Division</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="department" class="form-label require">Department
                                                            Name</label>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <select name="department" id="department"
                                                            class="form-control select2" required>
                                                            <option value="">Select Department</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="job_owner" class="form-label require">Job
                                                            Owner</label>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <input type="text" name="job_owner_name" readonly
                                                            class="form-control" id="job_owner_name" style="display: none">
                                                        <select name="job_owner" id="job_owner"
                                                            class="form-control select2" required>
                                                            <option value="">Select Job Owner</option>
                                                        </select>

                                                        <div style="color:red;display:none" id="job_owner_error">Job Owner
                                                            not Available!</div>

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
            $('#useeuact_add').validate({
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


        function toggleDiv(id) {


            $("#hazard_div").hide();
            $("#immidiate_action").hide();
            $("#positiveImage").hide();


            if (id == '{{ encryptId(1) }}' || id == '{{ encryptId(2) }}') {
                $("#positiveImage").show();
            }

            if (id == '{{ encryptId(3) }}' || id == '{{ encryptId(4) }}') {
                $("#action_taken_div").show();
                $(".select2").select2();
            } else {
                $("#action_taken_div").hide();
            }

            $("#messageView").hide();
            $("#zefaView").hide();

            if (id != '{{ encryptId(0) }}') {

                $("#hazard_div").show();

                if (id != '') {
                    $.ajax({
                        url: "{{ admin_url('atar/master/hsehazard/list/') }}" + id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#hse_hazard').empty().append(
                                '<option value="">Select HSE Issues</option>');
                            $.each(data, function(key, value) {
                                $('#hse_hazard').append(
                                    '<option data-message="' + value.hover_msg +
                                    '" data-zefa="' + value.zefa_rule + '" value="' + value.id +
                                    '">' + value.name + '</option>');
                            });

                            $('#hse_hazard').trigger('change.select2');
                        }
                    });
                } else {
                    $("#hazard_div").hide();
                    $("#immidiate_action").hide();
                    $('#hse_hazard').empty().append('<option value="">Select HSE Issues</option>');
                    $('#hse_hazard').trigger('change.select2');
                }

            }

            $(".select2").select2();

        }

        function actionTaken(val) {

            $("#action_taken_report_to").show();
            $("#violators_email_div").hide();

            $("#immidiate_action").show();
            if (val == '{{ encryptId(3) }}') {
                $("#violators_email_div").show();

            }
            if (val == '{{ encryptId(2) }}') {
                $("#action_taken_report_to").hide();

            }

            $("#uact_remarks_div").show();
            switch (val) {
                case "{{ encryptId(1) }}":
                    $("#uact_remarks").attr("placeholder", "DESCRIBE STOP WORK TAKEN.INCLUDE PTW SERIAL NO.(IF ANY)");
                    break;
                case "{{ encryptId(2) }}":
                    $("#uact_remarks").attr("placeholder", "DESCRIBE WHAT IS YOUR IMMEDIATE ACTION / INTERVENTION.");
                    break;
                case "{{ encryptId(3) }}":
                    $("#uact_remarks_div").hide();
                    $("#uact_remarks").attr("placeholder", "Enter your description.");
                    break;
                case "{{ encryptId(4) }}":
                    $("#uact_remarks").attr("placeholder", "What is your recommendation?");
                    break;
            }

            $("#company").val("").trigger("change");
            $(".select2").select2();
        }

        function unselectRadio() {
            var radios = document.getElementsByName('uauc_category_po');

            for (var i = 0; i < radios.length; i++) {
                radios[i].checked = false;
            }
        }

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
            $('#job_owner_name').val('');
            $('#job_owner').empty().append('<option value=""></option>');
            $('#job_owner').trigger('change.select2');


        });

        $('#department').change(function() {
            $('#job_owner_error').hide();
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
                        $('#job_owner').empty();

                        if (data.length === 0) {
                            $('#job_owner_error').show();
                            $("#job_owner_name").val('');
                        } else {
                            $.each(data, function(key, value) {
                                var selectedtext = '';
                                if (key == 0) {
                                    selectedtext = 'selected';
                                    $("#job_owner_name").val(value.name);
                                }
                                $('#job_owner').append('<option ' + selectedtext + ' value="' +
                                    value.id + '">' +
                                    value.name + '</option>');
                            });
                        }

                    }
                });
            }


            $('#job_owner').empty().append('<option value="">Select Job Owner</option>');
            $('#job_owner').trigger('change.select2');
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
                            '<option value="">Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            $('#specific_location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });
                        $('#specific_location').append(
                            '<option value="{{ encryptId(0) }}">Others</option>');
                        $('#specific_location').trigger('change.select2');
                    }
                });
            } else {
                $('#specific_location').empty().append('<option value="">Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
            }
        });

        $('#specific_location').change(function() {
            var speclocationId = $(this).val();
            console.log(speclocationId, '{{ encryptId(0) }}');
            if (speclocationId == '{{ encryptId(0) }}') {

                $("#other_speclocation_div").show();
                $("#other_speclocation").val("");

            } else {
                $("#other_speclocation_div").hide();
            }


        });

        $('#usee').change(function() {
            var useeId = $(this).val();
            if (useeId) {
                $.ajax({
                    url: "{{ admin_url('atar/master/hsehazard/list/') }}" + useeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#hse_hazard').empty().append(
                            '<option value="">Select HSE Hazard</option>');
                        $.each(data, function(key, value) {
                            $('#hse_hazard').append(
                                '<option data-message="' + value.hover_msg +
                                '" data-zefa="' + value.zefa_rule + '" value="' + value.id +
                                '">' + value.name + '</option>');
                        });

                        $('#hse_hazard').trigger('change.select2');
                    }
                });
            } else {

                $('#hse_hazard').empty().append('<option value="">Select HSE Hazard</option>');
                $('#hse_hazard').trigger('change.select2');
            }
        });

        $('#hse_hazard').change(function() {
            var id = $(this).val();

            if (id != '') {

                var message = $("#hse_hazard option:selected").data("message");
                var zefa = $("#hse_hazard option:selected").data("zefa");

                $('#messageView').show();
                $('#message').html(message);

                $('#message').attr('title', 'ZeFA Rule : ' + zefa);

                // $('#zefaView').show();
                // $('#zefa').html(zefa);


            } else {

                $('#messageView').hide();
                $('#message').html('');

                $('#zefaView').hide();
                $('#zefa').html('');

            }




        });


        $(document).on('click', '.addMorcerti1', function() {

            var asdElement = document.querySelector(".addMorecompet1");

            if (asdElement) {
                // Get all elements with class "a" inside "asd"
                var elementsWithClassA = asdElement.getElementsByClassName("imageuploadarea");

                // Get the count
                var count = elementsWithClassA.length;
                console.log(count);

                if (count >= 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maximum 3 images only',
                    })
                    return false;
                }



            }
            var baseUrl = "{{ admin_url() }}"

            var html = '<div class="col-md-12 imageuploadarea" style="">' +
                '<div class="float-end removeCertinew1"><i class="fa fa-trash"></i></div>' +
                '<div class="form-group"><div class="fileinput fileinput-new apprFileinput" data-provides="fileinput">' +
                '<div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" style="margin-top:30px;"></div>' +
                '<p class="mini-txt">(png, jpeg, jpg, MP4)</p><div class="file-pop"><span class="text-green btn-file">' +
                '<span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' + baseUrl +
                '/public/assets/images/common/camera.png" style="width: 30%;"></span>' +
                '<span class="fileinput-exists" title="Add Image"></span><input type="file" name="uactimage[]" class="atarfile" accept="image/*,video/mp4" onchange="validateFileSize(this)"></span>' +
                '<button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">' +
                '<i class="fa fa-times-circle-o" aria-hidden="true"></i></button></div>' +
                '<p class="text-danger mini-txt d-none fileError">File size must be below 20MB.</p></div></div></div>';


            $(".addMorecompet1").append(html);

        });


        $(document).on('click', '.removeCertinew1', function() {
            $(this).closest('.col-md-12').remove();
        })

        window.onbeforeunload = function(event) {
            //return confirm("Confirm refresh");
        };
    </script>
@endpush
