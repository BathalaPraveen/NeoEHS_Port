@extends('admin.layouts.layout')
@section('title', 'Slider')
@section('pageurl', admin_url('settings/slider'))


@section('content')

   <div class="container">
        <div class="container para mt-3">
            <!--breadcrumb-->
            <div class="card page-breadcrumb d-none d-sm-flex p-2 mb-3">

                <div class="">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item">
                                <a href="{{ admin_url('home') }}"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item " aria-current="page">Administrator</li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard Slider</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card mainCard">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">

                        <div class="position-relative">
                            <h5 class="card-title">Dashboard Slider</h5>
                        </div>
                        <div class="ms-auto">
                        </div>
                    </div>
                    @foreach ($sliderImage as $image)
                        <div class="d-lg-flex align-items-center gap-3 imagelist">

                            <div class="position-relative">
                                <div class="col-md-12">
                                    <a href="{{ url($image->file_path) }}" data-lightbox="final">
                                        <img style="" class="w-50" src="{{ url($image->file_path) }}"
                                            alt="">
                                    </a>

                                </div>
                            </div>
                            <div class="ms-auto">
                                <i class="fa fa-trash imagedelete" style="cursor: pointer"
                                    data-id="{{ encryptId($image->id) }}"></i>
                            </div>
                        </div>
                        <hr />
                    @endforeach

                    <div class="row">

                        <div class="col-md-12">
                            <div class="float-end">
                                <button type="button" class="badge bg-success addMore">Add
                                    More</button>
                            </div>
                        </div>`
                    </div>

                    <form action="{{ admin_url('settings/slider/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-md-12">
                            <div class="row addMoreImage">
                            </div>
                        </div>

                        <div class="row card-bottom" id="submitdiv" style="display: none">
                            <div class="col-12 mt-2 mb-3">
                                <button class="btn btn-primary " type="submit" data-bs-toggle="tooltip"
                                    title="Submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script type="text/javascript">
        $(document).on('click', '.addMore', function() {

            var maximage = 5;
            $("#submitdiv").show();
            var asdElement = document.querySelector(".addMoreImage");

            if (asdElement) {

                var elementsWithClassA = asdElement.getElementsByClassName("col-md-12");

                var count = elementsWithClassA.length;

                if (count >= maximage) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Maximum 5 image only upload!',
                    })
                    return false;
                }

            }
            var baseUrl = "{{ admin_url() }}"

            var html =
                '<div class="col-md-12" style=""><div class="float-end removeImage mt-5 mr-5"><i class="fa fa-trash"></i></div><div class="form-group"><div class="fileinput fileinput-new apprFileinput" style="" data-provides="fileinput"><div class="fileinput-preview thumbnail bootimgheight appbootimgheight" data-trigger="fileinput" style="margin-top:30px;""></div><p class="mini-txt">(png, jpeg, jpg )</p><div class="file-pop"><span class="text-green btn-file"><span class="photo fileinput-new" title="Add Image"><img class="imgupload" src="' +
                baseUrl +
                '/public/assets/images/common/camera.png" style=" width: 30%; "></span><span class="fileinput-exists" title="Add Image"></span><input type="file" name="sliderimage[]" class="atarfile" accept="image/*"></span><button type="button" name="re" class="btn btn-nothing text-maroon fileinput-exists" data-dismiss="fileinput" title="Remove Image"><i class="fa fa-times-circle-o" aria-hidden="true"></i></button></div></div><input type="hidden" name="other_user_img[]" value=""><hr></div></div> ';

            $(".addMoreImage").append(html);

        });

        $(document).on('click', '.removeImage', function() {
            $(this).closest('.col-md-12').remove();

            var asdElement = document.querySelector(".addMoreImage");

            if (asdElement) {

                var elementsWithClassA = asdElement.getElementsByClassName("col-md-12");

                var count = elementsWithClassA.length;

                if (count < 1) {
                    $("#submitdiv").hide();
                }

            }

        });

        $(document).on('click', '.imagedelete', function() {

            id = $(this).attr("data-id");


            var title = 'Do you want to delete the Slider Image';
            var text = 'Delete';
            var btncolor = '#dc3545'



            Swal.fire({
                title: title,
                icon: "warning",
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: text,
                confirmButtonColor: btncolor,
                denyButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn-skew',
                    cancelButton: 'btn-skew'
                },
            }).then((result) => {

                if (result.value) {
                    $(this).closest('.imagelist').remove();
                    $.ajax({
                        url: "{{ admin_url('settings/slider/delete') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                .attr('content')
                        },
                        data: {
                            id: id,
                        },
                        success: function(response) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener(
                                        'mouseenter',
                                        Swal.stopTimer)
                                    toast.addEventListener(
                                        'mouseleave',
                                        Swal.resumeTimer
                                    )
                                }
                            });
                            Toast.fire({
                                icon: 'success',
                                title: response.msg
                            });

                        },
                        error: function(data) {
                            $.notify(data.responseJSON.msg, "error");
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Something went wrong', '', 'info');
                }
            })


        });
    </script>
@endpush
