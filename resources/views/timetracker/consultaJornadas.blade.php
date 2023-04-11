<div class="card" >
    <div class="card-header">Rango de fechas</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <p>Total jornadas: {{ $total_jornadas }}</p>
                <table class="table table-bordered table-striped table-sm" >
                    <thead>
                        <tr>
                            <th>Fecha Inicio</th>
                            <th>Proyecto</th>
                            <th>Hora Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Hora Fin</th>
                            <th>Duración</th>
                            <th>Estado aprobación</th>
                            <th>Observación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jornadas as $j)
                            <tr>
                                <td>{{ $j->fecha }}</td>
                                <td>{{ $j->proyecto }}</td>
                                <td>{{ $j->hi }}</td>
                                <td>{{ $j->fechaf }}</td>
                                <td>{{ $j->hf }}</td>
                                <td>{{ $j->duracion }}</td>
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
                            
                                <td>{{ $j->observacion }}</td>
                                <td><button type="button" id="{{ $j->id}}" class="btn btn-danger btn-sm" onclick="delj2(this.id)" {{ $j->estado != 1 ? 'disabled' : ''}}><i class="bi bi-file-x-fill"></i></button></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
<div>