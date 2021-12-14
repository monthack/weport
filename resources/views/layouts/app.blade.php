<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    body{
    padding-bottom:4.2rem;
    } 
    
    .dropd,.drop-menu-bottom{
        background-color: transparent;
        border: none;
        font-size: 18px;
        color: #333;
        outline: 0 !important;
        padding: 0px;
    }
	.dropd > *,
	.drop-menu-bottom > * {
		vertical-align: middle;
	}
	.dropd .icon,
	.drop-menu-bottom .icon{
		color: #EE7421;
		vertical-align: top;
	}
	.dropd .down,
	.drop-menu-bottom .down{
		vertical-align: top;
	}
	.dropd + .dropdown-menu.show{
		padding: 4px 48px;
		border: 0px solid transparent;
		border-radius: 0px 0px 7px 7px;
		background-color: #DCEAF8;
	}

	.dropd + .dropdown-menu.show .dropdown-item{
		background-color: transparent !important;
		color: #333333 !important;
	}
    /*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/
    #footer {
    color: #37423b;
    font-size: 14px;
    background: #eef0ef;
    bottom: 0;
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <h1><a class="logo me-auto" href="{{ url('/') }}">
                    {{ config('app.name', 'Weport') }}
                </a></h1>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                    <h4>Hola</h4>
                </button>

                <div class="navbar order-last order-lg-0" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrase') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <button class="dropd" type="button" id="dropMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     Hola, {{ Auth::user()->name }} <i class="bi bi-chevron-down"></i>
                                </button>
                                

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @include('layouts.footer')
</body>
</html>
