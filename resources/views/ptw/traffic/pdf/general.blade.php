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

        tr {
            border: 0.5px solid
        }
    </style>
</head>

<body>

    <htmlpageheader name="myHeader1" style="display:block">
        <table border="0" style="width:100%;border:0;background-color: #FFF;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0" style="width:50%;float:left;">{!! $logo !!}</td>
                <td border="0"
                    style=" width:50%;float:right;text-align:right;font-size: 24px;font-weight: bold;font-family: Georgia, serif;">
                    {{ $pagetitle }}
                </td>
            </tr>
        </table>
    </htmlpageheader>


    <htmlpagefooter name="myFooter1" style="display:none">
        <table width="100%"
            style="width:100%;border:0;background-color: #FFF;border-top: 2px solid #000;padding-top:10px;padding-bottom:10px;">
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
                    General permit to work
                </td>
            </tr>
        </table>
        <br />
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    APPLICATION
                </td>
            </tr>
        </table>

        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="20%" style="padding:5px;"><b>Permit No</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $general->ptw_id }}</td>
                <td width="20%" style="padding:5px;"><b>Area of Work</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"></td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Location</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $general->location }}</td>
                <td width="20%" style="padding:5px;"><b>Applicant Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ getUsername($general->created_by) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Contact Number</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $general->contactnumber }}</td>
                <td width="20%" style="padding:5px;"><b>Date of Application</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">
                    {{ displayDateformat($general->date_of_application) }}
                </td>
            </tr>

            <tr>
                <td width="20%" style="padding:5px;"><b>Date of Commencement </b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ displayDateformat($general->date_of_commencement) }}</td>
                <td width="20%" style="padding:5px;"><b>Date of Completion</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ displayDateformat($general->date_of_completion) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Job Hazard Analysis</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="75%" style="padding:5px;" colspan="4"> {{ $general->job_hazard_analysis }}</td>

            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Work Description</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="75%" style="padding:5px;" colspan="4">{{ $general->work_description }}</td>

            </tr>
        </table>
        <br />
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    HAZARDOUS ACTIVITY / HAZARD
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            @php

                $hazardData = json_decode($general->hazard);

                if ($hazardData == '' || $hazardData == null) {
                    $hazardData = new stdClass();
                    $hazardData->hazard = [];
                    $hazardData->hazard_others_text = '';
                }

                $i = 1;
            @endphp
            <tr>
                @foreach ($hazardDetails as $hazard)
                    <td width="23%" style="padding:5px;padding-left:10px"><span style="padding-left: 10px;">
                            @if (in_array($hazard->id, $hazardData?->hazard))
                                ✔
                            @else
                            <span style="font-size: 14px">&#8226;</span>
                            @endif
                            {{ $hazard->category_name }}
                        </span></td>

                    @if ($i % 4 == 0)
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
                        SUPPORTING CERTIFICATE / DOCUMENT </td>
                </tr>
            </tbody>
        </table>

        <table style="width:100%;border: 0.5px solid">
            @php

                $documentData = json_decode($general->supporting_documents);

                if ($documentData == '' || $documentData == null) {
                    $documentData = new stdClass();
                    $documentData->supportcertificate = [];
                    $documentData->supportcertificate_data = '';
                }

                $i = 1;
            @endphp
            <tr>
                @foreach ($supportCertificate as $certificate)
                    <td width="23%" style="padding:5px;padding-left:10px">
                        <span style="padding-left: 10px;">
                            @if (in_array($certificate->id, $documentData?->supportcertificate))
                                ✔
                            @else
                            <span style="font-size: 14px">&#8226;</span>
                            @endif

                            {{ $certificate->category_name }}
                        </span>
                        @php
                            $col_name = $certificate->id;
                        @endphp
                        @if ($certificate->input_type == 1)
                            @if (in_array($certificate->id, $documentData->supportcertificate))
                                <div class="font-weight-bold">
                                    {{ $documentData->supportcertificate_data->$col_name }}
                                </div>
                            @endif
                        @else
                            @if (isset($supportCertificateFile[$certificate->id]))
                                <div>
                                    <a href="{{ url($supportCertificateFile[$certificate->id]['file_path']) }}"
                                        onclick="window.open(this.href); return false;"
                                        target="_blank">{{ $supportCertificateFile[$certificate->id]['file_orgname'] }}</a>
                                </div>
                            @endif
                        @endif
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
        </table>
        <br>

        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    PERSONAL PROTECTIVE EQUIPMENT
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            @php

                $equipmentData = json_decode($general->equipment_details);

                if ($equipmentData == '' || $equipmentData == null) {
                    $equipmentData = new stdClass();
                    $equipmentData->equipments = [];
                    $equipmentData->equipments_others_text = '';
                }

                $i = 1;
            @endphp

            @foreach ($protectiveEquipment as $equipment)
                <tr>
                    <td style="padding-left: 10px;" colspan="4"> <u>{{ $equipment->category_name }}</u> </td>
                </tr>
                <tr>

                    @if (isset($protectiveEquipmentItems[$equipment->id]))
                        @foreach ($protectiveEquipmentItems[$equipment->id] as $euipmentItems)
                            <td width="23%" style="padding:5px;padding-left:10px"><span
                                    style="padding-left: 10px;">
                                    @if (in_array($euipmentItems['id'], $equipmentData->equipments))
                                        ✔
                                    @else
                                        <span style="font-size:16px;">&#x2022;</span>
                                    @endif
                                    {{ $euipmentItems['item_name'] }}
                                </span>
                            </td>

                            @if ($i % 4 == 0)
                </tr>
                <tr>
            @endif

            @php
                $i++;
            @endphp
            @endforeach
            @endif
            @endforeach
            </tr>

        </table>
        <br>

        <table style="width:100%;">
            <tbody>
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        WORK SITE PREPARATION / PRECAUTIONS </td>
                </tr>
            </tbody>
        </table>

        <table style="width:100%;border: 0.5px solid">
            @php

                $siteData = json_decode($general->site_preparation);

                if ($siteData == '' || $siteData == null) {
                    $siteData = new stdClass();
                    $siteData->sitepreparation = [];
                    $siteData->sitepreparation_others_text = '';
                }
                $i = 1;
            @endphp
            <tr>
                @foreach ($sitePreparationDetails as $sitePreparation)
                    <td width="23%" style="padding:5px;padding-left:10px"><span style="padding-left: 10px;">
                            @if (in_array($sitePreparation->id, $siteData->sitepreparation))
                                ✔
                            @else
                            <span style="font-size: 14px">&#8226;</span>
                            @endif
                            {{ $sitePreparation->category_name }}
                        </span></td>

                    @if ($i % 4 == 0)
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
                        PERMIT ISSUANCE </td>
                </tr>
            </tbody>
        </table>


        <table style="width:100%;border: 0.5px solid">

            <tr>
                <td width="100%" colspan="6" style="padding-left: 10px">
                    <b style="padding-left: 10px"> ✔ fully
                        understand </b>& will <b>ensure compliance</b> with all the
                    requirements of this permit.
                </td>
            </tr>

            <tr>
                <td width="20%" style="padding: 10px;"><b style="padding-left:10px">Name</b> </td>
                <td width="2%">:</td>
                <td width="20%">{{ getUsername($general->created_by) }}</td>
                <td width="20%"><b style="padding-left:10px">Date & Time</b></td>
                <td width="2%">:</td>
                <td width="20%">{{ displayDatetimeformat($general->created_at) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding: 10px;"><b style="padding-left:10px">Remarks</b></td>
                <td width="2%">:</td>
                <td width="75%" colspan="4">{{ $general->application_remarks }}</td>
            </tr>
        </table>
        <br>


        @if ($general->ptw_status > 1)

            <table style="width:100%;">
                <tr>
                    <td style="width:100%;background-color: #FFFF00;color:#000;font-weight:bold;padding: 5px 5px 5px;">
                        Approvals
                    </td>
                </tr>
            </table><br />
            @foreach ($generalpermitStatusLog as $statusLog)
                <table width="100%" style="width:100%;border: 0.5px solid">
                    <tr>
                        <td
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            Status - {!! permitStatusText($statusLog->to_status) !!}
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


        @php
            $pagename = 'ptw.pdf.trafficmanagementcertificate' ;
        @endphp
        @include($pagename)


    </div>
</body>

</html>
