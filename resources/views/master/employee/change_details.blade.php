@extends('admin.layouts.layout')
@section('title', 'Employee Details Change')
@section('pageurl', admin_url('employee/change_details'))

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

                            <li class="breadcrumb-item active" aria-current="page">Employee Details Change</li>
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
                                    <h5 class="card-title">Employee Details Change</h5>
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
                                action="{{ admin_url('employee/change_details/submit') }}">

                                <div class="p-4 border rounded ">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">From Employee Details</h6>
                                        </div>


                                        <div class="col-md-4 form-input">
                                            <label for="emp_company" class="form-label require">Company Name</label>
                                            <select name="emp_company" id="emp_company" class="form-control select2"
                                                required>
                                                <option value="">Select Company</option>
                                                @foreach ($companylist as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_division" class="form-label require">Division Name</label>
                                            <select name="emp_division" id="emp_division" class="form-control select2"
                                                required>
                                                <option value="">Select Division</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_department" class="form-label require">Department
                                                Name</label>
                                            <select name="emp_department" id="emp_department" class="form-control select2"
                                                required>
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="id" class="form-label require">Employee Name</label>
                                            <select name="id" id="id" class="form-control select2">
                                                <option value="" selected disabled>Select Employee</option>
                                                
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-4 form-input">
                                            <label for="id" class="form-label require">Employee Id</label>
                                            <p id="emp_id"></p>
                                        </div> --}}

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> To Employee Details</h6>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_company_id" class="form-label require">Company Name</label>
                                            <select name="emp_company_id" id="emp_company_id" class="form-control select2"
                                                required>
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
                                            <select name="emp_division_id" id="emp_division_id" class="form-control select2"
                                                required>
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
                                            <label for="employee_id" class="form-label require">Employee Id</label>
                                            <input type="text" name="employee_id" id="employee_id" class="form-control">
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="remarks" class="form-label require">Remarks</label>
                                            <textarea name="remarks" rows="5" class="form-control"></textarea>
                                        </div>

                                        <hr>
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
                    employee_id: {
                        required: true,
                        remote: {
                            url: "{{ admin_url('employee/unique') }}",
                            type: "post",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                type: 'employee_id',
                                value: function() {
                                    return $("input[name='employee_id']").val();
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
                    },
                    id: {
                        required: true,
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
                    remarks: {
                        required: true,
                    },

                },
                messages: {
                    id: {
                        required: "Please Select Employee",
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
                    remarks: {
                        required: "Please Enter Remarks",
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


        $('#id').change(function() {
            var Id = $(this).val();
            if (Id) {
                $.ajax({
                    url: "{{ admin_url('employee/getEmpDetails/') }}" + Id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_id').text(data.emp_id);

                    }
                });
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

        $('#emp_company').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_division').empty().append(
                            '<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#emp_division').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_division').trigger('change.select2');
                        $('#emp_department').empty().append(
                            '<option value="">Select Department</option>');
                        $('#emp_department').trigger('change.select2');

                        $('#emp_jobowner_department').empty();
                        $('#emp_jobowner_department').trigger('change.select2');


                    }
                });
            } else {
                $('#emp_division').empty().append('<option value="">Select Division</option>');
                $('#emp_department').empty().append('<option value="">Select Department</option>');
                $('#emp_jobowner_department').empty();

                $('#emp_division').trigger('change.select2');
                $('#emp_department').trigger('change.select2');
                $('#emp_jobowner_department').trigger('change.select2');
            }
        });

        $('#emp_division').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {
                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_department').empty().append(
                            '<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#emp_department').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_department').trigger('change.select2');
                    }
                });
            } else {
                $('#emp_department').empty().append('<option value="">Select Department</option>');
                $('#emp_department').trigger('change.select2');

                $('#emp_jobowner_department').empty();
            }
        });

        $('#emp_department').change(function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: "{{ admin_url('employee/list/') }}" + departmentId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#id').empty().append(
                            '<option value="">Select Employee</option>');
                        $.each(data, function(key, value) {
                            $('#id').append('<option value="' + value.id + '">' +
                                value.name +' (' + value.emp_id + ') </option>');
                        });

                        $('#id').trigger('change.select2');
                    }
                });
            } else {
                $('#id').empty().append('<option value="">Select Employee</option>');
                $('#id').trigger('change.select2');

                $('#emp_jobowner_department').empty();
            }
        });
    </script>
@endpush
