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