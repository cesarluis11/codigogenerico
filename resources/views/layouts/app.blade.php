<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="shortcut icon" href="#">
</head>
@if(strpos(url()->current(), asset('login')) !== FALSE)
<body style="background-image: url('{{ asset('public/images/PANTALLA CHARLIE.jpg')  }}'); background-size: 100%; background-position:0px 30px;">
@endif
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid col-md-11">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
{{--                             <li class="nav-item">
                                <a class="nav-link" href="{{ route('bakan.create') }}">{{ __('Codigos BAKAN') }}</a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('durex.create') }}">{{ __('Codigos DUREX') }}</a>
                            </li> --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Códigos BAKAN') }}<span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('bakan.create') }}">
                                        {{ __('Nueva Solicitud') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('bakan.indexBusqueda') }}">
                                        {{ __('Ver los Códigos Bakan') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('bakan.revision') }}">
                                        {{ __('Revisión de Códigos Bakan') }}
                                    </a>
                                    {{-- <a class="dropdown-item" href="{{ route('bakan.indexAddComGenBakan') }}">
                                        {{ __('Agregar Componentes a Código Genérico') }}
                                    </a> --}}
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ __('Códigos DUREX') }}<span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('durex.create') }}">
                                        {{ __('Nueva Solicitud') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('durex.indexBusqueda') }}">
                                        {{ __('Ver los Códigos Durex') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('durex.revision') }}">
                                        {{ __('Revisión de Códigos Durex') }}
                                    </a>
                                    {{-- <a class="dropdown-item" href="#">
                                        {{ __('Consultar') }}
                                    </a> --}}
                                </div>
                            </li>
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            @hasanyrole('super-admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('usuarios.index') }}">{{ __('Usuarios') }}</a>
                                </li>
                            @endhasanyrole    
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}<span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    
    <script src="{{ URL::asset('public/js/codGenBakan.js')  }}"></script>
    <script src="{{ URL::asset('public/js/codGenDurex.js') }}"></script>
    <script src="{{ URL::asset('public/js/functGlobales.js') }}"></script>
{{--     <script src="public/js/codGenBakan.js"></script>
    <script src="public/js/codGenDurex.js"></script>
    <script src="public/js/functGlobales.js"></script>
 --}}</body>
</html>
