<table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>Trabajador</th>
        <th>Hora Inicio</th>
        <th>Hora fin</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato->trabajador }}</td>
        <td>{{ $dato->hi }}</td>
        <td>{{ $dato->hf }}</td>
        <td>{{ $dato->ht }}</td>
        <td><button class="btn btn-danger btn-sm">&nbsp;</button</td>
      </tr>
    @endforeach 
    </tbody>
</table>