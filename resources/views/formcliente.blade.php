<form id="formEditCliente">
<input type="hidden" id="id" name="id" value="{{ $datos['id']}}">
                <div class="form-group">
                    <label for="cc">CLIENTE</label>
                    <input type="text" class="form-control"  id="cliente" name="cliente" value="{{ $datos['cliente']}}">
                </div>
                <div class="form-group">
                    <label for="apellido1">CONTACTOS</label>
                    <input type="text" class="form-control"  id="contactos" name="contactos" value="{{ $datos['contactos']}}">
                </div>
                
                <button type="button" class="btn btn-primary" onclick="editarcliente()">Guardar</button>

            </form>