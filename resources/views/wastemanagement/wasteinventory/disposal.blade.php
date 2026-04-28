@extends('admin.layouts.layout')
@section('title', 'Waste Inventory Disposal')
@section('pageurl', admin_url('wastemanagement/' . $companyname . '/wasteregister/list'))

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
                                <a href="{{ admin_url('wastemanagement/' . $companyname . '/wasteregister/list') }}">Waste
                                    Inventory</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Waste Inventory Disposal</li>
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
                                    <h5 class="card-title">Waste Inventory Disposal</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('wastemanagement/' . $companyname . '/wasteinventory/list') }}"
                                        data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="useeuact_add" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('wastemanagement/' . $companyname . '/wasteinventory/disposal/submit') }}">

                                <div class=" border rounded ">
                                    <div class="">
                                        @csrf
                                        <input type="hidden" name="companyname" value="{{ $companyname }}">
                                        <div class="card-header card-header-inner ">
                                            <div class="d-lg-flex align-items-center gap-3">

                                                <div class="position-relative">
                                                    <h6 class="text-white">Waste Disposal</h6>
                                                </div>
                                                <div class="ms-auto">
                                                    <button class="btn btn-primary" type="button"
                                                        id="addmore">Add</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="wastedetaillist">
                                            <div class="wastedetail">
                                                <div class="row g-3 px-4 pt-4 mb-3">

                                                    <div class="col-md-4 form-input">
                                                        <label for="waste_code" class="form-label require">Waste
                                                            Code</label>
                                                        <select name="wastesdisposal[1][waste_code]"
                                                            id="wastesdisposal_1_waste_code"
                                                            class="form-control waste_code select2 validate-select-required"
                                                            data-error="Please select Wastte Code">
                                                            <option value="">Please Select Waste Code</option>
                                                            @foreach ($inventorylist as $inventory)
                                                                <option value="{{ encryptId($inventory->id) }}"
                                                                    data-name='{{ $inventory->wastetype_name }}'
                                                                    data-generationdate='{{ displaydateformat($inventory->generation_date) }}'
                                                                    data-locationname='{{ getItemName($inventory->location) }}'
                                                                    data-quantity='{{ $inventory->quantity }}'
                                                                    data-typeofpacking='{{ getpackageName($inventory->type_of_packing) }}'
                                                                    data-estimatedweight='{{ $inventory->estimated_weight }}'>
                                                                    {{ $inventory->wastetype_id }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="waste_name" class="form-label require">Waste
                                                            Name</label>
                                                        <input type="text" name="wastesdisposal[1][waste_name]"
                                                            id="wastesdisposal_1_waste_name"

                                                            class="form-control validate-input-required"
                                                            data-error="Waste Name is required" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="generation_date" class="form-label require">Generation
                                                            Date</label>
                                                        <input type="text" name="wastesdisposal[1][generation_date]"
                                                            id="wastesdisposal_1_generationdate"
                                                            data-error="Please select Generation Date"
                                                            class="form-control validate-input-required" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="location" class="form-label require">Location</label>
                                                        <input type="text" name="wastesdisposal[1][location]"
                                                            id="wastesdisposal_1_locationname"
                                                            class="form-control validate-input-required"
                                                            data-error="Please enter Location" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="quantity" class="form-label require">Quantity</label>
                                                        <input type="text" name="wastesdisposal[1][quantity]"
                                                            id="wastesdisposal_1_quantity"
                                                            class="form-control validate-input-required"
                                                            data-error="Please enter Quantity" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="type_of_packaging" class="form-label require">Type of
                                                            Packaging</label>
                                                        <input type="text" name="wastesdisposal[1][type_of_packaging]"
                                                            id="wastesdisposal_1_typeofpacking"
                                                            data-error="Please enter Type of Packaging"
                                                            class="form-control validate-input-required" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="estimated_weight" class="form-label require">Estimated
                                                            Weight (MT)</label>
                                                        <input type="text" name="wastesdisposal[1][estimated_weight]"
                                                        data-error="Estimated Weight (MT) is required"
                                                            id="wastesdisposal_1_estimatedweight"
                                                            class="form-control validate-input-required" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="disposal_date" class="form-label require">Disposal Date</label>
                                                        <div class="input-group">
                                                            <input type="text" name="wastesdisposal[1][disposal_date]"
                                                                id="wastesdisposal_1_disposal_date" readonly=""
                                                                data-error="Please select Disposal Date"
                                                                class="form-control  notificationdate validate-input-required">
                                                            <div class="input-group-append" id="inspectiondate-show">
                                                                <span class="input-group-text fas fa-calendar"
                                                                    style="height:37px;padding-top:10px;cursor: pointer;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="disposal_qty" class="form-label require">Disposal Quantity</label>
                                                        <input type="text" name="wastesdisposal[1][disposal_qty]"
                                                        data-error="Please enter Disposal Quantity"
                                                            id="wastesdisposal_1_disposal_qty"
                                                            class="form-control disposal_qty validate-input-required">
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label for="balance_qty"
                                                            class="form-label require">Balance</label>
                                                        <input type="text" name="wastesdisposal[1][balance_qty]"
                                                        data-error="Blance Qty is required"
                                                            id="wastesdisposal_1_balance_qty" class="form-control validate-input-required"
                                                            readonly >
                                                    </div>


                                                </div>
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
        $(document).ready(function() {
            $('#addmore').on('click', function() {

                $('#addmore').attr("disabled", true);
                var rowCount = $("#wastedetaillist .wastedetail").length;

                if (rowCount >= 10) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 10 records only add',
                    })
                    return true;
                }

                var newRow = $(".wastedetail").first().clone();

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

                $("#wastedetaillist").append(newRow);


                newRow.find(".select2").select2();

                $(".select2").select2();
                $('#addmore').attr("disabled", false);

                $(".notificationdate").datepicker({

                    format: "dd-mm-yyyy",
                    autoclose: true,
                    orientation: "bottom",
                    todayHighlight: true,
                    daysOfWeekDisabled: [0, 6],

                });

            });
        });

        $(document).on('click', '.removerow', function() {
            if ($("#wastedetaillist .wastedetail").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".wastedetail").remove();

                $("#wastedetaillist .wastedetail").each(function(index) {

                    newIndex = index + 1;
                    $(this).find("input[type='text']").each(function() {
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

        $(document).on('change', '.waste_code', function() {

            var currentId = $(this).attr('id');
            var idParts = currentId.split('_');
            var rowId = idParts[1];

            var wastetypeId = $(this).val();

            if (wastetypeId != '') {
                var selectedOption = this.options[this.selectedIndex];
                var dataname = selectedOption.getAttribute('data-name');
                var generationdate = selectedOption.getAttribute('data-generationdate');
                var locationname = selectedOption.getAttribute('data-locationname');
                var quantity = selectedOption.getAttribute('data-quantity');
                var typeofpacking = selectedOption.getAttribute('data-typeofpacking');
                var estimatedweight = selectedOption.getAttribute('data-estimatedweight');

                console.log(generationdate);
                $('#wastesdisposal_' + rowId + '_waste_name').val(dataname);
                $('#wastesdisposal_' + rowId + '_generationdate').val(generationdate);
                $('#wastesdisposal_' + rowId + '_locationname').val(locationname);
                $('#wastesdisposal_' + rowId + '_quantity').val(quantity);
                $('#wastesdisposal_' + rowId + '_typeofpacking').val(typeofpacking);
                $('#wastesdisposal_' + rowId + '_estimatedweight').val(estimatedweight);
            } else {
                $('#wastesdisposal_' + rowId + '_waste_name').val("");
                $('#wastesdisposal_' + rowId + '_generationdate').val("");
                $('#wastesdisposal_' + rowId + '_locationname').val("");
                $('#wastesdisposal_' + rowId + '_quantity').val("");
                $('#wastesdisposal_' + rowId + '_typeofpacking').val("");
                $('#wastesdisposal_' + rowId + '_estimatedweight').val("");
            }
        });

        // $(document).on('change', '.disposal_qty', function() {
        //     calculate_weight();
        // });


        $(document).on('change', '.disposal_qty', function() {

            var currentId = $(this).attr('id');
            var idParts = currentId.split('_');
            var rowId = idParts[1];

            var quantity = parseInt($('#wastesdisposal_' + rowId + '_disposal_qty').val());
            var currentqty = parseInt($('#wastesdisposal_' + rowId + '_quantity').val());

            balanceweight = currentqty;

            console.log(currentqty, quantity);

            if (currentqty != '' && currentqty != '') {

                console.log(currentqty , quantity);

                if (currentqty < quantity) {
                    $('#wastesdisposal_' + rowId + '_disposal_qty').val("");
                    swal.fire("Disposal Quantity is less than or equal to Current Quantity", '', 'error');

                } else {
                    balanceweight = currentqty - quantity;

                    if (isNaN(quantity)) {
                        balanceweight = currentqty;
                    } else {
                        balanceweight = parseFloat(balanceweight.toFixed(4));
                    }
                }
            }


            $('#wastesdisposal_' + rowId + '_balance_qty').val(balanceweight);
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

        $.validator.addMethod("notZeroOrLess", function(value, element) {
            return this.optional(element) || (parseFloat(value) !== 0 && parseFloat(value) > 0);
        }, "Please enter a value not equal to 0 and not less than 0.");


        $(function() {
            $('#useeuact_add').validate({
                rules: {
                    waste_code: {
                        required: true,
                    },
                    waste_name: {
                        required: true,
                    },
                    generation_date: {
                        required: true,
                    },
                    location: {
                        required: true,
                    },
                    quantity: {
                        required: true,
                    },
                    type_of_packaging: {
                        required: true,
                    },
                    estimated_weight: {
                        required: true,
                    },
                    disposal_date: {
                        required: true,
                    },
                    disposal_qty: {
                        required: true,
                    },
                    balance_qty: {
                        required: true,
                        notZeroOrLess: true
                    },
                },
                messages: {
                    waste_code: {
                        required: "Please select Waste Code",
                    },
                    waste_name: {
                        required: "Waste Name is required",
                    },
                    generation_date: {
                        required: "Generation date is required",
                    },
                    location: {
                        required: "Locatio is required",
                    },
                    quantity: {
                        required: "Quantity is required",
                    },
                    type_of_packaging: {
                        required: "Type of packaging is required",
                    },
                    estimated_weight: {
                        required: "Estimated Weight is required",
                    },
                    disposal_date: {
                        required: "Please select Disposal Date",
                    },
                    disposal_qty: {
                        required: "Please enter Disposal Qty",
                    },
                    balance_qty: {
                        required: "Balance Qty is required",
                        notZeroOrLess: 'please enter valid qty'
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
    </script>
@endpush
