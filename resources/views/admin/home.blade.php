@extends('admin.layouts.layout')
@section('title', 'Home')
@section('menu', 'home')
@section('pageurl', admin_url('home'))

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

        .announcement-card {
            background: #f8f9fb;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* HEADER */
        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .announcement-header .left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .announcement-header i {
            color: #2ecc71;
            font-size: 18px;
        }

        .announcement-header h5 {
            margin: 0;
            font-weight: 600;
            color: #001145;
        }

        /* VIEW ALL BUTTON */
        .view-all-btn {
            background: #e6f4ea;
            color: #2e7d32;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
        }

        .view-all-btn:hover {
            background: #d4edda;
            color: #1b5e20;
        }

        .incident-view-all-btn {
            background: #f4eae6;
            color: #8e0625;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
        }

        .incident-view-all-btn:hover {
            background: #edd8d4;
            color: #7d0a0a;
        }

        /* BODY */
        .announcement-body {
            padding: 10px 5px;
        }

        .announcement-body .title {
            font-weight: 600;
            color: #001145;
            margin-bottom: 6px;
        }

        .announcement-body .desc {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
        }

        /* DATE */
        .announcement-body .date {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 10px;
            font-size: 13px;
            color: #777;
        }

        .announcement-body .date i {
            font-size: 13px;
        }

        /* ===== CARD ===== */
        .stats-card {
            background: #fff;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        /* ===== HEADER ===== */
        .stats-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-header .title {
            font-size: 14px;
            font-weight: 600;
            color: #001145;
        }

        .stats-header span {
            font-size: 12px;
            color: #777;
        }

        /* ===== ICON ===== */
        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .icon-box.red {
            background: #ff4d4f;
        }

        /* ===== BODY ===== */
        .stats-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
        }

        .stats-body h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        /* ===== CHANGE ===== */
        .change {
            font-size: 14px;
            font-weight: 600;
        }

        .change.up {
            color: #28a745;
        }

        .change.down {
            color: #dc3545;
        }

        .change small {
            display: block;
            font-size: 11px;
            color: #777;
        }

        /* ===== FOOTER ===== */
        .stats-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            font-size: 13px;
        }

        /* DOTS */
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .dot.red {
            background: #ff4d4f;
        }

        .dot.green {
            background: #28a745;
        }

        .dot.blue {
            background: #007bff;
        }

        .total-label {
            font-size: 12px;
            color: #777;
            margin-top: 2px;
        }

        .stats-card {
            animation: fadeUp 0.6s ease;
        }

        /* ===== CARD ===== */
        .recent-card {
            background: #f8f9fb;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        /* ===== HEADER ===== */
        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .recent-header .left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recent-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
        }

        /* ICON */
        .recent-header .icon {
            background: #ffeaea;
            color: #ff4d4f;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* VIEW BUTTON */
        .view-btn {
            background: #fdeaea;
            color: #ff4d4f;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            text-decoration: none;
        }

        .view-btn:hover {
            background: #ffd6d6;
        }

        /* ===== TABLE ===== */
        .recent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-table th {
            font-size: 12px;
            color: #888;
            text-align: left;
            padding: 8px 5px;
        }

        .recent-table td {
            font-size: 13px;
            padding: 8px 5px;
            border-top: 1px solid #eee;
        }

        /* ===== SEVERITY COLORS ===== */
        .severity {
            font-weight: 600;
        }

        .severity.low {
            color: #28a745;
        }

        .severity.medium {
            color: #f0ad4e;
        }

        .severity.high {
            color: #dc3545;
        }

        /* ===== STATUS ===== */
        .status {
            font-weight: 600;
        }

        /* open */
        .status.open {
            color: #dc3545;
        }

        /* closed */
        .status.closed {
            color: #28a745;
        }

        /* in progress */
        .status.in-progress {
            color: #007bff;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-left" data-aos="zoom-out">
            <div class="col-xl-12 text-left">
                <p class="welcome-content">Welcome to</p>
                <h1 class="heading">BEACON</h1>
                <p class="welcome-content welcome-content-last"><span class="green-line"></span>HSE Management System for
                    Bintulu Port Holdings Berhad</p>

            </div>
        </div>

        <div class="container para mt-2">
            <div class="row gy-4">
                <div class="col-md-8" data-aos="zoom-out" data-aos-delay="100">

                    <div class="announcement-card">

                        <!-- HEADER -->
                        <div class="announcement-header">
                            <div class="left">
                                <i class="fa-solid fa-bullhorn"></i>
                                <h5>ANNOUNCEMENT</h5>
                            </div>

                            <a href="{{ admin_url('announcement') }}" class="view-all-btn">
                                View All
                            </a>
                        </div>

                        <!-- BODY -->
                        <div class="owl-carousel owl-theme mt-3">
                            @foreach ($announcementlist as $content)
                                <div class="announcement-body">

                                    <h6 class="title">
                                        {{ $content->announcement_title }}
                                    </h6>

                                    <p class="desc">
                                        {{ $content->announcement_content }}
                                    </p>

                                    <div class="date">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($content->created_at)->format('d F Y') }}</span>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-3">

            <div class="col-md-3">
                <div class="stats-card">

                    <!-- HEADER -->
                    <div class="stats-header">
                        <div class="icon-box ">
                            <i class="fa-solid fa-triangle-exclamation fs-2 text-danger"></i>
                        </div>

                        <div class="title">
                            INCIDENT <span>(THIS MONTH)</span>
                        </div>
                    </div>

                    <!-- MAIN COUNT -->
                    <div class="stats-body">

                        <div>
                            <h2 class="counter" data-count="{{ $incidentData['current_month_count'] }}">
                                {{ $incidentData['current_month_count'] }}</h2>
                            <p class="total-label">Total Incidents</p>
                        </div>

                        <div
                            class="change  {{ $incidentData['percentage_change'] < 0 ? 'up' : ($incidentData['percentage_change'] > 0 ? 'down' : '') }}">

                            @if ($incidentData['percentage_change'] > 0)
                                ↑
                            @elseif($incidentData['percentage_change'] < 0)
                                ↓
                            @endif

                            <span class="percent-counter"
                                data-count="{{ abs($incidentData['percentage_change']) }}">{{ abs($incidentData['percentage_change']) }}</span>%
                            <small>vs last month</small>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="stats-footer">
                        <div class="status open">
                            <span class="dot red"></span>
                            Open {{ $incidentData['OpenCount'] }}
                        </div>

                        <div class="status close">
                            <span class="dot green"></span>
                            Closed {{ $incidentData['CloseCount'] }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="stats-card">

                    <!-- HEADER -->
                    <div class="stats-header">
                        <div class="icon-box ">
                            <i class="fa-solid fa-clipboard-check text-success fs-2"></i>
                        </div>

                        <div class="title">
                            INSPECTION <span>(THIS MONTH)</span>
                        </div>
                    </div>

                    <!-- MAIN COUNT -->
                    <div class="stats-body">

                        <div>
                            <h2 class="counter" data-count="{{ $inspectionData['CloseCount'] }}">
                                {{ $inspectionData['current_month_count'] }}</h2>
                            <p class="total-label">Completed</p>
                        </div>

                        <div
                            class="change  {{ $inspectionData['percentage_change'] > 0 ? 'up' : ($inspectionData['percentage_change'] < 0 ? 'down' : '') }}">

                            @if ($inspectionData['percentage_change'] > 0)
                                ↑
                            @elseif($inspectionData['percentage_change'] < 0)
                                ↓
                            @endif

                            <span class="percent-counter"
                                data-count="{{ abs($inspectionData['percentage_change']) }}">{{ abs($inspectionData['percentage_change']) }}</span>%
                            <small>vs last month</small>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="stats-footer">
                        <div class="status open">
                            <span class="dot blue"></span>
                            Planned {{ $inspectionData['current_month_count'] }}
                        </div>

                        {{-- <div class="status close">
                            <span class="dot green"></span>
                            Completed {{ $inspectionData['CloseCount'] }}
                        </div> --}}
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="stats-card">

                    <!-- HEADER -->
                    <div class="stats-header">
                        <div class="icon-box ">
                            <i class="fa-solid fa-circle-exclamation fs-2 text-warning"></i>
                        </div>

                        <div class="title">
                            UAUC <span>(THIS MONTH)</span>
                        </div>
                    </div>

                    <!-- MAIN COUNT -->
                    <div class="stats-body">

                        <div>
                            <h2 class="counter" data-count="{{ $uaucData['current_month_count'] }}">
                                {{ $uaucData['current_month_count'] }}</h2>
                            <p class="total-label">Total UAUC</p>
                        </div>

                        <div
                            class="change  {{ $uaucData['percentage_change'] < 0 ? 'up' : ($uaucData['percentage_change'] > 0 ? 'down' : '') }}">

                            @if ($uaucData['percentage_change'] > 0)
                                ↑
                            @elseif($uaucData['percentage_change'] < 0)
                                ↓
                            @endif

                            <span class="percent-counter"
                                data-count="{{ abs($uaucData['percentage_change']) }}">{{ abs($uaucData['percentage_change']) }}</span>%
                            <small>vs last month</small>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="stats-footer">
                        <div class="status open">
                            <span class="dot red"></span>
                            Open {{ $uaucData['OpenCount'] }}
                        </div>

                        <div class="status close">
                            <span class="dot green"></span>
                            Closed {{ $uaucData['CloseCount'] }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="stats-card">

                    <!-- HEADER -->
                    <div class="stats-header">
                        <div class="icon-box ">
                            <i class="fa-solid fa-file-contract fs-2 text-info"></i>
                        </div>

                        <div class="title">
                            PERMITS <span>(THIS MONTH)</span>
                        </div>
                    </div>

                    <!-- MAIN COUNT -->
                    <div class="stats-body">

                        <div>
                            <h2 class="counter" data-count="{{ $ptwData['current_month_count'] }}">
                                {{ $ptwData['current_month_count'] }}</h2>
                            <p class="total-label">Issued</p>
                        </div>

                        <div
                            class="change  {{ $ptwData['percentage_change'] > 0 ? 'up' : ($ptwData['percentage_change'] < 0 ? 'down' : '') }}">

                            @if ($ptwData['percentage_change'] > 0)
                                ↑
                            @elseif($ptwData['percentage_change'] < 0)
                                ↓
                            @endif

                            <span class="percent-counter"
                                data-count="{{ abs($ptwData['percentage_change']) }}">{{ abs($ptwData['percentage_change']) }}</span>%
                            <small>vs last month</small>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="stats-footer">
                        <div class="status open">
                            <span class="dot blue"></span>
                            Active {{ $ptwData['OpenCount'] }}
                        </div>

                        <div class="status close">
                            <span class="dot red"></span>
                            Expired {{ $ptwData['CloseCount'] }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- {!! $main_menu !!} --}}





        </div>
        <div class="row  mt-3">
            <div class="col-md-6">
                <div class="recent-card">

                    <!-- HEADER -->
                    <div class="recent-header">
                        <h5 class="mt-2">
                            <i class="fa-solid fa-shield-halved text-danger fs-3 me-2 mb-2"></i>
                            Recent Incidents
                        </h5>
                        <div class="ms-auto mt-2 mb-2">
                            <a href="{{ admin_url('incident/notification/list') }}" class="incident-view-all-btn">
                                View all
                            </a>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="recent-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($incidentDetails as $details)
                                    <tr>
                                        <td>{{ $details->incident_id }}</td>

                                        <td>{{ getIncidentTypeName($details->incident_type) }}</td>

                                        <td>{{ getIncidentItemName($details->location) }}</td>

                                        <td>{{ \Carbon\Carbon::parse($details->created_at)->format('M d, Y') }}</td>

                                        <!-- SEVERITY -->
                                        <td>
                                            @if ($details->emergency_incident_tier == 2)
                                                <span
                                                    class="text-success">{{ getIncidentItemName($details->emergency_incident_tier) }}</span>
                                            @elseif ($details->emergency_incident_tier == 1)
                                                <span
                                                    class=" text-danger">{{ getIncidentItemName($details->emergency_incident_tier) }}</span>
                                            @endif

                                        </td>

                                        <td>{!! incidentStatus($details->incident_status) !!}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="recent-card">

                    <!-- HEADER -->
                    <div class="recent-header">
                        <h5 class="mt-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger fs-3 me-2 mb-2"></i>
                            Incidents
                        </h5>
                        <div class="ms-auto mt-2 mb-2">
                            <a href="{{ admin_url('incident/notification/list') }}" class="incident-view-all-btn">
                                View all
                            </a>
                        </div>
                    </div>

                    <div id="incident_open_close"></div>

                </div>
            </div>
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

                    finalheight = parentHeight - 165;

                    $(this).closest('.menu-item').css('margin-top', -finalheight + 'px');
                    console.log(finalheight)

                }, 400);

            });

        });

        function IncidentOpenClose() {

            var url =
                '{{ admin_url('incident/notification/get-open-close') }}';
            $('#incident_open_close').html('');
            $.ajax({
                type: 'get',
                url: url,
                data: {


                },
                cache: false,
                success: function(dataAjx) {
                    $('#incident_open_close').html(dataAjx);
                },
            });
        }

        $(document).ready(function() {

            IncidentOpenClose();
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


        // Redirect to form Url

        function redirectchartUrl(id, url) {


            let form = $('<form>', {
                method: 'POST',
                action: url
            });

            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));

            form.append($('<input>', {
                type: 'hidden',
                name: 'incident_open_close_status',
                value: id
            }));


            $('body').append(form);
            form.submit();
        }
    </script>
@endpush
