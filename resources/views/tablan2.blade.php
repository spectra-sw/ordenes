<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>ID CIA</th>
        <th>ID TERCERO</th>
        <th>NDC</th>
        <th>LAPSO</th>
        <th>UNIDADES</th>
        <th>CENTRO OPERACION</th>
        <th>CENTRO COSTOS</th>
        <th>ID PROYECTO</th>
        <th>ID UNIDAD DE NEGOCIO</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato['ID'] }}</td>
        <td>{{ $dato['ID TERCERO'] }}</td>
        <td>{{ $dato['NDC'] }}</td>
        <td>{{ $dato['LAPSO'] }}</td>
        <td>{{ $dato['UNIDADES'] }}</td>
        <td>{{ $dato['CENTRO OPERACION'] }}</td>
        <td>{{ $dato['CENTRO COSTOS'] }}</td>
        <td>{{ $dato['ID PROYECTO'] }}</td>
        <td>{{ $dato['ID UNIDAD DE NEGOCIO'] }}</td>
      </tr>
    @endforeach 
    </tbody>
</table>
<br>
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>Código</th>
        <th>Total horas</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($total as $clave => $valor)     
      <tr>
        <td>{{ $clave }}</td>
        <td>{{ $valor }}</td>
      </tr>
      @endforeach 
    </tbody>
</table>
    
<br>
<button type="submit" class="btn btn-success">Exportar</button>