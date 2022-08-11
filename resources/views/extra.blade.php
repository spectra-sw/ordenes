@extends('layouts.app')
@section('content')
<br>
<button class="btn btn-primary" onclick="nuevaextra()">Nueva Solicitud</button><br><br>
<div class="row">
                            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
                            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control"></div>
                            <div class="col-6 col-md-2 "><button class="btn btn-primary" onclick="exportarextra()">Exportar</button></div>
            </div>    <br><br>
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th>PROYECTO</th>
        <th>TRABAJADOR</th>
        <th>MOTIVO</th>
        <th>FECHA</th>
        <th>HORARIO HABITUAL</th>
        <th>HORA ENTRADA</th>
        <th>HORA AUTORIZADA</th>
        <th>AUTORIZA/RECHAZA</th>
        <th>SOLICITADA POR</th>
        <th>FECHA SOLICITUD</th>
        <th>FECHA AUTORIZACION/RECHAZO</th>
        <th>OBSERVACIONES</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($extra  as $e)     
      <tr>
        <td>{{ $e->proyecto }}</td>
        <td>{{ $e->ntrabajador->nombre." ".$e->ntrabajador->apellido1 }}</td>
        <td>{{ $e->motivo }}</td>
        <td>{{ $e->fecha }}</td>
        <td>{{ $e->horario_habitual }}</td>
        <td>{{ $e->hora_entrada }}</td>
        <td>{{ $e->hora_autorizada_salida }}</td>
        <td>{{ $e->ndirector->nombre." ".$e->ndirector->apellido1 }}</td>
        <td>{{ $e->nsolicita->nombre." ".$e->nsolicita->apellido1 }}</td>
        <td>{{ $e->fecha_solicitud }}</td>
        <td>{{ $e->fecha_autorizacion_rechazo }}</td>
        
        <td>
            @if ($e->autorizacion_rechazo == null)
            <input type="text" id="observacion" value="{{ $e->observaciones }}">
            @else
            {{ $e->observaciones }}
            @endif
        <td>
        <input type="button" class="btn btn-success btn-sm" value="aprobar" onclick="aprobar({{ $e->id}})">
        <input type="button" class="btn btn-warning btn-sm" value="rechazar" onclick="rechazar({{ $e->id}})">
        </td>
      </tr>
    @endforeach 
    </tbody>
</table>
<div class="modal fade bd-example-modal-xl" id="authExtraModal">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            <b>AUTORIZACIÓN JORNADA ESPECIAL O TIEMPO EXTRA</b>
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="authExtraBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>


<script src="{{asset('js/scripts.js')}}"></script>                
@endsection
