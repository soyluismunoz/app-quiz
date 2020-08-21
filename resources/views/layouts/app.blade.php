<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Certificaciones') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link href="{{ asset('admin/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link type="text/css" href="{{ asset('admin/css/argon.css?v=1.0.0') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @else
                    <a class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('login') }}">
                                    <i class="ni ni-key-25"></i>
                                    <span class="nav-link-inner--text">{{ __('Iniciar Sesion') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('register') }}">
                                    <i class="ni ni-circle-08"></i>
                                    <span class="nav-link-inner--text">{{ __('Registrarse') }}</span>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="{{ route('home') }}">
                                    <i class="ni ni-planet"></i>
                                    <span class="nav-link-inner--text">{{ __('Quizes') }}</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link nav-link-icon dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="ni ni-single-02"></i>
                                    <span class="nav-link-inner--text">{{ Auth::user()->name }}</span>
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
