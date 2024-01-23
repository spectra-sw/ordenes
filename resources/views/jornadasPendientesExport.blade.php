<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th style="font-weight: bold; width: 80px;">NOMBRE</th>
            <th style="font-weight: bold; width: 80px;">Apellido</th>
            <th style="font-weight: bold; width: 150px;">CARGO</th>
            <th style="font-weight: bold; width: 100px;">CEDULA</th>
            @foreach ($fechas_columnas as $item)
                <th style="font-weight: bold; width: 90px;">{{ $item }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($jornadas_pendientes as $jornada)
            <tr>
                <td>{{ $jornada['nombre'] }}</td>
                <td>{{ $jornada['apellido1'] }}</td>
                <td>{{ $jornada['cargo'] }}</td>
                <td>{{ $jornada['cc'] }}</td>
                @foreach ($fechas_columnas as $item)
                    @if (isset($jornada['jornadas_faltantes'][$item]))
                        <td style="background-color: {{ $jornada['jornadas_faltantes'][$item]['color'] }}; margin: 2px">
                            {{ $jornada['jornadas_faltantes'][$item]['duracion'] }}
                        </td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
