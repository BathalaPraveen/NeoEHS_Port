@extends('admin.layouts.layout')
@section('title', 'Contractor Employee Add')
@section('pageurl', admin_url('contractor/add'))

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
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('contractor/list') }}">Contractor</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor Add</li>
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
                                    <h5 class="card-title">Contractor Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('contractor/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="contractor_add" novalidate method="POST"
                                action="{{ admin_url('contractor/add/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row">
                                        @csrf
                                        {{-- <input type="hidden" name="con_role" value="{{ encryptId(2) }}"> --}}
                                        <div class="col-md-4 form-input">
                                            <label for="con_id" class="form-label require">Contractor ID</label>
                                            <input type="text" name="con_id" class="form-control" id="con_id"
                                                value="{{ getsequence('contractor') }}" required readonly>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="con_name" class="form-label require">Contractor Employee
                                                Name</label>
                                            <input type="text" name="con_name" class="form-control" id="con_name"
                                                value="" required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="con_role" class="form-label require">User Type</label>
                                            <select name="con_role" id="con_role" class="form-control select2">
                                                <option value="">Select User Type</option>
                                                <option value="{{ encryptId(ROLE_CONTRACTORADMIN) }}">Admin</option>
                                                <option value="{{ encryptId(ROLE_CONTRACTORUSER) }}">User</option>
                                            </select>

                                        </div>
                                        {{-- <div class="col-md-4 form-input">
                                            <label for="con_nationality" class="form-label ">Nationality</label>
                                            <select name="con_nationality" id="con_nationality" class="form-control select2"
                                                >
                                                <option value="">Select Nationality</option>
                                                @foreach ($nationalitylist as $nationality)
                                                    <option value="{{ encryptId($nationality->id) }}">
                                                        {{ $nationality->nationality }}</option>
                                                @endforeach
                                                <option value="0">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input " id="con_nationality_other_div"
                                            style="display: none">
                                            <label for="con_nationality_other" class="form-label require">Nationality
                                                Others</label>
                                            <input type="text" name="con_nationality_other" class="form-control"
                                                id="con_nationality_other" value="" required>
                                        </div> --}}

                                        <div class="col-md-4 form-input">
                                            <label for="id_type" class="form-label require">ID Type</label>
                                            <select name="id_type" id="id_type" class="form-control select2" required>
                                                <option value="">Select ID Type</option>
                                                <option value="{{ encryptId(1) }}">IC Number</option>
                                                <option value="{{ encryptId(2) }}">Passport Number</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="con_mc_or_passport_no" class="form-label require">IC Number or
                                                Passport Number</label>
                                            <input type="text" name="con_mc_or_passport_no" class="form-control"
                                                id="con_mc_or_passport_no" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="con_designation_id" class="form-label require">Designation</label>
                                            <input type="text" name="con_designation_id" class="form-control"
                                                id="con_designation_id" value="" required>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="con_company_id" class="form-label require">Company Name</label>
                                            <select name="con_company_id" id="con_company_id" class="form-control select2"
                                                required>
                                                <option value="">Select Company</option>
                                                @foreach ($companylist as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->con_comp_name }}
                                                    </option>
                                                @endforeach
                                                <option value="0">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input " id="con_company_other_div" style="display: none">
                                            <label for="con_company_other" class="form-label require">New Company
                                                Name</label>
                                            <input type="text" name="con_company_other" class="form-control"
                                                id="con_company_other" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="con_email_id" class="form-label require">Email ID</label>
                                            <input type="text" name="con_email_id" class="form-control"
                                                id="con_email_id" required value="">
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="con_phone_no" class="form-label require">Phone</label>
                                            <input type="text" name="con_phone_no" class="form-control"
                                                id="con_phone_no" required value="">
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
        $(function() {
            $('#contractor_add').validate({
                rules: {
                    con_id: {
                        required: true,
                    },
                    con_name: {
                        required: true,
                    },

                    con_role: {
                        required: true,
                    },
                    id_type: {
                        required: true,
                    },
                    con_mc_or_passport_no: {
                        required: true,
                        customPassportID: true,
                    },
                    con_designation_id: {
                        required: true,
                    },
                    con_company_id: {
                        required: true,
                    },
                    con_company_other: {
                        required: true,
                    },
                    con_email_id: {
                        required: true,
                        email: true,
                    },
                    con_phone_no: {
                        required: true,
                        pattern: /^[0-9+\-\/()\[\]{} ]+$/
                    },

                },
                messages: {
                    con_id: {
                        required: "Please enter Contractor ID",
                    },
                    con_name: {
                        required: "Please enter Contractor Name",
                    },

                    con_role: {
                        required: "Please select Contractor Role",
                    },
                    id_type: {
                        required: "Please select ID Type",
                    },
                    con_mc_or_passport_no: {
                        required: "Please enter IC or Passport No",
                    },
                    con_designation_id: {
                        required: "Please enter Designation",
                    },
                    con_company_id: {
                        required: "Please select Company",
                    },
                    con_company_other: {
                        required: "Please enter Company Name",
                    },
                    con_email_id: {
                        required: "Please enter Email",
                        email: "Please enter valid Email"
                    },
                    con_phone_no: {
                        required: "Please enter Phone Number",
                        pattern: "Please enter valid contact number"
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

        $('#con_nationality').change(function() {
            var nationality = $(this).val();
            console.log(nationality);
            if (nationality == 0) {
                $("#con_nationality_other_div").show();
            } else {
                $("#con_nationality_other_div").hide();

            }
        });

        $('#con_company_id').change(function() {
            var nationality = $(this).val();
            console.log(nationality);
            if (nationality == 0) {
                $("#con_company_other_div").show();
            } else {
                $("#con_company_other_div").hide();

            }
        });
    </script>
@endpush
