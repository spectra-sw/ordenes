<form id="formEdit">
                <input type="hidden" id="id" name="id" value="{{ $datos['id']}}">
                <div class="form-group">
                    <label for="cc">CC</label>
                    <input type="text" class="form-control"  id="cc" name="cc" value="{{ $datos['cc'] }}">
                </div>
                <div class="form-group">
                    <label for="apellido1">APELLIDO 1</label>
                    <input type="text" class="form-control"  id="apellido1" name="apellido1" value="{{ $datos['apellido1'] }}">
                </div>
                <div class="form-group">
                    <label for="apellido2">APELLIDO 2</label>
                    <input type="text" class="form-control"  id="apellido2" name="apellido2" value="{{ $datos['apellido2'] }}">
                </div>
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control"  id="nombre" name="nombre" value="{{ $datos['nombre'] }}">
                </div>
                <div class="form-group">
                    <label for="auxilio">AUXILIO</label>
                    <input type="text" class="form-control"  id="auxilio" name="auxilio" value={{ $datos['auxilio'] }}>
                </div>
                <div class="form-group">
                    <label for="correo">CORREO</label>
                    <input type="text" class="form-control"  id="correo" name="correo" value={{ $datos['correo'] }}>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo" class="form-control" >
                        <option value="0" {{ $datos['tipo'] == 0 ? 'selected' : '' }}>Admin</option>
                        <option value="1" {{ $datos['tipo'] == 1 ? 'selected' : '' }}>Registro</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary" onclick="editare()">Guardar</button>

            </form>