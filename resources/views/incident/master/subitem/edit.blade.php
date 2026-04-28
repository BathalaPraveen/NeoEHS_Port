<div>
    <form action="{{ admin_url('incident/master/subitem/edit/submit') }}" id="item_add" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($subitem->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">Sub Item Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Category</label>
                <div class="col-sm-9 form-input">

                    <select name="category" id="category" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>
                        @foreach ($categoryList as $category )
                            <option @if($category->id == $subitem->category_id) selected @endif value="{{ encryptId($category->id)}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Item</label>
                <div class="col-sm-9 form-input">
                    <select name="item" id="item" class="select2 form-control" style="width: 100%">
                        <option value="">Select Item</option>
                        @foreach ($itemList as $item )
                            <option @if($item->id == $subitem->item_id) selected @endif value="{{ encryptId($item->id)}}">{{$item->item_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="subitem_name" class="col-sm-3 col-form-label require">Sub Item Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="subitem_name" class="form-control" id="subitem_name" value="{{$subitem->subitem_name}}" placeholder="">
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
                    category: {
                        required: true,
                    },
                    item: {
                        required: true,
                    },
                    subitem_name: {
                        required: true,
                    },
                },
                messages: {

                    category: {
                        required: "Please select Category",
                    },
                    item: {
                        required: "Please select Item",
                    },
                    subitem_name: {
                        required: "Please enter Sub Item Name",
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

        $('#checklistitem').change(function() {
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
