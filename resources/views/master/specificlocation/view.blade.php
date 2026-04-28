@extends('admin.layouts.layout')
@section('title', 'Specific Location View')
@section('pageurl', admin_url('specificlocation/list'))

@section('style')
    <style type="text/css">
        .error {
            color: red;
            margin: 10px;
        }

        .fields {
            font-weight: bold;
        }
    </style>

@endsection

@section('content')

    <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('specificlocation/list') }}">Specific Location</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Specific Location View</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col">

                    <div class="card border-top border-0 border-4 border-primary">

                        <div class="card-body">

                            <div class="d-lg-flex align-items-center gap-3">

                                <div class="position-relative">
                                    <h5 class="card-title">Specific Location Detail View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('specificlocation/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5>Specific Location Detail </h5>
                            </div>

                            <div class="p-4 border rounded">
                                <div class="row g-3">

                                    <div class="col-md-4 form-input">
                                        <label for="location_id" class="form-label font-weight-bold">Company Name</label>
                                        <div>{{ $location->company_name }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="location_id" class="form-label font-weight-bold">Location Name</label>
                                        <div>{{ $location->location_name }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="location_id" class="form-label font-weight-bold">Specific Location
                                            ID</label>
                                        <div>{{ $location->specific_location_id }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="location_name" class="form-label font-weight-bold">Specific Location
                                            Name</label>
                                        <div>{{ $location->specific_loc_name }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="location_name" class="form-label font-weight-bold">Area Owner</label>
                                        <div>{{ getAllUserName($location->area_owner) }}</div>
                                    </div>
                                    <div class="col-md-12 form-input">
                                        <label for="location_short_name" class="form-label font-weight-bold">Specific
                                            Location Address / Description</label>
                                        <div>{{ $location->specific_loc_desc }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript"></script>
@endpush
