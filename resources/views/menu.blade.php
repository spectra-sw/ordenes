@extends('layouts.app')

@section('content')

<button type="button" class="btn btn-primary" onclick="window.open('ordenes','_self')">CREAR ORDENES</button>
@if (session('tipo')==0)
<button type="button" class="btn btn-primary" onclick="window.open('admin','_self')">ADMINISTRACIÓN</button>
@endif
@if (session('tipo')==1)
<button type="button" class="btn btn-primary" onclick="window.open('consultas','_self')">CONSULTAR</button>
@endif
<button type="button" class="btn btn-primary" onclick="window.open('ocupacion','_self')">REGISTRO DE OCUPACIÓN</button>
@if (session('tipo')==1)
<br>
<br>
<p>PROGRAMACION PARA {{ $nombre }} </p>
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th onclick="ordenarc('codigo')" style="cursor:pointer">TÉCNICO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">FECHA</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">PROYECTO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">RESPONSABLE</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">OBSERVACION</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($prog as $p)     
      <tr>
        <td>{{ $p->empleado->nombre . " ". $p->empleado->apellido1}}</td>
        <td>{{ $p->fecha }}</td>
        <td>{{ $p->datosproyecto->codigo . " - ". $p->datosproyecto->cliente->cliente }}</td>
        <td>{{ $p->datosresponsable->nombre . " ". $p->datosresponsable->apellido1 }}</td>
        <td>{{ $p->observacion }}
        
        
      </tr>
    @endforeach 
    </tbody>
</table>
@endif
@endsection

