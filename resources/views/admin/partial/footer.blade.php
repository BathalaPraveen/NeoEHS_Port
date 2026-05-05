</div>
<!--end page wrapper -->
<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
    <p class="mb-0">Copyright © {{ date('Y') }} All Rights Reserved. <span style="float: right">
            Powered By <img style="width:80px" src="{{ url('public/assets/images/logo-img.jpg') }}" alt="">
        </span></p>

</footer>
</div>

<!----- popup starts----->
<div class="modal modal-info fade" id="popupwindowmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        </div>
    </div>
</div>

<!----- popup ends----->

<!--end wrapper-->
<!--start switcher-->
<div class="switcher-wrapper">
    <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
    </div>
    <div class="switcher-body">
        <div class="d-flex align-items-center">
            <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
            <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
        </div>
        <hr />
        <h6 class="mb-0">Theme Styles</h6>
        <hr />
        <div class="d-flex align-items-center justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
                <label class="form-check-label" for="lightmode">Light</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
                <label class="form-check-label" for="darkmode">Dark</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
                <label class="form-check-label" for="semidark">Semi Dark</label>
            </div>
        </div>
        <hr />
        <div class="form-check">
            <input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
            <label class="form-check-label" for="minimaltheme">Minimal Theme</label>
        </div>
        <hr />
        <h6 class="mb-0">Header Colors</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator headercolor1" id="headercolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor2" id="headercolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor3" id="headercolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor4" id="headercolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor5" id="headercolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor6" id="headercolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor7" id="headercolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator headercolor8" id="headercolor8"></div>
                </div>
            </div>
        </div>
        <hr />
        <h6 class="mb-0">Sidebar Backgrounds</h6>
        <hr />
        <div class="header-colors-indigators">
            <div class="row row-cols-auto g-3">
                <div class="col">
                    <div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
                </div>
                <div class="col">
                    <div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap JS -->
<script src="{{ url('public/assets/js/bootstrap.bundle.min.js') }}"></script>



<!--plugins-->
<script src="{{ url('public/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ url('public/assets/plugins/select2/js/select2.min.js') }}"></script>





<!-- custom JS -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="{{ url('public/assets/plugins/notifications/js/notifications.min.js') }}"></script>
<script src="{{ url('public/assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

<script src="{{ url('public/assets/plugins/DataTables/datatables.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"
    integrity="sha512-6S5LYNn3ZJCIm0f9L6BCerqFlQ4f5MwNKq+EthDXabtaJvg3TuFLhpno9pcm+5Ynm6jdA9xfpQoMz2fcjVMk9g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ url('public/assets/js/moment.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>




<script src="{{ url('public/assets/js/custom-validation.js') }}"></script>
<script src="{{ url('public/assets/js/script.js') }}"></script>

<script src="{{ url('public/assets/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"
    integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"
    integrity="sha512-T+qL8JzVjquTv+yKR64v+58O+GVCe7A68gbJTzFVs76I7iAcgwisXKyOTaeKZaekcHeiG65p48NDqcMmPgnvIA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.js"
    integrity="sha512-x0qixPCOQbS3xAQw8BL9qjhAh185N7JSw39hzE/ff71BXg7P1fkynTqcLYMlNmwRDtgdoYgURIvos+NJ6g0rNg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"
    integrity="sha512-1QoWYDbO//G0JPa2VnQ3WrXtcgOGGCtdpt5y9riMW4NCCRBKQ4bs/XSKJAUSLIIcHmvUdKCXmQGxh37CQ8rtZQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!--app JS-->
<script src="{{ url('public/assets/js/app.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function datepickercall() {
        $(".datepicker").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'startDate': '{{ todayDate() }}',
        });

        $(".todaymaxdatepicker").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
            'orientation': 'bottom',
            'todayHighlight': true,
            'endDate': '{{ todayDate() }}',
        });
        $(".alldatepicker").datepicker({

            'format': "dd-mm-yyyy",
            'autoclose': true,
           
        });


    }

    function getEndDate(fromdate, addValue, type = {{ ADD_DATE }}, endDate = "") {


        var fromdate = moment(fromdate, 'DD-MM-YYYY').toDate();

        var currentDateTarget = new Date(fromdate);
        var futureDateTarget = new Date(fromdate);

        if (type === 1) {
            addValue = addValue - 1;
            futureDateTarget.setDate(currentDateTarget.getDate() + addValue); // add days
        } else if (type === 2) {
            futureDateTarget.setMonth(currentDateTarget.getMonth() + addValue); // add months
        } else if (type === 3) {
            futureDateTarget.setFullYear(currentDateTarget.getFullYear() + addValue); // add years
        } else {
            // Invalid type
            return null;
        }

        if (endDate != '') {
            var endDate = moment(endDate, 'DD-MM-YYYY').toDate();
            if (endDate && futureDateTarget > new Date(endDate)) {

                futureDateTarget = new Date(endDate);
            }
        }



        var day = futureDateTarget.getDate();
        var month = futureDateTarget.getMonth() + 1; // Months are 0-indexed
        var year = futureDateTarget.getFullYear();

        // Add leading zeros if needed
        if (day < 10) {
            day = "0" + day;
        }

        if (month < 10) {
            month = "0" + month;
        }

        var formattedDate = day + "-" + month + "-" + year;

        return formattedDate;
    }

    function timepickercall() {

        $(".clockpicker").clockpicker({
            twelvehour: true,
            placement: 'bottom',
            autoclose: true,
            donetext: 'Done',
            'default': 'now'
        });


    }

    function datetimepickercall() {

        $(".datetimepicker").datetimepicker({
            format: 'dd-mm-yyyy hh:ii',
            autoclose: true,
            todayHighlight: true,
            minuteStep: 5,
        });


    }


    $(document).ready(function() {

        // Select 2

        $('.select2').select2();

        $(document).ready(function() {
            // $('.select2').on('change', function() {
            //     var parentForm = $(this).closest('form');
            //     parentForm.validate().element(this);
            // });
        });

        datepickercall();
        timepickercall();
        datetimepickercall();


        $(function() {

            $(function() {

            });


            $.fn.datepicker.dates["en"] = {
                days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
                    "Saturday"
                ],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                months: ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ],
                monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                    "Nov", "Dec"
                ],
                today: "Today",
                clear: "Clear",
                format: "dd-mm-yyyy",
                titleFormat: "MM yyyy" /* Leverages same syntax as 'format' */ ,
                weekStart: 0,
            };

        });




        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        })

        $('button[type="reset"]').on('click', function() {

            $('.select2').each(function() {
                var $select = $(this);

                // Use setTimeout to delay resetting each select element
                setTimeout(function() {
                    $select.trigger('change');
                }, 0);
            });

            var form = $(this).closest('form');
            form.validate().resetForm();
            form[0].reset();


        });

        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        // Tooltips

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });


        @if ($message = Session::get('success'))
            toastMixin.fire({
                icon: 'success',
                animation: true,
                title: '{{ $message }}',
                showCloseButton: true,
            });
        @endif

        @if ($message = Session::get('error'))
            toastMixin.fire({
                icon: 'error',
                animation: true,
                title: '{{ $message }}',
                showCloseButton: true,
            });
        @endif




    });
</script>

@stack('script')

<script>
    $(document).on('click', '.popupwindow', function(e) {
        e.preventDefault();
        $('#popupwindowmodal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
</script>

</body>

</html>
