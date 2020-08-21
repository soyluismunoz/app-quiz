<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Icons -->
        <link href="{{ asset('admin/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">

        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('admin/css/argon.css?v=1.0.0') }}" rel="stylesheet">
        
    </head>
    <body class="{{ $class ?? '' }}">
       <div id="app">
            @auth()
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @include('layouts.navbars.sidebar')
            @endauth
            
            <div class="main-content">
                @include('layouts.navbars.navbar')
                @yield('content')
            </div>

            @guest()
                @include('layouts.footers.guest')
            @endguest
       </div>

        <script src="{{ asset('admin/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        
        @stack('js')
        
        <!-- Argon JS -->
        <script src="{{ asset('admin/js/argon.js?v=1.0.0') }}"></script>
    </body>
</html>