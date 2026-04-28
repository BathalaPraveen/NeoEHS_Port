@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('menu', 'hsebulletin')
@section('pageurl', admin_url('dashboard'))

@section('content')
    <div class="container">
        <div class="container para mt-5">
            <div class="container mt-5">
                <div class="row gy-4">
                    <!-- Slider -->
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="owl-carousel owl-theme">

                                    @foreach ($sliderImage as $image)
                                        <div class="1">
                                            <h4><img src="{{ url($image->file_path) }}" alt="image" /></h4>
                                        </div>
                                    @endforeach
                                </div>
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
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
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
    </script>
@endpush
