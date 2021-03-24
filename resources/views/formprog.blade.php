<form id="formProgEdit">
<input type="hidden" id="id" name="id" value="{{ $datos['id']}}">
                <div class="form-group">
                    <label for="cc">TÉCNICO</label>
                    <select class="form-control" id="cc" name="cc">
                        <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->cc }}" {{ $datos['cc'] == $e->cc ? 'selected' : ''}}>{{ $e->nombre . " " . $e->apellido1}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="apellido1">FECHA</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha" value ="{{ $datos['fecha'] }}">
                </div>
                <div class="form-group">
                    <label for="proyecto">PROYECTO</label>
                    <select class="form-control" id="proyecto" name="proyecto">
                    <option value=""><option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->codigo }}" {{ $datos['proyecto'] == $p->codigo ? 'selected' : ''}}>{{ $p->codigo . " " . $p->cliente->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="responsable">RESPONSABLE</label>
                    <select class="form-control" id="responsable" name="responsable">
                    <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" {{ $datos['responsable'] == $e->id ? 'selected' : ''}}>{{ $e->nombre . " " . $e->apellido1}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observaciones">OBSERVACIONES</label>
                    <input type="text" class="form-control"  id="observaciones" name="observaciones" value="{{ $datos['observacion'] }}">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="editarprog()">Guardar</button>

            </form>


