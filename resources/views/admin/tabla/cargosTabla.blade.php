<table id="tablaCargos" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th onclick="ordenarc('cargo')" style="cursor:pointer">CLIENTE</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cargos as $cargo)
            <tr>
                <td>{{ $cargo->cargo }}</td>
                <td>
                    <select class="form-control" id="{{ $cargo->id }}" onchange="accionesCargos(this.value, this.id)">
                        <option value="0"></option>
                        <option value="2">Editar</option>
                        <option value="3">Eliminar</option>
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
