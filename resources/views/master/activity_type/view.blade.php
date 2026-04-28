@extends('admin.layouts.layout')
@section('title', 'Company Activity Type View')
@section('pageurl', admin_url('activity_type/list'))

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
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('activity_type/list') }}">Company Activity Type</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Company Activity Type View</li>
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
                                    <h5 class="card-title">Company Activity Type View</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ admin_url('activity_type/list') }}" data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5> Company Activity Type Detail</h5>
                            </div>

                            <div class="p-4 border rounded">
                                <div class="row g-3">
                                    
                                    <div class="col-md-4 form-input">
                                        <label for="activity_id" class="form-label font-weight-bold">Company Activity Type ID</label>
                                        <div>{{ $activity_type->activity_id }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="activity_name" class="form-label font-weight-bold">Company Activity Type Name</label>
                                        <div>{{ $activity_type->activity_name }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript"></script>
@endpush
