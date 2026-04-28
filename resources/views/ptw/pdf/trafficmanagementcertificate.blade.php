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
            WORK TRAFFIC MANAGEMENT CERTIFICATE
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
                    {{ $traffic->location }}

                </div>
            </td>
            <td>
                <label class="require">Date & Time</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $traffic->datetime }}
                </div>
            </td>

        </tr>
        <tr>
            <td>
                <label class="require">
                    Work Description</label>
            </td>
            <td>:</td>
            <td colspan="9">
                <div class="form-input">
                    {{ $traffic->workdescription }}

                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="">
                    Reason(s) for closing the road(s)</label>
            </td>
            <td>:</td>
            <td colspan="9">
                <div class="form-input">
                    {{ $traffic->periodorduratio }}

                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="">
                    work start date</label>
            </td>
            <td>:</td>
            <td colspan="2">
                <div class="form-input">
                    {{ displayDateformat($traffic->workstartdate) }}

                </div>
            </td>
            <td>
                <label class="">
                    work end date</label>
            </td>
            <td>:</td>
            <td colspan="3">
                <div class="form-input">
                    {{ displayDateformat($traffic->workenddate) }}

                </div>
            </td>
        </tr>

    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            SKETCH or PLOT-PLAN THE TRAFFIC FLOW MANAGEMENT AT THE
            WORKSITE (Please attach attachment(s) if applicable)
        </td>
    </tr>
</table>

<table class="table-bordered" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td> Upload Plan</td>
            <td>
                @foreach ($trafficplandocument as $document)
                    <div>
                        <a target="_blank" href="{{ url($document['file_path']) }}">{{ $document['file_orgname'] }}</a>
                    </div> <br>
                @endforeach
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            WORKSITE TRAFFIC MANAGEMENT DETAILS
        </td>
    </tr>
</table>

<table class="table-bordered" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td> Lighting</td>
            <td>
                @foreach ($wtmotherdetails as $wtmother)
                    @if (in_array($wtmother->id, json_decode($traffic->wtmother)))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">{{ $wtmother->category_name }}</label> &nbsp; &nbsp;
                @endforeach
            </td>
        </tr>
        <tr>
            <td> </td>
            <td>
                @foreach ($wtmotherdetails as $wtmother)
                    @if (in_array($wtmother->id, json_decode($traffic->wtmother)))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">{{ $wtmother->category_name }}</label> &nbsp; &nbsp;
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Others</td>
            <td>
                {{ $traffic->wtmothers }}
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

<table class="table-bordered" width="100%" style="width:100%;border: 0.5px solid">

    <tr>
        <td>
            the </p>
            <p>worksite traffic management proposed under Permit to Work number
                <u><b>{{ $traffic->workpermitnymber }}</b> </u>
                dated <u><b>{{ $traffic->workpermitdate }}</b> </u>
                can be carried
                out:
            </p>

            <hr>

            <p>a) Without risk of damage to any underground services</p>
            <p>b) Provided that the following additional controls / alternative route are taken
                to prevent damages to the equipment/services specified below:</p>
            <p>c) With the compliance to traffic security rules & regulation</p>
            <p>d) Provide that the following additional controls / alternative route are taken
                to prevent damages to the equipment/services specified below:</p>
            <p class="border rounded pt-3 pb-5 px-3">
                {{ $traffic->otherserice }}
            </p>
        </td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>

</table>
<table class="table table-bordered" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ getusername($traffic->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($traffic->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $traffic->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>

<br />
@if (count($trafficpermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($trafficpermitStatusLog as $statusLog)
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
