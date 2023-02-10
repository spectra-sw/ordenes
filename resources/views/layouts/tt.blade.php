
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
          <a class="nav-link active" href="javascript:void(0)">
            <i class="bi bi-search"></i>
            Consultas</a>
        </li>
       
        <li class="nav-item dropdown">
            <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
                Administración</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Personas</a></li>
              <li><a class="dropdown-item" href="#">Proyectos</a></li>
              <li><a class="dropdown-item" href="#">Clientes</a></li>
            </ul>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="text" placeholder="Buscar">
        <button class="btn btn-primary" type="button">Buscar</button>
      </form>
    </div>
  </div>
</nav>

<div class="container-fluid mt-3">
  
    @yield('content')
</div>

</body>
</html>


