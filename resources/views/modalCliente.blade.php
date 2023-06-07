<!--  Modal crear emp -->
<div class="modal fade bd-example-modal-xl" id="nuevocliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-header">
                Nuevo cliente
            </div>
            <form id="formCliente">
                <!-- Modal body -->
                <div class="modal-body" id="clienteBody">
                    <div class="form-group mb-2">
                        <label for="cc">CLIENTE</label>
                        <input type="text" class="form-control" id="cliente" name="cliente">
                    </div>
                    <div class="form-group mb-2">
                        <label for="apellido1">CONTACTOS</label>
                        <input type="text" class="form-control" id="contactos" name="contactos">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarcliente()">Guardar</button>
                </div>
            </form>
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
            <form id="formEditCliente">
                <!-- Modal body -->
                <div class="modal-body" id="editarClienteBody">
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="editarcliente()">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="eliminarcliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal body -->

            <!-- Modal body -->
            <div class="modal-body" id="eliminarClienteBody">
                <p>Desea eliminar a este cliente?</p>
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
