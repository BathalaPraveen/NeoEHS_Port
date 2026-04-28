@extends('admin.layouts.layout')
@section('title', 'Gas Test PTW Add')
@section('pageurl', admin_url('ptw/gastest/list'))

@push('style')
    <style>
        #gas_ptw_add {
            color: #000;
        }

        #gas_ptw_add .form-check-label {
            display: inline;
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
                                <a href="{{ admin_url('ptw/gastest/list') }}">Gas Test PTW</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Gas Test PTW Add</li>
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
                                    <h5 class="card-title">Gas Test PTW Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/gastest/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="gas_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/gastest/add/submit') }}">
                                @csrf
                                <input type="hidden" name="ptwid" value="{{ encryptId($ptwid) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-1">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="require">Work Description</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td colspan="7" class="form-input">
                                                        <textarea name="workdescription" id="description" rows="2" class="form-control"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="require">Location</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <select name="location" class="form-control select2" required
                                                            @if (isset($general->location)) disabled @endif
                                                            id="location">
                                                            <option value="">Select Location</option>
                                                            @foreach ($locationDetails as $location)
                                                                <option value="{{ encryptId($location->id) }}"
                                                                    @if ($location->id == $general?->location) selected @endif>
                                                                    {{ $location->location_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label class="">Equipment / Process Affected</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <input type="text" name="equipmentprocess" id="equipmentprocess"
                                                            class="form-control">
                                                    </td>
                                                    <td style="width:15%;">
                                                        <label class="">Hotwork type (if aplicable refer to Hotwork
                                                            Certificate)</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <input type="text" class="form-control" name="hotworktype"
                                                            id="hotworktype">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="require">Gas Test for</label>
                                                    </td>
                                                    <td>:</td>
                                                    <td class="form-input">
                                                        <input class="form-check-input " type="radio" required
                                                            value="{{ encryptId(1) }}" name="gastestfor"
                                                            id="gas_test_for_{{ encryptId(1) }}">
                                                        <label class="form-check-label"
                                                            for="gas_test_for_{{ encryptId(1) }}">Confined Space</label>
                                                        <input class="form-check-input " type="radio" required
                                                            value="{{ encryptId(2) }}" name="gastestfor"
                                                            id="gas_test_for_{{ encryptId(2) }}">
                                                        <label class="form-check-label"
                                                            for="gas_test_for_{{ encryptId(2) }}">Open Air</label>
                                                    </td>

                                                    <td>Work Start Date</td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="input-group date form-input">
                                                            <input type="text" class="form-control workstartdate "
                                                                value="" required name="workstartdate"
                                                                id="workstartdate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Work End Date</td>
                                                    <td>:</td>
                                                    <td>
                                                        <div class="input-group date form-input">
                                                            <input type="text" class="form-control" value=""
                                                                required name="workenddate" id="workenddate" readonly>
                                                            <div class="input-group-addon input-group-text">
                                                                <span class="fa fa-calendar"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">SITE PREPARATION</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-4">

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label ">Access way arrangement:</label>
                                            <div class="col-md-9">
                                                <div class="m-2">
                                                    <textarea name="accesswayarrangement" id="accesswayarrangement" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="accesswayarrangement_check"
                                                        id="accesswayarrangement_check" class="form-check-input"
                                                        value="YES">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label "> Isolation Certificate Required
                                                (Remark if not applicable)</label>
                                            <div class="col-md-9">
                                                <div class="m-2">
                                                    <textarea name="isolationcertificate" id="isolationcertificate" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="isolationcertificate_check"
                                                        id="isolationcertificate_check" class="form-check-input"
                                                        value="YES">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label ">Ventilation Established:</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <input type="checkbox" name="ventilationestablishment[]"
                                                        id="ventilationestablishment_mechanical" class="form-check-input"
                                                        value="Mechanical Forced Air">
                                                    <label for="ventilationestablishment_mechanical">Mechanical Forced
                                                        Air</label>

                                                    <input type="checkbox" name="ventilationestablishment[]"
                                                        id="ventilationestablishment_natural" class="form-check-input"
                                                        value="Natural Ventilation">
                                                    <label for="ventilationestablishment_natural">Natural
                                                        Ventilation</label>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">Mean of Communication:</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <input type="text" name="meanofcommunication"
                                                        id="meanofcommunication" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-11 col-form-label require"> Space Hazard Assessment has
                                                been reviewed and brief conducted by Entry Supervisor with Authorised
                                                Entrance & Standby Person</label>

                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="spacehazardaccesment"
                                                        id="spacehazardaccesment" class="form-check-input"
                                                        value="YES">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">EQUIPMENT ON SCENE</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-4">
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label ">Gas Detector : Model / Serial
                                                Number</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <input type="text" name="gasdetector" id="gasdetector"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <label class="col-sm-2 col-form-label ">Last Calibration Date</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <input type="text" name="lastcalivration" id="lastcalivration"
                                                        class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label " for="safetybelt">Safety belt, harness
                                                and/or
                                                safety line or lifeline/rescue line</label>
                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="safetybelt" id="safetybelt"
                                                        class="form-check-input " value="YES">
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label " for="hoistingequipment">Hoisting
                                                Equipment</label>
                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="hoistingequipment"
                                                        id="hoistingequipment" class="form-check-input " value="YES">
                                                </div>
                                            </div>

                                            <label class="col-sm-2 col-form-label " for="scba">SCBA</label>
                                            <div class="col-md-1">
                                                <div class="m-2">
                                                    <input type="checkbox" name="scba" id="scba" value="YES"
                                                        class="form-check-input ">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="m-2">
                                                    <input type="text" name="scbadetails" id="scbadetails"
                                                        class="form-control ">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">PARTIES INVOLVED IN THE WORK (MANDATORY FOR CONFINED
                                            SPACE)</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-4">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label require"> Authorised Entrance & Standby
                                                person <span class="btn btn-sm btn-primary " id="addperson">Add</span>
                                            </label>
                                            <div class="col-md-8">
                                                <div class="m-2">
                                                    <table class="table" id="person">
                                                        <tbody>
                                                            <tr class="person">
                                                                <td class="form-input">
                                                                    <input type="text"
                                                                        data-error="Please enter the Authorised Entrance & Standby person "
                                                                        name="authperson[]"
                                                                        class="form-control validate-input-required">
                                                                </td>
                                                                <td> <i
                                                                        class="fa fa-trash persionRemove cursor-pointer"></i>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label require"> Entry Supervisor Name &
                                                Signature:

                                            </label>
                                            <div class="col-md-8">
                                                <div class="m-2 form-input">
                                                    <input type="text" name="supervisordetails" required
                                                        id="supervisordetails" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Gas Test</h6>
                                    </div>
                                    <div class="row g-3 px-2 pt-4">
                                        <div class="row mx-1 mb-2">

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td>TEST</td>
                                                        <td>STANDARD FOR CONFINED SPACE</td>
                                                        <td>STANDARD FOR OPEN AREA</td>
                                                        <td>INITIAL READING</td>
                                                        <td>REMARKS</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>OXYGEN</td>
                                                        <td>19.5% - 23.5 %</td>
                                                        <td>19.5% - 23.5 %</td>
                                                        <td class="form-input"> <input type="text"
                                                                name="gastest[initial][oxygen]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[remarks][oxygen]"
                                                                class="form-control validate-input-required"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>EXPLOSIVE ( % LEL )</td>
                                                        <td>
                                                            <= 10% LEL</td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[standard][explosive]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[initial][explosive]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[remarks][explosive]"
                                                                class="form-control validate-input-required"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOXIC (PEL)</td>
                                                        <td>
                                                            <= PEL </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[standard][toxic]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[initial][toxic]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[remarks][toxic]"
                                                                class="form-control validate-input-required"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>H2S (PPM)</td>
                                                        <td>
                                                            <= 10 PPM </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[standard][h2s]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[initial][h2s]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[remarks][h2s]"
                                                                class="form-control validate-input-required"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>CO (PPM)</td>
                                                        <td>
                                                            <= 25 PPM</td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[standard][co]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[initial][co]"
                                                                class="form-control validate-input-required"> </td>
                                                        <td class="form-input"><input type="text"
                                                                name="gastest[remarks][co]"
                                                                class="form-control validate-input-required"> </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label "> SAFE TO WORK / ENTER CONFINED SPACE
                                                (CIRCLE)</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="m-2">
                                                                <input class="form-check-input " type="radio"
                                                                    value="YES" name="safe_work" id="safe_work_yes">
                                                                <label class="form-check-label"
                                                                    for="safe_work_yes">Yes</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="m-2">
                                                                <input class="form-check-input " type="radio"
                                                                    value="no" name="safe_work" id="safe_work_no">
                                                                <label class="form-check-label"
                                                                    for="safe_work_no">NO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">REMARK</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <textarea name="safe_work_remarks" id="safe_work_remarks" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label "> ATMOSPHERE MONITORING REQUIRED
                                                (CIRCLE)</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="m-2">
                                                                <input class="form-check-input " type="radio"
                                                                    value="YES" name="atmosphere" id="atmosphere_yes">
                                                                <label class="form-check-label"
                                                                    for="atmosphere_yes">Yes</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="m-2">
                                                                <input class="form-check-input " type="radio"
                                                                    value="no" name="atmosphere" id="atmosphere_no">
                                                                <label class="form-check-label"
                                                                    for="atmosphere_no">NO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">REMARK</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <textarea name="atmosphere_remarks" id="atmosphere_remarks" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label ">AUTHORIZED GAS TESTER NAME</label>
                                            <div class="col-md-4">
                                                <div class="m-2">
                                                    <input type="text" name="gastestername" id="gastestername"
                                                        class="form-control">

                                                </div>
                                            </div>
                                            <label class="col-sm-2 col-form-label ">TIME / DATE </label>
                                            <div class="col-md-4">
                                                <div class="m-2">

                                                    <div class="input-group date ">
                                                        <input type="text"
                                                            class="form-control datepicker validate-input-required"
                                                            required id="gastestdatetime" name="gastestdatetime" readonly>
                                                        <div class="input-group-addon input-group-text">
                                                            <span class="fa fa-calendar"></span>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>



                                    <div class="card-header card-header-inner  mb-3 mt-3">

                                        <div class="d-lg-flex align-items-center gap-3">

                                            <div class="position-relative">
                                                <h6 class="text-white">GAS TEST LOG (ATTACH IF MORE TEST CONDUCTED)</h6>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-primary" type="button"
                                                    id="addgaslog">Add</button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row g-3 px-2 pt-4">

                                        <div class="row mb-2 mx-1">
                                            <table class="table table-bordered " id="gaslog">
                                                <thead>
                                                    <tr>
                                                        <td>DATE</td>
                                                        <td>Time</td>
                                                        <td>OXYGEN</td>
                                                        <td>EXPLOSIVE</td>
                                                        <td>TOXIC</td>
                                                        <td>AGT NAME & SIGN</td>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="gaslog" id="gaslogtable">
                                                        <td class="form-input">
                                                            <div class="input-group date ">
                                                                <input type="text"
                                                                    class="form-control workstartdate validate-input-required"
                                                                    required id="gaslog_date_1" name="gaslog[1][date]"
                                                                    readonly>
                                                                <div class="input-group-addon input-group-text">
                                                                    <span class="fa fa-calendar"></span>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td class="form-input">
                                                            <div class="input-group clockpicker" data-placement="bottom"
                                                                data-align="bottom" data-autoclose="true">
                                                                <input type="text" id="gaslog_time_1" required
                                                                    class="form-control validate-input-required" readonly
                                                                    placeholder="" name="gaslog[1][time]" />
                                                                <span class="input-group-addon input-group-text">
                                                                    <i class="bi bi-clock"></i>
                                                                </span>
                                                            </div>

                                                        </td>
                                                        <td class="form-input"><input type="text" required
                                                                name="gaslog[1][oxygen]" id="gaslog_oxygen_1"
                                                                class="form-control validate-input-required"></td>
                                                        <td class="form-input"><input type="text" required
                                                                name="gaslog[1][explosive]" id="gaslog_explosive_1"
                                                                class="form-control validate-input-required"></td>
                                                        <td class="form-input"><input type="text" required
                                                                id="gaslog_toxic_1" name="gaslog[1][toxic]"
                                                                class="form-control validate-input-required"></td>
                                                        <td class="form-input"><input type="text" required
                                                                id="gaslog_name_1" name="gaslog[1][name]"
                                                                class="form-control validate-input-required"></td>
                                                        <td class="form-input"> <i class="fa fa-trash gaslogRemove"></i>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
                                    </div>

                                    <div class="row g-3 px-2 pt-4">
                                        <div class="col-md-12">

                                            <div class="m-2 form-input">

                                                <input class="form-check-input" type="checkbox" value="1"
                                                    name="accept_terms" id="accept_terms" required>
                                                <label class="form-check-label" for="accept_terms">I <b>fully
                                                        understand </b>& will <b>ensure compliance</b> with all the
                                                    requirements of this permit.</label>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-3">
                                            <label class="col-sm-2 col-form-label">
                                                Name</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="applieduser"
                                                    value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                            <label class="col-sm-2 col-form-label form-input">
                                                Date & Time</label>
                                            <div class="col-sm-4 form-input">
                                                <input type="text" class="form-control" id="dataandtime"
                                                    name="dataandtime" placeholder="" value="{{ todaydatetime() }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label">
                                                Remarks</label>
                                            <div class="col-sm-10">
                                                <textarea name="applicant_remarks" id="applicant_remarks" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row card-bottom">
                                        <div class="col-12 mt-2 mb-3">
                                            <hr>

                                            @php
                                                if ($nextpermit != '' && $nextpermit != null) {
                                                    $text = 'Next';
                                                } else {
                                                    $text = 'Submit';
                                                }

                                            @endphp

                                            <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                                title="Reset">Reset</button>
                                            <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                data-bs-toggle="tooltip"
                                                title="{{ $text }}">{{ $text }}</button>
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
        $(function() {

            $.validator.setDefaults({
                messages: {
                    required: function(element) {
                        // Get the custom error message from the data-error attribute
                        return $(element).data("error") ||
                            "This field is required. Please enter a value.";
                    }
                }
            });


            $('#gas_ptw_add').validate({
                rules: {
                    workdescription: {
                        required: true,
                    },
                    gastest: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    company_shortname: {
                        required: true,
                    },

                },
                messages: {
                    workdescription: {
                        required: "Please enter the Work description",
                    },
                    gastest: {
                        required: "Please select Gas test for",
                    },
                    company_name: {
                        required: "Please select Location",
                    },
                    company_shortname: {
                        required: "Please enter Company Short Description",
                    },

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    // var customMessage = $(element).data("error");
                    // if (customMessage) {
                    //     error.text(customMessage);
                    // }
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


        $(".workstartdate").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'startDate': '{{ displayDateformat($general->date_of_commencement) }}',
            'endDate': '{{ displayDateformat($general->date_of_completion) }}',
        });

        $(document).on('change', '#workstartdate', function() {


            // Get selected date from datepicker
            var selectedDate = $('#workstartdate').val();

            if (selectedDate == '')
                return true;

            var newDate = getEndDate(selectedDate, {{ VALIDITY_GAS }});
            $('#workenddate').val(newDate);


        });


        $(document).ready(function() {
            $('#addperson').on('click', function() {
                var rowCount = $("#person tbody tr").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".person").first().clone();
                newRow.find("input[type='text']").val("");
                $("#person tbody").append(newRow);
            });
        });

        $(document).on('click', '.persionRemove', function() {

            if ($("#person tbody tr").length > 1) {
                $(this).closest("tr").remove();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record requierd',
                })
                return true;
            }
        });


        $(document).ready(function() {
            $('#addgaslog').on('click', function() {
                var rowCount = $("#gaslog tbody tr").length;

                if (rowCount >= 7) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 7 records only add',
                    })
                    return true;
                }

                var newRow = $(".gaslog").first().clone();
                newRow.find("input[type='text']").val("");

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                newRow.find("input[type='text']").removeAttr("aria-describedby");

                // Increment the index in the name attributes
                newRow.find("input[type='text']").each(function() {
                    var newIndex = rowCount + 1; // Increment the index

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/); // Use a regular expression to extract the field name

                    var errormessage = 'Please enter the value';
                    if (matches) {
                        var fieldName = matches[1];
                        errormessage = 'Please enter the ' + fieldName;
                    }

                    var newName = oldName.replace(/\d+/, newIndex); // Replace the index
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex); // Replace the index
                    $(this).attr("id", newName);

                    $(this).rules("add", {
                        required: true,
                        messages: {
                            required: errormessage
                        }
                    });


                });

                $("#gaslog tbody").append(newRow);
                datepickercall();
                timepickercall();

                $(".workstartdate").datepicker({

                    'format': "dd-mm-yyyy",
                    'autoclose': true,
                    'orientation': 'bottom',
                    'todayHighlight': true,
                    'startDate': '{{ displayDateformat($general->date_of_commencement) }}',
                    'endDate': '{{ displayDateformat($general->date_of_completion) }}',
                });


            });
        });

        $(document).on('click', '.gaslogRemove', function() {
            if ($("#gaslog tbody tr").length > 1) {
                $(this).closest("tr").remove();

                // Reorder the name attributes of the remaining rows
                $("#gaslog tbody tr").each(function(index) {
                    $(this).find("input[type='text']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (index + 1) +
                            ']'); // Update the index
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (index + 1)); // Update the index
                        $(this).attr("id", newId);
                    });
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });





        $(document).ready(function() {

            $('.othersshow').on('click', function() {

                $id = $(this).data('id');

                if ($(this).is(':checked')) {

                    $("#" + $id).show();
                } else {
                    $("#" + $id).hide();
                }
            });

            $('.radiocheck').on('change', function() {

                if ($(this).is(':checked')) {
                    $('.radiocheck[name="' + $(this).attr('name') + '"]').not(this).prop('checked',
                        false);
                    $('#btnsubmit').text('Next');
                } else {
                    $('#btnsubmit').text('Submit');

                }
            });

            $('.companycheck').on('change', function() {

                if ($(this).is(':checked')) {
                    $('.companycheck[name="' + $(this).attr('name') + '"]').not(this).prop('checked',
                        false);
                }
            });




        });
    </script>
@endpush
