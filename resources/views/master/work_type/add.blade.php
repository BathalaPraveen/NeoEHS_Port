@extends('admin.layouts.layout')
@section('title', 'Work Type Add')
@section('pageurl', admin_url('work_type/list'))

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
                                <a href="{{ admin_url('work_type/list') }}">Work Type</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">Work Type Add</li>
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
                                    <h5 class="card-title">Work Type Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('work_type/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="work_type_add" novalidate method="POST"
                                action="{{ admin_url('work_type/add/submit') }}">
                                <div class="p-4 border rounded">
                                    <div class="row">
                                        @csrf
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="work_type_id" class="form-label require">Work Type ID</label>
                                            <input type="text" name="work_type_id" class="form-control" id="work_type_id"
                                                value="{{ getsequence('work_type') }}" readonly required>
                                        </div>

                                        <div class="col-md-4 form-input mb-3">
                                            <label for="work_type_name" class="form-label require">Work Type Name</label>
                                            <input type="text" name="work_type_name" class="form-control"
                                                id="work_type_name" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input mb-3">
                                            <label for="work_type_id" class="form-label require">Supervising
                                                Authority</label>
                                            <select name="supervising_authority[]" id="supervising_authority"
                                                class="form-control select2" multiple>
                                                <option value="">Please select Supervising Authority</option>
                                                @foreach ($employeeDetails as $employee)
                                                    <option value="{{ encryptId($employee->id) }}">
                                                        {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="work_type_description" class="form-label">Work Type Description</label>
                                            <textarea class="form-control" name="work_type_description" id="work_type_description" rows="5"></textarea>
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
            $('#work_type_add').validate({
                rules: {

                    work_type_id: {
                        required: true,
                    },
                    work_type_name: {
                        required: true,
                    },
                    'supervising_authority[]': {
                        required: true,
                    },
                },
                messages: {

                    work_type_id: {
                        required: "Please enter Work Type ID",
                    },
                    work_type_name: {
                        required: "Please enter Work Type Name",
                    },
                    'supervising_authority[]': {
                        required: "Please Select Supervising Authority",
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
