<!--  Modal crear corte -->
<div class="modal fade bd-example-modal-xl" id="nuevocorte">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-header">
                Nuevo corte
            </div>
            <!-- Modal body -->
            <form id="formEditarCorte">
                <div class="modal-body" id="corteBody">
                    <div class="form-group mb-2">
                        <label for="fechainicio">Fecha inicio</label>
                        <input type="date" class="form-control" id="corte_fecha_inicio" name="corte_fecha_inicio">
                    </div>
                    <div class="form-group mb-2">
                        <label for="fechafin">Fecha fin</label>
                        <input type="date" class="form-control" id="corte_fecha_fin" name="corte_fecha_fin">
                    </div>
                    <div class="form-group mb-2">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="corte_estado" name="corte_estado">
                            <option value=""></option>
                            <option value="1">Abierto</option>
                            <option value="0">Cerrado</option>
                        </select>
                    </div>


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarcorte()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  Modal editar corte -->
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

<!--  Modal eliminar corte -->
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
