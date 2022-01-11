
<table class="table table-bordered  table-sm">
    <thead>
      <tr >   
        <th>CC</th>   
        <th>NOMBRE</th>
        <th>ÁREA</th>
        <th>FECHA</th> 
        <th>HORAS</th>     
      </tr>
    </thead>
    <tbody>
    @foreach ($seguimiento as $s)     
      <tr class="{{ $s['clase'] }}">
        <td>{{ $s['cc']}}</td>
        <td>{{ $s['nombre']}}</td>
        <td>{{ $s['area']}}</td>
        <td>{{ $s['fecha']}}</td>
        <td >{{ $s['registro']}}</td>
        
        
      </tr>
    @endforeach 
    </tbody>
</table>
