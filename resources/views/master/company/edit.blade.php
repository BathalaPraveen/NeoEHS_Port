@extends('admin.layouts.layout')
@section('title', 'Company Edit')
@section('pageurl', admin_url('company/list'))

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
                                <a href="{{ admin_url('company/list') }}">Company</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Company Edit</li>
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
                                    <h5 class="card-title">Company Edit</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('company/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <form class="" id="company_edit" novalidate method="POST"
                                action="{{ admin_url('company/edit/submit') }}">

                                <div class="p-4 border rounded">
                                    <div class="row g-3"> <input type="hidden" name="id" id="id"
                                            value="{{ encryptId($company->id) }}">
                                        @csrf

                                        <div class="col-md-4 form-input">
                                            <label for="company_id" class="form-label require">Company
                                                ID</label>
                                            <input type="text" name="company_id" class="form-control" id="company_id"
                                                value="{{ $company->company_id }}" readonly required>
                                        </div>

                                        <div class="col-md-4 form-input">
                                            <label for="company_name" class="form-label require">Company
                                                Name</label>
                                            <input type="text" name="company_name" class="form-control"
                                                value="{{ $company->company_name }}" id="company_name" value=""
                                                required>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="company_shortname" class="form-label require">Company
                                                Short Name</label>
                                            <input type="text" name="company_shortname" class="form-control"
                                                value="{{ $company->company_shortname }}" id="company_shortname"
                                                value="" required>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="roc_no" class="form-label require">Company ROC Number</label>
                                            <input type="text" name="roc_no" class="form-control"
                                                value="{{ $company->roc_no }}" id="roc_no" value="" required>
                                        </div>

                                        <div class="col-md-3 form-input">
                                            <label for="dosh_reg_no" class="form-label require">DOSH Registration No</label>
                                            <input type="text" name="dosh_reg_no" class="form-control"
                                                value="{{ $company->dosh_reg_no }}" id="dosh_reg_no" value="" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="row card-bottom">
                                    <div class="col-12 mt-2 mb-3">
                                        <hr>
                                        <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                            title="Reset">Reset</button>
                                        <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                            title="Update">Update</button>
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
            $('#company_edit').validate({
                rules: {

                    company_id: {
                        required: true,
                    },
                    company_name: {
                        required: true,
                    },
                    company_shortname: {
                        required: true,
                    },
                    dosh_reg_no: {
                        required: true,
                    },
                    roc_no: {
                        remote: {
                            url: '{{ admin_url('company/roc_unique') }}',
                            type: 'post',
                            data: {
                                _token: "{{ csrf_token() }}",
                                roc_no: function() {
                                    return $('#roc_no').val();
                                },
                                id: function() {
                                    return $('#id').val();
                                }
                            }
                        }
                    },
                },
                messages: {
                    company_id: {
                        required: "Please enter Company ID",
                    },
                    company_name: {
                        required: "Please enter Company Name",
                    },
                    company_shortname: {
                        required: "Please enter Company Short Name",
                    },
                    dosh_reg_no: {
                        required: "Please enter DOSH Reg No",
                    },
                    roc_no: {
                        remote: "ROC/ROB Number already exists"
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
