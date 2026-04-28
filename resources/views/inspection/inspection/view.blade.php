@extends('admin.layouts.layout')
@section('title', 'Inspection View')
@section('pageurl', admin_url('inspection/inspection/list'))

@section('content')
   <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{admin_url('home')}}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                HSSE Inspection
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('inspection/inspection/list') }}">Inspection</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Inspection View</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col">

                    <div class="card border-top border-0 border-4 border-primary">

                        <div class="card-body">
                            <div class="d-lg-flex align-items-center gap-3">

                                <div class="position-relative">
                                    <h5 class="card-title">Inspection View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('inspection/inspection/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">

                                    <div class="card-header card-header-inner mt-3 ">
                                        <h6 class="text-white">PART A : INSPECTION DETAILS</h6>
                                    </div>

                                    @php
                                        $user = getuser($inspectionDetails->created_by);
                                    @endphp
                                    <div class="row g-3 px-4 pt-4">

                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label font-weight-bold">Company</label>
                                            <div>
                                                {{ getCompanyName($inspectionDetails->company) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label font-weight-bold">Location</label>
                                            <div>
                                                {{ $inspectionDetails->location_name }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="specific_location" class="form-label font-weight-bold">Specific
                                                Location</label>
                                            <div>
                                                {{ $inspectionDetails->specific_loc_name }}
                                            </div>
                                        </div>


                                        <div class="col-md-4 form-input">
                                            <label for="inspectiondate" class="form-label font-weight-bold">Inspection
                                                Date</label>
                                            <div>
                                                {{ displayDateformat($inspectionDetails->inspection_date) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="inspectiontime" class="form-label font-weight-bold">Inspection
                                                Time</label>
                                            <div>
                                                {{ $inspectionDetails->inspection_time }}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">PART B: Inspection Type</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4">
                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label font-weight-bold">Inspection
                                                Type</label>
                                            <div>
                                                {{ $inspectionDetails->inspectiontype_name }}
                                            </div>
                                        </div>

                                    </div>
                                    <hr>

                                    @if ($inspectionDetails->inspection_status >= INSPECTION_STATUS_INSPECTION_COMPLETED)
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART C: INSPECTION CHECKLIST</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">
                                            @if ($inspectiontypeDetails->id == INSPECTION_TYPE_BOAT)
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md-6 ">
                                                            <label for="company_name" class="form-label bold">Inspection
                                                                Type</label>
                                                            <div class="form-input">
                                                                @if ($inspectionDetails->insp_type == 'Compliance Inspection')
                                                                    <i class="fa-solid fa-check"
                                                                        style="color: #267709;"></i>
                                                                @else
                                                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                                @endif

                                                                <label for="insp_type_compliance">Compliance
                                                                    Inspection</label>
                                                                @if ($inspectionDetails->insp_type == 'Safety Inspection')
                                                                    <i class="fa-solid fa-check"
                                                                        style="color: #267709;"></i>
                                                                @else
                                                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                                @endif

                                                                <label for="insp_type_safety">Safety Inspection</label>
                                                                @if ($inspectionDetails->insp_type == 'Follow-up Inspection')
                                                                    <i class="fa-solid fa-check"
                                                                        style="color: #267709;"></i>
                                                                @else
                                                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                                @endif
                                                                <label for="insp_type_followup">Follow-up
                                                                    Inspection</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 ">
                                                            <label class="form-label bold">LENGTH (M)</label>
                                                            <div class="form-input">
                                                                @if ($inspectionDetails->vessel_lengh == '< 16')
                                                                    <i class="fa-solid fa-check"
                                                                        style="color: #267709;"></i>
                                                                @else
                                                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                                                @endif

                                                                <label for="length_less_16">
                                                                    < 16</label>
                                                                        @if ($inspectionDetails->vessel_lengh == '16-25')
                                                                            <i class="fa-solid fa-check"
                                                                                style="color: #267709;"></i>
                                                                        @else
                                                                            <i class="fa  fa-dot-circle-o"
                                                                                style="color: #f72626;"></i>
                                                                        @endif

                                                                        <label for="length_16_25"> 16-25</label>
                                                                        @if ($inspectionDetails->vessel_lengh == '26-30')
                                                                            <i class="fa-solid fa-check"
                                                                                style="color: #267709;"></i>
                                                                        @else
                                                                            <i class="fa  fa-dot-circle-o"
                                                                                style="color: #f72626;"></i>
                                                                        @endif

                                                                        <label for="length_26_30"> 26-30</label>
                                                                        @if ($inspectionDetails->vessel_lengh == '>30')
                                                                            <i class="fa-solid fa-check"
                                                                                style="color: #267709;"></i>
                                                                        @else
                                                                            <i class="fa  fa-dot-circle-o"
                                                                                style="color: #f72626;"></i>
                                                                        @endif
                                                                        <label for="length_above_30"> >30</label>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 form-input">
                                                            <label for="vessel_name" class="form-label bold">VESSEL
                                                                NAME</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_name }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 form-input">
                                                            <label for="vessel_type" class="form-label bold">TYPE OF
                                                                VESSEL</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_type }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_beam" class="form-label bold">BEAM
                                                                (M)</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_beam }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_depth" class="form-label bold">DEPTH
                                                                (M)</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_depth }}
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_gross" class="form-label bold">GROSS
                                                                TONNAGE</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_gross }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_hull" class="form-label bold">HULL
                                                                CONSTRUCTION</label>
                                                            <div>
                                                                @if ($inspectionDetails->vessel_hull == 'Other')
                                                                    {{ $inspectionDetails->vessel_hull_other }}
                                                                @else
                                                                    {{ $inspectionDetails->vessel_hull }}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_superstructure"
                                                                class="form-label bold">SUPERSTRUCTURE
                                                                CONSTRUCTION</label>
                                                            <div>
                                                                @if ($inspectionDetails->vessel_superstructure == 'Other')
                                                                    {{ $inspectionDetails->vessel_superstructure_other }}
                                                                @else
                                                                    {{ $inspectionDetails->vessel_superstructure }}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_propulsion"
                                                                class="form-label bold">PROPULSION</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_propulsion }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_owner" class="form-label bold">VESSEL
                                                                OWNER</label>
                                                            <div>

                                                                @if ($inspectionDetails->vessel_owner == 'Other')
                                                                    {{ $inspectionDetails->vessel_owner_other }}
                                                                @else
                                                                    {{ $inspectionDetails->vessel_owner }}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_operator" class="form-label bold">VESSEL
                                                                OPERATOR</label>
                                                            <div>
                                                                @if ($inspectionDetails->vessel_operator == 'Other')
                                                                    {{ $inspectionDetails->vessel_operator_other }}
                                                                @else
                                                                    {{ $inspectionDetails->vessel_operator }}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 form-input">
                                                            <label for="vessel_imo_registration"
                                                                class="form-label bold">IMO/REGISTRATION NO</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_imo_registration }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_flag" class="form-label bold">FLAG</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_flag }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_port_of_registry"
                                                                class="form-label bold">PORT OF REGISTRY</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_port_of_registry }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_classification"
                                                                class="form-label bold">CLASSIFICATION SOCIETY OR
                                                                CLASS</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_classification }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_total_person" class="form-label bold">TOTAL
                                                                No. OF PERSON ONBOARD</label>
                                                            <div>
                                                                {{ $inspectionDetails->vessel_total_person }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_total_person" class="form-label bold">MSD
                                                                Representative</label>
                                                            <div>
                                                                {{ getusername($inspectionDetails->msd_representative) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                            @endif

                                            @if ($inspectiontypeDetails->id == INSPECTION_JETTY_AUDIT)
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md-3 form-input">
                                                            <label for="vessel_total_person" class="form-label ">TSD
                                                                Representative</label>
                                                            <div>
                                                                {{ getusername($inspectionDetails->tsd_representative) }}
                                                            </div>
                                                        </div>

                                                        @php
                                                            $jettydetails = getJettyLocation(
                                                                $inspectionDetails->jetty_location,
                                                            );
                                                        @endphp

                                                        <div class="col-md-3 form-input">
                                                            <label for="jetty_location" class="form-label require">Jetty
                                                                Location</label>
                                                            <div>
                                                                {{ $jettydetails['location'] }}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="jetty_location_image_div">

                                                        <div col-md-12>
                                                            <img src=" {{ admin_url($jettydetails['image']) }}"
                                                                id="jetty_location_image" style="" class="w-100"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (
                                                $inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE ||
                                                    $inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE_CARETAKER)
                                                <div class="mb-3">
                                                    <div class="row">

                                                        @if ($inspectiontypeDetails->id == INSPECTION_TYPE_BUILDING_OFFICE)
                                                            <div class="col-md-3 form-input">
                                                                <label for="building_type"
                                                                    class="form-label require">Building
                                                                    Type</label>
                                                                <div>
                                                                    {{ $inspectionDetails->building_type }}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 form-input" id="building_type_other_div"
                                                                @if ($inspectionDetails->building_type != 'Others') style="display: none" @endif>
                                                                <label for="building_type_others"
                                                                    class="form-label require">Others</label>
                                                                <div>
                                                                    {{ $inspectionDetails->building_type_others }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-3 form-input d-none">
                                                            <label for="caretaker_id"
                                                                class="form-label require">Caretaker</label>
                                                            <div>
                                                                {{ getusername($inspectionDetails->caretaker_id) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if (
                                                $inspectiontypeDetails->id == INSPECTION_TYPE_TERMINAL ||
                                                    $inspectiontypeDetails->id == INSPECTION_TYPE_CONTAINER_FORKLIFT ||
                                                    $inspectiontypeDetails->id == INSPECTION_TYPE_FORKLIFT ||
                                                    $inspectiontypeDetails->id == INSPECTION_TYPE_REACH_STACKER)
                                                <div class="mb-3">
                                                    <div class="row">


                                                        <div class="col-md-3 form-input">
                                                            <label for="operator_id"
                                                                class="form-label require">Operator</label>
                                                            <div>
                                                                {{ getusername($inspectionDetails->operator_id) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($inspectiontypeDetails->id == INSPECTION_TYPE_FIRST_AID)
                                                <div class="mb-3">
                                                    <div class="row">
                                                        <div class="col-md-3 form-input">
                                                            <label for="caretaker_id"
                                                                class="form-label require">Caretaker</label>
                                                            <div>
                                                                {{ getusername($inspectionDetails->caretaker_id) }}
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 form-input">

                                                            <label for="caretaker_id"
                                                                class="form-label require">Division</label>
                                                            <div>
                                                                {{ $inspectionDetails->division }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

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
                                                    <table class="table table-bordered w-100">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="{{ $colspan }}"
                                                                    style="font-weight: bold;text-align:center;">
                                                                    {{ $checklistCategory->category_name }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="width:3%">SNo</th>
                                                                <th style="width:40%">Item</th>
                                                                @if ($inspectiontypeDetails->marks_type == 1)
                                                                    <th style="width:3%">YES</th>
                                                                    <th style="width:3%">NO</th>
                                                                    <th style="width:3%">NA</th>
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
                                                                        $lineitem =
                                                                            $inspectionchecklistitem[
                                                                                $checklistItem->id
                                                                            ];
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $checklistItem->item_name }}
                                                                            <input type="hidden"
                                                                                name="insp_check[{{ encryptId($checklistItem->id) }}][category]"
                                                                                value="{{ encryptId($checklistCategory->id) }}">
                                                                        </td>


                                                                        @if ($inspectiontypeDetails->marks_type == 1)
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == 'YES')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == 'NO')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == 'NA')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                        @endif

                                                                        @if ($inspectiontypeDetails->marks_type == 2)
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == '1')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == '2')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == '3')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
                                                                                @endif

                                                                            </td>
                                                                            <td class="form-input">
                                                                                @if ($lineitem->score == 'NA')
                                                                                    <i class="fa-solid fa-check"
                                                                                        style="color: #267709;"></i>
                                                                                @else
                                                                                    <i class="fa  fa-dot-circle-o"
                                                                                        style="color: #f72626;"></i>
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
                                                                                    @foreach ($inspectionFiles[$checklistItem->id] as $image)
                                                                                        <div class="col-md-3 border ">
                                                                                            <img src="{{ admin_url($image->file_path) }}"
                                                                                                class="w-100 p-1"
                                                                                                alt="">
                                                                                        </div>
                                                                                    @endforeach
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
                                                @endforeach
                                                <input type="hidden" name="totalitems" value="{{ $j }}">
                                            </div>

                                            @if ($inspectiontypeDetails->marks_type == 2)
                                                @php
                                                    $score = json_decode($inspectionDetails->score);
                                                @endphp

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <tr>
                                                                    <td colspan="3">TOTAL SCORE </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No. Issue to be identified</td>
                                                                    <td>=</td>
                                                                    <td>
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
                                                                        <math xmlns="http://www.w3.org/1998/Math/MathML"
                                                                            display="block">
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
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
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
                                                                            &check;
                                                                        @else
                                                                            &Cross;
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
                                                                            &check;
                                                                        @else
                                                                            &Cross;
                                                                        @endif

                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>0 - 40%</td>
                                                                    <td>=</td>
                                                                    <td>
                                                                        @if ($score->scorerange == 3)
                                                                            &check;
                                                                        @else
                                                                            &Cross;
                                                                        @endif

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                        <hr>

                                        @php
                                            $inspector = getuser($inspectionDetails->inspector_id);
                                        @endphp

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">PART D: Inspection Submitted By</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4">
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime"
                                                    class="form-label font-weight-bold">Name</label>
                                                <div>
                                                    {{ $inspector->name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime"
                                                    class="form-label font-weight-bold">Designation</label>
                                                <div>
                                                    {{ $inspector->user_designation_name }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="inspectiontime" class="form-label font-weight-bold">Date and
                                                    Time</label>
                                                <div>
                                                    {{ displayDateformat($inspectionDetails->org_inspection_date) . ' ' . $inspectionDetails->org_inspection_time }}
                                                </div>
                                            </div>

                                            @if ($inspectionDetails->inspection_type == INSPECTION_TYPE_FIRST_AID)
                                                <div class="col-md-12 form-input">
                                                    <label for="overallfeedback" class="form-label require">Overall First
                                                        Aid Box Condition</label>
                                                    <div>
                                                        {{ $inspectionDetails->overallfeedback }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-md-12 form-input">
                                                <label for="inspectionremarks" class="form-label ">Upload
                                                    Documents</label>
                                                <div class="row">
                                                    @if (count($inspectionMainFileDetails) > 0)
                                                        @foreach ($inspectionMainFileDetails as $file)
                                                            <div class="col-md-4">
                                                                <a download href="{{ admin_url($file->file_path) }}">{{ $file->file_orgname }}</a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="inspectionremarks"
                                                    class="form-label font-weight-bold">Inspection
                                                    Remarks</label>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="inspectionremarks"
                                                    class="form-label font-weight-bold">Inspection
                                                    Remarks</label>
                                                <div>
                                                    {{ $inspectionDetails->inspector_remarks }}
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                    @endif

                                    @if (count($statuslogs) > 0)
                                        <div class="card-header card-header-inner  mb-3 mt-3">
                                            <h6 class="text-white">Status Log</h6>
                                        </div>
                                        @foreach ($statuslogs as $statusLog)
                                            <div class="row  px-3">
                                                <div class="col-md-12">
                                                    <table class="table mb-0 table-borderless">
                                                        <tbody>
                                                            <tr style="background-color: #aaa">
                                                                <td colspan="6" style="font-weight:500;"> Status -
                                                                    {!! inspectionStatus($statusLog->to_status) !!} </td>
                                                            </tr>
                                                            <tr>
                                                                <th style="width: 10%">Name</th>
                                                                <td style="width: 5%">:</td>
                                                                <td style="width: 30%">
                                                                    {{ getusername($statusLog->created_by) }}</td>
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
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif


                                    @if (isset($approvereject) && (CheckUserRole(ROLE_HOD) || CheckUserRole(ROLE_ADMIN)))
                                        @if ($inspectionDetails->inspection_status == INSPECTION_STATUS_INSPECTION_COMPLETED)
                                            <form action="{{ admin_url('inspection/inspection/approvereject/submit') }}"
                                                method="POST">
                                                <div class=" border rounded">
                                                    <div class="card-header card-header-inner  mb-3 mt-3">
                                                        <h6 class="text-white">Approve / Reject</h6>
                                                    </div>
                                                    @csrf
                                                    <input type="hidden" name="id"
                                                        value="{{ encryptId($inspectionDetails->id) }}">
                                                    <div class="row g-3 px-2 pt-4">

                                                        <div class="row mb-3 mt-3">
                                                            <label class="col-sm-2 bold col-form-label bold">
                                                                Name</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="text" class="form-control"
                                                                    name="approvedby" id="approvedby"
                                                                    value="{{ Auth::user()->name }}" readonly>

                                                            </div>
                                                            <label class="col-sm-2 col-form-label bold form-input bold">
                                                                Date & Time</label>
                                                            <div class="col-sm-4 form-input">
                                                                <input type="text" class="form-control"
                                                                    name="approveddate" id="approveddate"
                                                                    value="{{ todayDate() }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <label class="col-sm-2 col-form-label font-weight-bold bold">
                                                                Remarks</label>
                                                            <div class="col-sm-10">
                                                                <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row card-bottom">
                                                        <div class="col-12 mt-2 mb-3">

                                                            <button class="btn btn-danger " data-bs-toggle="tooltip"
                                                                type="submit" name="reject" value="yes"
                                                                title="submit">Reject</button>
                                                            <button class="btn btn-primary " id="btnsubmit"
                                                                type="submit" name="approve" value="yes"
                                                                data-bs-toggle="tooltip" title="Approve">Approve</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif

                                    @if (
                                        $inspectionDetails->inspection_status == INSPECTION_STATUS_HOD_REJECTED &&
                                            ($inspectionDetails->created_by == Auth::id() || CheckUserRole(ROLE_SUPERADMIN)))
                                        <form action="{{ admin_url('inspection/inspection/edit/submit') }}"
                                            method="POST">
                                            <div class=" border rounded">
                                                <div class="card-header card-header-inner  mb-3 mt-3">
                                                    <h6 class="text-white">Update</h6>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ encryptId($inspectionDetails->id) }}">
                                                <div class="row g-3 px-2 pt-4">

                                                    <div class="row mb-3 mt-3">
                                                        <label class="col-sm-2 bold col-form-label bold">
                                                            Name</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control" name="approvedby"
                                                                id="approvedby" value="{{ Auth::user()->name }}"
                                                                readonly>

                                                        </div>
                                                        <label class="col-sm-2 col-form-label bold form-input bold">
                                                            Date & Time</label>
                                                        <div class="col-sm-4 form-input">
                                                            <input type="text" class="form-control"
                                                                name="approveddate" id="approveddate"
                                                                value="{{ todayDate() }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <label class="col-sm-2 col-form-label font-weight-bold bold">
                                                            Remarks</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="remarks" id="remarks" required class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row card-bottom">
                                                    <div class="col-12 mt-2 mb-3">
                                                        <button class="btn btn-primary " id="btnsubmit" type="submit"
                                                            name="submit" value="yes" data-bs-toggle="tooltip"
                                                            title="Submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@stop

@push('script')
    <script type="text/javascript">
        $(".inspectiondatepicker").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'daysOfWeekDisabled': [0, 6]
            //'datesDisabled':['16-11-2023','17-11-2023']
        });


        $(function() {
            $('#useeuact_add').validate({
                rules: {
                    reporter_name: {
                        required: true,
                    },
                    reporter_email: {
                        required: true,
                    },
                    reporter_company: {
                        required: true,
                    },
                    reporter_division: {
                        required: true,
                    },
                    reporter_department: {
                        required: true,
                    },
                    dateandtime: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    specific_location: {
                        required: true,
                    },
                    area: {
                        required: true,
                    },
                    machinerytype: {
                        required: true,
                    },
                    purposeofuse: {
                        required: true,
                    },
                    inspectiondate: {
                        required: true,
                    },
                    inspectiontime: {
                        required: true,
                    },
                    purposelocationofinspection: {
                        required: true,
                    },


                },
                messages: {
                    reporter_name: {
                        required: "Please enter Reporter Name",
                    },
                    reporter_email: {
                        required: "Please enter Reporter Email",
                    },
                    reporter_company: {
                        required: "Please enter Reporter Company",
                    },
                    reporter_division: {
                        required: "Please enter Reporter Division",
                    },
                    reporter_department: {
                        required: "Please enter Reporter Department",
                    },
                    dateandtime: {
                        required: "Please enter Date & Time",
                    },
                    location: {
                        required: "Please select Location",
                    },
                    specific_location: {
                        required: "Please select Specific Location"
                    },
                    area: {
                        required: "Please select Area",
                    },
                    machinerytype: {
                        required: "Please select Machinery Type",
                    },
                    purposeofuse: {
                        required: "Please enter Purpose of Use",
                    },
                    inspectiondate: {
                        required: "Please select Inspection Date",
                    },
                    inspectiontime: {
                        required: "Please select Inspection Time",
                    },
                    purposelocationofinspection: {
                        required: "Please enter the Propose location of inspection",
                    },



                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    $(element).closest(".form-input").addClass("selecterror");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                },
            });
        });




        $('#location').change(function() {
            var locationId = $(this).val();
            if (locationId) {
                $.ajax({
                    url: "{{ admin_url('specificlocation/list/') }}" + locationId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#specific_location').empty().append(
                            '<option >Select Specific Location</option>');
                        $.each(data, function(key, value) {
                            $('#specific_location').append('<option value="' + value.id +
                                '">' +
                                value
                                .name + '</option>');
                        });

                        $('#specific_location').trigger('change.select2');
                    }
                });
            } else {
                $('#specific_location').empty().append('<option >Select Specific Location</option>');
                $('#specific_location').trigger('change.select2');
            }
        });


        $('#machinerytype').change(function() {
            var typeid = $(this).val();
            if (typeid) {

                // Remove inputtext and inputfile class names from all inputs
                $(".custominput").removeClass("validate-input-required validate-file-required is-invalid")
                    .removeAttr("required");
                $(".custominputlabel").removeClass("font-weight-bold");

                // Add validation based on the selected dropdown value
                $(".custominput").each(function() {
                    var classes = $(this).attr("class").split(" ");
                    $(this).closest(".form-input").find("span").remove();

                    // Check if the selected value is present in the classes
                    if ($.inArray(typeid.toString(), classes) !== -1) {

                        $(this).closest(".form-input").find("label").addClass("font-weight-bold");
                        // Add inputtext class for text inputs
                        if ($(this).attr("type") === "text") {
                            $(this).addClass("validate-input-required");
                        }

                        // Add inputfile class for file inputs
                        if ($(this).attr("type") === "file") {
                            $(this).addClass("validate-file-required");
                        }
                    }
                });

            } else {
                $(".custominput").removeClass("validate-input-required validate-file-required is-invalid")
                    .removeAttr("required");
                $(".custominputlabel").removeClass("font-weight-bold");
            }
        });
    </script>
@endpush
