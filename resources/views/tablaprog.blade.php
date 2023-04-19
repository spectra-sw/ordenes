
<table class="table table-bordered table-striped table-sm">
    <thead>
      <tr >
        <th onclick="ordenarc('codigo')" style="cursor:pointer">FUNCIONARIO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">FECHA</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">PROYECTO</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">RESPONSABLE</th>
        <th>INICIO</th>
        <th>FIN</th>
        <th onclick="ordenarc('descripcion')" style="cursor:pointer">OBSERVACION</th>
        <th>ESTADO</th>
        <th>GRUPO</th>
        <th>EXTRA</th>
        <th>CREACION</th>
        
      </tr>
    </thead>
    <tbody>
    @foreach ($prog as $p)     
      <tr>
        <td>{{ $p->empleado->nombre . " ". $p->empleado->apellido1}}</td>
        <td>{{ $p->fecha }}</td>
        <td>{{ $p->proyecto . " - ". $p->datosproyecto->cliente->cliente }}</td>
        <td>{{ p->datosresponsable ? $p->datosresponsable->nombre . " ". $p->datosresponsable->apellido1 : '' }}</td>
        <td>{{ $p->hi }}</td>
        <td>{{ $p->hf }}</td>
        <td>{{ $p->observacion }}</td>
        @if ($dato[$p->id]==1)
        <td><img src="{{ URL::asset('img/red.png') }}" width="50%"></td>
        @endif
        @if ($dato[$p->id]==2)
        <td><img src="{{ URL::asset('img/orange.png') }}" width="50%"></td>
        @endif
        @if ($dato[$p->id]==3)
        <td><img src="{{ URL::asset('img/yellow.png') }}" width="50%"></td>
        @endif
        @if ($dato[$p->id]==4)
        <td><img src="{{ URL::asset('img/green.png') }}" width="50%"></td>
        @endif
        <td>{{ $p->grupo }}</td>
        @if ($p->extra==0)
        <td>No</td>
        @endif
        @if ($p->extra==1)
        <td>Si</td>
        @endif
        <td>
        {{ $p->created_at}}
        </td>
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
