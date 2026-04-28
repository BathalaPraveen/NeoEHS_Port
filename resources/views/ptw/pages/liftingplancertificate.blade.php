<div class="row">
    <div class="col">

        <div class=" border rounded">
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">WORK DESCRIPTION</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Location :</label>
                    <div class="col-sm-4 form-input">
                        {{ getLocationName($lifting->location) }}
                    </div>
                    <label class="col-sm-2  ">
                        Work Start Date :</label>
                    <div class="col-sm-4 form-input">
                        {{ displayDateformat($lifting->workstartdate) }}
                    </div>

                    <label class="col-sm-2  ">
                        Work End Date :
                    </label>
                    <div class="col-md-4 form-input">
                        {{ displayDateformat($lifting->workenddate) }}
                    </div>
                </div>


                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Work Description :
                    </label>
                    <div class="col-md-10" class="form-input">
                        {{ $lifting->workdescription }}
                    </div>
                </div>

                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">LOAD(S) DESCRIPTION</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Description of load(s)
                    </label>
                    <div class="col-md-10 form-input">
                        <div class="m-2">
                            {{ $lifting->loaddescription }}
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Overall dimensions
                    </label>
                    <div class="col-md-10 form-input">
                        <div class="m-2">
                            {{ $lifting->overalldimension }}
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Weight of load (kg)
                    </label>
                    <div class="col-md-4 form-input">
                        <div class="m-2">
                            {{ $lifting->loadweight }}

                        </div>
                    </div>
                    <div class="col-md-3 form-input">
                        <div class="m-2">
                            @if ($lifting->weight_type == 'knownweight')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                            <label class="form-check-label" for="weight_type_known">Known
                                weight</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-input">
                        <div class="m-2">
                            @if ($lifting->weight_type == 'estimatedweight')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                            <label class="form-check-label" for="weight_type_estimated">Estimated
                                weight</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Center of gravity
                    </label>
                    <div class="col-md-3 form-input">
                        <div class="m-2">
                            @if ($lifting->centerofgravity == 'obvious')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                            <label class="form-check-label" for="centerofgravity_obvious">Obvious</label>
                        </div>
                    </div>
                    <div class="col-md-3 form-input">
                        <div class="m-2">
                            @if ($lifting->centerofgravity == 'estimated')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif

                            <label class="form-check-label" for="centerofgravity_estimated">Estimated </label>
                        </div>
                    </div>
                    <div class="col-md-3 form-inpt">
                        <div class="m-2">
                            @if ($lifting->centerofgravity == 'determinedbydrawing')
                                <i class="fa-solid fa-check" style="color: #267709;"></i>
                            @else
                                <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                            @endif
                            <label class="form-check-label" for="centerofgravity_determinedbydrawing">Determined by
                                drawing</label>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">LIFTING EQUIPMENT INFORMATION</h6>
            </div>

            <div class="row g-3 p-4">
                <div class="row mb-2">
                    @php
                        $liftequpdetails = json_decode($lifting->liftingquipment);
                    @endphp
                    @foreach ($liftingequipment as $equipment)
                        <div class="col-md-2">
                            <div class="m-2 ">
                                {{ $equipment->category_name }} :
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="m-2 form-input">
                                @php
                                    $equId = $equipment->id;
                                @endphp
                                {{ $liftequpdetails->$equId }}

                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">RIGGING DETAILS</h6>
            </div>
            @php
                $riggingDetails = json_decode($lifting->riggingdetails);
            @endphp
            <div class="row g-3 p-4">
                <div class="row mb-2">
                    <table class="table">
                        <thead>
                            <tr style="text-align: left">
                                <th></th>
                                <th>SIZE</th>
                                <th>SWL</th>
                                <th>QUANTITY</th>
                                <th>WEIGHT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riggingdetails as $rigging)
                                @php
                                    $riggingId = $rigging->id;
                                @endphp
                                <tr>
                                    <td>
                                        <label for="" class="form-input ">{{ $rigging->category_name }}</label>

                                    </td>
                                    <td class="form-input">

                                        {{ $riggingDetails->$riggingId->size }}

                                    </td>
                                    <td class="form-input">
                                        {{ $riggingDetails->$riggingId->swl }}

                                    </td>
                                    <td class="form-input">
                                        {{ $riggingDetails->$riggingId->quantity }}

                                    </td>
                                    <td class="form-input">
                                        {{ $riggingDetails->$riggingId->weight }}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mb-2">

                    <label class="col-sm-2  ">
                        Total weight of the lifting gears (kg)
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $lifting->ligtgearsweight }}

                    </div>

                    <label class="col-sm-2  ">
                        Total suspended load (weight lifting gear + load)
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $lifting->totalweight }}

                    </div>
                </div>
                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Means of Communication</h6>
            </div>
            <div class="row g-3 p-4">

                <div class="row mb-2">

                    <label class="col-sm-2  ">
                        Mean of Communication
                    </label>
                    <div class="col-md-4 form-input">
                        {{ $lifting->meanofcommunication }}

                    </div>

                    <label class="col-sm-4  ">
                        Can the operator see the loading and unloading point from his position
                    </label>
                    <div class="col-md-2 form-input">
                        @if ($lifting->loadinpoint == 'yes')
                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                        @else
                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                        @endif

                        <label class="form-check-label">YES</label>

                        @if ($lifting->loadinpoint == 'no')
                            <i class="fa-solid fa-check" style="color: #267709;"></i>
                        @else
                            <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                        @endif

                        <label class="form-check-label">NO</label>
                    </div>
                </div>
                <hr>
            </div>
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Physical and Environmental Consideration</h6>
            </div>
            <div class="row g-3 p-4">
                @php
                    $env_cond = json_decode($lifting->env_cond);
                @endphp
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Ground condition</td>
                            <td>Is the ground made safe (e.g. Placing stell plate)?</td>
                            <td style="width: 15% " class="form-input">
                                @if ($env_cond->pec_gc == 'yes')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">YES</label>
                                @if ($env_cond->pec_gc == 'no')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">NO</label>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2">Obstacles</td>
                            <td>Are there any overhead obstacles such as power lines?</td>
                            <td class="form-input">
                                @if ($env_cond->pec_ob == 'yes')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">YES</label>
                                @if ($env_cond->pec_ob == 'no')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">NO</label>
                            </td>
                        </tr>
                        <tr>

                            <td>Are there nearby buildings or structurs, equipment or stacked
                                materials that may obstruct lifting operation from being carried out
                                safely?</td>
                            <td class="form-input">
                                @if ($env_cond->pec_obs == 'yes')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">YES</label>
                                @if ($env_cond->pec_obs == 'no')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">NO</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Lighting</td>
                            <td>Is the lighting conditions adequate? <br>
                                (If the lighting out with Daylight hours additional lighting will be
                                provided)</td>
                            <td class="form-input">
                                @if ($env_cond->pec_lig == 'yes')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">YES</label>
                                @if ($env_cond->pec_lig == 'no')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">NO</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Demarcation</td>
                            <td>Has the zone of operation been barricaded (with warning sign and
                                barriers) to prevent unauthorized access for onshore lifting
                                activities?</td>
                            <td class="form-input">
                                @if ($env_cond->pec_dem == 'yes')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">YES</label>
                                @if ($env_cond->pec_dem == 'no')
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label">NO</label>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="5">Environment</td>
                            <td>
                                <b>
                                    <u>Do not proceed with the lifting operation under the following
                                        circumstances: </u>
                                </b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>

                            <td colspan="2">
                                @if (isset($env_cond->pec_env_gc))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label" for="pec_env_gc">
                                    Thunderstorm and lightening strikes in the area. the
                                    ground condition must be checked after thunderstorm.</label>
                            </td>

                        </tr>
                        <tr>

                            <td colspan="2">
                                @if (isset($env_cond->pec_env_wet))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label" for="pec_env_wet">Strong wind
                                    that may sway the suspended load. (Local
                                    weather forecast & Supervisor's experience & Tagline to
                                    address)</label>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @if (isset($env_cond->pec_env_scn))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif

                                <label class="form-check-label" for="pec_env_scn"> Do not
                                    proceed with lifting operation during bad sea
                                    condition. (Strong current and wave). (Local weather forecast &
                                    supervisor's experience & Tagline to address.)</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-check form-check-inline">
                                @if (isset($env_cond->pec_others))
                                    <i class="fa-solid fa-check" style="color: #267709;"></i>
                                @else
                                    <i class="fa  fa-dot-circle-o" style="color: #f72626;"></i>
                                @endif


                                <label class="form-check-label" for="pec_others"> Other
                                    circumstances :</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    {{ isset($env_cond->other_circum) ? $env_cond->other_circum : '' }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <hr>
            </div>

            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">Personnel Involved in lifting Operation</h6>
            </div>
            <div class="row g-3 p-4">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Position</td>
                            <td>Name & Identification Number</td>
                            <td>Document</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lifting Supervisor</td>
                            <td class="form-input">
                                {{ $lifting->liftingsupervisor }}
                            </td>
                            <td>
                                @if(isset($liftingdocument[1]))
                                    <a href="{{ url($liftingdocument[1]['file_path'] ) }}" target="_blank">{{ $liftingdocument[1]['file_orgname'] }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Crane Operator</td>
                            <td class="form-input">
                                {{ $lifting->liftingcraneoperator }}
                            </td>
                            <td>
                                @if(isset($liftingdocument[2]))
                                    <a href="{{ url($liftingdocument[2]['file_path'] ) }}" target="_blank">{{ $liftingdocument[2]['file_orgname'] }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Signalman</td>
                            <td class="form-input">
                                {{ $lifting->liftingsignalman }}
                            </td>
                            <td>
                                @if(isset($liftingdocument[3]))
                                    <a href="{{ url($liftingdocument[3]['file_path'] ) }}" target="_blank">{{ $liftingdocument[3]['file_orgname'] }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Rigger</td>
                            <td class="form-input">
                                {{ $lifting->liftingrigger }}
                            </td>
                            <td>
                                @if(isset($liftingdocument[4]))
                                    <a href="{{ url($liftingdocument[4]['file_path'] ) }}" target="_blank">{{ $liftingdocument[4]['file_orgname'] }}</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Others</td>
                            <td>
                                {{ $lifting->liftingothers }}
                            </td>
                            <td>
                                @if(isset($liftingdocument[5]))
                                    <a href="{{ url($liftingdocument[5]['file_path'] ) }}" target="_blank">{{ $liftingdocument[5]['file_orgname'] }}</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                    <label class="col-sm-2 ">
                        Name</label>
                    <div class="col-sm-4 form-input">
                        {{ getusername($lifting->created_by) }}
                    </div>
                    <label class="col-sm-2  form-input">
                        Date & Time</label>
                    <div class="col-sm-4 form-input">
                        {{ Displaydatetimeformat($lifting->created_at) }}

                    </div>
                </div>
                <div class="row mb-2">
                    <label class="col-sm-2  ">
                        Remarks</label>
                    <div class="col-sm-10 form-input">
                        {{ $lifting->applicant_remarks }}
                    </div>
                </div>
            </div>

            @if (count($liftingpermitStatusLog) > 0)
            <div class="card-header card-header-inner  mb-3 mt-3">
                <h6 class="text-white">APPROVAL</h6>
            </div>
            @foreach ($liftingpermitStatusLog as $statusLog)
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
