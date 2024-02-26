<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        {{-- todo: styles or link to specific errors stylesheet here when got designs. Will also need to add classes to buttons etc in error views. --}}

    </head>
    <body>
        <h1>
            @yield('code') - @yield('title')
        </h1>
        <div>
            @yield('message')
        </div>
        <div>
            @yield('actions')
        </div>
    </body>
</html>
