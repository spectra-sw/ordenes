<!--  Modal Empleado -->

{{-- crear empleado --}}
@if ($accion == 1)
    <!-- header -->
    <div class="modal-header">
        Nuevo empleado
    </div>

    {{-- body --}}
    <div class="modal-body">
        @include('admin.form.empleadoForm')
    </div>
    {{-- footer --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearEmpleado()">Guardar</button>
    </div>
@endif

{{-- editar empleado --}}
@if ($accion == 2)
    <!-- header -->
    <div class="modal-header">
        Editar empleado
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.empleadoForm')
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarEmpleado()">Guardar</button>
    </div>
@endif

{{-- eliminar empleado --}}
@if ($accion == 3)
    <!-- body -->
    <div class="modal-body">
        <h5 class="text-center">Desea inactivar a este empleado?</h5>
        <form id="formEmpleado">
            <input type="hidden" id="id" name="id" value="{{ $empleado_id }}">
        </form>
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="eliminarEmpleado()">Inactivar</button>
    </div>
@endif

{{-- cambiar contrasena --}}
@if ($accion == 4)
    <!-- Modal body -->
    <form id="formEmpleado">
        <div class="modal-body">
            <div class="form-group mb-2">
                <label for="password">Nueva contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
                <div id="password_e" class="invalid-feedback"></div>
            </div>
            <input type="hidden" id="empleado_id" name="empleado_id" value="{{ $empleado_id }}">
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="updatePassword()">Actualizar</button>
        </div>
    </form>
@endif
