
            <input type="hidden" name="diaid" id="diaid" value="{{ $id }}">
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
                    <!--<select class="form-control basicAutoSelect" name="trabajador" id="trabajador" placeholder="buscar..." data-url="../autoemp" autocomplete="off"></select>
                    <input type="hidden" name="cct" id="cct">-->
                    <select class="form-control" name="cct" id="cct">
                        <option value=""></option>
                        @foreach ($ts as $t)
                            <option value="{{ $t->empleado->cc }}">{{ $t->empleado->nombre . " ". $t->empleado->apellido1}}</option>
                        @endforeach
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
                  console.log(data.descripcion)
                  $("#cliente").val(data.descripcion);
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
    
</script>