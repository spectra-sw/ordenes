<form id="formEditProy">
                <input type="hidden" id="id" name="id" value="{{ $p['id']}}">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo" value="{{ $datos['codigo'] }}">
                </div>
                <div class="form-group">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion" value="{{ $datos['descripcion'] }}">
                </div>
                <div class="form-group">
                    <label for="proyecto">CLIENTE</label>
                    <select class="form-control" id="proyecto" name="proyecto">
                        <option value="{{ $p->cliente}}">{{ $p->cliente->cliente }}<option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sistema">SISTEMA</label>
                    <input type="text" class="form-control"  id="sistema" name="sistema" value="{{ $datos['sistema'] }}">
                </div>
                <div class="form-group">
                    <label for="auxilio">SUBPORTAFOLIO</label>
                    <input type="text" class="form-control"  id="subportafolio" name="subportafolio" value="{{ $datos['subportafolio'] }}">
                </div>
                <div class="form-group">
                    <label for="director">DIRECTOR</label>
                    <select class="form-control" id="director" name="director">
                        <option value="{{ $p->ndirector->cc }}">{{ $p->ndirector->nombre. " " . $p->ndirector->apellido1 }}<option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">LIDER</label>
                    <input type="text" class="form-control"  id="lider" name="lider" value="{{ $p->nlider->apellido1. " " . $p->nlider->nombre }}">
                    <select class="form-control" id="lider" name="lider">
                        <option value="{{ $p->nlider->cc }}">{{ $p->nlider->nombre. " " . $p->nlider->apellido1 }}<option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad" value="{{ $datos['ciudad'] }}">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="editarproy()">Guardar</button>

            </form>