<table id="tablaTurnos" class="table table-striped" style="width:100%;overflow:scroll;color:black">
    <thead>
        <tr>
            <th>CC</th>
            <th>NOMBRE</th>
            <th>FECHA_INICIO</th>
            <th>HORA_INICIO</th>
            <th>FECHA_FIN</th>
            <th>HORA_FIN</th>
            <th>ALMUERZO</th>
            <th>ACCIÓN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($turnos as $t)
            <tr>
                <td>{{ isset($t->empleado) ? $t->empleado->cc : '' }} </td>
                <td>{{ isset($t->empleado) ? $t->empleado->apellido1 . ' ' . $t->empleado->apellido2 . ' ' . $t->empleado->nombre : '' }}
                </td>
                <td>{{ $t->fecha_inicio }}</td>
                <td>{{ $t->hora_inicio }}</td>
                <td>{{ $t->fecha_fin }}</td>
                <td>{{ $t->hora_fin }}</td>
                <td>{{ $t->almuerzo }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-primary px-1 py-0" onclick="accionesTurnos(2,{{$t->id}})">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
