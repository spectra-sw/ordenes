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
        <button class="btn btn-primary" id="btnNuevaJornada">Nueva jornada</button><br>
        <br>
        <div id="formJornada" style="display: none">
            <form id="formRegistro" >
                <div class="card" >
                <div class="card-header">Registro jornada de trabajo</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 col-md-2 ">
                                <select id="tipo" name="tipo" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="Almuerzo">Almuerzo</option>
                                    <option value="Actividad">Actividad</option>
                                <select>
                            </div>
                        </div><br>
                        <div id="datos" style="display: none">
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Proyecto *</div>
                                <div class="col-6 col-md-2 ">
                                    <select class="form-control" name="proyecto" id="proyecto"  onchange="buscarP(this.value)" >
                                        <option value=""></option>
                                        @foreach ($proyectos as $p)
                                            <option value="{{ $p->proyecto }}">{{ $p->proyecto }}</option>
                                        @endforeach
                                    </select>
                                    <!--<input type="text" name="proyecto" id="proyecto" class="form-control basicAutoComplete" data-url="autocomplete" placeholder="buscar...">-->
                                </div>
                                <div class="col-6 col-md-1 cajaAzul">Subportafolio</div>
                                <div class="col-6 col-md-2 "><input type="text" name="subportafolio" id="subportafolio" class="form-control" ></div>
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
                                <div class="col-6 col-md-2 cajaAzul">Cliente *</div>
                                <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control" disabled></div>
                            <!--  <div class="col-6 col-md-2 cajaAzul">Área de trabajo *</div>
                                <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control"></div>-->
                                <div class="col-6 col-md-2 cajaAzul">Contacto *</div>
                                <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control" disabled></div>
                            </div>
                            <br>
                        </div>
                        <div id="datos2" style="display: none">
                            <div class="row">
                                <div class="col-6 col-md-2 cajaAzul">Fecha </div>
                                <div class="col-6 col-md-2 "><input type="date" name="fecha" id="fecha" class="form-control" ></div>
                                <div class="col-6 col-md-2 cajaAzul">Hora Inicio </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="horaInicio" name="horaInicio">
                                        @for ($i = 0; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="minInicio" name="minInicio">
                                        <option value="0">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-2 cajaAzul">Hora Fin </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="horaFin" name="horaFin">
                                        @for ($i = 0; $i <= 23; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-6 col-md-1 ">
                                    <select class="form-control" id="minFin" name="minFin">
                                        <option value="0">00</option>
                                        <option value="15">15</option>
                                        <option value="30">30</option>
                                        <option value="45">45</option>
                                    </select>
                                </div>
                            </div><br>
                            <button class="btn btn-success">Registrar</button> 
                        </div>
                    </div>
                
                </div>
            </form>
        </div>
                       
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
     function buscarP(codigo){
        //alert(codigo);
        url = '/consproyecto'
        data = {codigo : codigo}
        $.ajax({
              url: url,
              type:'GET',
              data: data,
              success: function(data) {
                  console.log(data)
                  $("#cliente").val(data.cliente.cliente);
                  $("#contacto").val(data.cliente.contactos);
                  $("#descripcion").val(data.descripcion);
                  $("#subportafolio").val(data.subportafolio);
                  $("#director").val(data.director);
                  $("#lider").val(data.lider);
                  $("#sistema").val(data.sistema);

                  /*for (let k in data.trabajadores) {
                        //console.log(k + ' is ' + data.trabajadores[k])
                        
                        $('#cct').append($('<option>', { 
                            value: k,
                            text : data.trabajadores[k]
                        }));
                    }      */
                  //validartipo(data.sistema)
                  //$("#contacto").val(data.responsable);
            }
        }); 
    }
</script>

<script>
  function detectSelectChange() {
    var select = document.getElementById("tipo");
    select.addEventListener("change", function() {
      var opcion = document.getElementById("tipo").value;
      if (opcion == "Actividad"){
        var div = document.getElementById("datos");
        div.style.display = "block";
      }
      else{
        var div = document.getElementById("datos");
        div.style.display = "none";
      }
      var div = document.getElementById("datos2");
      div.style.display = "block";
    });
  }
  detectSelectChange();
  var btnNuevaJornada = document.getElementById("btnNuevaJornada");
  btnNuevaJorna.addEventListener("change", function() {
      var opcion = document.getElementById("tipo").value;
      if (opcion == "Actividad"){
        var div = document.getElementById("datos");
        div.style.display = "block";
</script>

<script src="{{asset('js/scripts.js')}}"></script>                
@endsection
