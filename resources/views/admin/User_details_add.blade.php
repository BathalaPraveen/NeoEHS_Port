@extends('admin.layouts.layout')
@section('title', 'User Add')
@section('pageurl', admin_url('User_Management'))
<style type="text/css">
    .error {
        color: red;
        margin: 10px;
    }
</style>
@section('content')
    <!-- start page content wrapper-->
    <div class="page-content-wrapper">
        <!-- start page content-->
        <div class="page-content">
            <div class="card page-breadcrumb  d-sm-flex align-items-center mb-3">
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0 align-items-center">
                            <li class="breadcrumb-item"><a href="{{ admin_url('home') }}">
                                    <ion-icon name="home-outline"></ion-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{ admin_url('user_management') }}">User List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Add</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto button-action">
                    <div class="btn-group  btn-skew">
                        <a class="btn btn-outline-primary" href="{{ admin_url('user_management') }}"> Back</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card border radius-10 mt-2">
                        <div class="card-body">
                            <form id="UserAdd" class="forms-sample" method="post"
                                action="{{ admin_url('UserAddSubmit') }}" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="row g-3 ">
                                        <div class="col-4 form-group">
                                            <label class="form-label">User Name </label>
                                            <input type="text" class="form-control rounded-pill" id="user_name"
                                                name="user_name" placeholder="User Name">
                                            @error('user_name')
                                                <span class="error ">{{ $errors->first('user_name') }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4 form-group">
                                            <label class="form-label">Contact Number </label>
                                            <input type="text" class="form-control rounded-pill" name="mobile"
                                                id="mobile" placeholder="Contact Number">
                                            <span id="p1length_error"></span>
                                            @error('mobile')
                                                <span class="error ">{{ $errors->first('mobile') }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4 form-group">
                                            <label class="form-label">Country </label>
                                            <select class="form-select rounded-pill" name="country"
                                                aria-label="Default select example">
                                                <option value=''>Select Country</option>
                                                @foreach ($country_details as $country)
                                                    <option @if (old('country') == encryptId($country->id)) selected @endif
                                                        value="{{ encryptId($country->id) }}">
                                                        {{ $country->country }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4 form-group">
                                            <label class="form-label">Email </label>
                                            <input type="text" class="form-control rounded-pill" name="email"
                                                placeholder="Email">
                                            @error('email')
                                                <span class="error ">{{ $errors->first('email') }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4 form-group">
                                            <label class="form-label">Profile Image </label>
                                            <input class="form-control" type="file" name="profile_image"
                                                id="profile_image" accept=".png, .jpg, .jpeg"
                                                style="border-radius: 1.25rem;" onchange="return fileValidation()">
                                            <span id="profile_image_error" class="error"></span>
                                        </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" id="user_add" class="px-4 btn btn-primary btn-skew"><span
                                                class="fs-7">Add</span></button>
                                        <a class="px-4 btn btn-secondary btn-skew fs-7"
                                            href="{{ admin_url('user_management') }}">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
            <!-- end page content-->
        </div>
        @push('script')
            <script type="text/javascript">
                function fileValidation() {
                    var fileInput = document.getElementById('profile_image');
                    var filePath = fileInput.value;

                    // Allowing file type
                    var allowedExtensions = /(\.png|\.jpeg|\.gif|\.jpg)$/i;

                    if (!allowedExtensions.exec(filePath)) {
                        var errorSpan = document.getElementById('profile_image_error');
                        errorSpan.textContent = 'Accepted file formats are: PNG, JPEG, GIF,JPG';
                        $("#user_add").prop('disabled', true); //disable
                        form.submit();
                        fileInput.value = '';

                        return false;

                    } else {
                        $("#user_add").prop('disabled', false); //disable
                        form.submit();
                    }
                }
                // $('#mobile').on('keyup', function() {
                //     if (this.value == '') {
                //         $('#p1length_error').hide();
                //         return true;
                //     }
                //     var plength = $('#mobile').val().length;
                //     if (plength >= 10 && plength <= 14 && phone1 != null) {
                //         $('#p1length_error').hide();
                //     } else {
                //         $('#p1length_error').text('Number should be 10-14digits').css('color',
                //             'red').show();
                //     }

                // });



                $('#reset').on('click', function() {
                    window.location.reload();
                })
                $(function() {
                    validator = $('#UserAdd').validate({
                        rules: {
                            user_name: {
                                required: true,
                                maxlength: 30,
                                noSpaceAtEdges: true,
                                noConsecutiveSpaces: true,
                                alphaOnly: true,

                            },
                            mobile: {
                                required: true,
                                number: true,
                                // minlength: phoneminimum,
                                // maxlength: phonemaximum,
                                maxlength: 10,
                                minlength: 10,
                                numberonly: true,
                                noSpaceAtEdges: true,
                                noConsecutiveSpaces: true,

                            },
                            country: {
                                required: true,
                                noSpaceAtEdges: true,
                                noConsecutiveSpaces: true,
                            },
                            email: {
                                required: true,
                                email: true,
                                emailwithdot: true,
                                maxlength: 50,
                                remote: {
                                    url: "{{ admin_url('Useremailcheck') }}",
                                    type: "post",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        email: function() {
                                            return $("input[name='email']").val();
                                        }
                                    },
                                    dataFilter: function(data) {
                                        var json = JSON.parse(data);
                                        if (json.msg == "true") {
                                            return "\"" + "User email already exists" + "\"";
                                        } else {
                                            return 'true';
                                        }
                                    }
                                }
                            },
                            account_details: {
                                required: true,
                            },


                        },
                        messages: {
                            user_name: {
                                required: "Please enter User Name",
                                maxlength: "You have reached your maximum limit of characters allowed",
                            },
                            mobile: {
                                required: "Please enter Contact Number",
                                number: "No spaces at the beginning or end of the number",
                                maxlength: "You have reached your maximum limit of characters allowed",
                                minlength: "You haven't reached your maximum limit of characters allowed",
                            },
                            country: {
                                required: "Please select Country",
                            },
                            email: {
                                required: "Please enter Email",
                                email: "No spaces at the beginning or end of the string",
                                maxlength: "You have reached your maximum limit of characters allowed",
                            },
                            account_details: {
                                required: "Please enter Account Details",
                            },


                        },
                        errorElement: 'div',
                        errorPlacement: function(error, element) {
                            error.addClass('');
                            element.closest('.form-group').append(error);
                        },
                        highlight: function(element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');

                        },
                        submitHandler: function(form) {
                            $("#user_add").prop('disabled', true); //disable
                            form.submit();
                        }
                    });
                });
            </script>
        @endpush
    @stop
