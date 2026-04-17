<form id="formHorario">
    @isset($horario)
        <input type="hidden" id="horario_id" name="horario_id" value="{{ $horario->id }}">
    @endisset

    <div class="form-group mb-2">
        <label>Nombre</label>
        <input type="text" class="form-control" id="horario_nombre" name="horario_nombre"
            value="{{ isset($horario) ? $horario->nombre : '' }}">
        <div id="horario_nombre_e" class="invalid-feedback"></div>
    </div>

    <div class="row">
        <div class="col form-group mb-2">
            <label>Día inicio</label>
            <select class="form-control" id="horario_dia_inicio" name="horario_dia_inicio">
                <option value=""></option>
                <option value="1" {{ isset($horario) && $horario->dia_inicio == 1 ? 'selected' : '' }}>Lunes</option>
                <option value="2" {{ isset($horario) && $horario->dia_inicio == 2 ? 'selected' : '' }}>Martes</option>
                <option value="3" {{ isset($horario) && $horario->dia_inicio == 3 ? 'selected' : '' }}>Miércoles</option>
                <option value="4" {{ isset($horario) && $horario->dia_inicio == 4 ? 'selected' : '' }}>Jueves</option>
                <option value="5" {{ isset($horario) && $horario->dia_inicio == 5 ? 'selected' : '' }}>Viernes</option>
                <option value="6" {{ isset($horario) && $horario->dia_inicio == 6 ? 'selected' : '' }}>Sábado</option>
                <option value="0" {{ isset($horario) && $horario->dia_inicio == 0 ? 'selected' : '' }}>Domingo</option>
            </select>
            <div id="horario_dia_inicio_e" class="invalid-feedback"></div>
        </div>
        <div class="col form-group mb-2">
            <label>Día fin</label>
            <select class="form-control" id="horario_dia_fin" name="horario_dia_fin">
                <option value=""></option>
                <option value="1" {{ isset($horario) && $horario->dia_fin == 1 ? 'selected' : '' }}>Lunes</option>
                <option value="2" {{ isset($horario) && $horario->dia_fin == 2 ? 'selected' : '' }}>Martes</option>
                <option value="3" {{ isset($horario) && $horario->dia_fin == 3 ? 'selected' : '' }}>Miércoles</option>
                <option value="4" {{ isset($horario) && $horario->dia_fin == 4 ? 'selected' : '' }}>Jueves</option>
                <option value="5" {{ isset($horario) && $horario->dia_fin == 5 ? 'selected' : '' }}>Viernes</option>
                <option value="6" {{ isset($horario) && $horario->dia_fin == 6 ? 'selected' : '' }}>Sábado</option>
                <option value="0" {{ isset($horario) && $horario->dia_fin == 0 ? 'selected' : '' }}>Domingo</option>
            </select>
            <div id="horario_dia_fin_e" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="row">
        <div class="col form-group mb-2">
            <label>Hora entrada</label>
            <input type="number" step="0.5" class="form-control" id="horario_hora_inicio" name="horario_hora_inicio"
                placeholder="Ej: 7 o 7.5"
                value="{{ isset($horario) ? $horario->hora_inicio : '' }}">
            <div id="horario_hora_inicio_e" class="invalid-feedback"></div>
        </div>
        <div class="col form-group mb-2">
            <label>Hora salida</label>
            <input type="number" step="0.5" class="form-control" id="horario_hora_fin" name="horario_hora_fin"
                placeholder="Ej: 17 o 17.5"
                value="{{ isset($horario) ? $horario->hora_fin : '' }}">
            <div id="horario_hora_fin_e" class="invalid-feedback"></div>
        </div>
        <div class="col form-group mb-2">
            <label>Almuerzo (horas)</label>
            <input type="number" step="0.5" class="form-control" id="horario_almuerzo" name="horario_almuerzo"
                placeholder="Ej: 1 o 0.5"
                value="{{ isset($horario) ? $horario->almuerzo : '' }}">
            <div id="horario_almuerzo_e" class="invalid-feedback"></div>
        </div>
    </div>

    <div class="form-group mb-2">
        <label>Observación</label>
        <input type="text" class="form-control" id="horario_observacion" name="horario_observacion"
            value="{{ isset($horario) ? $horario->observacion : '' }}">
        <div id="horario_observacion_e" class="invalid-feedback"></div>
    </div>
</form>
