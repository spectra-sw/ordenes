<div class="form-group">
    <label for="director">Empleado</label>

    <select class="form-control" id="t_user_id" name="t_user_id">
        <option value=""></option>
        @foreach ($empleado as $e)
        @if ($e->id == $turno->user_id)
        <option value="{{ $e->id }}" selected>{{ $e->nombre . ' ' . $e->apellido1 }}</option>
        @else
        <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
        @endif
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="cc">Fecha Inicio</label>
    <input type="date" class="form-control" id="t_fecha_inicio" name="t_fecha_inicio" value="{{ $turno->fecha_inicio }}">
</div>

<div class="form-group">
    <label for="apellido1">Hora Inicio</label>
    <input type="number" class="form-control" id="t_hora_inicio" name="t_hora_inicio" value="{{ $turno->hora_inicio }}">
</div>

<div class="form-group">
    <label for="cc">Fecha Fin</label>
    <input type="date" class="form-control" id="t_fecha_fin" name="t_fecha_fin" value="{{ $turno->fecha_fin }}">
</div>

<div class="form-group">
    <label for="apellido1">Hora Fin</label>
    <input type="number" class="form-control" id="t_hora_fin" name="t_hora_fin" value="{{ $turno->hora_fin }}">
</div>

<div class="form-group">
    <label for="apellido1">Almuerzo</label>
    <input type="number" class="form-control" id="t_almuerzo" name="t_almuerzo" value="{{ $turno->almuerzo }}">
</div>

<input type="hidden" id="t_id" name="t_id" value="{{ $turno->id }}">
