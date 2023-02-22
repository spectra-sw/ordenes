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
            <div class="row" style="display:none" id="divhoras">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span id="msghoras"></span>
                    </div>
                </div>
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
                                    <option value="{{ $p->codigo }}">{{ $p->codigo . " " . $p->cliente->cliente }}</option>
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
                            <button type="button" class="btn btn-primary" onclick="consultaroc()">Consultar</button>&nbsp;       
                        </div>

                        <div id="tablaocupacion">
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
                <select class="form-control basicAutoSelect" name="responsable" id="responsable"
                        placeholder="buscar..."
                        data-url="autoemp" autocomplete="off"></select>
                    </div>
                </div>
            @endif 
            <div class="row">
                <button type="button" class="btn btn-primary" onclick="seguimiento()">Seguimiento</button>&nbsp;    
                <button type="button" class="btn btn-primary" onclick="generalo()">General</button>&nbsp;    
                @if ($area==6)
                <button type="button" class="btn btn-primary" onclick="distribuciono()">Archivo Distribución</button>&nbsp;  
                @endif
                <button type="button" class="btn btn-primary" onclick="analiticas()">Archivo Analíticas</button>&nbsp;
            </div>

            <div id="tablareporteo">
            </div>
                    
            
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
            <button class="btn btn-primary">Importar horas</button><br>
                <table id="tableNovedades" class="display" style="width:100%;overflow:scroll;color:black">
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
@endsection
