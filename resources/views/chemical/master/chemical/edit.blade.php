<div>
    <form action="{{ admin_url('chemical/master/chemical/edit/submit') }}" id="chemical_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($chemical->id) }}">
        <div class="modal-header">
            <h5 class="modal-title"> Chemical Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="machinery_type" class="col-sm-3 col-form-label require">Chemical Name</label>
                <div class="col-sm-9 form-input">
                   <input type="text" name="chemical_name" id="chemical_name" class="form-control" value="{{ $chemical->chemical_name }}">

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
        $('#chemical_edit').validate({
            rules: {
                chemical_name: {
                    required: true,
                },
            },
            messages: {
                chemical_name: {
                    required: "Please enter Chemical Name",
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
