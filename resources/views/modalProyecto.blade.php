<!--  Modal crear proyecto -->
<div class="modal fade bd-example-modal-xl" id="nuevoproyecto">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Nuevo proyecto
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="proyBody">
            <form id="formProy">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion">
                </div>
                <div class="form-group">
                    <label for="proyecto">CLIENTE</label>
                    <select class="form-control" id="cliente" name="cliente">
                    <option value=""><option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sistema">SISTEMA</label>
                    <input type="text" class="form-control"  id="sistema" name="sistema">
                </div>
                <div class="form-group">
                    <label for="auxilio">SUBPORTAFOLIO</label>
                    <!--<input type="text" class="form-control"  id="subportafolio" name="subportafolio">-->
                    <select class="form-control"  id="subportafolio" name="subportafolio">
                        <option value="Grandes cuentas">Grandes cuentas</option>
                        <option value="Estratégicos">Estratégicos</option>
                        <option value="Corporativos">Corporativos</option>
                        <option value="NA">No aplica</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="director">DIRECTOR</label>
                    <select class="form-control" id="director" name="director">
                        <option value="0"></option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                        @endforeach
                       
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">LIDER</label>
                    <select class="form-control" id="lider" name="lider">
                        <option value="0"></option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad">
                </div>
                <div class="form-group">
                    <label for="co">CENTRO DE OPERACIÓN</label>
                    <select class="form-control" id="co" name="co">
                            <option value=" "></option>
                            <option value="001">001</option>
                            <option value="002">002</option>
                    </select>
                   <!-- <input type="text" class="form-control"  id="co" name="co">-->
                </div>
                <div class="form-group">
                    <label for="un">UNIDAD DE NEGOCIO</label>
                    <select class="form-control" id="un" name="un">
                            <option value=" "></option>
                            <option value="001">001</option>∫
                            <option value="002">002</option>
                            <option value="003">003</option>
                            <option value="004">004</option>
                            <option value="005">005</option>
                            <option value="999">999</option>
                    </select>
                    <!--<input type="text" class="form-control"  id="un" name="un">-->
                </div>
                <div class="form-group">
                    <label for="un">REGISTRO DE HORAS</label>
                    <select class="form-control" id="registro" name="registro">
                        <option value="1" >Si</option>
                        <option value="0" >No</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="guardarproy()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="editarproy">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar proyecto
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarBodyProy">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminarproy">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Desea eliminar este proyecto?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminarproy()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>

<!--autorizados proyecto-->
  <div class="modal fade bd-example-modal-xl" id="autorizadosproy">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Autorizados proyecto
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="autorizadosBodyProy">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  
