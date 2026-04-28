<div>
    <form action="{{ admin_url('inspection/master/checklistitem/add/submit') }}" id="item_add" method="POST" novalidate>
        @csrf

        <div class="modal-header">
            <h5 class="modal-title">Checklist Item Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inspectiontype" class="col-sm-3 col-form-label require">Inspection Type</label>
                <div class="col-sm-9 form-input">
                    <select name="inspectiontype" id="inspectiontype" class="select2 form-control" style="width: 100%">
                        <option value="">Select Inspection Type</option>
                        @foreach ($inspectiontypeList as $inspectiontype )
                            <option value="{{ encryptId($inspectiontype->id)}}">{{$inspectiontype->inspectiontype_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="category" class="col-sm-3 col-form-label require">Category</label>
                <div class="col-sm-9 form-input">
                    <select name="category" id="category" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>

                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="item_name" class="col-sm-3 col-form-label require">Item Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="item_name" class="form-control" id="item_name" placeholder="">
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
            $('#item_add').validate({
                rules: {

                    inspectiontype: {
                        required: true,
                    },
                    category: {
                        required: true,
                    },
                    item_name: {
                        required: true,
                    },
                },
                messages: {
                    inspectiontype: {
                        required: "Please select Inspection Type",
                    },
                    category: {
                        required: "Please select Category",
                    },
                    item_name: {
                        required: "Please enter Item Name",
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

        $('#inspectiontype').change(function() {
            var inspectiontypeId = $(this).val();
            if (inspectiontypeId) {
                $.ajax({
                    url: "{{admin_url('inspection/master/checklistcategory/list/')}}" + inspectiontypeId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#category').empty().append('<option value="">Select Category</option>');
                        $.each(data, function(key, value) {
                            $('#category').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });

                        $('#category').trigger('change.select2');
                    }
                });
            } else {
                $('#category').empty().append('<option value="">Select Category</option>');

                $('#category').trigger('change.select2');
            }
        });

</script>
