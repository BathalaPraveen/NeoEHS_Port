@extends('admin.layouts.layout')
@section('title', 'Employee View')
@section('pageurl', admin_url('employee/list'))

@push('style')
    <style>
        form label {
            font-weight: 500;
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
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('employee/list') }}">Employee</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Employee View</li>
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
                                    <h5 class="card-title">Employee View</h5>
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
                                            <label for="emp_id" class="form-label ">Employee ID</label>
                                            <div> {{ $employee->emp_id }}</div>

                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_name" class="form-label ">Employee Name</label>
                                            <div>{{ $employee->emp_name }}</div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_gender" class="form-label ">Gender</label>
                                            <div>
                                                @if ($employee->emp_gender == 1)
                                                    Male
                                                @else
                                                    Female
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_nationality" class="form-label ">Nationality</label>
                                            <div>
                                                @if ($employee->nationality == '')
                                                    Others
                                                @else
                                                    {{ $employee->nationality }}
                                                @endif

                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input " id="emp_nationality_other_div"
                                            @if ($employee->emp_nationality != 0) style="display: none" @endif>
                                            <label for="emp_nationality_other" class="form-label ">Nationality
                                                Others</label>
                                            <div>{{ $employee->emp_nationality_other }}</div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_ic_or_passport_no" class="form-label ">IC or Passport
                                                No</label>
                                            <div>{{ $employee->emp_ic_or_passport_no }}</div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_joining_date" class="form-label ">Joining Date</label>
                                            <div> {{ Displaydateformat($employee->emp_joining_date) }}</div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_email_id" class="form-label ">Email ID</label>
                                            <div>{{ $employee->emp_email_id }}</div>

                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_phone_no" class="form-label ">Phone</label>
                                            <div> {{ $employee->emp_phone_no }}</div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_phone_no" class="form-label ">Employee Category</label>
                                            <div> {{ $employee->category_name }}</div>
                                        </div>
                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Company Details</h6>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="emp_company_id" class="form-label ">Company Name</label>
                                            <div>{{ $employee->company_name }}</div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_division_id" class="form-label ">Division Name</label>
                                            <div>{{ $employee->division_name }}</div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_department_id" class="form-label ">Department
                                                Name</label>
                                            <div> {{ $employee->department_name }}</div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_location_id" class="form-label ">Location</label>
                                            <div> {{ $employee->location_name }}</div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_specfic_location" class="form-label ">Specific
                                                Location</label>

                                            <div>{{ $employee->specific_loc_name }}</div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_specfic_location" class="form-label "> Job Owner Department Name</label>

                                            <div>{{ $jobownerdeparmentname }}</div>

                                        </div>



                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Role Details</h6>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_designation_id" class="form-label ">Designation</label>
                                            <div> {{ $employee->designation_name }}</div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="emp_role_id" class="form-label ">User Role</label>
                                            <div>{{ getUserRoleName($employee->login_id)  }} </div>

                                        </div>
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
