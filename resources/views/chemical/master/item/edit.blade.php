<div>
    <form action="{{ admin_url('chemical/master/item/edit/submit') }}" id="item_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{encryptId($item->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">Chemical Item Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Activity</label>
                <div class="col-sm-9 form-input">
                    <select name="category" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>
                        @foreach ($categoryList as $category )
                            <option @if($category->id == $item->category_id) selected @endif value="{{ encryptId($category->id)}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="item_name" class="col-sm-3 col-form-label">Category Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="item_name" value="{{$item->item_name}}" class="form-control" id="item_name" placeholder="">
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
            $('#item_edit').validate({
                rules: {
                    category: {
                        required: true,
                    },
                    item_name: {
                        required: true,
                    },
                },
                messages: {
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
</script>
