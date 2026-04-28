@extends('admin.layouts.layout')
@section('title', 'User View')
@section('pageurl', admin_url('user_management'))
<style type="text/css">
    .error {
        color: red;
        margin: 10px;
    }

    .fields {
        font-weight: bold;
    }
</style>
@section('content')
<!-- start page content wrapper-->
<div class="page-content-wrapper">
    <!-- start page content-->
    <div class="page-content">
        <div class="card page-breadcrumb  d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ admin_url('user_management') }}">User List</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User View</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto button-action">
                <div class="btn-group btn-skew">
                    <a class="btn btn-outline-primary" href="{{ admin_url('user_management') }}"> Back</a>
                </div>
            </div>
        </div>
        <div class="card mainCard">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="">
                        <img src="{{ getProfileImage($user_details->profile_image) }}" width="80" alt="" class="rounded-circle p-1 shadow-sm">
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $user_details->name}}</h6>
                        <p class="mb-0">{{ $user_details->email}}</p>
                    </div>
                </div>
                <hr>
                <div class="">
                    <div class="form-body">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">User Name : </label>
                                <p class="fields">{{ $user_details->name}}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact number</label>
                                <p class="fields">{{ $user_details->mobile}}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <p class="fields">{{ $user_details->email}}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <p class="fields">{{ isset($country_details->country)?$country_details->country:'' }}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content-->
</div>
@push('script')
@endpush
@stop
