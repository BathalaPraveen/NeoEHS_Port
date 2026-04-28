@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('menu', 'home')
@section('pageurl', admin_url('dashboard'))

@push('style')
    <style>
        .menu {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;

        }

        .menu p {
            color: #000000;
            margin-bottom: 1px !important;
        }

        .menu-item {
            background-color: #ffffff;
            color: #000000;
            border-radius: 8px;
            width: 160px;
            position: relative;
            height: fit-content;
            min-height: 165px;
            display: grid;
        }

        .menu-header {
            display: block;
            padding: 10px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            color: #000000;
        }

        .menu-header:hover {
            background-color: #ccc;
        }

        .icon {
            font-size: 1.5rem;
        }

        .sub-menu {
            display: none;
            padding: 5px;
        }

        .sub-menu p {
            background-color: #ffffff;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .sub-menu p:hover {

            background-color: #cccccc;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .sub-menu a {
            color: #000000 !important;
            display: block;
        }

        .anouncementcard {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px;
            overflow: hidden;
            position: relative;
            max-height: 10em;
            /* Approx height for 2 lines of text */
            transition: max-height 0.3s ease;
        }

        .content {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .hero img#bgimagefixed {
            position: fixed;
            inset: 0;
            display: grid;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        /* Parent menu styles */
        .menu {
            position: relative;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu>li {
            position: relative;
            display: inline-block;
            margin-right: 20px;
            /* Adjust spacing between parent menu items */
        }

        /* Child menu styles */
        .menu>li>ul {
            position: absolute;
            top: 0;
            left: 0;
            display: none;
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #fff;
            /* Background color for child menu */
            border: 1px solid #ccc;
            /* Border for child menu */
            z-index: 1000;
            /* Ensure child menu appears above other elements */
        }

        /* Display child menu on hover */
        .menu>li:hover>ul {
            display: block;
        }

        .menu>li>ul>li {
            position: relative;
            padding: 10px;
            /* Adjust padding for child menu items */
            white-space: nowrap;
        }

        .menu>li>ul>li a {
            display: block;
            color: #000;
            /* Text color for child menu items */
            text-decoration: none;
        }

        .menu>li>ul>li a:hover {
            background-color: #f0f0f0;
            /* Background color on hover */
        }

        /* Ensure the child menu goes to the top and bottom place is fixed */
        .menu>li>ul {
            top: auto;
            bottom: 100%;
            left: 0;
        }

        .menu-item {
            z-index: 10000;
        }

    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-left" data-aos="zoom-out">
            <div class="col-xl-12 text-left">
                <p class="welcome-content">Welcome to</p>
                <h1 class="heading">BEACON</h1>
                <p class="welcome-content">HSE Management System for Bintulu Port Holdings Berhad</p>

            </div>
        </div>

        <div class="container para mt-2">
            <div class="row gy-4">
                <div class="col-md-8" data-aos="zoom-out" data-aos-delay="100">
                    <div class="card p-3">
                        <div class="">
                            <h4 class="title p-2"
                                style="border-bottom:1px solid #ccc;color:#001145 !important;font-family: 'Roboto';">
                                ANNOUNCEMENT</h4>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel owl-theme">
                                    @foreach ($announcementlist as $content)
                                        <div class="p-2">
                                            <p class="side-heading">{{ $content->announcement_title }}</p>
                                            <p class="para-1 ">{{ $content->announcement_content }}</p>
                                            <div class="container time">
                                                <small class="text-muted">{{ timeago($content->created_at) }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class=" mt-3">

                {!! $main_menu !!}

            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $('.menu-header').click(function(event) {

                var $icon = $(this).find('.icon');
                var $subMenu = $(this).next('.sub-menu');
                $('.menu-item').css('margin-top', '0px');

                $('.sub-menu').not($subMenu).slideUp();
                $('.icon').not($icon).text('+');

                $subMenu.slideToggle();
                if ($icon.text() === '+') {
                    var orgheight = $(this).closest('.menu-item').height();
                    setTimeout(() => {
                        var parentHeight = $(this).closest('.menu-item').height();

                        finalheight = parentHeight - 165;
                        $(this).parent().css('margin-top', -finalheight + 'px');
                        console.log(finalheight)

                    }, 500);


                } else {

                    setTimeout(() => {
                        var parentHeight = $(this).closest('.menu-item').height();
                        $(this).parent().css('margin-top', '0px');
                        $('.menu-item').css('margin-top', '0px');
                        console.log(parentHeight)
                    }, 500);

                }

                $icon.text($icon.text() === '+' ? '-' : '+');


            });

            $('.menu-parent').click(function(event) {

                var $icon = $(this).find('.icon');
                var $subMenu = $(this).next('.sub-menu');

                $subMenu.slideToggle();

                 var orgheight = $(this).closest('.menu-item').height();
                    setTimeout(() => {
                        var parentHeight = $(this).closest('.menu-item').height();

                        finalheight = parentHeight - 165 ;

                        $(this).closest('.menu-item').css('margin-top', -finalheight + 'px');
                        console.log(finalheight)

                    }, 400);

            });

        });



        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            autoHeight: true,
            dots: false,
            navigation: false,
            nav: false,
            navText: ['', ''],
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    </script>
@endpush
