@extends('admin.layouts.layout')
@section('title', 'Location Edit')
@section('pageurl', admin_url('location/list'))

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
                                <a href="{{ admin_url('location/list') }}">Location</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Location Edit</li>
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
                                    <h5 class="card-title">Location List</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('location/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="location_edit" novalidate method="POST"
                                action="{{ admin_url('location/edit/submit') }}">
                                <div class="p-4 border  rounded">
                                    <div class="row">
                                        @csrf
                                        <input type="hidden" value="{{ encryptId($location->id) }}" name="id">
                                        <div class="col-md-4 form-input">
                                            <label for="location_id" class="form-label require">Location ID</label>
                                            <input type="text" name="location_id" class="form-control" id="location_id"
                                                value="{{ $location->location_id }}" readonly required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="location_id" class="form-label require">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control select2">
                                                <option value="">Please select Company Name</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}"
                                                        @selected($company->id == $location->company_id)>{{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="location_name" class="form-label require">Location Name</label>
                                            <input type="text" name="location_name" class="form-control"
                                                id="location_name" value="{{ $location->location_name }}" required>
                                        </div>                                       

                                        <div class="col-md-12 form-input">
                                            <label for="location_address" class="form-label ">Location
                                                Address</label>
                                            <textarea class="form-control" name="location_address" id="location_address" rows="5">{{ $location->location_address }}</textarea>
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
            $('#location_edit').validate({
                rules: {
                    location_id: {
                        required: true,
                    },
                    location_name: {
                        required: true,
                    },
                   

                },
                messages: {
                    location_id: {
                        required: "Please enter Location ID",
                    },
                    location_name: {
                        required: "Please enter Location Name",
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
