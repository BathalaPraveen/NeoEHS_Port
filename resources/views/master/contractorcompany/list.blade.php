@extends('admin.layouts.layout')
@section('title', 'Contractor Company List')
@section('pageurl', admin_url('contractor/company/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">Contractor Company</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Contractor Company List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"
                                id="searchicon"><i class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip"
                                    title="Search"></i>
                            </button>
                            <a href="{{ admin_url('contractor/company/add') }}" data-bs-toggle="tooltip" title="New"
                                class="btn btn-primary">
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

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="com_id" class="form-label ">Contractor Company ID</label>
                                            <input type="text" class="form-control " id="com_id" name="com_id">
                                        </div>

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="con_comp_name" class="form-label ">Contractor Company Name</label>
                                            <input type="text" class="form-control " id="con_comp_name" name="con_comp_name">
                                        </div>

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="con_email" class="form-label ">Contractor Company Email</label>
                                            <input type="text" class="form-control " id="con_email" name="con_email">
                                        </div>

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="con_phone" class="form-label ">Contractor Company Phone</label>
                                            <input type="text" class="form-control " id="con_phone" name="con_phone">
                                        </div>

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="type" class="form-label ">Contractor Company Type</label>
                                            <select name="type" id="type" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Type</option>
                                                <option value="{{ encryptId(FROM_CON_MASTER) }}">
                                                    {{ getContarctorType(FROM_CON_MASTER) }}</option>
                                                <option value="{{ encryptId(FROM_REGISTRATION) }}">
                                                    {{ getContarctorType(FROM_REGISTRATION) }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input mb-3">
                                            <label for="contractor_status" class="form-label ">Contractor Company
                                                Status</label>
                                            <select name="contractor_status" id="contractor_status" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Status</option>
                                                <option value="{{ encryptId(APPROVED) }}">
                                                    {{ getContractorCompFilterStatus(APPROVED) }}</option>
                                                <option value="{{ encryptId(HSE_ACTION_PENDING) }}">
                                                    {{ getContractorCompFilterStatus(HSE_ACTION_PENDING) }}</option>
                                                <option value="{{ encryptId(HSE_REJECTED) }}">
                                                    {{ getContractorCompFilterStatus(HSE_REJECTED) }}</option>
                                                <option value="{{ encryptId(IT_DEPT_ACTION_PENDING) }}">
                                                    {{ getContractorCompFilterStatus(IT_DEPT_ACTION_PENDING) }}</option>
                                                <option value="{{ encryptId(IT_DEPT_REJECTED) }}">
                                                    {{ getContractorCompFilterStatus(IT_DEPT_REJECTED) }}</option>
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
                                    <th>Name</th>
                                    <th>Contractor Company ID</th>
                                    <th>Contractor Company Name</th>
                                    <th>Contractor Company Email</th>
                                    <th>Contractor Company Phone</th>
                                    <th>Contractor Company Type</th>
                                    <th>Contractor Company Status</th>
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
                                    var formData = $('#formsearch').serialize();
                                    var exportUrl =
                                        "{{ admin_url('contractor/company/export/pdf') }}";

                                    window.location.href = exportUrl + '?search=' +
                                        searchValue + '&' + formData;

                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();
                                    var formData = $('#formsearch').serialize();
                                    var exportUrl =
                                        "{{ admin_url('contractor/company/export/excel') }}";

                                    window.location.href = exportUrl + '?search=' +
                                        searchValue + '&' + formData;
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
                "ordering": false,
                ajax: {
                    url: "{{ admin_url('contractor/company/list') }}",
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
                        data: 'com_id',
                        name: 'com_id'
                    },
                    {
                        data: 'con_comp_name',
                        name: 'con_comp_name'
                    },
                    {
                        data: 'con_email',
                        name: 'con_email'
                    },
                    {
                        data: 'con_phone',
                        name: 'con_phone'
                    },

                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'contractor_status',
                        name: 'contractor_status'
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
                    var title = 'Do you want to In-Activate the Contractor Company';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Contractor Company';
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
                            url: "{{ admin_url('contractor/company/status') }}",
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

                var title = 'Do you want to delete the Contractor Company';
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
                            url: "{{ admin_url('contractor/company/delete') }}",
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
