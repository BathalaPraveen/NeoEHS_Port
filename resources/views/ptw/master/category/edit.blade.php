<div>
    <form action="{{ admin_url('ptw/master/category/edit/submit') }}" id="category_edit" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{encryptId($category->id)}}">
        <div class="modal-header">
            <h5 class="modal-title">PTW Category Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="inputEnterYourName" class="col-sm-3 col-form-label">Activity</label>
                <div class="col-sm-9 form-input">
                    <select name="activity" class="select2 form-control" style="width: 100%">
                        <option value="">Select Activity</option>
                        @foreach ($activityList as $activity )
                            <option @if($category->activity_id == $activity->id) selected @endif value="{{ encryptId($activity->id)}}">{{$activity->activity_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="category_name" class="col-sm-3 col-form-label">Category Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="category_name" value="{{$category->category_name}}" class="form-control" id="category_name" placeholder="">
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
            $('#category_edit').validate({
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
