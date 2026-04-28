@extends('admin.layouts.layout')
@section('title', 'Company Activity Type Edit')
@section('pageurl', admin_url('activity_type/list'))

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
                                <a href="{{ admin_url('activity_type/list') }}">Company Activity Type</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Company Activity Type Edit</li>
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
                                    <h5 class="card-title">Company Activity Type List</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('activity_type/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="activity_type_edit" novalidate method="POST"
                                action="{{ admin_url('activity_type/edit/submit') }}">
                                <div class="p-4 border  rounded">
                                    <div class="row">
                                        @csrf
                                        <input type="hidden" value="{{ encryptId($activity_type->id) }}" name="id">
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="activity_id" class="form-label require">Company Activity Type ID</label>
                                            <input type="text" name="activity_id" class="form-control" id="activity_id"
                                                value="{{ $activity_type->activity_id }}" readonly required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="activity_name" class="form-label require">Company Activity Type Name</label>
                                            <input type="text" name="activity_name" class="form-control"
                                                id="activity_name" value="{{ $activity_type->activity_name }}" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Update">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(function() {
            $('#activity_type_edit').validate({
                rules: {
                    activity_id: {
                        required: true,
                    },
                    activity_name: {
                        required: true,
                    },

                },
                messages: {
                    activity_id: {
                        required: "Please enter Company Activity Type ID",
                    },
                    activity_name: {
                        required: "Please enter Company Activity Type Name",
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
