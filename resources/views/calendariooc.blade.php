
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >      
        <th>FECHA</th>
        <th>REPORTE</th>      
      </tr>
    </thead>
    <tbody>
    @foreach ($calendariooc as $c)     
      <tr>
        <td>{{ $c['fecha']}}</td>
        <td>{{ $c['registro']}}</td>
        
        
      </tr>
    @endforeach 
    </tbody>
</table>
