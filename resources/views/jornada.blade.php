@extends('layouts.app')

@section('content')
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#registrar">Registrar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#misregistros">Mis registros</a>
    </li>
    
   
    

</ul>
<div class="tab-content">
    <div class="tab-pane container active" id="registrar">
        <br>
        <form id="formRegistro" >
            <div class="card">
            <div class="card-header">Registro de ocupación diaria</div>
            <div class="card-body">
            
            </div>
            
            </div>
        </form>
                       
    </div>
    <div class="tab-pane container fade" id="misregistros">
        <br>
        <form id="formConsultaOcupacion" action="" method="get" target="_blank">    
            <div class="row">
                            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaInicioOcup" id="fechaInicioOcup" class="form-control"></div>
                            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaFinalOcup" id="fechaFinalOcup" class="form-control"></div>
            </div>     
                        <div class="row">
                            <button type="button" class="btn btn-primary" onclick="consultaroc()">Consultar</button>&nbsp;       
                        </div>

                        <div id="tablajornada">
                        </div>
                    
            
        </form>       
    </div>
                 
                    
</div>
<script type="text/javascript">
    $('#responsable').autoComplete();
    
</script>
<script>
    $(document).ready(function() {
        $('#tableNovedades').DataTable();
    } );
</script>

<script src="{{asset('js/scripts.js')}}"></script>                
@endsection
