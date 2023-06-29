<form id="formAutProy">
    <input type="hidden" id="id" name="id" value="{{ $proyecto_id }}">
    <div class="form-group">
        <select class="form-control" id="empleado" name="empleado">
            <option value="0"></option>
            @foreach ($empleados as $e)
                <option value="{{ $e->cc }}">{{ $e->apellido1 . ' ' . $e->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-success btn-sm" type="button" onclick="agregarAutorizado()">Agregar</button>
    </div>
</form>
<br>
<div id="tablaautorizados">
    @include('adminform')
</div>
