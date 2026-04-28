@php
    $logo ='<img src="' .url('public/assets/images/Logo-Mini.png') .'" style="width:15%;">';
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
            ;
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
        <table border="0" style="width:100%;border:0;background-color: #d9e2f3;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td border="0" style="width:20%;float:left;text-align:left;background-color: #d9e2f3">
                    {!! $logo !!}</td>
                <td style="font-weight:bold;font-size:22px;background-color: #d9e2f3">
                    <div>BINTULU PORT HOLDINGS BERHAD</div>
                    <div>UNSAFE ACT & UNSAFE CONDITION REPORT</div>
                    <div>{{ $uauc->atar_id }}</div>
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
            style="width:100%;border:0;background-color: #0272b4;border-top: 4px solid #84b5ec;border-style: double;padding-top:10px;padding-bottom:10px;">
            <tr>
                <td width="33%">
                    {{-- <span style="font-style: italic;">{DATE d-m-Y}</span> --}}
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
                <td
                    style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    GENERAL INFORMATION
                </td>
            </tr>
        </table>
        <br />

        <table width="100%" style="width:100%;">
            <tr>
                <td width="15%" style="padding:5px;"><b>REPORTER NAME</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->name }}</td>
                <td width="15%" style="padding:5px;"><b>DIVISION</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $userInfo->divisionInfo->division_name }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>COMPANY</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->companyInfo->company_name }}</td>
                <td width="15%" style="padding:5px;"><b>DEPARTMENT</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;"> {{ $userInfo->departmentInfo->department_name }}</td>
            </tr>
            <tr>
                <td width="15%" style="padding:5px;"><b>EMAIL</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="30%" style="padding:5px;">{{ $userInfo->email }}</td>


            </tr>

        </table>
        <br />
        <table style="width:100%;vertical-align:top;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    UAUC INFORMATION
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;vertical-align:top">

            <tr>
                <td width="24%" style="padding:5px;"><b>DATE</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;">{{ displayDateformat($uauc->dateandtime) }}</td>
            </tr>
            <tr>
                <td width="24%" style="padding:5px;"><b>LOCATION</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;">{{ $uauc->location_name }}</td>
            </tr>
            <tr>
                <td width="24%" style="padding:5px;"><b>SPECIFIC LOCATION</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;">
                    @if ($uauc->specific_loc_name == '')
                        Others
                    @else
                        {{ $uauc->specific_loc_name }}
                    @endif
                </td>
            </tr>
            @if ($uauc->specific_loc_name == '')
                <tr>
                    <td width="24%" style="padding:5px;"><b>OTHER LOCATION</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="74%" style="padding:5px;">{{ $uauc->other_speclocation }}</td>
                </tr>
            @endif

            <tr>
                <td width="24%" style="padding:5px;"><b>UAUC CATEGORY</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;"> {{ $uauc->atar_type }}</td>
            </tr>
            <tr>
                <td width="24%" style="padding:5px;"><b>HAZARDS / HSE ISSUES</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;">{{ strtoupper($uauc->hse_hazard) }} / {{ strtoupper($uauc->hover_msg) }}</td>
            </tr>
            <tr>
                <td width="24%" style="padding:5px;"><b>DESCRIBE WHAT YOU SEE</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="74%" style="padding:5px;">{{ $uauc->usee_remarks }}</td>
            </tr>
            @if (count($uactfiles) > 0)
                <tr>
                    <td width="24%" style="padding:5px;"><b>PHOTO(S)</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="74%" style="padding:5px;">

                        <div class="row">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        @foreach ($uactfiles as $uact)
                                            <td style="%;border:1px solid #ccc">
                                                <img style="width:20%" class="" src="{{ $uact->file_path }}"
                                                    alt="" />
                                            </td>
                                        @endforeach
                                        @if (count($uactfiles) == 1)
                                            <td colspan="2"></td>
                                        @else
                                            @if (count($uactfiles) == 2)
                                                <td colspan="1"></td>
                                            @endif
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endif

        </table>

        <br>

        @if (!in_array($uauc->uauc_category, [1, 2]))
            <table style="width:100%;">
                <tbody>
                    <tr>
                        <td
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            CORRECTIVE ACTION
                        </td>
                    </tr>
                </tbody>
            </table>

            <table width="100%" style="width:100%; vertical-align:top">
                <tr>
                    <td width="24%" style="padding:5px;"><b>ACTION TAKEN</b></td>
                    <td width="2%" style="padding:5px;">:</td>
                    <td width="74%" style="padding:5px;">{{ strtoupper($uauc->action_taken_details) }}</td>
                </tr>
                @if (!in_array($uauc->action_taken, [2]))
                    <tr>
                        <td width="24%" style="padding:5px;"><b>DESCRIPTION</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="74%" style="padding:5px;">{{ $uauc->uact_remarks }}</td>
                    </tr>
                @endif


                @if (!in_array($uauc->action_taken, [2]))
                    <tr>
                        <td colspan="6"
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            RESPONSIBILITY
                        </td>
                    </tr>

                    <tr>
                        <td width="24%" style="padding:5px;"><b>COMPANY</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="74%" style="padding:5px;">{{ $uauc->company_name }}</td>
                    </tr>
                    <tr>
                        <td width="24%" style="padding:5px;"><b>DIVISION</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="74%" style="padding:5px;">{{ $uauc->division_name }}</td>
                    </tr>
                    <tr>
                        <td width="24%" style="padding:5px;"><b>DEPARTMENT</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="74%" style="padding:5px;">{{ $uauc->department_name }}</td>
                    </tr>
                    <tr>
                        <td width="24%" style="padding:5px;"><b>JOB OWNER</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="74%" style="padding:5px;">{{ getusername($uauc->job_owner) }}</td>
                    </tr>

                    @if ($uauc->action_taken == 3)
                        <tr>
                            <td width="24%" style="padding:5px;"><b>VIOLATORS EMAIL</b></td>
                            <td width="2%" style="padding:5px;">:</td>
                            <td width="74%" style="padding:5px;">{{ $uauc->violators_email }}</td>
                        </tr>
                        <tr>
                            <td width="24%" style="padding:5px;"><b>INFRINGEMENT</b></td>
                            <td width="2%" style="padding:5px;">:</td>
                            <td width="74%" style="padding:5px;">{{ $uauc->infringement_no }} -
                                {{ $uauc->type_of_infringement }}</td>
                        </tr>
                        <tr>
                            <td width="24%" style="padding:5px;"><b>SSDS SERIAL NUMBER</b></td>
                            <td width="2%" style="padding:5px;">:</td>
                            <td width="74%" style="padding:5px;">{{ $uauc->ssds_serial_number }}</td>
                        </tr>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    @endif
                @endif
            </table>
        @endif

        <table width="100%" style="width:100%;vertical-align: top;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;"
                    colspan="2">
                    CORRECTIVE ACTION STATUS
                </td>
            </tr>
            <tr>
                <td style="width:40%">
                    <table style="width: 100%">
                        <tr>
                            <td>
                                <div class="row mt-3" style="margin-top:1rem;">
                                    <div class="col-md-12">
                                        <table class="table mb-0 " style="width:100%;">
                                            <tbody>
                                                <tr style="background-color: #d9e2f3">
                                                    <td colspan="6" style="font-weight:bold;padding:5px;"> STATUS -
                                                        CREATED
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;padding:5px;">NAME</th>
                                                    <td style="">:</td>
                                                    <td style=";padding:5px;">
                                                        {{ getUser($uauc->created_by)->name }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="  text-align:left;padding:5px;">DESIGNATION
                                                    </th>
                                                    <td style="">:</td>
                                                    <td style="padding:5px;">
                                                        {{ getUser($uauc->created_by)->user_designation_name }}
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="  text-align:left;padding:5px;">DATE</th>
                                                    <td>:</td>
                                                    <td style="padding:5px;">
                                                        {{ displayDateformat($uauc->created_at) }}</td>

                                                </tr>
                                                <tr>
                                                    <th style="text-align:left;padding:5px;">TIME</th>
                                                    <td>:</td>
                                                    <td style="padding:5px;">
                                                        {{ Displaytimeformat($uauc->created_at) }}</td>
                                                </tr>
                                                @foreach ($uauc_status_log as $statusLog)
                                                    <tr style="background-color: #d9e2f3">
                                                        <td colspan="6" style="font-weight:bold;"> STATUS -
                                                            {{ strtoupper($statusLog->statusToInfo->atar_status) }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style=" text-align:left;padding:5px;">NAME</th>
                                                        <td style="">:</td>
                                                        <td style="">{{ $statusLog->userInfo->name }}</td>

                                                    </tr>
                                                    <tr>
                                                        <th style=" text-align:left;padding:5px;">
                                                            DESIGNATION</th>
                                                        <td style="">:</td>
                                                        <td style="">
                                                            {{ $statusLog->userInfo->user_designation_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style=" text-align:left;padding:5px;">DATE</th>
                                                        <td>:</td>
                                                        <td>{{ displayDateformat($statusLog->created_at) }}</td>

                                                    </tr>
                                                    <tr>
                                                        <th style=" text-align:left;padding:5px;">TIME</th>
                                                        <td>:</td>
                                                        <td>{{ Displaytimeformat($statusLog->created_at) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th style=" text-align:left;padding:5px;">REMARKS</th>
                                                        <td>:</td>
                                                        <td colspan="4">{{ $statusLog->status_description }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:60%">
                    @if ($uauc->atar_status_id == 5)
                        @if (count($finalfiles) > 0)

                            <table style="width:100%">
                                <tbody>
                                    <tr style="width: 100%;">
                                        <td
                                            style="width:100%;background-color: #d9e2f3;color:#000;font-weight:bold;padding: 5px 5px 5px; text-align:center">
                                            PHOTO(S)/EVIDENCE OF CORRECTIVE ACTION
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row">
                                <table>
                                    <tbody>

                                        @foreach ($finalfiles as $final)
                                            <tr>
                                                <td style="">
                                                    <img style="" class=""
                                                        src="{{ url($final->file_path) }}" alt="">
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </td>
            </tr>
        </table>

        @if (in_array($uauc->action_taken, [2]))
        <table>
            <tr>
                <td style="width:28%;font-weight:bold;">REMARKS ON CORRECTIVE ACTION STATUS</td>
                <td style="width: 2% ">:</td>
                <td style="width:70%"> {{  $uauc->uact_remarks }}</td>
            </tr>
        </table>
        @endif


    </div>
</body>

</html>
