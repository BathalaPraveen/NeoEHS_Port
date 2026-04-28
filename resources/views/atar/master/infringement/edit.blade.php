<div>
    <form action="{{ admin_url('atar/master/infringement/edit/submit') }}" id="infringement_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($infringement->id) }}">
        <div class="modal-header">
            <h5 class="modal-title">Edit HSE Issues</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="infringement_no" class="col-sm-3 col-form-label require">HSE Hazard</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="infringement_no" class="form-control" id="infringement_no"
                        value="{{ $infringement->infringement_no }}">
                </div>
            </div>

            <div class="row mb-3">
                <label for="type_of_infringement" class="col-sm-3 col-form-label require">Message</label>
                <div class="col-sm-9 form-input">
                    <textarea name="type_of_infringement" id="type_of_infringement" class="form-control" rows="5">{{ $infringement->type_of_infringement }}</textarea>
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
        $('#infringement_edit').validate({
            rules: {

                infringement_no: {
                    required: true,
                },
                type_of_infringement: {
                    required: true,
                },
            },
            messages: {

                infringement_no: {
                    required: "Please enter Infringement No",
                },
                type_of_infringement: {
                    required: "Please enter Type of Infringement",
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
