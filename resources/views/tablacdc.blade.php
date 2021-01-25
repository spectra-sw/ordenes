
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>CODIGO</th>
        <th>DESCRIPCION</th>
        <th>C.OP</th>
        <th>U.NE</th>
        <th>RESPONSABLE</th>
        <th>MAYOR</th>
        <th>GRUPO</th>
        <th>OBSERVACIONES</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($cdc  as $c)     
      <tr>
        <td>{{ $c->codigo }}</td>
        <td>{{ $c->descripcion }}</td>
        <td>{{ $c->centro_operacion }}</td>
        <td>{{ $c->unidad_negocio }}</td>
        <td>{{ $c->responsable }}</td>
        <td>{{ $c->mayor }}</td>
        <td>{{ $c->grupo }}</td>
        <td>{{ $c->observaciones }}</td>
        <td><select class="form-control" id="{{ $c->id }}" onchange="accionescdc(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="2">Eliminar</option>
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
