<table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Hora Inicio</th>
                                <th>Hora fin</th>
                                <th>Total</th>
                                <th>Autorizadas</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dia['Horas'] as $dato)     
                            <tr>
                                <td>{{ $dato['Trabajador'] }}</td>
                                <td>{{ $dato['Hi'] }}</td>
                                <td>{{ $dato['Hf'] }}</td>
                                <td>{{ $dato['Ht'] }}</td>
                                <td>{{ $dato['Ha'] }}</td>
                                <td><input type="number"  name="ha{{ $dato['id'] }}" id="ha{{ $dato['id'] }}" min="0" max="24" size="1" class="form-control"></td>
                                <td><button type="button" class="btn btn-primary btn-sm" onclick="auto({{ $dato['id'] }},{{ $ndia}})" >Ok</button></td>
                            </tr>
                            @endforeach 
                            </tbody>
                        </table>