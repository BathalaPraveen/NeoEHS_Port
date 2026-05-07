@extends('admin.layouts.layout')
@section('title', 'User Log List')
@section('pageurl', admin_url('userlog/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">User Log</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">User Log List</h5>
                        </div>
                        <div class="ms-auto">


                        </div>
                    </div>
                    <hr />

                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered datatable-list">
                            <thead>
                                <tr>
                                    <th style="">No.</th>
                                    <th>User Name</th>
                                    <th>URL</th>
                                    <th>Session ID</th>
                                    <th>IP Address</th>
                                    <th>Date & Time</th>
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
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                            extend: 'excel',
                            text: 'Excel',
                            action: function(e, dt, button, config) {

                                var searchValue = $('.dataTables_filter input').val();

                                window.location.href =
                                    "{{ admin_url('userlog/export/excel') }}" +
                                    '?search=' +
                                    searchValue;
                            }
                        }, ]
                    },
                    'pageLength'
                ],

                processing: true,
                serverSide: true,
                 searching: false,
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('userlog/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {}
                },
                columns: [

                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'request_uri',
                        name: 'request_uri'
                    },
                    {
                        data: 'session_id',
                        name: 'session_id'
                    },
                    {
                        data: 'client_ip',
                        name: 'client_ip'
                    },
                    {
                        data: 'datetime',
                        name: 'datetime'
                    },

                ]
            });

        });
    </script>
@endpush
