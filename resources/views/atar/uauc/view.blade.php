@extends('admin.layouts.layout')
@section('title', 'UAUC View')
@section('pageurl', admin_url('atar/uauc/list'))

@push('style')
    <style>
        .card-body label {
            font-weight: 600;
        }

        textarea {
            text-transform: uppercase;
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
                                UAUC
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('atar/uauc/list') }}">UAUC</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">UAUC View </li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <div class="row mt-2">
                <div class="col">

                    <div class="card border-top border-0 border-4 border-primary">

                        <div class="card-body">
                            <div class="d-lg-flex align-items-center gap-3">

                                <div class="position-relative">
                                    <h5 class="card-title">UAUC View</h5>
                                </div>
                                <div class="ms-auto">

                                    <a href="{{ admin_url('atar/uauc/list') }}" data-bs-toggle="tooltip" title="Back"
                                        class="btn btn-primary">
                                        Back
                                    </a>
                                </div>
                            </div>
                            <hr />

                            <div class="p-4 border rounded ">
                                <div class="row g-3">
                                    @csrf
                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white text-uppercase">General Information</h6>
                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label class="form-label require">Reporter Name</label>
                                        <div>
                                            {{ $userInfo->name }}
                                        </div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label class="form-label require">Email</label>
                                        <div>
                                            {{ $userInfo->email }}
                                        </div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label class="form-label require">Company</label>
                                        <div>
                                            {{ $userInfo->companyInfo->company_name }}
                                        </div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label class="form-label require">Division</label>
                                        <div>
                                            {{ $userInfo->divisionInfo->division_name }}
                                        </div>

                                    </div>

                                    <div class="col-md-4 form-input">
                                        <label class="form-label require">Department</label>
                                        <div>
                                            {{ $userInfo->departmentInfo->department_name }}
                                        </div>

                                    </div>

                                    <hr>

                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white text-uppercase">UAUC INFORMATION</h6>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-3">
                                            <label class="form-label ">Date </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div>
                                                {{ displayDateformat($uauc->dateandtime) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label ">Location </label>
                                        </div>
                                        <div class="col-md-9">
                                            <div>
                                                {{ $uauc->location_name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label ">Specific Location</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div>

                                                @if ($uauc->specific_loc_name == '')
                                                    Others
                                                @else
                                                    {{ $uauc->specific_loc_name }}
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    @if ($uauc->specific_loc_name == '')
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <label class="form-label ">Other Location</label>
                                            </div>
                                            <div class="col-md-9">
                                                {{ $uauc->other_speclocation }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label ">UAUC ID</label>
                                        </div>
                                        <div class="col-md-9">
                                            {{ $uauc->atar_id }}
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-3 bold">
                                            UAUC Category
                                        </div>
                                        <div class="col-md-9">
                                            {{ $uauc->atar_type }}
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3">
                                            <label class="form-label ">Hazards / HSE issues</label>
                                        </div>
                                        <div class="col-md-9" title="{{ strtoupper($uauc->zefa_rule) }}">
                                            {{ strtoupper($uauc->hse_hazard) }} / {{ strtoupper($uauc->hover_msg) }}
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-3 bold">
                                            Describe what you see
                                        </div>
                                        <div class="col-md-9">
                                            {{ $uauc->usee_remarks }}
                                        </div>
                                    </div>

                                    @if (count($uactfiles) > 0)
                                        <div class="row mt-2">
                                            <div class="col-md-3 bold">
                                                Uploads
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    @foreach ($uactfiles as $uact)
                                                        <div class="col-md-4 form-input image-box">

                                                            @if (in_array(strtolower($uact->file_extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                <a href="{{ url($uact->file_path) }}"
                                                                    data-lightbox="final">
                                                                    <img src="{{ url($uact->file_path) }}"
                                                                        alt="Uploaded Image"
                                                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                </a>
                                                            @else
                                                                <video width="100%" controls>
                                                                    <source src="{{ url($uact->file_path) }}"
                                                                        type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif



                                    @if (!in_array($uauc->uauc_category, [1, 2]))
                                        <div class="card-header card-header-inner ">
                                            <h6 class="text-white text-uppercase">Corrective Action</h6>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <label class="form-label ">Action Taken</label>
                                            </div>
                                            <div class="col-md-9">
                                                {{ strtoupper($uauc->action_taken_details) }}
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <label class="form-label ">Description </label>
                                            </div>
                                            <div class="col-md-9">
                                                <div>
                                                    {{ $uauc->uact_remarks }}
                                                </div>
                                            </div>
                                        </div>

                                        @if (!in_array($uauc->action_taken, [2]))
                                            <div class="card-header card-header-inner ">
                                                <h6 class="text-white text-uppercase">Responsibility</h6>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <label class="form-label ">Company</label>
                                                </div>
                                                <div class="col-md-9">
                                                    {{ $uauc->company_name }}
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <label class="form-label ">Division</label>
                                                </div>
                                                <div class="col-md-9">
                                                    {{ $uauc->division_name }}
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <label class="form-label ">Department</label>
                                                </div>
                                                <div class="col-md-9">
                                                    {{ $uauc->department_name }}
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <label class="form-label ">Job Owner</label>
                                                </div>
                                                <div class="col-md-9">
                                                    {{ getusername($uauc->job_owner) }}
                                                </div>
                                            </div>
                                            @if ($uauc->action_taken == 3)
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label ">Violators Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        {{ $uauc->violators_email }}
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label ">Infringement</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        {{ $uauc->infringement_no }} - {{ $uauc->type_of_infringement }}
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <label class="form-label ">SSDS Serial Number</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        {{ $uauc->ssds_serial_number }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                    @endif


                                    <hr>
                                    <div class="card-header card-header-inner ">
                                        <h6 class="text-white text-uppercase">CORRECTIVE ACTION Status</h6>
                                    </div>

                                    <div class="row p-2">

                                        <div class="col">
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr style="background-color: #d9e2f3">
                                                        <td colspan="6" style="font-weight:600;"> Status - Created
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th style="width: 10%">Name</th>
                                                        <td style="width: 5%">:</td>
                                                        <td style="width: 30%">{{ getUser($uauc->created_by)->name }}</td>
                                                        <th style="width: 10%">Designation</th>
                                                        <td style="width: 5%">:</td>
                                                        <td style="width: 30%">
                                                            {{ getUser($uauc->created_by)->user_designation_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Date</th>
                                                        <td>:</td>
                                                        <td>{{ displayDateformat($uauc->created_at) }}</td>
                                                        <th>Time</th>
                                                        <td>:</td>
                                                        <td>{{ Displaytimeformat($uauc->created_at) }}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                            @foreach ($uauc_status_log as $statusLog)
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <table class="table mb-0 table-borderless">
                                                            <tbody>
                                                                <tr style="background-color: #d9e2f3">
                                                                    <td colspan="6" style="font-weight:600;"> Status -
                                                                        {{ $statusLog->statusToInfo->atar_status }} </td>
                                                                </tr>

                                                                <tr>
                                                                    <th style="width: 10%">Name</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td style="width: 30%">
                                                                        {{ $statusLog->userInfo->name }}</td>
                                                                    <th style="width: 10%">Designation</th>
                                                                    <td style="width: 5%">:</td>
                                                                    <td style="width: 30%">
                                                                        {{ $statusLog->userInfo->user_designation_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <td>:</td>
                                                                    <td>{{ displayDateformat($statusLog->created_at) }}
                                                                    </td>
                                                                    <th>Time</th>
                                                                    <td>:</td>
                                                                    <td>{{ Displaytimeformat($statusLog->created_at) }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Remarks</th>
                                                                    <td>:</td>
                                                                    <td colspan="4" class="max-with-word-wrap">
                                                                        {{ $statusLog->status_description }}</td>

                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($uauc->atar_status_id == 5 || $uauc->atar_status_id == 7)
                                            @if (count($finalfiles) > 0)
                                                <div class="col">
                                                    <div class="col-md-12 form-input P-2"
                                                        style="background-color: #d9e2f3">
                                                        <label class="form-label ">PHOTO(S)/EVIDENCE OF CORRECTIVE
                                                            ACTION</label>
                                                    </div>

                                                    <div class="row mt-2">
                                                        @foreach ($finalfiles as $final)
                                                            <div class="col-md-12 form-input image-box">

                                                                @if (in_array(strtolower($final->file_extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <a href="{{ url($final->file_path) }}"
                                                                        data-lightbox="final">
                                                                        <img src="{{ url($final->file_path) }}"
                                                                            alt="Uploaded Image"
                                                                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                    </a>
                                                                @else
                                                                    <video width="100%" controls>
                                                                        <source src="{{ url($final->file_path) }}"
                                                                            type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif

                                                                <a href="{{ url($final->file_path) }}"
                                                                    data-lightbox="final">
                                                                    <img style="" class="w-100"
                                                                        src="{{ url($final->file_path) }}"
                                                                        alt="">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>


                                    @if ($uauc->atar_status_id == 5)
                                        @if (count($hscfiles) > 0)
                                            <div class="card-header card-header-inner">
                                                <h6 class="text-white text-uppercase">CONSEQUENCE MANAGEMENT</h6>
                                            </div>

                                            <div class="row p-2">
                                                <div class="col">
                                                    <div class="col-md-12 form-input P-2"
                                                        style="background-color: #d9e2f3">
                                                        <label class="form-label ">PHOTO(S)/EVIDENCE OF CONSEQUENCE
                                                            MANAGEMENT</label>
                                                    </div>

                                                    <div class="row mt-2">
                                                        @foreach ($hscfiles as $hsc)
                                                            <div class="col-md-4 form-input image-box">

                                                                @if (in_array(strtolower($hsc->file_extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <a href="{{ url($hsc->file_path) }}"
                                                                        data-lightbox="hsc">
                                                                        <img src="{{ url($hsc->file_path) }}"
                                                                            alt="Uploaded Image"
                                                                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                    </a>
                                                                @else
                                                                    <video width="100%" controls>
                                                                        <source src="{{ url($hsc->file_path) }}"
                                                                            type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @endif

                                                                <a href="{{ url($hsc->file_path) }}" data-lightbox="hsc">
                                                                    <img style="" class="w-100"
                                                                        src="{{ url($hsc->file_path) }}" alt="">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <hr>

                                    @if (
                                        $uauc->atar_status_id != 7 &&
                                            $uauc->atar_status_id != 6 &&
                                            $uauc->atar_status_id != 5 &&
                                            $uauc->atar_status_id != 4 &&
                                            ((CheckUserRole(ROLE_JOBOWNER) &&
                                                ($uauc->job_owner == Auth::id() || $uauc->reassign_job_owner == Auth::id())) ||
                                                CheckUserRole(ROLE_HSEUSER) ||
                                                CheckUserRole(ROLE_SUPERADMIN) ||
                                                CheckUserRole(Auth::user()->role == ROLE_ADMIN)))

                                        <form id="useeuact_update" action="{{ admin_url('atar/uauc/edit/submit') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ encryptId($uauc->id) }}">
                                            <div class="col-md-4 form-input">
                                                <label class="form-label ">Status</label>
                                                <div>
                                                    <select name="uauc_status" class="select2 w-100" id="uauc_status">
                                                        @if ($uauc->atar_status_id == 1)
                                                            <option value="">Select Status</option>
                                                        @endif
                                                        @foreach ($uauc_status as $status)
                                                            <option @if ($status->id == $uauc->atar_status_id) selected @endif
                                                                data-id="{{ $status->id }}"
                                                                value="@if ($status->id != $uauc->atar_status_id) {{ encryptId($status->id) }} @endif">

                                                                @if ($uauc->atar_status_id == 2 && $status->id == 2)
                                                                    IN-PROGRESS
                                                                @else
                                                                    {{ strtoupper($status->atar_status) }}
                                                                @endif

                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="accept_div" style="display: none">

                                                <div class="col-md-12 form-input">
                                                    <label class="form-label require">Remarks on Action Taken</label>
                                                    <textarea name="accept_desc" id="accept_desc" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="reassign_div" style="display: none">

                                                <div class="col-md-3 form-input">
                                                    <label class="form-label require">Company Name</label>
                                                    <select name="company" id="company" class="form-control select2"
                                                        required>
                                                        <option value="">Select Company</option>
                                                        @foreach ($companyDetails as $company)
                                                            <option value="{{ encryptId($company->id) }}">
                                                                {{ $company->company_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-3 form-input">
                                                    <label class="form-label require">Division Name</label>
                                                    <select name="division" id="division" class="form-control select2"
                                                        required>
                                                        <option value="">Select Division</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 form-input">
                                                    <label class="form-label require">Department
                                                        Name</label>
                                                    <select name="department" id="department"
                                                        class="form-control select2" required>
                                                        <option value="">Select Department</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 form-input">
                                                    <label class="form-label require">Job Owner</label>
                                                    <input type="text" name="job_owner_name" readonly
                                                        class="form-control" id="job_owner_name" style="display: none">
                                                    <select name="job_owner" id="job_owner" class="form-control select2"
                                                         required>
                                                        <option value="">Select Job Owner</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12 form-input">
                                                    <label class="form-label require">Remarks on Action Taken</label>
                                                    <textarea name="reassign_desc" id="reassign_desc" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="irrelavant_div" style="display: none">

                                                <div class="col-md-12 form-input">
                                                    <label class="form-label require">Remarks on Action Taken</label>
                                                    <textarea name="irrelavant_desc" id="irrelavant_desc" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="row mt-2" id="duplicate_div" style="display: none">

                                                <div class="col-md-12 form-input">
                                                    <label class="form-label require">Remarks on Action Taken</label>
                                                    <textarea name="duplicate_desc" id="duplicate_desc" rows="5" class="form-control"></textarea>
                                                </div>
                                            </div>


                                            <div class="row mt-2" id="close_div" style="display: none">

                                                <div class="col-md-12 form-input">
                                                    <label class="form-label require">Remarks on Action Taken</label>
                                                    <textarea name="close_desc" id="close_desc" rows="5" class="form-control"></textarea>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="float-end">
                                                        <button type="button" class="badge bg-success addMorcerti1">Add
                                                            More</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row addMorecompet1">
                                                        <div class="col-md-4 form-input imageuploadarea">
                                                            <label class="form-label require">Image Upload</label>
                                                            <br>
                                                            <div class="fileinput fileinput-new apprFileinput"
                                                                style="  " data-provides="fileinput">
                                                                <div class="fileinput-preview thumbnail bootimgheight appbootimgheight"
                                                                    data-trigger="fileinput">
                                                                </div>
                                                                <p class="mini-txt">(png, jpeg, jpg, mp4)</p>
                                                                <div class="file-pop">
                                                                    <span class="text-green btn-file">
                                                                        <span class="photo fileinput-new"
                                                                            title="Add Image">
                                                                            <img class="imgupload"
                                                                                src='{{ admin_url('public/assets/images/common/camera.png') }}'
                                                                                style=" width: 30%; " />
                                                                        </span>
                                                                        <span class="fileinput-exists"
                                                                            title="Add Image"></span>
                                                                        <input type="file" name="finalimage[]"
                                                                            class='atarfile' accept="image/*,video/mp4"
                                                                            onchange="validateFileSize(this)">
                                                                    </span>

                                                                    <button type="button" name="re"
                                                                        class="btn btn-nothing text-maroon fileinput-exists"
                                                                        data-dismiss="fileinput" title="Remove Image"><i
                                                                            class="fa fa-times-circle-o"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                                <p class="text-danger mini-txt d-none fileError">
                                                                    File size must be below
                                                                    20MB.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row card-bottom">
                                                <div class="col-12 mt-2 mb-3">
                                                    <hr>
                                                    <button type="reset" class="btn btn-danger "
                                                        data-bs-toggle="tooltip" title="Reset">Reset</button>
                                                    <button class="btn btn-primary " type="submit"
                                                        data-bs-toggle="tooltip" title="Submit">Submit</button>
                                                </div>
                                            </div>

                                        </form>
                                    @endif

                                    @if ($uauc->atar_status_id == 7 && $uauc->action_taken == 3)
                                        <form id="useeuact_update" action="{{ admin_url('atar/uauc/hse/submit') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-header card-header-inner mb-3">
                                                <h6 class="text-white text-uppercase">CONSEQUENCE MANAGEMENT</h6>
                                            </div>
                                            <input type="hidden" name="uauc_status" value="{{ encryptId(5) }}">
                                            <input type="hidden" name="id" value="{{ encryptId($uauc->id) }}">
                                            <div class="col-md-12 form-input px-2">
                                                <label class="form-label require">Remarks</label>
                                                <textarea name="hsc_remarks" rows="5" class="form-control"></textarea>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="float-end">
                                                    <button type="button" class="badge bg-success addMorcerti2">Add
                                                        More</button>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="row addMorecompet2">
                                                    <div class="col-md-4 form-input imageuploadarea">
                                                        <label class="form-label require">Image Upload</label>
                                                        <br>
                                                        <div class="fileinput fileinput-new apprFileinput" style="  "
                                                            data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail bootimgheight appbootimgheight"
                                                                data-trigger="fileinput">
                                                            </div>
                                                            <p class="mini-txt">(png, jpeg, jpg, mp4)</p>
                                                            <div class="file-pop">
                                                                <span class="text-green btn-file">
                                                                    <span class="photo fileinput-new" title="Add Image">
                                                                        <img class="imgupload"
                                                                            src='{{ admin_url('public/assets/images/common/camera.png') }}'
                                                                            style=" width: 30%; " />
                                                                    </span>
                                                                    <span class="fileinput-exists"
                                                                        title="Add Image"></span>
                                                                    <input type="file" name="hscImage[]"
                                                                        class='atarfile' accept="image/*,video/mp4"
                                                                        onchange="validateFileSize(this)">
                                                                </span>

                                                                <button type="button" name="re"
                                                                    class="btn btn-nothing text-maroon fileinput-exists"
                                                                    data-dismiss="fileinput" title="Remove Image"><i
                                                                        class="fa fa-times-circle-o"
                                                                        aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            <p class="text-danger mini-txt d-none fileError">
                                                                File size must be below
                                                                20MB.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row card-bottom">
                                                <div class="col-12 mt-2 mb-3">
                                                    <hr>
                                                    <button type="reset" class="btn btn-danger "
                                                        data-bs-toggle="tooltip" title="Reset">Reset</button>
                                                    <button class="btn btn-primary " type="submit"
                                                        data-bs-toggle="tooltip" title="Submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
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
        function validateFileSize(input) {
            const maxSize = 20 * 1024 * 1024;
            const parentDiv = input.closest(".imageuploadarea");
            const errorMsg = parentDiv.querySelector(".fileError");

            if (input.files.length > 0) {
                const file = input.files[0];
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: "error",
                        title: "File Too Large",
                        text: "File size must be below 20MB.",
                    });

                    input.value = "";
                    errorMsg.classList.remove("d-none");
                } else {
                    errorMsg.classList.add("d-none");
                }
            }
        }

        $(function() {
            $('#useeuact_update').validate({
                rules: {
                    uauc_status: {
                        required: true,
                    },
                    irrelavant_desc: {
                        required: true,
                    },
                    duplicate_desc: {
                        required: true,
                    },
                    company: {
                        required: true,
                    },
                    division: {
                        required: true,
                    },
                    department: {
                        required: true,
                    },
                    job_owner: {
                        required: true,
                    },
                    reassign_desc: {
                        required: true,
                    },
                    hsc_remarks: {
                        required: true,
                    },
                    accept_close_desc: {
                        required: true,
                    },
                    "finalimage[]": {
                        required: true,
                    },
                    "hscImage[]": {
                        required: true,
                    }
                },
                messages: {
                    uauc_status: {
                        required: "Please change the Status",
                    },
                    irrelavant_desc: {
                        required: "Please enter the Remarks",
                    },
                    duplicate_desc: {
                        required: "Please enter the Remarks",
                    },
                    company: {
                        required: "Please select the Company",
                    },
                    division: {
                        required: "Please select the Division",
                    },
                    department: {
                        required: "Please select the Department",
                    },
                    job_owner: {
                        required: "Please select the Job Owner",
                    },
                    reassign_desc: {
                        required: "Please enter the Remarks",
                    },
                    hsc_remarks: {
                        required: "Please enter the Remarks",
                    },
                    accept_close_desc: {
                        required: "Please enter the Remarks",
                    },
                    "finalimage[]": {
                        required: "Please upload the Image",
                    },
                    "hscImage[]": {
                        required: "Please upload the Image",
                    }
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


        $('#uauc_status').change(function() {

            var status = $.trim($(this).val());

            $("#accept_div").hide();
            $("#reassign_div").hide();
            $("#irrelavant_div").hide();
            $("#duplicate_div").hide();
            $("#close_div").hide();

            if (status == '{{ encryptId(2) }}') {

                $("#accept_div").show();
            }

            if (status == '{{ encryptId(3) }}') {

                $("#reassign_div").show();
                $("#reassign_div .select2").select2();
            }

            if (status == '{{ encryptId(4) }}') {

                $("#irrelavant_div").show();
            }
            if (status == '{{ encryptId(6) }}') {

                $("#duplicate_div").show();
            }

            if (status == '{{ encryptId(5) }}') {

                $("#close_div").show();
            }


        });

        $('#company').change(function() {
            var companyId = $(this).val();
            if (companyId) {
                $.ajax({
                    url: "{{ admin_url('division/list/') }}" + companyId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#division').empty().append(
                            '<option value="">Select Division</option>');
                        $.each(data, function(key, value) {
                            $('#division').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });


                    }
                });
            }
            $('#division').empty().append('<option value="">Select Division</option>');
            $('#division').trigger('change.select2');

            $('#department').empty().append('<option value="">Select Department</option>');
            $('#department').trigger('change.select2');

            $('#job_owner_name').val('');
            $('#job_owner').empty().append('<option value="">Select Job Owner</option>');
            $('#job_owner').trigger('change.select2');
        });

        $('#division').change(function() {
            var divisionId = $(this).val();
            if (divisionId) {

                $.ajax({
                    url: "{{ admin_url('department/list/') }}" + divisionId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#department').empty().append(
                            '<option value="">Select Department</option>');
                        $.each(data, function(key, value) {
                            $('#department').append('<option value="' + value.id + '">' +
                                value
                                .name + '</option>');
                        });
                    }
                });
            }
            $('#department').empty().append('<option value="">Select Department</option>');
            $('#department').trigger('change.select2');
            $('#job_owner_name').val('');
            $('#job_owner').empty().append('<option value="">Select Job Owner</option>');
            $('#job_owner').trigger('change.select2');


        });

        $('#department').change(function() {
            var department_id = $(this).val();
            if (department_id) {
                $.ajax({
                    url: "{{ admin_url('employee/get/job_owner') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                            .attr('content')
                    },
                    data: {
                        department: department_id,
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#job_owner').empty().append(
                            '<option value="">Select Job Owner</option>');
                        $.each(data, function(key, value) {
                            if (key == 0) {
                                selectedtext = 'selected';
                                $("#job_owner_name").val(value.name);
                            }
                            $('#job_owner').append('<option ' + selectedtext + ' value="' +
                                value.id + '">' +
                                value.name + '</option>');
                        });
                    }
                });
            }

            $('#job_owner').empty().append('<option value="">Select Job Owner</option>');
            $('#job_owner').trigger('change.select2');
        });

        $(document).on('click', '.addMorcerti1', function() {

            var asdElement = document.querySelector(".addMorecompet1");

            if (asdElement) {
                // Get all elements with class "a" inside "asd"
                var elementsWithClassA = asdElement.getElementsByClassName("col-md-4");

                // Get the count
                var count = elementsWithClassA.length;

                if (count >= 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maximum 3 uploads only',
                    })
                    return false;
                }



            }
            var baseUrl = "{{ admin_url() }}"

            var html = '<div class="col-md-4 imageuploadarea">' +
                '<div class="float-end removeCertinew1"><i class="fa fa-trash"></i></div>' +
                '<div class="form-group"><div class="fileinput fileinput-new apprFileinput" data-provides="fileinput">' +
                '<div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" style="margin-top:30px;"></div>' +
                '<p class="mini-txt">(png, jpeg, jpg, MP4)</p>' +
                '<div class="file-pop"><span class="text-green btn-file">' +
                '<span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' + baseUrl +
                '/public/assets/images/common/camera.png" style="width: 30%;"></span>' +
                '<span class="fileinput-exists" title="Add Image"></span>' +
                '<input type="file" name="finalimage[]" class="atarfile" accept="image/*,video/mp4" onchange="validateFileSize(this)"></span>' +
                '<button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">' +
                '<i class="fa fa-times-circle-o" aria-hidden="true"></i></button></div>' +
                '<p class="text-danger mini-txt d-none fileError">File size must be below 20MB.</p></div></div></div>';

            $(".addMorecompet1").append(html);

        });

        $(document).on('click', '.addMorcerti2', function() {

            var asdElement = document.querySelector(".addMorecompet2");

            if (asdElement) {
                // Get all elements with class "a" inside "asd"
                var elementsWithClassA = asdElement.getElementsByClassName("col-md-4");

                // Get the count
                var count = elementsWithClassA.length;

                if (count >= 3) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maximum 3 uploads only',
                    })
                    return false;
                }



            }
            var baseUrl = "{{ admin_url() }}"

            var html = '<div class="col-md-4 imageuploadarea">' +
                '<div class="float-end removeCertinew2"><i class="fa fa-trash"></i></div>' +
                '<div class="form-group"><div class="fileinput fileinput-new apprFileinput" data-provides="fileinput">' +
                '<div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" style="margin-top:30px;"></div>' +
                '<p class="mini-txt">(png, jpeg, jpg, MP4)</p>' +
                '<div class="file-pop"><span class="text-green btn-file">' +
                '<span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' + baseUrl +
                '/public/assets/images/common/camera.png" style="width: 30%;"></span>' +
                '<span class="fileinput-exists" title="Add Image"></span>' +
                '<input type="file" name="hscImage[]" class="atarfile" accept="image/*,video/mp4" onchange="validateFileSize(this)"></span>' +
                '<button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image">' +
                '<i class="fa fa-times-circle-o" aria-hidden="true"></i></button></div>' +
                '<p class="text-danger mini-txt d-none fileError">File size must be below 20MB.</p></div></div></div>';

            $(".addMorecompet2").append(html);

        });


        $(document).on('click', '.removeCertinew2', function() {
            $(this).closest('.col-md-4').remove();
        })
    </script>
@endpush
