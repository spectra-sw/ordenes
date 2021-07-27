<!--  Modal crear emp -->
<div class="modal fade bd-example-modal-xl" id="nuevocliente">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo cliente
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="clienteBody">
            <form id="formCliente">
                <div class="form-group">
                    <label for="cc">CLIENTE</label>
                    <input type="text" class="form-control"  id="cliente" name="cliente">
                </div>
                <div class="form-group">
                    <label for="apellido1">CONTACTOS</label>
                    <input type="text" class="form-control"  id="contactos" name="contactos">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="guardarcliente()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
  <div class="modal fade bd-example-modal-xl" id="editarcliente">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar cliente
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarCliente">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminarcliente">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarCliente">
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