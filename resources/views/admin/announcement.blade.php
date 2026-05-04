@extends('admin.layouts.layout')
@section('title', 'Dashboard')
@section('menu', 'announcement')
@section('pageurl', admin_url('dashboard'))

@push('style')
    <style>
        /* ===== PAGE TITLE ===== */
        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 15px;
        }

        /* ===== CARD ===== */
        .announcement-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 14px;
            padding: 16px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        /* HOVER EFFECT */
        .announcement-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        /* ===== HEADER ===== */
        .announcement-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .announcement-header i {
            color: #2ecc71;
            font-size: 16px;
        }

        /* TITLE */
        .announcement-title {
            font-weight: 600;
            color: #001145;
            font-size: 15px;
        }

        /* ===== CONTENT ===== */
        .announcement-content {
            font-size: 14px;
            color: #555;
            line-height: 1.5;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* ===== DATE ===== */
        .announcement-date {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            color: #777;
            margin-top: 10px;
        }

        .announcement-date i {
            font-size: 12px;
        }

        /* ===== EXPAND ON HOVER ===== */
        .announcement-card:hover .announcement-content {
            -webkit-line-clamp: unset;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            justify-content: flex-end;
        }

        /* ===== CONTAINER SPACING ===== */
        .announcement-wrapper {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')

    <div class="container announcement-wrapper">

        <!-- TITLE -->
        <div class="position-relative mb-5">
            <h5 class="card-title text-white">ANNOUNCEMENT</h5>
        </div>

        <!-- LIST -->
        @foreach ($announcementlist as $content)
            <div class="announcement-card">

                <!-- HEADER -->
                <div class="announcement-header">
                    <i class="fa-solid fa-bullhorn"></i>
                    <div class="announcement-title">
                        {{ $content->announcement_title }}
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="announcement-content">
                    {{ $content->announcement_content }}
                </div>

                <!-- DATE -->
                <div class="announcement-date">
                    <i class="fa-regular fa-calendar"></i>
                    {{ \Carbon\Carbon::parse($content->created_at)->format('d F Y') }}
                </div>

            </div>
        @endforeach

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $announcementlist->links() }}
        </div>
        ```

    </div>

@endsection
