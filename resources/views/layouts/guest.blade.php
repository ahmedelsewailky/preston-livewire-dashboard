<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('dashboard/vendors/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard/vendors/boxicons/css/boxicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
