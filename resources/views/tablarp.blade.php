<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>CC</th>
        <th>Nombre</th>
        <th>Fecha</th>
        <th>Entrada</th>
        <th>Salida</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato['cc'] }}</td>
        <td>{{ $dato['nombre'] }}</td>
        <td>{{ $dato['fecha'] }}</td>
        <td>{{ $dato['entrada'] }}</td>
        <td>{{ $dato['salida'] }}</td>
      </tr>
    @endforeach 
    </tbody>
</table>

<!--<button type="submit" class="btn btn-success">Exportar</button>-->