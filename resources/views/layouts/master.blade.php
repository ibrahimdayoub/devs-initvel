<!DOCTYPE html>

@php
    $lang = app()->getLocale();
    $dir = $lang == 'ar' ? 'rtl' : 'ltr';
@endphp

<html lang="{{ $lang }}" dir="{{ $dir }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Initvel - @yield('title')</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css?v=' . time()) }}" />
    @yield('css')
</head>

<body class="{{ $lang }}">
    <div class="layout">
        @include('components.header')

        @yield('content')

        @include('components.footer')

        @include('components.message')
    </div>

    <script src="{{ asset('assets/js/main.js?v=0.25') }}" defer></script>
    @yield('js')
</body>

</html>