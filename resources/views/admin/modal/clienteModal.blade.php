<!--  Modal Clientes-->

{{-- crear Cliente --}}
@if ($accion == 1)
    <!-- header -->
    <div class="modal-header">
        Nuevo cliente
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.clienteForm')
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearCliente()">Guardar</button>
    </div>
@endif

{{-- editar cliente --}}
@if ($accion == 2)
    <!-- header -->
    <div class="modal-header">
        Editar cliente
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.clienteForm')
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarCliente()">Guardar</button>
    </div>
@endif

@if ($accion == 3)
    <!-- body -->
    <div class="modal-body">
        <h5 class="text-center">Desea eliminar a este cliente?</h5>
        <form id="formCliente">
            <input type="hidden" id="cliente_id" name="cliente_id" value="{{ $cliente_id }}">
        </form>
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="eliminarCliente()">Eliminar</button>
    </div>
@endif
