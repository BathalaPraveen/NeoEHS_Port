@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('menu', 'dashboard')
@section('pageurl', admin_url('dashboard'))

@push('style')
    <style>
        .customers-contacts span {
            font-size: 16px;
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #eeecec;
            text-align: center;
            border-radius: 50%;
            color: #2b2a2a;
        }

        .customers-list {
            position: relative;
            height: 400px;
        }

        #uaucChart .highcharts-color-0 {
            fill: #00ff00;
            stroke: #00ff00;
        }

        #uaucChart .highcharts-data-label-color-0 text {
            fill: black !important;
        }

        #uaucChart .highcharts-color-1 {
            fill: green;
            stroke: green;
        }

        #uaucChart .highcharts-data-label-color-1 text {
            fill: white !important;
        }

        #uaucChart .highcharts-color-2 {
            fill: yellow;
            stroke: yellow;
        }

        #uaucChart .highcharts-data-label-color-2 text {
            fill: black !important;
        }

        #uaucChart .highcharts-color-3 {
            fill: #ff0000;
            stroke: #ff0000;
        }

        #uaucChart .highcharts-data-label-color-3 text {
            fill: white !important;
        }

        .chart-wrapper {
            position: relative;
            overflow-x: auto;
            display: flex;
            flex-direction: column;
            /* stack children vertically */
        }

        .apexcharts-canvas {
            order: 2;
            /* push chart canvas below toolbar */
        }

        #custom-toolbar .apexcharts-toolbar {
            order: 1;
            /* move toolbar before chart */
            align-self: flex-end;
            /* stick it to the right */
            position: sticky !important;
            top: 0;
            z-index: 10;
            transform: none !important;
            /* override ApexCharts inline transform */
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="container para mt-3">
            <div class=" ">

                @if (CheckUserRole(ROLE_SUPERADMIN))

                    <div class="position-relative">
                        <h5 class="card-title text-white">Operating Management</h5>
                    </div>
                    <div class="row gy-4">
                        <div class="">
                            <div class="row">
                                <div class="col-12 col-xl-12 ">
                                    <div class=" ">
                                        <div class="row row-cols-7 row-cols-md-7 row-cols-xl-7 p-2">
                                            @foreach ($masterLink as $link)
                                                <div class="col">
                                                    <a href="{{ admin_url($link['link']) }}">
                                                        <div class="card radius-10">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="mb-0 text-secondary font-weight-bold">
                                                                            {{ $link['name'] }}</p>
                                                                        <h6 class="my-1">{{ $link['count'] }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif


                @if (!CheckUserRole(ROLE_CONTRACTORUSER) && !CheckUserRole(ROLE_CONTRACTORADMIN))
                    <div class="ms-auto d-flex justify-content-end">
                        <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-info mt-3"
                            id="searchicon"><i class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip"
                                title="Search"></i>
                        </button>
                    </div>

                    <div id="search" class="collapse bg-white rounded p-3 mt-3 mb-3">
                        <form action="">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="company">Company</label>
                                            <select class="form-select select2" name="company" id="company">
                                                <option value="">Select Company</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ $company->id }}">
                                                        {{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="division">Division</label>
                                            <select class="form-select select2" name="division" id="division">
                                                <option value="">Select Division</option>
                                                @foreach ($divisionDetails as $division)
                                                    <option value="{{ $division->id }}">
                                                        {{ $division->division_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="department">Department</label>
                                            <select class="form-select select2" name="department" id="department">
                                                <option value="">Select Department</option>
                                                @foreach ($departmentDetails as $department)
                                                    <option value="{{ $department->id }}">
                                                        {{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="location" class="form-label">Location Name</label>
                                            <select name="location" id="location" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Location</option>
                                                @foreach ($locationDetails as $location)
                                                    <option value="{{ $location->id }}">
                                                        {{ $location->location_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="spec_location" class="form-label">Specific Location Name</label>
                                            <select name="spec_location" id="spec_location" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Specific Location</option>
                                                @foreach ($specificlocationDetails as $spec_location)
                                                    <option value="{{ $spec_location->id }}">
                                                        {{ $spec_location->specific_loc_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="year" class="form-label">Year</label>
                                            <input type="text" name="year" id="year" class="form-control">
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="month" class="form-label">Month</label>
                                            <input type="text" name="month" id="month" class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <button type="button" id="searchform"
                                                class="btn btn-primary mt-4">Search</button>
                                            <button type="reset" id="resetform" class="btn btn-danger mt-4">reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>
                    <div class="position-relative mb-2 mt-1">
                        <h5 class="card-title text-white">UAUC</h5>
                    </div>
                    <div class="row">


                        {{-- <div class="col-md-5 mb-3">
                            <div class="col">
                                <div class="card radius-10 shadow-sm">
                                    <div class="card-body">
                                        <p class="mb-1 text-secondary fw-bold ">Total UAUC Count</p>
                                        <div id="uaucCard" class="">
                                            <h6 class="mb-0">{{ $uauc_total_count ?? 0 }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-12 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-1 text-secondary fw-bold text-center">Total UAUC Count</p>
                                    <div id="uaucPieChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-1 text-secondary fw-bold text-center">UAUC Count Based On UAUC Category
                                    </p>
                                    <div id="uaucCategoryChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-1 text-secondary fw-bold text-center">UAUC Count Based On Corrective
                                        Action
                                    </p>
                                    <div id="correctiveActionChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body chart-wrapper"
                                    style="width: 100%; overflow-x: auto; position: relative;">

                                    <!-- Custom Toolbar -->
                                    
                                    
                                    <p class="mb-1 text-secondary fw-bold text-center">
                                        UAUC Count Based On HSE Hazard
                                    </p>
                                    <div id="custom-toolbar" class="d-flex justify-content-end mb-2"></div>

                                    <div id="HseHazardChart"></div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-1 text-secondary fw-bold text-center">UAUC Count Based On ZeFAChart</p>
                                    <div id="ZeFAChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="card radius-10 shadow-sm">
                                <div class="card-body">
                                    <p class="mb-1 text-secondary fw-bold text-center">UAUC Count Based On
                                        InfringementChart</p>
                                    <div id="InfringementChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card ">
                                <div id="uaucChart"></div>
                            </div>
                        </div>

                    </div>

                    <div class="position-relative mb-3 mt-2">
                        <h5 class="card-title text-white">PTW</h5>
                    </div>


                @endif

                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="card ">
                            <div id="ptwchart"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-xl-12 ">
                        <div class="card d-flex">
                            <div class="row row-cols-1 row-cols-md-4 row-cols-xl-4 p-2">
                                @foreach ($ptw_card_data as $card)
                                    <div class="col">
                                        <div class="card radius-10">
                                            <div class="card-header">
                                                <div class="bg-style-ones">{{ $card['name'] }}</div>
                                            </div>

                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div id="{{ $card['id'] }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection



@push('script')
    <script type="text/javascript">
        function initializeUAUCPieChart(count) {
            var options = {
                series: [count],
                chart: {
                    type: 'pie',
                    height: 350,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true
                        }
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            let selectedCorrectiveAction = config.dataPointIndex +
                                1;

                            let filters = {
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();

                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },
                labels: ['UAUC Count'],
                colors: ['#007bff'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var uaucChart = new ApexCharts(document.querySelector("#uaucPieChart"), options);
            uaucChart.render();
        }

        function initializeUAUCCategoryChart(seriesData) {
            var options = {
                series: seriesData,
                chart: {
                    type: 'pie',
                    height: 300,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true
                        }
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            let selectedCategory = config.dataPointIndex +
                                1;

                            let filters = {
                                category: selectedCategory,
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();

                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },
                labels: ['Safe Act', 'Safe Condition', 'Unsafe Act', 'Unsafe Condition'],
                colors: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var uaucChart = new ApexCharts(document.querySelector("#uaucCategoryChart"), options);
            uaucChart.render();
        }


        function initializeUAUCHSCHazardChart(data) {
            var container = document.querySelector("#HseHazardChart");

            // Chart width calculation
            var totalBars = data.labels.length;
            var barWidth = 60; // Adjust bar width
            var calculatedWidth = totalBars * barWidth;

            // Use full chart width, not container width
            var chartWidth = calculatedWidth;

            var options = {
                series: [{
                    name: "Hazard Count",
                    data: data.series
                }],
                chart: {
                    type: 'bar',
                    height: 500,
                    width: chartWidth, // force chart width larger than container
                    toolbar: {
                        show: true
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            let filters = {
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();
                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50px',
                        distributed: true
                    }
                },
                xaxis: {
                    categories: data.labels,
                    labels: {
                        rotate: -40,
                        trim: false,
                        style: {
                            fontSize: '12px'
                        },
                        formatter: function(value) {
                            return value.length > 25 ? value.substring(0, 20) + '...' : value;
                        }
                    },
                    title: {
                        text: "HSE Hazards"
                    }
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#1E88E5', '#D32F2F', '#388E3C', '#FBC02D', '#8E24AA', '#E64A19', '#1976D2', '#C2185B',
                    '#7B1FA2', '#F57C00'
                ],
                legend: {
                    position: 'bottom'
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                }
            };

            // Wrap chart inside a scrollable container
            container.innerHTML = ""; // clear previous chart if any
            container.style.overflowX = "auto";
            container.style.whiteSpace = "nowrap";

            // Create inner div to hold chart
            var chartWrapper = document.createElement("div");
            chartWrapper.style.display = "inline-block";
            chartWrapper.style.width = chartWidth + "px";

            container.appendChild(chartWrapper);

            var hseHazardChart = new ApexCharts(chartWrapper, options);
            hseHazardChart.render().then(() => {
                const toolbar = document.querySelector("#HseHazardChart .apexcharts-toolbar");
                if (toolbar) {
                    document.querySelector("#custom-toolbar").appendChild(toolbar);
                }
            });
        }


        function initializeCorrectiveActionChart(seriesData) {
            var options = {
                series: seriesData,
                chart: {
                    type: 'pie',
                    height: 300,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true
                        }
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {
                            let selectedCorrectiveAction = config.dataPointIndex +
                                1;

                            let filters = {
                                corrective_action: selectedCorrectiveAction,
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();

                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },

                labels: ['Stop Work', 'Immediate Action / Intervention', 'Issue Safety Security Demerit System (SSDS)',
                    'Recommendation'
                ],
                colors: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var uaucChart = new ApexCharts(document.querySelector("#correctiveActionChart"), options);
            uaucChart.render();
        }

        function initializeUAUCZeFAChart(data) {
            var container = document.querySelector("#ZeFAChart");
            var totalBars = data.labels.length;
            var barWidth = 50;
            var minChartWidth = container.clientWidth;
            var calculatedWidth = totalBars * barWidth;

            var chartWidth = Math.max(minChartWidth, calculatedWidth);

            var options = {
                series: [{
                    name: "ZeFA Count",
                    data: data.series
                }],
                chart: {
                    type: 'bar',
                    height: 500,
                    width: chartWidth,
                    toolbar: {
                        show: true
                    },
                    padding: {
                        bottom: 10
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {

                            let filters = {
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();

                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50px',
                        distributed: true
                    }
                },
                xaxis: {
                    categories: data.labels,
                    title: {
                        text: "ZeFA analysis",
                    },
                    labels: {
                        trim: false,
                        style: {
                            fontSize: '12px'
                        },
                        rotate: -40,
                        maxHeight: 230,
                        formatter: function(value) {
                            return value.length > 25 ? value.substring(0, 20) + '...' : value;
                        }
                    }

                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#1E88E5', '#D32F2F', '#388E3C', '#FBC02D', '#8E24AA', '#E64A19', '#1976D2', '#C2185B',
                    '#7B1FA2', '#F57C00'
                ],
                legend: {
                    position: 'bottom',
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            container.style.overflowX = "auto";
            container.style.whiteSpace = "nowrap";
            container.style.width = "100%";
            container.style.minWidth = chartWidth + "px";
            container.style.height = "auto";

            var hseHazardChart = new ApexCharts(container, options);
            hseHazardChart.render();
        }

        function initializeUAUCInfringementChart(data) {
            var container = document.querySelector("#InfringementChart");
            var totalBars = data.labels.length;
            var barWidth = 50;
            var minChartWidth = container.clientWidth;
            var calculatedWidth = totalBars * barWidth;

            var chartWidth = Math.max(minChartWidth, calculatedWidth);

            var options = {
                series: [{
                    name: "Infringement Count",
                    data: data.series
                }],
                chart: {
                    type: 'bar',
                    height: 500,
                    width: chartWidth,
                    toolbar: {
                        show: true
                    },
                    padding: {
                        bottom: 10
                    },
                    events: {
                        dataPointSelection: function(event, chartContext, config) {

                            let filters = {
                                company: $("#company").val(),
                                division: $("#division").val(),
                                department: $("#department").val(),
                                location: $("#location").val(),
                                spec_location: $("#spec_location").val(),
                                year: $("#year").val(),
                                month: $("#month").val()
                            };

                            let queryParams = new URLSearchParams(filters).toString();

                            window.location.href = `{{ url('atar/uauc/list') }}?${queryParams}`;
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50px',
                        distributed: true
                    }
                },
                xaxis: {
                    categories: data.labels,
                    title: {
                        text: "Infringement",
                    },
                    labels: {
                        trim: false,
                        style: {
                            fontSize: '12px'
                        },
                        rotate: -40,
                        maxHeight: 230,
                        formatter: function(value) {
                            return value.length > 25 ? value.substring(0, 20) + '...' : value;
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#1E88E5', '#D32F2F', '#388E3C', '#FBC02D', '#8E24AA', '#E64A19', '#1976D2', '#C2185B',
                    '#7B1FA2', '#F57C00'
                ],
                legend: {
                    position: 'bottom',
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            container.style.overflowX = "auto";
            container.style.whiteSpace = "nowrap";
            container.style.width = "100%";
            container.style.minWidth = chartWidth + "px";
            container.style.height = "auto";

            var hseHazardChart = new ApexCharts(container, options);
            hseHazardChart.render();
        }

        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
            fetchUAUCCharts();
        });

        function fetchUAUCCharts(filters = {}) {
            let urls = [{
                    url: "{{ admin_url('uauc/chart/getUAUCCountChartData') }}",
                    callback: initializeUAUCPieChart,
                    container: "#uaucPieChart"
                },
                {
                    url: "{{ admin_url('uauc/chart/getUAUCCategoryChartData') }}",
                    callback: initializeUAUCCategoryChart,
                    container: "#uaucCategoryChart"
                },
                {
                    url: "{{ admin_url('uauc/chart/getHSCHazardChartData') }}",
                    callback: initializeUAUCHSCHazardChart,
                    container: "#HseHazardChart"
                },
                {
                    url: "{{ admin_url('uauc/chart/getCorrectiveActionChartData') }}",
                    callback: initializeCorrectiveActionChart,
                    container: "#correctiveActionChart"
                },
                {
                    url: "{{ admin_url('uauc/chart/getZeFAChartData') }}",
                    callback: initializeUAUCZeFAChart,
                    container: "#ZeFAChart"
                },
                {
                    url: "{{ admin_url('uauc/chart/getInfringementData') }}",
                    callback: initializeUAUCInfringementChart,
                    container: "#InfringementChart"
                }
            ];

            urls.forEach(({
                url,
                callback,
                container
            }) => {
                $.ajax({
                    url: url,
                    type: "GET",
                    data: filters,
                    success: function(response) {
                        if (response.success) {
                            $(container).html("");
                            callback(response.data);
                        }
                    },
                    error: function() {
                        alert("Error fetching chart data");
                    }
                });
            });
        }

        $("#searchform").click(function() {
            let filters = {
                company: $("#company").val(),
                division: $("#division").val(),
                department: $("#department").val(),
                location: $("#location").val(),
                spec_location: $("#spec_location").val(),
                year: $("#year").val(),
                month: $("#month").val()
            };

            fetchUAUCCharts(filters);
        });

        $("#resetform").click(function() {
            $("form")[0].reset();
            fetchUAUCCharts();
        });


        $('.owl-carousel').owlCarousel({
            autoplay: true,
            autoplayTimeout: 2000,
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

        @if (!CheckUserRole(ROLE_CONTRACTORUSER) && !CheckUserRole(ROLE_CONTRACTORADMIN))
            Highcharts.chart('uaucChart', {
                chart: {
                    type: 'column',
                    styledMode: true
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Location wise UAUC'
                },
                xAxis: {
                    categories: ['{!! array_to_string($Chartdata['label'], "','") !!}'] // Location
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total UAUC'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                        }
                    }
                },
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    x: 0,
                    y: 0,
                    colorByPoint: true,
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        },

                    }
                },
                series: [{
                        name: '{{ UAUC_SA_NAME }}',
                        data: [{{ array_to_string($Chartdata['data']['safeact']['data'], ',') }}],


                    }, {
                        name: '{{ UAUC_SC_NAME }}',
                        data: [{{ array_to_string($Chartdata['data']['safecont']['data'], ',') }}],

                    },
                    {
                        name: '{{ UAUC_USA_NAME }}',
                        data: [{{ array_to_string($Chartdata['data']['unsafeact']['data'], ',') }}],

                    },
                    {
                        name: '{{ UAUC_USC_NAME }}',
                        data: [{{ array_to_string($Chartdata['data']['unsafecont']['data'], ',') }}],

                    }
                ],

            });

            Highcharts.chart('ptwchart', {
                chart: {
                    type: 'column',
                    styledMode: true,

                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Location wise PTW'
                },
                xAxis: {
                    categories: ['{!! array_to_string($PTWChartdata['label'], "','") !!}'] // Location
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total PTW'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                        }
                    }
                },
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    x: 0,
                    y: 0,
                    colorByPoint: true,
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        },

                    }
                },
                series: [{
                        name: 'Sub Work Permit Approval Pending',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_SP_PENDING]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'Area Owner Approval pending',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_AO_PENDING]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'Area Owner Rejected',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_AO_REJECTED]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'GHSE Approval pending',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_GHSE_PENDING]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'GHSE Rejected',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_GHSE_REJECTED]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'Supervising Authority Approval pending',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_SA_PENDING]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'Supervising Authority Rejected',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_SA_REJECTED]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'PTW Approved',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_PTW_APPROVED]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'PTW Expired',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_PTW_EXPIRED]['data'], ',') }}
                        ],
                    },
                    {
                        name: 'PTW Closed',
                        data: [
                            {{ array_to_string($PTWChartdata['data'][PERMIT_STATUS_PTW_CLOSED]['data'], ',') }}
                        ],
                    },
                ],

            });

            @foreach ($ptw_card_data as $data)

                var options = {
                    series: [{{ array_to_string($data['chartdata']) }}],
                    chart: {
                        foreColor: '#9a9797',
                        height: 300,
                        type: 'donut',
                        events: {
                            dataPointSelection: function(event, chartContext, config) {

                                window.location.href = '{{ admin_url('ptw/' . $data['id'] . '/list') }}';
                                // if(config.dataPointIndex == 1){

                                // }

                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        show: true,
                    },
                    plotOptions: {
                        pie: {
                            customScale: 0.8,
                            donut: {
                                size: '80%',
                                labels: {
                                    show: false,
                                    name: {
                                        show: true,
                                        name: "test",
                                    },
                                    value: {
                                        show: true
                                    },
                                }

                            }
                        }
                    },
                    colors: ["#FFC72C", "#3184ab", "#50b839", "#f30000"],
                    dataLabels: {
                        enabled: false
                    },
                    labels: ['Not Approved', 'Pending Work', 'Closed', 'Expired'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            },
                            plotOptions: {
                                pie: {
                                    customScale: 1,
                                }
                            },
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#{{ $data['id'] }}"), options);
                chart.render();
            @endforeach
        @endif
    </script>
@endpush
