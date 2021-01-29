<!DOCTYPE html>
<html lang="sk">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Prihlásenie | Kartotéka v3</title>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,900;1,300;1,500;1,900&amp;display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body>
        <div class="body-wrap">
            <div class="login-wrap">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
