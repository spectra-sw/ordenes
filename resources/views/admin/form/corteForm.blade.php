<form id="formCorte">
    <div class="form-group mb-2">
        <label for="fechainicio">Fecha inicio</label>
        <input type="date" class="form-control" id="corte_fecha_inicio" name="corte_fecha_inicio">
        <div id="corte_fecha_inicio_e" class="invalid-feedback"></div>
    </div>
    <div class="form-group mb-2">
        <label for="fechafin">Fecha fin</label>
        <input type="date" class="form-control" id="corte_fecha_fin" name="corte_fecha_fin">
        <div id="corte_fecha_fin_e" class="invalid-feedback"></div>
    </div>
    <div class="form-group mb-2">
        <label for="estado">Estado</label>
        <select class="form-control" id="corte_estado" name="corte_estado">
            <option value=""></option>
            <option value="1">Abierto</option>
            <option value="0">Cerrado</option>
        </select>
        <div id="corte_estado_e" class="invalid-feedback"></div>
    </div>
</form>
