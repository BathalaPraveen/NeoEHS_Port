@php
    $logo = '<img src="' . url('public/assets/images/common/Logo.png') . '" style="width:30%;">';

@endphp

<html>

<head>
    <style>
        @page {
            size: auto;
            /* margin-header: 0mm; */
            /* margin-footer: 3mm; */
            odd-header-name: html_myHeader1;
            even-header-name: html_myHeader2;
            odd-footer-name: html_myFooter1;
            even-footer-name: html_myFooter2;
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

        body {

            font-size: 13px
        }

        table {
            border-collapse: collapse;

        }
    </style>

</head>

<body>
    <htmlpageheader name="myHeader1" style="display:block;">
        <table border="0" style="width:100%;border:0;border-bottom: 4px solid #000;background-color: #FFF;">
            <tr style="">
                <td border="0" style="width:50%;float:left;text-align:left;">{!! $logo !!}</td>
                <td border="0"
                    style="width:50%;float:right;text-align:right;font-size: 24px;font-weight:bold;font-family: Georgia, serif;">
                    {{ $pagetitle }}
                </td>
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
        <table class="table" style="width:100%;border: 0.5px solid;">
            <thead>
                <tr style="background-color: #f2f2f2;">


                    @foreach ($header as $key => $value)
                        <td style='padding: 7px;border: 0.5px solid;font-weight:bold;text-align:center;'>
                            {{ $value }}
                        </td>
                    @endforeach
                </tr>
            </thead>

            <tbody>

                @php
                    $i = 1;
                @endphp

                @foreach ($content as $key => $value)
                    <tr>
                        <td style='padding: 7px;border: 0.5px solid;text-align:center'>
                            {{ $i }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_id }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            @if ($value->emp_gender == 1)
                                Male
                            @else
                                Female
                            @endif
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            @if ($value->nationality != 1)
                                {{ $value->nationality }}
                            @else
                                Others
                            @endif

                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_nationality_other }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_ic_or_passport_no }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ Displaydateformat($value->emp_joining_date) }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_email_id }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->emp_phone_no }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->company_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->division_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->department_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->location_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->specific_loc_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->designation_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ $value->role_name }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            {{ Displaydateformat($value->created_at) }}
                        </td>
                        <td style='padding: 7px;border: 0.5px solid'>
                            @php
                                $status = ($value->status == 1)? "Active" : "Inactive" ;
                            @endphp
                            {{   $status  }}
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>
    </div>
</body>

</html>
