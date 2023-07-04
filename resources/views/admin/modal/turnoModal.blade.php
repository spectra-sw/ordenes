<!--  Modal turno -->

{{-- editar turno --}}
@if ($accion == 2)
    <div class="modal-header">
        <h5 class="modal-title">Editar Turno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        @include('admin.form.turnoForm')
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarTurno()">Guardar</button>
    </div>
@endif
