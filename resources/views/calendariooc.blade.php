<table class="table table-bordered table-striped mt-4">
    <thead>
        <tr>
            <th>FECHA</th>
            <th>REPORTE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($calendariooc as $c)
            <tr>
                <td>{{ $c['fecha'] }}</td>
                <td>{{ $c['registro'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
