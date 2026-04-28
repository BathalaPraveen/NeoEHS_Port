@extends('admin.layouts.layout')
@section('title', 'Division Add')
@section('pageurl', admin_url('division/list'))

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
                                <a href="{{ admin_url('division/list') }}">Division</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Division Add</li>
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
                                    <h5 class="card-title">Division Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('division/list') }}" data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="division_add" novalidate method="POST"
                                action="{{ admin_url('division/add/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row"> @csrf

                                        <div class="col-md-4 form-input">
                                            <label for="division_id" class="form-label require">Division ID</label>
                                            <input type="text" name="division_id" class="form-control" id="division_id"
                                                value="{{ getsequence('division') }}" readonly required>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="company_id" class="form-label require">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control select2" required>
                                                <option value="">Select Company</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="division_name" class="form-label require">Division Name</label>
                                            <input type="text" name="division_name" class="form-control"
                                                id="division_name" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="division_shortname" class="form-label ">Division
                                                Short Name</label>
                                            <input type="text" name="division_shortname" class="form-control"
                                                id="division_shortname" value="" >

                                        </div>

                                    </div>
                                </div>
                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip" title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip" title="Submit">Submit</button>
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
            $('#division_add').validate({
                rules: {

                    company_id: {
                        required: true,
                    },
                    division_name: {
                        required: true,
                    },
                    // division_shortname: {
                    //     required: true,
                    // },

                },
                messages: {
                    company_id: {
                        required: "Please select Company",
                    },
                    division_name: {
                        required: "Please enter Division Name",
                    },
                    // division_shortname: {
                    //     required: "Please enter Division Short Name",
                    // },

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
