<style>
    .table-bordered tr {
        border: 0.5px solid
    }

    .table-bordered tr td {
        border: 0.5px solid;
        padding: 5px;
    }

    .table-bordered tbody tr:nth-child(odd) {
        background-color: #ccc;

    }

    .table-striped tr:nth-child(odd) {
        background-color: #ccc;
        border-bottom: 1px solid;
    }

    td {
        padding: 5px;
    }
</style>
<pagebreak />
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #10d6d6;color:#000000;font-weight:bold;padding: 5px 5px 5px;">
            LIFTING CERTIFICATE
        </td>
    </tr>
</table>
<br />
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            WORK DESCRIPTION
        </td>
    </tr>
</table>
<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>
                <label class="require">
                    Location</label>
            </td>
            <td>:</td>
            <td colspan="3">
                <div class="form-input">
                    {{ $lifting->location }}
                </div>
            </td>
            <td>
                <label class="require">Date & Time</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $lifting->datetime }}
                </div>
            </td>

        </tr>

        <tr>
            <td>
                <label class="">
                    Work Description :</label>
            </td>
            <td>:</td>
            <td colspan="4">
                <div class="form-input">
                    {{ $lifting->workdescription }}
                </div>
            </td>
        </tr>

    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            LOAD(S) DESCRIPTION
        </td>
    </tr>
</table>
<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Description of load(s) </td>
            <td colspan="2"> {{ $lifting->loaddescription }}</td>

        </tr>
        <tr>
            <td>Overall dimensions</td>
            <td colspan="2">{{ $lifting->overalldimension }}</td>
        </tr>
        <tr>
            <td>Weight of load (kg)</td>
            <td>{{ $lifting->loadweight }}</td>
            <td>
                <div class="col-md-3 form-input">
                    <div class="m-2">
                        @if ($lifting->weight_type == 'knownweight')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="weight_type_known">Known
                            weight</label>
                    </div>
                </div>
                <div class="col-md-3 form-input">
                    <div class="m-2">
                        @if ($lifting->weight_type == 'estimatedweight')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="weight_type_estimated">Estimated
                            weight</label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>Center of gravity</td>
            <td colspan="2">
                <div class="col-md-3 form-input">
                    <div class="m-2">
                        @if ($lifting->centerofgravity == 'obvious')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="centerofgravity_obvious">Obvious</label>
                    </div>
                </div>
                <div class="col-md-3 form-input">
                    <div class="m-2">
                        @if ($lifting->centerofgravity == 'estimated')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="centerofgravity_estimated">Estimated </label>
                    </div>
                </div>
                <div class="col-md-3 form-inpt">
                    <div class="m-2">
                        @if ($lifting->centerofgravity == 'determinedbydrawing')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="centerofgravity_determinedbydrawing">Determined by
                            drawing</label>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            LIFTING EQUIPMENT INFORMATION
        </td>
    </tr>
</table>
@php
    $liftequpdetails = json_decode($lifting->liftingquipment);
    $i = 1;
@endphp
<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>

        <tr>


            @foreach ($liftingequipment as $equipment)
                <td style="width:20%;"> {{ $equipment->category_name }} </td>
                <td style="width:2%;">:</td>
                <td style="width:25%;">

                    @php
                        $equId = $equipment->id;
                    @endphp
                    {{ $liftequpdetails->$equId }}

                </td>

                @if ($i % 2 == 0)
        </tr>
        <tr>
            @endif

            @php
                $i++;
            @endphp
            @endforeach
        </tr>


    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            RIGGING DETAILS
        </td>
    </tr>
</table>
@php
    $riggingDetails = json_decode($lifting->riggingdetails);
@endphp
<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
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
            @php
                $riggingId = $rigging->id;
            @endphp
            <tr>
                <td>
                    <label for="" class="form-input ">{{ $rigging->category_name }}</label>

                </td>
                <td class="form-input">

                    {{ $riggingDetails->$riggingId->size }}

                </td>
                <td class="form-input">
                    {{ $riggingDetails->$riggingId->swl }}

                </td>
                <td class="form-input">
                    {{ $riggingDetails->$riggingId->quantity }}

                </td>
                <td class="form-input">
                    {{ $riggingDetails->$riggingId->weight }}

                </td>
            </tr>
        @endforeach
        <tr>
            <td>Total weight of the lifting gears (kg)</td>
            <td> {{ $lifting->ligtgearsweight }}</td>
            <td>Total suspended load (weight lifting gear + load)</td>
            <td colspan="2">{{ $lifting->totalweight }}</td>
        </tr>
    </tbody>
</table>

<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Means of Communication
        </td>
    </tr>
</table>

<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">

    <tbody>

        <tr>
            <td>Mean of Communication</td>
            <td> {{ $lifting->ligtgearsweight }}</td>
            <td>Can the operator see the loading and unloading point from his position</td>
            <td>
                <div class="col-md-2 form-input">
                    @if ($lifting->loadinpoint == 'yes')
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">YES</label>

                    @if ($lifting->loadinpoint == 'no')
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">NO</label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Physical and Environmental Consideration
        </td>
    </tr>
</table>
@php
    $env_cond = json_decode($lifting->env_cond);
