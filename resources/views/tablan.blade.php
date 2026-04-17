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
      @php
        $fecha = $dato['fecha movimiento'];
        $esFestivo = isset($festivos[$fecha]);
        $esDomingo = \Carbon\Carbon::parse($fecha)->dayOfWeek === 0;
        $esNormal  = in_array($dato['codigo del concepto'], ['001', '075']);
        if ($esFestivo)     $rowClass = 'table-danger';
        elseif ($esDomingo) $rowClass = 'table-secondary';
        elseif ($esNormal)  $rowClass = 'table-success';
        else                $rowClass = 'table-warning';
      @endphp
      <tr class="{{ $rowClass }}">
        <td>{{ $dato['codigo del empleado'] }}</td>
        <td>{{ $dato['codigo del concepto'] }}</td>
        <td>{{ $dato['centro de operacion'] }}</td>
        <td>{{ $dato['centro de costo'] }}</td>
        <td>{{ $fecha }}</td>
        <td>{{ $dato['horas'] }}</td>
        <td>{{ $dato['valor'] }}</td>
        <td>{{ $dato['unidad de negocio'] }}</td>
      </tr>
    @endforeach
    </tbody>
</table>
<br>
<!---->
<!--<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th>Concepto</th>
        <th>Total horas</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Almuerzo</td>
        <td>{{ $talmuerzo }}</td>
      </tr>
    
    </tbody>
</table>-->
<br>
<button type="submit" class="btn btn-success">Exportar</button>