<table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>FECHA</th>
        <th>OBSERVACION</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato->fecha }}</td>
        <td>{{ $dato->observacion }}</td>
        <td><button class="btn btn-primary btn-sm" type="button" onclick="infoDia({{ $dato->id}})">Ver</button</td>
        <td><button class="btn btn-primary btn-sm" type="button" onclick="editDia({{ $dato->id}})">Editar</button</td>
        <td><button class="btn btn-danger btn-sm" type="button" onclick="deleteDia({{ $dato->id}})">Eliminar</button</td>
      </tr>
    @endforeach 
    </tbody>
</table>