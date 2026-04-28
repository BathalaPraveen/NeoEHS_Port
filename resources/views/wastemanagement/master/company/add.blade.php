<div>
    <form action="{{ admin_url('wastemanagement/master/company/add/submit') }}" id="category_add" method="POST" novalidate>
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Waste Company Add</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body m-3">
            <div class="row mb-3">
                <label for="company_name" class="col-sm-3 col-form-label require">Company Name</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="company_name" class="form-control" id="company_name" placeholder="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="company_address" class="col-sm-3 col-form-label require">Company Address</label>
                <div class="col-sm-9 form-input">
                    <textarea type="text" name="company_address" class="form-control" id="company_address" placeholder=""></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="person_incharge" class="col-sm-3 col-form-label require">Person in Charge</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="person_incharge" class="form-control" id="person_incharge" placeholder="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="contact_no" class="col-sm-3 col-form-label require">Contact No.</label>
                <div class="col-sm-9 form-input">
                    <input type="phone" name="contact_no" class="form-control" id="contact_no" placeholder="">
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label require">Email</label>
                <div class="col-sm-9 form-input">
                    <input type="text" name="email" class="form-control" id="email" placeholder="">
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
                    company_name: {
                        required: true,
                    },
                    company_address: {
                        required: true,
                    },
                    person_incharge: {
                        required: true,
                    },
                    contact_no: {
                        required: true,
                        mobileNumber:true,
                    },
                    email: {
                        required: true,
                        customEmail:true,
                    },
                },
                messages: {
                    company_name: {
                        required: "Please enter Company Name",
                    },
                    company_address: {
                        required: "Please enter Company Address",
                    },
                    person_incharge: {
                        required: "Please enter Person in Charge",
                    },
                    contact_no: {
                        required: "Please enter Contact No.",
                        mobileNumber:"Please enter a valid 10-digit mobile number",
                    },
                    email: {
                        required: "Please enter Email",
                        customEmail:"Please enter Valid Email",
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
