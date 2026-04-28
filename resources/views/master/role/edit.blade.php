@extends('admin.layouts.layout')
@section('title', 'User Role Edit')
@section('pageurl', admin_url('user/role/list'))

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
                                <a href="{{ admin_url('user/role/list') }}">User Role</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Role Edit</li>
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
                                    <h5 class="card-title">User Role Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('user/role/list') }}" data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="role_edit" novalidate method="POST"
                                    action="{{ admin_url('user/role/edit/submit') }}">
                            <div class="p-4 border rounded">
                                    <div class="row">
                                    <input type="hidden" name="id" value="{{ encryptId($role->id) }}">
                                    @csrf

                                    <div class="col-md-4 form-input">
                                        <label for="role_id" class="form-label require">User Role
                                            ID</label>
                                        <input type="text" name="role_id" class="form-control" id="role_id"
                                            value="{{ $role->role_id }}" readonly required>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label for="role_name" class="form-label require">User Role
                                            Name</label>
                                        <input type="text" name="role_name" class="form-control"
                                            value="{{ $role->role_name }}" id="role_name" value="" required>
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
        <!--end row-->
    </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(function() {
            $('#role_edit').validate({
                rules: {

                    role_id: {
                        required: true,
                    },
                    role_name: {
                        required: true,
                    },


                },
                messages: {
                    role_id: {
                        required: "Please enter User Role ID",
                    },
                    role_name: {
                        required: "Please enter User Role Name",
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
