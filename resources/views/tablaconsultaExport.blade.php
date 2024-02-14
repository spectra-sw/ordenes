<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Proyecto</th>
            <th>Cliente</th>
            <th>Fecha Inicio</th>
            <th>Hora Inicio</th>
            <th>Fecha Fin</th>
            <th>Hora Fin</th>
            <th>Duración</th>
            <th>Almuerzo</th>
            <th>Laborales</th>
            <th>Creación</th>
            <th>Aprobación</th>
            <th>Aprobada por</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jornadas as $j)
            <?php $duracion = intval(explode(':', $j->duracion)[0]) + round(floatval(explode(':', $j->duracion)[1] / 60), 1); ?>

            <tr>
                <td>
                    {{ $j->trabajador->apellido1 . ' ' . $j->trabajador->apellido2 . ' ' . $j->trabajador->nombre }}
                </td>

                <td>{{ $j->proyecto }}</td>
                <td>{{ $j->proyectoinfo->cliente->cliente ?? 'N/A' }}</td>
                <td>{{ $j->fecha }}</td>
                <td>{{ $j->hi }}</td>
                <td>{{ $j->fechaf }}</td>
                <td>{{ $j->hf }}</td>
                <td>{{ $duracion }}</td>
                <td>{{ $j->almuerzo }}</td>
                <td>{{ $duracion - $j->almuerzo }}</td>
                <td>{{ $j->created_at }}</td>
                @switch($j->estado)
                    @case(1)
                        <td class="table-warning">Pendiente</td>
                    @break

                    @case(2)
                        <td class="table-success">Aprobada</td>
                    @break

                    @case(3)
                        <td class="table-danger">Rechazada</td>
                    @break

                    @default
                        <td class="table-danger">Valor no reconocido</td>
                @endswitch
                @if  ($j->revisado_por >0)
                                    <td>{{ $j->revisado->nombre . " " .$j->revisado->apellido1 }}</td> 
                @else
                                    <td></td>
                @endif 
                <td> {{ $j->observacion }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
