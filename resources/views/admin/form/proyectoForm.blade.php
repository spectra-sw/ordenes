<form id="formPoyecto">
    <input type="hidden" id="id" name="id" value="{{ $proyecto['id'] }}">

    <div class="form-group mb-2">
        <label for="codigo">CODIGO</label>
        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ $proyecto['codigo'] }}">
        <div id="codigo_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="descripcion">DESCRIPCIÓN</label>
        <input type="text" class="form-control" id="descripcion" name="descripcion"
            value="{{ $proyecto['descripcion'] }}">
        <div id="descripcion_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="proyecto">CLIENTE</label>
        <select class="form-control" id="cliente" name="cliente">
            @if ($proyecto->cliente)
                <option value="{{ $proyecto->cliente_id }}">{{ $proyecto->cliente->cliente }}
                <option>
            @endif
            @foreach ($clientes as $c)
                <option value="{{ $c->id }}">{{ $c->cliente }}</option>
            @endforeach
        </select>
        <div id="cliente_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="sistema">SISTEMA</label>
        <input type="text" class="form-control" id="sistema" name="sistema" value="{{ $proyecto['sistema'] }}">
        <div id="sistema_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="auxilio">SUBPORTAFOLIO</label>
        <input type="text" class="form-control" id="subportafolio" name="subportafolio"
            value="{{ $proyecto['subportafolio'] }}">
        <div id="subportafolio_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="director">DIRECTOR</label>
        <select class="form-control" id="director" name="director">
            @if ($proyecto['director'] == 0)
                <option value="0" selected>
                <option>
            @endif
            @if ($proyecto['director'] > 0)
                <option value="{{ $proyecto->ndirector->id }}" selected>
                    {{ $proyecto->ndirector->nombre . ' ' . $proyecto->ndirector->apellido1 }}
                <option>
            @endif
            @foreach ($empleados as $e)
                <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
            @endforeach
        </select>
        <div id="director_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="lider">LIDER</label>

        <select class="form-control" id="lider" name="lider">
            @if ($proyecto['lider'] == 0)
                <option value="0" selected>
                <option>
            @endif
            @if ($proyecto['lider'] > 0)
                <option value="{{ $proyecto->nlider->id }}" selected>
                    {{ $proyecto->nlider->nombre . ' ' . $proyecto->nlider->apellido1 }}
                <option>
            @endif
            @foreach ($empleados as $e)
                <option value="{{ $e->id }}">{{ $e->nombre . ' ' . $e->apellido1 }}</option>
            @endforeach
        </select>
        <div id="lider_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="lider">CIUDAD</label>
        <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ $proyecto['ciudad'] }}">
        <div id="ciudad_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="co">CENTRO DE OPERACIÓN</label>
        <select class="form-control" id="co" name="co">
            @isset($proyecto->cdc->centro_operacion)
                <option value="{{ $proyecto->cdc->centro_operacion }}">{{ $proyecto->cdc->centro_operacion }}</option>
            @endisset
            <option value="001">001</option>
            <option value="002">002</option>
        </select>
        <div id="co_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="un">UNIDAD DE NEGOCIO</label>
        <select class="form-control" id="un" name="un">
            @isset($proyecto->cdc->unidad_negocio)
                <option value="{{ $proyecto->cdc->unidad_negocio }}">{{ $proyecto->cdc->unidad_negocio }}</option>
            @endisset
            <option value="001">001</option>
            <option value="002">002</option>
            <option value="003">003</option>
            <option value="004">004</option>
            <option value="005">005</option>
            <option value="999">999</option>
        </select>
        <div id="un_e" class="invalid-feedback"></div>
    </div>
</form>
