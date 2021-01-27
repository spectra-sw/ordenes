<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ordenes de trabajo - Spectra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
    
   
    <style>
        
      
    </style>
</head>
<body>
<div id="formulario">

    <form id="f1">
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block">
        </div>

        <div class="col-12 col-md-4 cajaAzul ">
        ORDENES DE TRABAJO <br>
        <!--<button class="btn btn-primary" type="button" onclick="nueva()">Nueva orden</button>-->
        </div>
        <div class="col-12 col-md-4 cajaAzul">
            CONSECUTIVO <br>
            <input type="hidden" name="id" id="id" value="">
            <span class="red" id="consec">{{ $o->id }}</span>
        </div>
    </div>
    <br>
    <div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
            <div class="col-6 col-md-2 "><input type="text" name="proyecto" id="proyecto" class="form-control basicAutoComplete" value="{{ $o->proyecto }}" disabled></div>
            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="{{ $o->fecha_inicio }}" disabled></div>
            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control" value="{{ $o->fecha_final }}" disabled></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Responsable</div>
            <div class="col-6 col-md-10">
                <!--<input type="text" name="responsable" id="responsable" class="form-control basicAutoComplete" data-url="autoemp" >
                <input type="hidden" name="cc" id="cc">-->
                <input type="text" name="responsable" id="responsable" value="{{ $o->responsable }}" disabled >
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Cliente</div>
            <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control" value="{{ $o->cliente }}" disabled></div>
            <div class="col-6 col-md-2 cajaAzul">Área de trabajo</div>
            <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control" value="{{ $o->area_trabajo }}" disabled></div>
            <div class="col-6 col-md-2 cajaAzul">Contacto</div>
            <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control" value="{{ $o->contacto }}" disabled></div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Tipo de sistema solicitado</div>
        </div>
        <div class="row">
            <div class="col-6 col-md-12 "><input type="text" class="form-control" name="tipo" id="tipo" value="{{ $o->tipo }}"></div>
        </div>
        
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo</div>
        </div>
        <div class="row">
            <div class="col-6 col-md-12 "><input type="text" class="form-control" name="tipo" id="tipo" value="{{ $o->objeto }}"></div>
        </div>
        <br>
        <p><div class="cajaAzul">Días registrados</div></p>
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
                <div class="col-6 col-md-10 "><input type="text" name="observaciond" id="observaciond" class="form-control" disabled></div>
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
                                <th>Autorizadas</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($d['Horas'] as $dato)     
                            <tr>
                                <td>{{ $dato['Trabajador'] }}</td>
                                <td>{{ $dato['Hi'] }}</td>
                                <td>{{ $dato['Hf'] }}</td>
                                <td>{{ $dato['Ht'] }}</td>
                                <td>{{ $dato['Ha'] }}</td>
                                <td><input type="number"  name="ha{{ $dato['id'] }}" id="ha{{ $dato['id'] }}" min="0" max="24" size="1" class="form-control"></td>
                                <td><button type="button" class="btn btn-primary btn-sm" onclick="auto({{ $dato['id'] }},{{ $d['id'] }})" >Ok</button></td>
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
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Observaciones y comentarios generales de la OT</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
            <textarea rows="10" name="observacionesg" id="observacionesg" class="form-control" disabled>
            {{ $o->observaciones }}
            </textarea></div>
        </div>
        <!--
        <div class="row">
            <div class="col-12"><button class="btn btn-primary btn-block" type="button" onclick="enviarorden()">Finalizar orden</button></div>
        </div>
        -->
    </div>
    </form>
</div>

</body>
</html>
<script src="{{asset('js/scripts.js')}}"></script>