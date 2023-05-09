<!--  Modal crear corte -->
<div class="modal fade bd-example-modal-xl" id="nuevocorte">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo corte
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="corteBody">
            <form id="formCorte">
                <div class="form-group">
                    <label for="fechainicio">Fecha inicio</label>
                    <input type="date" class="form-control"  id="fechainicio" name="fechainicio">
                </div>
                <div class="form-group">
                    <label for="fechafin">Fecha fin</label>
                    <input type="date" class="form-control"  id="fechafin" name="fechafin">
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select class="form-control" id="estado" name="estado">
                        <option value=""></option>
                        <option value="1">Abierto</option>
                        <option value="0">Cerrado</option>
                    </select>
                </div>
                
                <button type="button" class="btn btn-primary" onclick="guardarcorte()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
  <div class="modal fade bd-example-modal-xl" id="editarcorte">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar corte
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarCorteBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminarcorte">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarCorteBody">
        <p>Desea eliminar este corte?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminarc()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>