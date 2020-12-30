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
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block"></div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#emp">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#centros">Centros</a>
                </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="emp">
                        @include('tablaemp')
                    </div>
                    <div class="tab-pane container fade" id="centros">
                        @include('tablacdc')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>