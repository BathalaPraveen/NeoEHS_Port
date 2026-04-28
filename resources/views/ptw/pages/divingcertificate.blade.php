<div class="row">
    <div class="col">

        <div class=" border rounded">
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORK DESCRIPTION</h6>
            </div>
            <div class="row g-3 px-4">

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td><label class="">Work Description</label></td>
                            <td>:</td>
                            <td colspan="7" class="form-input">
                                {{ $diving->workdescription }}
                            </td>
                        </tr>

                        <tr>
                            <td>Location</td>
                            <td>:</td>
                            <td class="form-input">
                                {{ getLocationName($diving->location) }}
                            </td>
                            <td><label class="">Estimation Diving Deep</label></td>
                            <td>:</td>
                            <td class="form-input">
                                {{ $diving->divingdeep }}
                            </td>

                            <td>Work Start Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($diving->workstartdate) }}
                            </td>
                        </tr>

                        <tr>
                            <td>Work End Date</td>
                            <td>:</td>
                            <td>
                                {{ displayDateformat($diving->workenddate) }}

                            </td>
                            <td> <label class="">Date</label></td>
                            <td>:</td>
                            <td class="form-input">
                                {{ $diving->date }}
                            </td>
                            <td> <label class="">Time Start</label></td>
                            <td>:</td>
                            <td class="form-input">
                                {{ $diving->time }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="">End Time</label>
                            </td>
                            <td>:</td>
                            <td class="form-input">
                                {{ $diving->estimationtime }}
                            </td>

                            <td><label class="">Applied Date & Time</label></td>
                            <td>:</td>
                            <td class="form-input">
                                {{ Displaydatetimeformat($diving->created_at) }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <hr>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Equipment / Gear</h6>
            </div>
            <div class="row g-3 p-4">
                <div class="row mb-2">
                    @php
                        $divingEquipments = json_decode($diving->equipment);
                    @endphp
                    @foreach ($equipmentgear as $equipment)
                        <div class="col-md-3">

                            <div class="m-2">
                                @if (in_array($equipment->id, $divingEquipments->equipment))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">{{ $equipment->category_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-2">
                    <div class="col-md-1">
                        <div class="m-2">
                            Others :
                        </div>
                    </div>
                    <div class="col-md-11">
                        <div class="m-2">
                            {{ $divingEquipments->equipmentothers }}
                        </div>
                    </div>
                </div>

                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Diving/Site Preparation</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">

                    <table class="table table-bordered">
                        <tbody>
                            @php
                                $divingsitepreparationArray = json_decode($diving->sitepreparation);
                            @endphp
                            @foreach ($divingsitepreparation as $sitepreparation)
                                <tr>
                                    <td>
                                        <label class="form-check-label">{{ $sitepreparation->category_name }}</label>
                                    </td>
                                    <td style="width:5%">
                                        @if (in_array($sitepreparation->id, $divingsitepreparationArray))
                                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                                        @else
                                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <div class="d-lg-flex align-items-center gap-3">
                    <div class="position-relative">
                        <h6 class="text-white">Diver(s) Detail</h6>
                    </div>

                </div>
            </div>
            <div class="row g-3 p-4">

                <div class="table-responsive">
                    <table class="table" id="driverdetails">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>IC no /Pass No</td>
                                <td>Competency</td>
                                <td>Health Fitness</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $driversDetails = json_decode($diving->divers);
                            @endphp

                            @foreach ($driversDetails as $driver)
                                <tr class="driverdetails">
                                    <td class="form-input">
                                        {{ $driver->name }}
                                    </td>
                                    <td class="form-input">
                                        {{ $driver->idnumber }}
                                    </td>
                                    <td class="form-input">
                                        {{ $driver->competency }}
                                    </td>
                                    <td class="form-input">
                                        {{ $driver->healthfitness }}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">ACCEPTANCE & APPROVAL</h6>
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
                        {{ getusername($diving->created_by) }}

                    </div>
                    <label class="col-sm-2 col-form-label form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($diving->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2 col-form-label ">
                        Remarks</label>
                    <div class="col-sm-10 form-input">
                        {{ $diving->applicant_remarks }}

                    </div>
                </div>
            </div>

            @if (count($divingpermitStatusLog) > 0)
                <div class="card-header card-header-inner  mb-3 mt-3">
                    <h6 class="text-white">APPROVAL</h6>
                </div>
                @foreach ($divingpermitStatusLog as $statusLog)
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
