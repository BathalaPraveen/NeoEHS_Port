@extends('admin.layouts.layout')
@section('title', 'Port Security Access View')
@section('pageurl', admin_url('portsecurity/master/list'))
@push('style')
    <style>
        label {
            font-weight: bold;
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
                            <li class="breadcrumb-item active" aria-current="page">Port Security Access</li>
                            <li class="breadcrumb-item active" aria-current="page">Master</li>
                            <li class="breadcrumb-item active" aria-current="page">Port Security Access View</li>
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
                                    <h5 class="card-title">Port Security Access View</h5>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ admin_url('portsecurity/master/list') }}" data-bs-toggle="tooltip"
                                        title="Back" class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="">
                                <div class="card-header card-header-inner mt-3 content-block-header">
                                    <h6 class="text-white">Report Datas</h6>
                                </div>
                                <div class="content-block-body">
                                    <div class="row g-3 px-4 pt-4 content-block-row">
                                        <div class="col-md-4">
                                            <label for="incident_type" class="form-label">PSS ID</label>
                                            <div>
                                                {{ $securitydata->unique_id }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class=" form-input">
                                                <label for="emergency_incident_tier" class="form-label">ID Type</label>
                                                <div>
                                                    {{ getIdType($securitydata->id_type) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class=" form-input">
                                                <label for="typeofnotification" class="form-label">IC/Passport No</label>
                                                <div>
                                                    {{ $securitydata->passport_number }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class=" form-input">
                                                <label for="location_" class="form-label">Designation Name</label>
                                                <div>
                                                    {{ getDesignationName($securitydata->designation_id) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="incidentdate" class="form-label">Induction Date</label>
                                            <div>
                                                {{ displayDateformat($securitydata->induction_date) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="incidenttime" class="form-label">Induction Due Date</label>
                                            <div>
                                                {{ displayDateformat($securitydata->induction_duedate) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="company" class="form-label">Company Name</label>
                                            <div>
                                                {{ getCompanyName($securitydata->company_id) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-input">
                                            <label for="location" class="form-label">Location Name</label>
                                            <div>
                                                {{ getLocationName($securitydata->location_id) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($certifiactedata) && count($certifiactedata) > 0)
                                    <div class="card-header card-header-inner mt-3 content-block-header">
                                        <b>Other Competency Details</b>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered" style="width: 100%; margin-bottom: 0;">
                                            <thead style="background: #f1f1f1;">
                                                <tr>
                                                    <th style="width: 25%;">Competency Certificate Name
                                                    </th>
                                                    <th style="width: 15%;">Start Date</th>
                                                    <th style="width: 15%;">End Date</th>
                                                    <th style="width: 35%;">Competency Certificate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($certifiactedata as $certificate)
                                                    <tr>
                                                        <td>{{ $certificate->cert_name ?? '-' }}</td>
                                                        <td>{{ Displaydateformat($certificate->cert_start_date) ?? '-' }}
                                                        </td>
                                                        <td>{{ Displaydateformat($certificate->cert_end_date) ?? '-' }}
                                                        </td>
                                                        <td>
                                                            <div class="fileinput-preview img-thumbnail"
                                                                style="width: 200px; height: 150px; text-align: center;">
                                                                @php $ext = strtolower(pathinfo('public/'. $certificate->cert_path, PATHINFO_EXTENSION)); @endphp
                                                                @if ($ext === 'pdf')
                                                                    <a href="{{ asset('public/'. $certificate->cert_path) }}"
                                                                        target="_blank" class="btn btn-sm btn-info">
                                                                        <i class="bx bx-file"></i> View PDF
                                                                    </a>
                                                                @else
                                                                    <img src="{{ asset('public/'. $certificate->cert_path) }}"
                                                                        style="max-width: 100%; max-height: 100%; border-radius: 5px;" />
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop
@push('script')
@endpush
