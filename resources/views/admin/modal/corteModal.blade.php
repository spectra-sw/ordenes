<!--  Modal crear corte -->
@if ($accion == 1)
    <!-- header -->
    <div class="modal-header">
        Nuevo corte
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.corteForm')
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crearCorte()">Guardar</button>
    </div>
@endif


<!--  Modal editar corte -->
@if ($accion == 2)
    <!-- header -->
    <div class="modal-header">
        Editar corte
    </div>
    <!-- body -->
    <div class="modal-body">
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
    </div>
@endif

<!--  Modal eliminar corte -->
@if ($accion == 3)
    <!-- body -->
    <div class="modal-body">
        <p>Desea eliminar este corte?</p>
        <form id="formCorte">
            <input type="hidden" id="id" name="id" value="">
        </form>
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="eliminarc()">Eliminar</button>
    </div>
@endif

<!--  Modal hablidar/deshabilitar corte -->
@if ($accion == 4)
    <!-- header -->
    <div class="modal-header">
        {{ $corte->estado == 1 ? 'Cerrar' : 'Habilitar' }} corte
    </div>
    <!-- body -->
    <div class="modal-body">
        <form id="formCorte">
            <input type="hidden" name="id_corte" id="id_corte" value="{{ $corte->id }}">
        </form>
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary"
            onclick="togleHabilitarCorte()">{{ $corte->estado == 1 ? 'Cerrar' : 'Habilitar' }}
        </button>
    </div>
@endif
