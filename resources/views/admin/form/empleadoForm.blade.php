<form id="formEmpleado">
    @isset($empleado['id'])
        <input type="hidden" id="id" name="id" value="{{ $empleado['id'] }}">
    @endisset

    <div class="form-group mb-2">
        <label for="cc">CC</label>
        <input type="text" class="form-control" id="cc" name="cc"
            value="{{ isset($empleado['cc']) ? $empleado['cc'] : '' }}">
        <div id="cc_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="apellido1">APELLIDO 1</label>
        <input type="text" class="form-control" id="apellido1" name="apellido1"
            value="{{ isset($empleado['apellido1']) ? $empleado['apellido1'] : '' }}">
        <div id="apellido1_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="apellido2">APELLIDO 2</label>
        <input type="text" class="form-control" id="apellido2" name="apellido2"
            value="{{ isset($empleado['apellido2']) ? $empleado['apellido2'] : '' }}">
        <div id="apellido2_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="nombre">NOMBRE</label>
        <input type="text" class="form-control" id="nombre" name="nombre"
            value="{{ isset($empleado['nombre']) ? $empleado['nombre'] : '' }}">
        <div id="nombre_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="auxilio">AUXILIO</label>
        <input type="text" class="form-control" id="auxilio" name="auxilio"
            value="{{ isset($empleado['auxilio']) ? $empleado['auxilio'] : '' }}">
        <div id="auxilio_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="auxilio">AUXILIO TRANSPORTE</label>
        <select class="form-control" id="auxiliot" name="auxiliot">
            @if (isset($empleado['auxiliot']))
                <option value="{{ $empleado['auxiliot'] ? 1 : 0 }}" selected>
                    {{ $empleado['auxiliot'] ? 'Si' : 'No' }}
                </option>
                <option value="{{ $empleado['auxiliot'] ? 0 : 1 }}">
                    {{ $empleado['auxiliot'] ? 'No' : 'Si' }}
                </option>
            @else
                <option value="" selected></option>
                <option value="1">Si</option>
                <option value="0">No</option>
            @endif
        </select>
        <div id="auxiliot_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="correo">CORREO</label>
        <input type="text" class="form-control" id="correo" name="correo"
            value="{{ isset($empleado['correo']) ? $empleado['correo'] : '' }}">
        <div id="correo_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="telefono">Telefono</label>
        <input type="text" class="form-control" id="telefono" name="telefono"
            placeholder="+573170000000"
            value="{{ isset($empleado['telefono']) ? $empleado['telefono'] : '' }}">
        <div id="telefono_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="ciudad">CIUDAD</label>
        <input type="text" class="form-control" id="ciudad" name="ciudad"
            value="{{ isset($empleado['ciudad']) ? $empleado['ciudad'] : '' }}">
        <div id="ciudad_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="horario">HORARIO</label>
        <select class="form-control" id="horario" name="horario">
            @if (isset($idh))
                <option value="{{ $idh }}" selected>{{ $horario }}</option>
                @foreach ($horarios as $h)
                    @if ($idh != $h->id)
                        <option value="{{ $h->id }}">{{ $h->nombre }}</option>
                    @endif
                @endforeach
            @else
                <option value="" selected></option>
                @foreach ($horarios as $h)
                    <option value="{{ $h->id }}">{{ $h->nombre }}</option>
                @endforeach
            @endif

        </select>
        <div id="horario_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="area">ÁREA</label>
        <select class="form-control" id="area" name="area">
            @if (isset($empleado['area']))
                <option value="{{ $empleado['area'] }}" selected>{{ $area }}</option>
                @foreach ($areas as $a)
                    @if ($empleado['area'] != $a->id)
                        <option value="{{ $a->id }}">{{ $a->area }}</option>
                    @endif
                @endforeach
            @else
                <option value="" selected></option>
                @foreach ($areas as $a)
                    <option value="{{ $a->id }}">{{ $a->area }}</option>
                @endforeach
            @endif
        </select>
        <div id="area_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="cargo">CARGO</label>
        <select class="form-control" id="cargo" name="cargo">
            @if (isset($empleado['cargo']))
                <option value="{{ $empleado['cargo'] }}" selected>{{ $cargo }}</option>
                @foreach ($cargos as $c)
                    @if ($empleado['cargo'] != $c->id)
                        <option value="{{ $c->id }}">{{ $c->cargo }}</option>
                    @endif
                @endforeach
            @else
                <option value="" selected></option>
                @foreach ($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->cargo }}</option>
                @endforeach
            @endif
        </select>
        <div id="cargo_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group mb-2">
        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" class="form-control">

            @if (isset($empleado['tipo']))
                <option value="0" {{ $empleado['tipo'] == 0 ? 'selected' : '' }}>Admin</option>
                <option value="1" {{ $empleado['tipo'] == 1 ? 'selected' : '' }}>Registro</option>
                <option value="2" {{ $empleado['tipo'] == 2 ? 'selected' : '' }}>Revisión</option>
                <option value="10" {{ $empleado['tipo'] == 10 ? 'selected' : '' }}>Ocupación</option>
            @else
                <option value=""></option>
                <option value="0">Admin</option>
                <option value="1">Registro OT</option>
                <option value="2">Revisión de tiempos</option>
                <option value="10">Registro Ocupación</option>
            @endif
        </select>
        <div id="tipo_e" class="invalid-feedback"></div>
    </div>

    <div class="form-group" id="containerExtraAuxilios">
        <label>AUXILIOS EXTRAS</label>

        @if (isset($empleado['tipo']))
            @foreach ($empleado['auxilio_extras'] as $auxilio)
                <div class="row mb-2">
                    <div class="col-7">
                        <select id="extra_names" name="extra_names" class="form-control">

                            <option value="{{ $auxilio->list_auxilio_extra->id }}" selected>{{ $auxilio->list_auxilio_extra->name }}
                            </option>
                            @foreach ($list_of_extras as $extra)
                                @if ($auxilio->list_auxilio_extra->id != $extra->id)
                                    <option value="{{ $extra->id }}">{{ $extra->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-3">
                        <input class="form-control" type="number" name="extra_values" id="extra_values"
                            placeholder="" value="{{ $auxilio->valor }}">
                    </div>

                    <div class="col align-item-center">
                        <div class="d-flex h-100 align-items-center">
                            <i class="bi bi-trash text-danger" style="font-size: 20px"
                                onclick="DeleteExtraAuxilio(this)"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div id="extra_names_e" class="text-danger" style="font-size: 0.875rem; display: block"></div>
    <div id="extra_values_e" class="text-danger" style="font-size: 0.875rem; display: block"></div>

    <div class="d-flex justify-content-center mt-4">
        <button type="button" class="btn btn-primary rounded-circle p-0 px-2" style="font-size: 32px"
            onclick="addExtraAuxilio()" title="Agregar auxilio">
            <i class="bi bi-plus"></i>
        </button>
    </div>
</form>


{{-- only used this for copy with JS --}}
<div id="copyExtraAuxilioHtml" class="d-none">
    <div class="row mb-2">
        <div class="col-7">
            <select id="extra_names" name="extra_names" class="form-control">
                <option value="" selected></option>
                @foreach ($list_of_extras as $extra)
                    <option value="{{ $extra->id }}">{{ $extra->name }}</option>
                @endforeach
            </select>

        </div>

        <div class="col-3">
            <input class="form-control" type="number" name="extra_values" id="extra_values" placeholder="">
        </div>

        <div class="col align-item-center">
            <div class="d-flex h-100 align-items-center">
                <i class="bi bi-trash text-danger" style="font-size: 20px" onclick="DeleteExtraAuxilio(this)"></i>
            </div>
        </div>
    </div>
</div>
