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
                    <div class="col-6 col-md-2 cajaAzul">Técnico</div>
                    <div class="col-6 col-md-10">                 
                <select class="form-control basicAutoSelect" name="tecnico" id="tecnico"
    placeholder="buscar..."
    data-url="autoemp" autocomplete="off"></select>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="btn btn-primary" onclick="consultar()">Consultar</button>&nbsp;
                    @if (session('tipo')==0)
                    <!--<button type="button" class="btn btn-primary" onclick="archivor()">Archivo Redistribución</button>&nbsp;-->
                    <button type="button" class="btn btn-primary" onclick="reportep()">Reporte personas</button>&nbsp;
                    <button type="button" class="btn btn-primary" onclick="archivo()">Archivo Distribución</button>&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" onclick="archivoc()">Archivo Consolidado</button>&nbsp;&nbsp;
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="auxilio" value="si" checked>Con auxilio
                        </label>
                    </div>&nbsp;
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="auxilio" value="no">Sin auxilio
                        </label>
                    </div>
                    @endif
                    
                </div>

                <div id="tablao">
                </div>
            
    </div>
</form>
<script type="text/javascript">
    $('#responsable').autoComplete();
    $('#tecnico').autoComplete();
</script>
<script src="{{asset('js/scripts.js')}}"></script>
@endsection




