@extends('layouts.login')
@section('title', 'Password Reset')
@section('content')

    <div class="card-body">
        <div class="p-5">
            <div class="text-start row">
                <div class="col-md-12" style="text-align: center;">
                    <img src="{{ url('public/assets/images/logo-mini.png') }}" style="width:100px;" alt="">
                </div>
                <img src="{{ url('public/assets/images/logo_full.png') }}" class="w-100" alt="">
            </div>
            <br>
            <p class="text-muted">Please enter the password</p>
            <form class="needs-validation" id="loginform" action="{{ admin_url('password/finalreset/submit') }}"
                method="post" autocomplete="false">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3 mt-5 validate-input">
                    <label class="form-label">Password</label>
                    <div class="input-group date form-input">
                        <input type="password" required="" class="form-control password" id="password" name="password" placeholder="Enter the password">
                        <div class="input-group-addon input-group-text password_view" >
                            <span style="color:#0053a1" class="fa fa-eye"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-5 validate-input">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group date form-input">
                        <input type="password" required="" class="form-control password" id="confirmpassword"
                            name="confirmpassword" placeholder="Enter the confirm password">
                        <div class="input-group-addon input-group-text password_view" >
                            <span style="color:#0053a1" class="fa fa-eye"></span>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary ">Submit</button>
                </div>
                <div class="d-grid gap-2 mt-3 ">
                    <a class="text-end text-opacity-75 text-black" href="{{ admin_url('login') }}">Login</a>
                </div>

                <div class="pt-3">

                    <div style="text-align: right">
                        Powered by <img style="width: 100px;" src="{{ url('public/assets/images/logo-img.jpg') }}"
                            alt="">
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('script')
    <script type="text/javascript" nonce="ardhasscript">
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
                },
                "Password must contain a minimum of 8 alphanumeric characters with a combination of uppercase, lowercase, number and symbol."
                );

            $('#loginform').validate({
                rules: {

                    password: {
                        required: true,
                        passwordPolicy: true
                    },
                    confirmpassword: {
                        required: true,
                        passwordPolicy: true,
                        equalTo: "#password",
                    },
                },
                messages: {

                    password: {
                        required: "Please enter your Password",

                    },
                    confirmpassword: {
                        required: "Please enter your confirm Password",
                        equalTo : "Please enter the same Password"
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
                }
            });
        });
    </script>
@endpush
