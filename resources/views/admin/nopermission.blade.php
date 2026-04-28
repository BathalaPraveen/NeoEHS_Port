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
            min-height: 140px;
            display: grid;
        }

        .menu-header {
            display: block;
            /* justify-content: space-between;
                    align-items: center; */
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

        .error-content {
            color: white;
            font-size: 40px;
            text-align: center;
            display: block;
            margin: 10%;
            margin-bottom: 10px;
        }
        .home-link-div{
            text-align: center;
        }
        .home-link-div a{
            font-size: 18px;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="row justify-content-left" data-aos="zoom-out">
            <div class="col-xl-12 text-left">
                <p class="error-content ">You do not have permission to access this page. Please contact your Administrator for support.</p>
                <div class="home-link-div">
                    <a href="{{ admin_url('home') }}">
                    <button class="btn btn-primary">Home</button>
                </a>

                </div>

            </div>
        </div>
    </div>

@endsection
@push('script')
    <script></script>
@endpush
