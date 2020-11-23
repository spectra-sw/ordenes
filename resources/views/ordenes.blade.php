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
    <style>
        .cajaAzul{
            background-color: #F0FFFF;
            color : darkBlue;
            border: solid darkBlue thin;
            padding-left: 25px;
            text-align:center;
        }
        .red{
            color:red;
            font-size:20px;
            font-weight: bold;
        }
        #formulario{
            margin: 2%;
        }
    </style>
</head>
<body>
<div id="formulario">
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block">
        </div>

        <div class="col-12 col-md-4 cajaAzul ">
        ORDENES DE TRABAJO
        </div>
        <div class="col-12 col-md-4 cajaAzul">
            CONSECUTIVO <br>
            <span class="red">000001</span>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
        <div class="col-6 col-md-2 "><input type="date" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Fecha Fin</div>
        <div class="col-6 col-md-2 "><input type="date" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Responsable</div>
        <div class="col-6 col-md-10"><input type="text" class="form-control" ></div>
    </div>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Cliente</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Área de trabajo</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Contacto</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-12 cajaAzul">Tipo de sistema solicitado</div>
    </div>
    <div class="row">
        <div class="col-6 col-md-3 "><label><input type="checkbox"> CCTV</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Incendio</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Cabl. Estr.</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Otro</label></div>
    </div>
    <div class="row">
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Acceso</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Intrusión</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Integración</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Documentación</label></div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo</div>
    </div>
    <div class="row">
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Instalación</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Mnto Prev</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Trab. Int.</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Revisión</label></div>
        <div class="col-6 col-md-3 "><label><input type="checkbox"> Otro</label></div>
    </div>
    <br>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Fecha</div>
        <div class="col-6 col-md-2 "><input type="date" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-12 col-md-2 cajaAzul">Planificación</div>
        <div class="col-6 col-md-1 cajaAzul">Cant</div>
        <div class="col-6 col-md-1 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-1 cajaAzul">Und</div>
        <div class="col-6 col-md-1 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Materiales/equipos</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary">Agregar</button></div></div>
    </div>
    <div class="row">
        <div class="col-12 col-md-2 cajaAzul">Ejecución</div>
        <div class="col-6 col-md-1 cajaAzul">Cant</div>
        <div class="col-6 col-md-1 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-1 cajaAzul">Und</div>
        <div class="col-6 col-md-1 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 cajaAzul">Observación</div>
        <div class="col-6 col-md-2 "><input type="text" class="form-control"></div>
        <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary">Agregar</button></div></div>
    </div>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Observación del día</div>
        <div class="col-6 col-md-10 "><input type="text" class="form-control"></div>
    </div>
    <div class="row">
        <div class="col-6 col-md-2 cajaAzul">Trabajador</div>
        <div class="col-6 col-md-1 "><input type="text" class="form-control"></div>
        <div class="col-4 col-md-1 cajaAzul">Hi</div>
        <div class="col-4 col-md-1 "><input type="number" min="0" max="24" class="form-control"></div>
        <div class="col-4 col-md-1 "><input type="number" min="0" max="59" class="form-control"></div>
        <div class="col-4 col-md-1 cajaAzul">Hf</div>
        <div class="col-4 col-md-1 "><input type="number" min="0" max="24" class="form-control"></div>
        <div class="col-4 col-md-1 "><input type="number" min="0" max="59" class="form-control"></div>
        <div class="col-4 col-md-1 cajaAzul">Th</div>
        <div class="col-4 col-md-1 "><input type="number" min="0" max="24" class="form-control"></div>
        
    </div>
    <br>
    <div class="row">
        <div class="col-12"><button class="btn btn-primary">Almacenar día</button></div>
    </div>
    <br>
    <div class="row">
        <div class="col-12 col-md-12 cajaAzul">Observaciones y comentarios generales de la OT</div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12"><textarea rows="10" class="form-control"></textarea></div>
    </div>
</div>
</body>
</html>