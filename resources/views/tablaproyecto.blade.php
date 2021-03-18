
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th onclick="ordenarc('codigo')" style="cursor:pointer">CODIGO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">CLIENTE</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">DESCRIPCION</th>
        <th>SISTEMA</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($proyectos  as $p)     
      <tr>
        <td>{{ $p->codigo }}</td>
        <td>{{ $p->cliente->cliente }}</td>
        <td>{{ $p->descripcion }}</td>
        <td>{{ $p->sistema }}</td>
        <td><select class="form-control" id="{{ $p->id }}" onchange="accionesproyectos(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="2">Eliminar</option>
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
