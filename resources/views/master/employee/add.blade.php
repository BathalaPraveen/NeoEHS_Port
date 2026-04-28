@extends('admin.layouts.layout')
@section('title', 'Employee Add')
@section('pageurl', admin_url('employee/add'))

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
                                <a href="{{ admin_url('employee/list') }}">Employee</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Employee Add</li>
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
                                    <h5 class="card-title">Employee Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('employee/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="employee_add" novalidate method="POST"
                                action="{{ admin_url('employee/add/submit') }}">

                                <div class="p-4 border rounded ">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Basic Details</h6>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_id" class="form-label require">Employee ID</label>
                                            <input type="text" name="emp_id" class="form-control" id="emp_id"
                                                value="" required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_name" class="form-label require">Employee Name</label>
                                            <input type="text" name="emp_name" class="form-control" id="emp_name"
                                                value="" required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_gender" class="form-label require">Gender</label>
                                            <select name="emp_gender" id="emp_gender" class="form-control select2" required>
                                                <option value="">Select Gender</option>
                                                <option value="{{ encryptId(1) }}">Male</option>
                                                <option value="{{ encryptId(2) }}">Female</option>
                                            </select>

                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_nationality" class="form-label require">Nationality</label>
                                            <select name="emp_nationality" id="emp_nationality" class="form-control select2"
                                                required>
                                                <option value="">Select Nationality</option>
                                                @foreach ($nationalitylist as $nationality)
                                                    <option value="{{ encryptId($nationality->id) }}">
                                                        {{ $nationality->nationality }}</option>
                                                @endforeach
                                                <option value="0">Others</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input " id="emp_nationality_other_div"
                                            style="display: none">
                                            <label for="emp_nationality_other" class="form-label require">Nationality
                                                Others</label>
                                            <input type="text" name="emp_nationality_other" class="form-control"
                                                id="emp_nationality_other" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_ic_or_passport_no" class="form-label require">IC or Passport
                                                No</label>
                                            <input type="text" name="emp_ic_or_passport_no" class="form-control"
                                                id="emp_ic_or_passport_no" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_joining_date" class="form-label require">Joining Date</label>
                                            <input type="text" name="emp_joining_date"
                                                class="form-control todaymaxdatepicker" autocomplete="false"
                                                id="emp_joining_date" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_email_id" class="form-label ">Email ID</label>
                                            <input type="text" name="emp_email_id" class="form-control"
                                                id="emp_email_id" value="">
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_category" class="form-label ">Phone</label>
                                            <input type="text" name="emp_category" class="form-control"
                                                id="emp_category" value="">
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_category" class="form-label ">Employee Category</label>
                                            <select name="emp_category" id="emp_category"
                                                class="form-control select2" >
                                                <option value="">Select Employee Category</option>
                                                @foreach ($categoryList as $category)
                                                    <option value="{{ encryptId($category->id) }}">
                                                        {{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Company Details</h6>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_company_id" class="form-label require">Company Name</label>
                                            <select name="emp_company_id" id="emp_company_id"
                                                class="form-control select2" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companylist as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_division_id" class="form-label require">Division Name</label>
                                            <select name="emp_division_id" id="emp_division_id"
                                                class="form-control select2" required>
                                                <option value="">Select Division</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_department_id" class="form-label require">Department
                                                Name</label>
                                            <select name="emp_department_id" id="emp_department_id"
                                                class="form-control select2" required>
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_location_id" class="form-label ">Location</label>
                                            <select name="emp_location_id" id="emp_location_id"
                                                class="form-control select2">
                                                <option value="">Select Location</option>
                                                @foreach ($locationlist as $location)
                                                    <option value="{{ encryptId($location->id) }}">
                                                        {{ $location->location_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_specfic_location" class="form-label ">Specific
                                                Location</label>
                                            <select name="emp_specfic_location" id="emp_specfic_location"
                                                class="form-control select2">
                                                <option value="">Select Specific Location</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_jobowner_department" class="form-label ">Job Owner Department
                                                Name</label>
                                            <select name="emp_jobowner_department_id[]" id="emp_jobowner_department"
                                                class="form-control select2" multiple>
                                                <option value="">Select Job Owner Department</option>
                                                @foreach ($jobownerdepartment as $jobownerdept)
                                                <option value="{{ encryptId($jobownerdept->id) }}">
                                                    {{ $jobownerdept->company_name }} - {{ $jobownerdept->department_name }}
                                                </option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Role Details</h6>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_designation_id" class="form-label require">Designation</label>
                                            <select name="emp_designation_id" id="emp_designation_id"
                                                class="form-control select2" required>
                                                <option value="">Select Designation</option>
                                                @foreach ($designationlist as $designation)
                                                    <option value="{{ encryptId($designation->id) }}">
                                                        {{ $designation->designation_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_role_id" class="form-label require">User Role</label>
                                            <select name="emp_role_id[]" multiple id="emp_role_id"
                                                class="form-control select2" required>
                                                <option value="">Select Role</option>

                                                @foreach ($rolelist as $role)
                                                    <option value="{{ encryptId($role->id) }}">
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
            $('#employee_add').validate({
                rules: {
                    emp_id: {
                        required: true,
                        remote: {
                            url: "{{ admin_url('employee/unique') }}",
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                type: 'emp_id',
                                value: function() {
                                    return $("input[name='emp_id']").val();
                                }
                            },
                            dataFilter: function(data) {
                                var json = JSON.parse(data);
                                if (json.msg == "true") {
                                    return "\"" + "Employee ID already exists" + "\"";
                                } else {
                                    return 'true';
                                }
                            }
                        },
                        //customEmployeeID: true
                    },
                    emp_name: {
                        required: true,
                    },
                    emp_gender: {
                        required: true,
                    },
                    emp_nationality: {
                        required: true,
                    },
                    emp_nationality_other: {
                        required: true,
                    },
                    emp_ic_or_passport_no: {
                        required: true,
                        customPassportID: true
                    },
                    emp_designation_id: {
                        required: true,
                    },
                    emp_email_id: {
                        email: true,
                    },
                    emp_company_id: {
                        required: true,
                    },
                    emp_phone_no: {
                        //  mobileNumber : true,
                    },
                    emp_division_id: {
                        required: true,
                    },
                    emp_department_id: {
                        required: true,
                    },
                    emp_joining_date: {
                        required: true,
                    },
                    "emp_role_id[]": {
                        required: true,
                    },

                },
                messages: {
                    emp_id: {
                        required: "Please enter Employee ID",
                    },
                    emp_name: {
                        required: "Please enter Employee Name",
                    },
                    emp_gender: {
                        required: "Please select Gender",
                    },
                    emp_nationality: {
                        required: "Please select Nationality",
                    },
                    emp_nationality_other: {
                        required: "Please enter Nationality",
                    },
                    emp_ic_or_passport_no: {
                        required: "Please enter IC or Passport No",
                    },
                    emp_designation_id: {
                        required: "Please select Designation",
                    },
                    emp_email_id: {
                        email: "Please enter valid Email id",
                    },
                    emp_phone_no: {
                        mobileNumber: "Please enter valide Phone number",
                    },
                    emp_company_id: {
                        required: "Please select Company",
                    },
                    emp_division_id: {
                        required: "Please select Division",
                    },
                    emp_department_id: {
                        required: "Please select Department",
                    },

                    emp_joining_date: {
                        required: "Please enter Joining Date",
                    },
                    "emp_role_id[]": {
                        required: "Please select Role",
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

        $('#emp_nationality').change(function() {
            var nationality = $(this).val();
            console.log(nationality);
            if (nationality == 0) {
                $("#emp_nationality_other_div").show();
            } else {
                $("#emp_nationality_other_div").hide();

            }
        });



        $('#emp_company_id').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_division_id').empty().append(
                            '<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#emp_division_id').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_division_id').trigger('change.select2');
                        $('#emp_department_id').empty().append(
                            '<option value="">Select Department</option>');
                        $('#emp_department_id').trigger('change.select2');

                        $('#emp_jobowner_department_id').empty();
                        $('#emp_jobowner_department_id').trigger('change.select2');


                    }
                });
            } else {
                $('#emp_division_id').empty().append('<option value="">Select Division</option>');
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');
                $('#emp_jobowner_department_id').empty();

                $('#emp_division_id').trigger('change.select2');
                $('#emp_department_id').trigger('change.select2');
                $('#emp_jobowner_department_id').trigger('change.select2');
            }
        });

        $('#emp_division_id').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {
                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_department_id').empty().append(
                            '<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#emp_department_id').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_department_id').trigger('change.select2');



                        $('#emp_jobowner_department_id').empty();
                        $.each(data, function(key, value) {
                            $('#emp_jobowner_department_id').append('<option value="' + value
                                .id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_jobowner_department_id').trigger('change.select2');
                    }
                });
            } else {
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');
                $('#emp_department_id').trigger('change.select2');

                $('#emp_jobowner_department_id').empty();
                $('#emp_departmemp_jobowner_department_ident_id').trigger('change.select2');
            }
        });


        $('#emp_location_id').change(function() {
            var locationId = $(this).val();
            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/list/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_specfic_location').empty().append(
                            '<option value="">Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            $('#emp_specfic_location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_specfic_location').trigger('change.select2');
                    }
                });
            } else {
                $('#emp_specfic_location').empty().append('<option value="">Select Specific Location</option>');
                $('#emp_specfic_location').trigger('change.select2');
            }
        });
    </script>
@endpush
