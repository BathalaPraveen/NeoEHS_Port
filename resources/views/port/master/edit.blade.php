@extends('admin.layouts.layout')
@section('title', 'Edit Port Security Access')
@section('pageurl', admin_url('portsecurity/master/list'))

@push('style')
    <style>
        input[type="text"] {
            text-transform: uppercase;
        }

        textarea {
            text-transform: uppercase;
        }

        .col-md-3 label {
            font-weight: bold;
        }

        .competency-main-card {
            border: 1px solid #dce3ea !important;
            background: #fff;
        }

        .competency-header {
            background: #0d5cab;
            padding: 15px 20px;
            border-radius: 8px;
        }

        .competency-row {
            border: 1px solid #dbe4ee;
            background: #f8fafc;
            border-radius: 10px;
            position: relative;
            transition: 0.3s;
            padding: 20px !important;
        }

        .competency-row:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .addMorcerti {
            background: #28a745 !important;
            border: none !important;
            color: #fff !important;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
        }

        .addMorcerti i {
            color: #fff !important;
            margin-right: 6px;
        }

        .removeCompetency {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none !important;
            background: #dc3545 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 99;
            transition: all .3s ease;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.35);
        }

        .removeCompetency:hover {
            background: #b02a37 !important;
            transform: scale(1.05);
        }

        .removeCompetency i {
            color: #fff !important;
            font-size: 16px !important;
        }

        .fileinput-preview img {
            object-fit: contain;
        }
    </style>
@endpush

