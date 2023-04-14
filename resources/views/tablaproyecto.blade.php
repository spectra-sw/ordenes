<br>
<table id="tablaproyectos" class="table table-striped" style="width:100%">
    <thead>
      <tr >
        <!--<th onclick="ordenarproy('codigo')" style="cursor:pointer">CODIGO</th>
        <th onclick="ordenarproy('cliente_id')" style="cursor:pointer">CLIENTE</th>-->
        <th>CODIGO</th>
        <th>CLIENTE</th>
        <th >DESCRIPCION</th>
        <th>SISTEMA</th>
        <th>SUBPORTAFOLIO</th>
        <th>DIRECTOR</th>
        <th>LÍDER</th>
        <th>CIUDAD</th>
        <th>C.O</th>
        <th>U.N</th>
        <th>R.HORAS</th>
        <th>ACCIÓN</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($proyectos  as $p)     
      <tr>
        <td>{{ $p->codigo }}</td>
        <td>{{ $p->cliente ? $p->cliente->cliente : ''}}</td>
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
        <td>{{ isset($p->cdc->centro_operacion) ? $p->cdc->centro_operacion : ''}}</td>
        <td>{{ isset($p->cdc->unidad_negocio) ? $p->cdc->unidad_negocio : ''}}</td>
        <td>{{ ($p->registro == 1) ? "Si" : 'No'}}</td>
        <td><select class="form-control" id="{{ $p->id }}" onchange="accionesproyectos(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="3">Autorizados</option>
            <!--<option value="2">Eliminar</option>-->
            
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
<script>
  $(document).ready(function() {
      $('#tablaproyectos').DataTable();
  } );
</script>