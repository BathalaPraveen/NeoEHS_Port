<div>
    <form action="{{ admin_url('incident/master/category/add/submit') }}" id="category_add" method="POST" novalidate>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Incident Category Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="category_name" class="col-sm-3 col-form-label require">Category Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="">
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
            $('#category_add').validate({
                rules: {

                    activity: {
                        required: true,
                    },
                    category_name: {
                        required: true,
                    },


                },
                messages: {
                    activity: {
                        required: "Please select Activity",
                    },
                    category_name: {
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
