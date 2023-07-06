<form id="formTurno">
    <input type="hidden" id="turno_id" name="turno_id" value="{{ $turno->id }}">

    <div class="form-group mb-2">
        <label for="user_id">Empleado</label>

        <select class="form-control" id="user_id" name="user_id">
            <option value=""></option>
            @foreach ($empleados as $e)
                @if ($e->id == $turno->user_id)
                    <option value="{{ $e->id }}" selected>{{ $e->nombre . ' ' . $e->apellido1 }}</option>
                @else
                    <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
                @endif
            @endforeach
        </select>
        <div id="user_id_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
            value="{{ $turno->fecha_inicio }}">
            <div id="fecha_inicio_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="hora_inicio">Hora Inicio</label>
        <input type="number" class="form-control" id="hora_inicio" name="hora_inicio"
            value="{{ $turno->hora_inicio }}">
            <div id="hora_inicio_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="fecha_fin">Fecha Fin</label>
        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $turno->fecha_fin }}">
        <div id="fecha_fin_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="hora_fin">Hora Fin</label>
        <input type="number" class="form-control" id="hora_fin" name="hora_fin" value="{{ $turno->hora_fin }}">
        <div id="hora_fin_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="almuerzo">Almuerzo</label>
        <input type="number" class="form-control" id="almuerzo" name="almuerzo" value="{{ $turno->almuerzo }}">
        <div id="almuerzo_e" class="invalid-feedback"></div>
    </div>
</form>
