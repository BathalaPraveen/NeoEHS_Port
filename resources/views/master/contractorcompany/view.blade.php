@extends('admin.layouts.layout')
@section('title', 'Contractor Company View')
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
                            <li class="breadcrumb-item active" aria-current="page">Contractor Company View</li>
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
                                    <h5 class="card-title">Contractor Company View</h5>
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

                            @if ($conCompany->type != FROM_CON_MASTER)
                                @if ($conCompany->contractor_status != HSE_ACTION_PENDING)
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


                                @if ($conCompany->contractor_status == IT_DEPT_REJECTED || $conCompany->contractor_status == APPROVED)
                                    <div class="card-header card-header-inner">
                                        <h5> IT Department Approval</h5>
                                    </div>
                                    <div class="row mt-3 px-3">
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="it_name" class="form-label font-weight-bold">Name</label>
                                            <p>{{ getUsername($conCompany->it_name) }}</p>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="it_time" class="form-label font-weight-bold">Date and Time</label>
                                            <p>{{ Displaydatetimeformat($conCompany->it_time) }}</p>

                                        </div>
                                        <div class="col-md-12 form-input mb-3">
                                            <label for="it_remarks" class="form-label font-weight-bold">Remarks</label>
                                            <p>{{ $conCompany->it_remarks }}</p>
                                        </div>
                                    </div>
                                @endif
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
    <script type="text/javascript"></script>
@endpush
