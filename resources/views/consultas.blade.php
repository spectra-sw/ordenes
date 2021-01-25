
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
    <div id="menu">
        <form id="formConsulta" action="exportReporte" method="get" target="_blank">
        <div class="card">
            <div class="card-header"><img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block"></div>
            <div class="card-body">
                
                <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
                    <div class="col-6 col-md-2 "><input type="text" name="proyecto" id="proyecto" class="form-control"></div>
                    <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                    <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
                    <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                    <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control"></div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Responsable</div>
                    <div class="col-6 col-md-10">                 
                <select class="form-control basicAutoSelect" name="responsable" id="responsable"
    placeholder="buscar..."
    data-url="autoemp" autocomplete="off"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Cliente</div>
                    <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control"></div>
                    <!--<div class="col-6 col-md-2 cajaAzul">Área de trabajo</div>
                    <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control"></div>
                    <div class="col-6 col-md-2 cajaAzul">Contacto</div>
                    <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control"></div>-->
                </div>
                <div class="row">
                    <button type="button" class="btn btn-primary" onclick="consultar()">Consultar</button>&nbsp;
                    <button type="button" class="btn btn-primary" onclick="archivo()">Archivo Nómina</button>
                </div>
                
            </div>
            <div id="tablao">
            </div>
            
        </div>
        </form>
    </div>
</body>
<script type="text/javascript">
    $('#responsable').autoComplete();
</script>
<script src="{{asset('js/scripts.js')}}"></script>