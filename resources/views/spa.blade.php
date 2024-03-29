<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex">
        <link rel="stylesheet" href="./css/app.css">
        <link rel="manifest" href="./manifest.json">
        <title>Deta</title>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        
        <script src="./js/app.js"></script>
    </body>
</html>
