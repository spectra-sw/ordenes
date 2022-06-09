
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th >CODIGO</th>
        <th >CLIENTE</th>
        <th >DESCRIPCION</th>
        <th>SISTEMA</th>
        <th>SUBPORTAFOLIO</th>
        <th>DIRECTOR</th>
        <th>LÍDER</th>
        <th>CIUDAD</th>
        <th>CREACION</th>
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
        <td>{{ $p->creacion }}</td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
