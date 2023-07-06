<!--  Modal crear proyecto -->
@if ($accion == 1)
    <!-- header -->
    <div class="modal-header">
        Nuevo proyecto
    </div>

    <!-- body -->
    <div class="modal-body" id="proyBody">
        <form id="formProy">
            <div class="form-group">
                <label for="codigo">CODIGO</label>
                <input type="text" class="form-control" id="codigo" name="codigo">
            </div>
            <div class="form-group">
                <label for="descripcion">DESCRIPCIÓN</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>
            <div class="form-group">
                <label for="proyecto">CLIENTE</label>
                <select class="form-control" id="cliente" name="cliente">
                    <option value=""></option>
                    @foreach ($clientes as $c)
                        <option value="{{ $c->id }}">{{ $c->cliente }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="sistema">SISTEMA</label>
                <input type="text" class="form-control" id="sistema" name="sistema">
            </div>
            <div class="form-group">
                <label for="auxilio">SUBPORTAFOLIO</label>
                <!--<input type="text" class="form-control"  id="subportafolio" name="subportafolio">-->
                <select class="form-control" id="subportafolio" name="subportafolio">
                    <option value="Grandes cuentas">Grandes cuentas</option>
                    <option value="Estratégicos">Estratégicos</option>
                    <option value="Corporativos">Corporativos</option>
                    <option value="NA">No aplica</option>
                </select>
            </div>
            <div class="form-group">
                <label for="director">DIRECTOR</label>
                <select class="form-control" id="director" name="director">
                    <option value="0"></option>
                    @foreach ($emp as $e)
                        <option value="{{ $e->id }}">{{ $e->apellido1 . ' ' . $e->nombre }}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="lider">LIDER</label>
                <select class="form-control" id="lider" name="lider">
                    <option value="0"></option>
                    @foreach ($emp as $e)
                        <option value="{{ $e->id }}">{{ $e->apellido1 . ' ' . $e->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="lider">CIUDAD</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad">
            </div>
            <div class="form-group">
                <label for="co">CENTRO DE OPERACIÓN</label>
                <select class="form-control" id="co" name="co">
                    <option value=" "></option>
                    <option value="001">001</option>
                    <option value="002">002</option>
                </select>
                <!-- <input type="text" class="form-control"  id="co" name="co">-->
            </div>
            <div class="form-group">
                <label for="un">UNIDAD DE NEGOCIO</label>
                <select class="form-control" id="un" name="un">
                    <option value=" "></option>
                    <option value="001">001</option>∫
                    <option value="002">002</option>
                    <option value="003">003</option>
                    <option value="004">004</option>
                    <option value="005">005</option>
                    <option value="999">999</option>
                </select>
                <!--<input type="text" class="form-control"  id="un" name="un">-->
            </div>
            <div class="form-group">
                <label for="un">REGISTRO DE HORAS</label>
                <select class="form-control" id="registro" name="registro">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="guardarproy()">Guardar</button>
        </form>
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
    </div>
@endif



{{-- editar proyecto --}}
@if ($accion == 2)
    <!-- header -->
    <div class="modal-header">
        Editar proyecto
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.proyectoForm')
    </div>
    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="editarProyecto()">Guardar</button>
    </div>
@endif


{{-- habilitar/deshabilitar proyecto --}}
@if ($accion == 3)
    <!-- header -->
    <div class="modal-header">
        {{ $proyecto->registro == 1 ? 'Deshabilitar' : 'Habilitar' }} proyecto
    </div>

    <!-- body -->
    <div class="modal-body">
        <form id="formPoyecto">
            <input type="hidden" name="proyecto_id" id="proyecto_id" value="{{ $proyecto->id }}">
        </form>
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="togleHabilitarProyecto()">
            {{ $proyecto->registro == 1 ? 'Deshabilitar' : 'Habilitar' }}
        </button>
    </div>
@endif

<!--autorizados proyecto-->
@if ($accion == 4)
    <!-- header -->
    <div class="modal-header">
        Autorizados proyecto
    </div>
    <!-- body -->
    <div class="modal-body">
        @include('admin.form.proyectoAutorizadoForm')
    </div>

    <!-- footer -->
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

    </div>
@endif
