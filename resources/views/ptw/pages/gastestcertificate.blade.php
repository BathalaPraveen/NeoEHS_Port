<div class="row">
    <div class="col">

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
                                {{ $gas->workdescription }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="require">Location</label>
                            </td>
                            <td>:</td>
                            <td>
                                {{ getLocationName($gas->location) }}
                            </td>
                            <td>
                                <label class="">Equipment / Process Affected</label>
                            </td>
                            <td>:</td>
                            <td class="form-input">

                                {{ $gas->equipmentprocess }}
                            </td>
                            <td>
                                <label class="">Hotwork type (if aplicable refer to Hotwork
                                    Certificate)</label>
                            </td>
                            <td>:</td>
                            <td class="form-input">
                                {{ $gas->hotworktype }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="require">Gas Test for</label>
                            </td>
                            <td>:</td>
                            <td class="form-input">

                                @if ($gas->gastestfor == 1)
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif
                                Confined Space

                                @if ($gas->gastestfor == 2)
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif
                                Open Air

                            </td>
                            <td>Work Start Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($gas->workstartdate) }}
                            </td>
                            <td>Work End Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($gas->workenddate) }}

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
                            {{ $gas->accesswayarrangement }}

                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="m-2">
                            @if ($gas->accesswayarrangement_check == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label "> Isolation Certificate Required
                        (Remark if not applicable)</label>
                    <div class="col-md-9">
                        <div class="m-2">
                            {{ $gas->isolationcertificate }}

                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="m-2">

                            @if ($gas->isolationcertificate_check == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label ">Ventilation Established:</label>
                    <div class="col-md-4">
                        <div class="m-2">

                            @php

                                $ventilationestablishment = json_decode($gas->ventilationestablishment);
                                if($ventilationestablishment == null || $ventilationestablishment == ''){
                                    $ventilationestablishment == [" test"];
                                }


                            @endphp

                            @if (in_array('Mechanical Forced Air', $ventilationestablishment))
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif


                            <label for="ventilationestablishment_mechanical">Mechanical Forced
                                Air</label>
                            @if (in_array('Natural Ventilation', $ventilationestablishment))
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                            <label for="ventilationestablishment_natural">Natural
                                Ventilation</label>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label ">Mean of Communication:</label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->meanofcommunication }}

                        </div>
                    </div>

                </div>

                <div class="row mb-2">
                    <label class="col-sm-11 col-form-label require"> Space Hazard Assessment has
                        been reviewed and brief conducted by Entry Supervisor with Authorised
                        Entrance & Standby Person</label>

                    <div class="col-md-1">
                        <div class="m-2">

                            @if ($gas->spacehazardaccesment == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif


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
                            {{ $gas->gasdetector }}

                        </div>
                    </div>

                    <label class="col-sm-2 col-form-label ">Last Calibration Date</label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->lastcalivration }}
                        </div>
                    </div>

                </div>

                <div class="row mb-2">

                    <label class="col-sm-2 col-form-label " for="safetybelt">Safety belt, harness
                        and/or
                        safety line or lifeline/rescue line</label>
                    <div class="col-md-1">
                        <div class="m-2">
                            @if ($gas->safetybelt == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label " for="hoistingequipment">Hoisting
                        Equipment</label>
                    <div class="col-md-1">
                        <div class="m-2">
                            @if ($gas->hoistingequipment == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                        </div>
                    </div>

                    <label class="col-sm-2 col-form-label " for="scba">SCBA</label>
                    <div class="col-md-1">
                        <div class="m-2">
                            @if ($gas->scba == 'YES')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="m-2">
                            {{ $gas->scbadetails }}

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
                        person
                    </label>
                    <div class="col-md-8">
                        <div class="m-2">
                            <table class="table" id="person">
                                <tbody>
                                    <tr class="">
                                        <td>
                                            @php
                                                $authperson = array_to_string(json_decode($gas->authperson));
                                                $authpersonArray = string_to_array($authperson);
                                            @endphp
                                            @foreach ($authpersonArray as $person)
                                                <div> {{ $person }}</div>
                                            @endforeach

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
                            {{ $gas->supervisordetails }}

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
                    @php
                        $gastest = json_decode($gas->gastest);
                    @endphp
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
                                <td class="form-input">
                                    {{ $gastest->initial->oxygen }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->remarks->oxygen }}

                                </td>
                            </tr>
                            <tr>
                                <td>EXPLOSIVE ( % LEL )</td>
                                <td>
                                    <= 10% LEL</td>
                                <td class="form-input">
                                    {{ $gastest->standard->explosive }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->initial->explosive }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->remarks->explosive }}

                                </td>
                            </tr>
                            <tr>
                                <td>TOXIC (PEL)</td>
                                <td>
                                    <= PEL </td>
                                <td class="form-input">
                                    {{ $gastest->standard->toxic }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->initial->toxic }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->remarks->toxic }}

                                </td>
                            </tr>
                            <tr>
                                <td>H2S (PPM)</td>
                                <td>
                                    <= 10 PPM </td>
                                <td class="form-input">
                                    {{ $gastest->standard->h2s }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->initial->h2s }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->remarks->h2s }}

                                </td>
                            </tr>
                            <tr>
                                <td>CO (PPM)</td>
                                <td>
                                    <= 25 PPM</td>
                                <td class="form-input">
                                    {{ $gastest->standard->co }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->initial->co }}

                                </td>
                                <td class="form-input">
                                    {{ $gastest->remarks->co }}

                                </td>
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

                                        @if ($gas->safe_work == 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="safe_work_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="m-2">
                                        @if ($gas->safe_work != 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="safe_work_no">NO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label ">REMARK</label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->safe_work_remarks }}

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
                                        @if ($gas->atmosphere == 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="atmosphere_yes">Yes</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="m-2">
                                        @if ($gas->atmosphere != 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="atmosphere_no">NO</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label ">REMARK</label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->atmosphere_remarks }}

                        </div>
                    </div>

                </div>

                <div class="row mb-2">

                    <label class="col-sm-2 col-form-label ">AUTHORIZED GAS TESTER NAME</label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->gastestername }}

                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label ">TIME / DATE </label>
                    <div class="col-md-4">
                        <div class="m-2">
                            {{ $gas->gastestdatetime }}
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

                </div>
            </div>


            <div class="row g-3 px-2 pt-4">

                <div class="row mb-2 mx-1">

                    @php
                        $gaslog = json_decode($gas->gaslog);
                    @endphp
                    <table class="table table-bordered " id="gaslog">
                        <thead>
                            <tr>
                                <td>DATE</td>
                                <td>Time</td>
                                <td>OXYGEN</td>
                                <td>EXPLOSIVE</td>
                                <td>TOXIC</td>
                                <td>AGT NAME & SIGN</td>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gaslog as $log)
                                <tr class="gaslog" id="gaslogtable">
                                    <td class="form-input">
                                        {{ $log->date }}
                                    </td>
                                    <td class="form-input">
                                        {{ $log->time }}
                                    </td>
                                    <td class="form-input">
                                        {{ $log->oxygen }}
                                    </td>
                                    <td class="form-input">
                                        {{ $log->explosive }}
                                    </td>
                                    <td class="form-input">
                                        {{ $log->toxic }}
                                    </td>
                                    <td class="form-input">
                                        {{ $log->name }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>
            </div>


            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">ACCEPTANCE </h6>
            </div>

            <div class="row g-3 px-2 pt-4">
                <div class="col-md-12">

                    <div class="m-2 form-input">

                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                        <label class="form-check-label" for="accept_terms">I <b>fully
                                understand </b>& will <b>ensure compliance</b> with all the
                            requirements of this permit.</label>
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label">
                        Name</label>
                    <div class="col-sm-4 form-input">
                        {{ getusername($gas->created_by) }}

                    </div>
                    <label class="col-sm-2 col-form-label form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($gas->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label">
                        Remarks</label>
                    <div class="col-sm-10">
                        {{ $gas->applicant_remarks }}
                    </div>
                </div>
            </div>

            @if (count($gaspermitStatusLog) > 0)
                <div class="card-header card-header-inner  mb-3 mt-3">
                    <h6 class="text-white">APPROVAL</h6>
                </div>
                @foreach ($gaspermitStatusLog as $statusLog)
                    <div class="row  px-3">
                        <div class="col-md-12">
                            <table class="table mb-0 table-borderless">
                                <tbody>
                                    <tr style="background-color: #aaa">
                                        <td colspan="6" style="font-weight:500;"> Status -
                                            {!! subpermitStatus($statusLog->to_status) !!} </td>
                                    </tr>
                                    <tr>
                                        <th style="width: 10%">Name</th>
                                        <td style="width: 5%">:</td>
                                        <td style="width: 30%">{{ getusername($statusLog->approved_by) }}</td>
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
        </div>
    </div>
</div>
