<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex">

    <title>{{ config('app.name') }}</title>

    <link href="{{ mix('css/admin.css', 'back') }}" rel="stylesheet">
</head>
<body>
    <app id="app"
        name="{{ config('app.name') }}"
        url="{{ config('app.url') }}"
        default-locale="{{ config('app.locale') }}"
        :available-locales="{{ json_encode(LaravelLocalization::getSupportedLanguagesKeys()) }}"
        :user="{{ request()->user() }}"
    ></app>

    <script src="{{ mix('js/manifest.js', 'back') }}"></script>
    <script src="{{ mix('js/vendor.js', 'back') }}"></script>
    <script src="{{ mix('js/main.js', 'back') }}"></script>
</body>
</html>
