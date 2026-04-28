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

        .hero {
            width: 100%;
            min-height: auto;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px 0 40px 0;
            overflow: hidden;
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
    </style>

    @stack('style')

    <script>
        var baseurl = "@yield('pageurl')"
    </script>

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="{{ admin_url('home') }}" class="logo d-flex align-items-center ">

                <img src="{{ url('public/assets/theme/img/logo.png') }}" alt="">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ admin_url('home') }}"
                            class="@if (View::yieldContent('menu') == 'home') active @endif">Home<br></a></li>
                    <li><a href="{{ admin_url('dashboard') }}"
                            class="@if (View::yieldContent('menu') == 'dashboard') active @endif">Dashboard</a></li>
                    <li><a href="{{ admin_url('announcement') }}"
                            class="@if (View::yieldContent('menu') == 'announcement') active @endif">Announcement</a></li>
                    <li><a href="{{ admin_url('hsebulletin') }}"
                            class="@if (View::yieldContent('menu') == 'hsebulletin') active @endif">HSE Bulletin</a></li>
                    {{-- <li class="dropdown"><a href="#"
                            class="@if (View::yieldContent('menu') == 'userguide') active @endif"><span>User Guide</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ admin_url('home') }}" download>uauc_guide.pdf</a></li>
                            <li><a href="{{ admin_url('home') }}" download>ptw_guide.pdf</a></li>
                            <li><a href="{{ admin_url('home') }}" download>hiradc_guide.pdf</a></li>
                        </ul>
                    </li> --}}

                    @if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_IT_ADMIN) || CheckUserRole(ROLE_HSEUSER))
                        <li class="dropdown"><a href="#"
                                class="@if (View::yieldContent('menu') == 'settings') active @endif"><span>Settings</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="{{ admin_url('settings/slider') }}">Slider</a></li>
                                <li><a href="{{ admin_url('settings/announcement/list') }}">Announcement</a></li>
                                @if (CheckUserRole(ROLE_SUPERADMIN) || CheckUserRole(ROLE_ADMIN) || CheckUserRole(ROLE_IT_ADMIN))
                                    <li class="dropdown"><a href="#"
                                            class="@if (View::yieldContent('menu') == 'userguide') active @endif"><span>Administration</span>
                                            <i class="bi bi-chevron-right toggle-dropdown"></i></a>
                                        <ul>
                                            <li class="dropdown"><a href="#"><span>Location Master</span><i
                                                        class="bi bi-chevron-right toggle-dropdown"></i></a>
                                                <ul>
                                                    <li><a href="{{ admin_url('location/list') }}">Location
                                                            Management</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('specificlocation/list') }}">Specific
                                                            Location
                                                            Master</a></li>
                                                </ul>
                                            </li>

                                            <li class="dropdown"><a href="#"><span>Company Master</span><i
                                                        class="bi bi-chevron-right toggle-dropdown"></i></a>
                                                <ul>
                                                    <li><a href="{{ admin_url('company/list') }}">Company Master</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('division/list') }}">Division Master</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('department/list') }}">Department
                                                            Master</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="dropdown"><a
                                                    href="{{ admin_url('designation/list') }}">Designation Master</a>
                                            </li>

                                            <li class="dropdown"><a href="#"><span>Employee Master</span><i
                                                        class="bi bi-chevron-right toggle-dropdown"></i></a>
                                                <ul>
                                                    <li><a href="{{ admin_url('employee/list') }}">List Employee</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('employee/add') }}">Add Employee</a>
                                                    </li>
                                                </ul>
                                            </li>

                                            <li class="dropdown"><a href="#"><span>Contractor Master</span><i
                                                        class="bi bi-chevron-right toggle-dropdown"></i></a>
                                                <ul>
                                                    <li><a href="{{ admin_url('contractor/company/list') }}">Contractor
                                                            Company</a></li>
                                                    <li><a href="{{ admin_url('contractor/list') }}">List
                                                            Contractor</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('contractor/add') }}">Add Contractor</a>
                                                    </li>

                                                </ul>
                                            </li>

                                            <li class="dropdown"><a href="#"><span>User Master</span><i
                                                        class="bi bi-chevron-right toggle-dropdown"></i></a>
                                                <ul>
                                                    <li><a href="{{ admin_url('user/role/list') }}">User Role</a></li>
                                                    <li><a href="{{ admin_url('user/permission/list') }}">User
                                                            Permission</a>
                                                    </li>
                                                    <li><a href="{{ admin_url('userlog/list') }}">User Log</a></li>
                                                    <li><a href="{{ admin_url('uploadlog/list') }}">Upload Log</a>
                                                    </li>
                                                    @if (CheckUserRole(ROLE_SUPERADMIN))
                                                        <li><a href="{{ admin_url('employee/change_details') }}">Change
                                                                Employee Details</a></li>
                                                    @endif
                                                </ul>
                                            </li>

                                            <li class="dropdown"><a href="{{ admin_url('work_type/list') }}">Work
                                                    Type
                                                    Master</a>
                                            </li>
                                            <li class="dropdown"><a
                                                    href="{{ admin_url('activity_type/list') }}">Activity
                                                    type Master</a>
                                            </li>

                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if ($unreadCount > 0)
                                <span class="alert-count">{{ $unreadCount }}</span>
                            @endif
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifications</p>
                                    @if ($unreadCount > 0)
                                        <a class="msg-header-clear ms-auto"
                                            href="{{ admin_url('notification/readall') }}">
                                            <p>Marks all as read</p>
                                        </a>
                                    @endif
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @if (count($notification_list) > 0)
                                    @foreach ($notification_list as $notification)
                                        <a class="dropdown-item"
                                            href="{{ admin_url('notification/view/' . encryptId($notification['id'])) }}"
                                            @if ($notification['read_status'] == 0) style="background-color: #ccc" @endif>
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary">
                                                    <img class="w-100 p-2" src="{{ $notification['icon'] }}"
                                                        alt="">
                                                </div>
                                                <div class="flex-grow-1" style="text-wrap: wrap;">
                                                    <p class="msg-info ">{{ $notification['title'] }}
                                                        <span
                                                            class="msg-time float-end">{{ $notification['time'] }}</span>
                                                    </p>
                                                    <p class="msg-info">{{ $notification['message'] }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="mt-5" style="text-align: center">
                                        <h6> We couldn't fint any notification</h6>
                                    </div>

                                @endif

                            </div>
                            @if (count($notification_list) > 0)
                                <a href="{{ admin_url('notification/list') }}">
                                    <div class="text-center msg-footer">View All Notifications</div>
                                </a>
                            @endif
                        </div>
                    </li>

                </ul>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret ms-2"
                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ url(profileImage(Auth::id())) }}" class="user-img" alt="user avatar"
                        style="width: 30px;">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0"> {{ Auth::user()->name }} </p>
                        <p class="designattion mb-0">{{ Auth::user()?->user_designation_name }} </p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href=" {{ admin_url('profile') }} "><i
                                class="bx bx-user"></i><span>Profile</span></a></li>

                    </li>
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href=""
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                        <form id="logout-form" action="{{ admin_url('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>

        </div>


    </header>

    <main class="main">
        <section id="hero" class="hero section">
            <img id="bgimagefixed" src="{{ url('public/assets/theme/img/hero-bg-abstract.png') }}" alt=""
                data-aos="fade-in" class="">
            @yield('content')
        </section>


        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <footer class="page-footer">
            <p class="mb-0">Copyright &copy; {{ date('Y') }} All Rights Reserved. <span style="float: right">
                    Powered By <img style="width:80px" src="{{ url('public/assets/images/logo-img.jpg') }}"
                        alt="">
                </span></p>

        </footer>

        <div id="preloader"></div>

        <!----- popup starts----->
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
    </main>

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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function datepickercall() {
            $(".datepicker").datepicker({

                'format': "dd-mm-yyyy",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
                'startDate': '{{ todayDate() }}',
            });

            $(".alldatepicker").datepicker({
                'format': "dd-mm-yyyy",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
            });

            $(".todaymaxdatepicker").datepicker({

                'format': "dd-mm-yyyy",
                'autoclose': true,
                'orientation': 'bottom',
                'todayHighlight': true,
                'endDate': '{{ todayDate() }}',
            });

            const today = new Date();
            const formatDate = (date) => {
                const day = ('0' + date.getDate()).slice(-2);
                const month = ('0' + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${day}-${month}-${year}`;
            };
        }


        const today = new Date();
        const minFromDate = new Date(2024, 6, 1);

        $("#from_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "bottom",
            todayHighlight: true,
            startDate: minFromDate,
            endDate: today
        }).on("changeDate", function(e) {
            const fromDate = e.date;

            $("#to_date").datepicker("setStartDate", fromDate);

            const maxToDate = new Date(fromDate);
            maxToDate.setMonth(maxToDate.getMonth() + 3);

            const finalMaxDate = maxToDate > today ? today : maxToDate;

            $("#to_date").datepicker("setEndDate", finalMaxDate);

            $('#to_date').val('');
        });

        $("#to_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "bottom",
            todayHighlight: true
        });


        function getEndDate(fromdate, addValue, type = {{ ADD_DATE }}, endDate = "") {

            var fromdate = moment(fromdate, 'DD-MM-YYYY').toDate();

            var currentDateTarget = new Date(fromdate);
            var futureDateTarget = new Date(fromdate);

            if (type === 1) {
                addValue = addValue - 1;
                futureDateTarget.setDate(currentDateTarget.getDate() + addValue);
            } else if (type === 2) {
                futureDateTarget.setMonth(currentDateTarget.getMonth() + addValue);
            } else if (type === 3) {
                futureDateTarget.setFullYear(currentDateTarget.getFullYear() + addValue);
            } else {
                return null;
            }

            if (endDate != '') {
                var endDate = moment(endDate, 'DD-MM-YYYY').toDate();
                if (endDate && futureDateTarget > new Date(endDate)) {

                    futureDateTarget = new Date(endDate);
                }
            }

            var day = futureDateTarget.getDate();
            var month = futureDateTarget.getMonth() + 1;
            var year = futureDateTarget.getFullYear();

            if (day < 10) {
                day = "0" + day;
            }

            if (month < 10) {
                month = "0" + month;
            }

            var formattedDate = day + "-" + month + "-" + year;

            return formattedDate;
        }

        function timepickercall() {

            $(".clockpicker").clockpicker({
                twelvehour: true,
                placement: 'bottom',
                autoclose: true,
                donetext: 'Done',
                'default': 'now'
            });
        }

        $('#year').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true
        });

        $('#month').datepicker({
            format: "M",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true
        });


        function datetimepickercall() {

            $(".datetimepicker").datetimepicker({
                format: 'dd-mm-yyyy hh:ii',
                autoclose: true,
                todayHighlight: true,
                minuteStep: 5,
            });
        }

        $(document).ready(function() {

            $('.select2').select2();

            datepickercall();
            timepickercall();
            datetimepickercall();

            $(function() {

                $.fn.datepicker.dates["en"] = {
                    days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
                        "Saturday"
                    ],
                    daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                    daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                    months: ["January", "February", "March", "April", "May", "June", "July", "August",
                        "September", "October", "November", "December"
                    ],
                    monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                        "Nov", "Dec"
                    ],
                    today: "Today",
                    clear: "Clear",
                    format: "dd-mm-yyyy",
                    titleFormat: "MM yyyy",
                    weekStart: 0,
                };

            });

            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            })

            $('button[type="reset"]').on('click', function() {

                $('.select2').each(function() {
                    var $select = $(this);

                    setTimeout(function() {
                        $select.trigger('change');
                    }, 0);
                });

                var form = $(this).closest('form');
                form.validate().resetForm();
                form[0].reset();
            });

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

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
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
                    title: '{{ $message }}',
                    showCloseButton: true,
                });
            @endif

            @if ($message = Session::get('error'))
                toastMixin.fire({
                    icon: 'error',
                    animation: true,
                    title: '{{ $message }}',
                    showCloseButton: true,
                });
            @endif
        });
    </script>

    @stack('script')

    <script>
        $(document).on('click', '.popupwindow', function(e) {
            e.preventDefault();
            $('#popupwindowmodal').modal('show').find('.modal-content').load($(this).attr('href'));
        });
    </script>
</body>

</html>

