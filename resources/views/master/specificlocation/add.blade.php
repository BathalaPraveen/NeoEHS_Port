@extends('admin.layouts.layout')
@section('title', 'Specific Location Add')
@section('pageurl', admin_url('specificlocation/list'))

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
                                <a href="{{ admin_url('specificlocation/list') }}">Specific Location</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Specific Location Add</li>
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
                                    <h5 class="card-title">Specific Location List</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('specificlocation/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class=" " id="specific_location_add" novalidate method="POST"
                                action="{{ admin_url('specificlocation/add/submit') }}">

                                <div class="p-4   border  rounded">
                                    <div class="row">
                                        @csrf

                                        <div class="col-md-3 form-input">
                                            <label for="specific_location_id" class="form-label require">Specific Location
                                                ID</label>
                                            <input type="text" name="specific_location_id" class="form-control"
                                                id="specific_location_id" value="{{ getsequence('specific_location') }}"
                                                readonly required>
                                        </div>
                                        <div class="col-md-3 form-input">
                                            <label for="location_id" class="form-label require">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control select2">
                                                <option value="">Please select Company Name</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 form-input">
                                            <label for="location_id" class="form-label require">Location Name</label>
                                            <select name="location_id" id="location_id" class="form-control select2"
                                                required>
                                                <option value="">Select Location</option>

                                            </select>

                                        </div>
                                        <div class="col-md-3 form-input">
                                            <label for="specific_location_name" class="form-label require">Specific Location
                                                Name</label>
                                            <input type="text" name="specific_location_name" class="form-control"
                                                id="specific_location_name" value="" required>
                                        </div>


                                        <div class="col-md-4 form-input mb-3 mt-3">
                                            <label for="location_id" class="form-label require">Area Owner</label>
                                            <select name="area_owner[]" id="area_owner" class="form-control select2"
                                                multiple>
                                                <option value="">Please select Area Owner</option>
                                                @foreach ($employeeDetails as $employee)
                                                    <option value="{{ encryptId($employee->id) }}">
                                                        {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="specific_location_desc" class="form-label ">Specific Location
                                                Address / Description</label>
                                            <textarea class="form-control" required name="specific_location_desc" id="specific_location_desc" rows="5"></textarea>
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
        $('#company_id').change(function() {

            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('location/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#location_id').empty().append(
                            '<option value="">Select Location</option>');
                        $.each(data, function(key, value) {
                            $('#location_id').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#location_id').trigger('change.select2');

                    }
                });
            } else {
                $('#location_id').empty().append('<option value="">Select Location</option>');
                $('#location_id').trigger('change.select2');

            }
        });

        $(function() {
            $('#specific_location_add').validate({
                rules: {

                    company_id: {
                        required: true,
                    },
                    location_id: {
                        required: true,
                    },
                    specific_location_name: {
                        required: true,
                    },
                    specific_location_desc: {
                        required: true,
                    },
                    'area_owner[]': {
                        required: true,
                    },

                },
                messages: {
                    company_id: {
                        required: "Please select Company ID",
                    },
                    location_id: {
                        required: "Please select Location",
                    },
                    specific_location_name: {
                        required: "Please enter Specific Location Name",
                    },
                    specific_location_desc: {
                        required: "Please enter Specific Location Description",
                    },
                    'area_owner[]': {
                        required: "Please Select Area Owner",
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
