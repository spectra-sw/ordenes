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
<body style="background-image:url('img/fondo.jpg');background-size: cover;")>
    <div class="row mt-4">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header text-center"><img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block"></div>
                <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" class="form-control" placeholder="Ingrese correo" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Contraseña:</label>
                        <input type="password" class="form-control" placeholder="Ingrese contraseña" id="pwd" required>
                    </div>
        
                    <button type="button" class="btn btn-2" onclick="login()">Ingresar</button>
                </form>
                
                </div>
            </div>
        <div class="alert alert-danger" id="alerta">
            <p id="mensaje">Prueba</p>
        </div>
        </div>
        <!--<p id="demo"></p>-->
    </div>
</body>
<script src="{{asset('js/scripts.js')}}"></script>
<script>

var x = document.getElementById("demo");
getLocation();
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;
}
</script>