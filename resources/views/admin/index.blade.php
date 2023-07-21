@extends('layouts.tt')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="tabAdmin">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#home">Empleados</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cargoCrud">Cargos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#menu1">Clientes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#menu2">Proyectos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#cortes">Cortes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#turnos">Turnos</a>
        </li>
    </ul>

    <div class="container-fluid bg-white border border-top-0 rounded-end rounded-bottom">
        <!-- Tab panes -->
        <div class="tab-content py-4">
            <div id="home" class="container-fluid tab-pane active">
                @if ($area == 6)
                    <button class="btn btn-success mt-2 mb-4" onclick="accionesEmpleados(1)">Nuevo Empleado</button>
                    <div id="containerTablaEmpleados" style="font-size: 14px">
                        <div class="d-flex justify-content-center mt-4 font-weight-bold">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div id="cargoCrud" class="container-fluid tab-pane fade">
                <button class="btn btn-success mt-2 mb-4" onclick="accionesCargos(1)">Nuevo Cargo</button>
                <div id="containerTablaCargos" style="font-size: 14px">
                    <div class="d-flex justify-content-center mt-4 font-weight-bold">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="menu1" class="container-fluid tab-pane fade">
                <button class="btn btn-success mt-2 mb-4" onclick="accionesClientes(1)">Nuevo Cliente</button>
                <div id="containerTablaClientes" style="font-size: 14px">
                    <div class="d-flex justify-content-center mt-4 font-weight-bold">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="menu2" class="container-fluid tab-pane fade">
                <!--<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nuevoproyecto">Nuevo Proyecto</button>-->
                <button class="btn btn-success mt-2 mb-4" onclick="exportarproyectos()">Exportar Proyectos</button>
                <div id="containerTablaProyectos" style="font-size: 14px">
                    <div class="d-flex justify-content-center mt-4 font-weight-bold">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="cortes" class="container-fluid tab-pane fade">

                <button class="btn btn-success mt-2 mb-4" onclick="accionesCortes(1)">Nuevo Corte</button>

                <div id="containerTablaCortes" style="font-size: 14px">
                    <div class="d-flex justify-content-center mt-4 font-weight-bold">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="turnos" class="container-fluid tab-pane fade">
                <form action="{{ route('importTurnos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="custom-file text-left">
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Escoger Archivo</label>
                        </div>
                    </div>
                    <button class="btn btn-success mt-2 mb-4">Importar turnos</button>
                    <div id="containerTablaTurnos" style="font-size: 14px">
                        <div class="d-flex justify-content-center mt-4 font-weight-bold">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modals -->
    @include('modalCdc')
@endsection


@section('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/helpers/helper.js') }}"></script>
    <script src="{{ asset('js/views/admin.js') }}"></script>
@endsection
