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
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #1066d6;color:#000000;font-weight:bold;padding: 5px 5px 5px;">
            GAS CERTIFICATE
        </td>
    </tr>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Application
        </td>
    </tr>
</table>

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tr>
        <td width="20%" style="padding:5px;"><b>Permit No</b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" style="padding:5px;">{{ $gas->sub_permit_id }}</td>
        <td width="20%" style="padding:5px;"><b>Location</b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" style="padding:5px;">{{ $gas->location }}</td>
    </tr>
    <tr>
        <td style="padding:5px;"><b>Equipment / Process Affected</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">{{ $gas->equipmentprocess }}</td>
        <td style="padding:5px;"><b>Hotwork type (if aplicable refer to Hotwork Certificate)</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">{{ $general->hotworktype }}</td>
    </tr>

    <tr>
        <td style="padding:5px;"><b>Gas Test for</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">
            @if ($gas->gastestfor == 1)
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
            Confined Space

            @if ($gas->gastestfor == 2)
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
            Open Air
        </td>
        <td style="padding:5px;"><b></b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;"></td>
    </tr>

</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            SITE PREPARATION
        </td>
    </tr>
</table>

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tr>
        <td width="20%" style="padding:5px;"><b>Access way arrangement</b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" colspan="4" style="padding:5px;">{{ $gas->accesswayarrangement }}</td>
        <td width="25%" style="padding:5px;">
            @if ($gas->accesswayarrangement_check == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td width="20%" style="padding:5px;"><b>Isolation Certificate Required
                (Remark if not applicable)</b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" colspan="4" style="padding:5px;">{{ $gas->isolationcertificate }}</td>
        <td width="25%" style="padding:5px;">
            @if ($gas->isolationcertificate_check == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>
    </tr>
    <tr>
        <td style="padding:5px;"><b>Ventilation Established</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">
            @php

                $ventilationestablishment = json_decode($gas->ventilationestablishment);

            @endphp

            @if (in_array('Mechanical Forced Air', $ventilationestablishment))
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif


            <label for="ventilationestablishment_mechanical">Mechanical Forced
                Air</label>
            <br>
            @if (in_array('Natural Ventilation', $ventilationestablishment))
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif

            <label for="ventilationestablishment_natural">Natural
                Ventilation</label>
        </td>
        <td style="padding:5px;"><b>Mean of Communication</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">{{ $gas->meanofcommunication }}</td>
    </tr>

    <tr>
        <td style="padding:5px;" colspan="5"><b>Space Hazard Assessment has
                been reviewed and brief conducted by Entry Supervisor with Authorised
                Entrance & Standby Person</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">
            @if ($gas->spacehazardaccesment == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>

    </tr>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            EQUIPMENT ON SCENE
        </td>
    </tr>
</table>

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tr>
        <td style="padding:5px;"><b>Gas Detector : Model / Serial Number</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">{{ $gas->gasdetector }}</td>
        <td style="padding:5px;"><b>Last Calibration Date</b></td>
        <td style="padding:5px;">:</td>
        <td style="padding:5px;">{{ $gas->lastcalivration }}</td>
    </tr>
    <tr>
        <td><b>Safety belt, harness and/or safety line or lifeline/rescue line</b></td>
        <td>
            @if ($gas->safetybelt == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>
        <td><b>Hoisting
                Equipment</b></td>
        <td>
            @if ($gas->hoistingequipment == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>
        <td><b>SCBA</b></td>
        <td>
            @if ($gas->scba == 'YES')
                <span style="color: #267709;">✔</span>
            @else
                <span style="color: #f72626;font-size: 14px">&#8226;</span>
            @endif
        </td>
        <td>
            {{ $gas->scbadetails }}
        </td>


    </tr>

</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            PARTIES INVOLVED IN THE WORK (MANDATORY FOR CONFINED SPACE)
        </td>
    </tr>
</table>

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tr>
        <td width="20%" style="padding:5px;"><b>Authorised Entrance & Standby person </b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" style="padding:5px;">
            @php
                $authperson = array_to_string(json_decode($gas->authperson));
                $authpersonArray = string_to_array($authperson);
            @endphp
            @foreach ($authpersonArray as $person)
                <div> {{ $person }}</div>
            @endforeach
        </td>
    </tr>

    <tr>
        <td width="20%" style="padding:5px;"><b>Entry Supervisor Name & Signature </b></td>
        <td width="2%" style="padding:5px;">:</td>
        <td width="25%" style="padding:5px;">{{ $gas->supervisordetails }}</td>
    </tr>

</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Gas Test
        </td>
    </tr>
</table>
@php
    $gastest = json_decode($gas->gastest);
@endphp

<table class="table table-bordered" style="width:100%;border: 0.5px solid">
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

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            SAFE TO WORK / ENTER CONFINED SPACE (CIRCLE)
        </td>
    </tr>
</table>
@php
    $gastest = json_decode($gas->gastest);
@endphp

<table class="table table-bordered" style="width:100%;border: 0.5px solid">
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


    </tbody>
</table>

<table class="table table-bordered" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td style="width:20%">
                SAFE TO WORK / ENTER CONFINED SPACE (CIRCLE)
            </td>
            <td style="width:2%">:</td>
            <td style="width:5%">
                @if ($gas->safe_work == 'YES')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="safe_work_yes">YES</label> &nbsp;&nbsp;

                @if ($gas->safe_work != 'YES')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="safe_work_no">NO</label>
                </div>
            </td>
            <td style="width:5%">
                REMARK
            </td>
            <td style="width:2%">:</td>
            <td style="width:20%">
                {{ $gas->safe_work_remarks }}
            </td>
        </tr>
        <tr>
            <td>
                ATMOSPHERE MONITORING REQUIRED (CIRCLE)
            </td>
            <td>:</td>
            <td>
                @if ($gas->atmosphere == 'YES')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="atmosphere_yes">YES</label> &nbsp;&nbsp;

                @if ($gas->atmosphere != 'YES')
                    <span style="color: #267709;">✔</span>
                @else
                    <span style="color: #f72626;font-size: 14px">&#8226;</span>
                @endif

                <label class="form-check-label" for="atmosphere_no">NO</label>
            </td>
            <td>
                REMARK
            </td>
            <td>:</td>
            <td>
                {{ $gas->atmosphere_remarks }}
            </td>
        </tr>
        <tr>
            <td>
                AUTHORIZED GAS TESTER NAME
            </td>
            <td>:</td>
            <td>
                {{ $gas->gastestername }}
            </td>
            <td>
                TIME / DATE
            </td>
            <td>:</td>
            <td>
                {{ $gas->gastestdatetime }}
            </td>
        </tr>
    </tbody>
</table>

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            GAS TEST LOG (ATTACH IF MORE TEST CONDUCTED)
        </td>
    </tr>
</table>
@php
    $gaslog = json_decode($gas->gaslog);
@endphp

<table class="table table-bordered" style="width:100%;border: 0.5px solid">
    <thead>
        <tr>
            <td style="width:20%;">DATE</td>
            <td style="width:20%;">Time</td>
            <td style="width:10%;">OXYGEN</td>
            <td style="width:10%;">EXPLOSIVE</td>
            <td style="width:10%;">TOXIC</td>
            <td style="width:30%;">AGT NAME & SIGN</td>

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
<br>
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
            <td>{{ getusername($gas->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($gas->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $gas->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>
<br />

@if (count($gaspermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($gaspermitStatusLog as $statusLog)
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
