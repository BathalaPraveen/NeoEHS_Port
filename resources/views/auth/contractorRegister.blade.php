@extends('layouts.login')
@section('title', 'Login')
@section('content')
    @push('style')
        <style>
            .login-btn {
                background-color: #009B9C !important;
                color: white !important;
                border-radius: 30px !important;
            }

            .login-btn:hover,
            .login-btn:focus,
            .login-btn:active,
            .login-btn.active {
                background-color: #066D6D !important;
                color: white !important;
            }

            .form-wrapper {
                max-width: 600px;
                margin: auto;
            }

            .step-group {
                transition: all 0.3s ease-in-out;
            }

            .step-circle {
                width: 35px;
                height: 35px;
                border-radius: 50%;
                background-color: #ccc;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
            }

            .step-circle.valid {
                background-color: #28a745;
            }

            .step-circle.error {
                background-color: #dc3545;
            }

            .require::after {
                content: " *";
                color: red;
                font-size: 1rem
            }
        </style>
    @endpush

    <form id="cont_reg_form" action="{{ admin_url('contractor/registration/submit') }}" method="post"
        enctype="multipart/form-data" autocomplete="false">
        @csrf

        <div class="step-indicator mb-3 d-flex justify-content-center gap-3">
            <div class="step-circle" data-step="0">1</div>
            <div class="step-circle" data-step="1">2</div>
            <div class="step-circle" data-step="2">3</div>
            <div class="step-circle" data-step="3">4</div>
            <div class="step-circle" data-step="4">5</div>
        </div>

        <div class="card p-4 shadow-sm rounded form-wrapper mb-5">
            <div class="step-group" data-step="0">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">Company Information</h5>
                    <a href="{{ admin_url('login') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Login
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label require">Company ID</label>
                    <input type="text" name="con_comp_id" class="form-control"
                        value="{{ getsequence('contractorcompanny') }}" readonly required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">Company Name (SSM)</label>
                    <input type="text" name="con_comp_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">ROC/ROB Number</label>
                    <input type="text" name="con_comp_roc" class="form-control" id="con_comp_roc" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">SSM Certificate (PDF)</label>
                    <input type="file" name="ssm_cerificate" class="form-control" accept="application/pdf" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">Type of Business</label>
                    <input type="text" name="type_of_business" class="form-control" required>
                </div>
            </div>

            <div class="step-group d-none" data-step="1">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">Company Address</h5>
                    <a href="{{ admin_url('login') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Login
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label require">Address Line 1</label>
                    <input type="text" name="address_1" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address Line 2</label>
                    <input type="text" name="address_2" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label require">Postcode</label>
                    <input type="text" name="postcode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">State</label>
                    <select name="state" id="state" class="form-control select2">
                        <option value="" selected disabled> Select State</option>
                        @foreach ($malaysiaStates as $state)
                            <option value="{{ $state->state_name }}">{{ $state->state_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="step-group d-none" data-step="2">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">Company Contact</h5>
                    <a href="{{ admin_url('login') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Login
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label">Office Phone</label>
                    <input type="text" name="con_comp_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label require">Company Email</label>
                    <input type="email" name="con_comp_email" class="form-control" required>
                </div>
            </div>

            <div class="step-group d-none" data-step="3">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">Person in Charge (PIC)</h5>
                    <a href="{{ admin_url('login') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Login
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label require">PIC Name</label>
                    <input type="text" name="pic_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">PIC Designation</label>
                    <input type="text" name="pic_designation" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label require">PIC Email</label>
                    <input type="email" name="pic_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="con_phone_no" class="form-control">
                </div>
            </div>
            <div class="step-group d-none" data-step="4">
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">Person in Charge (PIC)</h5>
                    <a href="{{ admin_url('login') }}"
                        class="btn btn-outline-primary btn-sm d-flex align-items-center shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i> Login
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label require">ID Type</label>
                    <select name="id_type" id="id_type" class="form-control select2" required>
                        <option value="">Select ID Type</option>
                        <option value="{{ encryptId(1) }}">IC Number</option>
                        <option value="{{ encryptId(2) }}">Passport Number</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label require">IC Number or Passport Number</label>
                    <input type="text" name="con_mc_or_passport_no" class="form-control" required>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" id="prevBtn">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                <button type="submit" class="btn btn-success d-none" id="submitBtn">Submit</button>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            let currentStep = 0;
            const steps = $('.step-group');
            const indicators = $('.step-circle');

            function showStep(step) {
                steps.addClass('d-none');
                $(`.step-group[data-step="${step}"]`).removeClass('d-none');
                $('#prevBtn').prop('disabled', step === 0);
                $('#nextBtn').toggleClass('d-none', step === steps.length - 1);
                $('#submitBtn').toggleClass('d-none', step !== steps.length - 1);
            }

            function updateIndicator(step, isValid) {
                const indicator = indicators.eq(step);
                indicator.removeClass('bg-secondary bg-success bg-danger');
                if (isValid) {
                    indicator.addClass('bg-success');
                } else {
                    indicator.addClass('bg-danger');
                }
            }

            function validateStep(step) {
                const inputs = $(`.step-group[data-step="${step}"] :input`);
                let isValid = true;
                inputs.each(function() {
                    if (!$(this).valid()) {
                        isValid = false;
                    }
                });
                updateIndicator(step, isValid);
                return isValid;
            }

            $('#nextBtn').click(function() {
                if (validateStep(currentStep)) {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                }
            });

            $('#prevBtn').click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            $('#cont_reg_form').validate({
                rules: {
                    con_comp_roc: {
                        required: true,
                        remote: {
                            url: '{{ admin_url('contractor/company/roc_unique') }}',
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                con_comp_roc: function() {
                                    return $('#con_comp_roc').val();
                                }
                            }
                        }
                    },
                    conReg: {
                        required: true,
                    },
                    con_comp_name: {
                        required: true,
                    },
                    ssm_cerificate: {
                        required: true,
                    },
                    type_of_business: {
                        required: true,
                    },
                    address_1: {
                        required: true,
                    },
                    postcode: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    con_comp_email: {
                        required: true,
                    },
                    pic_name: {
                        required: true,
                    },
                    pic_designation: {
                        required: true,
                    },
                    pic_email: {
                        required: true,
                    },
                    con_phone_no: {
                        // required: true,
                    },
                    id_type: {
                        required: true,
                    },
                    con_mc_or_passport_no: {
                        required: true,
                        customPassportID: true,
                    },
                },
                messages: {
                    con_comp_roc: {
                        required: "Please enter Roc Number",
                        remote: "ROC/ROB Number already exists"
                    },
                    conReg: {
                        required: "Please enter the Contractor Registration Number."
                    },
                    con_comp_name: {
                        required: "Please enter the Company Name."
                    },
                    ssm_cerificate: {
                        required: "Please upload the SSM Certificate."
                    },
                    type_of_business: {
                        required: "Please select the Type of Business."
                    },
                    address_1: {
                        required: "Please enter the Address."
                    },
                    postcode: {
                        required: "Please enter the Postcode."
                    },
                    city: {
                        required: "Please enter the City."
                    },
                    state: {
                        required: "Please select the State."
                    },
                    con_comp_email: {
                        required: "Please enter the Company Email."
                    },
                    pic_name: {
                        required: "Please enter the PIC Name."
                    },
                    pic_designation: {
                        required: "Please enter the PIC Designation."
                    },
                    pic_email: {
                        required: "Please enter the PIC Email."
                    },
                    con_phone_no: {
                        // required: "Please enter the Contact Phone Number."
                    },
                    id_type: {
                        required: "Please select the ID Type."
                    },
                    con_mc_or_passport_no: {
                        required: "Please enter the MyKad or Passport Number.",
                    },
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function(error, element) {
                    error.appendTo(element.closest('div'));
                },
            });

            showStep(currentStep);
        });
    </script>
@endpush
