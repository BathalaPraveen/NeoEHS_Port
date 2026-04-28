@extends('admin.layouts.layout')
@section('title', 'Diving PTW View')
@section('pageurl', admin_url('ptw/diving/list'))

@push('style')
    <style>
        #general_ptw_add {
            color: #000;
        }

        #general_ptw_add .form-check-label {
            display: inline;
        }

        .col-form-label {
            font-weight: 500;
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
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('ptw/diving/list') }}">Diving PTW</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Diving PTW View</li>
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
                                    <h5 class="card-title">Diving PTW View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/diving/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            @include('ptw.pages.divingcertificate')


                            @if ($diving->ptw_status == SUBPERMIT_STATUS_PENDING)
                                @if (isset($approvereject))
                                <form action="{{ admin_url('ptw/diving/approvereject/submit') }}" method="POST">
                                    <div class=" border rounded">
                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">Approve / Reject</h6>
                                        </div>
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($diving->id) }}">
                                        <div class="row g-3 px-2 pt-4">

                                            <div class="row mb-3 mt-3">
                                                <label class="col-sm-2 col-form-label">
                                                    Name</label>
                                                <div class="col-sm-4 form-input">
                                                    <input type="text" class="form-control" name="approvedby" id="approvedby"
                                                        value="{{ Auth::user()->name }}" readonly>


                                                </div>
                                                <label class="col-sm-2 col-form-label form-input">
                                                    Date & Time</label>
                                                <div class="col-sm-4 form-input">
                                                    <input type="text" class="form-control" name="approveddate"
                                                        id="approveddate" value="{{ todayDate() }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <label class="col-sm-2 col-form-label require">
                                                    Remarks</label>
                                                <div class="col-sm-10">
                                                    <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row card-bottom">
                                            <div class="col-12 mt-2 mb-3">

                                                <button class="btn btn-danger " data-bs-toggle="tooltip" type="submit"
                                                    name="reject" value="yes" title="submit">Reject</button>
                                                <button class="btn btn-primary " id="btnsubmit" type="submit" name="approve"
                                                    value="yes" data-bs-toggle="tooltip" title="Approve">Approve</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">

    </script>
@endpush
