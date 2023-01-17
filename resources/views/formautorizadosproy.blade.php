

<form id="formAutProy">
    <input type="hidden" id="id" name="id" value="{{ $proyecto }}">
    <div class="form-group">
        <select class="form-control basicAutoSelect" name="empleado" id="empleado"
            placeholder="buscar..."
            data-url="autoemp" autocomplete="off">
        </select>
        <button class="btn btn-success btn-sm" type="button" onclick="agregarAutorizado()">Agregar</button>
    </div>
</form>
    <div  id="tablaautorizados">
        @include('tablaautorizadosproy')
    </div>
</form>
<script type="text/javascript">
    $('#empleado').autoComplete();
   
</script>