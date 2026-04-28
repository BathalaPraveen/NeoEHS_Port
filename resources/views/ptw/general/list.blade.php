@extends('admin.layouts.layout')
@section('title', 'General PTW List')
@section('pageurl', admin_url('ptw/general/list'))


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
                            <li class="breadcrumb-item active" aria-current="page">General PTW</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">General PTW List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"><i
                                    class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip" title="Search"></i>
                            </button>
                            <a href="{{ admin_url('ptw/general/add') }}" class="btn btn-primary">
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
                                            <label for="subpermit" class="form-label ">Sub Permit Type</label>
                                            <select name="subpermit" id="subpermit" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Sub Permit Type </option>
                                                @foreach ($subpermitDetails as $permit)
                                                    <option value="{{ encryptId($permit->id) }}">
                                                        {{ $permit->permit_name }}</option>
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
                                    <th>Specific Location</th>
                                    <th>Work Description</th>
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

    <!-- PTW Hold Modal -->
    <div class="modal fade" id="ptwHoldModal" tabindex="-1" aria-labelledby="ptwHoldLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ admin_url('ptw/general/hold/submit') }}" id="hold_form">
                @csrf
                <input type="hidden" name="ptw_id" id="ptwHoldId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ptwHoldLabel">Hold PTW</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-md-12 form-input">
                                <label for="" class="form-label require">Reason for Hold/Freeze</label>
                                <textarea name="hold_remarks" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Hold</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- PTW UnHold Modal -->
    <div class="modal fade" id="ptwUnHoldModal" tabindex="-1" aria-labelledby="ptwUnHoldLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ admin_url('ptw/general/un_hold/submit') }}" id="unhold_form">
                @csrf
                <input type="hidden" name="ptw_id" id="ptwUnHoldId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ptwUnHoldLabel">UnHold PTW</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-input">
                                <label for="" class="form-label require">UnHold/Freeze Remarks</label>
                                <textarea name="unhold_remarks" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">UnHold</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(function() {

            $('#hold_form').validate({
                rules: {
                    hold_remarks: {
                        required: true,
                    },
                },
                messages: {
                    hold_remarks: {
                        required: "Please enter Hold/Freeze Remarks",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });

            $('#unhold_form').validate({
                rules: {
                    unhold_remarks: {
                        required: true,
                    },
                },
                messages: {
                    unhold_remarks: {
                        required: "Please enter Remarks",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
        $(document).on('click', '.btn-ptw-hold', function() {
            var ptwId = $(this).data('id');
            $('#ptwHoldId').val(ptwId);
            $('#ptwHoldModal').modal('show');

            $('#ptwHoldModal form').on('submit', function(e) {
                e.preventDefault();
                if ($(this).valid()) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you want to put this PTW on hold?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#f39c12",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, Hold it!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                }
            });


        });

        $(document).on('click', '.btn-ptw-unhold', function() {
            var ptwId = $(this).data('id');
            $('#ptwUnHoldId').val(ptwId);
            $('#ptwUnHoldModal').modal('show');

            $('#ptwUnHoldModal form').on('submit', function(e) {
                e.preventDefault();
                if ($(this).valid()) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you want to Unhold this PTW ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#198754",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, UnHold it!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                }
            });

        });

        $(function() {

            $('#hold_form').validate({
                rules: {
                    hold_remarks: {
                        required: true,
                    },
                },
                messages: {
                    hold_remarks: {
                        required: "Please Hold/Freeze Remarks",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });

            /* Datatable */
            var table = $('.datatable-list').DataTable({
                "autoWidth": false,
                "responsive": true,
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                searching: true,
                "ordering": false,
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
                                    var subpermit = $("#subpermit").val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();

                                    window.location.href =
                                        "{{ admin_url('ptw/general/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&subpermit=' + subpermit +
                                        '&location=' + location +
                                        '&status=' + status;
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                action: function(e, dt, button, config) {

                                    var searchValue = $('.dataTables_filter input').val();
                                    var subpermit = $("#subpermit").val();
                                    var location = $("#location").val();
                                    var status = $("#status").val();

                                    window.location.href =
                                        "{{ admin_url('ptw/general/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&subpermit=' + subpermit +
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

                ajax: {
                    url: "{{ admin_url('ptw/general/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.subpermit = $("#subpermit").val();
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
                        data: 'ptw_id',
                        name: 'ptw_id'
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'specific_loc_name',
                        name: 'specific_loc_name'
                    },
                    {
                        data: 'work_description',
                        name: 'work_description'
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

            /* Status Change */
            $(document).on('click', '.StatusChange', function() {
                var id = $(this).data('id');
                var types = $(this).data('type');
                if (types == 1) {
                    var title = 'Do you want to In-Activate the Language';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the Language';
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
                            url: "{{ admin_url('ptw/general/status') }}",
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

                Swal.fire({
                    title: 'Do you want to delete the Location?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        confirmButton: 'btn-skew',
                        cancelButton: 'btn-skew'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ admin_url('ptw/general/delete') }}",
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: response.status,
                                    title: response.msg,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                                table.draw(); // refresh DataTable
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: xhr.responseJSON ? xhr.responseJSON
                                        .msg : "Something went wrong",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });
                            }
                        });
                    }
                });
            });


        });
    </script>
@endpush
