<div>
    <form action="{{ admin_url('machinery/master/machinerytype/edit/submit') }}" id="machinery_type_edit" method="POST"
        novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($machineryType->id) }}">
        <div class="modal-header">
            <h5 class="modal-title">Machinery Type Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="machinery_type" class="col-sm-3 col-form-label require">Machinery Type Name</label>
                <div class="col-sm-9 form-input ">
                    <textarea name="machinery_type" id="machinery_type" class="form-control" rows="5">{{ $machineryType->machinery_type }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label for="machinery_description" class="col-sm-3 col-form-label require">Machinery Type Name</label>
                <div class="col-sm-9 form-input ">
                    <textarea name="machinery_description" id="machinery_description" class="form-control" rows="5">{{ $machineryType->machinery_description }}</textarea>
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
        $('#machinery_type_edit').validate({
            rules: {
                machinery_type: {
                    required: true,
                },
            },
            messages: {

                machinery_type: {
                    required: "Please enter Machinery Type Name",
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
