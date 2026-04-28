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
            SURFACE PENETRATION CERTIFICATE
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
                <label class="  require">
                    Location</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $surface->location }}

                </div>
            </td>
            <td> <label class="require">
                    Excavation hazardous area</label></td>
            <td>:</td>
            <td>
                <div class="form-input">
                    <div>

                        @if ($surface->hazardousarea == 'Hazardous')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif


                        <label class="form-check-label" for="checkbox_Hazardous">Hazardous</label>
                    </div>
                    <div>
                        @if ($surface->hazardousarea == 'Non-Hazardous')
                            <span style="color: #267709;">✔</span>
                        @else
                            <span style="color: #f72626;font-size: 14px">&#8226;</span>
                        @endif

                        <label class="form-check-label" for="checkbox_Non_Hazardous">Non-Hazardous</label>
                    </div>


                </div>
            </td>
            <td>
                <label class="">
                    Trial excavation carried out</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">

                    @if ($surface->trailexcavation == 'YES')
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label" for="trailexcavation">Hazardous</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="require">
                    Max excavation depth / length</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $surface->maxexcavationdepth }}
                </div>
            </td>
            <td>
                <label class="require">
                    Max excavation deep</label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $surface->maxexcavationdeep }}

                </div>
            </td>
            <td>
                <label class="">Result from Trial </label>
            </td>
            <td>:</td>
            <td>
                <div class="form-input">
                    {{ $surface->resulttrailfrom }}

                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label class="require">Work Description</label>
            </td>
            <td>:</td>
            <td colspan="7">
                <div class="form-input">
                    {{ $surface->workdescription }}

                </div>
            </td>
        </tr>
    </tbody>
</table>
<br />
<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            PPE (Compulsary)
        </td>
    </tr>
</table>

@php
    $ppelistdetails = json_decode($surface->ppelist);
    $ppelistArray = $ppelistdetails->ppelist;
    $i = 1;
@endphp
<table class="  table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            @foreach ($surfaceppe as $ppe)
                <td>
                    @if (in_array($ppe->id, $ppelistArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label"
                        for="checkbox_{{ encryptId($ppe->id) }}">{{ $ppe->category_name }}</label>
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
                {{ $ppelistdetails->ppeothers }}
            </td>
        </tr>
    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            EQUIPMENT
        </td>
    </tr>
</table>

@php
    $equipmentlistdetails = json_decode($surface->equipment);
    $equipmentlistArray = $equipmentlistdetails->equipment;
    $i = 1;
@endphp
<table class="  table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            @foreach ($equipments as $equipment)
                <td>
                    @if (in_array($equipment->id, $equipmentlistArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label"
                        for="checkbox_{{ encryptId($equipment->id) }}">{{ $equipment->category_name }}</label>
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
                {{ $equipmentlistdetails->equipmentothers }}
            </td>
        </tr>
    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            ADDITIONAL REQUIREMENTS
        </td>
    </tr>
</table>

@php
    $addrequiermentslistdetails = json_decode($surface->addrequierments);
    $addrequiermentslistArray = $addrequiermentslistdetails->addrequierments;
    $i = 1;
@endphp
<table class=" table-striped" width="100%" style="width:100%;border: 0.5px solid">
    <tbody>
        <tr>
            @foreach ($aditionalrequierments as $requierments)
                <td>
                    @if (in_array($requierments->id, $addrequiermentslistArray))
                        <span style="color: #267709;">✔</span>
                    @else
                        <span style="color: #f72626;font-size: 14px">&#8226;</span>
                    @endif

                    <label class="form-check-label"
                        for="checkbox_{{ encryptId($requierments->id) }}">{{ $requierments->category_name }}</label>
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
                {{ $addrequiermentslistdetails->requiermentsothers }}
            </td>
        </tr>
    </tbody>
</table>
<br />

<table style="width:100%;">
    <tr>
        <td style="width:100%;background-color: #0272b4;text-transform: uppercase;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
            ACCEPTANCE & APPROVAL
        </td>
    </tr>
</table>

<table class=" table-striped" width="100%" style="width:100%;border: 0.5px solid">

    <tr>
        <td colspan="6">
            <div class="col-md-12">
                <p>We hereby have checked the site / studied the
                    layout drawings and certify that the surface penetration proposed under
                    Permit to Work number
                    <u>{{ $surface->accept_worknumber }}</u>
                    dated
                    <u>{{ $surface->accept_work_date }}</u>
                    can be carried out:
                </p>
                <p>a) * Without risk of damage to any underground services</p>
                <p>b) * Provided that the following additional controls are taken to prevent
                    damages to the equipment/services specified below:</p>

                <p>
                    {{ $surface->accept_work_remarks }}
                </p>

                <div class="m-2 form-input">

                    <span style="color: #267709;">✔</span>
                    <label class="form-check-label" for="accept_terms">I <b>fully
                            understand </b>& will <b>ensure compliance</b> with all the
                        requirements of this permit.</label>
                </div>
            </div>

        </td>
    </tr>
    <tr>
        <td>Name</td>
        <td>:</td>
        <td>{{ getusername($surface->created_by) }}</td>
        <td>Date & Time</td>
        <td>:</td>
        <td>{{ Displaydatetimeformat($surface->created_at) }}</td>
    </tr>
    <tr>
        <td>Remarks</td>
        <td>:</td>
        <td colspan="4"> {{ $surface->applicant_remarks }}</td>
    </tr>

</table>

<br />
@if (count($surfacepermitStatusLog) > 0)

    <table style="width:100%;">
        <tr>
            <td style="width:100%;background-color: #FFFF00;text-transform: uppercase;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                Approvals
            </td>
        </tr>
    </table>
    @foreach ($surfacepermitStatusLog as $statusLog)
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
