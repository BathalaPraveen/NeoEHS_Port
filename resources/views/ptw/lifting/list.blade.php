@extends('admin.layouts.layout')
@section('title', 'Lifting PTW List')
@section('pageurl', admin_url('ptw/lifting/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">PTW</li>
                            <li class="breadcrumb-item active" aria-current="page">Lifting Plan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Lifting PTW List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                        </button>
                            {{-- <a href="{{ admin_url('ptw/lifting/add') }}" class="btn btn-primary">
                                New
                            </a> --}}
                        </div>
                    </div>
                    <hr />

                    <div id="search" class="collapse">
                        <form action="">
                            <div class="card-body">

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3 form-input">
                                            <label for="location" class="form-label ">Location Name</label>

                                            <select name="location" id="location" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Location </option>
                                                @foreach ($locationDetails as $location)
                                                    <option value="{{ encryptId($location->id) }}">
                                                        {{ $location->location_name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="status" class="form-label ">Status</label>
                                            <select name="status" id="status" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Status</option>
                                                @foreach ($statusDetails as $status)
                                                    <option value="{{ encryptId($status->id) }}">
                                                        {{ $status->status_name }}</option>
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
                                    <th>PTW ID</th>
                                    <th>Location</th>
                                    <th>Date & Time</th>
                                    <th>Applied By</th>
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
                                extend: 'pdf',
                                text: 'Pdf',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();

                                    window.location.href =
                                        "{{ admin_url('ptw/lifting/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&location=' + location +
                                        '&status=' + status;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();

                                    window.location.href =
                                        "{{ admin_url('ptw/lifting/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&location=' + location +
                                        '&status=' + status;
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
                    url: "{{ admin_url('ptw/lifting/list') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                .attr('content')
                        },
                    data: function(d) {
                        d.location = $("#location").val();
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
                        data: 'sub_permit_id',
                        name: 'sub_permit_id'
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },

                    {
                        data: 'created_date',
                        name: 'created_date'
                    },
                    {
                        data: 'name',
                        name: 'name'
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

            $('input[type="search"]').attr('placeholder', 'Search by PTW-ID');



        });
    </script>
@endpush
