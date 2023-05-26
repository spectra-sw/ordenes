@extends('layouts.tt')

@section('content')
<br>
<div class="container mt-0"> 

<ul class="nav nav-tabs" role="tablist" id="tabOcupacion">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#registrar">Registrar</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#misregistros">Mis registros</a>
    </li>
    
    @if (session('tipo')==0)
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#reporteso">Reportes</a>
    </li>
    @endif
    @if (session('area')==6)
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#horasNovedad">Horas</a>
    </li>
    @endif
    

</ul>
<div class="tab-content">
    <div id="registrar" class="container tab-pane active">
        <br>
    <form id="formRegistro" >
        <div class="card">
        <div class="card-header">Registro de ocupación diaria</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dia">Día reportado</label>
                        <input type="date" class="form-control"  id="dia" name="dia" onchange="buscarInfoOc()">
                    </div>
                </div>
            </div>
            <div id="mensaje">
               
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area">Área</label>
                        <select class="form-control" id="area" name="area">
                                <option value=""><option>
                                @foreach ($areas  as $a)
                                    <option value="{{ $a->id }}" {{ $area == $a->id  ? 'selected' : ''}} >{{ $a->area }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="proyecto">Proyecto</label>
                            <select class="form-control" id="proyecto" name="proyecto">
                                <option value=""><option>
                                @foreach ($proyectos as $p)
                                    <option value="{{ $p->codigo }}">{{$p->cliente ? $p->codigo . " " . $p->cliente->cliente : $p->codigo }}</option>
                                @endforeach
                            </select>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="actividad">Actividad</label>
                            <!--<select class="form-control" id="actividad" name="actividad">
                                <option value=""><option>
                                @foreach ($actividades  as $a)
                                    <option value="{{ $a->id }}">{{ $a->actividad }}</option>
                                @endforeach
                            </select>-->
                            <input type="text" list="actividades" class="form-control" name="actividad" id="actividad">
                            <datalist id="actividades">
                                @foreach ($actividades  as $a)
                                    <option value="{{ $a->actividad }}">
                                @endforeach
                            </datalist>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    Horas <select class="form-control" id="horas" name="horas">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                    </select>
                </div>
                <div class="col-md-2">
                    Minutos<select class="form-control" id="min" name="min">
                            <option value="0">0</option>
                            <option value="30">30</option> Minutos
                        </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <button type="button" class="btn btn-3" onclick="rocupacion()">REGISTRAR</button>
                </div>
            </div>
        </div>
        
        </div>
        </form>
                       
    </div>
    <div class="container tab-pane fade" id="misregistros">
        <br>
        <form id="formConsultaOcupacion" action="" method="get" target="_blank">    
            <div class="row">
                            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaInicioOcup" id="fechaInicioOcup" class="form-control"></div>
                            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaFinalOcup" id="fechaFinalOcup" class="form-control"></div>
            </div>     
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <button type="button" class="btn btn-3" onclick="consultaroc()">Consultar</button>&nbsp;       
                            </div>
                        </div>

                        <div id="tablaocupacion" style="background-color:white">
                        </div>
                    
            
        </form>       
    </div>
    <div class="tab-pane container fade" id="reporteso">
        <br>
        <form id="formReportesOcupacion" action="exportReporteO" method="get" target="_blank">  
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Área</div>
                <div class="col-6 col-md-2 ">
                    <select class="form-control" id="area" name="area">
                        <option value="">Todas</option>
                        @foreach ($areas as $a)
                        <option value="{{ $a->id }}">{{ $a->area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>  
            
            <div class="row">
                            <div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaInicioOcup1" id="fechaInicioOcup1" class="form-control"></div>
                            <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                            <div class="col-6 col-md-2 "><input type="date" name="fechaFinalOcup1" id="fechaFinalOcup1" class="form-control"></div>
            </div>    
            @if (session('tipo')==0)
                <div class="row">
                    <div class="col-6 col-md-2 cajaAzul">Responsable</div>
                    <div class="col-6 col-md-10">                 
                <!--<select class="form-control basicAutoSelect" name="responsable" id="responsable"
                        placeholder="buscar..."
                        data-url="autoemp" autocomplete="off"></select>-->
                        <select class="form-control" id="responsable" name="responsable">
                            <option value=""></option>
                            @foreach ($emp as $e)
                                <option value="{{ $e->cc }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif 
            <div class="row">
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-3" onclick="seguimiento()">Seguimiento</button>&nbsp;    
                </div>
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-3" onclick="generalo()">General</button>&nbsp;    
                </div>
                @if ($area==6)
                <div class="col-6 col-md-2">
                 <button type="button" class="btn btn-3" onclick="distribuciono()">Archivo Distribución</button>&nbsp;  
                </div>
                @endif
                <div class="col-6 col-md-2">
                    <button type="button" class="btn btn-3" onclick="analiticas()">Archivo Analíticas</button>&nbsp;
                </div>
            </div>

            <div id="tablareporteo" style="background-color:white">
            </div>
            <iframe title="Reporte Ocupacion" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=eada343c-1efb-4f6c-a2e2-7ac1309811c0&autoAuth=true&ctid=e752c1c1-100f-43ab-99fd-b6dd93dceb62"
 frameborder="0" allowFullScreen="true"></iframe>
            
        </form>    
    </div>
    <div class="tab-pane container fade" id="horasNovedad">
        <br>
        <form action="{{ route('importHoras') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <div class="custom-file text-left">
                    <input type="file" name="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <button class="btn btn-3">Importar horas</button><br>
                <table id="tableNovedades" class="table table-striped" style="width:100%;overflow:scroll;color:black">
                    <thead>
                        <tr>
                            <th>CC</th>
                            <th>NOMBRE</th>
                            <th>HORAS</th>
                            <th>PERIODO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($novedades  as $n)
                        <tr>
                            <td>{{ $n->cc}}</td>
                            <td>{{ isset($n->empleado) ?  $n->empleado->apellido1 . " ". $n->empleado->apellido2 . " ". $n->empleado->nombre : '' }}</td>
                            <td>{{ $n->horas}}</td>
                            <td>{{ $n->periodo }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                   
                </table>
        </form>
    </div>                
                    
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
<script src="{{asset('js/scripts_jornada.js')}}"></script>               
@endsection
