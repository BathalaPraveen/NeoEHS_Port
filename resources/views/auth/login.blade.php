@extends('layouts.login')
@section('title', 'Login')
@section('content')
    @push('style')
        <style>
            .login-btn {
                background-color: #009B9C !important;
                color: white !important;
                border-radius: 30px !important;
            }

            .login-btn:hover,
            .login-btn:focus,
            .login-btn:active,
            .login-btn.active {
                background-color: #066D6D !important;
                color: white !important;
            }


        </style>
    @endpush

    <form id="loginform" action="{{ admin_url('logintry') }}" method="post" autocomplete="false" style="margin-top:2rem">
        @csrf
        <div class="form-group first mb-3">
            <label for="username">User ID</label>
            <input type="text" class="form-control" placeholder="Enter User ID" name="username" id="username">
        </div>
        <div class="form-group last mb-3">
            <label for="password">Password</label>
            <div class="input-group date form-input">
                <input type="password" required="" class="form-control" id="password" name="password">
                <div class="input-group-addon input-group-text" id="password_view">
                    <span style="color:#0053a1" class="fa fa-eye"></span>
                </div>
            </div>
        </div>

        <div class="row mb-3 align-items-center">
            <div class="col-md-6">
                <label class="control control--checkbox mb-3">
                    <input type="checkbox" name="remember" class="form-input-checkbox">
                    <span class="caption">Remember me</span>
                </label>
            </div>
            <div class="col-md-6" style="text-align:right">
                <span class="ml-auto"><a href="{{ admin_url('password/forgot') }}" class="forgot-pass ">Forgot
                        Password</a></span>
            </div>
            <div class="col-md-6">

            </div>
            <div class="col-md-6" style="text-align:right">
                <span class="ml-auto"><a class="" href="{{ admin_url('contractor/registration') }}" role="button">
                     Contractor Registration
                </a></span>
            </div>

        </div>

        <div class="row mb-2 text-center">
            <div class="col-md-12">
                <input type="submit" value="Sign In" class="btn button-submit w-100 responsive-btn">
            </div>
        </div>
        <hr>
        {{-- <div class="form-row d-flex flex-column align-items-center mt-1 mb-5">

            <div class="d-flex justify-content-center gap-3">

                <a class="btn btn-primary" href="{{ admin_url('auth/microsoft') }}" role="button">
                    <i class="fab fa-microsoft me-2"></i> Log in with Microsoft
                </a>
                <a class="btn btn-primary" href="{{ admin_url('contractor/registration') }}" role="button">
                     Contractor Registration
                </a>
            </div>
        </div> --}}


    </form>


@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"
        integrity="sha512-a+SUDuwNzXDvz4XrIcXHuCf089/iJAoN4lmrXJg18XnduKK6YlDHNRalv4yd1N40OKI80tFidF+rqTFKGPoWFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" nonce="ardhasscript">
        $.validator.addMethod("passwordPolicy", function(value, element) {
            return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/.test(value);
        }, "Password should be Alphanumeric with 1 symbol, small, caps, minimum 8 characters.");

        $('#password_view').on('click', function() {
            var passInput = $("#password");
            var eyeIcon = $(this).find('span.fa');

            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passInput.attr('type', 'password');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        function generateHashPassword() {

            var passwordField = document.getElementById("password");
            var encryptedPassword = CryptoJS.AES.encrypt(passwordField.value, 'secret').toString();
            passwordField.value = encryptedPassword;

        }

        $(function() {
            $('#loginform').validate({
                rules: {
                    username: {
                        required: true,
                        'alphanumeric': true,

                    },
                    password: {
                        required: true,
                        'minlength': 8,
                        'maxlength': 20,
                        //passwordPolicy: true,

                    },
                },
                messages: {
                    username: {
                        required: "Please enter your User ID",
                        alphanumeric: "Please enter only alphanumeric",
                    },
                    password: {
                        required: "Please enter your Password",
                        maxlength: "Maximum character limit reached",
                    },
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    // generateHashPassword();
                    form.submit();
                }
            });
        });
    </script>
@endpush
