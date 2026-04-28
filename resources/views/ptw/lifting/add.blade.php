@extends('admin.layouts.layout')
@section('title', 'Lifting Plan Add')
@section('pageurl', admin_url('ptw/lifting/list'))

@push('style')
    <style>
        #general_ptw_add {
            color: #000;
        }

        #general_ptw_add .form-check-label {
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
                                <a href="{{ admin_url('ptw/lifting/list') }}">Lifting Plan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lifting Plan
                                Add</li>
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
                                    <h5 class="card-title">Lifting Plan Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('ptw/lifting/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form id="general_ptw_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('ptw/lifting/add/submit') }}">
                                @csrf
                                <input type="hidden" name="ptwid" value="{{ encryptId($ptwid) }}">
                                <div class=" border rounded">
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">WORK DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">
                                            <label class="col-sm-1 col-form-label require">
                                                Location </label>
                                            <div class="col-sm-3 form-input">
                                                <select name="location" class="form-control select2" required
                                                    @if (isset($general->location)) disabled @endif id="location">
                                                    <option value="">Select Location</option>
                                                    @foreach ($locationDetails as $location)
                                                        <option value="{{ encryptId($location->id) }}"
                                                            @if ($location->id == $general?->location) selected @endif>
                                                            {{ $location->location_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label class="col-sm-1 col-form-label require">
                                                Work Start Date
                                            </label>
                                            <div class="col-md-3 form-input">
                                                <div class="input-group  ">
                                                    <input type="text" class="form-control workstartdate "
                                                        required id="workstartdate" name="workstartdate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-sm-1 col-form-label require">
                                                Work End Date
                                            </label>
                                            <div class="col-md-3 form-input">
                                                <div class="input-group  ">
                                                    <input type="text" class="form-control  " required
                                                        id="workenddate" name="workenddate" readonly>
                                                    <div class="input-group-addon input-group-text">
                                                        <span class="fa fa-calendar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Work Description :
                                            </label>
                                            <div class="col-md-10" class="form-input">
                                                <textarea name="workdescription" id="workdescription" class="form-control" required rows="3"></textarea>
                                            </div>
                                        </div>

                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">LOAD(S) DESCRIPTION</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Description of load(s)
                                            </label>
                                            <div class="col-md-10 form-input">
                                                <div class="m-2">
                                                    <textarea name="loaddescription" required id="loaddescription" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Overall dimensions
                                            </label>
                                            <div class="col-md-10 form-input">
                                                <div class="m-2">
                                                    <input type="text" name="overalldimension" id="overalldimension"
                                                        required class="form-control">

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Weight of load (kg)
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <div class="m-2">
                                                    <input type="text" name="loadweight" id="loadweight" required
                                                        class="form-control">

                                                </div>
                                            </div>
                                            <div class="col-md-3 form-input">
                                                <div class="m-2">

                                                    <input class="form-check-input" type="radio" value="knownweight"
                                                        name="weight_type" id="weight_type_known" required>
                                                    <label class="form-check-label" for="weight_type_known">Known
                                                        weight</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-input">
                                                <div class="m-2">

                                                    <input class="form-check-input" type="radio"
                                                        value="estimatedweight" name="weight_type"
                                                        id="weight_type_estimated" required>
                                                    <label class="form-check-label" for="weight_type_estimated">Estimated
                                                        weight</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label require">
                                                Center of gravity
                                            </label>
                                            <div class="col-md-3 form-input">
                                                <div class="m-2">
                                                    <input class="form-check-input" type="radio" value="obvious"
                                                        name="centerofgravity" id="centerofgravity_obvious" required>
                                                    <label class="form-check-label"
                                                        for="centerofgravity_obvious">Obvious</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-input">
                                                <div class="m-2">

                                                    <input class="form-check-input" type="radio" value="estimated"
                                                        name="centerofgravity" id="centerofgravity_estimated" required>
                                                    <label class="form-check-label"
                                                        for="centerofgravity_estimated">Estimated </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-inpt">
                                                <div class="m-2">
                                                    <input class="form-check-input" type="radio"
                                                        value="determinedbydrawing" name="centerofgravity"
                                                        id="centerofgravity_determinedbydrawing" required>
                                                    <label class="form-check-label"
                                                        for="centerofgravity_determinedbydrawing">Determined by
                                                        drawing</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">LIFTING EQUIPMENT INFORMATION</h6>
                                    </div>

                                    <div class="row g-3 p-4">
                                        <div class="row mb-2">
                                            @foreach ($liftingequipment as $equipment)
                                                <div class="col-md-2">
                                                    <div class="m-2 require">
                                                        {{ $equipment->category_name }}
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="m-2 form-input">
                                                        <input type="text"
                                                            data-error="Please enter {{ $equipment->category_name }}"
                                                            name="liftingquipment[{{ $equipment->id }}]"
                                                            class="form-control validate-input-required "
                                                            id="liftingquipment">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">RIGGING DETAILS</h6>
                                    </div>

                                    <div class="row g-3 p-4">
                                        <div class="row mb-2">
                                            <table class="table">
                                                <thead>
                                                    <tr style="text-align: center">
                                                        <th></th>
                                                        <th>SIZE</th>
                                                        <th>SWL</th>
                                                        <th>QUANTITY</th>
                                                        <th>WEIGHT</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($riggingdetails as $rigging)
                                                        <tr>
                                                            <td>
                                                                <label for=""
                                                                    class="form-input require">{{ $rigging->category_name }}</label>

                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    class="form-control validate-input-required"
                                                                    data-error="Please enter {{ $rigging->category_name }} (SIZE)"
                                                                    name="riggingdetails[{{ $rigging->id }}][size]"
                                                                    id="riggingdetails_{{ encryptId($rigging->id) }}_size">
                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    class="form-control validate-input-required"
                                                                    data-error="Please enter {{ $rigging->category_name }} (SWL)"
                                                                    name="riggingdetails[{{ $rigging->id }}][swl]"
                                                                    id="riggingdetails_{{ encryptId($rigging->id) }}_swl">
                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    class="form-control validate-input-required"
                                                                    data-error="Please enter {{ $rigging->category_name }} (QUANTITY)"
                                                                    name="riggingdetails[{{ $rigging->id }}][quantity]"
                                                                    id="riggingdetails_{{ encryptId($rigging->id) }}_quantity">
                                                            </td>
                                                            <td class="form-input">
                                                                <input type="text"
                                                                    class="form-control validate-input-required"
                                                                    data-error="Please enter {{ $rigging->category_name }} (WEIGHT)"
                                                                    name="riggingdetails[{{ $rigging->id }}][weight]"
                                                                    id="riggingdetails_{{ encryptId($rigging->id) }}_weight">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label require">
                                                Total weight of the lifting gears (kg)
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <input type="text" name="ligtgearsweight" id="ligtgearsweight"
                                                    required class="form-control">
                                            </div>

                                            <label class="col-sm-2 col-form-label require">
                                                Total suspended load (weight lifting gear + load)
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <input type="text" name="totalweight" id="totalweight" required
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Means of Communication</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <div class="row mb-2">

                                            <label class="col-sm-2 col-form-label require">
                                                Mean of Communication
                                            </label>
                                            <div class="col-md-4 form-input">
                                                <input type="text" name="meanofcommunication" id="meanofcommunication"
                                                    required class="form-control">
                                            </div>

                                            <label class="col-sm-4 col-form-label require">
                                                Can the operator see the loading and unloading point from his position
                                            </label>
                                            <div class="col-md-2 form-input">
                                                <input class="form-check-input" type="radio" value="yes"
                                                    name="loadinpoint" id="loadinpoint_yes" required>
                                                <label class="form-check-label" for="loadinpoint_yes">YES</label>

                                                <input class="form-check-input" type="radio" value="no"
                                                    name="loadinpoint" id="loadinpoint_no" required>
                                                <label class="form-check-label" for="loadinpoint_no">NO</label>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Physical and Environmental Consideration</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Ground condition</td>
                                                    <td>Is the ground made safe (e.g. Placing stell plate)?</td>
                                                    <td style="width: 15% " class="form-input">
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="yes" name="env_cond[pec_gc]"
                                                            id="pec_gc_yes">
                                                        <label class="form-check-label" for="pec_gc_yes">YES</label>

                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="no" name="env_cond[pec_gc]"
                                                            id="pec_gc_no">
                                                        <label class="form-check-label" for="pec_gc_no">NO</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2">Obstacles</td>
                                                    <td>Are there any overhead obstacles such as power lines?</td>
                                                    <td class="form-input">
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="yes" name="env_cond[pec_ob]"
                                                            id="pec_ob_yes">
                                                        <label class="form-check-label" for="pec_ob_yes">YES</label>

                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="no" name="env_cond[pec_ob]"
                                                            id="pec_ob_no">
                                                        <label class="form-check-label" for="pec_ob_no">NO</label>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td>Are there nearby buildings or structurs, equipment or stacked
                                                        materials that may obstruct lifting operation from being carried out
                                                        safely?</td>
                                                    <td class="form-input">
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="yes" name="env_cond[pec_obs]"
                                                            id="pec_obs_yes">
                                                        <label class="form-check-label" for="pec_obs_yes">YES</label>

                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="no" name="env_cond[pec_obs]"
                                                            id="pec_obs_no">
                                                        <label class="form-check-label" for="pec_obs_no">NO</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Lighting</td>
                                                    <td>Is the lighting conditions adequate? <br>
                                                        (If the lighting out with Daylight hours additional lighting will be
                                                        provided)</td>
                                                    <td class="form-input">
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="yes" name="env_cond[pec_lig]"
                                                            id="pec_lig_yes">
                                                        <label class="form-check-label" for="pec_lig_yes">YES</label>

                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="no" name="env_cond[pec_lig]"
                                                            id="pec_lig_no">
                                                        <label class="form-check-label" for="pec_lig_no">NO</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Demarcation</td>
                                                    <td>Has the zone of operation been barricaded (with warning sign and
                                                        barriers) to prevent unauthorized access for onshore lifting
                                                        activities?</td>
                                                    <td class="form-input">
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="yes" name="env_cond[pec_dem]"
                                                            id="pec_dem_yes">
                                                        <label class="form-check-label" for="pec_dem_yes">YES</label>
                                                        <input class="form-check-input validate-radio-required"
                                                            type="radio" value="no" name="env_cond[pec_dem]"
                                                            id="pec_dem_no">
                                                        <label class="form-check-label" for="pec_dem_no">NO</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="5">Environment</td>
                                                    <td>
                                                        <b>
                                                            <u>Do not proceed with the lifting operation under the following
                                                                circumstances: </u>
                                                        </b>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>

                                                    <td colspan="2">
                                                        <input class="form-check-input" type="checkbox" value="yes"
                                                            name="env_cond[pec_env_gc]" id="pec_env_gc">
                                                        <label class="form-check-label" for="pec_env_gc">
                                                            Thunderstorm and lightening strikes in the area. the
                                                            ground condition must be checked after thunderstorm.</label>
                                                    </td>

                                                </tr>
                                                <tr>

                                                    <td colspan="2">
                                                        <input class="form-check-input" type="checkbox" value="yes"
                                                            name="env_cond[pec_env_wet]" id="pec_env_wet">
                                                        <label class="form-check-label" for="pec_env_wet">Strong wind
                                                            that may sway the suspended load. (Local
                                                            weather forecast & Supervisor's experience & Tagline to
                                                            address)</label>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input class="form-check-input" type="checkbox" value="yes"
                                                            name="env_cond[pec_env_scn]" id="pec_env_scn">
                                                        <label class="form-check-label" for="pec_env_scn"> Do not
                                                            proceed with lifting operation during bad sea
                                                            condition. (Strong current and wave). (Local weather forecast &
                                                            supervisor's experience & Tagline to address.)</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" value="yes" name="env_cond[pec_others]" id="pec_others">
                                                            <label class="form-check-label" for="pec_others">
                                                                Other circumstances:
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="text" name="env_cond[other_circum]"  id="other_circum" class="form-control" style="width: auto;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>

                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">Personnel Involved in lifting Operation</h6>
                                    </div>
                                    <div class="row g-3 p-4">

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Position</td>
                                                    <td>Name & Identification Number</td>
                                                    <td style="width:30%"><label for="" class="require">Document Upload</label></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lifting Supervisor</td>
                                                    <td class="form-input">
                                                        <input type="text" name="liftingsupervisor" required
                                                            id="liftingsupervisor" class="form-control">
                                                    </td>
                                                    <td class="form-input">
                                                        <input type="file" name="liftingsupervisor_document" id="liftingsupervisor_document" class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Crane Operator</td>
                                                    <td class="form-input">
                                                        <input type="text" name="liftingcraneoperator" required
                                                            id="liftingcraneoperator" class="form-control">
                                                    </td>
                                                    <td class="form-input">
                                                        <input type="file" name="liftingcraneoperator_document" id="liftingsupervisor_document" class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Signalman</td>
                                                    <td class="form-input">
                                                        <input type="text" name="liftingsignalman" required
                                                            id="liftingsignalman" class="form-control">
                                                    </td>
                                                    <td class="form-input">
                                                        <input type="file" name="liftingsignalman_document" id="liftingsupervisor_document" class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Rigger</td>
                                                    <td class="form-input">
                                                        <input type="text" name="liftingrigger" id="liftingrigger"
                                                            required class="form-control">
                                                    </td>
                                                    <td class="form-input">
                                                        <input type="file" name="liftingrigger_document" id="liftingsupervisor_document" class="form-control" required>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Others</td>
                                                    <td>
                                                        <textarea name="liftingothers" id="liftingothers" rows="3" class="form-control"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="liftingothers_document" id="liftingsupervisor_document" class="form-control" >
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>


                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                        <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
                                    </div>
                                    <div class="row g-3 p-4">
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
                                            <label class="col-sm-2 col-form-label require">
                                                Remarks</label>
                                            <div class="col-sm-10 form-input">
                                                <textarea name="applicant_remarks" required id="applicant_remarks" class="form-control" rows="3"></textarea>
                                            </div>
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
            $('#general_ptw_add').validate({
                rules: {

                    location: {
                        required: true,
                    },
                    datetime: {
                        required: true,
                    },
                    workdescription: {
                        required: true,
                    },
                    loaddescription: {
                        required: true,
                    },
                    overalldimension: {
                        required: true,
                    },
                    loadweight: {
                        required: true,
                    },
                    weight_type: {
                        required: true,
                    },
                    centerofgravity: {
                        required: true,
                    },
                    ligtgearsweight: {
                        required: true,
                    },
                    totalweight: {
                        required: true,
                    },
                    meanofcommunication: {
                        required: true,
                    },
                    loadinpoint: {
                        required: true,
                    },
                    liftingsupervisor: {
                        required: true,
                    },
                    liftingcraneoperator: {
                        required: true,
                    },
                    liftingsignalman: {
                        required: true,
                    },
                    liftingrigger: {
                        required: true,
                    },
                    accept_terms: {
                        required: true,
                    },
                    applicant_remarks: {
                        required: true,
                    },
                    liftingsupervisor_document: {
                        required: true,
                    },
                    liftingcraneoperator_document: {
                        required: true,
                    },
                    liftingsignalman_document: {
                        required: true,
                    },
                    liftingrigger_document: {
                        required: true,
                    },


                },
                messages: {
                    location: {
                        required: "Please select Location",
                    },
                    datetime: {
                        required: "Please select Date & Time",
                    },
                    workdescription: {
                        required: "Please enter Work Description",
                    },
                    loaddescription: {
                        required: "Please enter Description of load(s)",
                    },
                    overalldimension: {
                        required: "Please enter Overall Dimentsions",
                    },
                    loadweight: {
                        required: "Please enter Weight of load",
                    },
                    weight_type: {
                        required: "Please select Weight Type",
                    },
                    centerofgravity: {
                        required: "Please select Center of gravity",
                    },
                    ligtgearsweight: {
                        required: "Please enter the Total weight of the lifting gears (kg)",
                    },
                    totalweight: {
                        required: "Please enter the Total suspended load (weight lifting gear + load)",
                    },
                    meanofcommunication: {
                        required: "Please enter Mean of Communication",
                    },
                    loadinpoint: {
                        required: "Please select the operator see point",
                    },
                    liftingsupervisor: {
                        required: "Please enter the Lifting Supervisor details",
                    },
                    liftingcraneoperator: {
                        required: "Please enter the Crane Operator details",
                    },
                    liftingsignalman: {
                        required: "Please enter the Signalman details",
                    },
                    liftingrigger: {
                        required: "Please enter the Rigger details",
                    },
                    accept_terms: {
                        required: "Please Accept",
                    },
                    applicant_remarks: {
                        required: "Please enter Remarks",
                    },
                    liftingsupervisor_document: {
                        required: "Please upload lifting supervisor document",
                    },
                    liftingcraneoperator_document: {
                        required: "Please upload crane operator document",
                    },
                    liftingsignalman_document: {
                        required: "Please upload signalman document",
                    },
                    liftingrigger_document: {
                        required: "Please upload rigger document",
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

            var newDate = getEndDate(selectedDate, {{ VALIDITY_LIFTING }}, {{ ADD_DATE }},
                '{{ displayDateformat($general->date_of_completion) }}');
            $('#workenddate').val(newDate);


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
