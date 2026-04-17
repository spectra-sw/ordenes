@if ($accion == 1)
    <div class="modal-header">
        Nuevo Horario
    </div>
    <div class="modal-body">
        @include('admin.form.horarioForm')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearHorario()">Guardar</button>
    </div>
@endif

@if ($accion == 2)
    <div class="modal-header">
        Editar Horario
    </div>
    <div class="modal-body">
        @include('admin.form.horarioForm')
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarHorario()">Guardar</button>
    </div>
@endif

@if ($accion == 3)
    <div class="modal-header">
        Eliminar Horario
    </div>
    <div class="modal-body">
        <p>¿Desea eliminar el horario <strong>{{ $horario->nombre }}</strong>?</p>
        @if ($horario->empleados->count() > 0)
            <div class="alert alert-warning">
                Este horario tiene {{ $horario->empleados->count() }} empleado(s) asignado(s) y no puede eliminarse.
            </div>
        @endif
        <form id="formHorario">
            <input type="hidden" id="horario_id" name="horario_id" value="{{ $horario->id }}">
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        @if ($horario->empleados->count() == 0)
            <button type="button" class="btn btn-primary" onclick="eliminarHorario()">Eliminar</button>
        @endif
    </div>
@endif
