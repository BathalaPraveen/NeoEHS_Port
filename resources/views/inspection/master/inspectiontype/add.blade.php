<div>
    <form action="{{ admin_url('inspection/master/inspectiontype/add/submit') }}" id="inspectiontype_add" method="POST"
        novalidate>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Inspection Type Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inspectiontype_name" class="col-sm-3 col-form-label require">Inspection Type Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="inspectiontype_name" class="form-control" id="inspectiontype_name" placeholder="">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<script>
    $(".select2").select2({
        dropdownParent: $('#popupwindowmodal')
    });

    $(function() {
        $('#inspectiontype_add').validate({
            rules: {
                inspectiontype_name: {
                    required: true,
                },
            },
            messages: {
                inspectiontype_name: {
                    required: "Please enter Inspection Type Name",
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
