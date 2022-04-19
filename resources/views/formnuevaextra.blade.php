<form id="formExtra">
                
                <table class="table table-responsive table-bordered">
                    <tr>
                        <th>PROYECTO</th>
                        <td><select class="form-control" id="proyecto" name="proyecto">
                    <option value=""><option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->codigo }}">{{ $p->codigo . " " . $p->cliente->cliente }}</option>
                        @endforeach
                    </select></td>
                    </tr>
                    
                    <tr>
                        <th>EMPLEADO</th>
                        <td> <select class="form-control basicAutoSelect" name="trabajador" id="trabajador"
                            placeholder="buscar..."
                            data-url="autoemp" autocomplete="off"></td>
                    </tr>
                </table>
                <div class="form-group">
                    <label for="motivo">MOTIVO</label>
                    <textarea class="form-control" rows="5" cols="50" id="motivo" name="motivo"></textarea>
                </div>
                <div class="form-group">
                    <label for="apellido1">FECHA</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha" value="" >
                </div>
               
                <div class="form-group">
                    <div class="row">
                
                    <div class="col-12 col-md-4 ">Horario habitual<input type="text" name="horario_habitual" id="horario_habitual"  class="form-control" ></div>
                    <div class="col-12 col-md-4 ">Horario entrada<input type="text" name="hora_entrada" id="hora_entrada"  class="form-control" value="" ></div>
                    <div class="col-12 col-md-4 ">Horario autorizada salida<input type="text" name="hora_autorizada_salida" id="hora_autorizada_salida"  class="form-control" value="" ></div>
                  </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="guardarextra()">Guardar</button>

            </form>
<script type="text/javascript">
    $('#trabajador').autoComplete();
</script>
