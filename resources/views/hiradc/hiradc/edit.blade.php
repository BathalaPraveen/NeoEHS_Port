@extends('admin.layouts.layout')
@section('title', 'HIRADC Edit')
@section('pageurl', admin_url('hiradc/hiradc/list'))

@push('style')
    <style>
        .chemical_list {
            border: 1px solid #ccc;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .jsa_list {
            border: 1px dotted #ccc;
            padding: 10px;
            margin-bottom: 5px;
        }

        .jsa_list:nth-child(even) {
            background-color: #cfcfcf70;
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
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('hiradc/hiradc/list') }}">HIRADC</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">HIRADC Edit</li>
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
                                    <h5 class="card-title">HIRADC Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('hiradc/hiradc/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="hiradc_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('hiradc/hiradc/edit/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($risk->id) }}">

                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">Section A- Application</h6>
                                        </div>

                                        @php
                                            $user = getUser($risk->created_by);
                                        @endphp

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="row">

                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Risk Assessed
                                                        by</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone" value="{{ $user->name }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Email</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone" value="{{ $user->email }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Company</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone"
                                                        value="{{ $user->companyInfo->company_name }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Division</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone"
                                                        value="{{ $user->divisionInfo->division_name }}">
                                                </div>

                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Department</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone"
                                                        value="{{ $user->DepartmentInfo->department_name }}">
                                                </div>
                                                <div class="col-md-4 form-input">
                                                    <label for="company_telephone" class="form-label ">Date and Time</label>
                                                    <input type="text" name="company_telephone" class="form-control"
                                                        readonly id="company_telephone"
                                                        value="{{ displayDatetimeFormat($risk->created_at) }}">
                                                </div>


                                            </div>
                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">SECTION B - RISK DOCUMENT DETAILS</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="form-input col-md-6">
                                                <label for="document_type" class="form-label require">Document Type</label>

                                                <div>

                                                    @foreach ($documentdetails as $document)
                                                        <input type="radio" name="document_type"
                                                            class="document_type_option" required
                                                            @checked($risk->document_type == $document->id)
                                                            id="document_type_{{ encryptId($document->id) }}"
                                                            value="{{ encryptId($document->id) }}">
                                                        <label
                                                            for="document_type_{{ encryptId($document->id) }}">{{ $document->document_name }}</label>
                                                    @endforeach


                                                </div>
                                            </div>

                                            <div class="form-input col-md-3">
                                                <label for="location" class="form-label require">Document Sub-Type</label>
                                                <select name="docuenttype" class="form-control select2" required
                                                    id="docuenttype">
                                                    <option value="">Select Document Type</option>
                                                    @foreach ($documentsubTypeDetails as $documentsubType)
                                                        <option @selected($risk->document_sub_type == $documentsubType->id)
                                                            value="{{ encryptId($documentsubType->id) }}">
                                                            {{ $documentsubType->documenttype_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-input col-md-3">
                                                <label for="location" class="form-label require">Document Type
                                                    Category</label>
                                                <select name="docuenttypecategory" required class="form-control select2"
                                                    id="docuenttypecategory">
                                                    <option value="">Select Document Type Category</option>
                                                    @foreach ($documentsubTypeCategoryDetails as $documentsubTypeCategory)
                                                        <option @selected($risk->document_sub_type_category == $documentsubTypeCategory->id)
                                                            value="{{ encryptId($documentsubTypeCategory->id) }}">
                                                            {{ $documentsubTypeCategory->category_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="form-input col-md-12">
                                                <label for="location" class="form-label require">Process Type</label>

                                                <div>

                                                    @foreach ($processtypeList as $processtype)
                                                        <input type="radio" name="process_type" required
                                                            @checked($risk->document_type == getProcesstypeId($processtype->process_type_name))
                                                            id="{{ $processtype->process_type_name }}"
                                                            value="{{ $processtype->process_type_name }}">
                                                        <label
                                                            for="{{ $processtype->process_type_name }}">{{ $processtype->process_type_name }}</label>
                                                    @endforeach

                                                </div>
                                            </div>

                                            @php
                                                $processdetailsArray = string_to_array($risk->process_type_details);

                                            @endphp

                                            <div @if ($risk->document_type != 1) style="display:none" @endif
                                                class="process_type_items" id="div_New">
                                                <div class="row form-input ">
                                                    @foreach ($processtypedetails[1] as $subprocesstype)
                                                        <div class="col-md-3 mb-2">
                                                            <input type="checkbox" name="subprocesstype[]"
                                                                class="process_type_items_checkbox validate-checkbox-required"
                                                                @checked(in_array($subprocesstype->id, $processdetailsArray)) required
                                                                id="new_{{ encryptId($subprocesstype->id) }}"
                                                                value="{{ encryptId($subprocesstype->id) }}">
                                                            <label
                                                                for="new_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>



                                            </div>

                                            <div @if ($risk->document_type != 2) style="display:none" @endif
                                                class="process_type_items" id="div_Amendment">
                                                <div class="row form-input ">
                                                    @foreach ($processtypedetails[2] as $subprocesstype)
                                                        <div class="col-md-3 mb-2">
                                                            <input type="checkbox" name="subprocesstype[]"
                                                                @checked(in_array($subprocesstype->id, $processdetailsArray))
                                                                class="process_type_items_checkbox validate-checkbox-required"
                                                                id="amendment_{{ encryptId($subprocesstype->id) }}"
                                                                required value="{{ encryptId($subprocesstype->id) }}">
                                                            <label
                                                                for="amendment_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 form-input">
                                                        <label class="require">Activity Number</label>
                                                        <input type="text" class="form-control validate-input-required" data-error="Please enter Activity Number" name="activity_number_ammednent" id="activity_number_ammednent" value="{{ $risk->activity_number }}">
                                                    </div>
                                                </div>

                                            </div>

                                            <div @if ($risk->document_type != 3) style="display:none" @endif
                                                class="process_type_items" id="div_Withdraw">
                                                <div class="row form-input ">
                                                    @foreach ($processtypedetails[3] as $key => $subprocesstype)
                                                        <div class="col-md-3 mb-2">
                                                            <input type="checkbox" name="subprocesstype[]"
                                                                @checked(in_array($subprocesstype->id, $processdetailsArray))
                                                                class="process_type_items_checkbox validate-checkbox-required"
                                                                required
                                                                id="withdraw_{{ encryptId($subprocesstype->id) }}"
                                                                value="{{ encryptId($subprocesstype->id) }}">
                                                            <label
                                                                for="withdraw_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3 form-input">
                                                        <label class="require">Activity Number</label>
                                                        <input type="text" class="form-control validate-input-required" data-error="Please enter Activity Number" name="activity_number_withdraw" id="activity_number_withdraw" value="{{ $risk->activity_number }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center ">

                                                <div class="position-relative">
                                                    <h6 class="text-white">SECTION C - RISK ASSESSMENT</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmore">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="riskdetails" class="p-2">
                                            @php
                                                $rowId = 1;
                                            @endphp
                                            @foreach ($riskdetails as $risksig)
                                                <div class="jsa_list">
                                                    <div class="row">
                                                        <input type="hidden"
                                                            name="riskdetails[{{ $rowId }}][risk_order_id]"
                                                            value="{{ encryptId($risksig->id) }}"
                                                            id="riskdetails_risk_order_id_{{ $rowId }}">
                                                        <div class="col-md-4 form-input">
                                                            <label class="require">Activities /Area / Process</label>
                                                            <input type="text"
                                                                class="form-control validate-input-required"
                                                                name="riskdetails[{{ $rowId }}][actiities]"
                                                                id="riskdetails_actiities_{{ $rowId }}"
                                                                value="{{ $risksig->activities_area_process }}"
                                                                data-error="Please enter Activities /Area / Process">
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label class="require">C</label>
                                                            <select name="riskdetails[{{ $rowId }}][c]"
                                                                id="riskdetails_c_{{ $rowId }}"
                                                                data-error="Please select C"
                                                                class="form-control select2 validate-select-required"
                                                                style="width:100%">
                                                                <option @selected($risksig->routine_type == 'N') value="N">N
                                                                </option>
                                                                <option @selected($risksig->routine_type == 'NR') value="NR">NR
                                                                </option>

                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label class="require">location Specific</label>
                                                            <input type="text"
                                                                class="form-control validate-input-required"
                                                                data-error="Please enter location Specific"
                                                                name="riskdetails[{{ $rowId }}][locationspecific]"
                                                                value="{{ $risksig->location_specific }}"
                                                                id="riskdetails_locationspecific_{{ $rowId }}">
                                                        </div>

                                                        <div class="col-md-4 form-input documenttype_eai">
                                                            <label class="require">ASPECTS</label>
                                                            <textarea data-error="Please enter ASPECTS" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][aspects]" id="riskdetails_aspects_{{ $rowId }}">{{ $risksig->aspects }}</textarea>
                                                        </div>
                                                        <div class="col-md-4 form-input documenttype_eai">
                                                            <label class="require">IMPACTS</label>
                                                            <textarea data-error="Please enter IMPACTS" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][impacts]" id="riskdetails_impacts_{{ $rowId }}">{{ $risksig->impacts }}</textarea>
                                                        </div>
                                                        <div class="col-md-4 form-input documenttype_eai">
                                                            <label class="require">COMPLIANCE OBLIGATION</label>
                                                            <textarea data-error="Please enter COMPLIANCE OBLIGATION" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][complaince_obligation]"
                                                                id="riskdetails_complaince_obligation_{{ $rowId }}">{{ $risksig->compliance_obligation }}</textarea>
                                                        </div>


                                                        <div class="col-md-4 form-input documenttype_hiradc">
                                                            <label class="require">HAZARD</label>
                                                            <textarea data-error="please enter HAZARD" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][hazard]" id="riskdetails_hazard_{{ $rowId }}">{{ $risksig->hazard }}</textarea>
                                                        </div>

                                                        <div class="col-md-4 form-input documenttype_hiradc">
                                                            <label class="require">EFFECTS</label>
                                                            <textarea data-error="Please enter EFFECTS" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][effects]" id="riskdetails_effects_{{ $rowId }}">{{ $risksig->effects }}</textarea>
                                                        </div>

                                                        <div class="col-md-4 form-input documenttype_risk_register">
                                                            <label class="require">HAZARD</label>
                                                            <textarea data-error="Please enter HAZARD" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][rr_hazard]" id="riskdetails_rr_hazard_{{ $rowId }}">{{ $risksig->hazard }}</textarea>
                                                        </div>

                                                        <div class="col-md-4 form-input documenttype_risk_register">
                                                            <label class="require">EFFECTS</label>
                                                            <textarea data-error="Please enter EFFECTS" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][rr_effects]" id="riskdetails_rr_effects_{{ $rowId }}">{{ $risksig->effects }}</textarea>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label class="require">EXISTING CONTROL</label>
                                                            <textarea data-error="Please enter EXISTING CONTROL" class="form-control validate-textarea-required"
                                                                name="riskdetails[{{ $rowId }}][existing_control]" id="riskdetails_existing_control_{{ $rowId }}">{{ $risksig->existing_control }}</textarea>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label class="require">LIKELIHOOD</label>
                                                            <select name="riskdetails[{{ $rowId }}][likelihood]"
                                                                id="likelihood_{{ $rowId }}"
                                                                data-error="Please select LIKELIHOOD"
                                                                onchange="calculateRiskmatrix(this)"
                                                                class="form-control select2 validate-select-required"
                                                                style="width:100%">
                                                                <option value="">Please Select LIKELIHOOD
                                                                </option>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <option value="{{ $i }}"
                                                                        @selected($risksig->likelyhood == $i)>
                                                                        {{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label class="require">SEVERITY</label>
                                                            <select name="riskdetails[{{ $rowId }}][severity]"
                                                                id="riskdetails_{{ $rowId }}"
                                                                data-error="Please select SEVERITY"
                                                                onchange="calculateRiskmatrix(this)"
                                                                class="form-control select2 validate-select-required"
                                                                style="width:100%">
                                                                <option value="">Please Select SEVERITY</option>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <option value="{{ $i }}"
                                                                        @selected($risksig->severity == $i)>
                                                                        {{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label>RISK</label>
                                                            <div>
                                                                <input type="hidden"
                                                                    name="riskdetails[{{ $rowId }}][risk_matrix]"
                                                                    id="risk_matrix_{{ $rowId }}"
                                                                    data-error="Please enter ACTION/ RESPONSIBLE PARTY"
                                                                    class="form-control ">
                                                                <span class="risk_matrix" id="risk_{{ $rowId }}">
                                                                    <span
                                                                        style=" background-color: {{ hazardriskcolor($risksig->risk) }} ; border:1px solid #ccc; height:35px; padding: 7px;width: 100px;display: block;text-align: center;">
                                                                        {{ $risksig->dfa }}
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 form-input documenttype_hiradc">
                                                            <div class="row">
                                                                <div class="col-md-112">
                                                                    <label class="require">Opportunities</label>
                                                                    <textarea data-error="Please enter Opportunities" name="riskdetails[{{ $rowId }}][opportunities]"
                                                                        id="riskdetails_opportunities_{{ $rowId }}" rows="3"
                                                                        class="form-control validate-textarea-required">{{ $risksig->opportunities }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 form-input">
                                                            <div class="row">
                                                                <div class="col-md-11">
                                                                    <label class="require">Proposed Control</label>
                                                                    <textarea data-error="Please enter Proposed Control" name="riskdetails[{{ $rowId }}][proposed_control]"
                                                                        id="riskdetails_proposed_control_{{ $rowId }}" rows="3"
                                                                        class="form-control validate-textarea-required">{{ $risksig->proposed_control }}</textarea>
                                                                </div>
                                                                <div class="col-md-1 mt-4">
                                                                    <span class="fa fa-trash removerow"> </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $rowId++;
                                                @endphp
                                            @endforeach
                                        </div>


                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">SECTION D - Reviews Added By</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="reporter_name" class="form-label require">Name</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="reporter_name" data-error="Please enter " placeholder=""
                                                        name="reporter_name" readonly value="{{ $user->name }}">

                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="reporter_designation"
                                                    class="form-label require">Designation</label>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="reporter_designation" data-error="Please enter "
                                                        placeholder="" name="reporter_designation" readonly
                                                        value="{{ $user->user_designation_name }}">

                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="dateandtime" class="form-label require">Date & Time</label>

                                                <div class="input-group date">
                                                    <input type="text" class="form-control validate-input-required"
                                                        id="dateandtime" data-error="Please enter " placeholder=""
                                                        name="dateandtime" readonly
                                                        value="{{ displayDatetimeFormat($risk->created_at) }}">

                                                </div>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="reporter_remarks" class="form-label require">Remarks</label>
                                                <textarea name="reporter_remarks" id="reporter_remarks" class="form-control" rows="5" required>{{ $risk->remarks }}</textarea>
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
        $(".documenttype_hiradc").hide();
        $(".documenttype_risk_register").hide();


        $(document).ready(function() {

            callshowhide();

            $('input[type=radio][name=process_type]').change(function() {
                var selectedValue = $(this).val();
                $('.process_type_items').hide();
                $('.process_type_items_checkbox').prop('checked', false);
                $('#div_' + selectedValue).show();
            });
        });

        function callshowhide() {

            value = {{ $risk->document_type }}
            switch (value) {
                case "{{ encryptId(1) }}":
                    $(".documenttype_eai").show();
                    $(".documenttype_hiradc").hide();
                    $(".documenttype_risk_register").hide();
                    break;
                case "{{ encryptId(2) }}":
                    $(".documenttype_hiradc").show();
                    $(".documenttype_eai").hide();
                    $(".documenttype_risk_register").hide();
                    break;
                case "{{ encryptId(3) }}":
                    $(".documenttype_risk_register").show();
                    $(".documenttype_hiradc").hide();
                    $(".documenttype_eai").hide();
                    break;
                default:
                    break;
            }

        }

        $(document).on('change', '.document_type_option', function() {

            var value = $(this).val();

            if (value) {
                $.ajax({
                    url: "{{ admin_url('hiradc/master/documenttype/datalist') }}",
                    data: {
                        documentId: value,
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        $('#docuenttype').empty().append(
                            '<option >Select Document Type</option>');
                        $.each(data, function(key, value) {
                            $('#docuenttype').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#docuenttype').trigger('change.select2');
                    }
                });
            } else {
                $('#docuenttype').empty().append('<option >Select Document Type</option>');
                $('#docuenttype').trigger('change.select2');
            }

            switch (value) {
                case "{{ encryptId(1) }}":
                    $(".documenttype_eai").show();
                    $(".documenttype_hiradc").hide();
                    $(".documenttype_risk_register").hide();
                    break;
                case "{{ encryptId(2) }}":
                    $(".documenttype_hiradc").show();
                    $(".documenttype_eai").hide();
                    $(".documenttype_risk_register").hide();
                    break;
                case "{{ encryptId(3) }}":
                    $(".documenttype_risk_register").show();
                    $(".documenttype_hiradc").hide();
                    $(".documenttype_eai").hide();
                    break;
                default:
                    break;
            }


        });

        $(document).on('change', '#docuenttype', function() {

            var value = $(this).val();

            if (value) {
                $.ajax({
                    url: "{{ admin_url('hiradc/master/documentcategory/datalist') }}",
                    data: {
                        docuenttypecategory: value,
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        $('#docuenttypecategory').empty().append(
                            '<option >Select Document Type Category</option>');
                        $.each(data, function(key, value) {
                            $('#docuenttypecategory').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#docuenttypecategory').trigger('change.select2');
                    }
                });
            } else {
                $('#docuenttypecategory').empty().append('<option >Select Document Type Category</option>');
                $('#docuenttypecategory').trigger('change.select2');
            }


        });

        $('#company').change(function() {
            var companyId = $(this).val();
        });

        $(document).ready(function() {

            $('#addmore').on('click', function() {

                $('#addmore').attr("disabled", true);
                var rowCount = $("#riskdetails .jsa_list").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".jsa_list").first().clone();

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                var newIndex = rowCount + 1;

                newRow.find("input[type='text']").val("");
                newRow.find(".select2").val("");
                newRow.find("input[type='hidden']").val("");
                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find("input[type='text'],textarea,input[type='hidden']").each(function() {

                    $(this).val("");
                    $(this).removeAttr("aria-describedby");

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

                newRow.find("select").each(function() {
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

                newRow.find(".select2").each(function() {

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

                newRow.find(".risk_matrix").each(function() {

                    $(this).html("");
                    $(this).removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);
                });

                $("#riskdetails").append(newRow);

                newRow.find(".select2").select2();

                $(".select2").select2();
                $('#addmore').attr("disabled", false);

            });
        });

        $(document).on('click', '.removerow', function() {
            if ($("#riskdetails .jsa_list").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".jsa_list").remove();

                $("#riskdetails .jsa_list").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text']").each(function() {
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
            $('#hiradc_add').validate({
                rules: {
                    document_type: {
                        required: true,
                    },
                    docuenttype: {
                        required: true,
                    },
                    docuenttypecategory: {
                        required: true,
                    },
                    process_type: {
                        required: true,
                    },
                    "subprocesstype[]": {
                        required: true,
                    },

                    reporter_remarks: {
                        required: true,
                    },


                },
                messages: {
                    document_type: {
                        required: "Please select Document Type",
                    },
                    docuenttype: {
                        required: "Please select Document Sub-Type",
                    },
                    docuenttypecategory: {
                        required: "Please select Document type Category",
                    },
                    process_type: {
                        required: "Please select Process Type",
                    },
                    "subprocesstype[]": {
                        required: "Please select Process Type Items",
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


        function calculateRiskmatrix(element) {

            var rowIndex = element.id.split('_').pop();

            var likelihoodValue = $('#likelihood_' + rowIndex).val();
            var severityValue = $('#riskdetails_' + rowIndex).val();

            if (likelihoodValue !== '' && severityValue !== '') {

                console.log(parseInt(likelihoodValue) , parseInt(severityValue) , rowIndex);

                var riskValue = parseInt(likelihoodValue) * parseInt(severityValue);

                var riskmartixarray = {
                    "1": {
                        "id": 1,
                        "likelihood": 1,
                        "severity": 1,
                        "rating": 1,
                        "color_code": "#0ca747",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:42:36.000000Z"
                    },
                    "2": {
                        "id": 6,
                        "likelihood": 2,
                        "severity": 1,
                        "rating": 2,
                        "color_code": "#0ca747",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:46:08.000000Z"
                    },
                    "3": {
                        "id": 11,
                        "likelihood": 3,
                        "severity": 1,
                        "rating": 3,
                        "color_code": "#0ca747",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:46:08.000000Z"
                    },
                    "4": {
                        "id": 16,
                        "likelihood": 4,
                        "severity": 1,
                        "rating": 4,
                        "color_code": "#0ca747",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:46:08.000000Z"
                    },
                    "5": {
                        "id": 21,
                        "likelihood": 5,
                        "severity": 1,
                        "rating": 5,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:25.000000Z"
                    },
                    "6": {
                        "id": 12,
                        "likelihood": 3,
                        "severity": 2,
                        "rating": 6,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:28.000000Z"
                    },
                    "8": {
                        "id": 17,
                        "likelihood": 4,
                        "severity": 2,
                        "rating": 8,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:32.000000Z"
                    },
                    "10": {
                        "id": 22,
                        "likelihood": 5,
                        "severity": 2,
                        "rating": 10,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:41.000000Z"
                    },
                    "9": {
                        "id": 13,
                        "likelihood": 3,
                        "severity": 3,
                        "rating": 9,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:35.000000Z"
                    },
                    "12": {
                        "id": 18,
                        "likelihood": 4,
                        "severity": 3,
                        "rating": 12,
                        "color_code": "#f1e400",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:49:43.000000Z"
                    },
                    "15": {
                        "id": 23,
                        "likelihood": 5,
                        "severity": 3,
                        "rating": 15,
                        "color_code": "#df1800",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:50:07.000000Z"
                    },
                    "16": {
                        "id": 19,
                        "likelihood": 4,
                        "severity": 4,
                        "rating": 16,
                        "color_code": "#df1800",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:50:09.000000Z"
                    },
                    "20": {
                        "id": 24,
                        "likelihood": 5,
                        "severity": 4,
                        "rating": 20,
                        "color_code": "#df1800",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:50:12.000000Z"
                    },
                    "25": {
                        "id": 25,
                        "likelihood": 5,
                        "severity": 5,
                        "rating": 25,
                        "color_code": "#df1800",
                        "created_by": 1,
                        "updated_by": null,
                        "status": 1,
                        "trash": "NO",
                        "created_at": "2023-12-07T06:42:36.000000Z",
                        "updated_at": "2023-12-07T06:50:14.000000Z"
                    }
                };
                var colorCode = riskmartixarray[riskValue].color_code;

                var outtext = '<span style="background-color:' + colorCode +
                    ';padding:7px;width:100px;display:block;text-align:center;">' + riskValue + '</span>';

                $('#risk_' + rowIndex).html(outtext);
            } else {
                outtext =
                    ' <span style="border:1px solid #ccc; height:35px; padding: 7px;width: 100px;display: block;text-align: center;"> </span>';
                $('#risk_' + rowIndex).html(outtext);
            }
        }


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
