<div class="card" >
    <div class="card-header">Rango de fechas</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 overflow-auto" style="height: 80vh">
                <p>Total jornadas: {{ $total_jornadas }}</p>
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
                            <th>Observaciones</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jornadas as $j)
                            <?php $duracion =intval(explode(":", $j->duracion)[0]) + round(floatval(explode(":", $j->duracion)[1]/60),2) ?>

                            <tr>
                                <td>{{ $j->trabajador->apellido1 . " " . $j->trabajador->apellido2 . " " . $j->trabajador->nombre}}</td>

                                <td>{{ $j->proyecto }}</td>
                                <td>{{ $j->proyectoinfo->cliente->cliente ?? 'N/A' }}</td>
                                <td>{{ $j->fecha }}</td>
                                <td><input type="text"  id="hi{{ $j->id }}" name="hi{{ $j->id }}" value="{{ $j->hi }}"></td>
                                <td>{{ $j->fechaf }}</td>
                                <td><input type="text"  id="hf{{ $j->id }}" name="hf{{ $j->id }}" value="{{ $j->hf }}"></td>
                                <td><input type="text"  id="duracion{{ $j->id }}" name="duracion{{ $j->id }}" value="{{ $duracion }}" disabled></td>

                                <td ><input type="number"   min="0" id="almuerzo{{ $j->id }}" name="almuerzo{{ $j->id }}" value="{{ $j->almuerzo }}"></td>

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
                                        Valor no reconocido
                                @endswitch

                                <td>
                                    <input type="text" id="obs{{ $j->id }}" name="obs{{ $j->id }}" value="{{ str_replace(' ', ' ', $j->observacion) }}">
                                </td>

                                <td>
                                    <select class="form-control" onchange="accionj(this.value,this.id)" id="{{ $j->id }}" >
                                        <option value="">--Elige una opción--</option>
                                        <option value="1">Aprobar</option>
                                        <option value="2">Rechazar</option>
                                        <option value="3">Eliminar</option>
                                    </select>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<div>
