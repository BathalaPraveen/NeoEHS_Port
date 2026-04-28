<div>
    <form action="{{ admin_url('hiradc/master/documentcategory/add/submit') }}" id="item_add" method="POST" novalidate>
        @csrf

        <div class="modal-header">
            <h5 class="modal-title">HIRADC Category Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="document" class="col-sm-3 col-form-label require">Document Name</label>
                <div class="col-sm-9 form-input">
                    <select name="document" id="document" class="select2 form-control" style="width: 100%">
                        <option value="">Select Document Name</option>
                        @foreach ($documentList as $document )
                            <option value="{{ encryptId($document->id)}}">{{$document->document_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="document_type" class="col-sm-3 col-form-label require">Document Type </label>
                <div class="col-sm-9 form-input">
                    <select name="document_type" id="document_type" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>

                    </select>
                </div>
            </div>
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
            $('#item_add').validate({
                rules: {

                    document: {
                        required: true,
                    },
                    document_type: {
                        required: true,
                    },
                    category_name: {
                        required: true,
                    },
                },
                messages: {
                    document: {
                        required: "Please select Document",
                    },
                    document_type: {
                        required: "Please select Document Type",
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

        $('#document').change(function() {
            var documentId = $(this).val();
            if (documentId) {
                $.ajax({
                    url: "{{admin_url('hiradc/master/documenttype/datalist')}}",
                    type: 'POST',
                    data:{
                        documentId : documentId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#document_type').empty().append('<option value="">Select Document Type</option>');
                        $.each(data, function(key, value) {
                            $('#document_type').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        $('#document_type').trigger('change.select2');
                    }
                });
            } else {
                $('#document_type').empty().append('<option value="">Select Document Type</option>');
                $('#document_type').trigger('change.select2');
            }
        });

</script>
