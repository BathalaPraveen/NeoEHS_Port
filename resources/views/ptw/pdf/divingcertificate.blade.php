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
            DIVING CERTIFICATE
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
            <td><label class="">Work Description</label></td>
            <td>:</td>
            <td colspan="7" class="form-input">
                {{ $diving->workdescription }}
            </td>
        </tr>

        <tr>
            <td>Location</td>
            <td>:</td>
            <td class="form-input">
                {{ getLocationName($diving->location) }}
            </td>
            <td><label class="">Estimation Diving Deep</label></td>
            <td>:</td>
            <td class="form-input">
                {{ $diving->divingdeep }}
            </td>

            <td>Work Start Date</td>
            <td>:</td>
            <td>
                {{ displayDateformat($diving->workstartdate) }}
            </td>
        </tr>

        <tr>
            <td>Work End Date</td>
            <td>:</td>
            <td>
                {{ displayDateformat($diving->workenddate) }}

            </td>
            <td> <label class="">Date</label></td>
            <td>:</td>
            <td class="form-input">
                {{ $diving->date }}
            </td>
            <td> <label class="">Time Start</label></td>
            <td>:</td>
            <td class="form-input">
                {{ $diving->time }}
            </td>
        </tr>
        <tr>
            <td>
                <label class="">End Time</label>
            </td>
            <td>:</td>
            <td class="form-input">
                {{ $diving->estimationtime }}
            </td>

            <td><label class="">Applied Date & Time</label></td>
            <td>:</td>
            <td class="form-input">
                {{ Displaydatetimeformat($diving->created_at) }}
            </td>
        </tr>
    </tbody>
</table>

<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            WORK DESCRIPTION
        </td>
    </tr>
</table>
@php
    $divingEquipments = json_decode($diving->equipment);
    $i = 1;
@endphp

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>

            @foreach ($equipmentgear as $equipment)
                <td>

                    @if (in_array($equipment->id, $divingEquipments->equipment))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">{{ $equipment->category_name }}</label>
                </td>

                @if ($i % 4 == 0)
        </tr>
        <tr>
            @endif

            @php
                $i++;
            @endphp
            @endforeach

        </tr>
        <tr>
            <td>Others</td>
            <td colspan="3">
                {{ $divingEquipments->equipmentothers }}

            </td>
        </tr>
    </tbody>
</table>

<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Diving/Site Preparation
        </td>
    </tr>
</table>
@php
    $divingsitepreparationArray = json_decode($diving->sitepreparation);
@endphp
<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>

        @foreach ($divingsitepreparation as $sitepreparation)
            <tr>
                <td>
                    <label class="form-check-label">{{ $sitepreparation->category_name }}</label>
                </td>
                <td style="width:10%">
                    @if (in_array($sitepreparation->id, $divingsitepreparationArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Diver(s) Detail
        </td>
    </tr>
</table>
@php
    $driversDetails = json_decode($diving->divers);
@endphp

<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <thead>
        <tr style="background-color: #2e97b8">
            <td>Name</td>
            <td>IC no /Pass No</td>
            <td>Competency</td>
            <td>Health Fitness</td>
        </tr>
    </thead>
    <tbody>

        @foreach ($driversDetails as $driver)
            <tr class="driverdetails">
                <td class="form-input">
                    {{ $driver->name }}

                </td>
                <td class="form-input">
                    {{ $driver->idnumber }}

                </td>
                <td class="form-input">
                    {{ $driver->competency }}

                </td>
                <td class="form-input">
                    {{ $driver->healthfitness }}
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
<table class="table-striped table-bordered" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ getusername($diving->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($diving->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $diving->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>
<br />

@if (count($divingpermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($divingpermitStatusLog as $statusLog)
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
