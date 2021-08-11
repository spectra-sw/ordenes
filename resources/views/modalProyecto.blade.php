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
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion">
                </div>
                <div class="form-group">
                    <label for="proyecto">CLIENTE</label>
                    <select class="form-control" id="cliente" name="cliente">
                    <option value=""><option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sistema">SISTEMA</label>
                    <input type="text" class="form-control"  id="sistema" name="sistema">
                </div>
                <div class="form-group">
                    <label for="auxilio">SUBPORTAFOLIO</label>
                    <input type="text" class="form-control"  id="subportafolio" name="subportafolio">
                </div>
                <div class="form-group">
                    <label for="director">DIRECTOR</label>
                    <select class="form-control" id="director" name="director">
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">LIDER</label>
                    <select class="form-control" id="lider" name="lider">
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="guardarproy()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="editarproy">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar proyecto
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarBodyProy">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminarproy">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Desea eliminar este proyecto?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminarproy()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>

