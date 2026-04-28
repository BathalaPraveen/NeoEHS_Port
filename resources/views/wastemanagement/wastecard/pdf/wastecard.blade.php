@php
    $logo = '<img src="' . url('public/assets/images/common/Logo.png') . '" style="width:30%;">';

@endphp
<html>

<head>
    <style>
        .badge {
            padding: 1px 9px 2px;
            font-size: 12.025px;
            font-weight: bold;
            white-space: nowrap;
            color: #ffffff;
            background-color: #999999;
            -webkit-border-radius: 9px;
            -moz-border-radius: 9px;
            border-radius: 9px;
        }

        @page {
            size: auto;
            /* margin-header: 0mm; */
            /* margin-footer: 3mm; */
            odd-header-name: html_myHeader1;
            even-header-name: html_myHeader1;
            odd-footer-name: html_myFooter1;
            even-footer-name: html_myFoote1;
        }

        @page noheader {
            odd-header-name: _blank;
            even-header-name: _blank;
            odd-footer-name: _blank;
            even-footer-name: _blank;
        }

        .table {
            width: 100%;
        }

        .full-width {
            width: 100%;
            font-size: 11px;
        }

        .table td,
        .table th {}

        .table-striped tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05) !important;
        }

        body {
            /* font-family: "Courier New", Courier, monospace; */
            font-size: 13px
        }

        table {
            border-collapse: collapse;

        }

        .tblborder {
            border: 0.5px solid;
        }

        .activity,
        .activity th,
        .activity td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <htmlpageheader name="myHeader1" style="display:block">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0" style="width:40%;float:left;text-align:left;">{!! $logo !!}</td>
                <td border="0"
                    style=" width:60%;float:right;text-align:right;font-size: 24px;font-weight: bold;font-family: Georgia, serif;">
                    {{ $pagetitle }}
                </td>
            </tr>
        </table>
        <table border="0" style="width:100%;border:0;border-top: 4px solid #000;">
            <tr>
                <td border="0" style="width:30%;"></td>
                <!-- <td border="0"  style="width:70%;float:right;text-align:right;font-size: 12px;font-weight: bold"></td> -->
            </tr>
        </table>

    </htmlpageheader>


    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%"
            style="width:100%;border:0;background-color: #FFF;border-top: 4px solid #000;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">
                    <span style="font-style: italic;">{DATE d-m-Y}</span>
                </td>
                <td width="33%" align="center" style="font-weight: bold; font-style: italic;">

                </td>
                <td width="33%" style="text-align: right;">
                    {PAGENO}/{nbpg}
                </td>
            </tr>
        </table>
    </htmlpagefooter>


    <div style="width:100%;">
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    Waste Card
                </td>
            </tr>
        </table>
        <br />

        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>Company Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $companydetails->company_name }}</td>
                <td width="15%" style="padding:5px;"><b>Company Address</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{  $companydetails->company_address }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>Person in Charge</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $companydetails->person_incharge }}</td>
                <td width="15%" style="padding:5px;"><b>Contact No.</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $companydetails->contact_no }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>Email</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $companydetails->email }}</td>
            </tr>

        </table>
        <br />
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    A. PROPERTIES
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>Waste Code</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastetypedetails->wastetype_id }}</td>
                <td width="15%" style="padding:5px;"><b>Waste Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastetypedetails->wastetype_name }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Origin</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->origin }}</td>
                <td width="15%" style="padding:5px;"><b>Flash Point
                    (⁰C)</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->flash_point }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Boiling Point
                    (⁰C)</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->boiling_point }}</td>
                <td width="15%" style="padding:5px;"><b>Form in Room
                    Temperature</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ getItemName($wastecard->form_in_room_temp) }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Solubility in
                    Water</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ getItemName($wastecard->solubility_in_water) }}</td>
                <td width="15%" style="padding:5px;"><b>Density</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ getItemName($wastecard->density) }}</td>
            </tr>


            <tr>
                <td width="15%" style="padding:5px;"><b>Colour</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->color }}</td>
                <td width="15%" style="padding:5px;"><b>Odour</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->odour }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Risks</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;justify-content: space-between;" colspan="4">
                    @php
                        $riskdetails = string_to_array($wastecard->risk);
                    @endphp

                    @foreach ($wasterisklist as $wasterisk)
                    @if (in_array($wasterisk->id, $riskdetails))
                    ✔
                @else
                <span style="font-size: 14px">&#8226;</span>
                @endif
                        {{-- <input type="checkbox" name="risk[]"
                            id="risk_{{ encryptId($wasterisk->id) }}"
                            value="{{ encryptId($wasterisk->id) }}"
                            {!! in_array($wasterisk->id, $riskdetails) ? 'checked="checked" disabled="disabled"' : '' !!}> --}}
                        <label for="risk_{{ encryptId($wasterisk->id) }}">{{ $wasterisk->item_name }}</label>
                    @endforeach
                </td>
            </tr>

        </table>


        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        B. HANDLING OF WASTE
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>PPE</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;justify-content: space-between;" colspan="4" >
                    @php
                        $ppedetails = string_to_array($wastecard->ppe);
                    @endphp
                    @foreach ($wasteppelist as $wasteppe)
                    @if (in_array($wasteppe->id, $ppedetails))
                    ✔
                @else
                <span style="font-size: 14px">&#8226;</span>
                @endif
                            {{-- <input type="checkbox" name="ppe[]"
                                id="ppe_{{ encryptId($wasteppe->id) }}"
                                value="{{ encryptId($wasteppe->id) }}"
                                {!! in_array($wasteppe->id, $ppedetails) ? 'checked="checked" disabled="disabled"' : '' !!}>--}}
                            <label
                                for="ppe_{{ encryptId($wasteppe->id) }}">{{ $wasteppe->item_name }}</label>
                    @endforeach
                    </td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Packaging Type</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ getpackageName($wastecard->packaging_type) }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Grouping System
                </b></td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>i) No. of
                    Grouping on Pallet</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $wastecard->grouping_on_pallet }}</td>

                <td width="15%" style="padding:5px;"><b>ii) No. Stacking
                    Allowed</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $wastecard->stacking_allowed }}</td>
            </tr>

            <tr>
                <td width="15%" style="padding:5px;"><b>Pictogram
                    for Labelling</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{  $wastecard->pictogram_for_labelling }}</td>

                <td width="15%" style="padding:5px;"><b>Recommended Method of Disposal</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ getItemName($wastecard->recommended_method_of_disposal) }}</td>
            </tr>
        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        C. PRECAUTIONS IN CASE OF SPILL OR ACCIDENTAL DISCHARGE CAUSING PERSONAL INJURY
                    </td>
                </tr>
            </tbody>
        </table>
                @php
                    $precautionsdetails = json_decode($wastecard->precautions);
                @endphp
                <table class="table table-bordered table-striped activity">
                    <thead>
                        <tr>
                            <th>Risk</th>
                            <th>Symptoms of Intoxication</th>
                            <th>First Aid</th>
                            <th>Guidelines for the Physician</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($precautionsdetails as $precaution)
                            <tr>
                                <td> {{ getItemName(decryptId($precaution->risk)) }}</td>
                                <td>{{ $precaution->symptoms }}</td>
                                <td>{{ $precaution->firstaid }}</td>
                                <td>{{ $precaution->guidephy }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>

                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                                D. STEPS TO BE TAKEN IN CASE OF SPILL OR ACCIDENTAL DISCHARGE CAUSING MATERIAL DAMAGES ARISING FROM:
                            </td>
                        </tr>
                    </tbody>
                </table>
                        @php
                            $materialdamages = json_decode($wastecard->material_damages);
                        @endphp
                        <table class="table table-bordered table-striped activity" >
                            <thead>
                                <tr>
                                    <th>Spill on the Floor, Soil, Road, Water</th>
                                    <th>Fire</th>
                                    <th>Explosion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialdamages as $materialdamage)
                                    <tr>
                                        <td>{{ $materialdamage->spill }}</td>
                                        <td>{{ $materialdamage->fire }}</td>
                                        <td>{{ $materialdamage->explosion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


    </div>
</body>

</html>
