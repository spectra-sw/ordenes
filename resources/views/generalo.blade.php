
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>  
        <th>FECHA</th>
        <th>CC</th>
        <th>NOMBRE</th>     
        <th>AREA</th>    
        <th>PROYECTO</th>   
        <th>ACTIVIDAD</th>
        <th>HORAS</th>
        <th>MINUTOS</th>
        <th></th>
        <!--<th>CREACIÓN</th>-->
      </tr>
    </thead>
    <tbody>
    @foreach($ocs as $oc)    
        <tr>
            <td>{{ $oc->dia}}</td>
            <td>{{ $oc->cc}}</td>
            <td>{{ $oc->empleado->nombre . " " . $oc->empleado->apellido1  }}</td>
            <td>{{ $oc->narea->area }}</td>
            <td>{{ $oc->proyecto }}</td>
            <td>{{ $oc->nactividad->actividad }}</td>
            <td>{{ $oc->horas}}</td>
            <td>{{ $oc->minutos }}</td>
            <td><button class="btn btn-danger btn-sm" type="button" onclick="delOcupacion({{ $oc->id }})">x</button></td>
           <!-- <td>{{ $oc->created_at }}</td>-->
        </tr>
    @endforeach
    </tbody>
</table>
