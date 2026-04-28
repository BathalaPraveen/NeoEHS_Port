@extends('admin.layouts.layout')
@section('title', 'Chemical edit')
@section('pageurl', admin_url('chemical/chemical/list'))

@push('style')
    <style>
        .chemical_list {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .chemical-table {
            table-layout: auto;
            width: 100%;
            border-collapse: collapse;
        }

        .chemical-scroll-container {
            overflow-x: auto;
        }

        .chemical-table th,
        .chemical-table td {
            white-space: nowrap;
        }

        /* Apply fixed width styling to table header & body */
        .chemical-table th.fixed-width,
        .chemical-table td.fixed-width {
            min-width: 150px;
        }

        /* Optional: make entire container scroll if needed */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
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
                            <li class="breadcrumb-item active" aria-current="page">Chemical Edit</li>
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
                                    <h5 class="card-title">Chemical Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('chemical/chemical/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="chemical_edit" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('chemical/chemical/edit/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ encryptId($chemicalDetails->id) }}">
                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">Section A: COMPANY INFORMATION</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="container-bg">
                                                <h6>1 Company Details</h6>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 form-input">
                                                    <label for="company" class="form-labe   l require">Name of
                                                        Company</label>
                                                    <select name="company" id="company" class="form-control select2">
                                                        <option>Select Company</option>
                                                        @foreach ($companyList as $company)
                                                            <option @if ($chemicalDetails->company_id == $company->id) selected @endif
                                                                value="{{ encryptId($company->id) }}"
                                                                data-address="{{ $company->address }}"
                                                                data-city="{{ $company->city }}"
                                                                data-state="{{ $company->state }}"
                                                                data-roc="{{ $company->roc_no }}"
                                                                data-pincode="{{ $company->pincode }}"
                                                                data-dosh="{{ $company->dosh_reg_no }}"
                                                                data-cos="{{ $company->code_of_sector }}"
                                                                data-coi="{{ $company->class_of_industry }}">
                                                                {{ $company->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_dosh" class="form-label require">DOSH
                                                        Registration No</label>
                                                    <input type="text" name="company_dosh" class="form-control"
                                                        id="company_dosh" value="{{ $company->dosh_reg_no }}" readonly
                                                        required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_roc" class="form-label require">ROC No</label>
                                                    <input type="text" name="company_roc" class="form-control"
                                                        id="company_roc" value="{{ $company->roc_no }}" readonly required>
                                                </div>

                                                <div class="col-md-12 form-input">
                                                    <label for="company_address" class="form-label require">Address</label>
                                                    <textarea name="company_address" id="company_address" class="form-control" readonly rows="3"
                                                        value="{{ $company->address }}"></textarea>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_city" class="form-label require">City</label>
                                                    <input type="text" name="company_city"readonly class="form-control"
                                                        id="company_city" value=" {{ $company->city }}" required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_state" class="form-label require">State</label>
                                                    <input type="text" name="company_state" class="form-control"
                                                        id="company_state" value="{{ $company->state }}" readonly required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_pincode" class="form-label require">Postcode</label>
                                                    <input type="text" name="company_pincode" class="form-control"
                                                        id="company_pincode" value="{{ $company->pincode }}" readonly
                                                        required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="gps_coordinate" class="form-label require">GPS
                                                        Coordinate</label>
                                                    <input type="text" name="gps_coordinate" class="form-control"
                                                        id="gps_coordinate" pattern="^[A-Za-z0-9\/\-\_\.\, ]+$"
                                                        title="Only letters, numbers, spaces, and characters: / - _ . , are allowed."
                                                        value="{{ $chemicalDetails->gps_coordinate }}" required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Telephone
                                                        no</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        value="{{ $chemicalDetails->telephone_no }}" readonly
                                                        id="company_telephone">
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_email" class="form-label ">Company Email</label>
                                                    <input type="text" name="company_email" class="form-control"
                                                        id="company_email" value="customerservice@bintuluport.com.my"
                                                        readonly>
                                                </div>

                                                <div class="container-bg">
                                                    <h6>2 Contact Person</h6>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_name"
                                                        class="form-label require">Name</label>
                                                    <input type="text" name="contact_person_name" class="form-control"
                                                        id="contact_person_name" value="{{ Auth::user()->name }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_designation"
                                                        class="form-label require">Designation</label>
                                                    <input type="text" name="contact_person_designation"
                                                        class="form-control" id="contact_person_designation"
                                                        value="{{ getDesignationName(Auth::user()->designation) }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_ph" class="form-label require">Contact
                                                        Number</label>
                                                    <input type="text" name="contact_person_ph" class="form-control"
                                                        id="contact_person_ph"
                                                        value="{{ $chemicalDetails->contact_person_ph }}">
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_email"
                                                        class="form-label require">Email</label>
                                                    <input type="text" name="contact_person_email"
                                                        class="form-control" id="contact_person_email"
                                                        value="{{ Auth::user()->email }}" readonly>
                                                </div>

                                                <div class="container-bg">
                                                    <h6>3 Industrial Classification Code</h6>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="" class="form-label require">Industrial Sector
                                                        Division</label>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="industrial_sector" rows="2" class="form-control" readonly>{{ $chemicalDetails->industrial_sector }} </textarea>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="industrial_classification"
                                                        class="form-label require">Industrial
                                                        Classification (Fraction) Code</label>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="industrial_classification" rows="2" class="form-control" readonly>{{ $chemicalDetails->industrial_classification }}</textarea>
                                                </div>

                                                <div class="container-bg">
                                                    <h6>4 Company Activity</h6>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_activity" class="form-label require">Company
                                                        Activity</label>
                                                    <select name="company_activity" id="company_activity"
                                                        class="select2 form-control">
                                                        <option value=""> Select Company Activity
                                                        </option>
                                                        @foreach ($company_activity_type as $activity_type)
                                                            <option value="{{ encryptId($activity_type->id) }}"
                                                                {{ $activity_type->id == $chemicalDetails->company_activity ? 'selected' : '' }}>
                                                                {{ $activity_type->activity_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center gap-3">

                                                <div class="position-relative">
                                                    <h6 class="text-white">SECTION B : LIST OF CHEMICALS HAZARDOUS TO
                                                        HEALTH</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmore">Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="px-4 pt-4">
                                            <div class="table-responsive chemical-scroll-container">
                                                <table class="chemical-table table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="fixed-width" colspan="2">Section B</th>
                                                            <th class="fixed-width" colspan="7">LIST OF CHEMICALS
                                                                HAZARDOUS TO HEALTH</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="fixed-width">
                                                                <label for="work_area" class="form-label require">Work
                                                                    area</label>
                                                            </th>
                                                            <td class="fixed-width form-input" colspan="5">
                                                                <input type="text" name="work_area" id="work_area"
                                                                    class="form-control"
                                                                    value="{{ $chemicalDetails->work_area }}" required>
                                                            </td>
                                                            <th class="fixed-width" rowspan="2">No. of Workers</th>
                                                            <td class="fixed-width form-input">
                                                                <input type="text" name="no_of_workers_male"
                                                                    id="no_of_workers_male" class="form-control"
                                                                    value="{{ $chemicalDetails->worker_male }}" required>
                                                            </td>
                                                            <th class="fixed-width">Male</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="fixed-width">
                                                                <label for="work_process" class="form-label require">Work
                                                                    Process</label>
                                                            </th>
                                                            <td class="fixed-width form-input" colspan="5">
                                                                <input type="text" name="work_process"
                                                                    id="work_process" class="form-control"
                                                                    value="{{ $chemicalDetails->work_process }}" required>
                                                            </td>
                                                            <td class="fixed-width form-input">
                                                                <input type="text" name="no_of_workers_female"
                                                                    id="no_of_workers_female" class="form-control"
                                                                    value="{{ $chemicalDetails->worker_female }}"
                                                                    required>
                                                            </td>
                                                            <th class="fixed-width">Female</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="fixed-width" style="min-width: 160px;">Chemical
                                                                Name</th>
                                                            <th class="fixed-width" style="min-width: 180px;">Name of
                                                                Hazardous Ingredient</th>
                                                            <th class="fixed-width" style="width: 200px;">CAS No</th>
                                                            <th class="fixed-width" style="min-width: 220px;">Composition
                                                                of Hazardous Ingredient (%)</th>
                                                            <th class="fixed-width" style="min-width: 160px;">Physical
                                                                Form</th>
                                                            <th class="fixed-width" style="min-width: 280px;">Avg.
                                                                Quantity (monthly / yearly)</th>
                                                            <th class="fixed-width" style="min-width: 300px;">Supplier
                                                                Info</th>
                                                            <th class="fixed-width" style="min-width: 300px;">SDS
                                                                Availability & Upload</th>
                                                            <th class="fixed-width" style="width: 80px;">Action</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody id="chemicaldetails">
                                                        @foreach ($chemicallistDetails as $index => $detail)
                                                            <tr class="chemical_list">

                                                                <td class="form-input">
                                                                    <select name="chemicalname[{{ $index + 1 }}]"
                                                                        id="chemicalname_{{ $index + 1 }}"
                                                                        class="form-control select2 validate-select-required">
                                                                        <option value="" selected>Please Select
                                                                            Chemical</option>
                                                                        @foreach ($chemicalMasterList as $chemicals)
                                                                            <option
                                                                                value="{{ encryptId($chemicals->id) }}"
                                                                                @if (isset($chemicallistDetails[$index]) && $chemicallistDetails[$index]->name_of_chemical == $chemicals->id) selected @endif>
                                                                                {{ $chemicals->chemical_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                </td>

                                                                <td class="form-input">
                                                                    <input type="text"
                                                                        name="name_of_hazardous_ingredient[{{ $index + 1 }}]"
                                                                        id="name_of_hazardous_ingredient_{{ $index + 1 }}"
                                                                        class="form-control"
                                                                        value="{{ $detail->name_of_hazardous_ingredient }}">
                                                                </td>

                                                                <td class="form-input">
                                                                    <input type="text"
                                                                        name="casno[{{ $index + 1 }}]"
                                                                        id="casno_{{ $index + 1 }}"
                                                                        class="form-control" pattern="[0-9-]+"
                                                                        value="{{ $detail->cas_no }}">
                                                                </td>

                                                                <td class="form-input">
                                                                    <input type="text"
                                                                        name="compostion_hazardous_ingredient[{{ $index + 1 }}]"
                                                                        id="compostion_hazardous_ingredient_{{ $index + 1 }}"
                                                                        class="form-control"
                                                                        value="{{ $detail->compostion_hazardous_ingredient }}">
                                                                </td>

                                                                @php
                                                                    $fieldIndex = $index + 1;
                                                                    $PhysicalArray = string_to_array(
                                                                        $detail->physical_form_of_chemical,
                                                                    );
                                                                    $otherValue = $detail->phy_others ?? '';
                                                                    $isOthersSelected = false;
                                                                @endphp

                                                                <td style="min-width:300px;" class="form-input">
                                                                    <select
                                                                        name="phyformofchemical[{{ $fieldIndex }}][]"
                                                                        id="phyformofchemical_{{ $fieldIndex }}"
                                                                        class="form-control select2 validate-select-required phyform-select"
                                                                        data-index="{{ $fieldIndex }}">
                                                                        <option value="" disabled>Select Physical
                                                                            Form</option>
                                                                        @foreach ($phyformofchemicalList as $phyformofchemical)
                                                                            @php
                                                                                $isOther =
                                                                                    strtolower(
                                                                                        trim(
                                                                                            $phyformofchemical['name'],
                                                                                        ),
                                                                                    ) === 'others';
                                                                                $phyId = encryptId(
                                                                                    $phyformofchemical['id'],
                                                                                );
                                                                                $isSelected = in_array(
                                                                                    $phyformofchemical['id'],
                                                                                    $PhysicalArray,
                                                                                );
                                                                                if ($isOther && $isSelected) {
                                                                                    $isOthersSelected = true;
                                                                                }
                                                                            @endphp
                                                                            <option value="{{ $phyId }}"
                                                                                @if ($isOther) data-other="1" @endif
                                                                                @if ($isSelected) selected @endif>
                                                                                {{ $phyformofchemical['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>

                                                                    <div
                                                                        class="phyOtherContainer mt-3 @if (!$isOthersSelected) d-none @endif">
                                                                        <input type="text"
                                                                            name="phy_others[{{ $fieldIndex }}]"
                                                                            id="phy_others_{{ $fieldIndex }}"
                                                                            class="form-control" placeholder="Enter form"
                                                                            value="{{ $otherValue }}">
                                                                    </div>
                                                                </td>




                                                                <input type="hidden" name="editid[{{ $index }}]"
                                                                    value="{{ encryptId($detail->id) }}"
                                                                    id="editid_{{ $index }}">

                                                                <td class="form-input" style="min-width: 300px;">
                                                                    @php
                                                                        $qtyParts = string_to_array(
                                                                            $detail->usage_of_chemical_quantity,
                                                                            '_',
                                                                        );
                                                                        $unit_id = isset($detail->uocunit)
                                                                            ? encryptId($detail->uocunit)
                                                                            : '';
                                                                    @endphp

                                                                    <div class="d-flex flex-column">
                                                                        {{-- Quantity and Unit --}}
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <input type="text"
                                                                                name="uocmonth[{{ $index + 1 }}]"
                                                                                id="uocmonth_{{ $index + 1 }}"
                                                                                class="form-control me-2 validate-input-required"
                                                                                style="width: 50%;"
                                                                                placeholder="Enter quantity"
                                                                                value="{{ $qtyParts[0] ?? '' }}">

                                                                            <select name="uocunit[{{ $index + 1 }}]"
                                                                                id="uocunit_{{ $index + 1 }}"
                                                                                class="form-select select2"
                                                                                style="width: 40%;">
                                                                                <option value="">Unit</option>
                                                                                <option value="{{ encryptId(1) }}"
                                                                                    {{ $unit_id == encryptId(1) ? 'selected' : '' }}>
                                                                                    Kg</option>
                                                                                <option value="{{ encryptId(2) }}"
                                                                                    {{ $unit_id == encryptId(2) ? 'selected' : '' }}>
                                                                                    Tonne</option>
                                                                                <option value="{{ encryptId(3) }}"
                                                                                    {{ $unit_id == encryptId(3) ? 'selected' : '' }}>
                                                                                    Litre</option>
                                                                            </select>
                                                                        </div>

                                                                        {{-- Radio Buttons --}}
                                                                        <div class="d-flex gap-3">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="radio"
                                                                                    name="uocmonthyear[{{ $index + 1 }}]"
                                                                                    id="monthly_{{ $index + 1 }}"
                                                                                    value="Monthly"
                                                                                    {{ ($qtyParts[1] ?? '') == 'Monthly' ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="monthly_{{ $index + 1 }}">Monthly</label>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="radio"
                                                                                    name="uocmonthyear[{{ $index + 1 }}]"
                                                                                    id="yearly_{{ $index + 1 }}"
                                                                                    value="Yearly"
                                                                                    {{ ($qtyParts[1] ?? '') == 'Yearly' ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="yearly_{{ $index + 1 }}">Yearly</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                                @foreach ($chemicallistDetails as $index => $detail)
                                                                    <td class="form-input">
                                                                        <div class="row">
                                                                            @php
                                                                                $fieldIndex = $index + 1;
                                                                                $selectedSupplierId = old(
                                                                                    "supplier[$fieldIndex]",
                                                                                    isset($detail->supplier_id)
                                                                                        ? encryptId(
                                                                                            $detail->supplier_id,
                                                                                        )
                                                                                        : '',
                                                                                );
                                                                                $selectedSupplier = $supplierList->firstWhere(
                                                                                    'id',
                                                                                    $detail->supplier_id,
                                                                                );
                                                                            @endphp

                                                                            <div class="col-md-12 mb-2">
                                                                                <select
                                                                                    name="supplier[{{ $fieldIndex }}]"
                                                                                    id="supplier_{{ $fieldIndex }}"
                                                                                    class="form-control select2 validate-select-required supplier"
                                                                                    data-index="{{ $fieldIndex }}">
                                                                                    <option value="">Please Select
                                                                                        Supplier</option>
                                                                                    @foreach ($supplierList as $supplier)
                                                                                        <option
                                                                                            value="{{ encryptId($supplier->id) }}"
                                                                                            data-address="{{ $supplier->address }}"
                                                                                            data-ph="{{ $supplier->contact_no }}"
                                                                                            @if (isset($chemicallistDetails[$index]) && $chemicallistDetails[$index]->supplier_details == $chemicals->id) selected @endif>
                                                                                            {{ $supplier->supplier_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md-12 mb-2">
                                                                                <label class="form-label">Address</label>
                                                                                <textarea rows="3" class="form-control supplier_address" readonly id="supplier_address_{{ $fieldIndex }}">{{ old("supplier_address[$fieldIndex]", $selectedSupplier->address ?? '') }}</textarea>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <label class="form-label">Contact
                                                                                    Number</label>
                                                                                <input type="text"
                                                                                    name="supplier_ph[{{ $fieldIndex }}]"
                                                                                    id="supplier_ph_{{ $fieldIndex }}"
                                                                                    class="form-control supplier_ph"
                                                                                    readonly
                                                                                    value="{{ old("supplier_ph[$fieldIndex]", $selectedSupplier->contact_no ?? '') }}">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endforeach





                                                                @foreach ($chemicallistDetails as $index => $detail)
                                                                    @php
                                                                        $fieldIndex = $index + 1;

                                                                        $prepDate = old(
                                                                            "prep_date.$fieldIndex",
                                                                            $detail->prep_date ?? '',
                                                                        );
                                                                        $revDate = old(
                                                                            "revision_date.$fieldIndex",
                                                                            $detail->revision_date ?? '',
                                                                        );
                                                                        $complyWithSDS = old(
                                                                            "comply_with_classification_sds.$fieldIndex",
                                                                            $detail->comply_with_classification_sds ??
                                                                                '',
                                                                        );
                                                                    @endphp

                                                                    <td class="form-input">
                                                                        <div class="row">
                                                                            <!-- SDS YES/NO -->
                                                                            <div class="col-md-12 mb-2">
                                                                                <select
                                                                                    name="complyWithSDS[{{ $fieldIndex }}]"
                                                                                    id="complyWithSDS{{ $fieldIndex }}"
                                                                                    class="form-control select2 validate-select-required">
                                                                                    <option value="">Attachment of
                                                                                        SDS</option>
                                                                                    <option value="YES"
                                                                                        {{ $complyWithSDS == 'YES' ? 'selected' : '' }}>
                                                                                        YES</option>
                                                                                    <option value="NO"
                                                                                        {{ $complyWithSDS == 'NO' ? 'selected' : '' }}>
                                                                                        NO</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Preparation Date -->
                                                                            <div class="col-md-12 mb-2">
                                                                                <label class="form-label">Date of SDS
                                                                                    preparation</label>
                                                                                <input type="text"
                                                                                    name="prep_date[{{ $fieldIndex }}]"
                                                                                    class="form-control prep_date datepicker"
                                                                                    value="{{ $prepDate }}" readonly>
                                                                            </div>

                                                                            <!-- Revision Date -->
                                                                            <div class="col-md-12 mb-2">
                                                                                <label class="form-label">Date of SDS
                                                                                    revision</label>
                                                                                <input type="text"
                                                                                    name="revision_date[{{ $fieldIndex }}]"
                                                                                    class="form-control revision_date datepicker"
                                                                                    value="{{ $revDate }}" readonly>
                                                                            </div>


                                                                            <!-- File Upload -->
                                                                            <div class="col-md-12">
                                                                                <label class="form-label">Safety Data Sheet
                                                                                    (SDS)
                                                                                    File Upload</label>
                                                                                <input type="file"
                                                                                    name="sdsattachment[{{ $fieldIndex }}]"
                                                                                    id="sdsattachment_{{ $fieldIndex }}"
                                                                                    class="form-control {{ empty($detail->sds_file_path) ? 'validate-file-required' : '' }}">

                                                                                <!-- Show previous file if exists -->
                                                                                @if (!empty($detail->sds_file_path))
                                                                                    <div class="mt-2">
                                                                                        <a href="{{ asset('storage/sds_files/' . $detail->sds_file_path) }}"
                                                                                            target="_blank">
                                                                                            View Previously Uploaded File
                                                                                        </a>
                                                                                    </div>
                                                                                @endif

                                                                                <small class="text-danger">
                                                                                    Max size 5MB. Accepts: jpeg, jpg, png,
                                                                                    pdf, doc(x), xls(x), ppt(x).
                                                                                </small>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endforeach




                                                                <td class="text-center">
                                                                    <i class="fa fa-trash removerow"
                                                                        style="cursor:pointer; color:red;"></i>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">SECTION C : PREPARED BY</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="reporter_name" class="form-label require">Name</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="reporter_name" data-error="Please enter " placeholder=""
                                                        name="reporter_name" readonly value="{{ Auth::user()->name }}">

                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="reporter_designation"
                                                    class="form-label require">Designation</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="reporter_designation" data-error="Please enter "
                                                        placeholder="" name="reporter_designation" readonly
                                                        value="{{ Auth::user()->user_designation_name }}">

                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="dateandtime" class="form-label require">Date & Time</label>

                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="dateandtime" data-error="Please enter " placeholder=""
                                                        name="dateandtime" readonly
                                                        value="{{ Auth::user()->user_designation_name }}">

                                                </div>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="reporter_remarks" class="form-label require">Remarks</label>
                                                <textarea name="reporter_remarks" id="reporter_remarks" class="form-control" rows="5" required>{{ $chemicalDetails->remarks }}</textarea>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
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
        $('#company').change(function() {
            var companyId = $(this).val();

            if (companyId != '') {

                var selectedOption = this.options[this.selectedIndex];
                var dataAddress = selectedOption.getAttribute('data-address');
                var datacity = selectedOption.getAttribute('data-city');
                var datastate = selectedOption.getAttribute('data-state');
                var datapincode = selectedOption.getAttribute('data-pincode');
                var datadosh = selectedOption.getAttribute('data-dosh');
                var datacos = selectedOption.getAttribute('data-cos');
                var datacoi = selectedOption.getAttribute('data-coi');
                var dataca = selectedOption.getAttribute('data-ca');
                var dataroc = selectedOption.getAttribute('data-roc');



                $('#company_address').val(dataAddress);
                $('#company_city').val(datacity);
                $('#company_state').val(datastate);
                $('#company_pincode').val(datapincode);
                $('#company_dosh').val(datadosh);
                $('#company_code_of_sector').val(datacos);
                $('#company_class_of_industry').val(datacoi);
                $('#company_roc').val(dataroc);


            } else {
                $('#company_address').val("");
                $('#company_city').val("");
                $('#company_state').val("");
                $('#company_pincode').val("");
                $('#company_dosh').val("");
                $('#company_code_of_sector').val("");
                $('#company_class_of_industry').val("");
                $('#company_roc').val("");

            }
        });

        $(document).ready(function() {
            var defaultCompanyId = "{{ encryptId($chemicalDetails->company_id ?? '') }}";
            if (defaultCompanyId) {
                $('#company').val(defaultCompanyId).trigger('change');
            }
        });

        $(document).ready(function() {
            $(document).on('change', '.supplier', function() {
                var index = $(this).data('index');
                var selectedOption = this.options[this.selectedIndex];

                var address = $(selectedOption).data('address') || '';
                var contact = $(selectedOption).data('ph') || '';


                $('#supplier_address_' + index).val(address);
                $('#supplier_ph_' + index).val(contact);
            });

            $('.supplier').each(function() {
                $(this).trigger('change');
            });
        });

        $(document).ready(function() {
            $('#addmore').on('click', function() {
                $('#addmore').attr("disabled", true);
                var rowCount = $("#chemicaldetails .chemical_list").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only can be added',
                    });
                    $('#addmore').attr("disabled", false);
                    return;
                }

                var newRow = $(".chemical_list").first().clone();
                var newIndex = rowCount + 1;

                // Clear values and reset inputs
                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                // Reset text/hidden inputs
                newRow.find("input[type='text'], input[type='hidden']").each(function() {
                    $(this).val("").removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Reset file input
                newRow.find('.fileview').remove();
                newRow.find("input[type='file']").each(function() {
                    $(this).val("");

                    if (!$(this).hasClass('validate-file-required')) {
                        $(this).addClass('validate-file-required');
                    }

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Reset select elements
                newRow.find("select").each(function() {
                    $(this).val("").removeClass("select2-hidden-accessible")
                        .removeAttr("data-select2-id tabindex aria-hidden aria-describedby");
                    $(this).find('option').removeAttr('data-select2-id');

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Destroy and clean up select2
                newRow.find(".select2").each(function() {
                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    $(this).next(".select2-container").remove();
                });

                $("#chemicaldetails").append(newRow);

                newRow.find(".select2").select2();
                $(".select2").select2(); // reinit globally just in case

                $('#addmore').attr("disabled", false);
            });

            // Remove Row
            $(document).on('click', '.removerow', function() {
                var rowCount = $("#chemicaldetails .chemical_list").length;

                if (rowCount <= 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Minimum one record required',
                    });
                    return;
                }

                $(this).closest(".chemical_list").remove();
                $('#addmore').attr("disabled", false);

                // Reindex remaining rows
                $("#chemicaldetails .chemical_list").each(function(index) {
                    var newIndex = index + 1;

                    $(this).find("input[type='text'], input[type='hidden'], input[type='file']")
                        .each(function() {
                            var oldName = $(this).attr("name");
                            if (oldName) $(this).attr("name", oldName.replace(/\[\d+\]/,
                                `[${newIndex}]`));

                            var oldId = $(this).attr("id");
                            if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                        });

                    $(this).find(".risk_matrix").each(function() {
                        var oldId = $(this).attr("id");
                        if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                    });

                    // Clean and reinit select2
                    $(this).find("select").select2('destroy').each(function() {
                        $(this).removeClass("select2-hidden-accessible")
                            .removeAttr(
                                "data-select2-id tabindex aria-hidden aria-describedby");
                        $(this).find('option').removeAttr('data-select2-id');

                        var oldName = $(this).attr("name");
                        if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                        var oldId = $(this).attr("id");
                        if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                    });

                    $(this).find(".select2-container").remove();
                    $(this).find(".select2").select2();
                });

                $(".select2").select2();
            });
        });

        $(document).ready(function() {
            $('.phyform-select').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var isOther = selectedOption.data('other') === 1;
                var container = $(this).closest('td').find('.phyOtherContainer');

                if (isOther) {
                    container.removeClass('d-none');
                } else {
                    container.addClass('d-none');
                    container.find('input').val('');
                }
            });

            // Trigger change on page load for edit form to show 'Other' if selected
            $('.phyform-select').each(function() {
                var selectedOption = $(this).find('option:selected');
                if (selectedOption.data('other') === 1) {
                    $(this).trigger('change');
                }
            });
        });


        $(function() {
            $('#chemical_edit').validate({
                rules: {
                    company: {
                        required: true,
                    },

                    company_email: {
                        email: true,
                    },
                    company_address: {
                        required: true,
                    },
                    company_city: {
                        required: true,
                    },
                    company_state: {
                        required: true,
                    },
                    company_pincode: {
                        required: true,
                    },
                    company_dosh: {
                        required: true,
                    },
                    company_code_of_sector: {
                        required: true,
                    },
                    company_class_of_industry: {
                        required: true,
                    },
                    company_activity: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    processoperation: {
                        required: true,
                    },
                    hazardous_chemical: {
                        required: true,
                    },
                    no_of_workers_male: {
                        required: true,
                    },
                    no_of_workers_female: {
                        required: true,
                    },
                    reporter_remarks: {
                        required: true,
                    },


                },
                messages: {
                    company: {
                        required: "Please select Company",
                    },

                    company_email: {
                        email: "Please enter valid email",
                    },
                    company_address: {
                        required: "Please enter Address",
                    },
                    company_city: {
                        required: "Please enter City",
                    },
                    company_state: {
                        required: "Please enter State",
                    },
                    company_pincode: {
                        required: "Please enter Pincode",
                    },
                    company_dosh: {
                        required: "Please enter DOSH Registration No",
                    },
                    company_code_of_sector: {
                        required: "Please enter Code of Sector",
                    },
                    company_class_of_industry: {
                        required: "Please enter Class of Industry",
                    },
                    company_activity: {
                        required: "Please enter Company Activity",
                    },
                    location: {
                        required: "Please enter Location",
                    },
                    processoperation: {
                        required: "Please enter Process Operation",
                    },
                    hazardous_chemical: {
                        required: "Please enter No. of Hazardous Chemical",
                    },
                    no_of_workers_male: {
                        required: "Please enter no of works male",
                    },
                    no_of_workers_female: {
                        required: "Please enter No of workers female",
                    },
                    reporter_remarks: {
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
                    $(element).closest(".form-input").addClass("selecterror");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                },
            });
        });

        $('#location').change(function() {
            var locationId = $(this).val();
            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/list/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#specific_location').empty().append(
                            '<option >Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            $('#specific_location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#specific_location').trigger('change.select2');
                    }
                });
            } else {
                $('#specific_location').empty().append('<option >Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
            }
        });
    </script>
@endpush
