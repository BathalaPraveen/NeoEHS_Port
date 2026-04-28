@extends('admin.layouts.layout')
@section('title', 'Employee Edit')
@section('pageurl', admin_url('employee/list'))

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
                            <li class="breadcrumb-item active" aria-current="page">Employee Edit</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col">
                    <hr />
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body">
                            <div class="d-lg-flex align-items-center gap-3">

                                <div class="position-relative">
                                    <h5 class="card-title">Employee Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('employee/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="row g-3" id="employee_edit" novalidate method="POST"
                                action="{{ admin_url('employee/edit/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Basic Details</h6>
                                        </div>
                                        <input type="hidden" name="id" value="{{ encryptId($employee->id) }}">
                                        <div class="col-md-4 form-input">
                                            <label for="emp_id" class="form-label require">Employee ID</label>
                                            <input type="text" name="emp_id" class="form-control" id="emp_id"
                                                value="{{ $employee->emp_id }}" required readonly>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_name" class="form-label require">Employee Name</label>
                                            <input type="text" name="emp_name" class="form-control" id="emp_name"
                                                value="{{ $employee->emp_name }}" required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_gender" class="form-label require">Gender</label>
                                            <select name="emp_gender" id="emp_gender" class="form-control select2" required>
                                                <option value="">Select Gender</option>
                                                <option @if ($employee->emp_gender == 1) selected @endif
                                                    value="{{ encryptId(1) }}">Male</option>
                                                <option @if ($employee->emp_gender == 2) selected @endif
                                                    value="{{ encryptId(2) }}">Female</option>
                                            </select>

                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_nationality" class="form-label require">Nationality</label>
                                            <select name="emp_nationality" id="emp_nationality" class="form-control select2"
                                                required>
                                                <option value="">Select Nationality</option>
                                                @foreach ($nationalitylist as $nationality)
                                                    <option @if ($employee->emp_nationality == $nationality->id) selected @endif
                                                        value="{{ encryptId($nationality->id) }}">
                                                        {{ $nationality->nationality }}</option>
                                                @endforeach
                                                <option @if ($employee->emp_nationality == 0) selected @endif value="0">
                                                    Others
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input " id="emp_nationality_other_div"
                                            @if ($employee->emp_nationality != 0) style="display: none" @endif>
                                            <label for="emp_nationality_other" class="form-label require">Nationality
                                                Others</label>
                                            <input type="text" name="emp_nationality_other" class="form-control"
                                                id="emp_nationality_other" value="{{ $employee->emp_nationality_other }}"
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_ic_or_passport_no" class="form-label require">IC or Passport
                                                No</label>
                                            <input type="text" name="emp_ic_or_passport_no" class="form-control"
                                                id="emp_ic_or_passport_no" value="{{ $employee->emp_ic_or_passport_no }}"
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_joining_date" class="form-label require">Joining Date</label>
                                            <input type="text" name="emp_joining_date"
                                                class="form-control todaymaxdatepicker" id="emp_joining_date"
                                                value="{{ Displaydateformat($employee->emp_joining_date) }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_email_id" class="form-label ">Email ID</label>
                                            <input type="text" name="emp_email_id" class="form-control"
                                                id="emp_email_id" value="{{ $employee->emp_email_id }}">
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_phone_no" class="form-label ">Phone</label>
                                            <input type="text" name="emp_phone_no" class="form-control"
                                                id="emp_phone_no" value="{{ $employee->emp_phone_no }}">
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_category" class="form-label ">Employee Category</label>
                                            <select name="emp_category" id="emp_category" class="form-control select2">
                                                <option value="">Select Employee Category</option>
                                                @foreach ($categoryList as $category)
                                                    <option @if ($employee->emp_category == $category->id) selected @endif
                                                        value="{{ encryptId($category->id) }}">
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
                                                    <option @if ($employee->emp_company_id == $company->id) selected @endif
                                                        value="{{ encryptId($company->id) }}">
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
                                                @foreach ($diviaionList as $division)
                                                    <option @if ($employee->emp_division_id == $division->id) selected @endif
                                                        value="{{ encryptId($division->id) }}">
                                                        {{ $division->division_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_department_id" class="form-label require">Department
                                                Name</label>
                                            <select name="emp_department_id" id="emp_department_id"
                                                class="form-control select2" required>
                                                <option value="">Select Department</option>
                                                @foreach ($departmentList as $department)
                                                    <option @if ($employee->emp_department_id == $department->id) selected @endif
                                                        value="{{ encryptId($department->id) }}">
                                                        {{ $department->department_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_location_id" class="form-label ">Location</label>
                                            <select name="emp_location_id" id="emp_location_id"
                                                class="form-control select2">
                                                <option value="">Select Location</option>
                                                @foreach ($locationlist as $location)
                                                    <option @if ($employee->emp_location_id == $location->id) selected @endif
                                                        value="{{ encryptId($location->id) }}">
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
                                                @foreach ($specificlocationList as $splocation)
                                                    <option @if ($employee->emp_specfic_location == $splocation->id) selected @endif
                                                        value="{{ encryptId($splocation->id) }}">
                                                        {{ $splocation->specific_loc_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_jobowner_department_id" class="form-label">Job Owner
                                                Department
                                                Name</label>
                                            @php
                                                $job_owner_department = $employee->job_owner_department;
                                                $job_owner_department_list = [];
                                                if ($job_owner_department != '' && $job_owner_department != null) {
                                                    $job_owner_department_list = string_to_array($job_owner_department);
                                                }

                                            @endphp
                                            <select name="emp_jobowner_department_id[]" id="emp_jobowner_department_id"
                                                multiple class="form-control select2">

                                                @foreach ($jobownerdepartment as $jobownerdept)
                                                    <option @if ( in_array($jobownerdept->id,$job_owner_department_list) ) selected @endif
                                                        value="{{ encryptId($jobownerdept->id) }}">
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
                                                    <option @if ($employee->emp_designation_id == $designation->id) selected @endif
                                                        value="{{ encryptId($designation->id) }}">
                                                        {{ $designation->designation_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_role_id" class="form-label ">User Role</label>
                                            @php
                                                $roleIds = string_to_array($employee->emp_role_id);

                                            @endphp
                                            <select name="emp_role_id[]" id="emp_role_id" multiple
                                                class="form-control select2">
                                                <option value="">Select Role</option>

                                                @foreach ($rolelist as $role)
                                                    <option @if (in_array($role->id, $roleIds)) selected @endif
                                                        value="{{ encryptId($role->id) }}">
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class=" card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Update">Update</button>
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
            $('#employee_edit').validate({
                rules: {
                    emp_id: {
                        required: true,
                        //customEmployeeID : true
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
                    emp_email_id: {
                        email: true,
                    },
                    emp_ic_or_passport_no: {
                        required: true,

                    },
                    emp_designation_id: {
                        required: true,
                    },
                    emp_phone_no: {
                        mobileNumber: true,
                    },
                    emp_company_id: {
                        required: true,
                    },
                    emp_division_id: {
                        required: true,
                    },
                    emp_department_id: {
                        required: true,
                    },
                    emp_email_id: {
                        email: true,
                    },
                    emp_phone_no: {
                        // required: true,
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
                    emp_email_id: {
                        email: "Please enter valid Email id",
                    },
                    emp_designation_id: {
                        required: "Please select Designation",
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
                    emp_email_id: {
                        email: "Please enter valid Email",
                    },
                    emp_phone_no: {
                        required: "Please enter Phone Number",
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
                    }
                });
            } else {
                $('#emp_division_id').empty().append('<option value="">Select Division</option>');
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');

                $('#emp_division_id').trigger('change.select2');
                $('#emp_department_id').trigger('change.select2');
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
                    }
                });
            } else {
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');
                $('#emp_department_id').trigger('change.select2');
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
