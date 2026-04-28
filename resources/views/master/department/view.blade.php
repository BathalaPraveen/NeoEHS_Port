@extends('admin.layouts.layout')
@section('title', 'Department View')
@section('pageurl', admin_url('department/list'))

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
                                <a href="{{ admin_url('department/list') }}">Department</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Department View</li>
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
                                    <h5 class="card-title">Department View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('department/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5> Department Detail</h5>
                            </div>
                            <div class="p-4 border rounded">
                                <div class="row g-3">

                                    <div class="col-md-4 form-input">
                                        <label for="Department_id" class="form-label font-weight-bold">Department ID</label>
                                        <div>{{ $department->department_id }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="company_name" class="form-label font-weight-bold">Company Name</label>
                                        <div>{{ $department->company_name }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="Department_name" class="form-label font-weight-bold">Division
                                            Name</label>
                                        <div>{{ $department->division_name }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="Department_name" class="form-label font-weight-bold">Department
                                            Name</label>
                                        <div>{{ $department->department_name }}</div>
                                    </div>
                                    <div class="col-md-8 form-input">
                                        <label for="Department_short_name" class="form-label font-weight-bold">Department
                                            Short Name</label>
                                        <div>{{ $department->department_shortname }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="location_name" class="form-label font-weight-bold">Department Admin</label>
                                        <div>{{ getAllUserName($department->dept_admin) }}</div>
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
