<div>
    <form action="{{ admin_url('ptw/master/item/edit/submit') }}" id="item_add" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($item->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">PTW Item Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Activity</label>
                <div class="col-sm-9 form-input">
                    <select name="activity" id="activity" class="select2 form-control" style="width: 100%">
                        <option value="">Select Activity</option>
                        @foreach ($activityList as $activity )
                            <option @if($activity->id == $item->activity_id) selected @endif value="{{ encryptId($activity->id)}}">{{$activity->activity_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label require">Category</label>
                <div class="col-sm-9 form-input">
                    <select name="category" id="category" class="select2 form-control" style="width: 100%">
                        <option value="">Select Category</option>
                        @foreach ($categoryList as $category )
                            <option @if($category->id == $item->category_id) selected @endif value="{{ encryptId($category->id)}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="item_name" class="col-sm-3 col-form-label require">Item Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="item_name" class="form-control" id="item_name" value="{{$item->item_name}}" placeholder="">
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

                    activity: {
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
                    activity: {
                        required: "Please select Activity",
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

        $('#activity').change(function() {
            var activityId = $(this).val();
            if (activityId) {
                $.ajax({
                    url: "{{admin_url('ptw/master/category/list/')}}" + activityId,
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
