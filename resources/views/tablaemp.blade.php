
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>CC</th>
        <th>APELLIDO 1</th>
        <th>APELLIDO 2</th>
        <th>NOMBRE</th>
        <th>AUXILIO</th>
        <th>CORREO</th>
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
        <td>{{ $e->correo }}</td>
        <td><select>
            <option></option>
            <option>Editar</option>
            <option>Eliminar</option>
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
