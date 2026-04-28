<div>
    <form action="{{ admin_url('hiradc/master/documenttype/edit/submit') }}" id="documenttype_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{encryptId($item->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">Document Type Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Activity</label>
                <div class="col-sm-9 form-input">
                    <select name="document" class="select2 form-control" style="width: 100%">
                        <option value="">Select Document</option>
                        @foreach ($documentList as $document )
                            <option @if($document->id == $item->document_id) selected @endif value="{{ encryptId($document->id)}}">{{$document->document_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="documenttype_name" class="col-sm-3 col-form-label">Document Type Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="documenttype_name" value="{{$item->documenttype_name}}" class="form-control" id="documenttype_name" placeholder="">
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
            $('#documenttype_edit').validate({
                rules: {
                    document: {
                        required: true,
                    },
                    documenttype_name: {
                        required: true,
                    },
                },
                messages: {
                    document: {
                        required: "Please select document",
                    },
                    documenttype_name: {
                        required: "Please enter Document Type Name",
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
