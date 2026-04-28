@extends('admin.layouts.layout')
@section('title', 'Waste Card Edit')
@section('pageurl', admin_url('wastemanagement/' . $companyname . '/wastecard/list'))

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
                                Waste Management
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('wastemanagement/' . $companyname . '/wastecard/list') }}">Waste
                                    Card</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Waste Card Edit</li>
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
                                    <h5 class="card-title">Waste Card Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/' . $companyname . '/wastecard/list') }}"
                                        data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="useeuact_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('wastemanagement/' . $companyname . '/wastecard/edit/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ encryptId($wastecard->id) }}">
                                        <input type="hidden" name="companyname" value="{{ $companyname }}">

                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">WASTE GENERATOR INFORMATION</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 mb-3">

                                            <div class="col-md-4 form-input">
                                                <label for="company" class="form-label require">Company Name</label>
                                                <select name="company" id="company" class="form-control select2">
                                                    <option value="">Please Select Company</option>
                                                    @foreach ($wastecompanyList as $wastecompany)
                                                        <option value="{{ encryptId($wastecompany->id) }}"
                                                            @if ($wastecompany->id == $wastecard->company) selected @endif
                                                            data-address='{{ $wastecompany->company_address }}'
                                                            data-personincharge='{{ $wastecompany->person_incharge }}'
                                                            data-contactno='{{ $wastecompany->contact_no }}'
                                                            data-email='{{ $wastecompany->email }}'>
                                                            {{ $wastecompany->company_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="address" class="form-label require">Company Address</label>
                                                <input type="text" name="address" id="address" class="form-control"
                                                    value="{{ $companydetails->company_address }}" readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="personincharge" class="form-label require">Person in
                                                    Charge</label>
                                                <input type="text" name="personincharge" id="personincharge"
                                                    value="{{ $companydetails->person_incharge }}" class="form-control"
                                                    readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="contactno" class="form-label require">Contact No.</label>
                                                <input type="text" name="contactno" id="contactno" class="form-control"
                                                    value="{{ $companydetails->contact_no }}" readonly required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="email" class="form-label require">Email</label>
                                                <input type="text" name="email" id="email" class="form-control"
                                                    value="{{ $companydetails->email }}" readonly required>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">A. PROPERTIES</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 mb-3">


                                            <div class="col-md-4 form-input">
                                                <label for="waste_code" class="form-label require">Waste Code</label>
                                                <select name="waste_code" id="waste_code" class="form-control select2">
                                                    <option value="">Please Select Waste Code</option>
                                                    @foreach ($wastetypeList as $wastetype)
                                                        <option value="{{ encryptId($wastetype->id) }}"
                                                            @if ($wastetype->id == $wastecard->waste_code) selected @endif
                                                            data-name='{{ $wastetype->wastetype_name }}'>
                                                            {{ $wastetype->wastetype_id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="waste_name" class="form-label require">Waste Name</label>
                                                <input type="text" name="waste_name" id="waste_name"
                                                    class="form-control" value="{{ $wastetypedetails->wastetype_name }}"
                                                    readonly required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="origin" class="form-label require">Origin</label>
                                                <input type="text" name="origin" id="origin" class="form-control"
                                                    value="{{ $wastecard->origin }}" required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="flash_point" class="form-label require">Flash Point
                                                    (⁰C)</label>
                                                <input type="text" name="flash_point" id="flash_point"
                                                    value="{{ $wastecard->flash_point }}" class="form-control" required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="boiling_point" class="form-label require">Boiling Point
                                                    (⁰C)</label>
                                                <input type="text" name="boiling_point" id="boiling_point"
                                                    value="{{ $wastecard->boiling_point }}" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="form_in_room_temp" class="form-label require">Form in Room
                                                    Temperature</label>
                                                <select name="form_in_room_temp" id="form_in_room_temp"
                                                    class="form-control select2">
                                                    <option value="">Please Select Form in Room Temperature</option>
                                                    @foreach ($wasteroomtemplist as $wasteroomtemp)
                                                        <option value="{{ encryptId($wasteroomtemp->id) }}"
                                                            @if ($wasteroomtemp->id == $wastecard->form_in_room_temp) selected @endif>
                                                            {{ $wasteroomtemp->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="solubility_in_water" class="form-label require">Solubility in
                                                    Water</label>
                                                <select name="solubility_in_water" id="solubility_in_water"
                                                    class="form-control select2">
                                                    <option value="">Please Select Solubility in Water</option>
                                                    @foreach ($wastesolubilitylist as $wastesolubility)
                                                        <option value="{{ encryptId($wastesolubility->id) }}"
                                                            @if ($wastesolubility->id == $wastecard->solubility_in_water) selected @endif>
                                                            {{ $wastesolubility->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="density" class="form-label require">Density</label>
                                                <select name="density" id="density" class="form-control select2">
                                                    <option value="">Please Select Density</option>
                                                    @foreach ($wastedensitylist as $wastedensity)
                                                        <option value="{{ encryptId($wastedensity->id) }}"
                                                            @if ($wastedensity->id == $wastecard->density) selected @endif>
                                                            {{ $wastedensity->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="color" class="form-label require">Colour</label>
                                                <input type="text" name="color" id="color" class="form-control"
                                                    value="{{ $wastecard->color }}" required>
                                            </div>
                                            <div class="col-md-4 form-input">
                                                <label for="odour" class="form-label require">Odour</label>
                                                <select name="odour" id="odour" class="form-control select2">
                                                    <option value="">Please Select Odour</option>
                                                    <option @if ($wastecard->odour == 'YES') selected @endif
                                                        value="YES">YES</option>
                                                    <option @if ($wastecard->odour == 'NO') selected @endif
                                                        value="NO">NO</option>

                                                </select>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label for="risk" class="form-label require">Risks</label>
                                                <div class="row">
                                                    @php
                                                        $riskdetails = string_to_array($wastecard->risk);
                                                    @endphp
                                                    @foreach ($wasterisklist as $wasterisk)
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="risk[]"
                                                                id="risk_{{ encryptId($wasterisk->id) }}"
                                                                value="{{ encryptId($wasterisk->id) }}"
                                                                @if (in_array($wasterisk->id, $riskdetails)) checked @endif>
                                                            <label
                                                                for="risk_{{ encryptId($wasterisk->id) }}">{{ $wasterisk->item_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white">B. HANDLING OF WASTE</h6>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 mb-3">

                                            <div class="col-md-12 form-input">
                                                <label for="ppe" class="form-label require">PPE</label>
                                                <div class="row">
                                                    @php
                                                        $ppedetails = string_to_array($wastecard->ppe);
                                                    @endphp
                                                    @foreach ($wasteppelist as $wasteppe)
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="ppe[]"
                                                                id="ppe_{{ encryptId($wasteppe->id) }}"
                                                                value="{{ encryptId($wasteppe->id) }}"
                                                                @if (in_array($wasteppe->id, $ppedetails)) checked @endif>
                                                            <label
                                                                for="ppe_{{ encryptId($wasteppe->id) }}">{{ $wasteppe->item_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="packagin_type" class="form-label require">Packaging
                                                    Type</label>
                                                <select name="packaging_type" id="packaging_type"
                                                    class="form-control select2">
                                                    <option value="">Please Select Packaging Type</option>
                                                    @foreach ($wastepackageList as $wastepackage)
                                                        <option value="{{ encryptId($wastepackage->id) }}"
                                                            @if ($wastepackage->id == $wastecard->packaging_type) selected @endif>
                                                            {{ $wastepackage->disposaltype_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 form-input">
                                                <label class="form-label require">Grouping System</label>
                                            </div>

                                            <div class="col-md-6 form-input">
                                                <label for="grouping_on_pallet" class="form-label require">i) No. of
                                                    Grouping on Pallet</label>
                                                <input type="text" name="grouping_on_pallet" id="grouping_on_pallet"
                                                    value="{{ $wastecard->grouping_on_pallet }}" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-6 form-input">
                                                <label for="stacking_allowed" class="form-label require">ii) No. Stacking
                                                    Allowed</label>
                                                <input type="text" name="stacking_allowed" id="stacking_allowed"
                                                    value="{{ $wastecard->stacking_allowed }}" class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="pictogram_for_labelling" class="form-label require">Pictogram
                                                    for Labelling</label>
                                                <select name="pictogram_for_labelling" id="pictogram_for_labelling"
                                                    class="form-control select2">
                                                    <option value="">Please Select Pictogram for Labelling</option>
                                                    <option @if ($wastecard->pictogram_for_labelling == 'YES') selected @endif
                                                        value="YES">YES</option>
                                                    <option @if ($wastecard->pictogram_for_labelling == 'NO') selected @endif
                                                        value="NO">NO</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 form-input">
                                                <label for="recommended_method_of_disposal"
                                                    class="form-label require">Recommended Method of Disposal</label>
                                                <select name="recommended_method_of_disposal"
                                                    id="recommended_method_of_disposal" class="form-control select2">
                                                    <option value="">Please Select Recommended Method of Disposal
                                                    </option>
                                                    @foreach ($wastedisposallist as $wastedisposal)
                                                        <option value="{{ encryptId($wastedisposal->id) }}"
                                                            @if ($wastecard->recommended_method_of_disposal == $wastedisposal->id) selected @endif>
                                                            {{ $wastedisposal->item_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>



                                        </div>

                                        <hr>

                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center gap-3">

                                                <div class="position-relative">
                                                    <h6 class="text-white">C. PRECAUTIONS IN CASE OF SPILL OR ACCIDENTAL
                                                        DISCHARGE CAUSING PERSONAL INJURY</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmore">Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3 px-4 pt-4 mb-3">
                                            @php
                                                $precautionsdetails = json_decode($wastecard->precautions);
                                                $i = 1;
                                            @endphp

                                            <div id="personalinjurylist">

                                                @foreach ($precautionsdetails as $precaution)
                                                    <div class="personalinjury">
                                                        <div class="row">
                                                            <div class="col-md-2 form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Risk</label>
                                                                <select name="per_inju[{{ $i }}][risk]"
                                                                    id="per_inju_{{ $i }}_risk"
                                                                    class="form-control select2 validate-select-required">
                                                                    <option value="">Please Select Risk</option>
                                                                    @foreach ($wasterisklist as $wasterisk)
                                                                        <option value="{{ encryptId($wasterisk->id) }}"
                                                                            @if (decryptId($precaution->risk) == $wasterisk->id) selected @endif>
                                                                            {{ $wasterisk->item_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Symptoms of
                                                                    Intoxication</label>
                                                                <textarea name="per_inju[{{ $i }}][symptoms]" id="per_inju_{{ $i }}_symptoms"
                                                                    class="form-control validate-textarea-required" rows="3">{{ $precaution->symptoms }}</textarea>
                                                            </div>
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">First Aid</label>
                                                                <textarea name="per_inju[{{ $i }}][firstaid]" id="per_inju_{{ $i }}_firstaid"
                                                                    class="form-control validate-textarea-required" rows="3">{{ $precaution->firstaid }}</textarea>
                                                            </div>
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Guidelines for the
                                                                    Physician</label>
                                                                <textarea name="per_inju[{{ $i }}][guidephy]" id="per_inju_{{ $i }}_guidephy"
                                                                    class="form-control validate-textarea-required" rows="3">{{ $precaution->guidephy }}</textarea>
                                                            </div>
                                                            <div class="col-md-1  form-input">
                                                                <div>
                                                                    <i class="fa fa-trash removerow"
                                                                        style="padding-top: 2rem"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            </div>


                                        </div>

                                        <hr>
                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center gap-3">

                                                <div class="position-relative">
                                                    <h6 class="text-white">D. STEPS TO BE TAKEN IN CASE OF SPILL OR
                                                        ACCIDENTAL DISCHARGE CAUSING MATERIAL DAMAGES ARISING FROM:</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmoreone">Add</button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row g-3 px-4 pt-4 mb-3">
                                            @php
                                                $materialdamages = json_decode($wastecard->material_damages);
                                                $i = 1;
                                            @endphp
                                            <div id="materialdamageslist">
                                                @foreach ($materialdamages as $materialdamage)
                                                    <div class="materialdamages">
                                                        <div class="row">
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Spill on the Floor, Soil,
                                                                    Road,
                                                                    Water</label>
                                                                <textarea name="metedamage[{{ $i }}][spill]" id="metedamage_{{ $i }}_spill" class="form-control validate-textarea-required"
                                                                    rows="3">{{ $materialdamage->spill }}</textarea>
                                                            </div>
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Fire</label>
                                                                <textarea name="metedamage[{{ $i }}][fire]" id="metedamage_{{ $i }}_fire" class="form-control validate-textarea-required"
                                                                    rows="3">{{ $materialdamage->fire }}</textarea>
                                                            </div>
                                                            <div class="col-md-3  form-input">
                                                                <label for="form_in_room_temp"
                                                                    class="form-label require">Explosion</label>
                                                                <textarea name="metedamage[{{ $i }}][explosion]" id="metedamage_{{ $i }}_explosion" class="form-control validate-textarea-required"
                                                                    rows="3">{{ $materialdamage->explosion }}</textarea>
                                                            </div>
                                                            <div class="col-md-1  form-input">
                                                                <div>
                                                                    <i class="fa fa-trash removerowone"
                                                                        style="padding-top: 2rem"></i>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>



                                    </div>
                                </div>


                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
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
        $('#company').change(function() {
            var companyId = $(this).val();
            if (companyId != '') {
                var selectedOption = this.options[this.selectedIndex];
                var dataaddress = selectedOption.getAttribute('data-address');
                var datapersonincharge = selectedOption.getAttribute('data-personincharge');
                var datacontactno = selectedOption.getAttribute('data-contactno');
                var dataemail = selectedOption.getAttribute('data-email');

                $('#address').val(dataaddress);
                $('#personincharge').val(datapersonincharge);
                $('#contactno').val(datacontactno);
                $('#email').val(dataemail);
            } else {
                $('#address').val("");
                $('#personincharge').val("");
                $('#contactno').val("");
                $('#email').val("");
            }
        });

        $('#waste_code').change(function() {
            var wastetypeId = $(this).val();
            if (wastetypeId != '') {
                var selectedOption = this.options[this.selectedIndex];
                var dataname = selectedOption.getAttribute('data-name');
                $('#waste_name').val(dataname);
            } else {
                $('#waste_name').val("");
            }
        });

        $(document).ready(function() {
            $(".notificationdate").datepicker({

                format: "dd-mm-yyyy",
                autoclose: true,
                orientation: "bottom",
                todayHighlight: true,
                daysOfWeekDisabled: [0, 6],

            });
            $("#inspectiondate-show").on("click", function() {
                $(".notificationdate").datepicker("show");
            });
        });

        $(document).ready(function() {
            $('#addmore').on('click', function() {

                $('#addmore').attr("disabled", true);
                var rowCount = $("#personalinjurylist .personalinjury").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".personalinjury").first().clone();

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                var newIndex = rowCount + 1;

                newRow.find("input[type='text']").val("");
                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find("input[type='text']").each(function() {

                    $(this).val("");
                    $(this).removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);
                });

                // Reset input file data and change name and id
                newRow.find("input[type='file']").val(null).each(function() {

                    $(this).val(null);

                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newId);
                });

                newRow.find("textarea").val(null).each(function() {

                    $(this).val(null);

                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newId);
                });

                newRow.find("select").each(function() {
                    $(this).removeClass(' select2-hidden-accessible');
                    $(this).removeAttr('data-select2-id');
                    $(this).removeAttr('tabindex');
                    $(this).removeAttr('aria-hidden');
                    $(this).removeAttr('aria-describedby');
                    $(this).find('option').removeAttr('data-select2-id');


                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);

                });

                newRow.find(".select2").each(function() {

                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).next(".select2-container").remove();
                        $(this).removeClass("select2-hidden-accessible");
                    } else {
                        $(this).next(".select2-container").remove();
                    }

                });

                $("#personalinjurylist").append(newRow);


                newRow.find(".select2").select2();

                $(".select2").select2();
                $('#addmore').attr("disabled", false);

            });

            $('#addmoreone').on('click', function() {

                $('#addmoreone').attr("disabled", true);
                var rowCount = $("#materialdamageslist .materialdamages").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".materialdamages").first().clone();

                newRow.find(".form-input").removeClass("selecterror");
                newRow.find(".form-control ").removeClass("is-invalid");
                newRow.find(".invalid-feedback").remove();

                var newIndex = rowCount + 1;

                newRow.find("input[type='text']").val("");
                newRow.find("input[type='text']").removeAttr("aria-describedby");

                newRow.find("input[type='text']").each(function() {

                    $(this).val("");
                    $(this).removeAttr("aria-describedby");

                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);
                });

                newRow.find("textarea").val(null).each(function() {

                    $(this).val(null);

                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newId);
                });


                // Reset input file data and change name and id
                newRow.find("input[type='file']").val(null).each(function() {

                    $(this).val(null);

                    var oldName = $(this).attr("name");
                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newId = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newId);
                });

                newRow.find("select").each(function() {
                    $(this).removeClass(' select2-hidden-accessible');
                    $(this).removeAttr('data-select2-id');
                    $(this).removeAttr('tabindex');
                    $(this).removeAttr('aria-hidden');
                    $(this).removeAttr('aria-describedby');
                    $(this).find('option').removeAttr('data-select2-id');


                    var oldName = $(this).attr("name");
                    var tagName = $(this).attr("name");

                    var matches = tagName.match(
                        /\['(.*?)'\]/);

                    var newName = oldName.replace(/\d+/, newIndex);
                    $(this).attr("name", newName);

                    var oldId = $(this).attr("id");
                    var newName = oldId.replace(/\d+/, newIndex);
                    $(this).attr("id", newName);

                });

                newRow.find(".select2").each(function() {

                    if ($(this).data('select2')) {
                        $(this).select2('destroy');
                    }
                    if ($(this).hasClass("select2-hidden-accessible")) {
                        $(this).next(".select2-container").remove();
                        $(this).removeClass("select2-hidden-accessible");
                    } else {
                        $(this).next(".select2-container").remove();
                    }

                });

                $("#materialdamageslist").append(newRow);


                newRow.find(".select2").select2();

                $(".select2").select2();
                $('#addmoreone').attr("disabled", false);

            });
        });

        $(document).on('click', '.removerow', function() {
            if ($("#personalinjurylist .personalinjury").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".personalinjury").remove();

                $("#personalinjurylist .personalinjury").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find("textarea").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find(".risk_matrix").each(function() {

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);
                    });

                    $(this).find("select").select2('destroy');

                    $(this).find(".select2").each(function() {

                        if ($(this).data('select2')) {
                            $(this).select2('destroy');
                        }
                        if ($(this).hasClass("select2-hidden-accessible")) {
                            $(this).next(".select2-container").remove();
                            $(this).removeClass("select2-hidden-accessible");
                        } else {
                            $(this).next(".select2-container").remove();
                        }
                    });

                    $(this).find(".select2-container").remove();

                    $(this).find("select").each(function() {
                        $(this).removeClass(' select2-hidden-accessible');
                        $(this).removeAttr('data-select2-id');
                        $(this).removeAttr('tabindex');
                        $(this).removeAttr('aria-hidden');
                        $(this).removeAttr('aria-describedby');
                        $(this).find('option').removeAttr('data-select2-id');

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var matches = tagName.match(
                            /\['(.*?)'\]/);

                        var newName = oldName.replace(/\d+/, newIndex);
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);

                    });
                    $(this).find(".select2").select2();
                });
                $(".select2").select2();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });

        $(document).on('click', '.removerowone', function() {
            if ($("#materialdamageslist .materialdamages").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".materialdamages").remove();

                $("#materialdamageslist .materialdamages").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text']").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find("textarea").each(function() {
                        var oldName = $(this).attr("name");
                        var newName = oldName.replace(/\[\d+\]/, '[' + (newIndex) + ']');
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newId = oldId.replace(/\d+/, (newIndex));
                        $(this).attr("id", newId);
                    });

                    $(this).find(".risk_matrix").each(function() {

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);
                    });

                    $(this).find("select").select2('destroy');

                    $(this).find(".select2").each(function() {

                        if ($(this).data('select2')) {
                            $(this).select2('destroy');
                        }
                        if ($(this).hasClass("select2-hidden-accessible")) {
                            $(this).next(".select2-container").remove();
                            $(this).removeClass("select2-hidden-accessible");
                        } else {
                            $(this).next(".select2-container").remove();
                        }
                    });

                    $(this).find(".select2-container").remove();

                    $(this).find("select").each(function() {
                        $(this).removeClass(' select2-hidden-accessible');
                        $(this).removeAttr('data-select2-id');
                        $(this).removeAttr('tabindex');
                        $(this).removeAttr('aria-hidden');
                        $(this).removeAttr('aria-describedby');
                        $(this).find('option').removeAttr('data-select2-id');

                        var oldName = $(this).attr("name");
                        var tagName = $(this).attr("name");

                        var matches = tagName.match(
                            /\['(.*?)'\]/);

                        var newName = oldName.replace(/\d+/, newIndex);
                        $(this).attr("name", newName);

                        var oldId = $(this).attr("id");
                        var newName = oldId.replace(/\d+/, newIndex);
                        $(this).attr("id", newName);

                    });
                    $(this).find(".select2").select2();
                });
                $(".select2").select2();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Sorry!',
                    text: 'Minimum one record required',
                });
                return true;
            }
        });

        $(function() {
            $('#useeuact_add').validate({
                rules: {
                    company: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    personincharge: {
                        required: true,
                    },
                    contactno: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    waste_code: {
                        required: true,
                    },
                    waste_name: {
                        required: true,
                    },
                    origin: {
                        required: true,
                    },
                    flash_point: {
                        required: true,
                    },
                    boiling_point: {
                        required: true,
                    },
                    form_in_room_temp: {
                        required: true,
                    },
                    solubility_in_water: {
                        required: true,
                    },
                    density: {
                        required: true,
                    },
                    color: {
                        required: true,
                    },
                    odour: {
                        required: true,
                    },
                    'risk[]': {
                        required: true,
                    },
                    'ppe[]': {
                        required: true,
                    },
                    packaging_type: {
                        required: true,
                    },
                    grouping_on_pallet: {
                        required: true,
                    },
                    stacking_allowed: {
                        required: true,
                    },
                    pictogram_for_labelling: {
                        required: true,
                    },
                    recommended_method_of_disposal: {
                        required: true,
                    },

                },
                messages: {
                    company: {
                        required: "Please select Company Name",
                    },
                    address: {
                        required: "Company Address is required",
                    },
                    personincharge: {
                        required: "Person in Charge is required",
                    },
                    contactno: {
                        required: "Contact No. is required",
                    },
                    email: {
                        required: "Email is required",
                    },
                    waste_code: {
                        required: "Please select Waste Code",
                    },
                    waste_name: {
                        required: "Waste Name is required",
                    },
                    origin: {
                        required: "Please enter Origin",
                    },
                    flash_point: {
                        required: "Please enter Flash Point",
                    },
                    boiling_point: {
                        required: "Please enter Boiling Point",
                    },
                    form_in_room_temp: {
                        required: "Please select Form in Room Temperature",
                    },
                    solubility_in_water: {
                        required: "Please select Solubility in Water",
                    },
                    density: {
                        required: "Please select Density",
                    },
                    color: {
                        required: "Please enter Colour",
                    },
                    odour: {
                        required: "Please select Odour",
                    },
                    'risk[]': {
                        required: "Please select Risk",
                    },
                    'ppe[]': {
                        required: "Please select PPE",
                    },
                    packaging_type: {
                        required: "Please select Packaging Type",
                    },
                    grouping_on_pallet: {
                        required: "Please enter No. of Grouping on Pallet",
                    },
                    stacking_allowed: {
                        required: "Please enter No. Stacking Allowed",
                    },
                    pictogram_for_labelling: {
                        required: "Please select Pictogram for Labelling",
                    },
                    recommended_method_of_disposal: {
                        required: "Please select Recommended Method of Disposal",
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
    </script>
@endpush
