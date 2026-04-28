@extends('admin.layouts.layout')
@section('title', 'HIRADC View')
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
                            <li class="breadcrumb-item active" aria-current="page">HIRADC View</li>
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
                                    <h5 class="card-title">HIRADC View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('hiradc/hiradc/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">

                                    <div class="card-header card-header-inner mt-3 ">
                                        <h6 class="text-white">Section A - Application</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="row">

                                            @php
                                                $user = getUser($risk->created_by);
                                            @endphp

                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Risk Assessed
                                                    by</label>
                                                <div></div>{{ $user->name }}
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Email</label>
                                                <div>
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Company</label>
                                                <div>
                                                    {{ $user->companyInfo->company_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Division</label>
                                                <div>
                                                    {{ $user->divisionInfo->division_name }}
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Department</label>
                                                <div>
                                                    {{ $user->DepartmentInfo->department_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="company_telephone" class="form-label bold ">Date and
                                                    Time</label>
                                                <div>
                                                    {{ displayDatetimeFormat($risk->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">SECTION B - RISK DOCUMENT DETAILS</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="form-input col-md-6">
                                            <label for="document_type" class="form-label bold">Document Type</label>

                                            <div>
                                                {{ $risk->document_name }}
                                            </div>
                                        </div>

                                        <div class="form-input col-md-3">
                                            <label for="location" class="form-label bold">Document Sub-Type</label>
                                            <div>
                                                {{ $risk->documenttype_name }}
                                            </div>

                                        </div>

                                        <div class="form-input col-md-3">
                                            <label for="location" class="form-label bold">Document Type
                                                Category</label>
                                            <div>
                                                {{ $risk->category_name }}
                                            </div>

                                        </div>

                                        <div class="form-input col-md-12">
                                            <label for="location" class="form-label bold">Process Type</label>

                                            <div>
                                                {{ $risk->process_type_name }}
                                            </div>
                                        </div>

                                        @php

                                            $processtypelist = string_to_array($risk->process_type_details);

                                        @endphp

                                        <div @if ($risk->process_type != 1) style="display:none" @endif
                                            class="process_type_items" id="div_New">
                                            <div class="row form-input ">
                                                @foreach ($processtypedetails[1] as $subprocesstype)
                                                    <div class="col-md-3 mb-2">
                                                        <input type="checkbox" name="subprocesstype[]"
                                                            @checked(in_array($subprocesstype->id, $processtypelist)) @disabled(true)
                                                            class="process_type_items_checkbox validate-checkbox-required"
                                                            required id="new_{{ encryptId($subprocesstype->id) }}"
                                                            value="{{ encryptId($subprocesstype->id) }}">
                                                        <label
                                                            for="new_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div @if ($risk->process_type != 2) style="display:none" @endif
                                            class="process_type_items" id="div_Amendment">
                                            <div class="row form-input ">
                                                @foreach ($processtypedetails[2] as $subprocesstype)
                                                    <div class="col-md-3 mb-2">
                                                        <input type="checkbox" name="subprocesstype[]"
                                                            @checked(in_array($subprocesstype->id, $processtypelist)) @disabled(true)
                                                            class="process_type_items_checkbox validate-checkbox-required"
                                                            id="amendment_{{ encryptId($subprocesstype->id) }}" required
                                                            value="{{ encryptId($subprocesstype->id) }}">
                                                        <label
                                                            for="amendment_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                <div class="col-md-4 form-input">
                                                    <label class="form-label bold ">Activity Number</label>
                                                    <div>
                                                        {{ $risk->activity_number }}
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div @if ($risk->process_type != 3) style="display:none" @endif
                                            class="process_type_items" id="div_Withdraw">
                                            <div class="row form-input ">
                                                @foreach ($processtypedetails[3] as $key => $subprocesstype)
                                                    <div class="col-md-3 mb-2">
                                                        <input type="checkbox" name="subprocesstype[]"
                                                            @checked(in_array($subprocesstype->id, $processtypelist)) @disabled(true)
                                                            class="process_type_items_checkbox validate-checkbox-required"
                                                            required id="withdraw_{{ encryptId($subprocesstype->id) }}"
                                                            value="{{ encryptId($subprocesstype->id) }}">
                                                        <label
                                                            for="withdraw_{{ encryptId($subprocesstype->id) }}">{{ $subprocesstype->sub_type_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">

                                                <div class="col-md-4 form-input">
                                                    <label class="form-label bold ">Activity Number</label>
                                                    <div>
                                                        {{ $risk->activity_number }}
                                                    </div>

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
                                        </div>
                                    </div>
                                    <div id="riskdetails" class="p-2">

                                        @foreach ($riskdetails as $risksig)
                                            <div class="jsa_list">
                                                <div class="row">
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">Activities /Area / Process</label>
                                                        <div>
                                                            {{ $risksig->activities_area_process }}
                                                        </div>

                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">C</label>
                                                        <div>
                                                            {{ $risksig->routine_type }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">location Specific</label>
                                                        <div>
                                                            {{ $risksig->location_specific }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input documenttype_eai">
                                                        <label class="form-label bold ">ASPECTS</label>
                                                        <div>
                                                            {{ $risksig->aspects }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input documenttype_eai">
                                                        <label class="form-label bold ">IMPACTS</label>
                                                        <div>
                                                            {{ $risksig->impacts }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input documenttype_eai">
                                                        <label class="form-label bold ">COMPLIANCE OBLIGATION</label>
                                                        <div>
                                                            {{ $risksig->compliance_obligation }}
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 form-input documenttype_hiradc">
                                                        <label class="form-label bold ">HAZARD</label>
                                                        <div>
                                                            {{ $risksig->hazard }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input documenttype_hiradc">
                                                        <label class="form-label bold ">EFFECTS</label>
                                                        <div>
                                                            {{ $risksig->effects }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input documenttype_risk_register">
                                                        <label class="form-label bold ">HAZARD</label>
                                                        <div>
                                                            {{ $risksig->hazard }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input documenttype_risk_register">
                                                        <label class="form-label bold ">EFFECTS</label>
                                                        <div>
                                                            {{ $risksig->effects }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">EXISTING CONTROL</label>
                                                        <div>
                                                            {{ $risksig->existing_control }}
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">LIKELIHOOD</label>
                                                        <div>
                                                            {{ $risksig->likelyhood }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label bold ">SEVERITY</label>
                                                        <div>
                                                            {{ $risksig->severity }}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label>RISK</label>
                                                        <div>
                                                            <span class="risk_matrix">
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
                                                                <label class="form-label bold ">Opportunities</label>
                                                                <div>
                                                                    {{ $risksig->opportunities }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 form-input">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="form-label bold ">Proposed Control</label>
                                                                <div>
                                                                    {{ $risksig->proposed_control }}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>


                                    <hr>
                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">SECTION D - Reviews Added By</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_name" class="form-label bold">Name</label>
                                            <div>
                                                {{ $user->name }}
                                            </div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="reporter_designation" class="form-label bold">Designation</label>
                                            <div>
                                                {{ $user->user_designation_name }}
                                            </div>
                                        </div>


                                        <div class="col-md-4 form-input">
                                            <label for="dateandtime" class="form-label bold">Date & Time</label>
                                            <div>
                                                {{ displayDatetimeFormat($risk->created_at) }}
                                            </div>

                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="reporter_remarks" class="form-label bold">Remarks</label>
                                            <div>
                                                {{ $risk->remarks }}
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($hiradc_status_log as $statusLog)
                                    <br>
                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">Status Log</h6>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr style="background-color: #d9e2f3">
                                                        <td colspan="6" style="font-weight:600;"> Status -
                                                            {!!  mainStatus($statusLog->to_status)  !!} </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 10%">Name</th>
                                                        <td style="width: 5%">:</td>
                                                        <td style="width: 30%">
                                                            {{ getusername($statusLog->created_by) }}</td>
                                                        <th style="width: 10%">Designation</th>
                                                        <td style="width: 5%">:</td>
                                                        <td style="width: 30%">
                                                            {{ getuser($statusLog->created_by)->user_designation_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date</th>
                                                        <td>:</td>
                                                        <td>{{ displayDateformat($statusLog->created_at) }}
                                                        </td>
                                                        <th>Time</th>
                                                        <td>:</td>
                                                        <td>{{ Displaytimeformat($statusLog->created_at) }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Remarks</th>
                                                        <td>:</td>
                                                        <td colspan="4">
                                                            {{ $statusLog->status_description }}</td>

                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                @endforeach




                                    @isset($approve)
                                        <div class="card-header card-header-inner mt-3 ">
                                            <h6 class="text-white">Approval</h6>
                                        </div>

                                        <form class="" id="hiradc_add" method="POST" enctype="multipart/form-data"
                                            action="{{ admin_url('hiradc/hiradc/approve/submit') }}">
                                            <input type="hidden" name="id" value="{{ encryptId($risk->id) }}">
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
                                                            name="dateandtime" readonly value="{{ todayDateTime() }}">

                                                    </div>
                                                </div>
                                                @csrf
                                                <div class="col-md-12 form-input">
                                                    <label for="remarks" class="form-label require">Remarks</label>
                                                    <textarea name="remarks" id="remarks" class="form-control" rows="5" required></textarea>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">

                                                        <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                            type="submit" name="reject" value="yes"
                                                            title="submit">Reject</button>
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="approve" value="yes" data-bs-toggle="tooltip"
                                                            title="Approve">Approve</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    @endisset

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
        @if ($risk->process_type == 1)
            $(".documenttype_eai").show();
            $(".documenttype_hiradc").hide();
            $(".documenttype_risk_register").hide();
        @elseif ($risk->process_type == 2)
            $(".documenttype_hiradc").show();
            $(".documenttype_eai").hide();
            $(".documenttype_risk_register").hide();
        @elseif ($risk->process_type == 3)
            $(".documenttype_risk_register").show();
            $(".documenttype_hiradc").hide();
            $(".documenttype_eai").hide();
        @endif
    </script>
@endpush
