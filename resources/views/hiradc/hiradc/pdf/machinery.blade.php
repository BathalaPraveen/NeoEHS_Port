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
                    General Information
                </td>
            </tr>
        </table>
        <br />

        <table width="100%" style="width:100%;border: 0.5px solid">

            <tr>
                <td colspan="6" style="padding:1rem">
                    <p>I hereby to confirm that the information below is true and agree to perform
                        as follows :</p>
                    <ol class="p-2 mx-3">
                        <li>
                            Bound by the provisions in the Occupational Safety and Health Act 1994,
                            Factories and Machinery Act 1967, Bintulu Port Group Company Safety
                            Policy, other relevant government legislation and regulations.
                        </li>
                        <li>
                            All losses of Bintulu Port Group Company must be borne in full for all
                            claims, requests, legal actions, proceedings, orders, costs, losses and
                            expenses in any form that Bintulu Port Group Holdings Berhad may
                            experience or incur in connection with our use of the equipment
                            mentioned in Bintulu Port.
                        </li>
                        <li>
                            Comply with all the requirement and regulations that have been set.
                        </li>
                        <li>
                            If the contractor/ port user is found not to comply with the Bintulu
                            Port Holdings Berhad Group's safety policy, the Group Safety, Health and
                            Environment Division has the right to withdraw the approved Machinery
                            Tag at any time.
                        </li>
                        <li>
                            This notification is valid for the specific operation as presented and
                            is not transferable.
                        </li>
                        <li>
                            Submit all relevant documents as requested.
                        </li>
                    </ol>
                </td>
            </tr>


            <tr>
                <td width="15%" style="padding:5px;"><b>Applicant Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->name }}</td>
                <td width="15%" style="padding:5px;"><b>Email</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->email }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>Company</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->companyInfo->company_name }}</td>
                <td width="15%" style="padding:5px;"><b>Division</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $userInfo->divisionInfo->division_name }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>Department</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $userInfo->departmentInfo->department_name }}</td>
                <td width="15%" style="padding:5px;"><b>Date & Time</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ displayDatetimeformat($machineryDetails->created_at) }}</td>
            </tr>

        </table>
        <br />
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    Location Details
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>Location</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $machineryDetails->location_name }}</td>
                <td width="15%" style="padding:5px;"><b>Specific Location</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $machineryDetails->specific_loc_name }}</td>
            </tr>

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        MACHINERY LOCATION OF USE
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>Area</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $machineryDetails->area }}</td>
                <td width="15%" style="padding:5px;"><b>Vessel name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $machineryDetails->vessel_name }}</td>
            </tr>

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        TYPE OF MACHINERY
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="25%" style="padding:5px;"><b>TYPE OF MACHINERY</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td style="padding:5px;">{{ $machineryDetails->machinery_type_name }}</td>

            </tr>

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        PARTICULARS OF MACHINERY
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($partucularmachineryDetails as $particularmachinery)
                    @php

                        $particularmachineryArray = json_decode($machineryDetails->particularmachinery);

                        $id = $particularmachinery->id;

                        if ($particularmachinery->input_type == 'date') {
                            $value = $particularmachineryArray->$id != null ? displayDateformat($particularmachineryArray->$id) : '';
                        } else {
                            $value = $particularmachineryArray->$id;
                        }
                    @endphp

                    <td width="25%" style="padding:5px;"><b>{{ $particularmachinery->particulars_name }}</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td style="padding:5px;">{{ $value }}</td>

                    @if ($i % 2 == 0)
            </tr>
            <tr>
                @endif


                @php
                    $i++;
                @endphp
                @endforeach

            </tr>

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        SUPPORTING DOCUMENTS
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($supportingdocumentsDetails as $supportdocument)
                    @php

                        $particularmachineryArray = json_decode($machineryDetails->particularmachinery);

                        $id = $particularmachinery->id;

                        if ($particularmachinery->input_type == 'date') {
                            $value = $particularmachineryArray->$id != null ? displayDateformat($particularmachineryArray->$id) : '';
                        } else {
                            $value = $particularmachineryArray->$id;
                        }
                    @endphp

                    <td width="25%" style="padding:5px;"><b>{{ $supportdocument->document_name }}</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td style="padding:5px;">
                        @if (isset($supportDocDetails[$supportdocument->id]))
                            <a href="{{ url($supportDocDetails[$supportdocument->id]['file_path']) }}" download=""
                                target="_blank">
                                {{ $supportDocDetails[$supportdocument->id]['file_orgname'] }}
                            </a>
                        @endif
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

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        PURPOSE OF MACHINERY BEING USE
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="25%" style="padding:5px;"><b>PURPOSE OF USE</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td style="padding:5px;"> {{ $machineryDetails->purposeofuse }}</td>

            </tr>

        </table>

        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        MACHINERY INSPECTOR FROM GROUP HEALTH, SAFETY AND ENVIRONMENT DEPARTMENT
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="15%" style="padding:5px;"><b>Propose date of inspection</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ displayDateformat($machineryDetails->inspectiondate) }}
                </td>
                <td width="15%" style="padding:5px;"><b>Propose time of inspection</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $machineryDetails->inspectiontime }}</td>

            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>Propose location of inspection</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $machineryDetails->purposelocationofinspection }}</td>

            </tr>

        </table>


        @if ($machineryDetails->machinery_tag != null)
            <br>

            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            Inspection Details
                        </td>
                    </tr>
                </tbody>
            </table>
            <table width="100%" style="width:100%;border: 0.5px solid">
                <tr>
                    <td width="15%" style="padding:5px;"><b>Machinery Tag</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="30%" style="padding:5px;">
                        {{ $machineryDetails->machinery_tag }}
                    </td>
                    <td width="15%" style="padding:5px;"><b>Checklist</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="30%" style="padding:5px;">
                        @if ($machineryDetails->inspection_checklist != null)
                            <a href="{{ url($inspectionFiles[$machineryDetails->inspection_checklist]['file_path']) }}"
                                target="_blank">
                                {{ $inspectionFiles[$machineryDetails->inspection_checklist]['file_orgname'] }}
                            </a>
                        @endif
                    </td>

                </tr>
                <tr>
                    <td width="15%" style="padding:5px;"><b>Expired</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="30%" style="padding:5px;">
                        {{ displayDateformat($machineryDetails->expiry_date) }}
                    </td>

                </tr>

            </table>
        @endif

        <br>

        @if (count($statuslogs) > 0)
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            APPROVAL
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table mb-0 table-borderless" width="100%" style="width:100%;border: 0.5px solid">
                <tbody>
                    @foreach ($statuslogs as $statusLog)
                        <tr style="background-color: #aaa">
                            <td colspan="6" style="font-weight:500;"> Status -
                                {!! machhineryStatus($statusLog->to_status) !!} </td>
                        </tr>
                        <tr>
                            <th style="width: 10%">Name</th>
                            <td style="width: 5%">:</td>
                            <td style="width: 30%">
                                {{ getusername($statusLog->approved_by) }}</td>
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
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</body>

</html>
