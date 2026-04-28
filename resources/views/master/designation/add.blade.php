@extends('admin.layouts.layout')
@section('title', 'Designation Add')
@section('pageurl', admin_url('designation/list'))

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
                                <a href="{{ admin_url('designation/list') }}">Designation</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Designation Add</li>
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
                                    <h5 class="card-title">Designation Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('designation/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />


                            <form class="" id="specific_location_add" novalidate method="POST"
                                action="{{ admin_url('designation/add/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row">
                                        @csrf

                                        <div class="col-md-4 form-input">
                                            <label for="designation_id" class="form-label require">Designation ID</label>
                                            <input type="text" name="designation_id" class="form-control"
                                                id="designation_id" value="{{ getsequence('designation') }}" readonly
                                                required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="designation_name" class="form-label require">Designation
                                                Name</label>
                                            <input type="text" name="designation_name" class="form-control"
                                                id="designation_name" value="" required>
                                        </div>


                                    </div>
                                </div>

                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Submit">Submit</button>
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
            $('#specific_location_add').validate({
                rules: {

                    designation_id: {
                        required: true,
                    },
                    designation_name: {
                        required: true,
                    },


                },
                messages: {
                    designation_id: {
                        required: "Please enter Designation ID",
                    },
                    designation_name: {
                        required: "Please enter Designation Name",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endpush
