@extends('admin.layouts.layout')
@section('title', 'Waste Card View')
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
                            <li class="breadcrumb-item active" aria-current="page">Waste Card View</li>
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
                                    <h5 class="card-title">Waste Card View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/' . $companyname . '/wastecard/list') }}"
                                        data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class=" border rounded ">
                                <div class="">
                                    @csrf
                                    <input type="hidden" name="companyname" value="{{ $companyname }}">

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">WASTE GENERATOR INFORMATION</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4 mb-3">

                                        <div class="col-md-4 form-input">
                                            <label for="company" class="form-label bold">Company Name</label>
                                            <div>
                                                {{ $companydetails->company_name }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="address" class="form-label bold">Company Address</label>
                                            <div>
                                                {{ $companydetails->company_address }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="personincharge" class="form-label bold">Person in
                                                Charge</label>
                                            <div>
                                                {{ $companydetails->person_incharge }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="contactno" class="form-label bold">Contact No.</label>
                                            <div>
                                                {{ $companydetails->contact_no }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="email" class="form-label bold">Email</label>
                                            <div>
                                                {{ $companydetails->email }}
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white">A. PROPERTIES</h6>
                                    </div>

                                    <div class="row g-3 px-4 pt-4 mb-3">


                                        <div class="col-md-4 form-input">
                                            <label for="waste_code" class="form-label bold">Waste Code</label>
                                            <div>
                                                {{ $wastetypedetails->wastetype_id }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="waste_name" class="form-label bold">Waste Name</label>
                                            <div>
                                                {{ $wastetypedetails->wastetype_name }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="origin" class="form-label bold">Origin</label>
                                            <div>
                                                {{ $wastecard->origin }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="flash_point" class="form-label bold">Flash Point
                                                (⁰C)</label>
                                            <div>
                                                {{ $wastecard->flash_point }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="boiling_point" class="form-label bold">Boiling Point
                                                (⁰C)</label>
                                            <div>
                                                {{ $wastecard->boiling_point }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="form_in_room_temp" class="form-label bold">Form in Room
                                                Temperature</label>
                                            <div>
                                                {{ getItemName($wastecard->form_in_room_temp) }}
                                            </div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="solubility_in_water" class="form-label bold">Solubility in
                                                Water</label>
                                            <div>
                                                {{ getItemName($wastecard->solubility_in_water) }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="density" class="form-label bold">Density</label>
                                            <div>
                                                {{ getItemName($wastecard->density) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="color" class="form-label bold">Colour</label>
                                            <div>
                                                {{ $wastecard->color }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="odour" class="form-label bold">Odour</label>
                                            <div>
                                                {{ $wastecard->odour }}
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label for="risk" class="form-label bold">Risks</label>
                                            <div>
                                                @php
                                                    $riskdetails = string_to_array($wastecard->risk);
                                                @endphp
                                            </div>
                                            <div class="row">
                                                @foreach ($wasterisklist as $wasterisk)
                                                    <div class="col-md-2">
                                                        <input type="checkbox" name="risk[]"
                                                            id="risk_{{ encryptId($wasterisk->id) }}"
                                                            value="{{ encryptId($wasterisk->id) }}"
                                                            @if (in_array($wasterisk->id, $riskdetails)) checked @endif disabled>
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
                                            <label for="ppe" class="form-label bold">PPE</label>
                                            <div class="row">
                                                @php
                                                    $ppedetails = string_to_array($wastecard->ppe);
                                                @endphp
                                                @foreach ($wasteppelist as $wasteppe)
                                                    <div class="col-md-2">
                                                        <input type="checkbox" name="ppe[]"
                                                            id="ppe_{{ encryptId($wasteppe->id) }}"
                                                            value="{{ encryptId($wasteppe->id) }}"
                                                            @if (in_array($wasteppe->id, $ppedetails)) checked @endif disabled>
                                                        <label
                                                            for="ppe_{{ encryptId($wasteppe->id) }}">{{ $wasteppe->item_name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="packagin_type" class="form-label bold">Packaging
                                                Type</label>
                                            <div>
                                                {{ getpackageName($wastecard->packaging_type) }}
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-input">
                                            <label class="form-label bold">Grouping System</label>
                                        </div>

                                        <div class="col-md-6 form-input">
                                            <label for="grouping_on_pallet" class="form-label bold">i) No. of
                                                Grouping on Pallet</label>
                                            <div>
                                                {{ $wastecard->grouping_on_pallet }}
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-input">
                                            <label for="stacking_allowed" class="form-label bold">ii) No. Stacking
                                                Allowed</label>
                                            <div>
                                                {{ $wastecard->stacking_allowed }}
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="pictogram_for_labelling" class="form-label bold">Pictogram
                                                for Labelling</label>
                                            <div>
                                                {{ $wastecard->pictogram_for_labelling }}
                                            </div>

                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="recommended_method_of_disposal"
                                                class="form-label bold">Recommended Method of Disposal</label>
                                            <div>
                                                {{ getItemName($wastecard->recommended_method_of_disposal) }}
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <div class="d-lg-flex align-items-center gap-3">

                                            <div class="position-relative">
                                                <h6 class="text-white">C. PRECAUTIONS IN CASE OF SPILL OR ACCIDENTAL
                                                    DISCHARGE CAUSING PERSONAL INJURY</h6>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row g-3 px-4 pt-4 mb-3">

                                        <div class="table-responsive">

                                            @php
                                                $precautionsdetails = json_decode($wastecard->precautions);
                                            @endphp
                                            <table class="table table-bordered table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th>Risk</th>
                                                        <th>Symptoms of Intoxication</th>
                                                        <th>First Aid</th>
                                                        <th>Guidelines for the Physician</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($precautionsdetails as $precaution)
                                                        <tr>
                                                            <td> {{ getItemName(decryptId($precaution->risk)) }}</td>
                                                            <td>{{ $precaution->symptoms }}</td>
                                                            <td>{{ $precaution->firstaid }}</td>
                                                            <td>{{ $precaution->guidephy }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="card-header card-header-inner ">
                                        <div class="d-lg-flex align-items-center gap-3">

                                            <div class="position-relative">
                                                <h6 class="text-white">D. STEPS TO BE TAKEN IN CASE OF SPILL OR
                                                    ACCIDENTAL DISCHARGE CAUSING MATERIAL DAMAGES ARISING FROM:</h6>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="row g-3 px-4 pt-4 mb-3">

                                        <div class="table-responsive">

                                            @php
                                                $materialdamages = json_decode($wastecard->material_damages);
                                            @endphp
                                            <table class="table table-bordered table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th>Spill on the Floor, Soil, Road, Water</th>
                                                        <th>Fire</th>
                                                        <th>Explosion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($materialdamages as $materialdamage)
                                                        <tr>
                                                            <td>{{ $materialdamage->spill }}</td>
                                                            <td>{{ $materialdamage->fire }}</td>
                                                            <td>{{ $materialdamage->explosion }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
