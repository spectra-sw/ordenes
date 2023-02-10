@extends('layouts.tt')

@section('content')

<form id="formConsultaJornada">
<div class="row">
    <div class="col-12 col-md-10">
        <div class="card" >
            <div class="card-header">Rango de fechas</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <input type="date" class="form-control" id="inicio" name="inicio">
                    </div>
                    <div class="col-12 col-md-3">
                        <input type="date" class="form-control" id="inicio" name="fin">
                    </div>
                    <div class="col-12 col-md-3">
                        <button class="btn btn-3" id="btnConsultar" type="button">Consultar</button> 
                    </div>
                   
                </div>
                
            </div>
        <div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-10">
        <div id="consulta">

        </div>
    </div>
</div>
</form>
<script src="{{asset('js/scripts_jornada.js')}}"></script>                      
@endsection
