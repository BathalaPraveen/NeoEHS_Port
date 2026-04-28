@php
    $logo =
        '<img src="' .
        url('public/assets/images/Logo-Mini.png') .
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
                    <div>{{ strtoupper($inspectionDetails->inspectiontype_name) }}</div>
                    <div>{{ $inspectionDetails->inspection_id }} </div>
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
        $user = getuser($inspectionDetails->created_by);
    @endphp

    <div style="width:100%;">
        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    PART A : INSPECTION DETAILS
                </td>
            </tr>
        </table>
        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="20%" style="padding:5px;"><b>Company</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;" colspan="4">
                    {{ getCompanyName($inspectionDetails->company) }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Location</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ $inspectionDetails->location_name }}</td>
                <td width="20%" style="padding:5px;"><b>Specific Location</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ $inspectionDetails->specific_loc_name }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Inspection Type</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ $inspectionDetails->inspectiontype_name }}</td>
                <td width="20%" style="padding:5px;"><b>Inspection Date</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;"> {{ displayDateformat($inspectionDetails->inspection_date) }}
                </td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Inspection Time</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $inspectionDetails->inspection_time }}</td>

            </tr>
        </table>
        <br />

        <table style="width:100%;">
            <tr>
                <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                    PART B: INSPECTION CREATED BY
                </td>
            </tr>
        </table>

        <table width="100%" style="width:100%;border: 0.5px solid">
            <tr>
                <td width="20%" style="padding:5px;"><b>Name</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $user->name }}</td>
                <td width="20%" style="padding:5px;"><b>Designation</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $user->user_designation_name }}</td>
            </tr>
            <tr>
                <td width="20%" style="padding:5px;"><b>Date and Time</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ displayDateTimeformat($inspectionDetails->created_at) }}
                </td>
                <td width="20%" style="padding:5px;"><b>Inspection Remarks</b></td>
                <td width="2%" style="padding:5px;">:</td>
                <td width="25%" style="padding:5px;">{{ $inspectionDetails->inspection_remarks }}</td>
            </tr>
        </table>
        <br>


        @if ($inspectionDetails->inspection_status >= INSPECTION_STATUS_INSPECTION_COMPLETED)
            <table style="width:100%;">
                <tr>
                    <td style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                        PART C: INSPECTION CHECKLIST
                    </td>
                </tr>
            </table>

            @if ($inspectiontypeDetails->id == INSPECTION_TYPE_BOAT)
                <table width="100%" style="width:100%;border: 0.5px solid">
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Inspection Type</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">

                            <div>
                                @if ($inspectionDetails->insp_type == 'Compliance Inspection')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif
                                <label for="insp_type_compliance">Compliance Inspection</label>
                            </div>
                            <div>

                                @if ($inspectionDetails->insp_type == 'Safety Inspection')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif

                                <label for="insp_type_safety">Safety Inspection</label>

                            </div>
                            <div>
                                @if ($inspectionDetails->insp_type == 'Follow-up Inspection')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif
                                <label for="insp_type_followup">Follow-up Inspection</label>
                            </div>
                        </td>
                        <td width="20%" style="padding:5px;"><b>LENGTH (M)</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            <div>
                                @if ($inspectionDetails->vessel_lengh == '< 16')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif
                                <label for="insp_type_compliance">
                                    < 16 </label>
                            </div>
                            <div>
                                @if ($inspectionDetails->vessel_lengh == '16-25')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif

                                <label for="insp_type_safety">16-25</label>
                            </div>
                            <div>
                                @if ($inspectionDetails->vessel_lengh == '26-30')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif
                                <label for="insp_type_followup">26-30</label>
                            </div>
                            <div>
                                @if ($inspectionDetails->vessel_lengh == '>30')
                                    <i style="color: #267709;">✔</i>
                                @else
                                    <i style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></i>
                                @endif
                                <label for="insp_type_followup"> >30 </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>VESSEL NAME</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_name }}</td>
                        <td width="20%" style="padding:5px;"><b>TYPE OF VESSEL </b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"> {{ $inspectionDetails->vessel_type }}</td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>BEAM (M)</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_beam }}</td>
                        <td width="20%" style="padding:5px;"><b>DEPTH (M)</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_depth }}</td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>GROSS TONNAGE</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_gross }}</td>
                        <td width="20%" style="padding:5px;"><b>HULL CONSTRUCTION</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">

                            @if ($inspectionDetails->vessel_hull == 'Other')
                                Other - {{ $inspectionDetails->vessel_hull_other }}
                            @else
                                {{ $inspectionDetails->vessel_hull }}
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>UPERSTRUCTURE CONSTRUCTION</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            @if ($inspectionDetails->vessel_superstructure == 'Other')
                                Other - {{ $inspectionDetails->vessel_superstructure_other }}
                            @else
                                {{ $inspectionDetails->vessel_superstructure }}
                            @endif

                        </td>
                        <td width="20%" style="padding:5px;"><b>PROPULSION</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_propulsion }}</td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>VESSEL OWNER</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            @if ($inspectionDetails->vessel_owner == 'Other')
                                Other - {{ $inspectionDetails->vessel_owner_other }}
                            @else
                                {{ $inspectionDetails->vessel_owner }}
                            @endif
                        </td>
                        <td width="20%" style="padding:5px;"><b>VESSEL OPERATOR</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            @if ($inspectionDetails->vessel_operator == 'Other')
                                Other - {{ $inspectionDetails->vessel_operator_other }}
                            @else
                                {{ $inspectionDetails->vessel_operator }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>IMO/REGISTRATION NO</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_imo_registration }}
                        </td>
                        <td width="20%" style="padding:5px;"><b></b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"></td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>FLAG</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_flag }}</td>
                        <td width="20%" style="padding:5px;"><b>PORT OF REGISTRY</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_port_of_registry }}
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>CLASSIFICATION SOCIETY OR CLASS</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_classification }}</td>
                        <td width="20%" style="padding:5px;"><b>TOTAL No. OF PERSON ONBOARD</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspectionDetails->vessel_total_person }}</td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>MSD Representative</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            {{ getusername($inspectionDetails->msd_representative) }}
                        </td>

                    </tr>
                </table>
            @endif

            @if ($inspectiontypeDetails->id == INSPECTION_JETTY_AUDIT)
                @php
                    $jettydetails = getJettyLocation($inspectionDetails->jetty_location);
                @endphp
                <table width="100%" style="width:100%;border: 0.5px solid;">
                    <tr>
                        <td width="20%" style="padding:5px;"><b>TSD Representative</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">
                            {{ getusername($inspectionDetails->tsd_representative) }}
                        </td>
                        <td width="20%" style="padding:5px;"><b>Jetty Location</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $jettydetails['location'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" width="20%" style="padding:5px;">
                            <img src=" {{ admin_url($jettydetails['image']) }}" id="jetty_location_image"
                                style="width:400px;" alt="">
                        </td>
                    </tr>
                </table>
            @endif

            @if (
                $inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE ||
                    $inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE_CARETAKER)
                <table width="100%" style="width:100%;border: 0.5px solid">
                    <tr>
                        @if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE)
                            <td width="20%" style="padding:5px;"><b>Building Type</b></td>
                            <td width="2%" style="padding:5px;">:</td>
                            <td width="25%" style="padding:5px;">
                                @if ($inspectionDetails->building_type != 'Others')
                                    {{ $inspectionDetails->building_type }}
                                @else
                                    Others - {{ $inspectionDetails->building_type_others }}
                                @endif
                            </td>
                        @endif
                        <td width="20%" style="padding:5px;"><b>Caretaker</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ getusername($inspectionDetails->caretaker_id) }}
                        </td>
                    </tr>

                </table>
            @endif

            @if (
                $inspectiontypeDetails->id == INSPECTION_TYPE_TERMINAL ||
                    $inspectiontypeDetails->id == INSPECTION_TYPE_CONTAINER_FORKLIFT ||
                    $inspectiontypeDetails->id == INSPECTION_TYPE_FORKLIFT ||
                    $inspectiontypeDetails->id == INSPECTION_TYPE_REACH_STACKER)
                <table width="100%" style="width:100%;border: 0.5px solid">
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Operator</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"> {{ getusername($inspectionDetails->operator_id) }}
                        </td>
                    </tr>
                </table>
            @endif

            @if ($inspectiontypeDetails->id == INSPECTION_TYPE_FIRST_AID)
                <table width="100%" style="width:100%;border: 0.5px solid">
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Caretaker</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"> {{ getusername($inspectionDetails->caretaker_id) }}
                        </td>
                        <td width="20%" style="padding:5px;"><b>Division</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"> {{ $inspectionDetails->division }}</td>
                    </tr>
                </table>
            @endif

            <br>

            <div class="row g-3 px-4 pt-4">

                <div class="table-responsive" style="white-space: normal!important;">

                    @php
                        $colspan = 2;
                        if ($inspectiontypeDetails->marks_type == 1) {
                            $colspan += 3;
                        }
                        if ($inspectiontypeDetails->marks_type == 2) {
                            $colspan += 4;
                        }
                        if ($inspectiontypeDetails->observation_required == 1) {
                            $colspan += 1;
                        }
                        if ($inspectiontypeDetails->remarks_required == 1) {
                            $colspan += 1;
                        }

                        $j = 1;

                    @endphp

                    @foreach ($checklistCategoryDetails as $checklistCategory)
                        <table class="table-border" style="width:100%;border: 0.5px solid;border-collapse: collapse;">
                            <thead>
                                <tr style="border: 0.5px solid;border-collapse: collapse;">
                                    <th colspan="{{ $colspan }}" style="font-weight: bold;text-align:center;">
                                        {{ $checklistCategory->category_name }}</th>
                                </tr>
                                <tr style="border: 0.5px solid;border-collapse: collapse;">
                                    <th style="width:5% ">SNo</th>
                                    <th style="width:40%">Item</th>
                                    @if ($inspectiontypeDetails->marks_type == 1)
                                        <th style="width:5%">YES</th>
                                        <th style="width:5%">NO</th>
                                        <th style="width:5%">NA</th>
                                    @endif

                                    @if ($inspectiontypeDetails->marks_type == 2)
                                        <th style="width:3%">1</th>
                                        <th style="width:3%">2</th>
                                        <th style="width:3%">3</th>
                                        <th style="width:3%">NA</th>
                                    @endif

                                    @if ($inspectiontypeDetails->observation_required == 1)
                                        <th style="width:20%">Observation</th>
                                    @endif

                                    @if ($inspectiontypeDetails->remarks_required == 1)
                                        <th style="width:20%">Remarks</th>
                                    @endif

                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $i = 1;

                                @endphp
                                @if (isset($checklistItemDetails[$checklistCategory->id]))
                                    @foreach ($checklistItemDetails[$checklistCategory->id] as $checklistItem)
                                        @php
                                            $lineitem = $inspectionchecklistitem[$checklistItem->id];
                                        @endphp
                                        <tr style="width:100%;border: 0.5px solid">
                                            <td>{{ $i }}</td>
                                            <td>{{ $checklistItem->item_name }}
                                                <input type="hidden"
                                                    name="insp_check[{{ encryptId($checklistItem->id) }}][category]"
                                                    value="{{ encryptId($checklistCategory->id) }}">
                                            </td>


                                            @if ($inspectiontypeDetails->marks_type == 1)
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == 'YES')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == 'NO')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == 'NA')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                            @endif

                                            @if ($inspectiontypeDetails->marks_type == 2)
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == '1')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == '2')
                                                        <span style="color: #267709;"></span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == '3')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                                <td class="form-input" style="text-align: center">
                                                    @if ($lineitem->score == 'NA')
                                                        <span style="color: #267709;">✔</span>
                                                    @else
                                                        <span style="color: #f72626;"><span style="font-size: 14px">&#8226;</span></span>
                                                    @endif

                                                </td>
                                            @endif

                                            @if ($inspectiontypeDetails->observation_required == 1)
                                                <td class="form-input">
                                                    {{ $lineitem->observation }}
                                                </td>
                                            @endif

                                            @if ($inspectiontypeDetails->remarks_required == 1)
                                                <td class="form-input">
                                                    {{ $lineitem->remarks }}
                                                </td>
                                            @endif
                                        </tr>

                                        @isset($inspectionFiles[$checklistItem->id])
                                            <tr>
                                                <td colspan="{{ $colspan }}">
                                                    <div class="row m-1">
                                                        <table>
                                                            <tr>
                                                                @foreach ($inspectionFiles[$checklistItem->id] as $image)
                                                                    <td style="border-collapse: collapse;">
                                                                        <img src="{{ admin_url($image->file_path) }}"
                                                                            style="width:200px" alt="">
                                                                    </td>
                                                                @endforeach
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endisset

                                        @php
                                            $i++;
                                            $j++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>

                        </table>
                        <br>
                    @endforeach
                    <input type="hidden" name="totalitems" value="{{ $j }}">
                </div>

                @if ($inspectiontypeDetails->marks_type == 2)
                    @php
                        $score = json_decode($inspectionDetails->score);

                    @endphp

                    <div class="row">

                        <table class="">
                            <tr>
                                <td style="width: 60%">
                                    <table class="table table-border">
                                        <tr>
                                            <td colspan="3">TOTAL SCORE </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%">No. Issue to be identified</td>
                                            <td style="width: 10%">=</td>
                                            <td style="width: 40%">
                                                {{ $score->total_issue }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Score for each performance</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="padding-left:2rem">
                                                    No. Damaged X 1
                                                </span>
                                            </td>
                                            <td>=</td>
                                            <td>
                                                {{ $score->issue_value_1 * 1 }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="padding-left:2rem">
                                                    No. Less satisfied X 2
                                                </span>
                                            </td>
                                            <td>=</td>
                                            <td>
                                                {{ $score->issue_value_2 * 2 }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span style="padding-left:2rem">
                                                    No. Satisfied X 3
                                                </span>
                                            </td>
                                            <td>=</td>
                                            <td>
                                                {{ $score->issue_value_3 * 3 }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Total Score
                                            </td>
                                            <td>=</td>
                                            <td>
                                                {{ $score->total_scores }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Overall score</td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <math xmlns="http://www.w3.org/1998/Math/MathML" display="block">
                                                    <mfrac>
                                                        <mrow>
                                                            <mi>Total score</mi>
                                                        </mrow>
                                                        <mrow>
                                                            <mo>(</mo>
                                                            <mi>No. Issue to be identified</mi>
                                                            <mo>x</mo>
                                                            <mn>3</mn>
                                                            <mo>)</mo>
                                                        </mrow>
                                                    </mfrac>
                                                    <mo>x</mo>
                                                    <mn>100%</mn>
                                                </math>

                                            </td>
                                            <td>=</td>
                                            <td>
                                                {{ $score->overallscore }}
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td style="width: 40%;vertical-align:top">
                                    <table class="table table-border">
                                        <tr>
                                            <td colspan="3">OVERALL ASSESSMENT </td>
                                        </tr>
                                        <tr>
                                            <td>From the overall score, this audit can be concluded
                                                as :
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span>
                                                    81 - 100%
                                                </span>
                                            </td>
                                            <td>=</td>
                                            <td>
                                                @if ($score->scorerange == 1)
                                                    ✔
                                                @else
                                                <span style="font-size: 14px">&#8226;</span>
                                                @endif


                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span>
                                                    41 - 80%
                                                </span>
                                            </td>
                                            <td>=</td>
                                            <td>
                                                @if ($score->scorerange == 2)
                                                    ✔
                                                @else
                                                <span style="font-size: 14px">&#8226;</span>
                                                @endif

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>0 - 40%</td>
                                            <td>=</td>
                                            <td>
                                                @if ($score->scorerange == 3)
                                                    ✔
                                                @else
                                                <span style="font-size: 14px">&#8226;</span>
                                                @endif

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                @endif

            </div>
            <hr>

            @php
                $inspector = getuser($inspectionDetails->inspector_id);
            @endphp

            <table style="width:100%;" class="table table-border">
                <thead>
                    <tr>
                        <td colspan="6"
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            PART D: INSPECTION SUBMITTED BY
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Name</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;"> {{ $inspector->name }}</td>
                        <td width="20%" style="padding:5px;"><b>Designation</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" style="padding:5px;">{{ $inspector->user_designation_name }}
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Date and Time</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="25%" colspan="4" style="padding:5px;">
                            {{ displayDateformat($inspectionDetails->org_inspection_date) . ' ' . $inspectionDetails->org_inspection_time }}
                        </td>

                    </tr>
                    @if ($inspectionDetails->inspection_type == INSPECTION_TYPE_FIRST_AID)
                        <tr>
                            <td width="20%" style="padding:5px;"><b>Overall First Aid Box Condition</b></td>
                            <td width="2%" style="padding:5px;">:</td>
                            <td width="75%" colspan="4" style="padding:5px;">
                                {{ $inspectionDetails->overallfeedback }}
                            </td>
                        </tr>
                    @endif
                    @if (count($inspectionMainFileDetails) > 0)
                    <tr>
                        <td width="20%" style="padding:5px;"><b>Upload Documents</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="75%" colspan="4" style="padding:5px;">
                            @foreach ($inspectionMainFileDetails as $file)
                                <div>
                                    <a download href="{{ admin_url($file->file_path) }}">{{ $file->file_orgname }}</a>
                                </div>
                            @endforeach

                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td width="20%" style="padding:5px;"><b>Inspection Remarks</b></td>
                        <td width="2%" style="padding:5px;">:</td>
                        <td width="75%" colspan="4" style="padding:5px;">
                            {{ $inspectionDetails->inspector_remarks }}</td>
                    </tr>
                </tbody>
            </table>


        @endif

        @if (count($statuslogs) > 0)
            <br>
            <table style="width:100%;" class="table table-border">

                <head>
                    <tr>
                        <td colspan="6"
                            style="width:100%;background-color: #0272b4;color:#fff;font-weight:bold;padding: 5px 5px 5px;">
                            APPROVAL
                        </td>
                    </tr>
                </head>
                <tbody>
                    @foreach ($statuslogs as $statusLog)
                        <tr style="background-color: #aaa">
                            <td colspan="6" style="font-weight:500;"> Status -
                                {!! inspectionStatus($statusLog->to_status) !!} </td>
                        </tr>
                        <tr>
                            <th style="width: 10%">Name</th>
                            <td style="width: 5%">:</td>
                            <td style="width: 30%">
                                {{ getusername($statusLog->created_by) }}</td>
                            <td style="width: 10%">Date</td>
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
