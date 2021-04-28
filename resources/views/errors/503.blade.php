<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="language" content="en" />

    <title>{{ config('app.name ')}}</title>

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="maintenance">
    <section class="section">
        <div class="container is-narrow has-text-centered">
            <h1 class="title is-2">
                Maintenance
            </h1>

            <div class="subtitle is-4">
                We are currently doing some maintenance operations. We'll be back in a few minutes!
            </div>
        </div>
    </section>
</body>
</html>
