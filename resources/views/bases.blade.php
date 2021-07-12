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
                        <button class="btn btn-primary" onclick="nuevoemp()">Nuevo Empleado</button><br><br>
                        <div id ="te">
                            @include('tablaemp')
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="centros">
                      <br>
                        <button class="btn btn-primary" onclick="nuevocdc()">Nuevo Centro</button><br><br>
                        <div id ="tc">
                            @include('tablacdc')
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="clientes">
                      <br>
                        <button class="btn btn-primary" onclick="nuevocliente()">Nuevo Cliente</button><br><br>
                        <div id ="tcl">
                            @include('tablacliente')
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="proyectos">
                        <br>
                        <button class="btn btn-primary" onclick="nuevoproyecto()">Nuevo Proyecto</button><br><br>
                        <div id ="tp">
                            @include('tablaproyecto')
                        </div>
                    </div>
                </div>


<!--  Modal crear proyecto -->
<div class="modal fade bd-example-modal-xl" id="nuevoproyecto">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo proyecto
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="proyBody">
            <form id="formProy">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="apellido1">APELLIDO 1</label>
                    <input type="text" class="form-control"  id="apellido1" name="apellido1">
                </div>
                <div class="form-group">
                    <label for="apellido2">APELLIDO 2</label>
                    <input type="text" class="form-control"  id="apellido2" name="apellido2">
                </div>
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control"  id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="auxilio">AUXILIO</label>
                    <input type="text" class="form-control"  id="auxilio" name="auxilio">
                </div>
                <div class="form-group">
                    <label for="correo">CORREO</label>
                    <input type="text" class="form-control"  id="correo" name="correo">
                </div>
                
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                        <option value="0">Admin</option>
                        <option value="1">Registro</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="guardare()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>

<!--  Modal crear emp -->
<div class="modal fade bd-example-modal-xl" id="nuevoemp">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo empleado
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="empBody">
            <form id="formEmp">
                <div class="form-group">
                    <label for="cc">CC</label>
                    <input type="text" class="form-control"  id="cc" name="cc">
                </div>
                <div class="form-group">
                    <label for="apellido1">APELLIDO 1</label>
                    <input type="text" class="form-control"  id="apellido1" name="apellido1">
                </div>
                <div class="form-group">
                    <label for="apellido2">APELLIDO 2</label>
                    <input type="text" class="form-control"  id="apellido2" name="apellido2">
                </div>
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control"  id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="auxilio">AUXILIO</label>
                    <input type="text" class="form-control"  id="auxilio" name="auxilio">
                </div>
                <div class="form-group">
                    <label for="auxilio">AUXILIO TRANSPORTE</label>
                    <select class="form-control" id="auxiliot" name="auxiliot">
                        <option value=""></option>
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="correo">CORREO</label>
                    <input type="text" class="form-control"  id="correo" name="correo">
                </div>
                <div class="form-group">
                    <label for="correo">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad">
                </div>
                <div class="form-group">
                    <label for="correo">HORARIO</label>
                    <select class="form-control" id="horario" name="horario">
                        <option value=""></option>
                        @foreach ($horarios as $h)
                        <option value="{{ $h->id }}">{{ $h->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control">
                        <option value="0">Admin</option>
                        <option value="1">Registro</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="guardare()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
  <div class="modal fade bd-example-modal-xl" id="editaremp">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar empleado
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminaremp">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Desea eliminar a este empleado?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminare()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
 
  
<!--  Modal crear cdc -->
<div class="modal fade bd-example-modal-xl" id="nuevocdc">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo Centro
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="cdcBody">
            <form id="formCdc">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="descripcion">DESCRIPCION</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion">
                </div>
                <div class="form-group">
                    <label for="apellido2">CENTRO DE OPERACIÓN</label>
                    <input type="text" class="form-control"  id="co" name="co">
                </div>
                <div class="form-group">
                    <label for="nombre">UNIDAD DE NEGOCIO</label>
                    <input type="text" class="form-control"  id="un" name="un">
                </div>
                <div class="form-group">
                    <label for="auxilio">RESPONSABLE</label>
                    <input type="text" class="form-control"  id="responsable" name="responsable">
                </div>
                <div class="form-group">
                    <label for="correo">MAYOR</label>
                    <input type="text" class="form-control"  id="mayor" name="mayor">
                </div>
                <div class="form-group">
                    <label for="correo">GRUPO</label>
                    <input type="text" class="form-control"  id="grupo" name="grupo">
                </div>
                <div class="form-group">
                    <label for="correo">OBSERVACIONES</label>
                    <input type="text" class="form-control"  id="observaciones" name="observaciones">
                </div>
                <button type="button" class="btn btn-primary" onclick="guardarcdc()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="editarcdc">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar centro de costos
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="cdceditBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="eliminarcdc">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Desea eliminar a este centro?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminarcdc()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
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

