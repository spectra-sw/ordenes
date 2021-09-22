<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>CC</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Proyecto</th>
        <th>Entrada</th>
        <th>Salida</th>
        <th>Autorizadas</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato['cc'] }}</td>
        <td>{{ $dato['nombre'] }}</td>
        <td>{{ $dato['fecha'] }}</td>
        <td>{{ $dato['proyecto'] }}</td>
        <td>{{ $dato['entrada'] }}</td>
        <td>{{ $dato['salida'] }}</td>
        <td>{{ $dato['autorizadas'] }}</td>
      </tr>
    @endforeach 
    </tbody>
</table>

<!--<button type="submit" class="btn btn-success">Exportar</button>-->