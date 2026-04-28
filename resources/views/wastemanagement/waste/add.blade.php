@extends('admin.layouts.layout')
@section('title', 'Waste Add')
@section('pageurl', admin_url('wastemanagement/waste/list'))

@push('style')
    <style>
        .waste_list {
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
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('wastemanagement/waste/list') }}">Waste</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Waste Add</li>
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
                                    <h5 class="card-title">Waste Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/waste/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form id="waste_add_form" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('wastemanagement/waste/add/submit') }}">

                                <div class=" border rounded ">
                                    <div>
                                        @csrf

                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">Section A: COMPANY INFORMATION</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="row">
                                                <div class="col-md-4 form-input">
                                                    <label for="company" class="form-label require">Name of
                                                        Company</label>
                                                    <select name="company" id="company" class="form-control select2">
                                                        <option value="">Select Company</option>
                                                        @foreach ($companyList as $company)
                                                            <option value="{{ encryptId($company->id) }}">
                                                                {{ $company->full_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">SECTION B : Location Information</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="col-md-4 form-input">
                                                <label for="location" class="form-label require">Location</label>
                                                <select name="location" id="location" class="form-control select2">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locationList as $location)
                                                        <option value="{{ encryptId($location->id) }}">
                                                            {{ $location->location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center gap-3">

                                                <div class="position-relative">
                                                    <h6 class="text-white">Waste Details</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmore">Add</button>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div id="wastedetails">
                                                <div class="waste_list" id="">
                                                    <div class="row">
                                                        <div class="col-md-3 form-input">
                                                            <label>Name of Waste</label>
                                                            <select name="waste[1][wastetype]" id="wastetype_1"
                                                                data-error="Please select Name of Waste"
                                                                class="form-control select2 validate-select-required wastetype"
                                                                style="width:100%">
                                                                <option data-typeid="" value="">Please Select Waste
                                                                </option>
                                                                @foreach ($wastetypeList as $wastetype)
                                                                    <option data-typeid="{{ $wastetype->wastetype_id }}"
                                                                        value="{{ encryptId($wastetype->id) }}">
                                                                        {{ $wastetype->wastetype_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label>Waste Category Code</label>
                                                            <input type="text" name="waste[1][wastetypeid]" readonly
                                                                class="form-control validate-input-required" data-error=""
                                                                id="waste_type_id_1">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-lg-flex align-items-center gap-3">
                                                                <div class="position-relative">
                                                                    <h6>Previous Record</h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <button class="btn btn-primary btn-sm previousaddmore"
                                                                        type="button">Add</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="previousrecord">
                                                            <div class="previousrecord_list">
                                                                <div class="row recordrow">
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Date Generated</label>

                                                                        <div class="input-group ">
                                                                            <input type="text"
                                                                                class="form-control todaymaxdatepicker validate-input-required"
                                                                                data-error="" value=""
                                                                                name="waste[1][previous][1][date]" readonly
                                                                                id="waste_1_previous_date_1" required="">
                                                                            <div
                                                                                class="input-group-addon input-group-text">
                                                                                <span class="fa fa-calendar"></span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Quantity</label>
                                                                        <input type="text"
                                                                            name="waste[1][previous][1][qty]"
                                                                            class="form-control inputqty previousqty validate-input-required"
                                                                            data-error="" data-type="previous"
                                                                            id="waste_1_previous_qty_1">
                                                                    </div>
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Disposal Type</label>
                                                                        <select name="waste[1][previous][1][uom]"
                                                                            id="waste_1_previous_uom_1"
                                                                            class="form-control select2 inputuom previousuom validate-select-required"
                                                                            data-error="" data-type="previous">
                                                                            <option value="">Select Disposal type
                                                                            </option>
                                                                            @foreach ($disposaltypeList as $disposaltype)
                                                                                <option value="{{ $disposaltype->id }}">
                                                                                    {{ $disposaltype->disposaltype_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>

                                                                    <div class="col-md-3 form-input">
                                                                        <div class=" ">
                                                                            <i
                                                                                class="fa fa-trash mt-4 previousremoverow"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Disposal Record</h6>
                                                        </div>
                                                        <hr>
                                                        <div class="row recordrow">
                                                            <div class="col-md-3 form-input">
                                                                <label>Date Generated</label>

                                                                <div class="input-group ">
                                                                    <input type="text"
                                                                        class="form-control todaymaxdatepicker validate-input-required"
                                                                        data-error="" value=""
                                                                        name="waste[1][current][1][date]" readonly
                                                                        id="waste_1_current_date_1" required="">
                                                                    <div class="input-group-addon input-group-text">
                                                                        <span class="fa fa-calendar"></span>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label>Quantity</label>
                                                                <input type="text" name="waste[1][current][1][qty] "
                                                                    data-error="" data-type="current"
                                                                    class="form-control inputqty validate-input-required"
                                                                    id="waste_1_current_qty_1">
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label>Disposal Type</label>
                                                                <select name="waste[1][current][1][uom]"
                                                                    data-type="current" id="waste_1_current_uom_1"
                                                                    class="form-control select2 inputuom validate-select-required"
                                                                    data-error="">
                                                                    <option value="">Select Disposal type
                                                                    </option>
                                                                    @foreach ($disposaltypeList as $disposaltype)
                                                                        <option value="{{ $disposaltype->id }}">
                                                                            {{ $disposaltype->disposaltype_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Balance Waste after Disposal</h6>
                                                        </div>
                                                        <hr>
                                                        <div class="row recordrow">

                                                            <div class="col-md-3 form-input">
                                                                <label>Quantity</label>
                                                                <input type="text"
                                                                    name="waste[1][afterdisposal][1][qty]"
                                                                    data-type="afterdisposal"
                                                                    class="form-control inputqty validate-input-required"
                                                                    data-error="" id="waste_1_afterdisposal_qty_1">
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label>Disposal Type</label>
                                                                <select name="waste[1][afterdisposal][1][uom]"
                                                                    data-type="afterdisposal"
                                                                    id="waste_1_afterdisposal_uom_1"
                                                                    class="form-control select2 inputuom validate-select-required"
                                                                    data-error="">
                                                                    <option value="">Select Disposal type
                                                                    </option>
                                                                    @foreach ($disposaltypeList as $disposaltype)
                                                                        <option value="{{ $disposaltype->id }}">
                                                                            {{ $disposaltype->disposaltype_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-lg-flex align-items-center gap-3">
                                                                <div class="position-relative">
                                                                    <h6>New Generated Record</h6>
                                                                </div>
                                                                <div class="ms-auto">
                                                                    <button class="btn btn-primary btn-sm futureaddmore"
                                                                        type="button">Add</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>

                                                        <div class="futurerecord">
                                                            <div class="futurerecord_list">
                                                                <div class="row recordrow">
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Date Generated</label>

                                                                        <div class="input-group ">
                                                                            <input type="text"
                                                                                class="form-control datepicker validate-input-required"
                                                                                data-error="" value=""
                                                                                name="waste[1][future][1][date]" readonly
                                                                                id="waste_1_future_date_1" required="">
                                                                            <div
                                                                                class="input-group-addon input-group-text">
                                                                                <span class="fa fa-calendar"></span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Quantity</label>
                                                                        <input type="text"
                                                                            name="waste[1][future][1][qty] "
                                                                            data-error="" data-type="future"
                                                                            class="form-control inputqty validate-input-required"
                                                                            id="waste_1_future_qty_1">
                                                                    </div>
                                                                    <div class="col-md-3 form-input">
                                                                        <label>Disposal Type</label>
                                                                        <select name="waste[1][future][1][uom]"
                                                                            data-type="future" id="waste_1_future_uom_1"
                                                                            class="form-control select2 inputuom validate-select-required"
                                                                            data-error="">
                                                                            <option value="">Select Disposal type
                                                                            </option>
                                                                            @foreach ($disposaltypeList as $disposaltype)
                                                                                <option value="{{ $disposaltype->id }}">
                                                                                    {{ $disposaltype->disposaltype_name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>

                                                                    <div class="col-md-3 form-input">
                                                                        <div class=" ">
                                                                            <i
                                                                                class="fa fa-trash mt-4 futureremoverow"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Total Balance Waste</h6>
                                                        </div>
                                                        <hr>

                                                        <div class="row recordrow">
                                                            <div class="col-md-3 form-input">
                                                                <label>Quantity</label>
                                                                <input type="text" name="waste[1][balance][1][qty]"
                                                                    data-type="balance"
                                                                    class="form-control inputqty validate-input-required"
                                                                    data-error="" id="waste_1_balance_qty_1">
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label>Disposal Type</label>
                                                                <select name="waste[1][balance][1][uom]"
                                                                    data-type="balance" id="waste_1_balance_uom_1"
                                                                    class="form-control select2 inputuom validate-select-required"
                                                                    data-error="">
                                                                    <option value="">Select Disposal type
                                                                    </option>
                                                                    @foreach ($disposaltypeList as $disposaltype)
                                                                        <option value="{{ $disposaltype->id }}">
                                                                            {{ $disposaltype->disposaltype_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>

                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Total Weight</h6>
                                                        </div>
                                                        <hr>

                                                        <div class="row recordrow">
                                                            <div class="col-md-3 form-input">
                                                                <label>Weight</label>
                                                                <input type="text" name="waste[1][weight]"
                                                                    class="form-control rowweight validate-input-required"
                                                                    data-error="" id="waste_1_weight" value="0">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">Total</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">

                                            <div class="table-responsive">

                                                <table class="table table-bordered  table-striped ">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">Previous Record Total</th>
                                                            <th colspan="2">Disposal Record Total</th>
                                                            <th colspan="2">Balance Record Total</th>
                                                            <th colspan="2">New Generated Record Total</th>
                                                            <th colspan="2">Total Balance Waste Total</th>
                                                            <th>Total Weight</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $i = 1;
                                                        @endphp
                                                        @foreach ($disposaltypeList as $disposaltype)
                                                            <tr>
                                                                <td>
                                                                    <div class="finaltotal"
                                                                        id="previous_total_{{ $disposaltype->id }}">0
                                                                    </div>
                                                                    <input class="finaltotalinput" type="hidden"
                                                                        name="total[{{ $disposaltype->id }}][previous]"
                                                                        value="0"
                                                                        id="input_previous_total_{{ $disposaltype->id }}">
                                                                </td>
                                                                <td>{{ $disposaltype->disposaltype_name }}</td>
                                                                <td>
                                                                    <div class="finaltotal"
                                                                        id="current_total_{{ $disposaltype->id }}">0</div>
                                                                    <input class="finaltotalinput" type="hidden"
                                                                        name="total[{{ $disposaltype->id }}][current]"
                                                                        value="0"
                                                                        id="input_current_total_{{ $disposaltype->id }}">
                                                                </td>
                                                                <td>{{ $disposaltype->disposaltype_name }}</td>
                                                                <td>
                                                                    <div class="finaltotal"
                                                                        id="afterdisposal_total_{{ $disposaltype->id }}">0
                                                                    </div>
                                                                    <input class="finaltotalinput" type="hidden"
                                                                        name="total[{{ $disposaltype->id }}][afterdisposal]"
                                                                        value="0"
                                                                        id="input_afterdisposal_total_{{ $disposaltype->id }}">
                                                                </td>
                                                                <td>{{ $disposaltype->disposaltype_name }}</td>
                                                                <td>
                                                                    <div class="finaltotal"
                                                                        id="future_total_{{ $disposaltype->id }}">0</div>
                                                                    <input class="finaltotalinput" type="hidden"
                                                                        name="total[{{ $disposaltype->id }}][future]"
                                                                        value="0"
                                                                        id="input_future_total_{{ $disposaltype->id }}">
                                                                </td>
                                                                <td>{{ $disposaltype->disposaltype_name }}</td>
                                                                <td>
                                                                    <div class="finaltotal"
                                                                        id="balance_total_{{ $disposaltype->id }}">0</div>
                                                                    <input class="finaltotalinput" type="hidden"
                                                                        name="total[{{ $disposaltype->id }}][balance]"
                                                                        value="0"
                                                                        id="input_balance_total_{{ $disposaltype->id }}">
                                                                </td>
                                                                <td>{{ $disposaltype->disposaltype_name }}</td>
                                                                @if ($i == 1)
                                                                    <td rowspan="{{ count($disposaltypeList) }}" style="text-align: center;vertical-align:middle;background-color:white">
                                                                        <div id="overall_weight">0</div>
                                                                        <input type="hidden" name="total_weight" id="input_overall_weight" >
                                                                    </td>
                                                                @endif
                                                                @php
                                                                    $i++;
                                                                @endphp
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
                                                        value="{{ todayDateTime() }}">

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
        $(document).on('change', '.wastetype', function() {
            var wastetypeId = $(this).val();
            var rowIndex = this.id.split('_').pop();

            if (wastetypeId != '') {

                var selectedOption = this.options[this.selectedIndex];
                var dataTypeid = selectedOption.getAttribute('data-typeid');

                $('#waste_type_id_' + rowIndex).val(dataTypeid);

            } else {
                $('#waste_type_id_' + rowIndex).val("");
            }
        });

        $('#addmore').on('click', function() {

            $('#addmore').attr("disabled", true);
            var rowCount = $("#wastedetails .waste_list").length;

            if (rowCount >= 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Maximum 10 records only add',
                })
                return true;
            }

            var newRow = $(".waste_list").first().clone();

            newRow.find(".previousrecord").children().not(":first").remove();
            newRow.find(".futurerecord").children().not(":first").remove();


            newRow.find(".form-input").removeClass("selecterror");
            newRow.find(".form-control ").removeClass("is-invalid");
            newRow.find(".invalid-feedback").remove();

            var newIndex = rowCount + 1;

            newRow.find("input[type='text']").val("");
            newRow.find("input[type='text']").removeAttr("aria-describedby");

            newRow.find("input[type='text']").each(function() {

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

            $("#wastedetails").append(newRow);


            newRow.find(".select2").select2();

            $(".select2").select2();
            $('#addmore').attr("disabled", false);

            datepickercall();;

        });

        $(document).on('click', '.removerow', function() {
            if ($("#wastedetails .waste_list").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".waste_list").remove();

                $("#wastedetails .waste_list").each(function(index) {

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
                createArray();
                weightCalculation();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });


        $(document).on('click', '.previousaddmore', function() {

            $(this).closest('.waste_list').find('.previousaddmore').attr("disabled", true);
            var rowCount = $(this).closest('.waste_list').find(".previousrecord .previousrecord_list").length;

            if (rowCount >= 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Maximum 10 records only add',
                })
                return true;
            }

            var newRow = $(this).closest('.waste_list').find(".previousrecord_list").first().clone();

            newRow.find(".form-input").removeClass("selecterror");
            newRow.find(".form-control ").removeClass("is-invalid");
            newRow.find(".invalid-feedback").remove();

            var newIndex = rowCount + 1;

            newRow.find("input[type='text']").val("");
            newRow.find("input[type='text']").removeAttr("aria-describedby");

            newRow.find("input[type='text']").each(function() {

                $(this).val("");
                $(this).removeAttr("aria-describedby");

                var oldName = $(this).attr("name");

                // Replace only the last numeric part in the name
                var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match, group1, group2) {
                    return group1 + (parseInt(newIndex));
                });
                $(this).attr("name", newName);

                // The rest of your code for updating the ID remains unchanged
                var oldId = $(this).attr("id");
                var idParts = oldId.split('_');
                var numericId = parseInt(newIndex);

                idParts[idParts.length - 1] = numericId.toString();
                var newId = idParts.join('_');
                $(this).attr("id", newId);
            });

            newRow.find("select").each(function() {
                $(this).removeClass(' select2-hidden-accessible');
                $(this).removeAttr('data-select2-id');
                $(this).removeAttr('tabindex');
                $(this).removeAttr('aria-hidden');
                $(this).removeAttr('aria-describedby');
                $(this).find('option').removeAttr('data-select2-id');

                var oldName = $(this).attr("name");

                // Replace only the last numeric part in the name
                var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match, group1, group2) {
                    return group1 + (parseInt(newIndex));
                });
                $(this).attr("name", newName);

                // The rest of your code for updating the ID remains unchanged
                var oldId = $(this).attr("id");
                var idParts = oldId.split('_');
                var numericId = parseInt(newIndex);

                idParts[idParts.length - 1] = numericId.toString();
                var newId = idParts.join('_');
                $(this).attr("id", newId);

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

            $(this).closest('.waste_list').find(".previousrecord").append(newRow);



            newRow.find(".select2").select2();
            datepickercall();

            $(".select2").select2();
            $(this).closest('.waste_list').find('.previousaddmore').attr("disabled", false);

        });

        $(document).on('click', '.previousremoverow', function() {

            if ($(this).closest('.previousrecord').find(".previousrecord_list").length > 1) {

                var looptext = $(this).closest('.previousrecord').find(".previousrecord_list");

                var containerIndex = $(this).closest(".previousrecord_list").index();

                $(this).closest(".previousrecord_list").remove();

                newIndex = 1;

                looptext.each(function(index) {


                    if (index != containerIndex) {

                        $(this).find("input[type='text']").each(function() {
                            var oldName = $(this).attr("name");

                            // Replace only the last numeric part in the name
                            var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match,
                                group1,
                                group2) {
                                return group1 + (parseInt(newIndex));
                            });
                            $(this).attr("name", newName);

                            // The rest of your code for updating the ID remains unchanged
                            var oldId = $(this).attr("id");
                            var idParts = oldId.split('_');
                            var numericId = parseInt(newIndex);

                            idParts[idParts.length - 1] = numericId.toString();
                            var newId = idParts.join('_');
                            $(this).attr("id", newId);
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

                            // Replace only the last numeric part in the name
                            var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match,
                                group1,
                                group2) {
                                return group1 + (parseInt(newIndex));
                            });
                            $(this).attr("name", newName);

                            // The rest of your code for updating the ID remains unchanged
                            var oldId = $(this).attr("id");
                            var idParts = oldId.split('_');
                            var numericId = parseInt(newIndex);

                            idParts[idParts.length - 1] = numericId.toString();
                            var newId = idParts.join('_');
                            $(this).attr("id", newId);

                        });
                        $(this).find(".select2").select2();
                        newIndex++;
                    }

                });
                $(".select2").select2();
                createArray();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });


        $(document).on('click', '.futureaddmore', function() {

            $(this).closest('.waste_list').find('.futureaddmore').attr("disabled", true);
            var rowCount = $(this).closest('.waste_list').find(".futurerecord .futurerecord_list").length;

            if (rowCount >= 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Maximum 10 records only add',
                })
                return true;
            }

            var newRow = $(this).closest('.waste_list').find(".futurerecord_list").first().clone();

            newRow.find(".form-input").removeClass("selecterror");
            newRow.find(".form-control ").removeClass("is-invalid");
            newRow.find(".invalid-feedback").remove();

            var newIndex = rowCount + 1;

            newRow.find("input[type='text']").val("");
            newRow.find("input[type='text']").removeAttr("aria-describedby");

            newRow.find("input[type='text']").each(function() {

                $(this).val("");
                $(this).removeAttr("aria-describedby");

                var oldName = $(this).attr("name");

                // Replace only the last numeric part in the name
                var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match, group1, group2) {
                    return group1 + (parseInt(newIndex));
                });
                $(this).attr("name", newName);

                // The rest of your code for updating the ID remains unchanged
                var oldId = $(this).attr("id");
                var idParts = oldId.split('_');
                var numericId = parseInt(newIndex);

                idParts[idParts.length - 1] = numericId.toString();
                var newId = idParts.join('_');
                $(this).attr("id", newId);
            });

            newRow.find("select").each(function() {
                $(this).removeClass(' select2-hidden-accessible');
                $(this).removeAttr('data-select2-id');
                $(this).removeAttr('tabindex');
                $(this).removeAttr('aria-hidden');
                $(this).removeAttr('aria-describedby');
                $(this).find('option').removeAttr('data-select2-id');

                var oldName = $(this).attr("name");

                // Replace only the last numeric part in the name
                var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match, group1, group2) {
                    return group1 + (parseInt(newIndex));
                });
                $(this).attr("name", newName);

                // The rest of your code for updating the ID remains unchanged
                var oldId = $(this).attr("id");
                var idParts = oldId.split('_');
                var numericId = parseInt(newIndex);

                idParts[idParts.length - 1] = numericId.toString();
                var newId = idParts.join('_');
                $(this).attr("id", newId);

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

            $(this).closest('.waste_list').find(".futurerecord").append(newRow);



            newRow.find(".select2").select2();
            datepickercall();

            $(".select2").select2();
            $(this).closest('.waste_list').find('.futureaddmore').attr("disabled", false);

        });

        $(document).on('click', '.futureremoverow', function() {

            if ($(this).closest('.futurerecord').find(".futurerecord_list").length > 1) {

                var looptext = $(this).closest('.futurerecord').find(".futurerecord_list");

                var containerIndex = $(this).closest(".futurerecord_list").index();

                $(this).closest(".futurerecord_list").remove();

                newIndex = 1;

                looptext.each(function(index) {


                    if (index != containerIndex) {

                        $(this).find("input[type='text']").each(function() {
                            var oldName = $(this).attr("name");

                            // Replace only the last numeric part in the name
                            var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match,
                                group1,
                                group2) {
                                return group1 + (parseInt(newIndex));
                            });
                            $(this).attr("name", newName);

                            // The rest of your code for updating the ID remains unchanged
                            var oldId = $(this).attr("id");
                            var idParts = oldId.split('_');
                            var numericId = parseInt(newIndex);

                            idParts[idParts.length - 1] = numericId.toString();
                            var newId = idParts.join('_');
                            $(this).attr("id", newId);
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

                            // Replace only the last numeric part in the name
                            var newName = oldName.replace(/(\]\[)(\d+)(?=\])/g, function(match,
                                group1,
                                group2) {
                                return group1 + (parseInt(newIndex));
                            });
                            $(this).attr("name", newName);

                            // The rest of your code for updating the ID remains unchanged
                            var oldId = $(this).attr("id");
                            var idParts = oldId.split('_');
                            var numericId = parseInt(newIndex);

                            idParts[idParts.length - 1] = numericId.toString();
                            var newId = idParts.join('_');
                            $(this).attr("id", newId);

                        });
                        $(this).find(".select2").select2();
                        newIndex++;
                    }

                });
                $(".select2").select2();
                createArray();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });

        function createArray() {
            let resultArray = {};
            $(".finaltotal").html("0");
            $(".finaltotalinput").val("0");

            $('.recordrow').each(function() {
                let dataType = $(this).find('[data-type]').data('type');
                let disposalType = $(this).find('select').val();

                if (!resultArray[dataType + "_total_" + disposalType]) {
                    resultArray[dataType + "_total_" + disposalType] = 0;
                }

                let qty = parseFloat($(this).find('.inputqty').val()) || 0;

                resultArray[dataType + "_total_" + disposalType] += qty;
            });

            $.each(resultArray, function(key, value) {

                $("#" + key).html(value);
                $("#input_" + key).val(value);
            });

        }

        $(document).on('keyup', '.recordrow .inputqty', function() {
            createArray();
        });

        $(document).on('change', '.recordrow .inputuom', function() {
            createArray();
        });


        function weightCalculation() {
            let resultval = 0;
            $("#overall_weight").html("0");
            $("#input_overall_weight").val("0");

            $('.recordrow').each(function() {
                let qty = parseFloat($(this).find('.rowweight').val()) || 0;
                resultval += qty;
            });

            $("#overall_weight").html(resultval);
            $("#input_overall_weight").val(resultval);
        }

        $(document).on('keyup', '.recordrow .rowweight', function() {
            weightCalculation();
        });


        $(function() {
            $('#waste_add_form').validate({
                rules: {
                    company: {
                        required: true,
                    },
                    location: {
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
                    location: {
                        required: "Please select Location",
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
