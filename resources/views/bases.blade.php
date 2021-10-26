@extends('layouts.app')

@section('content')

 <!-- Nav tabs -->
 <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#emp">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#centros">Centros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#clientes">Clientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#proyectos">Proyectos</a>
                </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="emp">
                        <br>
                        @if ($authpr == 1)
                        <button class="btn btn-primary" onclick="nuevoemp()">Nuevo Empleado</button><br><br>
                        <div id ="te">
                            @include('tablaemp')
                        </div>
                        @endif
                    </div>
                    <div class="tab-pane container fade" id="centros">
                      <br>
                        <button class="btn btn-primary" onclick="nuevocdc()">Nuevo Centro</button><br><br>
                        @include('busquedaCentro')
                        <br>
                        <div id ="tc">
                            @include('tablacdc')
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="clientes">
                      <br>
                        <button class="btn btn-primary" onclick="nuevocliente()">Nuevo Cliente</button><br><br>
                        @include('busquedaCliente')
                        <br>
                        <div id ="tcl">
                            @include('tablacliente')
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="proyectos">
                        <br>
                      
                        <button class="btn btn-primary" onclick="nuevoproyecto()">Nuevo Proyecto</button><br><br>
                        @include('busquedaProy')
                        <br>
                        <div id ="tp">
                             @include('tablaproyecto')
                        </div>
                       
                    </div>
                </div>


@include('modalProyecto')
@include('modalEmpleado')
@include('modalCdc')
@include('modalCliente') 
  

<div class="modal fade bd-example-modal-sm" id="password">
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
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
<script src="{{asset('js/scripts.js')}}"></script>                
@endsection

