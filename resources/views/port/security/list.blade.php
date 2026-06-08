@extends('admin.layouts.layout')
@section('title', 'Port Security Access Master List')
@section('pageurl', admin_url('portsecurity/security_access/list'))
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
                            <li class="breadcrumb-item active" aria-current="page">Port Security Access</li>
                            <li class="breadcrumb-item active" aria-current="page">Port Security Access List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">
                        <div class="position-relative">
                            <h5 class="card-title">Port Security Access List</h5>
                        </div>
                        <div class="ms-auto">
                             <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>
                            <a href="{{ admin_url('incident/master/category/add') }}" class="btn btn-primary popupwindow">
                                New
                            </a>
                        </div>
                    </div>
                    <hr />
                         <div id="search" class="collapse">
                        <form action="" id="formsearch">

                            <div class="card-body">

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-3 form-input">
                                            <label for="passport_id" class="form-label ">IC/Passport No</label>
                                            <select name="passport_id" id="passport_id"
                                                class="form-control select2">
                                                <option value="">Select IC/Passport No</option>
                                                @foreach ($securitydata as $passport_id)
                                                    <option value="{{ $passport_id->passport_number }}">
                                                        {{ $passport_id->passport_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                         <div class="col-md-3 form-input">
                                            <label for="sec_name" class="form-label ">Name</label>
                                            <select name="sec_name" id="sec_name"
                                                class="form-control select2">
                                                <option value="">Select Name</option>
                                                @foreach ($securitydata as $secname)
                                                    <option value="{{ $secname->name }}">
                                                        {{ $secname->name }}
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
                                    <th>PSS ID</th>
                                    <th>Name</th>
                                    <th>IC/Passport No</th>
                                    <th>Company Name</th>
                                    <th>Location Name</th>
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
            if ($.fn.DataTable.isDataTable('.datatable-list')) {
                $('.datatable-list').DataTable().destroy();
            }
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
                                    var searchValue = $('#datatable-list_filter input').val();
                                    var formData = $('#formsearch').serialize();
                                    var exportUrl =
                                        "{{ admin_url('portsecurity/security_access/export/pdf') }}";
                                    window.location.href = exportUrl + '?search=' +
                                        searchValue + '&' +
                                        formData;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {
                                    var searchValue = $('#datatable-list_filter input').val();
                                    var formData = $('#formsearch').serialize();
                                    var exportUrl =
                                        "{{ admin_url('portsecurity/security_access/export/excel') }}";
                                    window.location.href = exportUrl + '?search=' +
                                        searchValue + '&' +
                                        formData;
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
                 searching: false,
                "order": [
                    [0, "asc"]
                ],
                ajax: {
                    url: "{{ admin_url('portsecurity/security_access/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                     data: function(d) {
                        let formData = $('#formsearch').serialize();
                        let params = new URLSearchParams(formData);
                        params.forEach((value, key) => d[key] = value);
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'unique_id',
                        name: 'unique_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'passport_number',
                        name: 'passport_number'
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
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

        });
    </script>
@endpush
