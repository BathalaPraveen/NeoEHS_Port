@extends('admin.layouts.layout')
@section('title', 'HIRADC Category List')
@section('pageurl', admin_url('hiradc/master/documentcategory/list'))

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
                            <li class="breadcrumb-item active" aria-current="page">HIRADC</li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">HIRADC Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">HIRADC Category List</h5>
                        </div>
                        <div class="ms-auto">

                            <a href="{{ admin_url('hiradc/master/documentcategory/add') }}"
                                class="btn btn-primary popupwindow">
                                New
                            </a>
                        </div>
                    </div>
                    <hr />

                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered datatable-list">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Inspection Type Name</th>
                                    <th>Category Name</th>
                                    <th>Item Name</th>
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
        var table;

        $(function() {

            /* Datatable */
            table = $('.datatable-list').DataTable({
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

                                    var searchValue = $('.dataTables_filter input').val();

                                    window.location.href =
                                        "{{ admin_url('hiradc/master/documentcategory/export/pdf') }}" +
                                        '?search=' +
                                        searchValue;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();

                                    window.location.href =
                                        "{{ admin_url('hiradc/master/documentcategory/export/excel') }}" +
                                        '?search=' +
                                        searchValue;
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
                "order": [
                    [0, "asc"]
                ],
                ajax: {
                    url: "{{ admin_url('hiradc/master/documentcategory/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {

                    }
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'document_name',
                        name: 'document_name'
                    },
                    {
                        data: 'documenttype_name',
                        name: 'documenttype_name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },


                ]
            });

            /* Status Change */
            $(document).on('click', '.StatusChange', function() {
                var id = $(this).data('id');
                var types = $(this).data('type');
                if (types == 1) {
                    var title = 'Do you want to In-Activate the Checklist Item';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Checklist Item';
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
                            url: "{{ admin_url('hiradc/master/documentcategory/status') }}",
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

                var title = 'Do you want to delete the Checklist Item';
                var text = 'Delete';
                var btncolor = '#dc3545'

                Swal.fire({
                    title: title,
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
                            url: "{{ admin_url('hiradc/master/documentcategory/delete') }}",
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
