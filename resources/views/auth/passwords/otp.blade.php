@extends('layouts.login')
@section('title', 'Password Reset')
@section('content')

    <div class="card-body">
        <div class="p-5">

            <p class="text-muted" >Please enter the OTP</p>
            <form class="needs-validation" id="loginform" action="{{ admin_url('password/otp/submit') }}" method="post"
                autocomplete="false">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3 mt-5 validate-input">
                    <label class="form-label">OTP</label>
                    <input required="" type="text" name="otp" id="otp"  class="form-control error"
                        placeholder="Enter the OTP" aria-invalid="true">

                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary ">Submit</button>
                </div>
                <div class="d-grid gap-2 mt-3 ">
                    <a class="text-end text-opacity-75 text-black" href="{{admin_url('login')}}">Login</a>
                </div>

                <div class="pt-3">

                    <div style="text-align: right">
                        Powered by <img style="width: 100px;" src="{{ url('public/assets/images/logo-img.jpg') }}" alt="">
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('script')
    <script type="text/javascript" nonce="ardhasscript">
        $('#password_view').on('click', function() {
            var passInput = $("#password");
            if (passInput.attr('type') === 'password') {
                passInput.attr('type', 'text');
            } else {
                passInput.attr('type', 'password');
            }
        })
        $(function() {
            $('#loginform').validate({
                rules: {
                    otp: {
                        required: true,
                        number: true,


                    },

                },
                messages: {
                    otp: {
                        required: "Please enter your username",
                        number: "Please enter only alphanumeric",

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
