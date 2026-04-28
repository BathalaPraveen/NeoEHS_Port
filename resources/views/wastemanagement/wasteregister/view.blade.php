@extends('admin.layouts.layout')
@section('title', 'Waste View')
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
                            <li class="breadcrumb-item active" aria-current="page">Waste View</li>
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
                                    <h5 class="card-title">Waste View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/waste/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class=" border rounded ">
                                <div>
                                    <div class="card-header card-header-inner mt-3 ">
                                        <h6 class="text-white">Section A: COMPANY INFORMATION</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="row">
                                            <div class="col-md-4 form-input">
                                                <label for="company" class="form-label bold">Name of
                                                    Company</label>
                                                <div>
                                                    {{ getCompanyName($wasteDetails->company_id) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">SECTION B : Location Information</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label bold">Location</label>
                                            <div>
                                                {{ getLocationName($wasteDetails->company_id) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-header card-header-inner ">
                                        <div class="d-lg-flex align-items-center gap-3">
                                            <div class="position-relative">
                                                <h6 class="text-white">Waste Details</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 px-4 pt-4">
                                        <div id="wastedetails">
                                            @foreach ($wastelistDetails as $wastelist)
                                                <div class="waste_list" id="">
                                                    <div class="row">
                                                        <div class="col-md-3 form-input">
                                                            <label class="form-label bold">Name of Waste</label>
                                                            <div>
                                                                {{ $wastelist->wastetype_name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label class="form-label bold">Waste Category Code</label>
                                                            <div>
                                                                {{ $wastelist->wastetype_id }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-lg-flex align-items-center gap-3">
                                                                <div class="position-relative">
                                                                    <h6>Previous Record</h6>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="previousrecord">

                                                            @php
                                                                $previousrecords = json_decode($wastelist->previous_record);
                                                            @endphp

                                                            @foreach ($previousrecords as $previousrecord)
                                                                <div class="previousrecord_list">
                                                                    <div class="row recordrow">
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Date
                                                                                Generated</label>

                                                                            <div class="">
                                                                                {{ $previousrecord->date }}
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Quantity</label>
                                                                            <div class="">
                                                                                {{ $previousrecord->qty }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Disposal
                                                                                Type</label>

                                                                            <div class="">
                                                                                {{ $disposaltypeArray[$previousrecord->uom] }}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Disposal Record</h6>
                                                        </div>
                                                        <hr>
                                                        <div class="row recordrow">
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Date Generated</label>

                                                                <div class="">
                                                                    {{ displayDateFormat($wastelist->disposal_date) }}
                                                                </div>

                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Quantity</label>
                                                                <div class="">
                                                                    {{ $wastelist->total_disposal }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Disposal Type</label>
                                                                <div class="">
                                                                    {{ $disposaltypeArray[$wastelist->disposal_type] }}
                                                                </div>

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
                                                                <label class="form-label bold">Quantity</label>
                                                                <div class="">
                                                                    {{ $wastelist->balance_waste }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Disposal Type</label>
                                                                <div class="">
                                                                    {{ $disposaltypeArray[$wastelist->balance_waste_disposal_type] }}
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-lg-flex align-items-center gap-3">
                                                                <div class="position-relative">
                                                                    <h6>New Generated Record</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="futurerecord">
                                                            @php
                                                                $futurerecords = json_decode($wastelist->new_generated_record);
                                                            @endphp

                                                            @foreach ($futurerecords as $futurerecord)
                                                                <div class="futurerecord_list">
                                                                    <div class="row recordrow">
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Date
                                                                                Generated</label>

                                                                            <div class="">
                                                                                {{ $futurerecord->date }}
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Quantity</label>
                                                                            <div class="">
                                                                                {{ $futurerecord->qty }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 form-input">
                                                                            <label class="form-label bold">Disposal
                                                                                Type</label>
                                                                            <div class="">
                                                                                {{ $disposaltypeArray[$futurerecord->uom] }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>Total Balance Waste</h6>
                                                        </div>
                                                        <hr>

                                                        <div class="row recordrow">
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Quantity</label>
                                                                <div class="">
                                                                    {{ $wastelist->total_balance_waste }}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-input">
                                                                <label class="form-label bold">Disposal Type</label>
                                                                <div class="">
                                                                    {{ $disposaltypeArray[$wastelist->total_balance_waste_type] }}
                                                                </div>
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
                                                                <label class="form-label bold">Weight</label>
                                                                <div class="">
                                                                    {{ $wastelist->weight }}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                                        $wastetotal = (array) json_decode($wasteDetails->total_waste);

                                                    @endphp
                                                    @foreach ($disposaltypeList as $disposaltype)
                                                        <tr>
                                                            <td>
                                                                <div class="finaltotal"
                                                                    id="previous_total_{{ $disposaltype->id }}">
                                                                    {{ $wastetotal[$disposaltype->id]->previous }}
                                                                </div>

                                                            </td>
                                                            <td>{{ $disposaltype->disposaltype_name }}</td>
                                                            <td>
                                                                <div class="finaltotal"
                                                                    id="current_total_{{ $disposaltype->id }}">
                                                                    {{ $wastetotal[$disposaltype->id]->current }}
                                                                </div>

                                                            </td>
                                                            <td>{{ $disposaltype->disposaltype_name }}</td>
                                                            <td>
                                                                <div class="finaltotal"
                                                                    id="afterdisposal_total_{{ $disposaltype->id }}">
                                                                    {{ $wastetotal[$disposaltype->id]->afterdisposal }}
                                                                </div>

                                                            </td>
                                                            <td>{{ $disposaltype->disposaltype_name }}</td>
                                                            <td>
                                                                <div class="finaltotal"
                                                                    id="future_total_{{ $disposaltype->id }}">
                                                                    {{ $wastetotal[$disposaltype->id]->future }}
                                                                </div>

                                                            </td>
                                                            <td>{{ $disposaltype->disposaltype_name }}</td>
                                                            <td>
                                                                <div class="finaltotal"
                                                                    id="balance_total_{{ $disposaltype->id }}">
                                                                    {{ $wastetotal[$disposaltype->id]->balance }}
                                                                </div>

                                                            </td>
                                                            <td>{{ $disposaltype->disposaltype_name }}</td>
                                                            @if ($i == 1)
                                                                <td rowspan="{{ count($disposaltypeList) }}"
                                                                    style="text-align: center;vertical-align:middle;background-color:white">
                                                                    <div id="overall_weight">
                                                                        {{ $wasteDetails->total_weight }}
                                                                    </div>

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
                                            <label for="reporter_name" class="form-label bold">Name</label>
                                            <div class="input-group date">
                                                <div>
                                                    {{ getuser($wasteDetails->created_by)->name }}
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="reporter_designation" class="form-label bold">Designation</label>
                                            <div>
                                                {{ getuser($wasteDetails->created_by)->user_designation_name }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="dateandtime" class="form-label bold">Date & Time</label>

                                            <div>
                                                {{ displayDateTimeFormat($wasteDetails->created_at) }}
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="reporter_remarks" class="form-label bold">Remarks</label>
                                            <div>
                                                {{ $wasteDetails->remarks }}
                                            </div>
                                        </div>

                                    </div>

                                    @if (count($statuslogs) > 0)
                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">APPROVAL</h6>
                                        </div>
                                        @foreach ($statuslogs as $statusLog)
                                            <div class="row  px-3">
                                                <div class="col-md-12">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr style="background-color: #aaa">
                                                                <td colspan="6" style="font-weight:500;"> Status -
                                                                    {!! wasteStatus($statusLog->to_status) !!} </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 10%">Name</th>
                                                                <td style="width: 5%">:</td>
                                                                <td style="width: 30%">
                                                                    {{ getusername($statusLog->approved_by) }}</td>
                                                                <th style="width: 10%">Date</th>
                                                                <td style="width: 5%">:</td>
                                                                <td style="width: 30%">
                                                                    {{ displayDateTimeformat($statusLog->created_at) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Description</th>
                                                                <td>:</td>
                                                                <td colspan="4">{{ $statusLog->remarks }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (isset($approveReject))

                                        @if ($wasteDetails->waste_disposal_status == WASTE_STATUS_GHSE_PENDING)
                                            <form action="{{ admin_url('wastemanagement/waste/approvereject/submit') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($wasteDetails->id) }}">
                                                <hr>

                                                <div class="card-header card-header-inner ">
                                                    <h6 class="text-white">SECTION D : Approval</h6>
                                                </div>

                                                <div class="row g-3 px-4 pt-4">

                                                    <div class="col-md-4 form-input">
                                                        <label for="reporter_name" class="form-label bold">Name</label>
                                                        <div class="input-group date">
                                                            <div>
                                                                <input type="text" readonly class="form-control"
                                                                    name=""
                                                                    value="{{ getuser($wasteDetails->created_by)->name }}">
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="reporter_designation"
                                                            class="form-label bold">Designation</label>
                                                        <div>
                                                            <input type="text" readonly class="form-control"
                                                                name=""
                                                                value="{{ getuser($wasteDetails->created_by)->user_designation_name }}">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label for="dateandtime" class="form-label bold">Date &
                                                            Time</label>

                                                        <div>
                                                            <input type="text" readonly class="form-control"
                                                                name=""
                                                                value="{{ displayDateTimeFormat($wasteDetails->created_at) }}">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 form-input">
                                                        <label for="reporter_remarks"
                                                            class="form-label bold">Remarks</label>
                                                        <div>
                                                            <textarea name="remarks" id="remarks" rows="3" class="form-control"></textarea>
                                                        </div>
                                                    </div>


                                                    <hr>
                                                    <div class="row card-bottom">
                                                        <div class="col-12 mt-2 mb-3">

                                                            <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                                type="submit" name="reject" value="yes"
                                                                title="submit">Reject</button>
                                                            <button class="btn btn-primary " id="btnsubmit"
                                                                type="submit" name="approve" value="yes"
                                                                data-bs-toggle="tooltip" title="Approve">Approve</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        @endif
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

                    console.log(looptext.length, containerIndex, newIndex);
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

                    console.log(looptext.length, containerIndex, newIndex);
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
                console.log(key, value);
                $("#" + key).html(value);
                $("#input_" + key).val(value);
            });
            console.log(resultArray);
            //return resultArray;
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
            $("#input_overall_weight" + key).val(resultval);
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
