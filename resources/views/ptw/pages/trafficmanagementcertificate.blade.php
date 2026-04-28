<div class="row">
    <div class="col">
        <div class="border rounded">
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORK DESCRIPTION</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Location</label>
                    <div class="col-sm-4 form-input">
                        {{ getLocationName($traffic->location) }}
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Work Description :
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $traffic->workdescription }}

                    </div>
                    <label class="col-sm-2 col-form-label require">
                        Reason(s) for closing the road(s):
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $traffic->reasonclosing }}

                    </div>

                </div>


                <div class="row mb-2">
                    {{-- <label class="col-sm-2 col-form-label require">
                        Period or duration for closing the road(s) :
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $traffic->periodorduratio }}

                    </div> --}}
                    <label class="col-sm-2 col-form-label require">
                       work start date
                    </label>
                    <div class="col-md-4 form-input">
                        {{ displayDateformat($traffic->workstartdate) }}

                    </div>
                    <label class="col-sm-2 col-form-label require">
                        work end date
                     </label>
                     <div class="col-md-4 form-input">
                         {{ displayDateformat($traffic->workenddate) }}

                     </div>
                </div>

                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">SKETCH or PLOT-PLAN THE TRAFFIC FLOW MANAGEMENT AT THE
                    WORKSITE (Please attach attachment(s) if applicable)</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">
                    <label class="col-sm-3 col-form-label require">
                        Upload Plan</label>
                    <div class="col-md-3 form-input">
                        <div class="m-2">

                            @foreach ($trafficplandocument as $document)
                                <div>
                                    <a target="_blank"
                                        href="{{ url($document['file_path']) }}">{{ $document['file_orgname'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>


                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORKSITE TRAFFIC MANAGEMENT DETAILS</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="col-md-2 require">
                    Lighting :
                </div>

                <div class="col-md-10 form-input">

                    @foreach ($wtmlight as $light)
                        @if (in_array($light->id, json_decode($traffic->lighting)))
                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                        @else
                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                        @endif

                        <label class="form-check-label">{{ $light->category_name }}</label>
                    @endforeach

                </div>

                <div class="col-md-2 ">
                    <label for=""> </label>
                </div>
                <div class="col-md-10 form-input">

                    @foreach ($wtmotherdetails as $wtmother)
                        @if (in_array($wtmother->id, json_decode($traffic->wtmother)))
                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                        @else
                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                        @endif

                        <label class="form-check-label">{{ $wtmother->category_name }}</label>
                    @endforeach

                </div>

                <div class="row">
                    <div class="col-md-1">Others</div>
                    <div class="col-md-11">
                        {{ $traffic->wtmothers }}
                    </div>
                </div>
                <hr>
            </div>


            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
            </div>
            <div class="row g-3 p-4">
                <p>We hereby have checked the site / studied the layout drawings and certify that
                    the </p>
                <p>worksite traffic management proposed under Permit to Work number
                    <u><b>{{ $traffic->workpermitnymber }}</b> </u>
                    dated <u><b>{{ $traffic->workpermitdate }}</b> </u>
                    can be carried
                    out:
                </p>

                <hr>

                <p>a) Without risk of damage to any underground services</p>
                <p>b) Provided that the following additional controls / alternative route are taken
                    to prevent damages to the equipment/services specified below:</p>
                <p>c) With the compliance to traffic security rules & regulation</p>
                <p>d) Provide that the following additional controls / alternative route are taken
                    to prevent damages to the equipment/services specified below:</p>
                <p class="border rounded pt-3 pb-5 px-3">
                    {{ $traffic->otherserice }}
                </p>

            </div>

            <div class="row g-3 p-4">
                <div class="col-md-12">

                    <div class="m-2 form-input">

                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                        <label class="form-check-label" for="accept_terms">I <b>fully
                                understand </b>& will <b>ensure compliance</b> with all the
                            requirements of this permit.</label>
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 col-form-label">
                        Name</label>
                    <div class="col-sm-4 form-input">
                        {{ getusername($traffic->created_by) }}

                    </div>
                    <label class="col-sm-2 col-form-label form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($traffic->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Remarks</label>
                    <div class="col-sm-10">
                        {{ $traffic->applicant_remarks }}
                    </div>
                </div>
            </div>

            @if (count($trafficpermitStatusLog) > 0)
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">APPROVAL</h6>
            </div>
            @foreach ($trafficpermitStatusLog as $statusLog)
                <div class="row  px-3">
                    <div class="col-md-12">
                        <table class="table mb-0 table-borderless">
                            <tbody>
                                <tr style="background-color: #aaa">
                                    <td colspan="6" style="font-weight:500;"> Status -
                                        {!! subpermitStatus($statusLog->to_status) !!} </td>
                                </tr>
                                <tr>
                                    <th style="width: 10%">Name</th>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 30%">{{ getusername($statusLog->approved_by) }}</td>
                                    <th style="width: 10%">Date</th>
                                    <td style="width: 5%">:</td>
                                    <td style="width: 30%">
                                        {{ displayDateTimeformat($statusLog->created_at) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>:</td>
                                    <td colspan="4">{{ $statusLog->remarks }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
        </div>
    </div>
</div>
