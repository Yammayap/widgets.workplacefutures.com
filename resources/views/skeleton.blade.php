<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content=”noindex,nofollow”>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">
    {!! SEO::generate() !!}
    @vite(['resources/js/app.js'])
</head>
<body>

@yield('page')

@vite(['resources/js/app.js'])

@stack('scripts')
</body>
</html>
