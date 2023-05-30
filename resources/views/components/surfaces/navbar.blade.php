<nav class="navbar navbar-expand-lg navbar-dark bg-1 py-3">
  <div class="container-fluid">
    <a class="navbar-brand " href="/menu">Spectra - Time Tracker</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link active" href="/jornada">
            <i class="bi bi-clock"></i>
            Registros</a>
        </li>
        @if (session('tipo')==0)
        <li class="nav-item">
          <a class="nav-link active" href="/consultas">
            <i class="bi bi-search"></i>
            Consultas</a>
        </li>
        @endif
        @if (session('tipo')!=1)
        <li class="nav-item">
          <a class="nav-link active" href="/ocupacion">
            <i class="bi bi-clock"></i>
            Ocupación</a>
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
      <div class="d-flex align-items-center text-white">
        <p class="m-0">{{ session('nombre') }}</p>
        <button class="btn btn-primary btn-3 ms-2" onclick="window.open('/logout','_self')">Salir</button>
      </div>
    </div>
  </div>
</nav>