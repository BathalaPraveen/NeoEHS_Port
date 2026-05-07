@extends('admin.layouts.layout')
@section('content')
@section('title', 'User List')
@push('style')
@endpush
<!-- start page content wrapper-->
<div class="page-content-wrapper" style="padding-top:20px">
    <!-- start page content-->
    <div class="page-content">
        <!--start breadcrumb-->
        <div class="card page-breadcrumb  d-sm-flex align-items-center mb-3">
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="{{ admin_url('home') }}">
                                <ion-icon name="home-outline"></ion-icon>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto button-action">
                <div class="btn-group btn-skew">
                    <a class="btn btn-outline-primary" href="{{ admin_url('UserAdd') }}"> Add User</a>
                </div>
            </div>


        </div>
        <!--end breadcrumb-->
        <hr />

        <div class="card mainCard">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user_list_table" class="table  table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>User Name</th>
                                <th>Email</th>
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
    <!-- end page content-->
</div>
@push('script')
<script type="text/javascript">
    $(function() {
        var table = $('#user_list_table').DataTable({
            "autoWidth": false,
            dom: 'Bfrtip',
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            buttons: [{
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                        text: 'Excel',
                        action: function(e, dt, button, config) {
                            var table_length = table.data().count();
                            if (table_length != 0) {
                                window.location = 'UserProfileDownload';
                                // /Excel?' +
                                //     value;
                            } else {
                                Swal.fire(
                                    'oops!',
                                    'No data available',
                                    'error'
                                )
                            }
                        }

                    }, ]
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
                [0, "desc"]
            ],
            ajax: {
                url: "{{ admin_url('user_management') }}",
                type: 'GET',
                data: function(d) {
                    d.name = $('input[name=name]').val();
                    d.email = $('input[name=email]').val();
                    d.clientsearch = $('#client_search').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'profile_status',
                    name: 'profile_status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    width: "150px",
                },
            ]
        });
        $(document).on('click', '.StatusChange', function() {
            var user_id = $(this).data('id');
            var types = $(this).data('type');
            if (types == 1) {
                var title = 'Do you want to In-Activate the User';
                var text = 'In-Activate';
                var btncolor = '#dc3545'
            } else {
                var title = 'Do you want to Activate the User';
                var text = 'Activate';
                var btncolor = '#7ddc35'
            }
            Swal.fire({
                title: title,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: text,
                confirmButtonColor: btncolor,
                denyButtonColor: '#28a745',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ admin_url('UserStatus') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            user_id: user_id,
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
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
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
                    Swal.fire('User not deleted.', '', 'info');
                }
            })
        });

        $(document).on('click', '.UserDelete', function() {
            var user_id = $(this).data('id');
            Swal.fire({
                title: 'Do you want to Delete the User',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: `Delete`,
                denyButtonText: `Don't Delete`,
                confirmButtonColor: '#dc3545',
                denyButtonColor: '#28a745',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ admin_url('UserDelete') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            user_id: user_id
                        },
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener('mouseleave',
                                        Swal.resumeTimer)
                                }
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'User Deleted successfully'
                            });
                            table.draw();
                        },
                        error: function(data) {
                            $.notify(data.responseJSON.msg, "error");
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('User not deleted.', '', 'info');
                }
            })
        });
    });
</script>
@endpush
@stop
