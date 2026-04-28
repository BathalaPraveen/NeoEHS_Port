@extends('emails.layouts.email')
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">

                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                   New Machinery - {{ $details['machinery_id'] }} <br>
                </p>

                <table role="presentation" border="1" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                    width="100%">
                    <tbody style="font-family:Nakheel Headline">
                        <tr>
                            <td colspan="4" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color:yellow "
                                valign="top">
                                <u>New Machinery Added</u>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top; text-align:center "
                                valign="top">
                                Machinery Details
                            </td>
                        </tr>

                        @php
                            $user = getUser($details['created_by']);
                        @endphp

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Machinery Added By:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $user->name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Email ID:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $user->email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Date:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ displayDatetimeformat($details['created_at']) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Company:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $user->companyInfo->company_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Division:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $user->divisionInfo->division_name }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Department</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $user->departmentInfo->department_name }}
                            </td>
                        </tr>


                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Location:</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $details['location_name'] }}</td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Specific Location</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $details['specific_loc_name'] }}</td>
                        </tr>

                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Machinery Type</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">
                                {{ $details['machinery_type_name'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
@stop
