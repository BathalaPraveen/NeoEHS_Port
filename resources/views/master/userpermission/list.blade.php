@extends('admin.layouts.layout')
@section('title', 'User Permission')
@section('pageurl', admin_url('user/permission/list'))


@section('content')

   <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">

                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                            <li class="breadcrumb-item active" aria-current="page">User Permission</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">User Permission</h5>
                        </div>
                        <div class="ms-auto">
                        </div>
                    </div>
                    <hr />

                    <form id="userpermission" action="{{ admin_url('user/permission/update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4 form-input">
                                    <select name="role" id="role" class="form-control select2" required>
                                        <option value="">Select Role</option>
                                        @foreach ($roleList as $role)
                                            <option value="{{ encryptId($role->id) }}">{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">


                            <table id="example2" class="table table-striped table-bordered datatable-list">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Add</th>
                                        <th>Edit</th>
                                        <th>View</th>
                                        <th>Delete</th>
                                        <th>Export</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {!! $menuList !!}

                                </tbody>
                            </table>

                            <hr>
                            <div class=" card-bottom">
                                <div class="col-12 mt-2 mb-3">
                                    <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                        title="Save">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script type="text/javascript">

$(function() {
            $('#userpermission').validate({
                rules: {
                    role: {
                        required: true,
                    },
                },
                messages: {
                    role: {
                        required: "Please select Role",
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

        // Handle parent checkboxes
        $('.parent').change(function() {
            var id = $(this).data('id');
            $(this).closest('tbody').find('.' + id).prop('checked', this.checked);
        });

        const childCheckboxes = document.querySelectorAll('.child');

        childCheckboxes.forEach((childCheckbox) => {
            childCheckbox.addEventListener('click', function() {
                const parentClasses = this.classList;
                console.log(parentClasses);

                parentClasses.forEach((parentClass) => {

                });
            });
        });

        $(document).ready(function() {

            $("#role").on("change", function() {

                $("#userpermission input[type=checkbox]").prop("checked", false);
                var id = $(this).val();

                if (id == '') {
                    return true;
                }

                $.ajax({
                    url: "{{ admin_url('user/permission/get') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(response) {

                        if (response.status === "success" && response.userpermission) {
                            response.userpermission.forEach(function(permissionName) {

                                $(":checkbox[name='" + permissionName + "']").prop(
                                    "checked", true);
                            });
                        }
                    },
                    error: function(xhr, status, error) {

                        console.error("AJAX request failed: " + error);
                    }
                });
            });
        });
    </script>
@endpush
