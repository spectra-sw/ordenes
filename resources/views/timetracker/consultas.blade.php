@extends('layouts.tt')

@section('content')

<form id="formConsultaAdmin" action="exportReporte" method="get" target="_blank">
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <label for="proyecto" class="form-label">Proyecto</label>
                        <input type="text" class="form-control" name="proyecto" id="proyecto">
                    </div>   
                    <div class="col-12 col-md-8">
                        <label for="trabajador" class="form-label">Trabajador</label>
                        <select class="form-control" id="trabajador" name="trabajador">
                            <option value=""></option>
                            @foreach ($emp as $e)
                                <option value="{{ $e->id }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                            @endforeach
                        </select>
                    </div>   
                </div>
                
            </div>
        <div>
    </div>
</div><br>
<div class="row">
    <div class="col-12">
        <div class="card" >
            <div class="card-body">
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
                   
                </div><br>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <button class="btn btn-3" id="btnConsultarAdmin" type="button">Consultar</button> 
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-3" id="btnDistribucion" type="button">Distribución</button> 
                    </div>
                </div>
            </div>
        <div>
    </div>
</div><br>
<div class="row">
    <div class="col-12">
        <div id="consultaAdmin">

        </div>
    </div>
</div>
</form>
<script src="{{asset('js/scripts_jornada.js')}}"></script>                      
@endsection
