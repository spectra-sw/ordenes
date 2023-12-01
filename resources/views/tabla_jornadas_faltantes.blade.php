<table id="tablaJornadaFaltante" class="table table-bordered table-striped mt-4">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>Apellido</th>
            <th>CEDULA</th>
            <th>FECHAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jornadas_pendientes as $jornada)
            <tr>
                <td>{{ $jornada['nombre'] }}</td>
                <td>{{ $jornada['apellido1'] }}</td>
                <td>{{ $jornada['cc'] }}</td>
                <td>{{ implode(', ', $jornada['jornadas_faltantes']) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>

</script>