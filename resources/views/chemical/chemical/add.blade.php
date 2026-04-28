@extends('admin.layouts.layout')
@section('title', 'Chemical Add')
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
                            <li class="breadcrumb-item active" aria-current="page">Chemical Add</li>
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
                                    <h5 class="card-title">Chemical Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('chemical/chemical/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="chemical_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('chemical/chemical/add/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf

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
                                                        <option value="">Select Company</option>
                                                        @foreach ($companyList as $company)
                                                            <option value="{{ encryptId($company->id) }}"
                                                                data-address="{{ $company->address }}"
                                                                data-city="{{ $company->city }}"
                                                                data-state="{{ $company->state }}"
                                                                data-pincode="{{ $company->pincode }}"
                                                                data-dosh="{{ $company->dosh_reg_no }}"
                                                                data-roc="{{ $company->roc_no }}"
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
                                                        id="company_dosh" value="" readonly required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_roc" class="form-label require">ROC No</label>
                                                    <input type="text" name="company_roc" class="form-control"
                                                        id="company_roc" value="" readonly required>
                                                </div>

                                                <div class="col-md-12 form-input">
                                                    <label for="company_address" class="form-label require">Address</label>
                                                    <textarea name="company_address" id="company_address" class="form-control" readonly rows="3"></textarea>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_city" class="form-label require">City</label>
                                                    <input type="text" name="company_city" value="" readonly
                                                        class="form-control" id="company_city" required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_state" class="form-label require">State</label>
                                                    <input type="text" name="company_state" class="form-control"
                                                        id="company_state" value="" readonly required>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_pincode" class="form-label require">Postcode</label>
                                                    <input type="text" name="company_pincode" class="form-control"
                                                        id="company_pincode" value="" readonly required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="gps_coordinate" class="form-label require">GPS
                                                        Coordinate</label>
                                                    <input type="text" name="gps_coordinate"
                                                        pattern="^[A-Za-z0-9\/\-\_\.\, ]+$"
                                                        title="Only letters, numbers, spaces, and characters: / - _ . , are allowed."
                                                    class="form-control" id="gps_coordinate" value="" required>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Telephone
                                                        no</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        id="company_telephone" value="+6086 291001" readonly>
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
                                                        value="{{ getDesignationName(AUth::user()->designation) }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_ph" class="form-label require">Contact
                                                        Number</label>
                                                    <input type="text" name="contact_person_ph" class="form-control"
                                                        id="contact_person_ph" value="">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="contact_person_email"
                                                        class="form-label require">Email</label>
                                                    <input type="text" name="contact_person_email"
                                                        class="form-control" id="contact_person_email"
                                                        value="{{ AUth::user()->email }}" readonly>
                                                </div>

                                                <div class="container-bg">
                                                    <h6>3 Industrial Classification Code</h6>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="" class="form-label require">Industrial Sector
                                                        Division</label>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="industrial_sector" id="" rows="2" class="form-control" readonly> 52 – Penggudangan dan aktiviti sokongan untuk pengangkutan
                                                        </textarea>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="industrial_classification"
                                                        class="form-label require">Industrial
                                                        Classification (Fraction) Code</label>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <textarea name="industrial_classification" id="" rows="2" class="form-control" readonly> 52521 – Operasi perkhidmatan pelabuhan dan limbungan
                                                        </textarea>
                                                </div>

                                                <div class="container-bg">
                                                    <h6>4 Company Activity</h6>
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_activity" class="form-label require">Company
                                                        Activity</label>
                                                    <select name="company_activity" id=""
                                                        class="select2 form-control">
                                                        <option value="" selected disabled>Select Company Activity
                                                        </option>
                                                        @foreach ($company_activity_type as $activity_type)
                                                            <option value="{{ encryptId($activity_type->id) }}">
                                                                {{ $activity_type->activity_name }}</option>
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
                                                                    class="form-control" required>
                                                            </td>
                                                            <th class="fixed-width" rowspan="2">No. of Workers</th>
                                                            <td class="fixed-width form-input">
                                                                <input type="text" name="no_of_workers_male"
                                                                    id="no_of_workers_male" class="form-control" required>
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
                                                                    id="work_process" class="form-control" required>
                                                            </td>
                                                            <td class="fixed-width form-input">
                                                                <input type="text" name="no_of_workers_female"
                                                                    id="no_of_workers_female" class="form-control"
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
                                                        <tr class="chemical_list">

                                                            <td class="form-input">
                                                                <select name="chemicalname[1]" id="chemicalname_1"
                                                                    class="form-control select2 validate-select-required">
                                                                    <option value="">Please Select Chemical</option>
                                                                    @foreach ($chemicalMasterList as $chemical)
                                                                        <option value="{{ encryptId($chemical->id) }}">
                                                                            {{ $chemical->chemical_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    name="name_of_hazardous_ingredient[1]"
                                                                    id="name_of_hazardous_ingredient_1"
                                                                    class="form-control validate-input-required">
                                                            </td>

                                                            <td class="form-input">
                                                                <input type="text" name="casno[1]" id="casno_1"
                                                                    class="form-control validate-input-required"
                                                                    pattern="[0-9-]+">
                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    name="compostion_hazardous_ingredient[1]"
                                                                    id="compostion_hazardous_ingredient_1"
                                                                    class="form-control validate-input-required"
                                                                    pattern="[0-9.-]+">
                                                            </td>
                                                            <td class="form-input">
                                                                <select name="phyformofchemical[1]"
                                                                    id="phyformofchemical_1"
                                                                    class="form-control select2 validate-select-required phyform-select"
                                                                    data-index="1">
                                                                    <option value="" selected disabled> Select
                                                                        Physical Form</option>
                                                                    @foreach ($phyformofchemicalList as $phy)
                                                                        <option value="{{ encryptId($phy['id']) }}"
                                                                            @if (strtolower(trim($phy['name'])) === 'others') data-other="1" @endif>
                                                                            {{ $phy['name'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                                <div class="phyOtherContainer d-none mt-3">
                                                                    <input type="text" name="phy_others[1]"
                                                                        id="phy_othes_1" class="form-control"
                                                                        placeholder="Enter form">
                                                                </div>
                                                            </td>

                                                            <td class="form-input">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-md-12 d-flex align-items-center gap-2 mb-2">
                                                                        <div class="col-md-8">

                                                                            <input type="text" name="uocmonth[1]"
                                                                                id="uocmonth_1"
                                                                                class="form-control validate-input-required"
                                                                                pattern="[A-Za-z0-9/ ]+"
                                                                                placeholder="Enter quantity">
                                                                        </div>
                                                                        <div class="col-md-4">

                                                                            <select name="uocunit[1]" id="uocunit_1"
                                                                                class="form-select select2"
                                                                                style="max-width: 50px;">
                                                                                <option value="{{ encryptId(1) }}">Kg
                                                                                </option>
                                                                                <option value="{{ encryptId(2) }}">Tonne
                                                                                </option>
                                                                                <option value="{{ encryptId(3) }}">Litre
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12 row">
                                                                        <div class="col-md-6 row">
                                                                            <div class="col-md-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="uocmonthyear[1]"
                                                                                    id="uocmonth_month_1" value="Monthly">
                                                                            </div>
                                                                            <div class="col-md-9">
                                                                                <label class="form-check-label"
                                                                                    for="uocmonth_month_1">Monthly</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6 row">
                                                                            <div class="col-md-2">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="uocmonthyear[1]"
                                                                                    id="uocmonth_year_1" value="Yearly">
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <label class="form-check-label"
                                                                                    for="uocmonth_year_1">Yearly</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>


                                                            <td class="form-input">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <select name="supplier[1]" id="supplier_1"
                                                                            class="form-control select2 validate-select-required supplier">
                                                                            <option value="">Please Select Supplier
                                                                            </option>
                                                                            @foreach ($supplierList as $supplier)
                                                                                <option
                                                                                    value="{{ encryptId($supplier->id) }}"
                                                                                    data-address="{{ $supplier->address }}"
                                                                                    data-ph="{{ $supplier->contact_no }}">
                                                                                    {{ $supplier->supplier_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for=""
                                                                            class="form-label">Address</label>
                                                                        <textarea rows="3" class="form-control supplier_address" readonly></textarea>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="" class="form-label">Contact
                                                                            Number</label>
                                                                        <input type="text" name="supplier_ph[1]"
                                                                            class="form-control supplier_ph" readonly>
                                                                    </div>

                                                                </div>

                                                            </td>
                                                            <td class="form-input">
                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <select name="nameofai_sds[1]" id="nameofai_sds_1"
                                                                            class="form-control select2 validate-select-required">
                                                                            <option value="">Attachment of SDS
                                                                            </option>
                                                                            <option value="YES">YES</option>
                                                                            <option value="NO">NO</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <label for="" class="form-label">Date of
                                                                            SDS preparation</label>
                                                                        <input type="text" name="prep_date[1]"
                                                                            class="form-control prep_date datepicker"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label for="" class="form-label">Date of
                                                                            SDS revision</label>
                                                                        <input type="text" name="revision_date[1]"
                                                                            class="form-control revision_date datepicker"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-md-12">

                                                                        <label for="" class="form-label">Safety
                                                                            Data Sheet (SDS) File Upload</label>
                                                                        <input type="file" name="sdsattachment[1]"
                                                                            id="sdsattachment_1"
                                                                            class="form-control validate-file-required">
                                                                        <small class="text-danger">Max size 5MB. Accepts:
                                                                            jpeg,
                                                                            jpg, png, pdf, doc(x), xls(x), ppt(x).</small>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td class="text-center">
                                                                <i class="fa fa-trash removerow"
                                                                    style="cursor:pointer; color:red;"></i>
                                                            </td>
                                                        </tr>
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
                                                <textarea name="reporter_remarks" id="reporter_remarks" class="form-control" rows="5" required></textarea>
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
                var dataroc = selectedOption.getAttribute('data-roc');
                var datacos = selectedOption.getAttribute('data-cos');
                var datacoi = selectedOption.getAttribute('data-coi');
                var dataca = selectedOption.getAttribute('data-ca');

                $('#company_address').val(dataAddress);
                $('#company_city').val(datacity);
                $('#company_state').val(datastate);
                $('#company_pincode').val(datapincode);
                $('#company_dosh').val(datadosh);
                $('#company_roc').val(dataroc);
                $('#company_code_of_sector').val(datacos);
                $('#company_class_of_industry').val(datacoi);
                $('#company_activity').val(dataca);

            } else {
                $('#company_address').val("");
                $('#company_city').val("");
                $('#company_state').val("");
                $('#company_pincode').val("");
                $('#company_dosh').val("");
                $('#company_roc').val("");
                $('#company_code_of_sector').val("");
                $('#company_class_of_industry').val("");
                $('#company_activity').val("");

            }
        });

        $(document).on('change', '.supplier', function() {
            var selectedOption = this.options[this.selectedIndex];
            var dataAddress = selectedOption.getAttribute('data-address');
            var dataPh = selectedOption.getAttribute('data-ph');

            var $row = $(this).closest('.chemical_list');

            $row.find('.supplier_address').val(dataAddress || '');
            $row.find('.supplier_ph').val(dataPh || '');
        });

        $(document).on('change', '.phyform-select', function() {
            let $select = $(this);
            let index = $select.data('index'); // get dynamic index (like 1, 2, etc.)
            let showOther = false;

            // Loop over selected options (in case of multiple select)
            $select.find('option:selected').each(function() {
                if ($(this).data('other') == "1") {
                    showOther = true;
                }
            });

            if (showOther) {
                $select.closest('td').find('.phyOtherContainer').removeClass('d-none');
            } else {
                $select.closest('td').find('.phyOtherContainer').addClass('d-none');
                $select.closest('td').find('.phyOtherContainer input').val(''); // Optional: clear input
            }
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

                var newIndex = rowCount + 1;
                var newRow = $(".chemical_list").first().clone();

                // Reset error states
                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                // Clear text inputs and update names/IDs
                newRow.find("input[type='text']").each(function() {
                    $(this).val("").removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Clear and update radio buttons
                newRow.find("input[type='radio']").each(function(index) {
                    // Uncheck all radios in the cloned row
                    $(this).prop('checked', false).removeAttr("aria-describedby");

                    // Update the name attribute with new index
                    var oldName = $(this).attr("name");
                    if (oldName) {
                        var newName = oldName.replace(/\[\d+\]/, "[" + newIndex + "]");
                        $(this).attr("name", newName);
                    }

                    // Update the ID
                    var oldId = $(this).attr("id");
                    if (oldId) {
                        var newId = oldId.replace(/_\d+$/, "_" + newIndex);
                        $(this).attr("id", newId);

                        // Also update the corresponding <label for="">
                        newRow.find(`label[for='${oldId}']`).attr("for", newId);
                    }
                });


                // Reset file inputs
                newRow.find("input[type='file']").each(function() {
                    $(this).val(null);

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Handle selects
                newRow.find("select").each(function() {
                    $(this).removeClass('select2-hidden-accessible')
                        .removeAttr('data-select2-id tabindex aria-hidden aria-describedby')
                        .find('option').removeAttr('data-select2-id');

                    var oldName = $(this).attr("name");
                    if (oldName) $(this).attr("name", oldName.replace(/\d+/, newIndex));

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Destroy previous select2 to avoid duplicates
                newRow.find(".select2").each(function() {
                    if ($(this).data('select2')) $(this).select2('destroy');
                    $(this).next(".select2-container").remove();
                });

                // Reset textareas (e.g. supplier address)
                newRow.find("textarea").each(function() {
                    $(this).val("");

                    var oldId = $(this).attr("id");
                    if (oldId) $(this).attr("id", oldId.replace(/\d+/, newIndex));
                });

                // Append new row
                $("#chemicaldetails").append(newRow);

                // Re-initialize Select2
                newRow.find(".select2").select2();

                $('#addmore').attr("disabled", false);
            });

        });

        $(document).on('click', '.removerow', function() {
            if ($("#chemicaldetails .chemical_list").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".chemical_list").remove();

                $("#chemicaldetails .chemical_list").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text'], input[type='radio']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find(".risk_matrix").each(function() {

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);
                    });

                    $(this).find("select").select2('destroy');

                    $(this).find(".select2").each(function() {

                        if ($(this).data('select2')) {
                            $(this).select2('destroy');
                        }
                        if ($(this).hasClass("select2-hidden-accessible")) {
                            $(this).next(".select2-container").remove();
                            $(this).removeClass("select2-hidden-accessible");
                        } else {
                            $(this).next(".select2-container").remove();
                        }
                    });

                    $(this).find(".select2-container").remove();

                    $(this).find("select").each(function() {
                        $(this).removeClass(' select2-hidden-accessible');
                        $(this).removeAttr('data-select2-id');
                        $(this).removeAttr('tabindex');
                        $(this).removeAttr('aria-hidden');
                        $(this).removeAttr('aria-describedby');
                        $(this).find('option').removeAttr('data-select2-id');

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var matches = tagName.match(
                            /\['(.*?)'\]/);

                        var newName = oldName.replace(/\d+/, newIndex);
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);

                    });
                    $(this).find(".select2").select2();
                });
                $(".select2").select2();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });

        $(function() {
            $('#chemical_add').validate({
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
                    gps_coordinate: {
                        required: true,
                    },
                    contact_person_ph: {
                        required: true,
                        digits: true,
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
                        digits: true,
                    },
                    no_of_workers_female: {
                        required: true,
                        digits: true,
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
                    gps_coordinate: {
                        required: "Please enter coordinate",
                    },
                    contact_person_ph: {
                        required: "Please enter Contact number",
                        digits: "Please enter only numbers.",
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
                        digits: "Please enter only numbers.",
                    },
                    no_of_workers_female: {
                        required: "Please enter No of workers female",
                        digits: "Please enter only numbers.",
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
