@if ($inspectiontypeDetails->id == INSPECTION_TYPE_BOAT)
    <div class="mb-3">
        <div class="row">
            <div class="col-md-6 ">
                <label for="company_name" class="form-label require">INSPECTION TYPE</label>
                <div class="form-input">
                    <div>
                        <input type="radio" name="insp_type" id="insp_type_compliance" value="Compliance Inspection"
                            class="validate-radio-required">
                        <label for="insp_type_compliance">Compliance Inspection</label>
                    </div>
                    <div>
                        <input type="radio" name="insp_type" id="insp_type_safety" value="Safety Inspection"
                            class="validate-radio-required">
                        <label for="insp_type_safety">Safety Inspection</label>
                    </div>
                    <div>
                        <input type="radio" name="insp_type" id="insp_type_followup" value="Follow-up Inspection"
                            class="validate-radio-required">
                        <label for="insp_type_followup">Follow-up Inspection</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <label class="form-label require">LENGTH (M)</label>
                <div class="form-input">
                    <div>
                        <input type="radio" name="vessel_lengh" id="length_less_16" value="< 16"
                            class="validate-radio-required">
                        <label for="length_less_16">
                            < 16</label>
                    </div>
                    <div> <input type="radio" name="vessel_lengh" value="16-25" id="length_16_25"
                            class="validate-radio-required">
                        <label for="length_16_25"> 16-25</label>
                    </div>
                    <div>
                        <input type="radio" name="vessel_lengh" value="26-30" id="length_26_30"
                            class="validate-radio-required">
                        <label for="length_26_30"> 26-30</label>
                    </div>
                    <div>
                        <input type="radio" name="vessel_lengh" value=">30" id="length_above_30"
                            class="validate-radio-required">
                        <label for="length_above_30"> >30</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-input">
                <label for="vessel_name" class="form-label require">VESSEL NAME</label>
                <input type="text" class="form-control validate-input-required" name="vessel_name" id="vessel_name"
                    data-error="Please enter Vessel Name">
            </div>
            <div class="col-md-6 form-input">
                <label for="vessel_type" class="form-label require">TYPE OF VESSEL</label>
                <input type="text" class="form-control validate-input-required" name="vessel_type" id="vessel_type"
                    data-error="Please enter Type of Vessel">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-input">
                <label for="vessel_beam" class="form-label require">BEAM (M)</label>
                <input type="text" class="form-control validate-input-required" name="vessel_beam" id="vessel_beam"
                    data-error="Please enter Beam">
            </div>
            <div class="col-md-4 form-input">
                <label for="vessel_depth" class="form-label require">DEPTH (M)</label>
                <input type="text" class="form-control validate-input-required" name="vessel_depth" id="vessel_depth"
                    data-error="Please enter Depth" pattern="[0-9]+" title="Please enter a numeric value">
            </div>

            <div class="col-md-4 form-input">
                <label for="vessel_gross" class="form-label require">GROSS TONNAGE</label>
                <input type="text" class="form-control validate-input-required" name="vessel_gross" id="vessel_gross"
                    data-error="Please enter Gross Tonnage" pattern="[0-9]+" title="Please enter a numeric value">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-input">
                <label for="vessel_hull" class="form-label require">HULL CONSTRUCTION</label>
                <select name="vessel_hull" id="vessel_hull"
                    class="form-control select2 validate-select-required othersshow" data-id="vessel_hull_other">
                    <option value="">Please select Hull Construction</option>
                    <option value="Steel">Steel</option>
                    <option value="Wood">Wood</option>
                    <option value="Aluminium">Aluminium</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="vessel_hull_other" id="vessel_hull_other" style="display:none;"
                    data-error="Please enter HULL CONSTRUCTION" class="form-control mt-1 validate-input-required">
            </div>

            <div class="col-md-4 form-input">
                <label for="vessel_superstructure" class="form-label require">SUPERSTRUCTURE CONSTRUCTION</label>
                <select name="vessel_superstructure" id="vessel_superstructure" data-id="vessel_superstructure_other"
                    class="form-control select2 validate-select-required othersshow">
                    <option value="">Please select Superstructure Construction</option>
                    <option value="Steel">Steel</option>
                    <option value="Wood">Wood</option>
                    <option value="Aluminium">Aluminium</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="vessel_superstructure_other" id="vessel_superstructure_other"
                    data-error="Please enter SUPERSTRUCTURE CONSTRUCTION" style="display:none;"
                    class="form-control mt-1 validate-input-required">
            </div>

            <div class="col-md-4 form-input">
                <label for="vessel_propulsion" class="form-label require">PROPULSION</label>
                <select name="vessel_propulsion" id="vessel_propulsion"
                    class="form-control select2 validate-select-required">
                    <option value="">Please select PROPULSION</option>
                    <option value="Inboard">Inboard</option>
                    <option value="Outboard">Outboard</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 form-input">
                <label for="vessel_owner" class="form-label require">VESSEL OWNER</label>
                <select name="vessel_owner" id="vessel_owner" data-id="vessel_owner_other"
                    class="form-control select2 validate-select-required othersshow">
                    <option value="">Please select Vessel Owner</option>
                    <option value="BPSB">BPSB</option>
                    <option value="Contractor">Contractor</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="vessel_owner_other" id="vessel_owner_other" style="display:none;"
                    data-error="Please enter VESSEL OWNER" class="form-control mt-1 validate-input-required">
            </div>

            <div class="col-md-4 form-input">
                <label for="vessel_operator" class="form-label require">VESSEL OPERATOR</label>
                <select name="vessel_operator" id="vessel_operator" data-id="vessel_operator_other"
                    class="form-control select2 validate-select-required othersshow">
                    <option value="">Please select Vessel Operation</option>
                    <option value="BPSB">BPSB</option>
                    <option value="Contractor">Contractor</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="vessel_operator_other" id="vessel_operator_other" style="display:none;"
                    data-error="Please enter VESSEL OPERATOR" class="form-control mt-1 validate-input-required">
            </div>

            <div class="col-md-4 form-input">
                <label for="vessel_imo_registration" class="form-label require">IMO/REGISTRATION NO</label>
                <input type="text" name="vessel_imo_registration" id="vessel_imo_registration"
                    data-error="Please enter IMO/ Registration" class="form-control validate-input-required"
                    pattern="[0-9]+" title="Please Enter Numeric Value">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 form-input">
                <label for="vessel_flag" class="form-label require">FLAG</label>
                <input type="text" name="vessel_flag" id="vessel_flag" data-error="Please enter Flag"
                    class="form-control validate-input-required">
            </div>
            <div class="col-md-3 form-input">
                <label for="vessel_port_of_registry" class="form-label require">PORT OF REGISTRY</label>
                <input type="text" name="vessel_port_of_registry" id="vessel_port_of_registry"
                    data-error="Please enter Port of Registry" class="form-control validate-input-required">
            </div>
            <div class="col-md-3 form-input">
                <label for="vessel_classification" class="form-label require">CLASSIFICATION SOCIETY OR CLASS</label>
                <input type="text" name="vessel_classification" id="vessel_classification"
                    data-error="Please enter Classification Society or Class"
                    class="form-control validate-input-required">
            </div>
            <div class="col-md-3 form-input">
                <label for="vessel_total_person" class="form-label require">TOTAL No. OF PERSON ONBOARD</label>
                <input type="text" name="vessel_total_person" id="vessel_total_person"
                    class="form-control validate-input-required" data-error="Please enter Total No of Person Onboard"
                    pattern="[0-9]+" title="Please Enter Numeric Values">
            </div>
            <div class="col-md-3 form-input">
                <label for="vessel_total_person" class="form-label require">MSD Representative</label>
                <select class="form-control select2 validate-select-required" name="msd_representative"
                    id="msd_representative" data-error="Please select MSD Representative">
                    <option value="">Select MSD Representative</option>
                    @foreach ($msdUserDetails as $msdUser)
                        <option value="{{ encryptId($msdUser->id) }}">{{ $msdUser->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
    </div>
@endif

@if ($inspectiontypeDetails->id == INSPECTION_JETTY_AUDIT)
    <div class="mb-3">
        <div class="row">
            <div class="col-md-3 form-input">
                <label for="vessel_total_person" class="form-label require">TSD Representative</label>
                <select class="form-control select2 validate-select-required" name="tsd_representative"
                    id="tsd_representative" data-error="Please select TSD Representative">
                    <option value="">Select TSD Representative</option>
                    @foreach ($tsdUserDetails as $tsdUser)
                        <option value="{{ encryptId($tsdUser->id) }}">{{ $tsdUser->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 form-input">
                <label for="jetty_location" class="form-label require">Jetty Location</label>
                <select class="form-control select2 validate-select-required" name="jetty_location"
                    id="jetty_location" data-error="Please select Jetty Location">
                    <option value="">Select Jetty Location</option>
                    @foreach ($jettylocation as $location)
                        <option data-img="{{ $location->layout_image }}" value="{{ encryptId($location->id) }}">
                            {{ $location->jetty_location }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row" style="display: none" id="jetty_location_image_div">

            <div col-md-12>
                <img src="" id="jetty_location_image" style="" class="w-100" alt="">
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
                    <label for="building_type" class="form-label require">Building Type</label>
                    <select class="form-control select2 validate-select-required" name="building_type"
                        id="building_type" data-error="Please select Building Type">
                        <option value="">Select Building Type</option>
                        <option value="Office">Office</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="col-md-3 form-input" id="building_type_other_div" style="display: none">
                    <label for="building_type_others" class="form-label require">Others</label>
                    <input type="text" name="building_type_other" class="form-control validate-input-required "
                        data-error="Please enter Building types Others" id="building_type_others">
                </div>
            @endif


            <div class="col-md-3 form-input">
                <label for="caretaker_id" class="form-label require">Caretaker</label>
                <select class="form-control select2 validate-select-required" name="caretaker_id" id="caretaker_id"
                    data-error="Please select Caretaker">
                    <option value="">Select Caretaker</option>
                    @foreach ($caretakerDetails as $caretaker)
                        <option value="{{ encryptId($caretaker->id) }}">
                            {{ $caretaker->name }}</option>
                    @endforeach
                </select>
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
                <label for="operator_id" class="form-label require">Operator</label>
                <input type="text" class="form-control" name="operator_id" id="operator_id">

            </div>
        </div>
    </div>
@endif

@if ($inspectiontypeDetails->id == INSPECTION_TYPE_FIRST_AID)

    <div class="mb-3">
        <div class="row">
            <div class="col-md-3 form-input">
                <label for="caretaker_id" class="form-label require">Caretaker</label>
                <select class="form-control select2 validate-select-required" name="caretaker_id" id="caretaker_id"
                    data-error="Please select Caretaker">
                    <option value="">Select Caretaker</option>
                    @foreach ($caretakerDetails as $caretaker)
                        <option value="{{ encryptId($caretaker->id) }}">
                            {{ $caretaker->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 form-input">
                <label for="division" class="form-label require">Division</label>
                <input type="text" name="division" id="division" class="form-control">
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

        $headercount = 2;

        if ($inspectiontypeDetails->marks_type == 1) {
            $headercount = $headercount + 3;
        }

        if ($inspectiontypeDetails->marks_type == 2) {
            $headercount = $headercount + 4;
        }

        if ($inspectiontypeDetails->observation_required == 1) {
            $headercount = $headercount + 1;
        }

        if ($inspectiontypeDetails->remarks_required == 1) {
            $headercount = $headercount + 1;
        }

    @endphp

    @foreach ($checklistCategoryDetails as $checklistCategory)
        <table class="table table-bordered w-100">
            <thead>
                <tr>
                    <th colspan="{{ $colspan }}" style="font-weight: bold;text-align:center;">
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
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $checklistItem->item_name }}
                                <input type="hidden"
                                    name="insp_check[{{ encryptId($checklistItem->id) }}][category]"
                                    value="{{ encryptId($checklistCategory->id) }}">
                            </td>


                            @if ($inspectiontypeDetails->marks_type == 1)
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_yes_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required optionchange" value="YES">
                                </td>
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_no_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required optionchange" value="NO">
                                </td>
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_na_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required optionchange" value="NA">
                                </td>
                            @endif

                            @if ($inspectiontypeDetails->marks_type == 2)
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_one_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required calculatemark valueone optionchange"
                                        value="1">
                                </td>
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_two_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required calculatemark valuetwo optionchange"
                                        value="2">
                                </td>
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_three_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required calculatemark valuethree optionchange"
                                        value="3">
                                </td>
                                <td class="form-input">
                                    <input type="radio"
                                        name="insp_check[{{ encryptId($checklistItem->id) }}][value]"
                                        id="insp_check_na_{{ encryptId($checklistItem->id) }}"
                                        data-id="{{ encryptId($checklistItem->id) }}"
                                        class="validate-radio-required calculatemark valuena optionchange"
                                        value="NA">
                                </td>
                            @endif

                            @if ($inspectiontypeDetails->observation_required == 1)
                                <td class="form-input">
                                    <textarea name="insp_check[{{ encryptId($checklistItem->id) }}][observation]" data-error="Please enter Observation"
                                        id="insp_check_observation_{{ encryptId($checklistItem->id) }}" rows="3"
                                        class="form-control validate-textarea-required"></textarea>
                                </td>
                            @endif

                            @if ($inspectiontypeDetails->remarks_required == 1)
                                <td class="form-input">
                                    <textarea name="insp_check[{{ encryptId($checklistItem->id) }}][remarks]"
                                        id="insp_check_remarks_{{ encryptId($checklistItem->id) }}" rows="3" data-error="Please enter Remarks"
                                        class="form-control validate-textarea-required"></textarea>
                                </td>
                            @endif
                        </tr>

                        <tr id="imageupload_{{ encryptId($checklistItem->id) }}" class="imageupload"
                            style="display: none">
                            <td colspan="{{ $headercount }}">
                                <div id="referenceImages_{{ encryptId($checklistItem->id) }}">
                                    <div class="col-md-12">
                                        <div class="float-end">
                                            <button type="button" data-id="{{ encryptId($checklistItem->id) }}"
                                                class="badge bg-success addMoreButton">Add
                                                More</button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row addMoreRow">
                                        <label>Reference Image</label>
                                        <div class="col-md-3 form-input addMoreBlock">
                                            <div class="col-md-12 form-input imageuploadarea">
                                                <div class="fileinput fileinput-new apprFileinput"
                                                    data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail bootimgheight appbootimgheight"
                                                        data-trigger="fileinput">
                                                    </div>
                                                    <p class="mini-txt">(png, jpeg, jpg)</p>
                                                    <div class="file-pop">
                                                        <span class="text-green btn-file">
                                                            <span class="photo fileinput-new" title="Add Image">
                                                                <img class="imgupload"
                                                                    src='{{ admin_url('public/assets/images/common/camera.png') }}'
                                                                    style=" width: 30%; " />
                                                            </span>
                                                            <span class="fileinput-exists" title="Add Image"></span>
                                                            <input type="file"
                                                                name="referenceimage[{{ encryptId($checklistItem->id) }}][]"
                                                                class='atarfile' accept="image/*">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>

                        @php
                            $i++;
                            $j++;
                        @endphp
                    @endforeach
                @endif
            </tbody>

        </table>
    @endforeach
    <input type="hidden" name="totalitems" id="totalitems" value="{{ $j }}">
</div>

@if ($inspectiontypeDetails->marks_type == 2)
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
                            <span id="total_issue_identified"></span>
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
                            <span id="score_1" class="option-count"></span>
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
                            <span id="score_2" class="option-count"></span>
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
                            <span id="score_3" class="option-count"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Score
                        </td>
                        <td>=</td>
                        <td>
                            <span id="total_score"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Overall score</td>
                        <td>

                        </td>
                        <td></td>
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
                            <span id="overall_total_score"></span>
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
                        <td>From the overall score, this audit can be concluded as :</td>
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
                        <td><span id="overall_81_100" class="finalresult bold" style="font-size:18px;">&Cross;</span>
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
                            <span id="overall_41_80" class="finalresult bold" style="font-size:18px;">&Cross;</span>
                        </td>
                    </tr>

                    <tr>
                        <td>0 - 40%</td>
                        <td>=</td>
                        <td>
                            <span id="overall_0_40" class="finalresult bold" style="font-size:18px;">&Cross;</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <input type="hidden" name="mark[total_issue]" id="total_issue">
        <input type="hidden" name="mark[issue_value_1]" id="issue_value_1">
        <input type="hidden" name="mark[issue_value_2]" id="issue_value_2">
        <input type="hidden" name="mark[issue_value_3]" id="issue_value_3">
        <input type="hidden" name="mark[total_scores]" id="total_scores">
        <input type="hidden" name="mark[overallscore]" id="overallscore">
        <input type="hidden" name="mark[scorerange]" id="scorerange">
    </div>
@endif
