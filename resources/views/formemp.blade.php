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
                    <label for="auxilio">AUXILIO TRANSPORTE</label>
                    <select class="form-control" id="auxiliot" name="auxiliot">
                        <option value="0" {{ $datos['auxiliot'] == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $datos['auxiliot'] == 1 ? 'selected' : '' }}>Si</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="correo">CORREO</label>
                    <input type="text" class="form-control"  id="correo" name="correo" value={{ $datos['correo'] }}>
                </div>
                <div class="form-group">
                    <label for="correo">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad" value={{ $datos['ciudad']}} >
                </div>
                <div class="form-group">
                    <label for="correo">HORARIO</label>
                    <select class="form-control" id="horario" name="horario">
                        <option value="{{ $idh }}">{{ $horario }}</option>
                        @foreach ($horarios as $h)
                        <option value="{{ $h->id }}">{{ $h->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="area">ÁREA</label>
                    <select class="form-control" id="area" name="area">
                        <option value="{{ $datos['area'] }}">{{ $area}}</option>
                        @foreach ($areas as $a)
                        <option value="{{ $a->id }}">{{ $a->area }}</option>
                        @endforeach
                    </select>
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