<div>
    <form action="{{ admin_url('wastemanagement/master/disposaltype/edit/submit') }}" id="disposaltype_edit" method="POST"
        novalidate>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Packaging Type Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="disposaltype_name" class="col-sm-3 col-form-label require">Type of Packaging</label>
                <div class="col-sm-9 form-input">
                    <input type="hidden" name="id" value="{{ encryptId($disposaltype->id) }}">
                    <input type="text" name="disposaltype_name" class="form-control" id="disposaltype_name"
                        value="{{ $disposaltype->disposaltype_name }}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="disposaltype_name" class="col-sm-3 col-form-label require">Packaging Capacity</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="packaging_capacity" class="form-control" id="packaging_capacity"
                        value="{{ $disposaltype->packaging_capacity }}">
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
        $('#disposaltype_edit').validate({
            rules: {
                disposaltype_name: {
                    required: true,
                },
                packaging_capacity: {
                    required: true,
                },
            },
            messages: {

                disposaltype_name: {
                    required: "Please enter Type of Packaging",
                },
                packaging_capacity: {
                    required: "Please enter Packaging Capacity",
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
