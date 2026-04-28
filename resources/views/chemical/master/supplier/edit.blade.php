<div>
    <form action="{{ admin_url('chemical/master/supplier/edit/submit') }}" id="supplier" method="POST" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ encryptId($supplier->id) }}">
        <div class="modal-header">
            <h5 class="modal-title">Supplier Edit   </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">

            <div class="row mb-3">
                <label for="supplier_name" class="col-sm-3 col-form-label require">Supplier Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" value="{{ $supplier->id }}" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="address" class="col-sm-3 col-form-label ">Supplier Address</label>
                <div class="col-sm-9 form-input">
                    <textarea name="address" id="address" class="form-control" rows="3">{{ $supplier->address }}</textarea>

                </div>
            </div>
            <div class="row mb-3">
                <label for="contact_no" class="col-sm-3 col-form-label ">Supplier Contact Number</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ $supplier->contact_no }}"  >
                </div>
            </div>
            <div class="row mb-3">
                <label for="email_id" class="col-sm-3 col-form-label ">Supplier Email ID</label>
                <div class="col-sm-9 form-input">
                    <input type="email" name="email_id" id="email_id" class="form-control" value="{{ $supplier->email_id }}"  >
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
        $('#supplier').validate({
            rules: {
                supplier_name: {
                    required: true,
                },
                email_id: {
                    email: true,
                }
            },
            messages: {
                supplier_name: {
                    required: "Please enter Supplier Name",
                },
                email_id: {
                    required: "Please enter valid Email id",
                }
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
