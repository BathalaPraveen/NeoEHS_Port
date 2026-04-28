@extends('emails.layouts.email')
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">

                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                    New PTW created<br>
                </p>

                <table role="presentation" border="1" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                    width="100%">
                    <tbody style="font-family:Nakheel Headline">
                        <tr>
                            <td colspan="6" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color:yellow "
                                valign="top">
                                <u>General PTW - {{ $details['sub_permit_id'] }} </u>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align:center;background-color:#0053A1;color:#ffffff; "
                                valign="top">
                                General Information
                            </td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Applied By:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ getusername($details['created_by']) }}
                            </td>

                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Applied Date:</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ displayDatetimeformat($details['created_at']) }}</td>
                            </td>

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
                                PTW Details
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
                                {{ getLocationName($details['location']) }}</td>
                        </tr>

                    
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Work start Date</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{displayDateformat ($details['workstartdate']) }}</td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Work End Date</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{displayDateformat ($details['workenddate']) }}</td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Work Description</b>
                            </td>
                            <td colspan="5"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-transform: uppercase;"
                                valign="top">
                                {{ $details['workdescription'] }}</td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </table>
@stop
