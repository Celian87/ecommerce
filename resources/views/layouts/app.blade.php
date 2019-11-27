<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src={{ asset('js/jquery-3.3.1.js') }}></script>
    <script src={{ asset('js/ecommerce.js') }}></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="col-md-2">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src={{ asset('images/ecommercelogo.png') }} style="width: 75%;">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if ( $admin = Auth::user()->isAdmin() )
                                <li class="nav-item">
                                    <a class="dropdown-item" href="/adminConsole">
                                        ADMIN CONSOLE
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ action('OrdersController@index') }}">
                                        <i class="fas fa-truck-loading"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ action('CartController@index') }}">
                                        @if (App\Cart::all()->count() > 0)
                                            <i class="fas fa-cart-arrow-down"></i>
                                        @else
                                            <i class="fas fa-shopping-cart"></i>
                                        @endif
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item dropdown @if (Auth::user()->isAdmin())  badge-success @endif">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span class="caret">{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if ( !Auth::user()->isAdmin() )
                                        <p class="dropdown-item disabled">
                                            <span>
                                                @php
                                                    echo number_format( Auth::user()->money , 2, ',', '.');
                                                @endphp
                                                €
                                            </span>
                                        </p>
                                        <a class="dropdown-item" href="{{ action('CartController@index') }}">
                                            <span>Il mio carrello</span>
                                        </a>
                                        <a class="dropdown-item" href="{{ action('OrdersController@index') }}">
                                            I miei Ordini
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="/adminConsole">
                                            ADMIN CONSOLE
                                        </a>
                                    @endif
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
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            {{-- Barra categorie --}}
            <div class="container-fluid">
                <ul class="nav navbar-nav">

                    @php
                        $categories = App\Category::orderBy('name')->get();
                    @endphp
                    @foreach ($categories as $category)
                        <li>
                            <a class="btn" href="{{ action('CategoryController@show', $category->id)}}">{{ $category->name }}</a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </nav>

        <main class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-11 ">
                    <!-- Alert bar for errors -->
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <h4 class="alert-heading">Si sono verificati alcuni errori</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li><b>{{ $error }}</b></li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            @yield('content')
        </main>
    </div>
    @yield('page-javascript')

</body>
</html>
