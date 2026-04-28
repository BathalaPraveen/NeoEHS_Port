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
            HOT WORK CERTIFICATE
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
            <td>
                <div class="form-input">
                    {{ $hotwork->location }}

                </div>
            </td>
            <td>
                <label class="require">Date & Time</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $hotwork->datetime }}
                </div>
            </td>
            <td>
                <label class="require">
                    Hotwork type (if aplicable refer to Hotwork Certificate)</label>
            </td>
            <td>:</td>
            <td style="width:10%">
                <div class="form-input">
                    <div class="">
                        @if ($hotwork->hotworktype == 'YES')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="hotwork_type_yes">YES</label>
                    </div>
                    <div class="">
                        @if ($hotwork->hotworktype != 'YES')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="hotwork_type_no">NO</label>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="require">
                    Location (if Hotwork is conducted on vessel, please write vessel name/ location of vessel):</label>
            </td>
            <td>:</td>
            <td colspan="9">
                <div class="form-input">
                    {{ $hotwork->locationmarine }}

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
                    {{ $hotwork->workdescription }}

                </div>
            </td>
        </tr>
    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Type of Hot Work operation
        </td>
    </tr>
</table>
@php
    $hotworkoperationArray = json_decode($hotwork->hotworkoperation);
    $i = 1;
@endphp

<table class=" table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            @foreach ($hotworkoperation as $hotworkoperation)
                <td>
                    @if (in_array($hotworkoperation->id, $hotworkoperationArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label">{{ $hotworkoperation->category_name }}</label>
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
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            Precautions
        </td>
    </tr>
</table>

<table class=" table-bordered table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>

        @php
            $i = 1;
            $precautionsArray = json_decode($hotwork->precautions);

        @endphp

        <tr>
            @foreach ($precautionslist as $precautions)
                <td style="width:40%">
                    <p>{{ $precautions->category_name }}</p>
                </td>
                <td style="width:10%" class="form-input">
                    @php
                        $id = $precautions->id;
                    @endphp
                    @if ($precautionsArray->$id == 'YES')
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif


                    <label class="form-check-label">YES</label>

                    @if ($precautionsArray->$id != 'YES')
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label" >N/A</label>
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
            ACCEPTANCE & APPROVAL
        </td>
    </tr>
</table>

<table class="table table-bordered" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            <td>Name</td>
            <td>:</td>
            <td>{{ getusername($hotwork->created_by) }}</td>
            <td>Date & Time</td>
            <td>:</td>
            <td>{{ Displaydatetimeformat($hotwork->created_at) }}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td colspan="4"> {{ $hotwork->applicant_remarks }}</td>
        </tr>
    </tbody>
</table>
<br />

@if (count($hotworkpermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($hotworkpermitStatusLog as $statusLog)
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
