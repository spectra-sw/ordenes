
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <style>
      .bg-1 {
        background-color: rgb(134,169,189)
      }
      .bg-2{
        background-color: rgb(111,188,176)
      }
      .bg-3{
        background-color: rgb(70,156,87)
      }
      .bg-4{
        background-color: rgb(221,221,221)
      }
</style>
  

</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-1">
  <div class="container-fluid">
    <a class="navbar-brand" href="javascript:void(0)">Spectra- Time Tracker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
         
          <a class="nav-link active" href="javascript:void(0)">
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
  <h3>Navbar Forms</h3>
  <p>You can also include forms inside the navigation bar.</p>
</div>

</body>
</html>


