<form id="formCargo">
    @isset($cargo['id'])
        <input type="hidden" id="cargo_id" name="cargo_id" value="{{ $cargo['id'] }}">
    @endisset

    <div class="form-group mb-2">
        <label for="cargo">Cargo</label>
        <input type="text" class="form-control" id="cargo" name="cargo"
            value="{{ isset($cargo['cargo']) ? $cargo['cargo'] : '' }}">
        <div id="cargo_e" class="invalid-feedback"></div>
    </div>
</form>
