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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
    
   
    <style>
        
      
    </style>
</head>
<body>
<div id="formulario">
    <form id="f1">
    <div class="row">
        <div class="col-12 col-md-4">
            <img src="{{ URL::asset('img/logo.png') }}" class="img-responsive center-block">
        </div>

        <div class="col-12 col-md-4 cajaAzul ">
        ORDENES DE TRABAJO <br>
        <button class="btn btn-primary" type="button" onclick="nueva()">Nueva orden</button>
        </div>
        <div class="col-12 col-md-4 cajaAzul">
            CONSECUTIVO <br>
            <input type="hidden" name="id" id="id" value="">
            <span class="red" id="consec"></span>
        </div>
    </div>
    <br>
    <div id="datos">
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Proyecto *</div>
            <div class="col-6 col-md-2 ">
                <select class="form-control" name="proyecto" id="proyecto"  onchange="buscarP(this.value)" >
                    <option value=""></option>
                    @foreach ($proyectos as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
                <!--<input type="text" name="proyecto" id="proyecto" class="form-control basicAutoComplete" data-url="autocomplete" placeholder="buscar...">-->
            </div>
           <!-- <div class="col-6 col-md-2 cajaAzul">Fecha Inicio *</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="fechaInicio" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Fecha Final *</div>
            <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="fechaFinal" class="form-control"></div>-->
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Responsable *</div>
            <div class="col-6 col-md-4">
                <!--<input type="text" name="responsable" id="responsable" class="form-control basicAutoComplete" data-url="autoemp" >
                <input type="hidden" name="cc" id="cc">-->
                <select class="form-control basicAutoSelect" name="responsable" id="responsable"
    placeholder="buscar..."
    data-url="autoemp" autocomplete="off"></select>
            </div>
            <div class="col-6 col-md-1 cajaAzul">Subportafolio</div>
            <div class="col-6 col-md-2 "><input type="text" name="subportafolio" id="subportafolio" class="form-control" ></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Descripción</div>
            <div class="col-6 col-md-4 "><input type="text" name="descripcion" id="descripcion" class="form-control" disabled></div>
            <div class="col-6 col-md-1 cajaAzul">Director</div>
            <div class="col-6 col-md-2 "><input type="text" name="director" id="director" class="form-control" disabled></div>
            <div class="col-6 col-md-1 cajaAzul">Líder</div>
            <div class="col-6 col-md-2 "><input type="text" name="lider" id="lider" class="form-control"></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-2 cajaAzul">Cliente *</div>
            <div class="col-6 col-md-2 "><input type="text" name="cliente" id="cliente" class="form-control" ></div>
            <div class="col-6 col-md-2 cajaAzul">Área de trabajo *</div>
            <div class="col-6 col-md-2 "><input type="text" name="area" id="area" class="form-control"></div>
            <div class="col-6 col-md-2 cajaAzul">Contacto *</div>
            <div class="col-6 col-md-2 "><input type="text" name="contacto" id="contacto" class="form-control" ></div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-12 cajaAzul">Tipo de sistema solicitado *</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-12 "><input type="text" class="form-control" name="sistema" id="sistema" ></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo *</div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-12 ">
                        <select class="form-control" id="objeto" name="objeto">
                            <option value="Instalación">Instalación</option>
                            <option value="Mantenimiento Preventivo">Mantenimiento Preventivo</option>
                            <option value="Trabajo Interno">Trabajo Interno</option>
                            <option value="Revisión">Revisión</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="cctv" id="cctv" value="cctv"> CCTV</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="incendio" id="incendio" value="incendio"> Incendio</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="cablestr" id="cablestr" value="cablestr">Cableado Estructurado</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="otro" id="otro" value="otro"> Otro</label></div>
        </div>
        <div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="acceso" id="acceso" value="acceso"> Acceso</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="intrusion" id="intrusion" value="intrusion"> Intrusión</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="integracion" id="integracion" value="integracion"> Integración</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="documentacion" id="documentacion" value="documentacion"> Documentación</label></div>
        </div>-->
        <br>
        <!--<div class="row">
            <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo *</div>
        </div>
        <br>
        <div class="row">
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="instalacion" id="instalacion" value="instalacion"> Instalación</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="MntoPrev" id="MntoPrev" value="MntoPrev"> Mantenimiento Preventivo</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="TrabInt" id="TrabInt" value="TrabInt"> Trab. Int.</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="revision" id="revision" value="revision"> Revisión</label></div>
            <div class="col-6 col-md-3 "><label><input type="checkbox" name="otro" id="otro" value="otro"> Otro</label></div>
        </div>
        <br>-->
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Días registrados</div>
        </div>
        <div class="row">
            <div class="col-12">
                 <div id="tablad"></div>
            </div>
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-sm" onclick="nuevodia()">Nuevo día</button>
        <br>
        <div id="dias">
            <input type="hidden" name="diaid" id="diaid" value="">
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Fecha</div>
                <div class="col-6 col-md-2 "><input type="date" name="fecha" id="fecha" value="fecha" class="form-control"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 col-md-2 cajaAzul">Planificación</div>
                <div class="col-6 col-md-1 cajaAzul">Cant</div>
                <div class="col-6 col-md-1 "><input type="text" name="cantp" id="cantp" class="form-control"></div>
                <div class="col-6 col-md-1 cajaAzul">Und</div>
                <div class="col-6 col-md-1 ">
                
                    <select class="form-control" name="undp" id="undp">
                        <option value=""></option>
                        <option value="CAJA">CAJA</option>
                        <option value="DIAS">DIAS</option>
                        <option value="GL">GL</option>
                        <option value="KG">KG</option>
                        <option value="ML">ML</option>
                        <option value="PERS">PERS</option>
                        <option value="PKT">PKT</option>
                        <option value="UND">UND</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 cajaAzul">Materiales/equipos</div>
                <div class="col-6 col-md-2 "><input type="text" name="materiales" id="materiales" class="form-control"></div>
                <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregarp()">Agregar</button></div></div>
                <div class="alert alert-danger" id="alertap">
                    <p id="mensajep"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablap">

                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12 col-md-2 cajaAzul">Ejecución</div>
                <div class="col-6 col-md-1 cajaAzul">Cant</div>
                <div class="col-6 col-md-1 "><input type="text" name="cante" id="cante" class="form-control"></div>
                <div class="col-6 col-md-1 cajaAzul">Und</div>
                <div class="col-6 col-md-1 ">
                    <select class="form-control" name="unde" id="unde">
                        <option value=""></option>
                        <option value="CAJA">CAJA</option>
                        <option value="DIAS">DIAS</option>
                        <option value="GL">GL</option>
                        <option value="KG">KG</option>
                        <option value="ML">ML</option>
                        <option value="PERS">PERS</option>
                        <option value="PKT">PKT</option>
                        <option value="UND">UND</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 cajaAzul">Observación</div>
                <div class="col-6 col-md-2 "><input type="text" name="observacione" id="observacione" class="form-control"></div>
                <div class="col-6 col-md-2 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregare()">Agregar</button></div></div>
                <div class="alert alert-danger" id="alertae">
                    <p id="mensajee"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablae">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Observación del día</div>
                <div class="col-6 col-md-10 "><input type="text" name="observaciond" id="observaciond" class="form-control"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Trabajador</div>
                <div class="col-6 col-md-10 ">
                    <!--
                    <select class="form-control basicAutoSelect" name="trabajador" id="trabajador" placeholder="buscar..." data-url="autoemp" autocomplete="off"></select>
                    <input type="hidden" name="cct" id="cct">-->
                    <select class="form-control" name="cct" id="cct">
                        <option value=""></option>
                        
                    </select>
                </div>
                <div class="col-4 col-md-1 cajaAzul">Hi</div>
                <div class="col-4 col-md-1 "><input type="number" name="hi" id="hi" min="0" max="24" class="form-control"></div>
                <div class="col-4 col-md-1 "><input type="number" name="mi" id="mi" min="0" max="59" class="form-control"></div>
                <div class="col-4 col-md-1 cajaAzul">Hf</div>
                <div class="col-4 col-md-1 "><input type="number" name="hf" id="hf" min="0" max="24" class="form-control"></div>
                <div class="col-4 col-md-1 "><input type="number" name="mf" id="mf" min="0" max="59" class="form-control"></div>
                <!--<div class="col-4 col-md-1 cajaAzul">Ht</div>
                <div class="col-4 col-md-1 "><input type="number" onclick="calchoras()" name="th" id="th" min="0" max="24" class="form-control"  readonly></div>-->
                <div class="col-6 col-md-1 "> <div class="col-12 col-md-2 "><button class="btn btn-primary btn-sm" type="button" onclick="agregarh()">Agregar</button></div></div>
                <br>
                <div class="alert alert-danger" id="alertah">
                    <p id="mensajeh"></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="tablah">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12"><button class="btn btn-primary btn-block" type="button" onclick="almdia()">Almacenar día</button></div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 col-md-12 cajaAzul">Observaciones y comentarios generales de la OT</div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12"><textarea rows="10" name="observacionesg" id="observacionesg" class="form-control"></textarea></div>
        </div>
        <div class="row">
            <div class="col-12"><button class="btn btn-primary btn-block" type="button" onclick="modalconfirm()">Guardar orden</button></div>
        </div>
    </div>
    </form>
</div>
<!-- The Modal -->
<div class="modal fade bd-example-modal-xl" id="info">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-body" id="infoBody">
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="confirm">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
        <h5 class="modal-title">Confirme los datos de la orden de trabajo antes de ser enviada</h5>
        
        </div>
        <div class="modal-body" id="infoBody">
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Proyecto</div>
                <div class="col-6 col-md-2 "><input type="text" name="proyecto" id="cproyecto" class="form-control basicAutoComplete" value="" disabled></div>
                <!--<div class="col-6 col-md-2 cajaAzul">Fecha Inicio</div>
                <div class="col-6 col-md-2 "><input type="date" name="fechaInicio" id="cfechaInicio" class="form-control"  disabled></div>
                <div class="col-6 col-md-2 cajaAzul">Fecha Final</div>
                <div class="col-6 col-md-2 "><input type="date" name="fechaFinal" id="cfechaFinal" class="form-control" disabled></div>-->
            </div>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Responsable</div>
                <div class="col-6 col-md-10">
                    <!--<input type="text" name="responsable" id="responsable" class="form-control basicAutoComplete" data-url="autoemp" >
                    <input type="hidden" name="cc" id="cc">-->
                    <input type="text" name="responsable" id="cresponsable"  disabled >
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-2 cajaAzul">Cliente</div>
                <div class="col-6 col-md-2 "><input type="text" name="cliente" id="ccliente" class="form-control"  disabled></div>
                <div class="col-6 col-md-2 cajaAzul">Área de trabajo</div>
                <div class="col-6 col-md-2 "><input type="text" name="area" id="carea" class="form-control"  disabled></div>
                <div class="col-6 col-md-2 cajaAzul">Contacto</div>
                <div class="col-6 col-md-2 "><input type="text" name="contacto" id="ccontacto" class="form-control"  disabled></div>
            </div>
            <br>
            <!--<div class="row">
                <div class="col-12 col-md-12 cajaAzul">Tipo de sistema solicitado</div>
            </div>
            <div class="row">
                <div class="col-6 col-md-12 "><input type="text" class="form-control" name="tipo" id="tipo" ></div>
            </div>
            
            <br>
            <div class="row">
                <div class="col-12 col-md-12 cajaAzul">Objeto de la orden de trabajo</div>
            </div>
            <div class="row">
                <div class="col-6 col-md-12 "><input type="text" class="form-control" name="tipo" id="tipo" ></div>
            </div>-->

        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="enviarorden(1)">Enviar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>      
      </div>
    </div>
</div>
<script type="text/javascript">
    $('.basicAutoComplete').autoComplete();
    $('#proyecto').on('autocomplete.select', function (evt, item) {
        //alert(JSON.stringify(item))
        codigo = JSON.stringify(item);
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
                  validartipo(data.sistema)
                  //$("#contacto").val(data.responsable);
        }
    });   
    });
    $('#responsable').autoComplete();
    $('#responsable').on('autocomplete.select', function (evt, item) {   
        $("#cc").val(item.value);
    });
    $('#trabajador').autoComplete();
    $('#trabajador').on('autocomplete.select', function (evt, item) {   
        $("#cct").val(item.value);
    });
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
    function validartipo(sistema){
        var sistema = sistema.toLowerCase();
        n = sistema.search("incendio");
        if (n>=0) { $("#incendio").prop('checked', true);}
        n = sistema.search("cctv");
        if (n>=0) { $("#cctv").prop('checked', true);}
        n = sistema.search("acceso");
        if (n>=0) { $("#acceso").prop('checked', true);}
        n = sistema.search("instrusión");
        if (n>=0) { $("#intrusion").prop('checked', true);}
        n = sistema.search("cableado estructurado");
        if (n>=0) { $("#cablestr").prop('checked', true);}
        n = sistema.search("instrusión");
        if (n>=0) { $("#intrusion").prop('checked', true);}
        n = sistema.search("integración");
        if (n>=0) { $("#integrcion").prop('checked', true);}
        n = sistema.search("otro");
        if (n>=0) { $("#otro").prop('checked', true);}
        n = sistema.search("documentacion");
        if (n>=0) { $("#intrusion").prop('checked', true);}
    }
</script>
</body>
</html>
<script src="{{asset('js/scripts.js')}}"></script>