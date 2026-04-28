@extends('admin.layouts.layout')
@section('title', 'Upload Log View')
@section('pageurl', admin_url('uploadlog/list'))


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
                            <li class="breadcrumb-item " aria-current="page">
                                <a href="{{ admin_url('uploadlog/list') }}">Upload Log</i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Upload Log View</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Upload Log View</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ admin_url('uploadlog/download/'.request()->logid) }}" data-bs-toggle="tooltip" title="Download" class="btn btn-primary">
                                Download
                            </a>

                            <a href="{{ admin_url('uploadlog/list') }}" data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                Back
                            </a>

                        </div>
                    </div>
                    <hr />

                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered datatable-list">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Line No</th>
                                    <th>Error</th>
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
                            extend: 'excel',
                            text: 'Excel',
                            action: function(e, dt, button, config) {

                                var searchValue = $('.dataTables_filter input').val();

                                window.location.href =
                                    "{{ admin_url('uploadlog/export/excel/'.request()->logid ) }}" +
                                    '?search=' +
                                    searchValue;
                            }
                        }, ]
                    },
                    'pageLength'
                ],

                processing: true,
                serverSide: true,
                searching: true,
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('uploadlog/list/'.request()->logid ) }}",
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
                        data: 'line_no',
                        name: 'line_no'
                    },
                    {
                        data: 'error',
                        name: 'error'
                    },

                ]
            });

        });
    </script>
@endpush
