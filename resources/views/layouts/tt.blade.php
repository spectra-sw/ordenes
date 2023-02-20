
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Spectra - Time Tracker</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="{{ URL::asset('css/style_tt.css') }}">
</head>
<body class="random-background-image">

<nav class="navbar navbar-expand-sm navbar-dark bg-1">
  <div class="container-fluid">
    <a class="navbar-brand" href="/menu">Spectra - Time Tracker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="/jornada">
            <i class="bi bi-clock"></i>
            Registros</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="/consultas">
            <i class="bi bi-search"></i>
            Consultas</a>
        </li>
        @if (session('tipo')!=1)
        <li class="nav-item">
          <a class="nav-link active" href="/ocupacion">
            <i class="bi bi-clock"></i>
            Ocupacion</a>
        </li>            
        @endif
        @if (session('tipo')==0)
        <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
                Administración</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/bases">Bases de datos</a></li>
             <!--<li><a class="dropdown-item" href="#">Proyectos</a></li>
              <li><a class="dropdown-item" href="#">Clientes</a></li>-->
            </ul>
        </li>
        @endif
      </ul>
      <!--<form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Buscar">
        <button class="btn btn-primary" type="button">Buscar</button>
      </form>-->
      <p style="color:white">{{ session('nombre') }}&nbsp; <button class="btn btn-primary btn-3" onclick="window.open('/logout','_self')">Salir</button></p>
    </div>
  </div>
</nav>

<div class="container-fluid mt-1">
    @yield('content')
</div>

</body>
</html>


