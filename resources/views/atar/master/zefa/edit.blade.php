<div>
    <form action="{{ admin_url('atar/master/zefa/edit/submit') }}" id="zefa_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{encryptId($zefa->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">Edit ZeFA Rule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="zefa_rule" class="col-sm-3 col-form-label require">ZeFA Rule</label>
                <div class="col-sm-9 form-input ">
                    <textarea name="zefa_rule" id="zefa_rule" class="form-control" rows="5">{{$zefa->zefa_rule}}</textarea>
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
            $('#zefa_edit').validate({
                rules: {


                    zefa_rule: {
                        required: true,
                    },
                },
                messages: {

                    zefa_rule: {
                        required: "Please enter Category Name",
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
