<nav class="navbar navbar-expand-lg navbar-dark bg-1 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" style="font-size: 22px" href="/menu">Spectra - Time Tracker</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a @if (Request::is('jornada')) class="nav-link active" @else class="nav-link" @endif
                        href="/jornada" style="font-size: 14px">
                        <i class="bi bi-clock"></i>
                        Registros
                    </a>
                </li>
                @if (session('tipo') == 0)
                    <li class="nav-item">
                        <a @if (Request::is('consultas')) class="nav-link active" @else class="nav-link" @endif
                            href="/consultas" style="font-size: 14px">
                            <i class="bi bi-search"></i>
                            Consultas
                        </a>
                    </li>
                @endif
                @if (session('tipo') != 1)
                    <li class="nav-item">
                        <a @if (Request::is('ocupacion')) class="nav-link active" @else class="nav-link" @endif
                            href="/ocupacion" style="font-size: 14px">
                            <i class="bi bi-clock"></i>
                            Ocupación
                        </a>
                    </li>
                @endif
                @if (session('tipo') == 0)
                    <li class="nav-item dropdown">
                        <a @if (Request::is('bases')) class="nav-link active dropdown-toggle" @else class="nav-link dropdown-toggle" @endif
                            href="#" role="button" data-bs-toggle="dropdown" style="font-size: 14px">
                            <i class="bi bi-person-circle"></i>
                            Administración
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/bases">Bases de datos</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            <div class="d-flex align-items-center text-white">
                <p class="m-0">{{ session('nombre') }}</p>
                <button class="btn btn-success ms-2" onclick="window.open('/logout','_self')">
                    Salir
                </button>
            </div>
        </div>
    </div>
</nav>
