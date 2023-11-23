<nav class="navbar navbar-expand-lg navbar-dark bg-1 py-3">
    <div class="container-fluid">
        <a class="navbar-brand" style="font-size: 22px" href="/menu">Spectra - Time Tracker</a>

        <div>
            <span class="px-2 d-inline d-lg-none" style="position: relative">
                <span class="rounded-circle bg-info shadow px-1 text-white notification-count"
                    style="top: -10px; right: 4px; position: absolute; font-size: 12px; font-weight: bold;">
                </span>
                <img src="{{ URL::asset('img/notifications.svg') }}" style="height: 26px" onclick="test1()">
            </span>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation" style="padding: 0.25rem">
                <span class="navbar-toggler-icon" style="height: 18px;"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (session('tipo') != 2)
                    <li class="nav-item">
                        <a @if (Request::is('jornada')) class="nav-link active" @else class="nav-link" @endif
                            href="/jornada" style="font-size: 14px">
                            <i class="bi bi-clock"></i>
                            Registros
                        </a>
                    </li>
                @endif
                @if (session('tipo') == 0 || session('tipo') == 2)
                    <li class="nav-item">
                        <a @if (Request::is('consultas')) class="nav-link active" @else class="nav-link" @endif
                            href="/consultas" style="font-size: 14px">
                            <i class="bi bi-search"></i>
                            Consultas
                        </a>
                    </li>
                @endif
                @if (session('tipo') != 1 && session('tipo') != 2)
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

                <span class="px-2 d-none d-lg-inline" style="position: relative">
                    <span class="rounded-circle bg-info shadow px-1 text-white notification-count"
                        style="top: -10px; right: 4px; position: absolute; font-size: 12px; font-weight: bold;">
                    </span>
                    <img src="{{ URL::asset('img/notifications.svg') }}" style="height: 26px" onclick="test1()">
                </span>

                <button class="btn btn-success ms-2" onclick="window.open('/logout','_self')">
                    Salir
                </button>
            </div>
        </div>
    </div>
</nav>
