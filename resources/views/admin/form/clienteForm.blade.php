<form id="formCliente">
    @isset($cliente['id'])
        <input type="hidden" id="id" name="id" value="{{ $cliente['id'] }}">
    @endisset
    <div class="form-group mb-2">
        <label for="cc">CLIENTE</label>
        <input type="text" class="form-control" id="cliente" name="cliente"
            value="{{ isset($cliente['cliente']) ? $cliente['cliente'] : '' }}">
        <div id="cliente_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="apellido1">CONTACTOS</label>
        <input type="text" class="form-control" id="contactos" name="contactos"
            value="{{ isset($cliente['contactos']) ? $cliente['contactos'] : '' }}">
        <div id="contactos_e" class="invalid-feedback"></div>
    </div>
</form>
