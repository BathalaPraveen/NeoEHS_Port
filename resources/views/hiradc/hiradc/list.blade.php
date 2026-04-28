@extends('admin.layouts.layout')
@section('title', 'HIRADC List')
@section('pageurl', admin_url('hiradc/hiradc/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">HIRADC Management</li>
                            <li class="breadcrumb-item active" aria-current="page">HIRADC</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">HIRADC List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>
                            <a href="{{ admin_url('hiradc/hiradc/add') }}" class="btn btn-primary">
                                New
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
                                            <label for="documenttype" class="form-label ">Document Type</label>
                                            <select name="documenttype" id="documenttype" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Document Type </option>
                                                @foreach ($documentdetails as $document)
                                                    <option value="{{ encryptId($document->id) }}">{{ $document->document_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="status" class="form-label ">Status</label>
                                            <select name="status" id="status" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Status</option>
                                                <option value="{{ encryptId(1) }}">Pending</option>
                                                <option value="{{ encryptId(2) }}">Approved</option>
                                                <option value="{{ encryptId(3) }}">Rejected</option>

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
                                    <th>Risk ID</th>
                                    <th>Document Type</th>
                                    <th>Process Type</th>
                                    <th>Created By</th>
                                    <th>Date</th>
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

                processing: true,
                serverSide: true,
                searching: false,
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('hiradc/hiradc/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.documenttype = $("#documenttype").val();
                        d.status = $("#status").val();

                    }
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'risk_id',
                        name: 'risk_id'
                    },
                    {
                        data: 'document_name',
                        name: 'document_name'
                    },

                    {
                        data: 'process_type_name',
                        name: 'process_type_name'
                    },

                    {
                        data: 'created_user',
                        name: 'created_user'
                    },


                    {
                        data: 'created_date',
                        name: 'created_date'
                    },

                    {
                        data: 'risk_status',
                        name: 'risk_status'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
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

                                    var documenttype = $("#documenttype").val();
                                    var status = $("#status").val();


                                    window.location.href =
                                        "{{ admin_url('hiradc/hiradc/export/pdf') }}" +
                                        '?documenttype=' + documenttype +
                                        '&status=' + status;

                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var documenttype = $("#documenttype").val();
                                    var status = $("#status").val();


                                    window.location.href =
                                        "{{ admin_url('hiradc/hiradc/export/excel') }}" +
                                        '?documenttype=' + documenttype +
                                        '&status=' + status;
                                }
                            },
                        ]
                    },
                    'pageLength'
                ],

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
                    var title = 'Do you want to In-Activate the Chemical';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Chemical';
                    var text = 'Activate';
                    var btncolor = '#7ddc35'
                }

                Swal.fire({
                    title: title,
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
                            url: "{{ admin_url('hiradc/hiradc/status') }}",
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

                var title = 'Do you want to delete the Record';
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
                            url: "{{ admin_url('hiradc/hiradc/delete') }}",
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
