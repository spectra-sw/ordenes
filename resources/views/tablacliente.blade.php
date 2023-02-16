
<table id="tablacliente" class="table table-striped" style="width:100%">
    <thead>
      <tr >
        <th onclick="ordenarc('codigo')" style="cursor:pointer">CLIENTE</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">CONTACTOS</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($clientes  as $c)     
      <tr>
        <td>{{ $c->cliente }}</td>
        <td>{{ $c->contactos }}</td>
        
        <td><select class="form-control" id="{{ $c->id }}" onchange="accionescliente(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="2">Eliminar</option>
        </select></td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
<script>
  $(document).ready(function() {
      $('#tablacliente').DataTable();
  } );
</script>
