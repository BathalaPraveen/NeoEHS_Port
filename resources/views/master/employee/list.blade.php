@extends('admin.layouts.layout')
@section('title', 'Employee List')
@section('pageurl', admin_url('employee/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">Employee</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Employee List</h5>
                        </div>
                        <div class="ms-auto">

                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>

                            <a href="{{ admin_url('employee/add') }}" data-bs-toggle="tooltip" title="New"
                                class="btn btn-primary">
                                New
                            </a>
                            <a href="{{ admin_url('employee/import') }}" data-bs-toggle="tooltip" title="Import"
                                class="btn btn-primary">
                                Import
                            </a>
                        </div>
                    </div>
                    <hr />

                    <div id="search" class="collapse">
                        <form action="">
                            <div class="card-body">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 form-input">
                                            <label for="emp_company_id" class="form-label ">Company Name</label>
                                            <select name="emp_company_id" id="emp_company_id" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Company</option>
                                                @foreach ($company_list as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->company_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="emp_division_id" class="form-label ">Division Name</label>
                                            <select name="emp_division_id" id="emp_division_id" style="width: 100%"
                                                class="form-control select2 ">
                                                <option value="">Select Division</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="emp_department_id" class="form-label ">Department
                                                Name</label>
                                            <select name="emp_department_id" id="emp_department_id" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Department</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="emp_user_role" class="form-label ">User Role</label>
                                            <select name="emp_user_role" id="emp_user_role" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select User Role</option>
                                                @foreach ($role_list as $role)
                                                    <option value="{{ encryptId($role->id) }}">
                                                        {{ $role->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <button type="button" id="searchform"
                                                class="btn btn-primary mt-4">Search</button>
                                            <button type="reset" id="resetform" class="btn btn-danger mt-4">reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                    </div>


                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered datatable-list">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Employee ID</th>
                                    <th>Company Name</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th style="width:75px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script type="text/javascript">
        $(function() {
            if ($.fn.DataTable.isDataTable('.datatable-list')) {
                $('.datatable-list').DataTable().destroy();
            }
            /* Datatable */
            var table = $('.datatable-list').DataTable({
                "autoWidth": false,
                dom: 'Bfrtip',
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],

                processing: true,
                serverSide: true,
                searching: true,
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('employee/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.companyid = $("#emp_company_id").val();
                        d.divisionid = $("#emp_division_id").val();
                        d.departmentid = $("#emp_department_id").val();
                        d.roleid = $("#emp_user_role").val();

                    }
                },
                buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                                extend: 'pdf',
                                text: 'Pdf',
                                action: function(e, dt, button, config) {

                                    var companyid = $("#emp_company_id").val();
                                    var divisionid = $("#emp_division_id").val();
                                    var departmentid = $("#emp_department_id").val();
                                    var roleid = $("#emp_user_role").val();
                                    var searchValue = $('.dataTables_filter input').val();

                                    window.location.href =
                                        "{{ admin_url('employee/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&companyid=' + companyid +
                                        '&divisionid=' + divisionid +
                                        '&roleid=' + roleid +
                                        '&departmentid=' + departmentid;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {


                                    var companyid = $("#emp_company_id").val();
                                    var divisionid = $("#emp_division_id").val();
                                    var departmentid = $("#emp_department_id").val();
                                    var roleid = $("#emp_user_role").val();
                                    var searchValue = $('.dataTables_filter input').val();


                                    window.location.href =
                                        "{{ admin_url('employee/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&companyid=' + companyid +
                                        '&divisionid=' + divisionid +
                                        '&roleid=' + roleid +
                                        '&departmentid=' + departmentid;
                                }
                            },
                        ]
                    },
                    'pageLength'
                ],

                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'emp_id',
                        name: 'emp_id'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'emp_name',
                        name: 'emp_name'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'designation_name',
                        name: 'designation_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '#searchform', function() {
                table.draw();
            });

            $(document).on('click', '#resetform', function() {
                table.draw();
            });

            /* Status Change */
            $(document).on('click', '.StatusChange', function() {
                var id = $(this).data('id');
                var types = $(this).data('type');
                if (types == 1) {
                    var title = 'Do you want to In-Activate the Employee';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Employee';
                    var text = 'Activate';
                    var btncolor = '#7ddc35'
                }

                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: text,
                    confirmButtonColor: btncolor,
                    customClass: {
                        confirmButton: 'btn-skew',
                        cancelButton: 'btn-skew'
                    },
                }).then((result) => {



                    if (result.value) {
                        $.ajax({
                            url: "{{ admin_url('employee/status') }}",
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            data: {
                                id: id,
                                types: types
                            },
                            success: function(response) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            'mouseenter',
                                            Swal.stopTimer)
                                        toast.addEventListener(
                                            'mouseleave',
                                            Swal.resumeTimer
                                        )
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: response.msg
                                });
                                table.draw();
                            },
                            error: function(data) {
                                $.notify(data.responseJSON.msg, "error");
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Something went wrong', '', 'info');
                    }
                })

            });

            /* Delete Record */
            $(document).on('click', '.recordDelete', function() {

                var id = $(this).data('id');

                var title = 'Do you want to delete the Employee';
                var text = 'Delete';
                var btncolor = '#dc3545'

                Swal.fire({
                    title: title,
                    showDenyButton: false,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: text,
                    confirmButtonColor: btncolor,
                    denyButtonColor: '#28a745',
                    customClass: {
                        confirmButton: 'btn-skew',
                        cancelButton: 'btn-skew'
                    },
                }).then((result) => {

                    if (result.value) {
                        $.ajax({
                            url: "{{ admin_url('employee/delete') }}",
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            data: {
                                id: id,
                            },
                            success: function(response) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-right',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            'mouseenter',
                                            Swal.stopTimer)
                                        toast.addEventListener(
                                            'mouseleave',
                                            Swal.resumeTimer
                                        )
                                    }
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: response.msg
                                });
                                table.draw();
                            },
                            error: function(data) {
                                $.notify(data.responseJSON.msg, "error");
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Something went wrong', '', 'info');
                    }
                })


            });

        });


        $('#emp_company_id').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_division_id').empty().append(
                            '<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#emp_division_id').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_division_id').trigger('change.select2');
                    }
                });
            } else {
                $('#emp_division_id').empty().append('<option value="">Select Division</option>');
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');

                $('#emp_division_id').trigger('change.select2');
                $('#emp_department_id').trigger('change.select2');
            }
        });

        $('#emp_division_id').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {
                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#emp_department_id').empty().append(
                            '<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#emp_department_id').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });

                        $('#emp_department_id').trigger('change.select2');
                    }
                });
            } else {
                $('#emp_department_id').empty().append('<option value="">Select Department</option>');
                $('#emp_department_id').trigger('change.select2');
            }
        });
    </script>
@endpush
