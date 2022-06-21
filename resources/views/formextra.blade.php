<form id="formExtra">
                <input type="hidden" value="{{ $e->cc}}" name="trabajador">
                <table class="table table-responsive table-bordered">
                    <tr>
                        <th>PROYECTO</th>
                        <td><input type="text" name="proyecto" value="{{ $p->codigo }}" ></td>
                    </tr>
                    <tr>
                        <th>CLIENTE</th>
                        <td>{{ $p->cliente->cliente}}</td>
                    </tr>
                    <tr>
                        <th>EMPLEADO</th>
                        <td>{{ $e->nombre . " ". $e->apellido1 ." ".$e->apellido2}}</td>
                    </tr>
                </table>
                <div class="form-group">
                    <label for="motivo">MOTIVO</label>
                    <textarea class="form-control" rows="5" cols="50" id="motivo" name="motivo"></textarea>
                </div>
                <div class="form-group">
                    <label for="apellido1">FECHA</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha" value="{{ $fecha }}" >
                </div>
               
                <div class="form-group">
                    <div class="row">
                
                    <div class="col-12 col-md-4 ">Horario habitual<input type="text" name="horario_habitual" id="horario_habitual"  class="form-control" ></div>
                    <div class="col-12 col-md-4 ">Horario entrada<input type="text" name="hora_entrada" id="hora_entrada"  class="form-control" value="{{ $hi}}" ></div>
                    <div class="col-12 col-md-4 ">Horario autorizada salida<input type="text" name="hora_autorizada_salida" id="hora_autorizada_salida"  class="form-control" value="{{ $hf}}" ></div>
                  </div>
                <div class="form-group">
                    <div class="row">
                    <div class="col-12">Quien autoriza?  <select class="form-control basicAutoSelect" name="autoriza" id="autoriza"
                        placeholder="buscar..."
                        data-url="../autoemp" autocomplete="off"></select>
                    </div>
                    <script type="text/javascript">
                            $('#autoriza').autoComplete();
                    </script>
    
                </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="guardarextra()">Guardar</button>

            </form>
        