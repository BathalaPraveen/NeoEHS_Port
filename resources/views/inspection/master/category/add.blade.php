@extends('admin.layouts.layout')
@section('title', 'Inspection Checklist Add')
@section('pageurl', admin_url('inspection/master/checklistcategory/list'))

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
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('inspection/master/checklistcategory/list') }}">Checklist</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Inspection Checklist Add</li>
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
                                    <h5 class="card-title">Inspection Checklist Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('inspection/master/checklistcategory/list') }}"
                                        data-bs-toggle="tooltip" title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div>
                                <form action="{{ admin_url('inspection/master/checklistcategory/add/submit') }}"
                                    id="category_add" method="POST" novalidate>
                                    @csrf

                                    <div class="m-3">
                                        <div class="row mb-3">
                                            <label for="inputEnterYourName"
                                                class="col-sm-3 col-form-label require">Inspection Type</label>
                                            <div class="col-sm-4 form-input">
                                                <select name="inspectiontype" class="select2 form-control"
                                                    style="width: 100%">
                                                    <option value="">Select Inspection Type</option>
                                                    @foreach ($inspectiontypeList as $inspectiontype)
                                                        <option value="{{ encryptId($inspectiontype->id) }}">
                                                            {{ $inspectiontype->inspectiontype_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="category_name" class="col-sm-3 col-form-label require">Category
                                                Name</label>
                                            <div class="col-sm-9 form-input">
                                                <input type="text" name="category_name" class="form-control"
                                                    id="category_name" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-header card-header-inner mb-2">
                                        <div class="d-lg-flex align-items-center gap-3">

                                            <div class="position-relative">
                                                <h6 class="text-white">Check List Item</h6>
                                            </div>
                                            <div class="ms-auto">
                                                <button class="btn btn-primary" type="button" id="addmore">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="itemdetails">
                                        <div class="itemlist">
                                            <div class="row g-3  pt-1 mb-1">
                                                <div class="col-md-11 form-input">
                                                    <input type="text" name="itemlist[1]"
                                                        data-error="Please enter Checklist Item" id="itemlist_1"
                                                        class="form-control validate-input-required" >
                                                </div>
                                                <div class="col-md-1 form-input">
                                                    <div>
                                                        <i class="fa fa-trash removerow" style="cursor:pointer"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
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
    <script>

$(document).ready(function() {
            $('#addmore').on('click', function() {

                $('#addmore').attr("disabled", true);
                var rowCount = $("#itemdetails .itemlist").length;

                if (rowCount >= 100) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sorry!',
                        text: 'Maximum 100 records only add',
                    })
                    return true;
                }

                var newRow = $(".itemlist").first().clone();

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

                $("#itemdetails").append(newRow);


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
            if ($("#itemdetails .itemlist").length > 1) {
                $('#addmore').attr("disabled", false);
                $(this).closest(".itemlist").remove();

                $("#itemdetails .itemlist").each(function(index) {

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

        // $(".select2").select2({
        //     dropdownParent: $('#popupwindowmodal')
        // });

        $(function() {
            $('#category_add').validate({
                rules: {

                    activity: {
                        required: true,
                    },
                    category_name: {
                        required: true,
                    },
                },
                messages: {
                    activity: {
                        required: "Please select Activity",
                    },
                    category_name: {
                        required: "Please enter Category Name",
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
