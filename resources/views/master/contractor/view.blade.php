@extends('admin.layouts.layout')
@section('title', 'Contractor View')
@section('pageurl', admin_url('contractor/list'))

@push('style')
    <style>
        .card-body label {
            font-weight: 500;
        }

        .form-input {
            margin-bottom: 1rem;
        }
    </style>
@endpush
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
                                <a href="{{ admin_url('contractor/list') }}">Contractor</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor View</li>
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
                                    <h5 class="card-title">Contractor View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('contractor/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5> Contractor Detail</h5>
                            </div>
                            <div class="p-4 border rounded">
                                <div class="row">

                                    <div class="col-md-4 form-input">
                                        <label for="con_id" class="form-label ">Contractor ID</label>
                                        <div> {{ $contractor->cont_id }}</div>
                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="con_name" class="form-label ">Contractor Employee
                                            Name</label>
                                        <div>{{ $contractor->cont_name }}</div>

                                    </div>
                                    {{-- <div class="col-md-4 form-input">
                                            <label for="con_gender" class="form-label ">Gender</label>
                                            <div>{{ $contractor->gender_name }}</div>

                                        </div> --}}
                                    {{-- <div class="col-md-4 form-input">
                                            <label for="con_nationality" class="form-label ">Nationality</label>

                                            @if ($contractor->cont_nationality != 0)
                                                <div>{{ $contractor->nationality }}</div>
                                            @else
                                                <div>Others</div>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-input " id="con_nationality_other_div"
                                            @if ($contractor->cont_nationality != 0) style="display: none" @endif>
                                            <label for="con_nationality_other" class="form-label ">Nationality
                                                Others</label>
                                            <div>{{ $contractor->cont_nationality_other }}</div>
                                        </div> --}}

                                    <div class="col-md-4 form-input">
                                        <label for="id_type" class="form-label ">ID Type</label>

                                        @if ($contractor->cont_id_type == 1)
                                            <div>IC Number</div>
                                        @else
                                            <div>Passport Number</div>
                                        @endif
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="con_mc_or_passport_no" class="form-label ">IC Number or
                                            Passport Number</label>
                                        <div>{{ $contractor->cont_id_number }}</div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="con_designation_id" class="form-label ">Designation</label>
                                        <div>{{ $contractor->cont_designation }}</div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="con_company_id" class="form-label ">Company Name</label>
                                        <div>{{ $contractor->con_comp_name }}</div>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="con_email_id" class="form-label ">Email ID</label>
                                        <div>{{ $contractor->cont_email }}</div>

                                    </div>
                                    <div class="col-md-4 form-input">
                                        <label for="con_phone_no" class="form-label ">Phone</label>
                                        <div>{{ $contractor->cont_phone }}</div>

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
