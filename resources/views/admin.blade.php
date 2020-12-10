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
    <div id="menu">
        <div class="card">
            <div class="card-header"><img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block"></div>
            <div class="card-body"><button type="button" class="btn btn-primary" onclick="window.open('consultas','_blank')">CONSULTAS</button></div>
            <div class="card-body"><button type="button" class="btn btn-primary" onclick="window.open('bases','_blank')">>BASES DE DATOS</button></div>
        </div>
    </div>
</body>