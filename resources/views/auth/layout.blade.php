<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    {{-- Styles --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('favicon.png') }}">

    <link href="{{ mix('css/admin.css', 'back') }}" rel="stylesheet">

    @yield('scripts')
</head>
<body>
    <main>
        <section class="hero is-light is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column is-12-tablet is-6-desktop is-5-widescreen">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
