@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('pageurl', admin_url('dashboard'))

@section('content')

    <div class="container">
        <div class="row justify-content-left" data-aos="zoom-out">
            <div class="col-xl-12 text-left">
                <p>Welcome to</p>
                <h1 class="heading">BEACON</h1>
                <p>HSE Management System for Bintulu Port Holdings Berhad</p>

            </div>
        </div>

        <div class="container para mt-5">
            <div class="row gy-4">
                <div class="col-md-12" data-aos="zoom-out" data-aos-delay="100">
                    <div class="icon-box">
                        <h4 class="title"><a href="">ANNOUNCEMENT</a></h4>
                        <hr>
                        <p class="side-heading">Bintulu Port Holdings Berhad officially released the HSE
                            Management System named “BEACON”</p>
                        <p class="para-1">On this very delightful day, Group Information IT has officially
                            released the highly anticipated HSE Management System. This system will provide
                            users with...</p>
                        <div class="container time">
                            <small class="text-muted">3 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row gy-4">
                    <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="100">
                        <div class="icon-box">
                            <div class="icon"><i class="bi bi-plus-circle"></i></div>
                            <h4 class="title"><a href="">HSE INSPECTION</a></h4>
                            <p class="description">HSE Checklist Inspection</p>
                        </div>
                    </div>
                    < <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="200">
                        <div class="icon-box">
                            <div class="icon"><i class="bi bi-plus-circle"></i></div>
                            <h4 class="title"><a href="">HIRADC</a></h4>
                            <p class="description">Hazard Identification, Risk Assessment, and Determining
                                Control</p>
                        </div>
                </div>

                <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-plus-circle"></i></div>
                        <h4 class="title"><a href="">PTW</a></h4>
                        <p class="description">Permit To Work</p>
                    </div>
                </div>

                <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="400">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-plus-circle"></i></div>
                        <h4 class="title"><a href="">UAUC</a></h4>
                        <p class="description">Unsafe Act Unsafe Condition</p>
                    </div>
                </div>

                <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="500">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-plus-circle"></i></div>
                        <h4 class="title"><a href="">MACHINERY</a></h4>
                        <p class="description">Machinery Certificate Administration</p>
                    </div>
                </div>

                <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="600">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-plus-circle"></i></div>
                        <h4 class="title"><a href="">CHEMICAL</a></h4>
                        <p class="description">Chemical Management</p>
                    </div>
                </div>

                <div class="col-7-custom" data-aos="zoom-out" data-aos-delay="700">
                    <div class="icon-box">
                        <div class="icon"><i class="bi bi-plus-circle"></i></div>
                        <h4 class="title"><a href="">SCHEDULE WASTE</a></h4>
                        <p class="description">Waste Management</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('script')

@endpush
