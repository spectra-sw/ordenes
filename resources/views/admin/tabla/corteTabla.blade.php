<table id="tablaCortes" class="table table-striped" style="width:100%">
    <thead>
      <tr >
        <!--<th onclick="ordenarproy('codigo')" style="cursor:pointer">CODIGO</th>
        <th onclick="ordenarproy('cliente_id')" style="cursor:pointer">CLIENTE</th>-->
        <th>FECHA INCIO </th>
        <th>FECHA FIN</th>
        <th>ESTADO</th>
        <th>ACCIÓN</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($cortes  as $c)
      <tr>
        <td>{{ $c->fecha_inicio }}</td>
        <td>{{ $c->fecha_fin }}</td>

        <td>{{ ($c->estado == 1) ? "Abierto" : 'Cerrado'}}</td>
        <td><select class="form-control" id="{{ $c->id }}" onchange="accionesCortes(this.value, this.id)">
            <option value="0"></option>
            <option value="4">{{ $c->estado == 1 ? 'Cerrar' : 'Habilitar' }}</option>
        </select></td>

      </tr>
    @endforeach
    </tbody>
</table>
