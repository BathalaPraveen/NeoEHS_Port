@php
    $logo =
        '<img src="' .
        url('public/assets/theme/img/logo.png') .
        '" style="width:15%;">
';

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

        .table-border td {
            border: 0.5px solid;
            border-collapse: collapse;
        }

        .table-border th {
            border: 0.5px solid;
            border-collapse: collapse;
        }

        .table-border td,
        .table-border th{
            border:0.5px solid #000;
            padding:5px;
        }

        .table-border td{
            vertical-align:top;
        }
    </style>
</head>

<body>

    <htmlpageheader name="myHeader1" style="display:block">
        <table border="0" style="width:100%;border:0;background-color: #d9e2f3;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0" style="width:20%;float:left;text-align:left;background-color: #d9e2f3">
                    {!! $logo !!}</td>
                <td style="font-weight:bold;font-size:22px;background-color: #d9e2f3">
                    <div>NeoEHS PORT</div>
                    <div>{{ $securitydata->unique_id }} </div>
                </td>
            </tr>
        </table>
        <table border="0" style="width:100%;border:0;border-top: 4px solid #84b5ec;border-style: double;">
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

    @php
        $user = getuser($securitydata->created_by);
    @endphp

    <div style="width:100%;">
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                  Report Datas
                </td>
            </tr>
        </table>
        <table width="100%" class="table-border" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="20%" style="padding:5px;"><b>PSS ID</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ $securitydata->unique_id }}</td>
                <td width="20%" style="padding:5px;"><b>ID Type</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ getIdType($securitydata->id_type) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>IC/Passport No</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $securitydata->passport_number }}</td>
                <td width="20%" style="padding:5px;"><b>Designation Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ getDesignationName($securitydata->designation_id) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Induction Date</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ displayDateformat($securitydata->induction_date) }}</td>
                <td width="20%" style="padding:5px;"><b>Induction Due Date</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ displayDateformat($securitydata->induction_duedate)}}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Company Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ getCompanyName($securitydata->company_id) }}</td>
                <td width="20%" style="padding:5px;"><b>Location Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ getLocationName($securitydata->location_id) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Vehicle Type</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ !empty($securitydata->vehicle_type) ? getVehicleType($securitydata->vehicle_type) : '-' }}</td>
                <td width="20%" style="padding:5px;"><b>Vehicle Number</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ !empty($securitydata->vehicle_number) ? $securitydata->vehicle_number : '-' }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Purpose</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;" colspan="4">   {{ !empty($securitydata->purpose) ? $securitydata->purpose : '-' }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Vehicle Entry Date</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ !empty($securitydata->vehicle_entry_date) ? displayDateformat($securitydata->vehicle_entry_date) : '-' }}</td>
                <td width="20%" style="padding:5px;"><b>Vehicle Entry Time</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ !empty($securitydata->vehicle_entry_time) ? Displaytimeformat($securitydata->vehicle_entry_time) : '-' }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Vehicle Exit Date</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ !empty($securitydata->vehicle_exit_date) ? displayDateformat($securitydata->vehicle_exit_date) : '-' }}</td>
                <td width="20%" style="padding:5px;"><b>Vehicle Exit Time</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ !empty($securitydata->vehicle_exit_time) ? Displaytimeformat($securitydata->vehicle_exit_time) : '-' }}</td>
            </tr>
        </table>
        <br />
        @if (!empty($certifiactedata) && count($certifiactedata) > 0)
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                  Other Competency Details
                </td>
            </tr>
        </table>

         <table width="100%" class="table-border" style="width:100%;">
            <thead>
                <tr style="background:#f1f1f1;">
                    <th width="25%" style="padding:5px;">Competency Certificate Name</th>
                    <th width="15%" style="padding:5px;">Start Date</th>
                    <th width="15%" style="padding:5px;">End Date</th>
                    <th width="45%" style="padding:5px;">Competency Certificate</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($certifiactedata as $certificate)

                    @php
                        $ext = strtolower(pathinfo('public/'.$certificate->cert_path, PATHINFO_EXTENSION));
                    @endphp

                    <tr>
                        <td style="padding:5px; vertical-align:top;">
                            {{ $certificate->cert_name ?? '-' }}
                        </td>

                        <td style="padding:5px; vertical-align:top; text-align:center;">
                            {{ Displaydateformat($certificate->cert_start_date) ?? '-' }}
                        </td>

                        <td style="padding:5px; vertical-align:top; text-align:center;">
                            {{ Displaydateformat($certificate->cert_end_date) ?? '-' }}
                        </td>

                        <td style="padding:5px; text-align:center; vertical-align:middle;">

                            @if ($ext == 'pdf')

                                <a href="{{ asset('public/'.$certificate->cert_path) }}">
                                    View PDF
                                </a>

                            @else

                                <img src="{{ asset('public/'.$certificate->cert_path) }}"
                                    style="width:250px; height:auto; border:1px solid #ccc;" />

                            @endif

                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        @endif
        <br>
    </div>
</body>

</html>
