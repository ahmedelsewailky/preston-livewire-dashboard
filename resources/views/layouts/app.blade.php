<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ locale: @js(auth()->user()->locale), theme: @js(auth()->user()->theme) }"
    x-on:update-settings.window="locale = $event.detail.locale; theme = $event.detail.theme"
    x-bind:dir="locale == 'ar' ? 'rtl' : 'ltr'" x-bind:class="theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? __('Undefined') }}</title>

    <!-- Css Files & Libraries -->
    @if (auth()->user()->locale == 'en')
        <link rel="stylesheet" href="{{ asset('dashboard/vendors/bootstrap/css/bootstrap.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('dashboard/vendors/bootstrap/css/bootstrap.rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/vendors/simple-scrollbar/simple-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    @stack('css')
</head>

<body>
    <div id="dashboard-app">
        <div class="preload">
            <svg>
                <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                    Preston
                </text>
            </svg>
        </div>
        <div class="body-warpper">
            <!-- Sidebar -->
            <livewire:partials.sidebar />
            <!-- ./Sidebar -->

            <!-- Main Content -->
            <main class="main-content">
                <livewire:partials.navigation />

                <div class="container">
                    <div class="py-3 mb-2 d-flex">
                        <div class="me-auto">
                            <h6 class="page-title">{{ str_replace('.',' ',request()->route()->getName()) }}</h6>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    {{ $breadcrumbs }}
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                {{ $slot }}

                @include('partials.footer')
            </main>
            <!-- ./Main Content -->
        </div>
    </div>

    <script src="{{ asset('dashboard/vendors/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendors/simple-scrollbar/simple-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/js/main.js') }}"></script>
    @stack('js')
</body>

</html>
