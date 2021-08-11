
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th onclick="ordenarc('codigo')" style="cursor:pointer">TÉCNICO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">FECHA</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">PROYECTO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">RESPONSABLE</th>
        <th>INICIO</th>
        <th>FIN</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">OBSERVACION</th>
        <th>GRUPO</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($prog as $p)     
      <tr>
        <td>{{ $p->empleado->nombre . " ". $p->empleado->apellido1}}</td>
        <td>{{ $p->fecha }}</td>
        <td>{{ $p->datosproyecto->codigo . " - ". $p->datosproyecto->cliente->cliente }}</td>
        <td>{{ $p->datosresponsable->nombre . " ". $p->datosresponsable->apellido1 }}</td>
        <td>{{ $p->hi }}</td>
        <td>{{ $p->hf }}</td>
        <td>{{ $p->observacion }}</td>
        <td>{{ $p->grupo }}</td>
        <td>
            <select class="form-control" id="{{ $p->id }}" onchange="accionesprog(this.value,this.id)">
            <option></option>
            <option value="1">Editar</option>
            <option value="2">Eliminar</option>
        </select>
        </td>
        
      </tr>
    @endforeach 
    </tbody>
</table>
