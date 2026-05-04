@extends('admin.layouts.layout')
@section('title', 'Waste Registered List')
@section('pageurl', admin_url('wastemanagement/' . $companyname . '/wasteregister/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">Waste Management</li>
                            <li class="breadcrumb-item active" aria-current="page">Waste Registered List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Waste Registered List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>
                            <a href="{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/add') }}"
                                class="btn btn-primary">
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
                                            <label for="wastetype" class="form-label ">Waste Type</label><br>
                                            <select name="wastetype" id="wastetype" class="form-control select2 w-100"
                                                style="width:100%!important;">
                                                <option value="">Please Select Waste Code</option>
                                                @foreach ($wastetypeList as $wastetype)
                                                    <option value="{{ encryptId($wastetype->id) }}">
                                                        {{ $wastetype->wastetype_id }} - {{ $wastetype->wastetype_name }}
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
                                    <th>Waste Code</th>
                                    <th>Waste Name</th>
                                    <th>Waste Form</th>
                                    <th>Notification Date</th>
                                    <th>Notification No</th>
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
            if ($.fn.DataTable.isDataTable('.datatable-list')) {
                $('.datatable-list').DataTable().destroy();
            }
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
                    url: "{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.wastetype = $("#wastetype").val();
                    }
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'wastetype_id',
                        name: 'wastetype_id'
                    },
                    {
                        data: 'wastetype_name',
                        name: 'wastetype_name'
                    },

                    {
                        data: 'wasteform',
                        name: 'wasteform'
                    },
                    {
                        data: 'notificationdate',
                        name: 'notificationdate'
                    },
                    {
                        data: 'notification_no',
                        name: 'notification_no'
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

                                    var searchValue = $('.dataTables_filter input').val();
                                    var wastetype = $("#wastetype").val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();


                                    window.location.href =
                                        "{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&wastetype=' + wastetype +
                                        '&location=' + location +
                                        '&status=' + status;

                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();
                                    var wastetype = $("#wastetype").val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();


                                    window.location.href =
                                        "{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&wastetype=' + wastetype +
                                        '&location=' + location +
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


            /* Delete Record */
            $(document).on('click', '.recordDelete', function() {

                var id = $(this).data('id');

                var title = 'Do you want to delete the Waste Register Record';
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
                            url: "{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/delete') }}",
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

