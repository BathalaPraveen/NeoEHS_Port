@extends('admin.layouts.layout')
@section('title', 'Contractor Company Approval')
@section('pageurl', admin_url('contractor/company/list'))

@section('style')
    <style type="text/css">
        .error {
            color: red;
            margin: 10px;
        }

        .fields {
            font-weight: bold;
        }
    </style>

@endsection

@section('content')

    <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('contractor/company/list') }}">Contractor Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor Company Approval</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col">

                    <div class="card border-top border-0 border-4 border-primary">


                        <div class="card-body">

                            <div class="d-lg-flex align-items-center gap-3">

                                <div class="position-relative">
                                    <h5 class="card-title">Contractor Company Approval</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('contractor/company/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="card-header card-header-inner">
                                <h5> Contractor Company Detail</h5>
                            </div>

                            <div class="p-4 border rounded">
                                <div class="row g-3">
                                    @if ($conCompany->com_id)
                                        <div class="col-md-4 form-input">
                                            <label for="location_id" class="form-label font-weight-bold">Contractor Company
                                                ID</label>
                                            <div>{{ $conCompany->com_id }}</div>
                                        </div>
                                    @endif

                                    @if ($conCompany->con_comp_name)
                                        <div class="col-md-4 form-input">
                                            <label for="location_name" class="form-label font-weight-bold">Contractor
                                                Company
                                                Name</label>
                                            <div>{{ $conCompany->con_comp_name }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->con_email)
                                        <div class="col-md-4 form-input">
                                            <label for="location_short_name"
                                                class="form-label font-weight-bold">Email</label>
                                            <div>{{ $conCompany->con_email }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->roc_no)
                                        <div class="col-md-4 form-input">
                                            <label for="location_short_name" class="form-label font-weight-bold">Company
                                                Registration Number (ROC/ROB)</label>
                                            <div>{{ $conCompany->roc_no }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->ssm_cerificate_path)
                                        <div class="col-md-4 form-input">
                                            <label for="location_short_name" class="form-label font-weight-bold">SSM
                                                Certificate</label>
                                            <div>
                                                <a href="{{ url($conCompany->ssm_cerificate_path) }}"
                                                    download="SSM Certificate - {{ $conCompany->com_id }}">Download PDF</a>

                                            </div>
                                        </div>
                                    @endif
                                    @if ($conCompany->con_phone)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">Phone</label>
                                            <div>{{ $conCompany->con_phone }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->type_of_business)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">Type of
                                                Business</label>
                                            <div>{{ $conCompany->type_of_business }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->address_1)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">Address Line
                                                1</label>
                                            <div>{{ $conCompany->address_1 }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->address_2)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">Address Line
                                                2</label>
                                            <div>{{ $conCompany->address_2 }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->postcode)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">PostCode</label>
                                            <div>{{ $conCompany->postcode }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->city)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">City</label>
                                            <div>{{ $conCompany->city }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->state)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">State</label>
                                            <div>{{ $conCompany->state }}</div>
                                        </div>
                                    @endif
                                    @if ($conCompany->type)
                                        <div class="col-md-4 form-input">
                                            <label for="location_email" class="form-label font-weight-bold">Type</label>
                                            <div>{{ getContarctorType($conCompany->type) }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if (
                                $conCompany->contractor_status == HSE_ACTION_PENDING &&
                                    (CheckUserRole(ROLE_HSEUSER) || CheckUserRole(ROLE_SUPERADMIN)))
                                <div class="card-header card-header-inner">
                                    <h5> HSE Department Approval</h5>
                                </div>
                                <div class="mt-3 px-3">

                                    <form action="{{ admin_url('contractor/company/hse_approval/submit') }}" method="post"
                                        id="hse_approval_form">

                                        @csrf
                                        <input type="hidden" name="id" id="id"
                                            value="{{ encryptId($conCompany->id) }}">

                                        <div class="row">
                                            <div class="col-md-4 form-input mb-3">
                                                <label for="hse_name" class="form-label font-weight-bold">Name</label>
                                                <input type="text" class="form-control" name="hse_name"
                                                    value="{{ getUsername(Auth::id()) }}" readonly>
                                            </div>
                                            <div class="col-md-4 form-input mb-3">
                                                <label for="hse_time" class="form-label font-weight-bold">Date and
                                                    Time</label>
                                                <input type="text" class="form-control" name="hse_time"
                                                    value="{{ TodayDateTime() }}" readonly>
                                            </div>
                                            <div class="col-md-12 form-input mb-3">
                                                <label for="hse_remarks" class="form-label font-weight-bold">Remarks</label>
                                                <textarea name="hse_remarks" id="hse_remarks" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button action="submit" name="action" value="0"
                                                class="btn btn-danger">Reject</button>
                                            <button action="submit" name="action" value="1"
                                                class="btn btn-primary ms-2">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="card-header card-header-inner">
                                    <h5> HSE Department Approval</h5>
                                </div>
                                <div class="row mt-3 px-3">
                                    <div class="col-md-4 form-input mb-3">
                                        <label for="hse_name" class="form-label font-weight-bold">Name</label>
                                        <p>{{ getUsername($conCompany->hse_name) }}</p>
                                    </div>
                                    <div class="col-md-4 form-input mb-3">
                                        <label for="hse_time" class="form-label font-weight-bold">Date and Time</label>
                                        <p>{{ Displaydatetimeformat($conCompany->hse_time) }}</p>

                                    </div>
                                    <div class="col-md-12 form-input mb-3">
                                        <label for="hse_remarks" class="form-label font-weight-bold">Remarks</label>
                                        <p>{{ $conCompany->hse_remarks }}</p>
                                    </div>
                                </div>
                            @endif

                            @if (
                                $conCompany->contractor_status == IT_DEPT_ACTION_PENDING &&
                                    (CheckUserRole(ROLE_IT_DEPARTMENT) || CheckUserRole(ROLE_SUPERADMIN)))
                                <div class="card-header card-header-inner">
                                    <h5> IT Department Approval</h5>
                                </div>
                                <div class="mt-3 px-3">

                                    <form action="{{ admin_url('contractor/company/it_approval/submit') }}"
                                        method="post" id="it_approval_form">
                                        @csrf

                                        <input type="hidden" name="id" id="id"
                                            value="{{ encryptId($conCompany->id) }}">
                                        <div class="row">
                                            <div class="col-md-4 form-input mb-3">
                                                <label for="it_name" class="form-label font-weight-bold">Name</label>
                                                <input type="text" class="form-control" name="it_name"
                                                    value="{{ getUsername(Auth::id()) }}" readonly>
                                            </div>
                                            <div class="col-md-4 form-input mb-3">
                                                <label for="it_time" class="form-label font-weight-bold">Date and
                                                    Time</label>
                                                <input type="text" class="form-control" name="it_time"
                                                    value="{{ TodayDateTime() }}" readonly>
                                            </div>
                                            <div class="col-md-12 form-input mb-3">
                                                <label for="it_remarks"
                                                    class="form-label font-weight-bold">Remarks</label>
                                                <textarea name="it_remarks" id="it_remarks" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button action="submit" name="action" value="0"
                                                class="btn btn-danger">Reject</button>
                                            <button action="submit" name="action" value="1"
                                                class="btn btn-primary ms-2">Approve</button>
                                        </div>
                                    </form>
                                </div>
                            @elseif ($conCompany->contractor_status == IT_DEPT_REJECTED || $conCompany->contractor_status == APPROVED)
                                <div class="card-header card-header-inner">
                                    <h5> IT Department Approval</h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 form-input mb-3">
                                        <label for="it_name" class="form-label font-weight-bold">Name</label>
                                        <p>{{ $conCompany->it_name }}</p>
                                    </div>
                                    <div class="col-md-4 form-input mb-3">
                                        <label for="it_time" class="form-label font-weight-bold">Date and Time</label>
                                        <p>{{ $conCompany->it_time }}</p>

                                    </div>
                                    <div class="col-md-12 form-input mb-3">
                                        <label for="it_remarks" class="form-label font-weight-bold">Remarks</label>
                                        <p>{{ $conCompany->it_remarks }}</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#hse_approval_form").validate({
                rules: {
                    hse_remarks: {
                        required: true,
                    },
                },
                messages: {
                    hse_remarks: {
                        required: "Remarks is required !",
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
            })

            $("#it_approval_form").validate({
                rules: {
                    it_remarks: {
                        required: true,
                    },
                },
                messages: {
                    it_remarks: {
                        required: "Remarks is required !",
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
            })
        })
    </script>
@endpush
