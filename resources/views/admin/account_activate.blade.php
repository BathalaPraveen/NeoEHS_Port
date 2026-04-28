@extends('layouts.login')
@section('title', 'Account Activate')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-10 col-sm-12 mx-auto mt-5">
                @if ($status == 'not_activate')
                    <form id="ActivateAccountform" action="{{ admin_url('SubmitAccountActivate') }}" method="post"
                        autocomplete="false">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">
                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        <div class="card-body p-4">
                            <div class="text-center">
                                <a href="#"><img class="w-20" src="{{ asset('public/assets/images/Glice_bg.png') }}"
                                        alt=""></a>
                                <p class="text-secondary mt-2 mb-4 fs-5"><i>Welcome to <b>Glice</b> Offer Tool</i></p>
                            </div>
                            <h1 class="text-center">Activate your Account</h1>
                            <div class="row">
                                <div class="col-10 validate-input">
                                    <div class="position-relative re_field">
                                        <p class="form-control rounded-pill bg-secondary pull-right">{{ $email }}</p>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 validate-input">
                                    <div class="position-relative re_field">
                                        <input type="password" name="password" class="form-control rounded-pill pull-right"
                                            id="password" placeholder="New Password" required autocomplete="off">

                                    </div>
                                    @error('password')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 validate-input">
                                    <div class="position-relative re_field">
                                        <input type="password" name="password-confirm" class="form-control rounded-pill"
                                            id="confirm_password" placeholder="Confirm Password" required
                                            autocomplete="off">
                                    </div>
                                    @error('password-confirm')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="px-4 btn btn-success btn-skew ms-2"><span
                                        class="fs-7">Submit</span></button>
                                <a href="{{ url('login') }}"> <button type="button"
                                        class="px-4 btn btn-primary btn-skew ms-2"><span
                                            class="fs-7">Cancel</span></button></a>
                            </div>
                        </div>
                    </form>
                @else
                    <div>
                        <div class="card-body p-4">
                            <div class="text-center">
                                <a href="#"><img class="w-20" src="{{ asset('public/assets/images/Glice_bg.png') }}"
                                        alt=""></a>
                                <p class="text-secondary mt-2 mb-4 fs-5"><i>Welcome to <b>Glice</b> Offer Tool</i></p>
                                <h2>Your account is already activated</h2>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url('login') }}"><button type="button"
                                    class="px-4 btn btn-primary btn-skew ms-2"><span class="fs-7">Log
                                        In</span></button></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </form>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            $('#ActivateAccountform').validate({
                rules: {
                    password: {
                        required: true,
                        passcheck: true,
                    },
                    'password-confirm': {
                        required: true,
                        equalTo: "#password",
                        passcheck: true,
                    },
                },
                messages: {
                    password: {
                        required: "Please enter a New Password",
                        passcheck: "Password should be alphanumeric, case sensitive with minimum of 12 characters"
                    },
                    'password-confirm': {
                        required: "Please enter a Confirm Password",
                        equalTo: "Mismatch of New and Confirm Password",
                        passcheck: "Password should be alphanumeric, case sensitive with minimum of 12 characters"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.re_field').append(error);
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
