<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <!--Icon-->

    <link rel="icon" href="{{ url('public/assets/theme/img/favicon.png') }}" type="image/x-icon" />
    <!-- loader-->

    <link href="{{ url('public/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ url('public/assets/css/pace.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ url('public/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/css/icons.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        html,
        body {
            height: 100%;
            margin: 0;

        }

        .select2 {
            width: 100% !important;
        }

        .leftimage {
            height: auto;
            width: auto;
            display: block;
            margin: auto;
        }

        .button-submit {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
            background-color: #262b66;
            color: white;
        }

        .footercontnet {
            bottom: 0;
            position: absolute;

        }

        ::placeholder {
            background-color: #cccccc;
        }

        /* or, for legacy browsers */

        ::-webkit-input-placeholder {
            background-color: #cccccc;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            background-color: #cccccc;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            background-color: #cccccc;
        }

        :-ms-input-placeholder {
            background-color: #cccccc;
        }

        @media only screen and (max-width: 600px) {
            .leftimage {
                display: none;
            }

            form {
                padding: 15px;
            }

            html,
            body {
                height: auto;
                margin: 0;
                overflow: auto;
            }
        }

        /* For screens between 600px and 900px */
        @media only screen and (min-width: 600px) and (max-width: 900px) {
            .leftimage {
                display: none;
            }

            form {
                padding: 15px;
            }

            html,
            body {
                height: auto;
                margin: 0;
                overflow: auto;
            }

            #formside {
                width: 100% !important;
            }
        }

        /* For screens larger than 900px */
        @media only screen and (min-width: 900px) {}
    </style>
    @stack('style')


</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <div class="row">
            <div class="col-md-8" style="background: #f7f9fb;">
                <img src="{{ url('public/assets/images/login-images/bg_1.jpg') }}" style=""
                    class="leftimage w-100" alt="">
            </div>
            <div class="col-md-4" id="formside">
                <div class="row">
                    <div class="col-md-11">
                        <div class="row">
                            <div class="logo-row col-md-12 text-center">
                                <img src="{{ url('public/assets/images/login-images/login_logo.png') }}" alt="logo"
                                    class="logo" style="margin-top: 20px;width:90px;">
                            </div>
                            <div class="logo-row col-md-12 text-center">
                                <img src="{{ url('public/assets/images/login-images/Logo.png') }}" alt="logo"
                                    class="logo" style="margin-top: 10px; margin-bottom: 20px;width:180px;">
                            </div>
                        </div>

                        <h5 class="text-center">
                            <strong>Health, Safety &amp; Environment (HSE)<br>Management System</strong>
                        </h5>
                        @yield('content')

                        <div class="row" style="font-size:10px;">
                            <div class="col-md-6">
                                <p style="">
                                    <img src="{{ url('public/assets/images/login-images/logoFinal.png') }}"
                                        style="width: 50px"> Powered By NeoEHS
                                </p>
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <div class="text-right">
                                    <p class="copy right">Copyright &copy; 2024 Reserved.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--plugins-->
    <script src="{{ url('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('public/assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ url('public/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ url('public/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
        integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript" nonce="ardhasscript">
        $(document).ready(function() {

            $('.select2').select2();


            $("#show_hide_password a").on('click', function(event) {
                alert('test');
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });

        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });


        @if ($message = Session::get('success'))
            toastMixin.fire({
                icon: 'success',
                animation: true,
                title: '{{ $message }}'
            });
        @endif

        @if ($message = Session::get('error'))
            toastMixin.fire({
                icon: 'error',
                animation: true,
                title: '{{ $message }}',
            });
        @endif
    </script>

    @stack('script')

</body>

</html>
