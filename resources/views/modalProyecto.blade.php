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
                    <select class="form-control" id="proyecto" name="proyecto">
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