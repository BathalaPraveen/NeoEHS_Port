@extends('admin.layouts.layout')
@section('title', 'Contractor Add')
@section('pageurl', admin_url('contractor/add'))

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
                                <a href="{{ admin_url('contractor/list') }}">Contractor</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor Upload</li>
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
                                    <h5 class="card-title">Contractor Upload</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ url('public/assets/documents/sample/Contractor_Upload.xlsx') }}" data-bs-toggle="tooltip" title="Download Template" download
                                        class="btn btn-secondary">
                                        Download Template
                                    </a>
                                    <a href="{{ admin_url('employee/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="contractor_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('contractor/import/submit') }}">

                                <div class="p-4 border rounded ">
                                    <div class="row g-3">
                                        @csrf
                                        <div class="col-md-12 form-input">
                                            <input type="file" class="form-control" name="contractor_upload" id="contractor_upload"
                                                required>
                                        </div>
                                    </div>
                                </div>


                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Upload">Upload</button>
                                    </div>
                                </div>
                            </form>
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
        $(function() {
            $('#contractor_add').validate({
                rules: {

                    contractor_upload: {
                        required: true,
                    },
                },
                messages: {
                    contractor_upload: {
                        required: "Please upload Contractor file",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    $(element).closest(".form-input").addClass("selecterror");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                },
            });
        });
    </script>
@endpush