@section('content')

    <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">
                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                Port Security Access
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('portsecurity/master/list') }}">Port Security Access List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Port Security Access</li>
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
                                    <h5 class="card-title">Edit Port Security Access</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ admin_url('portsecurity/master/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="port_edit" novalidate method="POST" enctype="multipart/form-data"
                                action="{{ admin_url('portsecurity/master/edit/submit') }}">
                                @csrf
                                <input type="hidden" name="edit_id" value="{{ encryptId($editData->id) }}">

                                <div class="p-4 border rounded">
                                    <div class="row g-3">
                                        <div class="card-header card-header-inner">
                                            <h6 class="text-white text-uppercase">Port Security Access</h6>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="unique_id" class="form-label require">Unique Id</label>
                                            <input type="text" name="unique_id" class="form-control" readonly
                                                id="unique_id" value="{{ $editData->unique_id }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="name" class="form-label require">Name</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="{{ $editData->name }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="id_type" class="form-label require">ID Type</label>
                                            <select name="id_type" id="id_type" required
                                                class="form-control select2 othersshow">
                                                <option value="">Select ID Type</option>
                                                <option value="1" {{ $editData->id_type == 1 ? 'selected' : '' }}>IC No</option>
                                                <option value="2" {{ $editData->id_type == 2 ? 'selected' : '' }}>Passport No</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="passport_number" class="form-label require">IC/Passport No</label>
                                            <input type="text" name="passport_number" class="form-control"
                                                id="passport_number" value="{{ $editData->passport_number }}" required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="company_id" class="form-label require">Company</label>
                                            <select name="company_id" id="company_id" class="form-control select2">
                                                <option value="">Select Company</option>
                                                @foreach ($companyList as $company)
                                                    <option value="{{ encryptId($company->id) }}"
                                                        data-address="{{ $company->address }}"
                                                        data-city="{{ $company->city }}"
                                                        data-state="{{ $company->state }}"
                                                        data-pincode="{{ $company->pincode }}"
                                                        data-dosh="{{ $company->dosh_reg_no }}"
                                                        data-roc="{{ $company->roc_no }}"
                                                        data-cos="{{ $company->code_of_sector }}"
                                                        data-coi="{{ $company->class_of_industry }}"
                                                        {{ $editData->company_id == $company->id ? 'selected' : '' }}>
                                                        {{ $company->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label require">Location</label>
                                            <select name="location" id="location" required class="form-control select2">
                                                <option value="">Select Location</option>
                                                {{-- Populated via AJAX on page load --}}
                                            </select>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="designation_id" class="form-label require">Designation</label>
                                            <select name="designation_id" id="designation_id" class="form-control select2">
                                                <option value="">Select Designation</option>
                                                @foreach ($designationList as $designation)
                                                    <option value="{{ encryptId($designation->id) }}"
                                                        {{ $editData->designation_id == $designation->id ? 'selected' : '' }}>
                                                        {{ $designation->designation_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="induction_date" class="form-label require">Induction Date</label>
                                            <input type="text" name="induction_date"
                                                class="form-control prep_date datepicker" id="induction_date"
                                                value="{{ $editData->induction_date ? \Carbon\Carbon::parse($editData->induction_date)->format('d-m-Y') : '' }}"
                                                readonly>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="induction_duedate" class="form-label require">Induction Due Date</label>
                                            <input type="text" name="induction_duedate"
                                                class="form-control prep_date datepicker" id="induction_duedate"
                                                value="{{ $editData->induction_duedate ? \Carbon\Carbon::parse($editData->induction_duedate)->format('d-m-Y') : '' }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- Other Competency Details --}}
                                <div class="p-4 border rounded mt-3 competency-main-card">
                                    <div class="d-flex justify-content-between align-items-center competency-header mb-3">
                                        <h6 class="text-white mb-0 text-uppercase">Other Competency Details</h6>
                                        <button type="button" class="btn btn-success btn-sm addMorcerti">
                                            <i class="fa fa-plus-circle"></i> Add More
                                        </button>
                                    </div>

                                    <div id="competencyContainer">

                                        @if ($competencyList->isEmpty())
                                            {{-- Default empty row when no data --}}
                                            <div class="competency-row card shadow-sm mb-3 p-3 border-0">
                                                <div class="row g-3">
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" name="cert_name[]"
                                                            class="form-control cert_name">
                                                    </div>
                                                    <div class="col-md-4 form-input">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="text" name="cert_start_date[]"
                                                            class="form-control datepicker cert_start_date" readonly>
                                                    </div>
                                                    <div class="col-md-4 form-input pe-5" style="padding-right:70px;">
                                                        <label class="form-label">End Date</label>
                                                        <input type="text" name="cert_end_date[]"
                                                            class="form-control datepicker cert_end_date" readonly>
                                                    </div>
                                                    <div class="col-md-4 mt-2 form-input">
                                                        <label class="form-label">Competency Certificate</label>
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview img-thumbnail"
                                                                data-trigger="fileinput"
                                                                style="width:200px;height:150px;overflow:hidden;">
                                                                <img src="{{ url('public/assets/images/common/camera.png') }}"
                                                                    style="width:100%;height:100%;object-fit:contain;">
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="btn-file">
                                                                    <span class="btn btn-primary btn-sm fileinput-new">Upload Attachment</span>
                                                                    <span class="btn btn-warning btn-sm fileinput-exists">Change</span>
                                                                    <input type="file" name="other_competency_certi[]"
                                                                        class="form-control other_competency_certi">
                                                                </span>
                                                            </div>
                                                            <span class="text-danger other_competency_certi_error"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @else
                                            {{-- Existing competency rows from DB --}}
                                            @foreach ($competencyList as $cert)
                                                <div class="competency-row card shadow-sm mb-3 p-3 border-0">

                                                    <input type="hidden" name="cert_id[]" value="{{ encryptId($cert->id) }}">

                                                    <button type="button" class="removeCompetency">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>

                                                    <div class="row g-3">
                                                        <div class="col-md-4 form-input">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" name="cert_name[]"
                                                                class="form-control cert_name"
                                                                value="{{ $cert->cert_name }}">
                                                        </div>
                                                        <div class="col-md-4 form-input">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="text" name="cert_start_date[]"
                                                                class="form-control datepicker cert_start_date"
                                                                value="{{ $cert->cert_start_date ? \Carbon\Carbon::parse($cert->cert_start_date)->format('d-m-Y') : '' }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-4 form-input" style="padding-right:70px;">
                                                            <label class="form-label">End Date</label>
                                                            <input type="text" name="cert_end_date[]"
                                                                class="form-control datepicker cert_end_date"
                                                                value="{{ $cert->cert_end_date ? \Carbon\Carbon::parse($cert->cert_end_date)->format('d-m-Y') : '' }}"
                                                                readonly>
                                                        </div>
                                                        <div class="col-md-4 mt-2 form-input">

    <label class="form-label">Competency Certificate</label>

    <div class="fileinput {{ $cert->cert_path ? 'fileinput-exists' : 'fileinput-new' }}"
        data-provides="fileinput">

        <div class="fileinput-preview img-thumbnail"
            data-trigger="fileinput"
            style="width:200px;height:150px;overflow:hidden;">

            @if ($cert->cert_path)

                @php
                    $extension = strtolower(pathinfo($cert->cert_path, PATHINFO_EXTENSION));
                @endphp

                <a href="{{ asset('public/'.$cert->cert_path) }}" target="_blank">

                    @if(in_array($extension, ['jpg','jpeg','png','gif','webp']))

                        <img src="{{ asset('public/'.$cert->cert_path) }}"
                            style="width:100%;height:100%;object-fit:contain;">

                    @elseif($extension == 'pdf')

                        <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png"
                            style="width:100%;height:100%;object-fit:contain;">


                    @else

                        <img src="{{ url('public/assets/images/common/camera.png') }}"
                            style="width:100%;height:100%;object-fit:contain;">

                    @endif

                </a>

            @else

                <img src="{{ url('public/assets/images/common/camera.png') }}"
                    style="width:100%;height:100%;object-fit:contain;">

            @endif

        </div>

        <div class="mt-2">

            <span class="btn-file">

                <span class="btn btn-primary btn-sm fileinput-new">
                    Upload Attachment
                </span>

                <span class="btn btn-warning btn-sm fileinput-exists">
                    Change
                </span>

                <input type="file"
                    name="other_competency_certi[]"
                    class="form-control other_competency_certi">

            </span>

        </div>

        <span class="text-danger other_competency_certi_error"></span>

    </div>

</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger" data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary" type="submit" data-bs-toggle="tooltip"
                                            title="Submit">Update</button>
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

        // Pre-load location dropdown on page load based on saved company
        $(document).ready(function () {

            var companyId  = '{{ encryptId($editData->company_id) }}';
            var savedLocation = '{{ $editData->location }}';

            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('location/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#location').empty().append('<option value="">Select Location</option>');
                        $.each(data, function (key, value) {
                            var selected = (value.id == savedLocation) ? 'selected' : '';
                            $('#location').append(
                                '<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>'
                            );
                        });
                        $('#location').trigger('change.select2');
                    }
                });
            }

            // Init datepickers for all existing competency rows
            $('.competency-row').each(function () {
                initializeDateValidation($(this));
            });

        });

        // Company change → reload locations
        $('select[name=company_id]').change(function () {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('location/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#location').empty().append('<option value="">Select Location</option>');
                        $.each(data, function (key, value) {
                            $('#location').append(
                                '<option value="' + value.id + '">' + value.name + '</option>'
                            );
                        });
                        $('#location').trigger('change.select2');
                    }
                });
            } else {
                $('#location').empty().append('<option value="">Select Location</option>');
                $('#location').trigger('change.select2');
            }
        });

        // Form validation
        $(function () {

            $.validator.addMethod("noSpace", function (value, element) {
                return value.trim().length > 0 && value.indexOf(" ") !== 0;
            }, "First space is not allowed");

            $('#port_edit').validate({

                ignore: [],

                rules: {
                    unique_id:        { required: true },
                    name:             { required: true, noSpace: true },
                    id_type:          { required: true },
                    passport_number:  { required: true, noSpace: true },
                    company_id:       { required: true },
                    location:         { required: true },
                    designation_id:   { required: true },
                    induction_date:   { required: true },
                    induction_duedate:{ required: true }
                },

                messages: {
                    unique_id:         { required: "Please enter Unique ID" },
                    name:              { required: "Please enter Name", noSpace: "First space is not allowed" },
                    id_type:           { required: "Please select ID Type" },
                    passport_number:   { required: "Please enter IC/Passport No", noSpace: "First space is not allowed" },
                    company_id:        { required: "Please select Company" },
                    location:          { required: "Please select Location" },
                    designation_id:    { required: "Please select Designation" },
                    induction_date:    { required: "Please select Induction Date" },
                    induction_duedate: { required: "Please select Induction Due Date" }
                },

                errorElement: 'span',

                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },

                highlight: function (element) {
                    $(element).addClass('is-invalid');
                    $(element).closest(".form-input").addClass("selecterror");
                },

                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                    $(element).closest(".form-input").removeClass("selecterror");
                }

            });

        });

        // Datepicker with start/end date cross-validation per row
        function initializeDateValidation(row) {

            let startDate = row.find('.cert_start_date');
            let endDate   = row.find('.cert_end_date');

            startDate.datepicker('destroy');
            endDate.datepicker('destroy');

            startDate.datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function (selected) {
                let start = selected.date;
                endDate.datepicker('setStartDate', start);
                let end = endDate.datepicker('getDate');
                if (end && end < start) {
                    endDate.val('');
                }
            });

            endDate.datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function (selected) {
                let end = selected.date;
                startDate.datepicker('setEndDate', end);
                let start = startDate.datepicker('getDate');
                if (start && start > end) {
                    startDate.val('');
                }
            });

            // If editing existing row with pre-filled dates, set limits immediately
            let existingStart = startDate.val();
            let existingEnd   = endDate.val();

            if (existingStart) {
                let parsedStart = startDate.datepicker('getDate');
                if (parsedStart) {
                    endDate.datepicker('setStartDate', parsedStart);
                }
            }

            if (existingEnd) {
                let parsedEnd = endDate.datepicker('getDate');
                if (parsedEnd) {
                    startDate.datepicker('setEndDate', parsedEnd);
                }
            }
        }

        // Add more competency row
        $(document).off('click.addCompetency').on('click.addCompetency', '.addMorcerti', function (e) {

            e.preventDefault();
            e.stopImmediatePropagation();

            let html = `
    <div class="competency-row card shadow-sm mb-3 p-3 border-0">

        <input type="hidden" name="cert_id[]" value="">

        <button type="button" class="removeCompetency">
            <i class="fas fa-trash-alt"></i>
        </button>

        <div class="row g-3">

            <div class="col-md-4 form-input">
                <label class="form-label">Name</label>
                <input type="text" name="cert_name[]" class="form-control cert_name">
            </div>

            <div class="col-md-4 form-input">
                <label class="form-label">Start Date</label>
                <input type="text" name="cert_start_date[]" class="form-control datepicker cert_start_date" readonly>
            </div>

            <div class="col-md-4 form-input" style="padding-right:70px;">
                <label class="form-label">End Date</label>
                <input type="text" name="cert_end_date[]" class="form-control datepicker cert_end_date" readonly>
            </div>

            <div class="col-md-4 mt-2 form-input">
                <label class="form-label">Competency Certificate</label>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput"
                        style="width:200px;height:150px;overflow:hidden;">
                        <img src="{{ url('public/assets/images/common/camera.png') }}"
                            style="width:100%;height:100%;object-fit:contain;">
                    </div>
                    <div class="mt-2">
                        <span class="btn-file">
                            <span class="btn btn-primary btn-sm fileinput-new">Upload Attachment</span>
                            <span class="btn btn-warning btn-sm fileinput-exists">Change</span>
                            <input type="file" name="other_competency_certi[]" class="form-control other_competency_certi">
                        </span>
                    </div>
                    <span class="text-danger other_competency_certi_error"></span>
                </div>
            </div>

        </div>
    </div>`;

            $('#competencyContainer').append(html);
            let newRow = $('#competencyContainer .competency-row').last();
            initializeDateValidation(newRow);
        });

        // Remove competency row
        $(document).on('click', '.removeCompetency', function () {
            $(this).closest('.competency-row').remove();
        });

    </script>
@endpush