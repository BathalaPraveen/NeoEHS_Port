@extends('layouts.login')
@section('title', 'Forgot Password')
@section('content')

    <div class="card-body">
        <div class="p-5">

            <h6>Password Reset</h6>
            <p>Enter your User ID to reset the password</p>
            <form class="needs-validation" id="loginform" action="{{ admin_url('password/forgot/submit') }}" method="post"
                autocomplete="false">
                @csrf
                <div class="mb-3 mt-5 validate-input">
                    <label class="form-label">User ID</label>
                    <input required="" type="text" name="username" id="username" class="form-control error"
                        placeholder="Enter the User ID" aria-invalid="true">

                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary ">Send OTP</button>
                </div>
                <div class="d-grid gap-2 mt-3 ">
                    <a class="text-end text-opacity-75 text-black" href="{{ admin_url('login')}}">Login</a>
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
                    username: {
                        required: true,
                        'alphanumeric': true,

                    },

                },
                messages: {
                    username: {
                        required: "Please enter your User ID",
                        alphanumeric: "Please enter only alphanumeric",
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
