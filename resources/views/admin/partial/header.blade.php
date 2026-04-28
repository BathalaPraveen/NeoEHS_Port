<!doctype html>
<html lang="en" class="color-sidebar">

<head>

    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ url('public/assets/images/Logo-Mini.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ url('public/assets/plugins/notifications/css/lobibox.min.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/segoe-fonts@1.0.1/segoe-fonts.min.css" rel="stylesheet">

    <link href="{{ url('public/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/css/icons.css') }}" rel="stylesheet">


    <link href="{{ url('public/assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet" />

    <link href="{{ url('public/assets/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/segoe-fonts@1.0.1/segoe-fonts.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css"
        integrity="sha512-VUj0sZbQFPixq7NJ6ioBRK/scakfsdlKl647mLmZaZHWPgpnrWvIfy80/QF3q1l+kozBc8IHrTEoiZY25PSUTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css"
        integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css"
        integrity="sha512-BB0bszal4NXOgRP9MYCyVA0NNK2k1Rhr+8klY17rj4OhwTmqdPUQibKUDeHesYtXl7Ma2+tqC6c7FzYuHhw94g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.min.css"
        integrity="sha512-MT4B7BDQpIoW1D7HNPZNMhCD2G6CDXia4tjCdgqQLyq2a9uQnLPLgMNbdPY7g6di3hHjAI8NGVqhstenYrzY1Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="{{ url('public/assets/css/style.css?time=' . time()) }}" rel="stylesheet">

    <style>
        .datatable-list td {
            word-wrap: break-word;
        }
    </style>

    @stack('style')

    <script>
        var baseurl = "@yield('pageurl')"
    </script>

</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        @include('admin.partial.left_menu')

        @include('admin.partial.menu')
