
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
        <th>C.O</th>
        <th>U.N</th>
        <th>CREACION</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($proyectos  as $p)     
      <tr>
        <td>{{ $p->codigo }}</td>
        <td>{{ $p->cliente ? $p->cliente->cliente : '' }}</td>
        <td>{{ $p->descripcion }}</td>
        <td>{{ $p->sistema }}</td>
        <td>{{ $p->subportafolio }}</td>
        @if ($p->director ==0)
          <td></td>
        @else
          <td>{{ $p->ndirector ? $p->ndirector->nombre . " " . $p->ndirector->apellido1 : ''}}</td>
        @endif
      
        <td>{{ $p->nlider ? $p->nlider->nombre . " ". $p->nlider->apellido1 : ''  }}</td>
        
        
        <td>{{ $p->ciudad }}</td>
        <td>{{ isset($p->cdc->centro_operacion) ? $p->cdc->centro_operacion : ''}}</td>
        <td>{{ isset($p->cdc->unidad_negocio) ? $p->cdc->unidad_negocio : ''}}</td>
        <td>{{ $p->creacion }}</td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
