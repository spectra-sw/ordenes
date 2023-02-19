<div class="card" >
    <div class="card-header">Rango de fechas</div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12">
                <p>Total jornadas: {{ $total_jornadas }}</p>
                <table class="table table-bordered table-striped table-sm" >
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proyecto</th>
                            <th>Tipo</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Estado aprobación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jornadas as $j)
                            <tr>
                                <td>{{ $j->fecha }}</td>
                                <th>{{ $j->proyecto }}</th>
                                <td>{{ $j->tipo == 1 ? "Actividad" : "Almuerzo" }}</td>
                                <td>{{ $j->hi }}</td>
                                <td>{{ $j->hf }}</td>
                                <td>@switch($j->estado)
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
                                <td><button type="button" id="{{ $j->id}}" class="btn btn-danger btn-sm" onclick="delj(this.id)" {{ $estado == 0 ? 'disabled' : ''}}><i class="bi bi-file-x-fill"></i></button></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
<div>