@endphp
<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Ground condition</td>
            <td>Is the ground made safe (e.g. Placing stell plate)?</td>
            <td style="width: 15% " class="form-input">
                @if ($env_cond->pec_gc == 'yes')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">YES</label>
                @if ($env_cond->pec_gc == 'no')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">NO</label>
            </td>
        </tr>
        <tr>
            <td rowspan="2">Obstacles</td>
            <td>Are there any overhead obstacles such as power lines?</td>
            <td class="form-input">
                @if ($env_cond->pec_ob == 'yes')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">YES</label>
                @if ($env_cond->pec_ob == 'no')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">NO</label>
            </td>
        </tr>
        <tr>

            <td>Are there nearby buildings or structurs, equipment or stacked
                materials that may obstruct lifting operation from being carried out
                safely?</td>
            <td class="form-input">
                @if ($env_cond->pec_obs == 'yes')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">YES</label>
                @if ($env_cond->pec_obs == 'no')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">NO</label>
            </td>
        </tr>
        <tr>
            <td>Lighting</td>
            <td>Is the lighting conditions adequate? <br>
                (If the lighting out with Daylight hours additional lighting will be
                provided)</td>
            <td class="form-input">
                @if ($env_cond->pec_lig == 'yes')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">YES</label>
                @if ($env_cond->pec_lig == 'no')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">NO</label>
            </td>
        </tr>
        <tr>
            <td>Demarcation</td>
            <td>Has the zone of operation been barricaded (with warning sign and
                barriers) to prevent unauthorized access for onshore lifting
                activities?</td>
            <td class="form-input">
                @if ($env_cond->pec_dem == 'yes')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">YES</label>
                @if ($env_cond->pec_dem == 'no')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label">NO</label>
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
                @if (isset($env_cond->pec_env_gc))
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="pec_env_gc">
                    Thunderstorm and lightening strikes in the area. the
                    ground condition must be checked after thunderstorm.</label>
            </td>

        </tr>
        <tr>

            <td colspan="2">
                @if (isset($env_cond->pec_env_wet))
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="pec_env_wet">Strong wind
                    that may sway the suspended load. (Local
                    weather forecast & Supervisor's experience & Tagline to
                    address)</label>

            </td>
        </tr>
        <tr>
            <td colspan="2">
                @if (isset($env_cond->pec_env_scn))
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="pec_env_scn"> Do not
                    proceed with lifting operation during bad sea
                    condition. (Strong current and wave). (Local weather forecast &
                    supervisor's experience & Tagline to address.)</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="form-check form-check-inline">
                @if (isset($env_cond->pec_others))
                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                @else
                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                @endif


                <label class="form-check-label" for="pec_others"> Other
                    circumstances :</label>
                </div>
                <div class="form-check form-check-inline">
                    {{ isset($env_cond->other_circum) ? $env_cond->other_circum : '' }}
                </div>
            </td>
        </tr>
    </tbody>
</table>

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Personnel Involved in lifting Operation
        </td>
    </tr>
</table>

<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <thead>
        <tr style="background-color: #2e97b8">
            <td>Position</td>
            <td>Name & Identification Number</td>
            <td>Document</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Lifting Supervisor</td>
            <td class="form-input">
                {{ $lifting->liftingsupervisor }}
            </td>
            <td>
                @if(isset($liftingdocument[1]))
                    <a href="{{ url($liftingdocument[1]['file_path'] ) }}" target="_blank">{{ $liftingdocument[1]['file_orgname'] }}</a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Crane Operator</td>
            <td class="form-input">
                {{ $lifting->liftingcraneoperator }}
            </td>
            <td>
                @if(isset($liftingdocument[2]))
                    <a href="{{ url($liftingdocument[2]['file_path'] ) }}" target="_blank">{{ $liftingdocument[2]['file_orgname'] }}</a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Signalman</td>
            <td class="form-input">
                {{ $lifting->liftingsignalman }}
            </td>
            <td>
                @if(isset($liftingdocument[3]))
                    <a href="{{ url($liftingdocument[3]['file_path'] ) }}" target="_blank">{{ $liftingdocument[3]['file_orgname'] }}</a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Rigger</td>
            <td class="form-input">
                {{ $lifting->liftingrigger }}
            </td>
            <td>
                @if(isset($liftingdocument[4]))
                    <a href="{{ url($liftingdocument[4]['file_path'] ) }}" target="_blank">{{ $liftingdocument[4]['file_orgname'] }}</a>
                @endif
            </td>
        </tr>
        <tr>
            <td>Others</td>
            <td>
                {{ $lifting->liftingothers }}
            </td>
            <td>
                @if(isset($liftingdocument[5]))
                    <a href="{{ url($liftingdocument[5]['file_path'] ) }}" target="_blank">{{ $liftingdocument[5]['file_orgname'] }}</a>
                @endif
            </td>
        </tr>
    </tbody>
</table>

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            ACCEPTANCE & APPROVAL
        </td>
    </tr>
</table>
<table class="table table-bordered" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ getusername($lifting->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($lifting->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $lifting->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>
<br />

@if (count($liftingpermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table><br />
    @foreach ($liftingpermitStatusLog as $statusLog)
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    Status - {!! subpermitStatusText($statusLog->to_status) !!}
                </td>

            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="20%" style="padding:5px;"><b>Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ getusername($statusLog->approved_by) }}</td>
                <td width="20%" style="padding:5px;"><b>Date & Time</b></td>
                <td width="2%" style="padding:5 px;">:</td>
                <td width="25%" style="padding:5px;"> {{ displayDateTimeformat($statusLog->created_at) }}
                </td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Description</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td colspan="75" colspan="4" style="padding:5px;">{{ $statusLog->remarks }}</td>
            </tr>
        </table>
    @endforeach
    <br />
@endif
