
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th onclick="ordenarproy('codigo')" style="cursor:pointer">CODIGO</th>
        <th onclick="ordenarproy('cliente_id')" style="cursor:pointer">CLIENTE</th>
        <th >DESCRIPCION</th>
        <th>SISTEMA</th>
        <th>SUBPORTAFOLIO</th>
        <th>DIRECTOR</th>
        <th>LÍDER</th>
        <th>CIUDAD</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($proyectos  as $p)     
      <tr>
        <td>{{ $p->codigo }}</td>
        <td>{{ $p->cliente->cliente }}</td>
        <td>{{ $p->descripcion }}</td>
        <td>{{ $p->sistema }}</td>
        <td>{{ $p->subportafolio }}</td>
        @if ($p->director ==0)
          <td></td>
        @else
          <td>{{ $p->ndirector->nombre . " " . $p->ndirector->apellido1 }}</td>
        @endif
        @if ($p->lider ==0)
          <td></td>
        @else
          <td>{{ $p->nlider->nombre . " ". $p->nlider->apellido1 }}</td>
        @endif
        
        <td>{{ $p->ciudad }}</td>
        <td><select class="form-control" id="{{ $p->id }}" onchange="accionesproyectos(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="2">Eliminar</option>
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
