<table class="table table-bordered table-striped table-sm table-responsive" >
    <thead>
        <tr>
            <th>Fecha Inicio</th>
            <th>Proyecto</th>
            <th>Hora Inicio</th>
            <th>Fecha Fin</th>
            <th>Hora Fin</th>
            <th>Duración</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($jornada as $j)
            <tr>
                <td>{{ $j->fecha }}</td>
                <td>{{ $j->proyecto }}</td>
                <td>{{ $j->hi }}</td>
                <td>{{ $j->fechaf }}</td>
                <td>{{ $j->hf }}</td>
                <td>{{ $j->duracion }}</td>
             
                <td><button type="button" id="{{ $j->id}}" class="btn btn-danger btn-sm" onclick="delj(this.id)"><i class="bi bi-file-x-fill"></i></button></td>
                
            </tr>
        @endforeach
    </tbody>
</table>