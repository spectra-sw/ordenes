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
    <style>
        
      
    </style>
</head>
<body>
<div id="formulario">
    <form>
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block">
        </div>

        <div class="col-12 col-md-4 cajaAzul ">
        ORDENES DE TRABAJO <br>
        <button class="btn btn-primary" type="button" onclick="nueva()">Nueva orden</button>
        </div>
        <div class="col-12 col-md-4 cajaAzul">
            CONSECUTIVO <br>
            <input type="hidden" name="id" id="id" value="">
            <span class="red" id="consec"></span>
        </div>
    </div>
    <br>
    <div id="datos">
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
            <div class="col-6 col-md-2 "><input type="text" name="proyecto" id="proyecto" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaInicio" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Responsable</div>
            <div class="col-6 col-md-10"><input type="text" name="responsable" id="responsable" class="form-control" ></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Cliente</div>
            <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Área de trabajo</div>
            <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Contacto</div>
            <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Tipo de sistema solicitado</div>
        </div>
        <div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="cctv" id="cctv" value="cctv"> CCTV</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="incendio" id="incendio" value="incendio"> Incendio</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="cabl.estr" id="cabl.estr" value="cabl.estr">Cabl. Estr.</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="otro" id="otro" value="otro"> Otro</label></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="acceso" id="acceso" value="acceso"> Acceso</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="intrusion" id="intrusion" value="intrusion"> Intrusión</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="integracion" id="integracion" value="integracion"> Integración</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="documentacion" id="documentacion" value="documentacion"> Documentación</label></div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo</div>
        </div>
        <div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="instalacion" id="instalacion" value="instalacion"> Instalación</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="Mnto.Prev" id="Mnto.Prev" value="Mnto.Prev"> Mnto Prev</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="Trab.Int" id="Trab.Int" value="Trab.Int"> Trab. Int.</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="revision" id="revision" value="revision"> Revisión</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="otro" id="otro" value="otro"> Otro</label></div>
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-sm" onclick="nuevodia()">Nuevo día</button>
        <br>
        <div id="dias">
            <input type="hidden" name="diaid" id="diaid" value="">
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Fecha</div>
                <div class="col-6 col-md-2 "><input type="date" name="fecha" id="fecha" value="fecha" class="form-control"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 col-md-2 cajaAzul">Planificación</div>
                <div class="col-6 col-md-1 cajaAzul">Cant</div>
                <div class="col-6 col-md-1 "><input type="text" name="cantp" id="cantp" class="form-control"></div>
                <div class="col-6 col-md-1 cajaAzul">Und</div>
                <div class="col-6 col-md-1 "><input type="text" name="undp" id="undp" class="form-control"></div>
                <div class="col-6 col-md-2 cajaAzul">Materiales/equipos</div>
                <div class="col-6 col-md-2 "><input type="text" name="materiales" id="materiales" class="form-control"></div>
                <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregarp()">Agregar</button></div></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablap">

                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 col-md-2 cajaAzul">Ejecución</div>
                <div class="col-6 col-md-1 cajaAzul">Cant</div>
                <div class="col-6 col-md-1 "><input type="text" name="cante" id="cante" class="form-control"></div>
                <div class="col-6 col-md-1 cajaAzul">Und</div>
                <div class="col-6 col-md-1 "><input type="text" name="unde" id="unde" class="form-control"></div>
                <div class="col-6 col-md-2 cajaAzul">Observación</div>
                <div class="col-6 col-md-2 "><input type="text" name="observacione" id="observacione" class="form-control"></div>
                <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregare()">Agregar</button></div></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablae">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Observación del día</div>
                <div class="col-6 col-md-10 "><input type="text" name="observaciond" id="observaciond" class="form-control"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Trabajador</div>
                <div class="col-6 col-md-1 "><input type="text" name="trabajador" id="trabajador" class="form-control"></div>
                <div class="col-4 col-md-1 cajaAzul">Hi</div>
                <div class="col-4 col-md-1 "><input type="number" name="hi" id="hi" min="0" max="24" class="form-control"></div>
                <div class="col-4 col-md-1 "><input type="number" name="mi" id="mi" min="0" max="59" class="form-control"></div>
                <div class="col-4 col-md-1 cajaAzul">Hf</div>
                <div class="col-4 col-md-1 "><input type="number" name="hf" id="hf" min="0" max="24" class="form-control"></div>
                <div class="col-4 col-md-1 "><input type="number" name="mf" id="mf" min="0" max="59" class="form-control"></div>
                <div class="col-4 col-md-1 cajaAzul">Th</div>
                <div class="col-4 col-md-1 "><input type="number" onclick="calchoras()" name="th" id="th" min="0" max="24" class="form-control"></div>
                <div class="col-6 col-md-1 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregarh()">Agregar</button></div></div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablah">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12"><button class="btn btn-primary btn-block" type="button" onclick="almdia()">Almacenar día</button></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Observaciones y comentarios generales de la OT</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12"><textarea rows="10" name="observacionesg" id="observacionesg" class="form-control"></textarea></div>
        </div>
        <div class="row">
            <div class="col-12"><button class="btn btn-primary btn-block" type="submit">Finalizar orden</button></div>
        </div>
    </div>
    </form>
</div>
</body>
</html>
<script src="{{asset('js/scripts.js')}}"></script>