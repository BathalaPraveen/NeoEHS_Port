<div class="row">
    <div class="col">

        <div class=" border rounded">
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORK DESCRIPTION</h6>
            </div>
            <div class="row g-3 px-2 pt-1">

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>
                                <label class="  require">
                                    Location</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ getLocationName($surface->location) }}

                                </div>
                            </td>
                            <td> <label class="require">
                                    Excavation hazardous area</label></td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    <div>

                                        @if ($surface->hazardousarea == 'Hazardous')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif


                                        <label class="form-check-label" for="checkbox_Hazardous">Hazardous</label>
                                    </div>
                                    <div>
                                        @if ($surface->hazardousarea == 'Non-Hazardous')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label"
                                            for="checkbox_Non_Hazardous">Non-Hazardous</label>
                                    </div>


                                </div>
                            </td>
                            <td>
                                <label class="">
                                    Trial excavation carried out</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">

                                    @if ($surface->trailexcavation == 'YES')
                                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                                    @else
                                        <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                    @endif

                                    <label class="form-check-label" for="trailexcavation">Hazardous</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="require">
                                    Max excavation depth / length</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ $surface->maxexcavationdepth }}
                                </div>
                            </td>
                            <td>
                                <label class="require">
                                    Max excavation deep</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ $surface->maxexcavationdeep }}

                                </div>
                            </td>
                            <td>
                                <label class="">Result from Trial </label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ $surface->resulttrailfrom }}

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Work Start Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($surface->workstartdate) }}
                            </td>
                            <td>Work End Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($surface->workenddate) }}

                            </td>

                        </tr>
                        <tr>
                            <td>
                                <label class="require">Work Description</label>
                            </td>
                            <td>:</td>
                            <td colspan="7">
                                <div class="form-input">
                                    {{ $surface->workdescription }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">PPE (Compulsary)</h6>
            </div>
            <div class="row g-3 px-2 pt-1">

                <div class="row mb-2">

                    @php
                        $ppelistdetails = json_decode($surface->ppelist);
                        $ppelistArray = $ppelistdetails->ppelist;
                    @endphp

                    @foreach ($surfaceppe as $ppe)
                        <div class="col-md-3">


                            <div class="m-2">
                                @if (in_array($ppe->id, $ppelistArray))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label"
                                    for="checkbox_{{ encryptId($ppe->id) }}">{{ $ppe->category_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label ">
                        Others
                    </label>
                    <div class="col-md-10">
                        <div class="m-2">
                            {{ $ppelistdetails->ppeothers }}

                        </div>
                    </div>
                </div>
                <hr>
            </div>


            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">EQUIPMENT</h6>
            </div>
            <div class="row g-3 px-2 pt-1">
                <div class="row mb-2">

                    @php
                        $equipmentlistdetails = json_decode($surface->equipment);
                        $equipmentlistArray = $equipmentlistdetails->equipment;
                    @endphp

                    @foreach ($equipments as $equipment)
                        <div class="col-md-3">

                            <div class="m-2">

                                @if (in_array($equipment->id, $equipmentlistArray))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label"
                                    for="checkbox_{{ encryptId($equipment->id) }}">{{ $equipment->category_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label ">
                        Others
                    </label>
                    <div class="col-md-10">
                        <div class="m-2">
                            {{ $equipmentlistdetails->equipmentothers }}

                        </div>
                    </div>
                </div>
                <hr>
            </div>


            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">ADDITIONAL REQUIREMENTS</h6>
            </div>
            <div class="row g-3 px-2 pt-1">
                <div class="row mb-2">

                    @php
                        $addrequiermentslistdetails = json_decode($surface->addrequierments);
                        $addrequiermentslistArray = $addrequiermentslistdetails->addrequierments;
                    @endphp

                    @foreach ($aditionalrequierments as $requierments)
                        <div class="col-md-3">

                            <div class="m-2">

                                @if (in_array($requierments->id, $addrequiermentslistArray))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif


                                <label class="form-check-label"
                                    for="checkbox_{{ encryptId($requierments->id) }}">{{ $requierments->category_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label ">
                        Others
                    </label>
                    <div class="col-md-10">
                        <div class="m-2">
                            {{ $addrequiermentslistdetails->requiermentsothers }}

                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
            </div>

            <div class="row g-3 px-2 pt-1">
                <div class="col-md-12">
                    <p>We hereby have checked the site / studied the
                        layout drawings and certify that the surface penetration proposed under
                        Permit to Work number
                        <u>{{ $surface->accept_worknumber }}</u>
                        dated
                        <u>{{ $surface->accept_work_date }}</u>
                        can be carried out:
                    </p>
                    <p>a) * Without risk of damage to any underground services</p>
                    <p>b) * Provided that the following additional controls are taken to prevent
                        damages to the equipment/services specified below:</p>

                    <p>
                        {{ $surface->accept_work_remarks }}
                    </p>

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
                        {{ getusername($surface->created_by) }}
                    </div>
                    <label class="col-sm-2 col-form-label form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($surface->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label require">
                        Remarks</label>
                    <div class="col-sm-10 form-input">
                        {{ $surface->applicant_remarks }}

                    </div>
                </div>
            </div>

            @if (count($surfacepermitStatusLog) > 0)
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">APPROVAL</h6>
            </div>
            @foreach ($surfacepermitStatusLog as $statusLog)
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
