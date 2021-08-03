<form id="formEditProy">
                <input type="hidden" id="id" name="id" value="{{ $p['id']}}">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="codigo" name="codigo" value="{{ $p['codigo'] }}">
                </div>
                <div class="form-group">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <input type="text" class="form-control"  id="descripcion" name="descripcion" value="{{ $p['descripcion'] }}">
                </div>
                <div class="form-group">
                    <label for="proyecto">CLIENTE</label>
                    <select class="form-control" id="cliente" name="cliente">
                        <option value="{{ $p->cliente_id}}">{{ $p->cliente->cliente }}<option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sistema">SISTEMA</label>
                    <input type="text" class="form-control"  id="sistema" name="sistema" value="{{ $p['sistema'] }}">
                </div>
                <div class="form-group">
                    <label for="auxilio">SUBPORTAFOLIO</label>
                    <input type="text" class="form-control"  id="subportafolio" name="subportafolio" value="{{ $p['subportafolio'] }}">
                </div>
                <div class="form-group">
                    <label for="director">DIRECTOR</label>
                    <select class="form-control" id="director" name="director">
                        @if ($p['director'] >0)
                        <option value="{{ $p->ndirector->id }}">{{ $p->ndirector->nombre. " " . $p->ndirector->apellido1 }}<option>
                        @endif
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">LIDER</label>
                    
                    <select class="form-control" id="lider" name="lider">
                        @if ($p['lider'] >0)
                        <option value="{{ $p->nlider->id }}">{{ $p->nlider->nombre. " " . $p->nlider->apellido1 }}<option>
                        @endif
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="lider">CIUDAD</label>
                    <input type="text" class="form-control"  id="ciudad" name="ciudad" value="{{ $p['ciudad'] }}">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="editarproy()">Guardar</button>

            </form>