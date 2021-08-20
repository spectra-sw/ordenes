<table class="table table-bordered table-striped table-sm">
    <tbody>
    @foreach ($calendario as $c)     
      <tr>
        @foreach ($c as $col) 
            <td>
                <table>
                    @if($col['fecha'])
                        <tr class="table-primary"><td>{{$col['fecha']}}</td></tr>
                        <tr class="table-success"><td>{{$col['nombre']}}</td></tr>
                        <tr><td>{{$col['proyecto']}}</td></tr>
                        <tr><td>{{$col['responsable']}}</td></tr>
                        <tr class="table-warning"><td>{{$col['inicio']. " - ". $col['fin']}}</td></tr>
                        <tr><td>{{$col['observacion']}}</td></tr>
                        <tr><td>{{$col['grupo']}}</td></tr>
                    @else
                        <tr></tr>
                    @endif
                </table>
            </td> 
        @endforeach    
      </tr>
    @endforeach 
    </tbody>
</table>
<br>
