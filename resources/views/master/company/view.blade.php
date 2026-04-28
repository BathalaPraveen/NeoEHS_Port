@extends('admin.layouts.layout')
@section('title', 'Company View')
@section('pageurl', admin_url('company/list'))

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
                                <a href="{{ admin_url('company/list') }}">Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Company View</li>
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
                                    <h5 class="card-title">Company View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('company/list') }}" data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5> Company Detail</h5>
                            </div>

                            <div class="p-4 border rounded">
                                <div class="row g-3">
                                    <div class="col-md-4 form-input">
                                        <label for="company_id" class="form-label font-weight-bold">Company ID</label>
                                        <div>{{ $company->company_id }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="company_name" class="form-label font-weight-bold">Company Name</label>
                                        <div>{{ $company->company_name }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="company_short_name" class="form-label font-weight-bold">Company Short Description</label>
                                        <div>{{ $company->company_shortname }}</div>
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
