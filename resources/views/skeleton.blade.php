<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @vite(['resources/js/app.js'])
</head>
<body>

<x-header />

@yield('page')

<x-footer />

@vite(['resources/js/app.js'])

@stack('scripts')
</body>
</html>
