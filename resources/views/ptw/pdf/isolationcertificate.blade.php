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
            ISOLATION CERTIFICATE
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
                <label for="" class=" require">Location</label>
            </td>
            <td>:</td>
            <td>
                <div class=" form-input">
                    {{ $isolation?->location }}
                </div>
            </td>

            <td>
                <label class="require">
                    What do Isolate</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $isolation->whatdoisolate }}
                </div>
            </td>
            <td>
                <label class="require">
                    Source of Energy / Flow to Isolate </label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $isolation->sourceofenergy }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="require">
                    Work Description</label>
            </td>
            <td>:</td>
            <td colspan="7">
                <div class="form-input">
                    {{ $isolation->workdescription }}
                </div>
            </td>
        </tr>

        <tr>
            <td>Work Start Date</td>
            <td>:</td>
            <td>
                {{ displayDateformat($isolation->workstartdate) }}
            </td>
            <td>Work End Date</td>
            <td>:</td>
            <td>
                {{ displayDateformat($isolation->workenddate) }}

            </td>u
        </tr>

    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            PPE (Compulsary)
        </td>
    </tr>
</table>
@php
    $ppelistArray = json_decode($isolation->ppelist);
    $i = 1;
@endphp
<table class="table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>

            @foreach ($ppelist as $ppe)
                <td>
                    @if (in_array($ppe->id, $ppelistArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif
                    <label class="form-check-label">{{ $ppe->category_name }}</label>
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


    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Isolation Detail
        </td>
    </tr>
</table>

@php
    $isolationArray = json_decode($isolation->isolation);
@endphp

<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <thead>
        <tr style="background-color: #71a2da">
            <td>Isolation Point</td>
            <td>Lock & Tag Out No.</td>
            <td>Time</td>

        </tr>
    </thead>
    <tbody>
        @foreach ($isolationArray as $details)
            <tr class="isolationmain">
                <td class="form-input">
                    {{ $details->point }}

                </td>
                <td class="form-input">
                    {{ $details->lock }}

                </td>
                <td class="form-input">
                    {{ $details->time }}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
<br>
<table class="table-bordered" width="100%" style="width:100%;border: 0.5px solid">
    <tr>
        <td>Lock Out / Tag Out Applied by</td>
        <td>:</td>
        <td>{{ $isolation->loockoutapplied }}</td>
        <td>IC No/Body Pass No</td>
        <td>:</td>
        <td>{{ $isolation->icno }}</td>
    </tr>
    <tr>
        <td colspan="6">
            I <u><b>{{ getusername($isolation->created_by) }}</b></u> Confirmed that the energy /
            flow has been
            fully isolated and secured.
        </td>
    </tr>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Isolation Daily Check
        </td>
    </tr>
</table>
@php
    $days = DAYS;
    $isolatiodailycheckArray = json_decode($isolation->isolatiodailycheck);
@endphp

<table class="table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <thead>
        <tr style="background-color: #71a2da">
            <td></td>
            @foreach ($days as $day)
                <td>{{ $day }}</td>
            @endforeach
            <td>Status</td>
        </tr>
    </thead>
    <tbody>
        @foreach (generateNumberArray(7) as $intervel)
            <tr>
                <td> Tag no {{ $intervel }}</td>
                @foreach ($days as $day)
                    <td>
                        @if (isset($isolatiodailycheckArray->$intervel->$day))
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif
                    </td>
                @endforeach
                <td>
                    {{ $isolatiodailycheckArray->$intervel->status }}

                </td>
            </tr>
        @endforeach
        <tr>
            <td>Remarks</td>
            <td colspan="8"> {{ $isolation->isolationremarks }}</td>
        </tr>
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
            <td>{{ getusername($isolation->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($isolation->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $isolation->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>
<br />

@if (count($isolationpermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($isolationpermitStatusLog as $statusLog)
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
