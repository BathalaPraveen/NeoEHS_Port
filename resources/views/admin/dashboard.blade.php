@extends('admin.layouts.layout')
@section('title', 'Dashboard')
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
    </style>
@endpush

@section('content')

   <div class="container">
        <div class="container para mt-3">

            <!-- Slider -->
            <div class="card mainCard">
                <div class="row">
                    <div class="col-md-12" style="height: 100%;width:100%;">
                        <div class="owl-carousel owl-theme">

                            @foreach ($sliderImage as $image)
                                <div class="item">
                                    <h4><img src="{{ url($image->file_path) }}" alt="image" /></h4>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>

            @if (CheckUserRole(ROLE_ADMIN))
                <div class="card mainCard">
                    <div class="position-relative">
                        <h5 class="card-title">Operating Management</h5>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 ">
                            <div class="card d-flex">
                                <div class="row row-cols-1 row-cols-md-4 row-cols-xl-4 p-2">
                                    @foreach ($masterLink as $link)
                                        <div class="col">
                                            <a href="{{ admin_url($link['link']) }}">
                                                <div class="card radius-10">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary font-weight-bold">
                                                                    {{ $link['name'] }}</p>
                                                                <h4 class="my-1">{{ $link['count'] }}</h4>
                                                            </div>
                                                            <div class="{{ $link['icon_color'] }} ms-auto font-35"><i
                                                                    class="{{ $link['icon'] }}"></i>
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
                <div class="card mainCard">
                    <div class="position-relative">
                        <h5 class="card-title">UAUC</h5>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 ">
                            <div class="card d-flex">
                                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 p-2">
                                    @foreach ($rightcardDetails as $link)
                                        <a href="{{ $link['url'] }} ">
                                            <div class="col">
                                                <div class="card radius-10">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">{{ $link['name'] }}</p>
                                                                <h4 class="my-1">{{ $link['count'] }}</h4>
                                                            </div>
                                                            <div class="{{ $link['icon_color'] }} ms-auto font-35"><i
                                                                    class="{{ $link['icon'] }}"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="card ">
                            <div id="uaucChart"></div>
                        </div>
                    </div>
                </div>

                <div class="card mainCard">
                    <div class="position-relative">
                        <h5 class="card-title">PTW</h5>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12 ">
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
            @endif
        </div>
    </div>

@endsection



@push('script')
    <script src="{{ url('public/assets/plugins/highcharts/js/highcharts.js') }}"></script>
    <script src="{{ url('public/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            autoHeight: false,
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

        @if (CheckUserRole(ROLE_ADMIN))
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
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    // backgroundColor: 'red' || 'white',
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
