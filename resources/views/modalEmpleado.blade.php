<!--  Modal crear emp -->
<div class="modal fade" id="nuevoemp">
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
                    <label for="ciudad">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad">
                </div>
                <div class="form-group">
                    <label for="horario">HORARIO</label>
                    <select class="form-control" id="horario" name="horario">
                        <option value=""></option>
                        @foreach ($horarios as $h)
                        <option value="{{ $h->id }}">{{ $h->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="area">ÁREA</label>
                    <select class="form-control" id="area" name="area">
                        <option value=""></option>
                        @foreach ($areas as $a)
                        <option value="{{ $a->id }}">{{ $a->area }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="area">CARGO</label>
                    <select class="form-control" id="cargo" name="cargo">
                       
                        @foreach ($cargos as $c)
                        <option value="{{ $c->id }}">{{ $c->cargo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="area" name="tipo" class="form-control">
                        <option value="0">Admin</option>
                        <option value="1">Registro OT</option>
                        <option value="10">Registro Ocupación</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="guardare()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
  <div class="modal fade" id="editaremp">
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
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade" id="eliminaremp">
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
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>