@extends('layouts.tt')

@section('content')

<div class="container mt-0">
   
    <br>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="tabAdmin">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#home">Empleados</a>
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
      <div id="cortes" class="container tab-pane fade"><br>
        <br>
        <button class="btn btn-3" onclick="nuevocorte()">Nuevo Corte</button><br><br>
        <br>
        <div id ="tcl">
            @include('tablacortes')
        </div>
      </div>
      <div id="turnos" class="container tab-pane fade"><br>
        <br>
        <form action="{{ route('importTurnos') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Escoger Archivo</label>
                </div>
            </div>
            <button class="btn btn-3">Importar turnos</button><br>
                <table id="tableTurnos" class="table table-striped" style="width:100%;overflow:scroll;color:black">
                    <thead>
                        <tr>
                            <th>CC</th>
                            <th>NOMBRE</th>
                            <th>FECHA_INICIO</th>
                            <th>HORA_INICIO</th>
                            <th>FECHA_FIN</th>
                            <th>HORA_FIN</th>
                            <th>ALMUERZO</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($turnos as $t)
                      <tr>
                          <td>{{ isset($t->empleado) ?  $t->empleado->cc : '' }} </td>
                          <td>{{ isset($t->empleado) ?  $t->empleado->apellido1 . " ". $t->empleado->apellido2 . " ". $t->empleado->nombre : '' }}</td>
                          <td>{{ $t->fecha_inicio}}</td>
                          <td>{{ $t->hora_inicio }}</td>
                          <td>{{ $t->fecha_fin}}</td>
                          <td>{{ $t->hora_fin}}</td>
                          <td>{{ $t->almuerzo}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                   
                </table>
        </form>
      </div>
    </div>
</div>

@include('modalProyecto')
@include('modalEmpleado')
@include('modalCdc')
@include('modalCliente') 

<div class="modal fade" id="password">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Nueva contraseña</p>
        <p><input type="password" id="pwd" name="pwd" class="form-control"></p>
        <input type="hidden" id="idup" name="idup" value=""> 
        <button type="button" class="btn btn-primary" onclick="updatepwd()">Actualizar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>

  <script>
    $(document).ready(function () {
      $('#tablaemp').DataTable();
      $('#tableTurnos').DataTable();
    });
    </script>
    <script src="{{asset('js/scripts.js')}}"></script>    
@endsection

