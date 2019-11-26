<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" 
              rel="stylesheet" type="text/css">
        <!-- CSS -->
        <link href="{{ asset('css/app.css')}}" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div id="app">
            <main-app></main-app>
            <!-- set progressbar -->
            <vue-progress-bar></vue-progress-bar>
        </div>
        <!-- JavaScript -->
        <script src="{{ asset('js/app.js')}}"></script>
    </body>
</html>
