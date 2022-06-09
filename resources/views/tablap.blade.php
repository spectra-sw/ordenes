<table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th>CANT</th>
        <th>UND</th>
        <th>MATERIALES</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
        <td>{{ $dato->cant }}</td>
        <td>{{ $dato->und }}</td>
        <td>{{ $dato->materiales }}</td>
        <td><button class="btn btn-danger btn-sm" type="button" onclick="del(1,{{ $dato->id}},{{ $dato->dias_id}})">x</button></td>
      </tr>
    @endforeach 
    </tbody>
</table>