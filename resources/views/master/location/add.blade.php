@extends('admin.layouts.layout')
@section('title', 'Location Add')
@section('pageurl', admin_url('location/list'))

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
                                <a href="{{ admin_url('location/list') }}">Location</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Location Add</li>
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
                                    <h5 class="card-title">Location Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('location/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="location_add" novalidate method="POST"
                                action="{{ admin_url('location/add/submit') }}">
                                <div class="p-4 border  rounded">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-4 form-input">
                                            <label for="location_id" class="form-label require">Location ID</label>
                                            <input type="text" name="location_id" class="form-control" id="location_id"
                                                value="{{ getsequence('location') }}" readonly required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="location_id" class="form-label require">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control select2">
                                                <option value="">Please select Company Name</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="location_name" class="form-label require">Location Name</label>
                                            <input type="text" name="location_name" class="form-control"
                                                id="location_name" value="" required>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="location_address" class="form-label require">Location Address /
                                                Description</label>
                                            <textarea class="form-control" required name="location_address" id="location_address" rows="5"></textarea>
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
            $('#location_add').validate({
                rules: {
                    company_id: {
                        required: true,
                    },
                    location_id: {
                        required: true,
                    },
                    location_name: {
                        required: true,
                    },
                },
                messages: {
                    company_id: {
                        required: "Please select Company Name",
                    },
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
