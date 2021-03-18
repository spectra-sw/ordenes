@extends('layouts.app')

@section('content')
<form id="formConsulta" action="exportReporte" method="get" target="_blank">    
    <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
                    <div class="col-6 col-md-2 "><input type="text" name="proyecto" id="proyecto" class="form-control"></div>
                    <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                    <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
                    <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                    <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control"></div>
    </div>
                @if (session('tipo')==0)
                <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Responsable</div>
                    <div class="col-6 col-md-10">                 
                <select class="form-control basicAutoSelect" name="responsable" id="responsable"
    placeholder="buscar..."
    data-url="autoemp" autocomplete="off"></select>
                    </div>
                </div>
                @endif
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
                    @if (session('tipo')==0)
                    <button type="button" class="btn btn-primary" onclick="archivo()">Archivo Nómina</button>
                    @endif
                </div>

                <div id="tablao">
                </div>
            
    </div>
</form>
<script type="text/javascript">
    $('#responsable').autoComplete();
</script>
<script src="{{asset('js/scripts.js')}}"></script>
@endsection




