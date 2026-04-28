@extends('admin.layouts.layout')
@section('title', 'Employee Password Reset')
@section('pageurl', admin_url('employee/list'))

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
                            <li class="breadcrumb-item active" aria-current="page">Employee Password Reset</li>
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
                                    <h5 class="card-title">Employee Password Reset</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('employee/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="row g-3" id="password_update" novalidate method="POST"
                                action="{{ admin_url('employee/passwordchange/submit') }}">
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
                                                value="{{ $employee->emp_name }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        @csrf
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white"> Password Details</h6>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="password" class="form-label require">New Password</label>
                                            <div class="input-group date form-input">
                                                <input type="password" required="" class="form-control password"
                                                    id="password" name="password">
                                                <div class="input-group-addon input-group-text password_view">
                                                    <span style="color:#0053a1" class="fa fa-eye"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="conpassword" class="form-label require">Re-enter Password</label>

                                            <div class="input-group date form-input">
                                                <input type="password" required="" class="form-control password"
                                                    id="conpassword" name="conpassword">
                                                <div class="input-group-addon input-group-text password_view">
                                                    <span style="color:#0053a1" class="fa fa-eye"></span>
                                                </div>
                                            </div>
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
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $('.password_view').on('click', function() {
            var passInput = $(this).prev('.password');
            var eyeIcon = $(this).find('span.fa');

            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passInput.attr('type', 'password');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $(function() {

            $.validator.addMethod("passwordPolicy", function(value, element) {
                return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/
                    .test(value);
            }, "Password must contain a minimum of 8 alphanumeric characters with a combination of uppercase, lowercase, number and symbol.");

            $('#password_update').validate({
                rules: {
                    emp_id: {
                        required: true,
                    },
                    emp_name: {
                        required: true,
                    },
                    password: {
                        required: true,
                        passwordPolicy : true
                    },
                    conpassword: {
                        required: true,
                        passwordPolicy : true,
                        equalTo: "#password",
                    },
                },
                messages: {
                    emp_id: {
                        required: "Please enter Employee ID",
                    },
                    emp_name: {
                        required: "Please enter Employee Name",
                    },
                    password: {
                        required: "Please enter the Password",
                    },
                    conpassword: {
                        required: "Please enter the Confirm Password",
                        equalTo: "Password and confirm password Mismatch",

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
    </script>
@endpush
