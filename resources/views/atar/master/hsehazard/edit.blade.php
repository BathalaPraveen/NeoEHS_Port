<div>
    <form action="{{ admin_url('atar/master/hsehazard/edit/submit') }}" id="hse_hazard_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($hsehazard->id) }}">
        <div class="modal-header">
            <h5 class="modal-title">Edit HSE Issues</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">ATAR Type</label>
                <div class="col-sm-9 form-input">
                    <select name="atar_type" id="atar_type" class="select2 form-control" style="width: 100%">
                        <option value="">Select ATAR Type</option>
                        @foreach ($atarDetails as $atar )
                            <option @if( $hsehazard->atar_type == $atar->id) selected @endif value="{{ encryptId($atar->id)}}">{{$atar->atar_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">ZeFA Rule</label>
                <div class="col-sm-9 form-input">
                    <select name="zefa_rule" id="zefa_rule" class="select2 form-control" style="width: 100%">
                        <option value="">Select ZeFA Rule</option>
                        @foreach ($zefaDetails as $zefa )
                            <option @if( $hsehazard->zefa_rule == $zefa->id) selected @endif value="{{ encryptId($zefa->id)}}">{{$zefa->zefa_rule}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="hse_hazard" class="col-sm-3 col-form-label require">HSE Hazard</label>
                <div class="col-sm-9 form-input">
                   <input type="text" name="hse_hazard" class="form-control" id="hse_hazard" value="{{ $hsehazard->hse_hazard }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="hover_message" class="col-sm-3 col-form-label require">Message</label>
                <div class="col-sm-9 form-input">
                    <textarea name="hover_message" id="hover_message" class="form-control" rows="5">{{ $hsehazard->hover_msg }}</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
<script>
    $(".select2").select2({
        dropdownParent: $('#popupwindowmodal')
    });

    $(function() {
        $('#hse_hazard_edit').validate({
            rules: {
                atar_type: {
                    required: true,
                },
                zefa_rule: {
                    required: true,
                },
                hse_hazard: {
                    required: true,
                },
                hover_message: {
                    required: true,
                },
            },
            messages: {
                atar_type: {
                    required: "Please select ATAR Type",
                },
                zefa_rule: {
                    required: "Please select ZeFA Rule",
                },
                hse_hazard: {
                    required: "Please enter HSE Hazard",
                },
                hover_message: {
                    required: "Please enter Message",
                },
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
</script>
