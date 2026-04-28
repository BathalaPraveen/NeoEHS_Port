@extends('admin.layouts.layout')
@section('title', 'Contractor Company Add')
@section('pageurl', admin_url('contractor/company/list'))

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
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('contractor/company/list') }}">Contractor Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Contractor Company Add</li>
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
                                    <h5 class="card-title">Contractor Company Add</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('contractor/company/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <form class="" id="contractor_company_add" novalidate method="POST"
                                action="{{ admin_url('contractor/company/add/submit') }}" enctype="multipart/form-data">
                                <div class="p-4 border rounded">
                                    <div class="row">
                                        @csrf

                                        <div class="col-md-4 form-input mb-3">
                                            <label for="con_comp_id" class="form-label require">Contractor Company
                                                ID</label>
                                            <input type="text" name="con_comp_id" class="form-control" id="con_comp_id"
                                                value="{{ getsequence('contractorcompanny') }}" readonly required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="con_comp_name" class="form-label require">Contractor Company
                                                Name</label>
                                            <input type="text" name="con_comp_name" class="form-control"
                                                id="con_comp_name" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">ROC/ROB Number</label>
                                            <input type="text" name="con_comp_roc" class="form-control" id="con_comp_roc"
                                                required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">SSM Certificate (PDF)</label>
                                            <input type="file" name="ssm_cerificate" class="form-control"
                                                accept="application/pdf" required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">Type of Business</label>
                                            <input type="text" name="type_of_business" class="form-control" required>
                                        </div>

                                        <div class="card-header card-header-inner mb-3">
                                            <h5>Contact Details</h5>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="con_comp_email" class="form-label require">Email</label>
                                            <input type="email" name="con_comp_email" class="form-control"
                                                id="con_comp_email" value="" required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label for="con_comp_phone" class="form-label require">Phone</label>
                                            <input type="text" name="con_comp_phone" class="form-control"
                                                id="con_comp_phone" value="" required>
                                        </div>

                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">Address Line 1</label>
                                            <input type="text" name="address_1" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">Address Line 2</label>
                                            <input type="text" name="address_2" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">Postcode</label>
                                            <input type="text" name="postcode" class="form-control" required>
                                        </div>
                                        <div class="col-md-4 form-input mb-3">
                                            <label class="form-label require">City</label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>
                                        <div class="mb-3 col-md-4 form-input">
                                            <label class="form-label require">State</label>
                                            <select name="state" id="state" class="form-control select2">
                                                <option value="" selected disabled> Select State</option>
                                                @foreach ($malaysiaStates as $state)
                                                    <option value="{{ $state->state_name }}">{{ $state->state_name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
        $(function() {
            $('#contractor_company_add').validate({
                rules: {
                    con_comp_id: {
                        required: true,
                    },
                    con_comp_name: {
                        required: true,
                    },
                    con_comp_email: {
                        required: true,
                        email: true,
                    },
                    con_comp_phone: {
                        required: true,
                        pattern: /^[0-9+\-\/()\[\]{} ]+$/
                    },
                    ssm_cerificate: {
                        required: true,
                    },
                    type_of_business: {
                        required: true,
                    },
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

                },
                messages: {
                    con_comp_id: {
                        required: "Please enter Contractor Company ID",
                    },
                    con_comp_name: {
                        required: "Please enter Contractor Company Name",
                    },
                    con_comp_email: {
                        required: "Please enter Email",
                        email: "Please enter valid Email"
                    },
                    con_comp_phone: {
                        required: "Please enter Phone Number",
                        pattern: "Please enter valid contact number"
                    },
                    ssm_cerificate: {
                        required: "Please upload the SSM Certificate."
                    },
                    type_of_business: {
                        required: "Please select the Type of Business."
                    },
                    con_comp_roc: {
                        required: "Please enter Roc Number",
                        remote: "ROC/ROB Number already exists"
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

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-input').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>
@endpush
