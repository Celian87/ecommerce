{{-- Layout principale del sito --}}

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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Styles -->
    <style>
        .w3-sidebar a {font-family: "Roboto", sans-serif}
        body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('head')

</head>
<body class="w3-content" style="max-width:1300px">
<br>
    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3; width:250px;" id="mySidebar">
        <div class="w3-container w3-display-container w3-padding-16">
            <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
            <h3 class="w3-wide"><b>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src={{ asset('images/logo.png') }} style="width: 75%;">
                </a></b>
            </h3>
        </div>
        <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">

            @guest
                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
            @else
                <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
                    {{ Auth::user()->name }}<i class="fa fa-caret-down"></i>
                </a>
                <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium" style="background-color: #d6f4ff">
                    
                    @if ( $admin = Auth::user()->isAdmin() )
                        <a href="/adminConsole" class="w3-bar-item w3-button badge-success">
                            ADMIN CONSOLE
                        </a>
                    @else
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
            @endguest

            <br>


            @foreach (App\Category::orderBy('name')->get() as $category)
                <a class="dropdown-item" href="{{ action('CategoryController@show', $category->id)}}">{{ $category->name }}</a>
            @endforeach
        </div>
    </nav>

    <!-- Top menu on small screens -->
    <header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
        <div class="w3-bar-item w3-padding-24 w3-wide">
            <a href="{{ url('/') }}" style="color: inherit">
                NERDHERD
            </a>
        </div>
        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

    <!-- !PAGE CONTENT! -->
    <div class="w3-main" style="margin-left:250px">

        <!-- Push down content on small screens -->
        <div class="w3-hide-large" style="margin-top:83px">
        </div>

        <!-- Top header -->
        <header class="w3-container w3-xlarge">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div class="col-md-4">
                        <p class="w3-left" style="color: #08a3de !important; font-size: 30px; font-weight: bold;">
                            @yield('name-page')
                        </p>
                    </div>

                    <div class="col-md-3">
                        <div class="box_search" style="float: left; width: 100%;">
                            <form action="{{ action('ProductsController@search') }}" method="get">
                                <input type="text" name="name" id="search" class="form-control" placeholder="Cerca prodotto">
                            </form>
                        </div>
                    </div>
                    

                    <div class="col-md-4">
                        @if ( Auth::check() )
                            <p class="w3-right">
                                @if ( $admin = Auth::user()->isAdmin() )
                                    <a class="w3-bar-item w3-padding" href="/adminConsole">
                                        ADMIN CONSOLE
                                    </a>
                                @else
                                    <a href="{{ action('OrdersController@index') }}">
                                        <i class="fas fa-truck-loading"></i>
                                    </a>
                                    <a href="{{ action('CartController@index') }}">
                                        @if (App\Cart::all()->count() > 0)
                                            <i class="fas fa-cart-arrow-down"></i>
                                        @else
                                            <i class="fas fa-shopping-cart"></i>
                                        @endif
                                    </a>
                                @endif
                            </p>
                        <!--i class="fa fa-shopping-cart w3-margin-right"></i-->{{--Icona carello--}}
                        @endif
                    </div>
                </div>
            </div>
        </header>


        <main class="py-4" style="min-height: 500px">
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
        

        <!-- Footer -->
        <footer class="w3-padding-64 w3-light-grey w3-small w3-center" id="footer" style="background-color: #1bb1ea !important; color: #fff !important">
            <div class="w3-row-padding">
                <div class="w3-col s4 w3-justify">
                    <h4>Store</h4>
                    <p><i class="fa fa-fw fa-map-marker"></i> Ecommerce Srl</p>
                    <p><i class="fa fa-fw fa-envelope"></i> admin@gmail.com</p>
                </div>
                <div class="w3-col s4 w3-justify w3-right">
                    <h4>Accettiamo</h4>
                    <p><i class="fa fa-fw fa-credit-card"></i> Credit Card</p>
                    <br>
                    
                </div>
            </div>
        </footer>

        <div class="w3-black w3-center w3-padding-24">
            Copyright © 2018-2019 Ecommerce S.R.L - All rights reserved
        </div>
        <!-- End page content -->
    </div>

    @yield('page-javascript')

    <script>
        // Accordion 
        function myAccFunc() {
            var x = document.getElementById("demoAcc");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            }else{
                x.className = x.className.replace(" w3-show", "");
            }
        }

        // Click on the "Jeans" link on page load to open the accordion for demo purposes
        document.getElementById("myBtn").click();

        // Open and close sidebar
        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("myOverlay").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("myOverlay").style.display = "none";
        }

        myAccFunc();
    </script>

</body>
</html>
