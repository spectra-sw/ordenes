<table class="table table-bordered table-sm">
    <thead>
      <tr>
      <th>No. orden</th>
        <th>Proyecto</th>
       <!-- <th>Fecha Inicio</th>
        <th>Fecha Final</th>-->
        <th>Responsable</th>
        <th>Cliente</th>
        <th>Area</th>
        <th>Contacto</th>
        <th>Tipo de sistema</th>
        <th>Objeto</th>
        <th>Observaciones</th>
        <th>Creación</th>
        <th>Autorizada</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($datos as $dato)     
      <tr>
      <td>{{ $dato->id }}</td>
        <td>{{ $dato->proyecto }}</td>
      <!--  <td>{{ $dato->fecha_inicio }}</td>
        <td>{{ $dato->fecha_final }}</td>-->
        <td>{{ $dato->responsable }}</td>
        <td>{{ $dato->cliente }}</td>
        <td>{{ $dato->area_trabajo }}</td>
        <td>{{ $dato->contacto }}</td>
        <td>{{ $dato->tipo }}</td>
        <td>{{ $dato->objeto }}</td>
        <td>{{ $dato->observaciones}}</td>
        <td>{{ $dato->created_at }}</td>
        <td>{{ $dato->autorizada_por !=0 ? 'Si' : 'No'}}</td>
        @if (session('tipo')==0)
        <td><button class="btn btn-primary btn-sm" type="button" onclick="verorden({{ $dato->id }})">Autorizar</button</td>
        @endif
        
        <td><button class="btn btn-primary btn-sm" type="button" onclick="editorden({{ $dato->id }})">Editar</button</td>
       
      </tr>
    @endforeach 
    </tbody>
</table>