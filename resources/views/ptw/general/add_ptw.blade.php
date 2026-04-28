@extends('admin.layouts.layout')
@section('title', 'SubPermit Add')
@section('pageurl', admin_url('ptw/general/list'))


@section('content')

    <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">

                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">PTW</li>
                            <li class="breadcrumb-item active" aria-current="page">General PTW</li>
                            <li class="breadcrumb-item active" aria-current="page">SubPermit Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">SubPermit Add - {{ $general->ptw_id }}</h5>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ admin_url('ptw/general/list') }}" data-bs-toggle="tooltip" title="Back"
                                class="btn btn-primary">
                                Back
                            </a>
                        </div>
                    </div>
                    <hr />

                    <form action="{{ admin_url('ptw/general/addPTW/submit') }}" id="subpermit_add" novalidate method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ encryptId($general->id) }}">

                        @csrf
                        <div class="card-header card-header-inner  mb-3 ">
                            <h6 class="text-white">Add HAZARDOUS ACTIVITY / HAZARD</h6>
                        </div>

                        @php

                            $hazardData = json_decode($general->hazard);

                            if ($hazardData == '' || $hazardData == null) {
                                $hazardData = new stdClass();
                                $hazardData->hazard = [];
                            }

                        @endphp

                        <div class="row g-3 pt-4">
                            <div class="row ">
                                @foreach ($hazardDetails as $hazard)
                                    <div class="col-md-3">

                                        <div class="m-2">
                                            <span style="">

                                            </span>
                                            <input
                                                @if (in_array($hazard->id, $hazardData->hazard)) checked @disabled(true) @endif
                                                class="form-check-input radiocheck @if ($hazard->input_type == 2) othersshow @endif"
                                                type="checkbox" value="{{ encryptId($hazard->id) }}" name="hazard[]"
                                                data-id="hazard_document_{{ encryptId($hazard->id) }}"
                                                id="checkbox_{{ encryptId($hazard->id) }}">
                                            <label class="form-check-label"
                                                for="checkbox_{{ encryptId($hazard->id) }}">{{ $hazard->category_name }}</label>
                                        </div>

                                        <div>
                                            @if ($hazard->input_type == 2)
                                                @if (isset($hazardfile[$hazard->id]))
                                                    <div>
                                                        <a href="{{ url($hazardfile[$hazard->id]['file_path']) }}"
                                                            target="_blank">{{ $hazardfile[$hazard->id]['file_orgname'] }}</a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <div @if ($hazard->required == 0) style="display:none" @endif
                                            id="hazard_document_{{ encryptId($hazard->id) }}" class="form-input">
                                            @php
                                                $params = json_decode($hazard->other_params);

                                            @endphp
                                            @isset($params->message)
                                                <label class="require">{{ $params->message }}</label>
                                            @endisset
                                            @if ($hazard->input_type == 2)
                                                <input type="file" class="form-control" required
                                                    name="hazard_document_file[{{ $hazard->id }}]" value="">
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row card-bottom">
                            <div class="col-12 mt-2">
                                <hr>
                                <button type="reset" class="btn btn-danger " data-bs-toggle="tooltip"
                                    title="Reset">Reset</button>
                                <button class="btn btn-primary " id="btnsubmit" type="submit" data-bs-toggle="tooltip"
                                    title="Submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@push('script')
    <script>
        $(document).ready(function() {

            $('.othersshow').on('click', function() {

                $id = $(this).data('id');

                if ($(this).is(':checked')) {
                    $("#" + $id).show().prop('required', true);
                } else {
                    $("#" + $id).hide().prop('required', false);
                }
            });

            $('#btnsubmit').on('click', function(e) {
                let isValid = true;

                $('.hazard-error').remove();

                $('.othersshow').each(function() {
                    let $checkbox = $(this);
                    let targetId = $checkbox.data('id');
                    let $container = $('#' + targetId);
                    let $fileInput = $container.find('input[type="file"]');

                    if ($checkbox.is(':checked')) {
                        $container.show();
                        $fileInput.prop('required', true);

                        if ($fileInput.val() === '') {
                            isValid = false;
                            $fileInput.addClass('is-invalid');

                            $fileInput.after(
                                '<div class="text-danger hazard-error mt-1">This file is required.</div>'
                                );
                        } else {
                            $fileInput.removeClass('is-invalid');
                        }

                    } else {
                        $container.hide();
                        $fileInput.prop('required', false).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });



        });
    </script>
@endpush
