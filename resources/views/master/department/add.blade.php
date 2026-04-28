@extends('admin.layouts.layout')
@section('title', 'Department Add')
@section('pageurl', admin_url('department/list'))

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
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('department/list') }}">Department</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Department Add</li>
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
                                    <h5 class="card-title">Department Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('department/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="department_add" novalidate method="POST"
                                action="{{ admin_url('department/add/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="company_id" class="form-label require">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control select2" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="division_id" class="form-label require">Division Name</label>
                                            <select name="division_id" id="division_id" class="form-control select2"
                                                required>
                                                <option value="">Select Division</option>

                                            </select>

                                        </div>
                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="department_id" class="form-label require">Department ID</label>
                                            <input type="text" name="department_id" class="form-control"
                                                id="department_id" value="{{ getsequence('department') }}" readonly
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="department_name" class="form-label require">Department Name</label>
                                            <input type="text" name="department_name" class="form-control"
                                                id="department_name" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="department_shortname" class="form-label ">Department
                                                Short Name</label>
                                            <input type="text" name="department_shortname" class="form-control"
                                                id="department_shortname" value="" >

                                        </div>

                                        <div class="col-md-4 form-input  mb-3">
                                            <label for="location_id" class="form-label require">Department Admin</label>
                                            <select name="dept_admin[]" id="dept_admin" class="form-control select2"
                                                multiple>
                                                <option value="">Please select Admin</option>
                                                @foreach ($employeeDetails as $employee)
                                                    <option value="{{ encryptId($employee->id) }}">
                                                        {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip" title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip" title="Submit">Submit</button>
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
            $('#department_add').validate({
                rules: {
                    company_id: {
                        required: true,
                    },
                    division_id: {
                        required: true,
                    },
                    department_name: {
                        required: true,
                    },
                    'dept_admin[]': {
                        required: true,
                    },
                    // department_shortname: {
                    //     required: true,
                    // },

                },
                messages: {
                    company_id: {
                        required: "Please select Company",
                    },
                    division_id: {
                        required: "Please select Division",
                    },
                    department_name: {
                        required: "Please enter Department Name",
                    },
                    'dept_admin[]': {
                        required: "Please Select Department Admin",
                    },
                    // department_shortname: {
                    //     required: "Please enter Department Short Name",
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

        $('#company_id').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#division_id').empty().append('<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#division_id').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });

                        $('#division_id').trigger('change.select2');
                    }
                });
            } else {
                $('#division_id').empty().append('<option value="">Select Division</option>');

                $('#division_id').trigger('change.select2');
            }
        });
    </script>
@endpush
