@extends('emails.layouts.email')
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0"
        style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                    Dear {{ $details['emp_name'] }},</p>
                <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
                    Login credential has been changed for you to access Bintulu Port EHS application by NeoEHS team. <br>
                </p>

                <table role="presentation" border="1" cellpadding="0" cellspacing="0"
                    style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;"
                    width="100%">
                    <tbody style="font-family:Nakheel Headline">
                        <tr>
                            <td colspan="4" align="center"
                                style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Employee Details</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">Find your new credentials below,</td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Employee ID</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top"> {{ $details['emp_id'] }}</td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Company Name</b>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                {{ getCompanyName($details['emp_company_id']) }}
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Division</b>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                {{ getDivisionName($details['emp_division_id']) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Department</b>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                {{ getDepartmentName($details['emp_department_id']) }}</td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Designation</b>
                            </td>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                {{ getDesignationName($details['emp_designation_id'])}}
                            </td>
                        </tr>


                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>URL</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top"> {{ admin_url('login') }}</td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>User Name</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top">{{ $details['emp_id']  }}</td>
                        </tr>
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                                <b>Password</b>
                            </td>
                            <td colspan="3" style="font-family: sans-serif; font-size: 14px; vertical-align: top;"
                                valign="top"> {{ $details['emp_id']  }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
@stop
