@extends('admin.layouts.layout')
@section('title', 'Chemical View')
@section('pageurl', admin_url('chemical/chemical/list'))

@push('style')
    <style>
        .chemical_list {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush

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

                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('chemical/chemical/list') }}">Chemical</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chemical View</li>
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
                                    <h5 class="card-title">Chemical View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('chemical/chemical/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">
                                    @csrf

                                    <div class="card-header card-header-inner mt-3 ">
                                        <h6 class="text-white">Section A: COMPANY INFORMATION</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="row">
                                            <div class="col-md-4 form-input">
                                                <label for="company" class="form-label bold">Name of
                                                    Company</label>
                                                <div>
                                                    {{ $companyList->full_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_dosh" class="form-label bold">DOSH
                                                    Registration No</label>
                                                <div>{{ $companyList->dosh_reg_no }}</div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_dosh" class="form-label bold">Roc No</label>
                                                <div>{{ $companyList->roc_no }}</div>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="company_address" class="form-label bold">Address</label>
                                                <div> {{ $companyList->address }} </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_city" class="form-label bold">City</label>
                                                <div> {{ $companyList->city }} </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_state" class="form-label bold">State</label>
                                                <div> {{ $companyList->state }} </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_pincode" class="form-label bold">Postcode</label>
                                                <div> {{ $companyList->pincode }} </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="gps_coordinate" class="form-label bold">GPS
                                                    Coordinate</label>
                                                <div> {{ $chemicalDetails->gps_coordinate }} </div>

                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold">Telephone
                                                    no</label>
                                                <div> {{ $chemicalDetails->telephone_no }} </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_email" class="form-label bold">Email</label>
                                                <div> {{ $chemicalDetails->email }} </div>
                                            </div>

                                            <div class="container-bg">
                                                <h6>2 Contact Person</h6>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="contact_person_name" class="form-label bold">Name</label>
                                                <div>{{ getUsername($chemicalDetails->contact_person_name) }}</div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="contact_person_designation"
                                                    class="form-label bold">Designation</label>
                                                <div>
                                                    {{ getuser($chemicalDetails->contact_person_name)->user_designation_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="contact_person_ph" class="form-label bold">Contact
                                                    Number</label>
                                                <div>{{ $chemicalDetails->contact_person_ph }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="contact_person_email" class="form-label bold">Email
                                                </label>
                                                <div>{{ getuser($chemicalDetails->contact_person_name)->email }}
                                                </div>
                                            </div>

                                            <div class="container-bg">
                                                <h6>3 Industrial Classification Code</h6>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="" class="form-label bold">Industrial Sector
                                                    Division</label>
                                                <div>{{ $chemicalDetails->industrial_sector }}</div>
                                            </div>

                                            <div class="col-md-12 mb-3 form-input">
                                                <label for="" class="form-label bold">Industrial
                                                    Classification (Fraction) Code</label>
                                                <div>{{ $chemicalDetails->industrial_classification }}</div>
                                            </div>

                                            <div class="container-bg">
                                                <h6>4 Company Activity</h6>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_activity" class="form-label bold">Company
                                                    Activity</label>
                                                <div>{{ getCompany_activity($chemicalDetails->company_activity) }}</div>
                                            </div>

                                            <hr>

                                            <div class="card-header card-header-inner ">
                                                <div class="d-lg-flex align-items-center gap-3">

                                                    <div class="position-relative">
                                                        <h6 class="text-white">SECTION B : LIST OF CHEMICALS HAZARDOUS TO
                                                            HEALTH</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-4 pt-4">
                                                <div class="table-responsive chemical-scroll-container">
                                                    <table class="chemical-table table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2">Section B</th>
                                                                <th colspan="7">LIST OF CHEMICALS HAZARDOUS TO HEALTH
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Work area</th>
                                                                <td colspan="5">{{ $chemicalDetails->work_area ?? '-' }}
                                                                </td>
                                                                <th rowspan="2">No. of Workers</th>
                                                                <td>{{ $chemicalDetails->worker_male ?? '-' }}</td>
                                                                <th>Male</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Work Process</th>
                                                                <td colspan="5">
                                                                    {{ $chemicalDetails->work_process ?? '-' }}</td>
                                                                <td>{{ $chemicalDetails->worker_female ?? '-' }}</td>
                                                                <th>Female</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="min-width: 160px;">Chemical Name</th>
                                                                <th style="min-width: 180px;">Name of Hazardous Ingredient
                                                                </th>
                                                                <th style="min-width: 200px;">CAS No</th>
                                                                <th style="min-width: 220px;">Composition (%)</th>
                                                                <th style="min-width: 160px;">Physical Form</th>
                                                                <th style="min-width: 280px;">Avg. Quantity (monthly /
                                                                    yearly). </th>
                                                                <th style="min-width: 300px;">Supplier Info</th>
                                                                <th style="min-width: 300px;">SDS Info</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="chemicaldetails">
                                                            @foreach ($chemicallistDetails as $index => $chemical)
                                                                <tr class="chemical_list">
                                                                    <td>{{ getChemical($chemical->name_of_chemical) ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $chemical->name_of_hazardous_ingredient ?? '-' }}
                                                                    </td>
                                                                    <td>{{ $chemical->cas_no ?? '-' }}</td>
                                                                    <td>{{ $chemical->compostion_hazardous_ingredient ?? '-' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ getChemicalItem($chemical->physical_form_of_chemical) ?? '-' }}
                                                                        @if (strtolower(getChemicalItem($chemical->physical_form_of_chemical)) === 'others')
                                                                            <br><strong>Other:</strong>
                                                                            {{ $chemical->phy_other ?? '-' }}
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ str_replace('_', ' / ', $chemical->usage_of_chemical_quantity) ?? '-' }} /
                                                                        {{ Displayuocunit($chemical->uocunit) }}
                                                                    </td>

                                                                    @php
                                                                        $supplier = getSupplierDetails(
                                                                            $chemical->supplier_details,
                                                                        );
                                                                    @endphp


                                                                    <td>
                                                                        <strong>Supplier:</strong>
                                                                        {{ $supplier?->supplier_name ?? '_' }} <br>
                                                                        <strong>Address:</strong>
                                                                        {{ $supplier?->address ?? '_' }} <br>
                                                                        <strong>Phone:</strong>
                                                                        {{ $supplier?->contact_no ?? '_' }}
                                                                    </td>

                                                                    <td>
                                                                        <strong>SDS:</strong>
                                                                        {{ $chemical->comply_with_classification_sds ?? '-' }}<br>
                                                                        <strong>Prep Date:</strong>
                                                                        {{ Displaydateformat($chemical->prep_date) ?? '-' }}<br>
                                                                        <strong>Revision Date:</strong>
                                                                        {{ Displaydateformat($chemical->revision_date) ?? '-' }}<br>
                                                                        <strong>File:</strong>
                                                                        @if (!empty($chemical->sds_file_path))
                                                                            <a href="{{ admin_url($chemical->sds_file_path) }}"
                                                                                target="_blank">
                                                                                {{ $chemical->sds_org_name ?? 'View SDS' }}
                                                                            </a>
                                                                        @else
                                                                            -
                                                                        @endif
                                                                    </td>
                                                                    <td>--</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="card-header card-header-inner ">
                                                <h6 class="text-white">SECTION C : PREPARED BY</h6>
                                            </div>

                                            <div class="row g-3 px-4 pt-4">

                                                <div class="col-md-4 form-input">
                                                    <label for="reporter_name" class="form-label bold">Name</label>
                                                    <div>{{ getuser($chemicalDetails->created_by)->name }}</div>

                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="reporter_designation"
                                                        class="form-label bold">Designation</label>
                                                    <div>
                                                        {{ getuser($chemicalDetails->created_by)->user_designation_name }}
                                                    </div>

                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="dateandtime" class="form-label bold">Date &
                                                        Time</label>
                                                    <div>{{ displayDateTimeFormat($chemicalDetails->created_at) }}
                                                    </div>
                                                </div>

                                                <div class="col-md-12 form-input">
                                                    <label for="reporter_remarks" class="form-label bold">Remarks</label>
                                                    <div>
                                                        {{ $chemicalDetails->remarks }}
                                                    </div>
                                                </div>

                                            </div>

                                            @if (
                                                $chemicalDetails->chemical_status == CHEMICAL_SUPERVIOR_REJECTED ||
                                                    $chemicalDetails->chemical_status == CHEMICAL_ACKNOWLEDGMENT_PENDING)

                                                <div class="card-header card-header-inner ">
                                                    <h6 class="text-white">Approval Log</h6>
                                                </div>

                                                <div class="row g-3 px-4 pt-4">

                                                    <div class="table-responsiv">
                                                        <table class="table mb-0 table-borderless">
                                                            <tbody>

                                                                @foreach ($statuslog as $status)
                                                                    <tr style="background-color: #aaa">
                                                                        <td colspan="6" style="font-weight:500;">
                                                                            Status -
                                                                            {!! chemicalStatus($status->to_status) !!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width: 10%">Name</th>
                                                                        <td style="width: 5%">:</td>
                                                                        <td style="width: 30%">
                                                                            {{ getusername($status->created_by) }}</td>
                                                                        <th style="width: 10%">Date</th>
                                                                        <td style="width: 5%">:</td>
                                                                        <td style="width: 30%">
                                                                            {{ displayDateTimeformat($status->created_at) }}
                                                                        </td>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Description</th>
                                                                        <td>:</td>
                                                                        <td colspan="4">
                                                                            {{ $status->status_description }}</td>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            @endif


                                            @if (
                                                $chemicalDetails->chemical_status == CHEMICAL_SUPERVIOR_REJECTED ||
                                                    $chemicalDetails->chemical_status == CHEMICAL_ACKNOWLEDGMENT_PENDING)
                                                <div class="card-header card-header-inner ">
                                                    <h6 class="text-white">Supervior Approval</h6>
                                                </div>

                                                <form method="POST">

                                                    <div class="row g-3 px-4 pt-4">

                                                        <div class="col-md-4 form-input">
                                                            <label for="approved_by_id"
                                                                class="form-label bold">Name</label>
                                                            <div>{{ getusername($chemicalDetails->approved_by_id) }}
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="reporter_designation"
                                                                class="form-label bold">Designation</label>
                                                            <div>
                                                                {{ getuser($chemicalDetails->approved_by_id)->user_designation_name }}
                                                            </div>

                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="approved_by_date" class="form-label bold">Date
                                                                &
                                                                Time</label>
                                                            <div>
                                                                {{ displayDateTimeformat($chemicalDetails->approved_by_date) }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 form-input">
                                                            <label for="approved_by_remarks"
                                                                class="form-label bold">Remarks</label>
                                                            <div>{{ $chemicalDetails->approved_by_remarks }}</div>
                                                        </div>

                                                    </div>
                                                </form>
                                            @endif

                                            @if ($chemicalDetails->chemical_status == CHEMICAL_STATUS_APPROVED)
                                                <div class="card-header card-header-inner ">
                                                    <h6 class="text-white">SECTION D : Review and Endorsement</h6>
                                                </div>

                                                <form>

                                                    <div class="col-md-12 mt-2 form-input bold">
                                                        <p style="font-size: 16px;">
                                                            I <strong> <u> {{ getusername($chemicalDetails->acknowledged_by) }} </u> </strong>
                                                            hereby
                                                            declare that this
                                                            chemical register shall be accessible to all employees at
                                                            the place of work who may be exposed or are likely to be
                                                            exposed to chemicals hazardous to health.
                                                        </p>
                                                    </div>

                                                    <div class="row g-3 px-4 pt-4">
                                                        <div class="col-md-4 form-input">
                                                            <label for="reporter_name"
                                                                class="form-label bold">Name</label>
                                                            <div>{{ getusername($chemicalDetails->acknowledged_by) }}
                                                            </div>

                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="reporter_designation"
                                                                class="form-label bold">Designation</label>
                                                            <div>
                                                                {{ getuser($chemicalDetails->acknowledged_by)->user_designation_name }}
                                                            </div>

                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="dateandtime" class="form-label bold">Date &
                                                                Time</label>
                                                            <div>
                                                                {{ displayDateTimeformat($chemicalDetails->acknowledged_at) }}
                                                            </div>
                                                        </div>

                                                    </div>

                                                </form>
                                            @endif

                                        </div>
                                    </div>
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
                $(function() {

                    $(document).on('change', '.supplier', function() {
                        alert(1)
                        var selectedOption = this.options[this.selectedIndex];
                        var dataAddress = selectedOption.getAttribute('data-address');
                        var dataPh = selectedOption.getAttribute('data-ph');

                        var $row = $(this).closest('.chemical_list');

                        $row.find('.supplier_address').val(dataAddress || '');
                        $row.find('.supplier_ph').val(dataPh || '');
                    });


                    $('#supervisor_approval').validate({
                        rules: {
                            remarks: {
                                required: true,
                            },
                        },
                        messages: {
                            remarks: {
                                required: "Please enter the Remarks",
                            },
                        },
                        errorElement: 'span',
                        errorPlacement: function(error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-input').append(error);
                        },
                        highlight: function(element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                            $(element).closest(".form-input").addClass("selecterror");
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                            $(element).closest(".form-input").removeClass("selecterror");
                        },
                    });

                    $('#ghse_approval').validate({
                        rules: {
                            remarks: {
                                required: true,
                            },
                        },
                        messages: {
                            remarks: {
                                required: "Please enter the Remarks",
                            },
                        },
                        errorElement: 'span',
                        errorPlacement: function(error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-input').append(error);
                        },
                        highlight: function(element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                            $(element).closest(".form-input").addClass("selecterror");
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                            $(element).closest(".form-input").removeClass("selecterror");
                        },
                    });

                });
            </script>
        @endpush
