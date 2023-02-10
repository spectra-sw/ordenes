<table class="table table-bordered table-striped table-sm" >
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Proyecto</th>
            <th>Tipo</th>
            <th>Hora Inicio</th>
            <th>Hora Fin</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($jornada as $j)
            <tr>
                <td>{{ $j->fecha }}</td>
                <th>{{ $j->proyecto }}</th>
                <td>{{ $j->tipo == 1 ? "Actividad" : "Almuerzo" }}</td>
                <td>{{ $j->hi }}</td>
                <td>{{ $j->hf }}</td>
                <td><button type="button" id="{{ $j->id}}" class="btn btn-danger btn-sm" onclick="delj(this.id)"><i class="bi bi-file-x-fill"></i></button></td>
                
            </tr>
        @endforeach
    </tbody>
</table>