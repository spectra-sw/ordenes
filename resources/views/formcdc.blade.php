<form id="formCdce">
    <input type="hidden" id="id" name="id" value="{{ $datos['id']}}">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo" value="{{ $datos['codigo']}}">
                </div>
                <div class="form-group">
                    <label for="descripcion">DESCRIPCION</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion" value="{{ $datos['descripcion']}}">
                </div>
                <div class="form-group">
                    <label for="apellido2">CENTRO DE OPERACIÓN</label>
                    <input type="text" class="form-control"  id="co" name="co" value="{{ $datos['centro_operacion']}}">
                </div>
                <div class="form-group">
                    <label for="nombre">UNIDAD DE NEGOCIO</label>
                    <input type="text" class="form-control"  id="un" name="un" value="{{ $datos['unidad_negocio']}}">
                </div>
                <div class="form-group">
                    <label for="auxilio">RESPONSABLE</label>
                    <input type="text" class="form-control"  id="responsable" name="responsable" value="{{ $datos['responsable']}}">
                </div>
                <div class="form-group">
                    <label for="correo">MAYOR</label>
                    <input type="text" class="form-control"  id="mayor" name="mayor" value="{{ $datos['mayor']}}">
                </div>
                <div class="form-group">
                    <label for="correo">GRUPO</label>
                    <input type="text" class="form-control"  id="grupo" name="grupo" value="{{ $datos['grupo']}}">
                </div>
                <div class="form-group">
                    <label for="correo">OBSERVACIONES</label>
                    <input type="text" class="form-control"  id="observaciones" name="observaciones" value="{{ $datos['observaciones']}}">
                </div>
                <button type="button" class="btn btn-primary" onclick="editarcdc()">Guardar</button>

            </form>
