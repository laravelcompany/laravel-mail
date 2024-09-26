<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @include('laravel-mail::layouts.partials.favicons')

    <title>
        @hasSection('title')
            @yield('title')  - Laravel Company London
        @endif
        {{ config('app.name') }}
    </title>

    <link href="{{ asset('vendor/laravel-mail/css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laravel-mail/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/laravel-mail/css/app.css') }}" rel="stylesheet">


    @stack('css')

    <style>
        ul.pagination{
            background: transparent !important;
        }
    </style>

</head>
<body>

@yield('htmlBody')

<script src="{{ asset('vendor/laravel-mail/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-mail/js/popper.min.js') }}"></script>
<script src="{{ asset('vendor/laravel-mail/js/bootstrap.min.js') }}"></script>

<script>
    $('.sidebar-toggle').click(function (e) {
        e.preventDefault();
        toggleElements();
    });

    function toggleElements() {
        $('.sidebar').toggleClass('d-none');
    }
</script>

@stack('js')

</body>
</html>
