@foreach($dias as $d)
        <div>  
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Fecha</div>
                <div class="col-6 col-md-2 "><input type="date" name="fecha" id="fecha" value="{{ $d['fecha'] }}" class="form-control" disabled ></div>
            </div>
            
            <div class="row">
                <div class="col-6 cajaAzul">Planificación</div>
                <div class="col-6 cajaAzul">Ejecución</div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div id="tablap">
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>CANT</th>
                                <th>UND</th>
                                <th>MATERIALES</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($d['Planificacion'] as $dato)     
                            <tr>
                                <td>{{ $dato['Cant'] }}</td>
                                <td>{{ $dato['Und'] }}</td>
                                <td>{{ $dato['Materiales']}}</td>
                                
                            </tr>
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-6">
                    <div id="tablae">
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>CANT</th>
                                <th>UND</th>
                                <th>OBSERVACION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($d['Ejecucion'] as $dato)     
                            <tr>
                                <td>{{ $dato['Cant'] }}</td>
                                <td>{{ $dato['Und'] }}</td>
                                <td>{{ $dato['Observacion'] }}</td>
                                
                            </tr>
                            @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Observación del día</div>
                <div class="col-6 col-md-10 "><input type="text" name="observaciond" id="observaciond" class="form-control" value="{{ $d['observacion'] }}" disabled></div>
            </div>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Horas</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablah{{ $d['id'] }}">
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Hora Inicio</th>
                                <th>Hora fin</th>
                                <th>Total</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($d['Horas'] as $dato)     
                            <tr>
                                <td>{{ $dato['Trabajador'] }}</td>
                                <td>{{ $dato['Hi'] }}</td>
                                <td>{{ $dato['Hf'] }}</td>
                                <td>{{ $dato['Ht'] }}</td>
                                
                            </tr>
                            @endforeach 
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <br>    
        </div>
@endforeach