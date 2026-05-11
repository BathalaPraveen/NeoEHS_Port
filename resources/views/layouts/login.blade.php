<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <link rel="icon" href="{{ url('public/assets/theme/img/favicon.png') }}" type="image/x-icon" />

    <!-- Bootstrap -->
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ url('public/assets/css/icons.css') }}" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* font-family: 'Poppins', sans-serif; */
            min-height: 100vh;
            overflow-x: hidden;
        }

        .login-wrapper {
            width: 100%;
            min-height: 100vh;
            background: url("{{ url('public/assets/images/login-images/port_bg3.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            padding: 40px 70px;
        }

        .login-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.08);
        }

        .login-card {
            position: relative;
            z-index: 10;

            width: 100%;
            max-width: 480px;

            background: rgb(255, 255, 255);

            border-radius: 28px;

            padding: 45px;

            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.18);

            backdrop-filter: blur(10px);
        }

        .logo-area {
            margin-bottom: 10px;
        }

        .logo-area img {
            max-width: 160px;
        }

        .login-title {
            font-size: 38px;
            font-weight: 600;
            color: #222;
            margin-bottom: 30px;
        }

        .login-switch {
            display: flex;
            gap: 15px;
            margin-bottom: 28px;
        }

        .switch-btn {
            flex: 1;
            height: 60px;
            border-radius: 14px;
            border: 1px solid #dcdcdc;
            background: white;

            font-size: 20px;
            font-weight: 500;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            cursor: pointer;
            transition: 0.3s ease;
        }

        .switch-btn.active {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .form-label {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }

        .form-control:focus {
            border-color: #0d6efd;
        }

        .password-box {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 18px;
            transform: translateY(-50%);
            color: #999;
            cursor: pointer;
        }

        .forgot-link {
            text-decoration: none;
            color: #0d6efd;
            font-size: 16px;
            font-weight: 500;
        }

        .login-btn {
            width: 100%;
            height: 62px;

            border: none;
            border-radius: 14px;

            background: #0d6efd;
            color: white;

            font-size: 22px;
            font-weight: 600;

            transition: 0.3s;
        }

        .login-btn:hover {
            background: #0b5ed7;
        }

        @media(max-width: 992px) {

            .login-wrapper {
                justify-content: center;
                padding: 20px;
            }

            .login-card {
                max-width: 100%;
                padding: 30px;
            }

            .login-title {
                font-size: 30px;
            }
        }

        @media(max-width: 576px) {

            .login-card {
                padding: 24px;
                border-radius: 20px;
            }

            .login-title {
                font-size: 26px;
            }

            .switch-btn {
                font-size: 16px;
                height: 52px;
            }

            .form-control {
                height: 54px;
            }

            .login-btn {
                height: 54px;
                font-size: 18px;
            }
        }

        .button-submit {
            height: 45px;
            padding-left: 30px;
            padding-right: 30px;
            background-color: #262b66;
            color: white;
        }
    </style>

    @stack('style')

</head>

<body>

    <div class="login-wrapper">

        <div class="login-card">

            <div class="logo-area">
                <img src="{{ url('public/assets/images/port_logo.png') }}" alt="Logo">
            </div>

            @yield('content')
            <div class="row" style="font-size:10px;">
                <div class="col-md-6">
                    <p style="">
                        <img src="{{ url('public/assets/images/login-images/logoFinal.png') }}" style="width: 50px">
                        Powered By NeoEHS
                    </p>
                </div>
                <div class="col-md-6" style="text-align: right">
                    <div class="text-right">
                        <p class="copy right">Copyright &copy; 2026 Reserved.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ url('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('public/assets/js/bootstrap.bundle.min.js') }}"></script>

    @stack('script')

</body>

</html>
