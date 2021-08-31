<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ordenes de trabajo - Spectra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
    <style>
      
      
    </style>
</head>
<body>
    <div id="menu">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-2">
                        <img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block" style="cursor:pointer" onclick="window.open('/menu','_self')">
                    </div>
                    <div class="col-2">
                        <p class="font-weight-light">{{ session('nombre') }}&nbsp; <button class="btn btn-primary btn-sm" onclick="window.open('/logout','_self')">Salir</button></p>
                        
                        
                        <!--<nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="/admin" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Menú
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/ordenes">Crear orden</a>
                                        <a class="dropdown-item" href="/consultas">Consultas</a>
                                        <a class="dropdown-item" href="/bases">Bases</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/logout">Salir</a>
                                        </div>
                                    </li>  
                                    </ul>
                                </div>
                        </nav>-->
                    </div>

                </div>
            </div>
            <div class="card-body">
            

                <ul class="nav nav-pills">
                    <li class="nav-item ml-1">
                        <a class="nav-link active" href="/ordenes">CREAR ORDENES</a>
                    </li>
                    @if (session('tipo')==0)
                    <li class="nav-item dropdown ml-2">
                        <a class="nav-link active dropdown-toggle" data-toggle="dropdown" href="#">ADMINISTRACIÓN</a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="consultas">CONSULTAS</a>
                        <a class="dropdown-item" href="bases">BASES DE DATOS</a>
                        <a class="dropdown-item" href="programacion">PROGRAMACION</a>
                        </div>
                    </li>
                    @endif
                    @if (session('tipo')==1)
                    <li class="nav-item ml-2">
                        <a class="nav-link active" href="consultas">CONSULTAR</a>
                    </li>
                    @endif
                    @if (session('tipo')!=1)
                    <li class="nav-item ml-2">
                        <a class="nav-link active" href="ocupacion">REGISTRO DE OCUPACIÓN</a>
                    </li>
                    @endif
                   
                </ul>
                <br>
               

            </div>
        </div>
        <div class="row m-1">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
       
    </div>
</body>