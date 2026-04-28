@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('menu', 'announcement')
@section('pageurl', admin_url('dashboard'))

@push('style')
    <style>
        .pagination {
            float: right;
        }

        .anouncementcard {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            margin: 10px;
            overflow: hidden;
            position: relative;
            max-height: 10em;
            /* Approx height for 2 lines of text */
            transition: max-height 0.3s ease;
        }

        .content {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endpush

@section('content')

    <div class="container">

        <div class="container para">
            <div class="position-relative">
                <h5 class="card-title text-white">ANNOUNCEMENT</h5>
            </div>

            @foreach ($announcementlist as $content)
                <div class="row mt-2">
                    <div class="col-md-12" data-aos="zoom-out" data-aos-delay="100">
                        <div class="icon-box anouncementcard">
                            <div class="content">
                                <p class="side-heading">{{ $content->announcement_title }}</p>
                                <p class="para-1">{{ $content->announcement_content }}</p>
                                <div class="container time">
                                    <small class="text-muted">{{ timeago($content->created_at) }}</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row mt-2 ">
                <div class="col-md-12">
                    {{ $announcementlist->links() }}
                </div>
            </div>
        </div>
    @endsection



    @push('script')
        <script>
            $(document).ready(function() {
                $('.anouncementcard').hover(
                    function() {
                        // Mouse enters the card
                        $(this).css('max-height', 'none');
                        $(this).find('.content').css('-webkit-line-clamp', 'unset');
                    },
                    function() {
                        // Mouse leaves the card
                        $(this).css('max-height', '10em');
                        $(this).find('.content').css('-webkit-line-clamp', '2');
                    }
                );
            });
        </script>
    @endpush
