@extends('layouts.tt')

@section('content')

<div class="container mt-3">
   
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#home">Empleados</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Clientes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#menu2">Proyectos</a>
      </li>
    </ul>
  
    <!-- Tab panes -->
    <div class="tab-content">
      <div id="home" class="container tab-pane active"><br>
        <br>
        @if ($area == 6)
        <button class="btn btn-3" onclick="nuevoemp()">Nuevo Empleado</button><br><br>
        <div id ="te">
            @include('tablaemp')
        </div>
        @endif
      </div>
      <div id="menu1" class="container tab-pane fade"><br>
        <br>
        <button class="btn btn-3" onclick="nuevocliente()">Nuevo Cliente</button><br><br>
        <br>
        <div id ="tcl">
            @include('tablacliente')
        </div>
      </div>
      <div id="menu2" class="container tab-pane fade"><br>
        <br>                 
        <button type="button" class="btn btn-3" data-bs-toggle="modal" data-bs-target="#nuevoproyecto">Nuevo Proyecto</button>
        <button class="btn btn-3" onclick="exportarproyectos()">Exportar Proyectos</button><br><br>
        <br>
        <div id ="tp">
                @include('tablaproyecto')
        </div>
       
      </div>
    </div>
</div>

@include('modalProyecto')



  <script>
    $(document).ready(function () {
      $('#tablaemp').DataTable();
    });
    </script>
    <script src="{{asset('js/scripts.js')}}"></script>    
@endsection

