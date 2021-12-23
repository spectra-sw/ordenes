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
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="dia">Día reportado</label>
                        <input type="date" class="form-control"  id="dia" name="dia">
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
                            <select class="form-control" id="actividad" name="actividad">
                                <option value=""><option>
                                @foreach ($actividades  as $a)
                                    <option value="{{ $a->id }}">{{ $a->actividad }}</option>
                                @endforeach
                            </select>
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
                    <button type="button" class="btn btn-primary" onclick="rocupacion()">REGISTRAR</button>
                </div>
            </div>
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

                        <div id="tablaocupacion">
                        </div>
                    
            </div>
        </form>       
    </div>
                    
                    
</div>



<script src="{{asset('js/scripts.js')}}"></script>                
@endsection
