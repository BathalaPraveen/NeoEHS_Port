<div>
    <form action="{{ admin_url('hiradc/master/documentcategory/edit/submit') }}" id="category_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($category->id) }}">
        <div class="modal-header">
            <h5 class="modal-title">Checklist Item Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Inspection Type</label>
                <div class="col-sm-9 form-input">

                    <select name="document" id="document" class="select2 form-control" style="width: 100%">
                        <option value="">Select Inspection Type</option>
                        @foreach ($documentList as $document)
                            <option @if ($document->id == $category->document_id) selected @endif
                                value="{{ encryptId($document->id) }}">{{ $document->document_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Category</label>
                <div class="col-sm-9 form-input">
                    <select name="document_type" id="document_type" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>
                        @foreach ($documenttypeList as $documenttype)
                            <option @if ($documenttype->id == $category->documenttype_id) selected @endif
                                value="{{ encryptId($documenttype->id) }}">{{ $documenttype->documenttype_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="category_name" class="col-sm-3 col-form-label require">Item Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="category_name" class="form-control" id="category_name"
                        value="{{ $category->category_name }}" placeholder="">
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
        $('#category_edit').validate({
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
