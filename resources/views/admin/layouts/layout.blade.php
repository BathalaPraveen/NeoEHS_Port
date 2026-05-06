<!DOCTYPE html>
<html lang="en">

<head>
    <title>BEACON | @yield('title') </title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ url('public/assets/theme/img/favicon.png') }}" rel="icon">
    <link href="{{ url('public/assets/theme/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link href="{{ url('public/assets/theme/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/theme/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/theme/vendor/aos/aos.css" rel="stylesheet') }}">
    <link href="{{ url('public/assets/theme/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/assets/theme/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css" />

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
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

    <link href="{{ url('public/assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />

    <link href="{{ url('public/assets/css/style.css?time=' . time()) }}" rel="stylesheet">
    <link href="{{ url('public/assets/theme/css/main.css') }}" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}"> --}}

    <style>
        .datatable-list td {
            word-wrap: break-word;
        }

        .user-info .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #413c3c;
        }

        .user-info .designattion {
            font-size: 13px;
            color: #a9a8a8;
        }

        .user-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 0 solid #e5e5e5;
            padding: 0;
        }

        .alert-count {
            position: absolute;
            top: 5px;
            left: 10px;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
            background: #f62718;
        }

        .navmenu,
        .navbar-offcanvas {
            width: auto;
            height: auto;
            border-width: 1px;
            border-style: none;
            border-radius: 4px;
        }

        .bx.bx-bell {
            font-size: 24px;
        }

        .header-message-list,
        .header-notifications-list {
            position: relative;
            height: 360px;
            overflow: scroll;
        }





        #navmenu {
            font-family: 'Roboto' !important;
        }

        * {
            font-family: 'Roboto';
        }

        .menu-item .icon {
            width: 35px;
            background: #fbb54936;
            height: 34px;
            border-radius: 20px;
            text-align: center;
            color: #e78d02;
            position: static;
            float: right;
        }

        .clockpicker-popover {
            position: absolute;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #e9ecef;
            opacity: 1;
        }

        .card-bottom .btn-danger {
            margin-right: 1rem;
        }

        .fa.fa-dot-circle-o {
            font-size: 12px !important;
            color: red !important;
        }

        .select2 {
            width: 100% !important;
        }

        .container-bg {
            background-color: #79b9e7;
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .container-bg h6 {
            color: #fff;
            font-weight: bold;
            margin: 6px 15px;
            font-family: sans-serif
        }


        .sub-menu {
            max-height: 420px;
            overflow-y: auto;
        }

        .sub-menu::-webkit-scrollbar {
            width: 5px;
        }

        .sub-menu::-webkit-scrollbar-thumb {
            background-color: #e78b0286;
            border-radius: 4px;
            cursor: pointer;
        }

        .sub-menu::-webkit-scrollbar-thumb:hover {
            background-color: #e78b02;
        }

        .hero {
            width: 100%;
            min-height: auto;
            position: relative;
        }

        /* Main content wrapper: dedicated class to avoid hero conflicts */
        .main-content-wrapper.page-wrapper {
            display: block;
            padding: 0 0 60px 0 !important;
            overflow: visible !important;
            min-height: calc(100vh - 60px);
            margin-top: 40px !important;
        }

        /* Make background image decorative only, never affect layout */
        .main-content-wrapper #bgimagefixed {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            pointer-events: none;
        }

        /* Keep page content above background image */
        .main-content-wrapper>*:not(#bgimagefixed) {
            position: relative;
            z-index: 1;
        }

        /* Keep content naturally aligned from top-left */
        .main-content-wrapper .container,
        .main-content-wrapper .container-fluid,
        .main-content-wrapper .page-content {
            margin-top: 0 !important;
        }

        /* Topbar should be first row without extra top gap */
        html,
        body,
        .wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        #header.header,
        #header.topbar-fixed {
            margin-top: 0 !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100%;
            position: fixed !important;
            z-index: 1002;
        }

        /* Top bar style - match NeoEHS reference */
        #header.topbar-fixed {
            background: #ffffff !important;
            border-bottom: 1px solid #dfe6f4 !important;
            padding: 0 !important;
            min-height: 58px;
            height: 58px;
            box-shadow: none !important;
        }

        #header.topbar-fixed .container-fluid {
            max-width: 100% !important;
            padding: 0 14px !important;
            height: 58px;
        }

        #header.topbar-fixed .logo img {
            max-height: 44px !important;
            width: auto;
            margin-right: 6px !important;
        }

        #header.topbar-fixed .toggle-icon {
            color: #253a78 !important;
            font-size: 18px;
            margin-right: 10px !important;
            margin-left: 4px !important;
        }

        #header.topbar-fixed #navmenu>ul {
            gap: 6px;
        }

        #header.topbar-fixed #navmenu>ul>li>a {
            color: #1f2a44 !important;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 14px !important;
            border-radius: 8px;
            line-height: 1.2;
        }

        #header.topbar-fixed #navmenu>ul>li>a.active,
        #header.topbar-fixed #navmenu>ul>li>a:hover {
            background: #2ea84d !important;
            color: #ffffff !important;
        }

        #header.topbar-fixed .top-menu .nav-link {
            color: #1f2a44 !important;
        }

        #header.topbar-fixed .user-box .user-name {
            color: #24355f;
            font-size: 14px;
            font-weight: 600;
        }

        #header.topbar-fixed .user-box .designattion {
            color: #8b94a8;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        #header.topbar-fixed .user-img {
            width: 30px !important;
            height: 30px !important;
        }

        /* NeoEHS-like left menu style */
        .sidebar-wrapper {
            background: linear-gradient(180deg, #06215f 0%, #041741 100%) !important;
            border-right: 0 !important;
            box-shadow: none !important;
            width: 250px !important;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            top: 59px !important;
            height: calc(100vh - 50px) !important;
            bottom: auto !important;

            /* ✨ premium effect */
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.4);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sidebar-wrapper .simplebar-mask,
        .sidebar-wrapper .simplebar-content-wrapper,
        .sidebar-wrapper .simplebar-content {
            background: transparent !important;
        }

        .neo-sidebar-header {
            display: none !important;
        }

        .neo-brand {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        .neo-brand-icon {
            width: 36px !important;
            min-width: 36px;
            height: 36px;
            object-fit: contain;
        }

        .neo-brand-text {
            width: auto;
            max-width: calc(100% - 40px);
            height: 34px;
            object-fit: contain;
        }

        .neo-sidebar-header .toggle-icon {
            color: #d4defe !important;
            font-size: 20px;
        }

        .main-menu {
            margin-top: 0;
            padding: 10px 8px 80px 4px;
            list-style: none;
            height: calc(100vh - 66px) !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch;
        }

        .main-menu::-webkit-scrollbar {
            width: 6px;
        }

        .main-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 10px;
        }

        .main-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-wrapper .simplebar-content {
            padding-top: 0 !important;
        }

        .sidebar-wrapper .simplebar-content-wrapper {
            overflow-x: hidden !important;
        }

        .main-menu .slide {
            margin-bottom: 3px;
            margin-left: 0 !important;
            padding-left: 0 !important;
        }

        .main-menu>.slide.has-sub {
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 2px;
            transition: all .2s ease;
        }

        .main-menu .side-menu__item,
        .main-menu .leftmenu-master,
        .main-menu .leftmenu-color {
            border-radius: 8px;
            color: #e8ecff !important;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s ease;
        }

        .main-menu .side-menu__item {
            min-height: 38px;
            padding: 7px 10px 7px 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            flex-wrap: wrap;
        }

        .main-menu .side-menu__item i.side-menu__angle {
            order: 10;
            margin-left: auto;
            margin-right: 0;
            font-size: 18px !important;
            width: auto;
            height: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #b9c8ff;
            transition: transform .3s cubic-bezier(0.4, 0.0, 0.2, 1), color .3s ease;
            flex-shrink: 0;
        }

        .main-menu>.slide>.side-menu__item {
            margin-left: 0 !important;
        }

        .main-menu .side-menu__item img {
            width: 18px;
            height: 18px !important;
            margin-right: 0 !important;
            object-fit: contain;
        }

        .main-menu .side-menu__label {
            line-height: 1.2;
            white-space: normal;
            flex: 1;
        }

        .main-menu .side-menu__angle {
            margin-left: auto;
            margin-right: 2px;
            color: #b9c8ff;
            font-size: 16px;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(0deg);
            transition: transform .3s cubic-bezier(0.4, 0.0, 0.2, 1);
            flex-shrink: 0;
        }

        .main-menu .slide.has-sub>.side-menu__item .side-menu__angle {
            transform: rotate(-180deg);
        }

        .main-menu .slide.has-sub.open>.side-menu__item .side-menu__angle {
            transform: rotate(0deg);
            color: #ffffff;
        }


        .main-menu>.slide.has-sub.open {
            border-color: rgba(255, 255, 255, 0.28);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .main-menu .slide-menu {
            margin: 4px 0 6px 0;
            padding: 3px 0 2px 12px;
            border-left: 1px solid rgba(255, 255, 255, 0.15);
            background: transparent !important;
            border-radius: 0;
        }

        /* Keep submenus collapsed by default; open only when active/toggled */
        .main-menu .slide.has-sub>.slide-menu {
            display: none;
        }

        .main-menu .slide.has-sub.open>.slide-menu,
        .main-menu .slide.has-sub.active>.slide-menu {
            display: block;
        }

        .main-menu>.slide.has-sub.open>.slide-menu {
            margin: 6px 6px 6px 4px;
            padding: 6px 4px 4px 10px;
            border-left: 2px solid rgb(78 227 126 / 70%);
            background: #5f8f7b !important;
            border-radius: 8px;
            color: #eaf5ef !important;
        }

        .main-menu>.slide.has-sub.open>.slide-menu,
        .main-menu>.slide.has-sub.open>.slide-menu a,
        .main-menu>.slide.has-sub.open>.slide-menu .slides,
        .main-menu>.slide.has-sub.open>.slide-menu .slides a {
            color: #eaf5ef !important;
        }

        .main-menu .leftmenu-master {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 10px;
            margin: 0;
            min-height: 36px;
            width: 100%;
        }

        .main-menu .leftmenu-master .side-menu__angle {
            margin-left: auto;
            margin-right: 2px;
            color: #b9c8ff;
            font-size: 16px;
            width: auto;
            height: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            /* Child arrow: closed state = left */
            transform: rotate(-90deg);
            transition: transform .3s cubic-bezier(0.4, 0.0, 0.2, 1), color .3s ease;
            flex-shrink: 0;
        }

        .main-menu .slide.has-sub.open>.leftmenu-master .side-menu__angle {
            /* Child arrow: open state = right */
            transform: rotate(90deg);
            color: #ffffff;
        }

        .main-menu .leftmenu-color {
            padding: 0;
            margin: 0;
            background: transparent !important;
        }

        .main-menu .leftmenu-color .slides {
            list-style: none;
            margin: 0;
            padding: 7px 10px !important;
            border-radius: 8px;
            font-size: 13px;
            color: #d9e3ff;
            line-height: 1.25;
            min-height: 34px;
            display: flex;
            align-items: center;
        }

        .main-menu .side-menu__item:hover,
        .main-menu .leftmenu-master:hover,
        .main-menu .leftmenu-color:hover .slides {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
        }

        .main-menu .leftmenu-color.active .slides,
        .main-menu .leftmenu-color.active .slides a,
        .main-menu .slide-menu .leftmenu-color.active,
        .main-menu .slide-menu .leftmenu-color.active a,
        .main-menu>.slide.active>.side-menu__item,
        .main-menu>.slide.open>.side-menu__item {
            background: #22a447 !important;
            color: #ffffff !important;
            box-shadow: 0 6px 14px rgba(25, 104, 51, 0.35);
        }

        .main-menu .leftmenu-color.active .slides,
        .main-menu .leftmenu-color.active .slides a {
            font-weight: 600;
        }

        .main-menu .slides.ms-2 {
            margin-left: 0 !important;
        }

        .main-menu .slide.has-sub.p-2 {
            padding: 0 !important;
        }

        .main-menu a {
            text-decoration: none !important;
        }

        .main-menu .slide-menu .slide-menu {
            margin-left: 8px;
            padding-left: 10px;
            border-left-color: rgba(255, 255, 255, 0.1);
            background: #6fa892 !important;
            color: #ffffff !important;
            border-radius: 8px !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper {
            width: 64px !important;
            top: 76px !important;
            height: calc(100vh - 66px) !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .page-wrapper {
            margin-left: 64px !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .topbar,
        .wrapper.toggled:not(.sidebar-hovered) .page-footer {
            left: 64px !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper .neo-brand-text {
            display: none;
        }

        .wrapper.toggled:not(.sidebar-hovered) .sidebar-wrapper .neo-brand {
            width: auto;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__label,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .leftmenu-master span,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .leftmenu-color .slides {
            display: none;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu {
            padding: 10px 6px 14px 6px;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .slide,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .slide.has-sub,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .slide.has-sub.p-2 {
            margin: 0 0 6px 0 !important;
            padding: 0 !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__item {
            justify-content: center;
            padding: 8px 0 !important;
            gap: 0;
            min-height: 40px;
            width: 100%;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__angle,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .leftmenu-master .side-menu__angle,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .slide-menu {
            display: none !important;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__item .menu-db-icon,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__item i,
        .wrapper.toggled:not(.sidebar-hovered) .main-menu .leftmenu-master .menu-db-icon {
            margin: 0 !important;
            font-size: 18px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper.toggled:not(.sidebar-hovered) .main-menu .side-menu__item img {
            margin: 0 !important;
        }

        .welcome-content {
            color: #ffffff !important;
            font-size: 18px;
            margin-bottom: 0 !important;
        }

        .welcome-content-last {
            margin-bottom: 2rem !important;
        }

        .green-line {
            display: inline-block;
            width: 40px;
            /* length of line */
            height: 4px;
            /* thickness */
            background-color: #4caf50;
            /* green color */
            margin-right: 10px;
            vertical-align: middle;
            border-radius: 2px;
        }

        .dropdown-open {
            display: block;
            top: 57px;
            width: 100%;
        }

        #userDropdownMenu {
            display: none;
            position: absolute;
            top: 57px;
            right: 0;
            width: 220px;
            z-index: 9999;
        }

        #userDropdownMenu.show {
            display: block;
        }
    </style>

    @stack('style')

    <script>
        var baseurl = "@yield('pageurl')"
    </script>

</head>

<body>

    <!-- Start Switcher -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header border-bottom d-block p-0">
            <div class="d-flex align-items-center justify-content-between p-3">
                <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <nav class="border-top border-block-start-dashed">
                <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
                    <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-home" type="button" role="tab" aria-controls="switcher-home"
                        aria-selected="true">Theme Styles</button>
                    <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
                        data-bs-target="#switcher-profile" type="button" role="tab"
                        aria-controls="switcher-profile" aria-selected="false">Theme Colors</button>
                </div>
            </nav>
        </div>
        <div class="offcanvas-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active border-0" id="switcher-home" role="tabpanel"
                    aria-labelledby="switcher-home-tab" tabindex="0">
                    <div class="">
                        <p class="switcher-style-head">Theme Color Mode:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-light-theme">
                                        Light
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style"
                                        id="switcher-light-theme" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-dark-theme">
                                        Dark
                                    </label>
                                    <input class="form-check-input" type="radio" name="theme-style"
                                        id="switcher-dark-theme">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Directions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-ltr">
                                        LTR
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction"
                                        id="switcher-ltr" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-rtl">
                                        RTL
                                    </label>
                                    <input class="form-check-input" type="radio" name="direction"
                                        id="switcher-rtl">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Navigation Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-vertical">
                                        Vertical
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style"
                                        id="switcher-vertical" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-horizontal">
                                        Horizontal
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-style"
                                        id="switcher-horizontal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="navigation-menu-styles">
                        <p class="switcher-style-head">Vertical & Horizontal Menu Styles:</p>
                        <div class="row switcher-style gx-0 pb-2 gy-2">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-click">
                                        Menu Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-menu-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-hover">
                                        Menu Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-menu-hover">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-click">
                                        Icon Click
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-icon-click">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-hover">
                                        Icon Hover
                                    </label>
                                    <input class="form-check-input" type="radio" name="navigation-menu-styles"
                                        id="switcher-icon-hover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidemenu-layout-styles">
                        <p class="switcher-style-head">Sidemenu Layout Styles:</p>
                        <div class="row switcher-style gx-0 pb-2 gy-2">
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-default-menu">
                                        Default Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-default-menu" checked>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-closed-menu">
                                        Closed Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-closed-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icontext-menu">
                                        Icon Text
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-icontext-menu">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-icon-overlay">
                                        Icon Overlay
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-icon-overlay">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-detached">
                                        Detached
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-detached">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-double-menu">
                                        Double Menu
                                    </label>
                                    <input class="form-check-input" type="radio" name="sidemenu-layout-styles"
                                        id="switcher-double-menu">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Page Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-regular">
                                        Regular
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles"
                                        id="switcher-regular" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-classic">
                                        Classic
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles"
                                        id="switcher-classic">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-modern">
                                        Modern
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-styles"
                                        id="switcher-modern">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Layout Width Styles:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-sm-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-full-width">
                                        Full Width
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width"
                                        id="switcher-full-width" checked>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-boxed">
                                        Boxed
                                    </label>
                                    <input class="form-check-input" type="radio" name="layout-width"
                                        id="switcher-boxed">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Menu Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions"
                                        id="switcher-menu-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-menu-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="menu-positions"
                                        id="switcher-menu-scroll">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Header Positions:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-fixed">
                                        Fixed
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions"
                                        id="switcher-header-fixed" checked>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-header-scroll">
                                        Scrollable
                                    </label>
                                    <input class="form-check-input" type="radio" name="header-positions"
                                        id="switcher-header-scroll">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <p class="switcher-style-head">Loader:</p>
                        <div class="row switcher-style gx-0">
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-enable">
                                        Enable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader"
                                        id="switcher-loader-enable">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check switch-select">
                                    <label class="form-check-label" for="switcher-loader-disable">
                                        Disable
                                    </label>
                                    <input class="form-check-input" type="radio" name="page-loader"
                                        id="switcher-loader-disable" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade border-0" id="switcher-profile" role="tabpanel"
                    aria-labelledby="switcher-profile-tab" tabindex="0">
                    <div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Menu Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Light Menu" type="radio" name="menu-colors"
                                        id="switcher-menu-light">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Dark Menu" type="radio" name="menu-colors"
                                        id="switcher-menu-dark" checked>
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Color Menu" type="radio" name="menu-colors"
                                        id="switcher-menu-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Gradient Menu"
                                        type="radio" name="menu-colors" id="switcher-menu-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Menu"
                                        type="radio" name="menu-colors" id="switcher-menu-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Menu dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Header Colors:</p>
                            <div class="d-flex switcher-style pb-2">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-white" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Light Header" type="radio"
                                        name="header-colors" id="switcher-header-light" checked>
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Dark Header" type="radio"
                                        name="header-colors" id="switcher-header-dark">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Color Header" type="radio"
                                        name="header-colors" id="switcher-header-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-gradient"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Gradient Header"
                                        type="radio" name="header-colors" id="switcher-header-gradient">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-transparent"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Transparent Header"
                                        type="radio" name="header-colors" id="switcher-header-transparent">
                                </div>
                            </div>
                            <div class="px-4 pb-3 text-muted fs-11">Note:If you want to change color Header dynamically
                                change from below Theme Primary color picker</div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Primary:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-1" type="radio"
                                        name="theme-primary" id="switcher-primary">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-2" type="radio"
                                        name="theme-primary" id="switcher-primary1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-3" type="radio"
                                        name="theme-primary" id="switcher-primary2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-4" type="radio"
                                        name="theme-primary" id="switcher-primary3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-primary-5" type="radio"
                                        name="theme-primary" id="switcher-primary4">
                                </div>
                                <div class="form-check switch-select ps-0 mt-1 color-primary-light">
                                    <div class="theme-container-primary"></div>
                                    <div class="pickr-container-primary" onchange="updateChartColor(this.value)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="theme-colors">
                            <p class="switcher-style-head">Theme Background:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-1" type="radio"
                                        name="theme-background" id="switcher-background">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-2" type="radio"
                                        name="theme-background" id="switcher-background1">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-3" type="radio"
                                        name="theme-background" id="switcher-background2">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-4" type="radio"
                                        name="theme-background" id="switcher-background3">
                                </div>
                                <div class="form-check switch-select me-3">
                                    <input class="form-check-input color-input color-bg-5" type="radio"
                                        name="theme-background" id="switcher-background4">
                                </div>
                                <div
                                    class="form-check switch-select ps-0 mt-1 tooltip-static-demo color-bg-transparent">
                                    <div class="theme-container-background"></div>
                                    <div class="pickr-container-background"></div>
                                </div>
                            </div>
                        </div>
                        <div class="menu-image mb-3">
                            <p class="switcher-style-head">Menu With Background Image:</p>
                            <div class="d-flex flex-wrap align-items-center switcher-style">
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img1" type="radio"
                                        name="menu-background" id="switcher-bg-img">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img2" type="radio"
                                        name="menu-background" id="switcher-bg-img1">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img3" type="radio"
                                        name="menu-background" id="switcher-bg-img2">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img4" type="radio"
                                        name="menu-background" id="switcher-bg-img3">
                                </div>
                                <div class="form-check switch-select m-2">
                                    <input class="form-check-input bgimage-input bg-img5" type="radio"
                                        name="menu-background" id="switcher-bg-img4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center canvas-footer flex-nowrap gap-2">
                    <a href="javascript:void(0);" id="reset-all" class="btn btn-danger text-nowrap">Reset</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Switcher -->


    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('assets/images/common/loader.svg') }}" alt="">
    </div>

    <div id="page-loader">
        {{-- <div class="loader-spinner"> --}}
        <img src="{{ asset('assets/images/common/loader.gif') }}" alt="" id="loader-gif">

        {{-- </div> --}}
    </div>
    <!-- Loader -->

    <div class="wrapper">

        @include('admin.partial.menu')

        @include('admin.partial.left_menu')

        <div id="hero" class="page-wrapper main-content-wrapper">
            <img id="bgimagefixed" src="{{ url('public/assets/theme/img/hero-bg-abstract.png') }}" alt=""
                data-aos="fade-in" class="">
            @yield('content')

            @include('admin.partial.footer')

        </div>

    </div>


    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow"><i class="ti ti-arrow-narrow-up fs-20"></i></span>
    </div>

    <div id="responsive-overlay"></div>
    <!-- Scroll To Top -->

    <div class="modal modal-info fade" id="popupwindowmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!----- popup ends----->

    <script src="{{ url('public/assets/theme/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/aos/aos.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ url('public/assets/theme/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ url('public/assets/theme/js/main.js') }}"></script>

    <script src="{{ url('public/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ url('public/assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ url('public/assets/plugins/notifications/js/notifications.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

    <script src="{{ url('public/assets/plugins/DataTables/datatables.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
        integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ url('public/assets/js/moment.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>



    <script src="{{ url('public/assets/js/custom-validation.js') }}"></script>
    <script src="{{ url('public/assets/js/script.js') }}"></script>

    <script src="{{ url('public/assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"
        integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"
        integrity="sha512-T+qL8JzVjquTv+yKR64v+58O+GVCe7A68gbJTzFVs76I7iAcgwisXKyOTaeKZaekcHeiG65p48NDqcMmPgnvIA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"
        integrity="sha512-1QoWYDbO//G0JPa2VnQ3WrXtcgOGGCtdpt5y9riMW4NCCRBKQ4bs/XSKJAUSLIIcHmvUdKCXmQGxh37CQ8rtZQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ url('public/assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ url('public/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ url('assets/plugins/flatpickr/flatpickr.min.js') }}"></script> --}}

    <script>
        const dropdownBtn = document.getElementById('userDropdownBtn');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        document.addEventListener('click', function() {
            dropdownMenu.classList.remove('show');
        });

        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to close nested parents that aren't in the direct active path
            function closeUnnecessaryNestedParents() {
                // Find the active menu item (leaf node)
                var activeMenuItem = document.querySelector(
                    ".main-menu .leftmenu-color.active, .main-menu .slide-menu .leftmenu-color.active");

                if (activeMenuItem) {
                    // Build the active path by traversing up from the active item
                    var activePathParents = [];
                    var current = activeMenuItem.closest("li");

                    // Traverse up the DOM tree to collect all parent .slide.has-sub elements
                    while (current) {
                        // Check if current element or its parent is a .slide.has-sub
                        var parentSlide = current.closest(".slide.has-sub");
                        if (parentSlide && activePathParents.indexOf(parentSlide) === -1) {
                            activePathParents.push(parentSlide);
                        }
                        // Move to parent
                        current = parentSlide ? parentSlide.parentElement.closest("li") : null;
                    }

                    // Now close all open nested parents that are NOT in the active path
                    document.querySelectorAll(".main-menu .slide.has-sub.open").forEach(function(openParent) {
                        var isInActivePath = activePathParents.indexOf(openParent) !== -1;

                        // If this parent is not in the active path, close it
                        if (!isInActivePath) {
                            openParent.classList.remove("open");
                            openParent.classList.remove("active");
                            // Hide its submenu
                            var submenu = openParent.querySelector(":scope > ul.slide-menu");
                            if (submenu) {
                                submenu.style.display = "none";
                            }
                        }
                    });
                } else {
                    // If no active item, close all nested parents (but keep top-level ones)
                    document.querySelectorAll(".main-menu .slide-menu .slide.has-sub.open").forEach(function(
                        nestedParent) {
                        nestedParent.classList.remove("open");
                        nestedParent.classList.remove("active");
                        var submenu = nestedParent.querySelector(":scope > ul.slide-menu");
                        if (submenu) {
                            submenu.style.display = "none";
                        }
                    });
                }
            }

            // Run on page load to fix initial state (with a small delay to ensure DOM is fully rendered)
            setTimeout(function() {
                closeUnnecessaryNestedParents();
                // Ensure only the active chain is opened initially
                var menuRoot = document.querySelector('.main-menu');
                openActiveChainWithin(menuRoot);
            }, 100);

            // Helper: when a parent is opened, ensure only the active child's ancestor chain within it is opened
            function openActiveChainWithin(container) {
                if (!container) return;
                var activeLeaf = container.querySelector('.leftmenu-color.active');
                if (!activeLeaf) return;

                // Build ancestor path within the given container
                var path = [];
                var current = activeLeaf.closest('.slide');
                while (current && container.contains(current)) {
                    var parentSlide = current.closest('.slide.has-sub');
                    if (!parentSlide || !container.contains(parentSlide)) break;
                    if (path.indexOf(parentSlide) === -1) path.push(parentSlide);
                    current = parentSlide.parentElement.closest('.slide');
                }

                // Close all descendant parents not in path
                container.querySelectorAll('.slide.has-sub').forEach(function(node) {
                    var inPath = path.indexOf(node) !== -1;
                    if (!inPath) {
                        node.classList.remove('open');
                        node.classList.remove('active');
                        var sub = node.querySelector(':scope > ul.slide-menu');
                        if (sub) sub.style.display = 'none';
                    }
                });

                // Open the path chain
                path.forEach(function(node) {
                    node.classList.add('open');
                    node.classList.add('active');
                    var sub = node.querySelector(':scope > ul.slide-menu');
                    if (sub) sub.style.display = 'block';
                });
            }

            // Attach click handlers
            document.querySelectorAll(".main-menu .slide.has-sub > a").forEach(function(menuItem) {
                menuItem.addEventListener("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var parent = this.closest(".slide.has-sub");
                    var submenu = parent ? parent.querySelector(":scope > ul.slide-menu") : null;

                    // Toggle only the clicked parent state
                    if (parent) {
                        parent.classList.toggle("open");
                        parent.classList.toggle("active");
                    }

                    // Close all descendant submenus to avoid nested auto-open
                    if (parent) {
                        parent.querySelectorAll(".slide.has-sub").forEach(function(nestedParent) {
                            if (nestedParent !== parent) {
                                nestedParent.classList.remove("open");
                                nestedParent.classList.remove("active");
                                var nestedSub = nestedParent.querySelector(
                                    ":scope > ul.slide-menu");
                                if (nestedSub) {
                                    nestedSub.style.display = "none";
                                }
                            }
                        });
                    }

                    // Optionally close sibling menus at the same level only
                    if (parent && parent.parentElement) {
                        parent.parentElement.querySelectorAll(":scope > .slide.has-sub").forEach(
                            function(sibling) {
                                if (sibling !== parent) {
                                    sibling.classList.remove("open");
                                    sibling.classList.remove("active");
                                }
                            });
                    }

                    // If theme relies on inline display toggling, handle submenu visibility explicitly
                    if (submenu) {
                        if (parent.classList.contains("open") || parent.classList.contains(
                                "active")) {
                            submenu.style.display = "block";
                            // Ensure only the active path chain within this parent is expanded
                            openActiveChainWithin(parent);
                        } else {
                            submenu.style.display = "none";
                        }
                    }
                });
            });
        });

        @if (session('trash_data') == 1)
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Not Found',
                    text: 'The data you are trying to access has been deleted.',
                    confirmButtonText: 'OK'
                });
            });
        @endif


        // $(function() {
        //     $(document).on("click", "form [type=submit]", function() {
        //         const $form = $(this).closest("form");
        //         $form.data("clicked-button", this);
        //     });

        //     $(document).on("submit", "form", function(e) {
        //         const $form = $(this);

        //         if ($form.data("isSubmitting")) {
        //             e.preventDefault();
        //             return false;
        //         }

        //         if ($form.data("validator") && !$form.valid()) {
        //             e.preventDefault();
        //             e.stopPropagation();
        //             return false;
        //         }

        //         $form.data("isSubmitting", true);

        //         const clickedButton = $form.data("clicked-button");
        //         if (clickedButton) {
        //             const $btn = $(clickedButton);
        //             if ($btn.attr("name")) {
        //                 $("<input>")
        //                     .attr({
        //                         type: "hidden",
        //                         name: $btn.attr("name"),
        //                         value: $btn.val()
        //                     })
        //                     .appendTo($form);
        //             }
        //             $btn.prop("disabled", true).text("Submitting...");
        //         }
        //     });
        // });

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, 'File size must be less than {0}');

        function checkFileExtension(input) {
            const filePath = input.value;
            const allowedExtension = /(\.xlsx)$/i;
            const fileSizeLimit = 5242880;

            // Check extension
            if (!allowedExtension.exec(filePath)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid file type',
                    text: 'Please upload an Excel file (.xlsx).',
                    confirmButtonText: 'OK'
                });
                input.value = '';
                return false;
            }

            // Check file size
            const fileSize = input.files[0].size;
            if (fileSize > fileSizeLimit) {
                Swal.fire({
                    icon: 'error',
                    title: 'File too large',
                    text: 'File size must be less than 5MB.',
                    confirmButtonText: 'OK'
                });
                input.value = '';
                return false;
            }

            return true;
        }

        function validateFileType(input) {
            const file = input?.files?.[0];
            if (!file) return;

            const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/heif', 'image/heic', 'application/pdf'];
            const allowedExtensions = ['jpeg', 'jpg', 'heif', 'heic', 'pdf'];
            const fileType = file.type.toLowerCase();
            const fileExtension = file.name.split('.').pop().toLowerCase();

            const parentDiv = input.closest(".fileinput");
            const errorMsg = parentDiv?.querySelector(".fileError");

            const isValidType = allowedMimeTypes.includes(fileType);
            const isValidExt = allowedExtensions.includes(fileExtension);

            if (!isValidType && !isValidExt) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please upload a JPG, JPEG, HEIF, HEIC, or PDF file!',
                    confirmButtonText: 'Okay'
                });
                input.value = "";
                errorMsg?.classList.remove("d-none");
            } else {
                errorMsg?.classList.add("d-none");
            }
        }

        function validateFileTypeWithoutPdf(input) {
            const file = input?.files?.[0];
            if (!file) return;

            const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/heif', 'image/heic'];
            const allowedExtensions = ['jpeg', 'jpg', 'heif', 'heic', ];
            const fileType = file.type.toLowerCase();
            const fileExtension = file.name.split('.').pop().toLowerCase();

            const parentDiv = input.closest(".fileinput");
            const errorMsg = parentDiv?.querySelector(".fileError");

            const isValidType = allowedMimeTypes.includes(fileType);
            const isValidExt = allowedExtensions.includes(fileExtension);

            if (!isValidType && !isValidExt) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please upload a JPG, JPEG, HEIF, HEIC file!',
                    confirmButtonText: 'Okay'
                });
                input.value = "";
                errorMsg?.classList.remove("d-none");
            } else {
                errorMsg?.classList.add("d-none");
            }
        }

        $.validator.addMethod("accept", function(value, element, param) {
            if (this.optional(element)) return true;
            var allowed = param.split("|");
            var ext = value.split('.').pop().toLowerCase();
            return allowed.indexOf(ext) !== -1;
        });


        $(document).ready(function() {


            $('.select2').select2();

            $('.single-select').select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });

            $('.multiple-select').select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });



            // flatpickr('.date_time', {
            //     dateFormat: 'd-m-Y H:i:S',
            //     enableTime: true,
            //     time_24hr: true,
            // });

            var startDateFromBackend = "{{ isset($start_date_from_dashboard) ? $start_date_from_dashboard : '' }}";
            var endDateFromBackend = "{{ isset($end_date_from_dashboard) ? $end_date_from_dashboard : '' }}";

            // var endDatepickersearch_filter = flatpickr('#enddatepickersearch', {
            //     dateFormat: "Y/m/d",
            //     altInput: true,
            //     altFormat: 'd-m-Y',
            //     allowInput: true,
            //     // minDate: startDateFromBackend ? new Date(startDateFromBackend) : new Date(),
            //     defaultDate: endDateFromBackend || null
            // });

            // flatpickr("#datepickersearch", {
            //     dateFormat: "Y/m/d",
            //     altInput: true,
            //     altFormat: 'd-m-Y',
            //     allowInput: true,
            //     maxDate: new Date(),
            //     defaultDate: startDateFromBackend || null,
            //     onChange: function(selectedDates) {
            //         if (selectedDates.length > 0) {
            //             var startDate = selectedDates[0];
            //             var nextDay = new Date(startDate);
            //             nextDay.setDate(nextDay.getDate() + 1);

            //             endDatepickersearch_filter.set('minDate', nextDay);
            //             endDatepickersearch_filter.clear();
            //         }
            //     }
            // });

            // var endDatepickersearch = flatpickr('.enddatepickersearch', {
            //     dateFormat: "d-m-Y",
            //     altFormat: 'd-m-Y',

            //     minDate: startDateFromBackend ? new Date(startDateFromBackend) : new Date(),
            //     defaultDate: endDateFromBackend || null
            // });

            // flatpickr(".datepickersearch", {
            //     dateFormat: "d-m-Y",
            //     altFormat: 'd-m-Y',

            //     maxDate: new Date(),
            //     defaultDate: startDateFromBackend || null,
            //     onChange: function(selectedDates) {
            //         if (selectedDates.length > 0) {
            //             var startDate = selectedDates[0];
            //             var nextDay = new Date(startDate);
            //             nextDay.setDate(nextDay.getDate() + 1);

            //             endDatepickersearch.set('minDate', nextDay);
            //             endDatepickersearch.clear();
            //         }
            //     }
            // });

            // flatpickr(".date-start-today", {
            //     dateFormat: "d-m-Y",
            //     minDate: "today",
            //     allowInput: true
            // });

            // flatpickr(".date-all", {
            //     dateFormat: "d-m-Y",
            //     allowInput: true
            // });

            // flatpickr(".date-six-month", {
            //     dateFormat: "d-m-Y",
            //     minDate: "today",
            //     maxDate: new Date(new Date().setMonth(new Date().getMonth() + 6)),
            //     allowInput: true
            // });
            // flatpickr(".date-7-days", {
            //     dateFormat: "d-m-Y",
            //     minDate: "today",
            //     maxDate: new Date().fp_incr(7), // flatpickr built-in date increment
            //     allowInput: true
            // });


            // flatpickr(".date-14days", {
            //     dateFormat: "d-m-Y",
            //     minDate: "today",
            //     maxDate: new Date(new Date().setDate(new Date().getDate() + 14)),
            //     allowInput: true
            // });

            function timepickercall() {

                $(".clockpicker").clockpicker({
                    twelvehour: true,
                    placement: 'bottom',
                    autoclose: true,
                    donetext: 'Done',
                    'default': 'now'
                });
            }

            timepickercall();
            $(".date-year").datepicker({
                'format': "yyyy",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
                'minViewMode': "years"

            });

            $(".date-month").datepicker({
                'format': "M",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
                'minViewMode': 'months'
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


            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            })

            @if ($message = Session::get('success'))
                toastMixin.fire({
                    icon: 'success',
                    animation: true,
                    title: '{{ $message }}',
                    showCloseButton: true,
                    timer: 10000,
                    timerProgressBar: true
                });
            @endif

            @if ($message = Session::get('error'))
                toastMixin.fire({
                    icon: 'error',
                    animation: true,
                    title: '{{ $message }}',
                    showCloseButton: true,
                    timer: 10000,
                    timerProgressBar: true
                });
            @endif
            @if ($message = Session::get('warning'))
                toastMixin.fire({
                    icon: 'warning',
                    animation: true,
                    title: '{{ $message }}',
                    showCloseButton: true,
                    timer: 10000,
                    timerProgressBar: true
                });
            @endif
        });
    </script>

    @stack('scripts')
    @stack('script')

</body>

</html>
