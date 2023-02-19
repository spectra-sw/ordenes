<div class="card" >
    <div class="card-header">Rango de fechas</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <p>Total jornadas: {{ $total_jornadas }}</p>
                <table class="table table-bordered table-striped table-sm" >
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Aprobación</th>
                            <th>Observaciones</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jornadas as $j)
                            <tr>
                                <td>{{ $j->trabajador->apellido1 . " " . $j->trabajador->apellido2 . " " . $j->trabajador->nombre}}</td>
                                <td>{{ $j->fecha }}</td>
                                <td>{{ $j->proyecto }}</td>
                                <td>{{ $j->proyectoinfo->cliente->cliente }}</td>
                                <td>{{ $j->tipo == 1 ? "Actividad" : "Almuerzo" }}</td>
                                <td>{{ $j->hi }}</td>
                                <td>{{ $j->hf }}</td>
                                <td>
                                @switch($j->estado)
                                    @case(1)
                                        Pendiente
                                        @break
                                    @case(2)
                                        Aprobada
                                        @break
                                    @case(3)
                                        Rechazada
                                        @break
                                    @default
                                        Valor no reconocido
                                @endswitch
                                </td>
                                <td>
                                    <input type="text" id="obs{{ $j->id }}" name="obs" value={{ $j->observacion }}>
                                </td>    
                                <td>
                                    <select class="form-control" onchange="accionj(this.value,this.id)" id="{{ $j->id }}" >
                                        <option value=""></option>
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