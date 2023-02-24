

  <table id="tablaemp" class="table table-striped" style="width:100%">

    <thead>
      <tr style="cursor:pointer">
        <th onclick="ordenar('cc')">CC</th>
        <th onclick="ordenar('apellido1')">APELLIDO 1</th>
        <th onclick="ordenar('apellido2')">APELLIDO 2</th>
        <th onclick="ordenar('nombre')">NOMBRE</th>
        <th onclick="ordenar('auxilio')">AUXILIO</th>
        <th >AUXILIO TR.</th>
        <th onclick="ordenar('correo')">CORREO</th>
        <th>CIUDAD</th>
        <th>AREA</th>
        <th>CARGO</th>
        <th onclick="ordenar('tipo')">TIPO</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($emp  as $e)     
      <tr>
        <td>{{ $e->cc }}</td>
        <td>{{ $e->apellido1 }}</td>
        <td>{{ $e->apellido2 }}</td>
        <td>{{ $e->nombre }}</td>
        <td>{{ $e->auxilio }}</td>
        <td>{{ $e->auxiliot == 0 ? 'No' : 'Si' }}</td>
        <td>{{ $e->correo }}</td>
        <td>{{ $e->ciudad }}</td>
        <td>{{ $e->narea->area }}</td>
        <td>{{ $e->ncargo->cargo }}</td>
        <td>{{ $e->tipo == 0 ? 'Admin' : 'Registro' }}</td>
        <td><select class="form-control" id="{{ $e->id }}" onchange="acciones(this.value,this.id)">
            <option value=""></option>
            <option value="1">Editar</option>
            <option value="3">Contraseña</option>
            <option value="2">Inactivar</option>
            
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
    <tfoot>
      <tr style="cursor:pointer">
        <th onclick="ordenar('cc')">CC</th>
        <th onclick="ordenar('apellido1')">APELLIDO 1</th>
        <th onclick="ordenar('apellido2')">APELLIDO 2</th>
        <th onclick="ordenar('nombre')">NOMBRE</th>
        <th onclick="ordenar('auxilio')">AUXILIO</th>
        <th >AUXILIO TR.</th>
        <th onclick="ordenar('correo')">CORREO</th>
        <th>CIUDAD</th>
        <th>AREA</th>
        <th>CARGO</th>
        <th onclick="ordenar('tipo')">TIPO</th>
      </tr>
  </tfoot>
</table>
