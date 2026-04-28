@extends('admin.layouts.layout')
@section('title', 'Announcement Add')
@section('pageurl', admin_url('settings/announcement/list'))

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
                                <a href="{{ admin_url('settings/announcement/list') }}">Announcement</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Announcement Add</li>
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
                                    <h5 class="card-title">Announcement Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('settings/announcement/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="specific_location_add" novalidate method="POST"
                                action="{{ admin_url('settings/announcement/add/submit') }}">

                                <div class="p-4 border rounded">
                                    <div class="row g-3">

                                        @csrf

                                        <div class="col-md-4 form-input">
                                            <label for="announcement_id" class="form-label require">Announcement ID</label>
                                            <input type="text" name="announcement_id" class="form-control"
                                                id="announcement_id" value="{{ getsequence('announcement') }}" readonly
                                                required>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="announcement_title" class="form-label require">Announcement
                                                Title</label>
                                            <input type="text" name="announcement_title" class="form-control"
                                                id="announcement_title" value="" required>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="announcement_content" class="form-label require">Announcement
                                                Content</label>
                                            <textarea name="announcement_content" class="form-control"id="announcement_content" rows="5"></textarea>

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

                    announcement_id: {
                        required: true,
                    },
                    announcement_title: {
                        required: true,
                    },
                    announcement_content: {
                        required: true,
                    },

                },
                messages: {
                    announcement_id: {
                        required: "Please enter Announcement ID",
                    },
                    announcement_title: {
                        required: "Please enter Announcement Title",
                    },
                    announcement_content: {
                        required: "Please enter Announcement Content",
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
