<div>
    <form action="{{ admin_url('wastemanagement/master/wastetype/add/submit') }}" id="wastetype_add" method="POST" novalidate>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Waste Type Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="type_id" class="col-sm-3 col-form-label require">Waste Type ID</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="type_id" class="form-control" id="type_id" placeholder="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="type_name" class="col-sm-3 col-form-label require">Waste Type Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="type_name" class="form-control" id="type_name" placeholder="">
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
            $('#wastetype_add').validate({
                rules: {
                    type_id: {
                        required: true,
                    },
                    type_name: {
                        required: true,
                    },
                },
                messages: {
                    type_id: {
                        required: "Please enter Waste Type ID",
                    },
                    type_name: {
                        required: "Please enter Waste Type Name",
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
