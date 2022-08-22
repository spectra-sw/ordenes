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
                
                    <div class="col-12 ">
                        Horario habitual
                        <!--<input type="text" name="horario_habitual" id="horario_habitual"  class="form-control" >-->
                        <div class="row">
                            <div class="col-4 col-md-2 ">Inicio</div>
                            <div class="col-4 col-md-2 "><input type="number" name="hhi" id="hhi" min="0" max="24" class="form-control" value=""></div>
                            <div class="col-4 col-md-2 "><input type="number" name="mhi" id="mhi" min="0" max="59" class="form-control" value=""></div>
                            <div class="col-4 col-md-2 ">Fin</div>
                            <div class="col-4 col-md-2 "><input type="number" name="hhf" id="hhf" min="0" max="24" class="form-control" value=""></div>
                            <div class="col-4 col-md-2 "><input type="number" name="mhf" id="mhf" min="0" max="59" class="form-control" value=""></div>
                        </div>
                    </div>
                    </div>
                    <br>
                    <div class="col-12 col-md-12 ">
                        Hora inicio jornada especial y/o extra
                        <div class="row">
                            <div class="col-4 col-md-2 "><input type="number" name="hi" id="hi" min="0" max="24" class="form-control" value=""></div>
                            <div class="col-4 col-md-2 "><input type="number" name="mi" id="mi" min="0" max="59" class="form-control" value=""></div>
                        </div>
                       <!-- <input type="text" name="hora_entrada" id="hora_entrada"  class="form-control" value="" >-->
                    </div>
                    <br>
                    <div class="col-12 col-md-12 ">
                        Hora fin jornada especial y/o extra
                        <!--<input type="text" name="hora_autorizada_salida" id="hora_autorizada_salida"  class="form-control" value="" >-->
                        <div class="row"> 
                            <div class="col-4 col-md-2 "><input type="number" name="hf" id="hf" min="0" max="24" class="form-control" value=""></div>
                            <div class="col-4 col-md-2 "><input type="number" name="mf" id="mf" min="0" max="59" class="form-control" value=""></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">Quien autoriza?  
                        <select class="form-control" name="autoriza" id="autoriza">
                            <option value=""><option>
                            @foreach ($autoriza as $e)
                                <option value="{{ $e->cc }}">{{ $e->apellido1. " " . $e->nombre}}</option>
                            @endforeach
                        </select>
                </div>
                <br>
                <button type="button" class="btn btn-primary" onclick="guardarextra()">Guardar</button>

            </form>
<script type="text/javascript">
    $('#trabajador').autoComplete();
</script>

