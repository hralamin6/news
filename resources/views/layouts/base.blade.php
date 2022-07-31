<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <meta name="description" content="@yield('description', 'This is an islamic site where you can easily find different kind of essential question and answer related our life.') - {{config('app.name')}}">

    <meta property="og:title" content="@yield('title', 'Home Page') - {{config('app.name')}}" />
    <meta property="og:description" content="@yield('description', 'This is an islamic site where you can easily find different kind of essential question and answer related our life.') - {{config('app.name')}}" />
    <meta property="og:url" content="@yield('url', config('app.url'))" />
    <meta property="og:image" content="{{ url(asset('unnamed.jpg')) }}" />
    <meta property="og:image:secure_url" content="{{ url(asset('unnamed.jpg')) }}" />
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="og:image:width" content="1536" />
    <meta property="og:image:height" content="1024" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="@yield('description', 'This is an islamic site where you can easily find different kind of essential question and answer related our life.') - {{config('app.name')}}" />
    <meta name="twitter:title" content="@yield('title', 'Home Page') - {{config('app.name')}}" />
    <meta name="twitter:image" content="{{ url(asset('unnamed.jpg')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ url(asset('unnamed.jpg')) }}" type="image/x-icon">
    <link rel="icon" href="{{ url(asset('unnamed.jpg')) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--    <script src="{{ asset('js/echo.js') }}"></script>--}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('js')
</head>
<body class="dark:bg-darkBg text-tahiti scrollbar-none" x-data="{nav: false, dark: $persist(false)}" :class="{'dark': dark}">
@yield('body')

@livewireScripts
<script src="{{ asset('js/sa.js') }}"></script>
{{--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<x-livewire-alert::scripts />
<script src="{{ asset('js/spa.js') }}" data-turbolinks-eval="false"></script>
</body>
</html>
