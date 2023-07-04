<table id="tablaEmpleados" class="table table-striped" style="width:100%">
    <thead>
        <tr style="cursor:pointer">
            <th onclick="ordenar('cc')">CC</th>
            <th onclick="ordenar('apellido1')">APELLIDO 1</th>
            <th onclick="ordenar('apellido2')">APELLIDO 2</th>
            <th onclick="ordenar('nombre')">NOMBRE</th>
            <th onclick="ordenar('auxilio')">AUXILIO</th>
            <th>AUXILIO TR.</th>
            <th onclick="ordenar('correo')">CORREO</th>
            <th>CIUDAD</th>
            <th>AREA</th>
            <th>CARGO</th>
            <th onclick="ordenar('tipo')">TIPO</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($emp as $e)
            <tr>
                <td>{{ $e->cc }}</td>
                <td>{{ $e->apellido1 }}</td>
                <td>{{ $e->apellido2 }}</td>
                <td>{{ $e->nombre }}</td>
                <td>{{ $e->auxilio }}</td>
                <td>{{ $e->auxiliot == 0 ? 'No' : 'Si' }}</td>
                <td>{{ $e->correo }}</td>
                <td>{{ $e->ciudad }}</td>
                <td>{{ $e->narea->area ?? 'no tiene area' }}</td>
                <td>{{ $e->ncargo ? $e->ncargo->cargo : '' }}</td>
                <td>{{ $e->tipo == 0 ? 'Admin' : 'Registro' }}</td>
                <td>
                    <select class="form-control" id="{{ $e->id }}" onchange="accionesEmpleados(this.value, this.id)">
                        <option value="0"></option>
                        <option value="2">Editar</option>
                        <option value="4">Contraseña</option>
                        <option value="3">Inactivar</option>
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="cursor:pointer">
            <th onclick="ordenar('cc')">CC</th>
            <th onclick="ordenar('apellido1')">APELLIDO 1</th>
            <th onclick="ordenar('apellido2')">APELLIDO 2</th>
            <th onclick="ordenar('nombre')">NOMBRE</th>
            <th onclick="ordenar('auxilio')">AUXILIO</th>
            <th>AUXILIO TR.</th>
            <th onclick="ordenar('correo')">CORREO</th>
            <th>CIUDAD</th>
            <th>AREA</th>
            <th>CARGO</th>
            <th onclick="ordenar('tipo')">TIPO</th>
        </tr>
    </tfoot>
</table>
