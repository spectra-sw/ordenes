<input type="hidden" id="id" name="id" value="{{ $p['id'] }}">
<div class="form-group mb-2">
    <label for="codigo">CODIGO</label>
    <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $p['codigo'] }}">
</div>
<div class="form-group mb-2">
    <label for="descripcion">DESCRIPCIÓN</label>
    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ $p['descripcion'] }}">
</div>
<div class="form-group mb-2">
    <label for="proyecto">CLIENTE</label>
    <select class="form-control" id="cliente" name="cliente">
        @if ($p->cliente)
            <option value="{{ $p->cliente_id }}">{{ $p->cliente->cliente }}
            <option>
        @endif
        @foreach ($clientes as $c)
            <option value="{{ $c->id }}">{{ $c->cliente }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mb-2">
    <label for="sistema">SISTEMA</label>
    <input type="text" class="form-control" id="sistema" name="sistema" value="{{ $p['sistema'] }}">
</div>
<div class="form-group mb-2">
    <label for="auxilio">SUBPORTAFOLIO</label>
    <input type="text" class="form-control" id="subportafolio" name="subportafolio"
        value="{{ $p['subportafolio'] }}">
</div>
<div class="form-group mb-2">
    <label for="director">DIRECTOR</label>
    <select class="form-control" id="director" name="director">
        @if ($p['director'] == 0)
            <option value="0" selected>
            <option>
        @endif
        @if ($p['director'] > 0)
            <option value="{{ $p->ndirector->id }}" selected>
                {{ $p->ndirector->nombre . ' ' . $p->ndirector->apellido1 }}
            <option>
        @endif
        @foreach ($emp as $e)
            <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mb-2">
    <label for="lider">LIDER</label>

    <select class="form-control" id="lider" name="lider">
        @if ($p['lider'] == 0)
            <option value="0" selected>
            <option>
        @endif
        @if ($p['lider'] > 0)
            <option value="{{ $p->nlider->id }}" selected>{{ $p->nlider->nombre . ' ' . $p->nlider->apellido1 }}
            <option>
        @endif
        @foreach ($emp as $e)
            <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
        @endforeach
    </select>
</div>
<div class="form-group mb-2">
    <label for="lider">CIUDAD</label>
    <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $p['ciudad'] }}">
</div>
<div class="form-group mb-2">
    <label for="co">CENTRO DE OPERACIÓN</label>
    <select class="form-control" id="co" name="co">
        <option value="{{ $p->cdc->centro_operacion }}">{{ $p->cdc->centro_operacion }}</option>
        <option value="001">001</option>
        <option value="002">002</option>
    </select>
    <!--<input type="text" class="form-control"  id="co" name="co">-->
</div>
<div class="form-group mb-2">
    <label for="un">UNIDAD DE NEGOCIO</label>
    <select class="form-control" id="un" name="un">
        <option value="{{ $p->cdc->unidad_negocio }}">{{ $p->cdc->unidad_negocio }}</option>
        <option value="001">001</option>
        <option value="002">002</option>
        <option value="003">003</option>
        <option value="004">004</option>
        <option value="005">005</option>
        <option value="999">999</option>
    </select>
    <!--<input type="text" class="form-control"  id="un" name="un">-->
</div>
<div class="form-group mb-2">
    <label for="un">REGISTRO DE HORAS</label>
    <select class="form-control" id="registro" name="registro">
        <option value="1" {{ $p->registro == 1 ? 'selected' : '' }}>Si</option>
        <option value="0" {{ $p->registro == 0 ? 'selected' : '' }}>No</option>
    </select>
</div>
