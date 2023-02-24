@extends('layouts.tt')

@section('content')

<div class="row">
    <div class="col-12 col-md-10">
        <button class="btn  btn-2" id="btnNuevaJornada">Nueva jornada</button>&nbsp;<button class="btn  btn-2" id="btnMisjornadas" onclick="window.open('/misjornadas','_self');">Mis jornadas</button><br><br>
        <div id="formJornada" style="display: none">
            <form id="formRegistro">
                <input type="hidden" id="jornada_id" name="jornada_id">
                <div class="card" >
                <div class="card-header">Registro jornada de trabajo</div>
                    <div class="card-body">
                        <input type="hidden" id="tipo" name="tipo" value="1">
                        <!--<div class="row">
                            <div class="col-12 col-md-10">
                                <select id="tipo" name="tipo" id="tipo" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="1">Actividad</option>
                                    <option value="0">Almuerzo</option
                                    
                                <select>
                            </div>
                        </div><br>-->
                        <div id="datos" >
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Proyecto *</div>
                                <div class="col-6 col-md-2 ">
                                    <select class="form-control" name="proyecto" id="proyecto"  onchange="buscarP(this.value)" required>
                                        <option value=""></option>
                                        @foreach ($proyectos as $p)
                                            <option value="{{ $p->proyecto }}">{{ $p->proyecto }}</option>
                                        @endforeach
                                    </select>
                                    <!--<input type="text" name="proyecto" id="proyecto" class="form-control basicAutoComplete" data-url="autocomplete" placeholder="buscar...">-->
                                </div>
                                <div class="col-6 col-md-2 cajaAzul">Subportafolio</div>
                                <div class="col-6 col-md-2 "><input type="text" name="subportafolio" id="subportafolio" class="form-control" disabled></div>
                            <!-- <div class="col-6 col-md-2 cajaAzul">Fecha Inicio *</div>
                                <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
                                <div class="col-6 col-md-2 cajaAzul">Fecha Final *</div>
                                <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control"></div>-->
                            </div>
                            <div class="row">
                                <!--<div class="col-6 col-md-2 cajaAzul">Responsable *</div>
                                <div class="col-6 col-md-4">-->
                                    <!--<input type="text" name="responsable" id="responsable" class="form-control basicAutoComplete" data-url="autoemp" >
                                    <input type="hidden" name="cc" id="cc">-->
                                <!-- <select class="form-control basicAutoSelect" name="responsable" id="responsable"
                        placeholder="buscar..."
                        data-url="autoemp" autocomplete="off"></select>
                                </div>-->
                                
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Descripción</div>
                                <div class="col-6 col-md-4 "><input type="text" name="descripcion" id="descripcion" class="form-control" disabled></div>
                                <div class="col-6 col-md-1 cajaAzul">Director</div>
                                <div class="col-6 col-md-2 "><input type="text" name="director" id="director" class="form-control" disabled></div>
                                <div class="col-6 col-md-1 cajaAzul">Líder</div>
                                <div class="col-6 col-md-2 "><input type="text" name="lider" id="lider" class="form-control" disabled></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Cliente</div>
                                <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control" disabled></div>
                            <!--  <div class="col-6 col-md-2 cajaAzul">Área de trabajo *</div>
                                <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control"></div>-->
                                <div class="col-6 col-md-2 cajaAzul">Contacto</div>
                                <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control" disabled></div>
                            </div>
                            <br>
                        </div>
                        <div id="datos2">
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Fecha *</div>
                                <div class="col-6 col-md-2 "><input type="date" name="fecha" id="fecha" class="form-control" onchange="validarCorte(this.value)" required></div>
                                <div class="col-6 col-md-2 cajaAzul">Hora Inicio *</div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="horaInicio" name="horaInicio" required>
                                        <option value=""></option>
                                        @for ($i = 0; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="minInicio" name="minInicio" required>
                                        <option value=""></option>
                                        <option value="0">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-2 cajaAzul">Hora Fin *</div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="horaFin" name="horaFin" required>
                                        <option value=""></option>
                                        @for ($i = 0; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="minFin" name="minFin" required>
                                        <option value=""></option>
                                        <option value="0">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                            </div><br>
                            <button class="btn btn-3" id="btnRegistrar" type="button">Registrar</button> 
                        </div>
                    </div>
                
                </div>
            </form>
            <br>
            <div id="mensaje">
               
            </div>
         
            <div class="card">
                <div class="card-header">Jornada</div>
                <div class="card-body">
                    <div id="tablaJornada">       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/scripts_jornada.js')}}"></script>                      
@endsection
