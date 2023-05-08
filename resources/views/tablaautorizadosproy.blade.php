<table class="table table-bordered table-striped table-sm" >
    <thead>
        <tr>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($aut as $a)
            @if ($a->empleado)
            <tr>
                <td>{{ $a->empleado->apellido1 . ' ' . $a->empleado->apellido2 . ' ' . $a->empleado->nombre}}</td>
                <td><button class="btn btn-danger" id="{{ $a->id }}" onclick="borrarautorizado(this.id)">x</button></td>
            </tr>
            @endif
        @endforeach
    </tbody>
</table>