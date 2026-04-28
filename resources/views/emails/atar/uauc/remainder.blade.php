@extends('emails.layouts.email')

@php
    $userInfo = getUser($details['created_by']);
@endphp

@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">

                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                   Remainder of UAUC Notification - {{ $details['atar_id'] }} <br>
                </p>

                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                    This UAUC has been Initiated {{$details['weeks']}} Weeks Before Please Take Action !.<br>
                 </p>
 

                <table role="presentation" border="1" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                    width="100%">
                    <tbody style="font-family:Nakheel Headline">

                        <tr>
                            <td colspan="6" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align:center;background-color:#0053A1;color:#ffffff; "
                                valign="top">
                                General Information
                            </td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Reported By:</b>
                            </td>
                            <td colspan="2"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ getusername($details['created_by']) }}
                            </td>

                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Division:</b>
                            </td>
                            <td colspan="2"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ $userInfo->divisionInfo->division_name }}</td>

                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Company:</b>
                            </td>
                            <td colspan="2"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ $userInfo->companyInfo->company_name }}</td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Department</b>
                            </td>
                            <td colspan="2"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ $userInfo->departmentInfo->department_name }}</td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Email ID:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ getUseremail($details['created_by']) }}
                            </td>

                        </tr>

                        <tr>
                            <td colspan="6" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align:center;background-color:#0053A1;color:#ffffff "
                                valign="top">
                                UAUC Information
                            </td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Date:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ displayDatetimeformat($details['created_at']) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Location:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ $details['location_name'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Specific Location:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">


                                @if ($details['specific_loc_name'] != '')
                                    {{ $details['specific_loc_name'] }}
                                @else
                                   Others - {{ $details['other_speclocation'] }}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Job Owner:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                @if ($details['job_owner'] != '')
                                    {{ getusername($details['job_owner']) }}
                                @else
                                    N/A
                                @endif

                            </td>
                        

                    </tbody>
                </table>
            </td>
        </tr>
    </table>
@stop
