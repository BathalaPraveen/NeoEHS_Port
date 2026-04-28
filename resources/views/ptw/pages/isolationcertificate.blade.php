<div class="row">
    <div class="col">

        <div class=" border rounded">
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORK DESCRIPTION</h6>
            </div>
            <div class="row g-3 px-2">

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <label for="" class=" require">Location</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class=" form-input">
                                    {{ getLocationName($isolation->location) }}
                                </div>
                            </td>

                            <td>
                                <label class="require">
                                    What do Isolate</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ $isolation->whatdoisolate }}
                                </div>
                            </td>

                            <td>
                                <label class="require">
                                    Source of Energy / Flow to Isolate </label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ $isolation->sourceofenergy }}
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label class="require">
                                    Work Description</label>
                            </td>
                            <td>:</td>
                            <td colspan="7">
                                <div class="form-input">
                                    {{ $isolation->workdescription }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Work Start Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($isolation->workstartdate) }}
                            </td>
                            <td>Work End Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($isolation->workenddate) }}

                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">PPE (Compulsary)</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">

                    @php
                        $ppelistArray = json_decode($isolation->ppelist);

                    @endphp

                    @foreach ($ppelist as $ppe)
                        <div class="col-md-3">

                            <div class="m-2">
                                @if (in_array($ppe->id, $ppelistArray))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif
                                <label class="form-check-label">{{ $ppe->category_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
            </div>


            <div class="card-header card-header-inner  mb-3 mt-3">

                <div class="d-lg-flex align-items-center gap-3">

                    <div class="position-relative">
                        <h6 class="text-white">Isolation Detail</h6>
                    </div>

                </div>
            </div>
            <div class="row g-3 p-4">

                <div class="table-responsive">

                    @php
                        $isolationArray = json_decode($isolation->isolation);
                    @endphp

                    <table class="table" id="isolation">
                        <thead>
                            <tr>
                                <td>Isolation Point</td>
                                <td>Lock & Tag Out No.</td>
                                <td>Time</td>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($isolationArray as $details)
                                <tr class="isolationmain">
                                    <td class="form-input">
                                        {{ $details->point }}

                                    </td>
                                    <td class="form-input">
                                        {{ $details->lock }}

                                    </td>
                                    <td class="form-input">
                                        {{ $details->time }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Lock Out / Tag Out Applied by
                    </label>
                    <div class="col-md-4">
                        <div class="m-2 form-input">
                            {{ $isolation->loockoutapplied }}

                        </div>
                    </div>
                    <label class="col-sm-2 col-form-label require">
                        IC No/Body Pass No
                    </label>
                    <div class="col-md-4">
                        <div class="m-2 form-input">
                            {{ $isolation->icno }}

                        </div>
                    </div>
                </div>

                <div class="row mb-2">

                    <div class="col-md-12">
                        <div class="m-2">
                            I <u><b>{{ getusername($isolation->created_by) }}</b></u> Confirmed that the energy /
                            flow has been
                            fully isolated and secured.

                        </div>
                    </div>

                </div>

                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Isolation Daily Check</h6>
            </div>
            <div class="row g-3 p-4">
                @php
                    $days = DAYS;
                @endphp

                <div class="table-responsive">
                    @php
                        $isolatiodailycheckArray = json_decode($isolation->isolatiodailycheck);
                    @endphp
                    <table class="table">
                        <thead>
                            <tr>
                                <td></td>
                                @foreach ($days as $day)
                                    <td>{{ $day }}</td>
                                @endforeach
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (generateNumberArray(7) as $intervel)
                                <tr>
                                    <td> Tag no {{ $intervel }}</td>
                                    @foreach ($days as $day)
                                        <td>
                                            @if (isset($isolatiodailycheckArray->$intervel->$day))
                                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                                            @else
                                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                            @endif


                                        </td>
                                    @endforeach
                                    <td>
                                        {{ $isolatiodailycheckArray->$intervel->status }}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mb-2">

                    <label class="col-sm-2 col-form-label ">
                        Remarks :
                    </label>
                    <div class="col-md-10">
                        <div class="m-2">
                            {{ $isolation->isolationremarks }}

                        </div>
                    </div>

                </div>

                <hr>
            </div>


            <div class="row g-3 px-4">
                <div class="col-md-12">

                    <div class="mx-2 form-input">

                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                        <label class="form-check-label" for="accept_terms">I <b>fully
                                understand </b>& will <b>ensure compliance</b> with all the
                            requirements of this permit.</label>
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <label class="col-sm-2 ">
                        Name</label>
                    <div class="col-sm-4 form-input">
                        {{ getusername($isolation->created_by) }}

                    </div>
                    <label class="col-sm-2  form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($isolation->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Remarks</label>
                    <div class="col-sm-10 form-input">
                        {{ $isolation->applicant_remarks }}

                    </div>
                </div>
            </div>

            @if (count($isolationpermitStatusLog) > 0)
                <div class="card-header card-header-inner  mb-3 mt-3">
                    <h6 class="text-white">APPROVAL</h6>
                </div>
                @foreach ($isolationpermitStatusLog as $statusLog)
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
