<table id="tablaCargos" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th onclick="ordenarc('cargo')" style="cursor:pointer">Cargo</th>
            <th>Activo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cargos as $cargo)
            <tr>
                <td>{{ $cargo->cargo }}</td>
                @if ($cargo->estado)
                    <td>
                        <i class="bi bi-check-circle-fill text-success"></i>
                    </td>
                @else
                    <td>
                        <i class="bi bi-x-circle-fill text-danger"></i>
                    </td>
                @endif
                <td>
                    <select class="form-control" id="{{ $cargo->id }}" onchange="accionesCargos(this.value, this.id)">
                        <option value="0"></option>
                        <option value="2">Editar</option>
                        <option value="3">{{ $cargo->estado ? 'Inactivar' : 'Activar' }}</option>
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
