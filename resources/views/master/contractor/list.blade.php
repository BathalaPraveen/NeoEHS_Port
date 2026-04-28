@extends('admin.layouts.layout')
@section('title', 'Contractor Employee List')
@section('pageurl', admin_url('contractor/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">Contractor Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor List</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Contractor List</h5>
                        </div>
                        <div class="ms-auto">

                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>
                            <a href="{{ admin_url('contractor/add') }}" data-bs-toggle="tooltip" title="New"
                                class="btn btn-primary">
                                New
                            </a>
                            <a href="{{ admin_url('contractor/import') }}" data-bs-toggle="tooltip" title="Import"
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
                                            <label for="con_company_id" class="form-label ">Company Name</label>
                                            <select name="con_company_id" id="con_company_id" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Company</option>
                                                @foreach ($companylist as $company)
                                                    <option value="{{ encryptId($company->id) }}">
                                                        {{ $company->con_comp_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="con_status" class="form-label ">Status</label>
                                            <select name="con_status" id="con_status" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Status</option>
                                                <option value="{{ encryptId(1) }}">Active</option>
                                                <option value="{{ encryptId(0) }}">In-Active</option>
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
                                    <th>Contractor ID</th>
                                    <th>Contractor Name</th>
                                    <th>Company Name</th>
                                    <th>Designation</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

            /* Datatable */
            var table = $('.datatable-list').DataTable({
                "autoWidth": false,
                "responsive": true,
                dom: 'Bfrtip',
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                                extend: 'pdf',
                                text: 'Pdf',
                                action: function(e, dt, button, config) {

                                    var con_company_id = $("#con_company_id").val();
                                    var con_status = $("#con_status").val();

                                    var searchValue = $('.dataTables_filter input').val();

                                    window.location.href =
                                        "{{ admin_url('contractor/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&con_company_id=' + con_company_id +
                                        '&con_status=' + con_status;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var con_company_id = $("#con_company_id").val();
                                    var con_status = $("#con_status").val();


                                    var searchValue = $('.dataTables_filter input').val();

                                    window.location.href =
                                        "{{ admin_url('contractor/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&con_company_id=' + con_company_id +
                                        '&con_status=' + con_status;
                                }
                            },
                        ]
                    },
                    'pageLength'
                ],

                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 1,
                        targets: 1
                    }
                ],
                processing: true,
                serverSide: true,
                searching: true,
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('contractor/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.con_company_id = $("#con_company_id").val();
                        d.con_status = $("#con_status").val();

                    }
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cont_id',
                        name: 'cont_id'
                    },
                    {
                        data: 'cont_name',
                        name: 'cont_name'
                    },
                    {
                        data: 'con_comp_name',
                        name: 'con_comp_name'
                    },
                    {
                        data: 'cont_designation',
                        name: 'cont_designation'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
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
                    var title = 'Do you want to In-Activate the Contractor';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Contractor';
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
                            url: "{{ admin_url('contractor/status') }}",
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

                var title = 'Do you want to delete the Contractor';
                var text = 'Delete';
                var btncolor = '#dc3545'

                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showDenyButton: false,
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
                            url: "{{ admin_url('contractor/delete') }}",
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
    </script>
@endpush
