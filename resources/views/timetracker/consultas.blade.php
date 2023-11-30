@extends('layouts.tt')

@section('content')
    <ul class="nav nav-tabs" role="tablist" id="tabOcupacion">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#jornadas">Jornadas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#jornadasFaltantes">Jornadas faltantes</a>
        </li>
    </ul>

    <div class="container-fluid bg-white border border-top-0 rounded-end rounded-bottom">
        <div class="tab-content py-4">
            {{-- Start Jornada --}}
            <div id="jornadas" class="container-fluid tab-pane active">
                <form id="formConsultaAdmin" action="exportReporte" method="get" target="_blank">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <label for="proyecto" class="form-label">Proyecto</label>
                            <input type="text" class="form-control" name="proyecto" id="proyecto">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="trabajador" class="form-label">Trabajador</label>
                            <select class="form-control" id="trabajador" name="trabajador">
                                <option value=""></option>
                                @foreach ($emp as $e)
                                    <option value="{{ $e->id }}">
                                        {{ $e->apellido1 . ' ' . $e->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="cliente" class="form-label">Cliente</label>
                            <select class="form-control" id="cliente" name="cliente">
                                <option value=""></option>
                                @foreach ($clientes as $c)
                                    <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label for="inicio" class="form-label">Rango de fechas</label>
                            <input type="date" class="form-control" id="inicio" name="inicio">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fin" class="form-label">&nbsp;</label>
                            <input type="date" class="form-control" id="fin" name="fin">
                        </div>
                        <div class="col-12 col-md-3">
                            <label for="inicio" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="">Todos</option>
                                <option value="1">Pendiente</option>
                                <option value="2">Aprobada</option>
                                <option value="3">Rechazada</option>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-12 col-md-3">
                            <button class="btn btn-success" id="btnConsultarAdmin" type="button">Consultar</button>
                        </div>
                        <div class="col-12 col-md-3">
                            <button class="btn btn-success" id="btnExportarConsultas" type="button">Exportar</button>
                        </div>
                        @if (session('area') == 6)
                            <div class="col-12 col-md-3">
                                <button class="btn btn-success" id="btnDistribucion" type="button">Distribución</button>
                            </div>
                        @endif
                    </div>
                    <br>


                    <div class="row">
                        <div class="col-12">
                            <div id="consultaAdmin"></div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- End Jornadas --}}

            {{-- Start Jornadas Faltantes --}}
            <div class="container-fluid tab-pane fade" id="jornadasFaltantes">
                <form id="formConsultJornadaFaltante">
                    <div class="row">
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="dia">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" class="form-control">
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="dia">Fecha Final</label>
                                <input type="date" name="fecha_fin" class="form-control">
                            </div>
                        </div>

                        <div class="col-12 col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="empleado">Trabajador</label>
                                <select class="form-control" name="empleado">
                                    <option value=""></option>
                                    @foreach ($emp as $e)
                                        <option value="{{ $e->id }}">
                                            {{ $e->apellido1 . ' ' . $e->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <button type="button" class="btn btn-success" onclick="consultarJornadasFaltantes()">
                                Consultar
                            </button>
                            <button type="button" class="btn btn-success" onclick="exportarJornadasFaltantes()">
                                Exportar
                            </button>
                        </div>
                    </div>
                    <div id="tablaJornadaFaltante" style="background-color:white"></div>
                </form>
            </div>
            {{-- End Jornadas Faltantes --}}
        </div>
    </div>
    <script src="{{ asset('js/scripts_jornada.js') }}"></script>
@endsection
