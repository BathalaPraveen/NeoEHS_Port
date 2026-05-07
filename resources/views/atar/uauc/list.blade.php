@extends('admin.layouts.layout')
@section('title', 'UAUC List')
@section('pageurl', admin_url('atar/uauc/list'))



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
                            <li class="breadcrumb-item active" aria-current="page">UAUC</li>
                            <li class="breadcrumb-item active" aria-current="page">UAUC List</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">UAUC List</h5>
                        </div>
                        <div class="ms-auto">
                            <button data-bs-toggle="collapse" data-bs-target="#search" class="btn btn-primary"
                                id="searchicon"><i class="fa-solid fa-magnifying-glass" data-bs-toggle="tooltip"
                                    title="Search"></i>
                            </button>
                            <a href="{{ admin_url('atar/uauc/add') }}" class="btn btn-primary">
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
                                            <label for="uauctype" class="form-label ">UAUC Type</label>
                                            <select name="uauctype" id="uauctype" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select UAUC </option>
                                                @foreach ($uauctype as $type)
                                                    <option value="{{ encryptId($type->id) }}"
                                                        {{ $type->id == $uauc_category_from_filter ? 'selected' : '' }}>
                                                        {{ $type->atar_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="location" class="form-label ">Location Name</label>
                                            <select name="location" id="location" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Location</option>
                                                @foreach ($locationDetails as $location)
                                                    <option value="{{ encryptId($location->id) }}"
                                                        {{ $type->id == $location_from_filter ? 'selected' : '' }}>
                                                        {{ $location->location_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="company">Company</label>
                                            <select class="form-select select2" name="company" id="company">
                                                <option value="">Select Company</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}"
                                                        {{ $company->id == $company_from_filter ? 'selected' : '' }}>
                                                        {{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="department">Department</label>
                                            <select class="form-select select2" name="department" id="department">
                                                <option value="">Select Department</option>
                                                @foreach ($departmentDetails as $department)
                                                    <option value="{{ encryptId($department->id) }}"
                                                        {{ $department->id == $department_from_filter ? 'selected' : '' }}>
                                                        {{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="user_company">Users Company</label>
                                            <select class="form-select select2" name="user_company" id="user_company">
                                                <option value="">Select Company</option>
                                                @foreach ($companyDetails as $company)
                                                    <option value="{{ encryptId($company->id) }}"
                                                        {{ $company->id == $company_from_filter ? 'selected' : '' }}>
                                                        {{ $company->company_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="user_department">Users Department</label>
                                            <select class="form-select select2" name="user_department"
                                                id="user_department">
                                                <option value="">Select Department</option>
                                                @foreach ($departmentDetails as $department)
                                                    <option value="{{ encryptId($department->id) }}"
                                                        {{ $department->id == $department_from_filter ? 'selected' : '' }}>
                                                        {{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label class="form-label" for="user_division">Users Division</label>
                                            <select class="form-select select2" name="user_division" id="user_division">
                                                <option value="">Select division</option>
                                                @foreach ($divisionDetails as $division)
                                                    <option value="{{ encryptId($division->id) }}"
                                                        {{ $division->id == $division_from_filter ? 'selected' : '' }}>
                                                        {{ $division->division_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="status" class="form-label ">Status</label>
                                            <select name="status" id="status" style="width: 100%"
                                                class="form-control select2">
                                                <option value="">Select Status</option>
                                                @foreach ($uaucstatus as $status)
                                                    <option @if ($searchstatus == $status->id) selected @endif
                                                        value="{{ encryptId($status->id) }}"> {{ $status->atar_status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="uauctype" class="form-label ">From Date</label>
                                            <div class="input-group date form-input">
                                                <input type="text" required="" class="form-control "
                                                    id="from_date" name="from_date" readonly="">
                                                <div class="input-group-addon input-group-text">
                                                    <span class="fa fa-calendar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="uauctype" class="form-label ">To Date</label>
                                            <div class="input-group date form-input">
                                                <input type="text" required="" class="form-control "
                                                    id="to_date" name="to_date" readonly="">
                                                <div class="input-group-addon input-group-text">
                                                    <span class="fa fa-calendar"></span>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- hidden input for filter --}}
                                        <input type="hidden" name="year_filter" id="year_filter"
                                            value="{{ $year_from_filter }}">
                                        <input type="hidden" name="month" id="month"
                                            value="{{ $month_from_filter }}">
                                        <input type="hidden" name="division" id="division"
                                            value="{{ $division_from_filter }}">
                                        <input type="hidden" name="department" id="department"
                                            value="{{ isset($department_from_filter) ? $department_from_filter : '' }}">
                                        <input type="hidden" name="spec_location" id="spec_location"
                                            value="{{ $spec_location_from_filter }}">
                                        <input type="hidden" name="corrective_action" id="corrective_action"
                                            value="{{ $corrective_action_from_filter }}">
                                        <div class="col-md-3">

                                            <button type="button" id="searchform"
                                                class="btn btn-primary mt-4">Search</button>
                                            <button type="reset" id="resetform"
                                                class="btn btn-danger mt-4">reset</button>
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
                                    <th>Date</th>
                                    <th>UAUC ID</th>
                                    <th>UAUC Description</th>
                                    <th>UAUC Type</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Department</th>
                                    <th>Users Company</th>
                                    <th>Users Department</th>
                                    <th>Users Division</th>
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
                autoWidth: false,
                responsive: true,
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                 searching: false,
                orderin: false,
                bAutoWidth: false,
                ajax: {
                    url: "{{ admin_url('atar/uauc/list') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: function(d) {
                        d.location = $("#location").val();
                        d.status = $("#status").val();
                        d.uauctype = $("#uauctype").val();
                        d.fromdate = $("#from_date").val();
                        d.todate = $("#to_date").val();
                        d.company = $("#company").val();
                        d.user_company = $("#user_company").val();
                        d.user_department = $("#user_department").val();
                        d.user_division = $("#user_division").val();

                        d.department = $("#department").val();
                        d.division = $("#division").val();
                        d.year_filter = $("#year_filter").val();
                        d.month = $("#month").val();
                        d.spec_location = $("#spec_location").val();
                        d.corrective_action = $("#corrective_action").val();

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'dateandtime',
                        name: 'dateandtime'
                    },
                    {
                        data: 'atar_id',
                        name: 'atar_id'
                    },
                    {
                        data: 'usee_remarks',
                        name: 'usee_remarks'
                    },
                    {
                        data: 'atar_type',
                        name: 'atar_type'
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
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'user_company',
                        name: 'user_company'
                    },
                    {
                        data: 'user_department',
                        name: 'user_department'
                    },
                    {
                        data: 'user_division',
                        name: 'user_division'
                    },
                    {
                        data: 'atar_status',
                        name: 'atar_status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                "fnDrawCallback": function(oSettings) {

                    $('body').tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="tooltip"]').tooltip();
                    $(this).tooltip({
                        html: true
                    });
                },
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 1,
                        targets: 1
                    },
                    {
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 1,
                        targets: 1,

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
                                    var location = $("#location").val();
                                    var status = $("#status").val();
                                    var company = $("#company").val();
                                    var uauctype = $("#uauctype").val();
                                    var user_company = $("#user_company").val();
                                    var user_department = $("#user_department").val();
                                    var user_division = $("#user_division").val();

                                    var fromdate = $("#from_date").val();
                                    var todate = $("#to_date").val();

                                    var department = $("#department").val();
                                    var division = $("#division").val();
                                    var year_filter = $("#year_filter").val();
                                    var month = $("#month").val();
                                    var spec_location = $("#spec_location").val();
                                    var corrective_action = $("#corrective_action").val();

                                    window.location.href =
                                        "{{ admin_url('atar/uauc/export/pdf') }}" +
                                        '?search=' + searchValue +
                                        '&uauctype=' + uauctype +
                                        '&location=' + location +
                                        '&fromdate=' + fromdate +
                                        '&todate=' + todate +
                                        '&company=' + company +
                                        '&department=' + department +
                                        '&division=' + division +
                                        '&user_company=' + user_company +
                                        '&user_department=' + user_department +
                                        '&user_division=' + user_division +
                                        '&year_filter=' + year_filter +
                                        '&month=' + month +
                                        '&spec_location=' + spec_location +
                                        '&corrective_action=' + corrective_action +
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
                                    var uauctype = $("#uauctype").val();
                                    var fromdate = $("#from_date").val();
                                    var company = $("#company").val();
                                    var todate = $("#to_date").val();
                                    var user_company = $("#user_company").val();
                                    var user_department = $("#user_department").val();
                                    var user_division = $("#user_division").val();
                                    var department = $("#department").val();
                                    var division = $("#division").val();
                                    var year_filter = $("#year_filter").val();
                                    var month = $("#month").val();
                                    var spec_location = $("#spec_location").val();
                                    var corrective_action = $("#corrective_action").val();


                                    window.location.href =
                                        "{{ admin_url('atar/uauc/export/excel') }}" +
                                        '?search=' + searchValue +
                                        '&uauctype=' + uauctype +
                                        '&location=' + location +
                                        '&fromdate=' + fromdate +
                                        '&todate=' + todate +
                                        '&company=' + company +
                                        '&department=' + department +
                                        '&division=' + division +
                                        '&user_company=' + user_company +
                                        '&user_department=' + user_department +
                                        '&user_division=' + user_division +
                                        '&year_filter=' + year_filter +
                                        '&month=' + month +
                                        '&spec_location=' + spec_location +
                                        '&corrective_action=' + corrective_action +
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
                    var title = 'Do you want to In-Activate the UAUC';
                    var text = 'In-Activate';
                    var btncolor = '#dc3545'

                } else {
                    var title = 'Do you want to Activate the UAUC';
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
                            url: "{{ admin_url('atar/uauc/status') }}",
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
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Something went wrong, Please try after sometimes'
                                });

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

                var title = 'Do you want to delete the UAUC';
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
                            url: "{{ admin_url('atar/uauc/delete') }}",
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
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Something went wrong, Please try after sometimes'
                                });
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Something went wrong', '', 'info');
                    }
                })


            });

        });

        @if ($search == 1)
            $("#searchicon").click();
        @endif
    </script>
@endpush
