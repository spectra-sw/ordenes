<div class="form-group mb-2">
    <label for="director">Empleado</label>

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
</div>

<div class="form-group mb-2">
    <label for="cc">Fecha Inicio</label>
    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $turno->fecha_inicio }}">
</div>

<div class="form-group mb-2">
    <label for="apellido1">Hora Inicio</label>
    <input type="number" class="form-control" id="hora_inicio" name="hora_inicio" value="{{ $turno->hora_inicio }}">
</div>

<div class="form-group mb-2">
    <label for="cc">Fecha Fin</label>
    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $turno->fecha_fin }}">
</div>

<div class="form-group mb-2">
    <label for="apellido1">Hora Fin</label>
    <input type="number" class="form-control" id="hora_fin" name="hora_fin" value="{{ $turno->hora_fin }}">
</div>

<div class="form-group mb-2">
    <label for="apellido1">Almuerzo</label>
    <input type="number" class="form-control" id="almuerzo" name="almuerzo" value="{{ $turno->almuerzo }}">
</div>

<input type="hidden" id="id" name="id" value="{{ $turno->id }}">
