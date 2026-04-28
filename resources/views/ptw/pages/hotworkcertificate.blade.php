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
                                <label class="require">
                                    Location</label>
                            </td>
                            <td>:</td>
                            <td>
                                <div class="form-input">
                                    {{ getLocationName($hotwork->location) }}

                                </div>
                            </td>

                            <td>
                                <label class="require">
                                    Hotwork type (if aplicable refer to Hotwork Certificate)</label>
                            </td>
                            <td>:</td>
                            <td style="width:10%">
                                <div class="form-input">
                                    <div class="">
                                        @if ($hotwork->hotworktype == 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="hotwork_type_yes">YES</label>
                                    </div>
                                    <div class="">
                                        @if ($hotwork->hotworktype != 'YES')
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                        <label class="form-check-label" for="hotwork_type_no">NO</label>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="require">
                                    Location (if Hotwork is conducted on vessel, please write vessel name/ location of vessel):</label>
                            </td>
                            <td>:</td>
                            <td colspan="9">
                                <div class="form-input">
                                    {{ $hotwork->locationmarine }}

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="require">
                                    Work Description</label>
                            </td>
                            <td>:</td>
                            <td colspan="9">
                                <div class="form-input">
                                    {{ $hotwork->workdescription }}

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Work Start Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($hotwork->workstartdate) }}
                            </td>
                            <td>Work End Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($hotwork->workenddate) }}

                            </td>

                        </tr>
                    </tbody>
                </table>

                <div class="row mb-2">
                    <div>
                        <label class="require">Type of Hot Work operation</label>
                    </div>
                    <div class="row form-input">

                        @php
                            $hotworkoperationArray = json_decode($hotwork->hotworkoperation);
                        @endphp
                        @foreach ($hotworkoperation as $hotworkoperation)
                            <div class="col-md-3 ">
                                <div class="">
                                    @if (in_array($hotworkoperation->id, $hotworkoperationArray))
                                        <i class="fa-solid fa-check" style="color: #267709;"></i>
                                    @else
                                        <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                    @endif

                                    <label class="form-check-label">{{ $hotworkoperation->category_name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                </div>

                <div class="card-header card-header-inner  mb-3 mt-3">
                    <h6 class="text-white">Precautions</h6>
                </div>
                <div class="row g-3 px-2 pt-1">
                    <div class="row mb-2">
                        <table class="table mx-3 table-bordered">
                            <tbody>

                                @php
                                    $i = 1;
                                    $precautionsArray = json_decode($hotwork->precautions);

                                @endphp

                                <tr>
                                    @foreach ($precautionslist as $precautions)
                                        <td style="width:40%">
                                            <p>{{ $precautions->category_name }}</p>
                                        </td>
                                        <td style="width:10%" class="form-input">
                                            @php
                                                $id = $precautions->id;
                                            @endphp
                                            @if ($precautionsArray->$id == 'YES')
                                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                                            @else
                                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                            @endif


                                            <label class="form-check-label">YES</label>

                                            @if ($precautionsArray->$id != 'YES')
                                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                                            @else
                                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                            @endif

                                            <label class="form-check-label">N/A</label>
                                        </td>

                                        @if ($i % 2 == 0)
                                </tr>
                                <tr>
                                    @endif

                                    @php
                                        $i++;
                                    @endphp
                                    @endforeach
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <hr>
                </div>

                <div class="row g-3 px-2 pt-1">
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
                            {{ getusername($hotwork->created_by) }}

                        </div>
                        <label class=" col-sm-2 form-input">
                            Date & Time</label>
                        <div class="col-sm-4 form-input">
                            {{ Displaydatetimeformat($hotwork->created_at) }}

                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-2 col-form-label require">
                            Remarks</label>
                        <div class="col-sm-10 form-input">
                            {{ $hotwork->applicant_remarks }}

                        </div>
                    </div>
                </div>

                @if (count($hotworkpermitStatusLog) > 0)
                <div class="card-header card-header-inner  mb-3 mt-3">
                    <h6 class="text-white">APPROVAL</h6>
                </div>
                @foreach ($hotworkpermitStatusLog as $statusLog)
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
</div>
