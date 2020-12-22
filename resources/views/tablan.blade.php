<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>Código</th>
        <th>Concepto</th>
        <th>Centro de op</th>
        <th>Centro de costo</th>
        <th>Fecha</th>
        <th>Horas</th>
        <th>Valor</th>
        <th>Unidad</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato['codigo del empleado'] }}</td>
        <td>{{ $dato['codigo del concepto'] }}</td>
        <td>{{ $dato['centro de operacion'] }}</td>
        <td>{{ $dato['centro de costo'] }}</td>
        <td>{{ $dato['fecha movimiento'] }}</td>
        <td>{{ $dato['horas'] }}</td>
        <td>{{ $dato['valor'] }}</td>
        <td>{{ $dato['unidad de negocio'] }}</td>
      </tr>
    @endforeach 
    </tbody>
</table>