<form id="filtrarProy">
<div class="row cajaAzul">
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="codigo">CODIGO</label>
                    <input type="text" class="form-control"  id="fcodigo" name="fcodigo" ">
                </div>
  </div>
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="proyecto">CLIENTE</label>
                    <select class="form-control" id="fcliente" name="fcliente">
                        <option value=""></option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                        @endforeach
                    </select>
                </div>
  </div>
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="director">DIRECTOR</label>
                   
                    <select class="form-control" id="fdirector" name="fdirector">
                        <option value=""></option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
  </div>
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="lider">LIDER</label>
                    
                    <select class="form-control" id="flider" name="flider">
                        <option value=""></option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}" >{{ $e->nombre . " " . $e->apellido1 }}</option>
                        @endforeach
                    </select>
                </div>
  </div>
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="lider">CIUDAD</label>
                    <input type="text" class="form-control"  id="fciudad" name="fciudad" ">
                </div>
  </div>
  <div class="col-12 col-sm-2">
    <button type="button" class="btn btn-primary" onclick="filtrarproy()">Filtrar</button>
  </div>
</div>
</form>