<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" class="@yield('html_class')">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="language" content="{{ LaravelLocalization::getCurrentLocale() }}" />

    <meta property="og:site_name" content="{{ config('app.name') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::url() }}" />

    <meta name="twitter:card" content="photo" />
    <meta name="twitter:url" content="{{ Request::url() }}" />
    <meta name="twitter:domain" content="{{ config('app.url') }}" />

    @hasSection('meta_cover')
        <meta property="og:image" content="@yield('meta_cover')" />
        <meta name="twitter:image" content="@yield('meta_cover')" />
    @else
        <meta property="og:image" content="{{ asset('img/og_default.jpg') }}" />
        <meta name="twitter:image" content="{{ asset('img/og_default.jpg') }}" />
    @endif

    @hasSection('meta_description')
        <meta property="og:description" content="@yield('meta_description')" />
        <meta name="description" content="@yield('meta_description')" />
    @else
        <meta property="og:description" content="@lang('common.meta.description')" />
        <meta name="description" content="@lang('common.meta.description')" />
    @endif

    @hasSection('title')
        <meta property="og:title" content="@yield('title') - {{ config('app.name') }}" />
        <meta name="twitter:title" content="@yield('title') - {{ config('app.name') }}" />
        <title>@yield('title') - SITE_NAME</title>
    @else
        <meta property="og:title" content="{{ config('app.name') }}" />
        <meta name="twitter:title" content="{{ config('app.name') }}" />
        <title>{{ config('app.name') }}</title>
    @endif

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="@yield('body_class')">
    <div id="app">
        @include('layout.header')

        @yield('content')

        @include('layout.footer')
    </div>

    <script>
    window.COOKIE_DOMAIN = '{{ config('app.domain') }}';
    window.PRIVACY_POLICY_URL = '';
    window.GTAG_ID = '{{ config('services.analytics.gtag') }}';
    </script>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
