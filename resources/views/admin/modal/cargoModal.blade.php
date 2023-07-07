<!--  Modal Cargo-->

{{-- crear cargo --}}
@if ($accion == 1)
    <!-- header -->
    <div class="modal-header">
        Nuevo cargo
    </div>
    <!-- body -->
    <div class="modal-body">
        @include("admin.form.cargoForm")
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearCargo()">Guardar</button>
    </div>
@endif

{{-- editar cargo --}}
@if ($accion == 2)
    <!-- header -->
    <div class="modal-header">
        Editar cargo
    </div>
    <!-- body -->
    <div class="modal-body">
        @include("admin.form.cargoForm")
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarCargo()">Guardar</button>
    </div>
@endif

@if ($accion == 3)
    <!-- body -->
    <div class="modal-body">
        <h5 class="text-center">Desea {{$cargo->estado? 'inactivar': 'activar'}} este cargo?</h5>
        <form id="formCargo">
            <input type="hidden" id="cargo_id" name="cargo_id" value="{{ $cargo->id }}">
        </form>
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="toggleEstadoCargo()">{{$cargo->estado? 'Inactivar': 'Activar'}}</button>
    </div>
@endif
