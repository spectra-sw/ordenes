<table id="tablaHorarios" class="table table-striped" style="width:100%">
    <thead>
      <tr>
        <th>NOMBRE</th>
        <th>DÍAS</th>
        <th>ENTRADA</th>
        <th>SALIDA</th>
        <th>ALMUERZO</th>
        <th>EMPLEADOS</th>
        <th>ACCIÓN</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($horarios as $h)
      <tr>
        <td>{{ $h->nombre }}</td>
        <td>{{ $dias[$h->dia_inicio] }} - {{ $dias[$h->dia_fin] }}</td>
        <td>{{ $h->hora_inicio }}</td>
        <td>{{ $h->hora_fin }}</td>
        <td>{{ $h->almuerzo }}h</td>
        <td>{{ $h->empleados->count() }}</td>
        <td>
          <select class="form-control" id="{{ $h->id }}" onchange="accionesHorarios(this.value, this.id)">
            <option value="0"></option>
            <option value="2">Editar</option>
            <option value="3">Eliminar</option>
          </select>
        </td>
      </tr>
    @endforeach
    </tbody>
</table>
