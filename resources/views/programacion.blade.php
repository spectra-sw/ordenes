@extends('layouts.app')

@section('content')

<br>
<button class="btn btn-primary" onclick="nuevaprog()">Nueva Programacion</button><br><br>
<form id="filtrarProg">
<div class="row cajaAzul">
  <div class="col-12 col-sm-2">
    <div class="form-group">
      <label for="cc">FUNCIONARIO</label>
        <select class="form-control" id="filtrocc" name="filtrocc">
          <option value=""><option>
          @foreach ($emp as $e)
          <option value="{{ $e->cc }}">{{ $e->apellido1. " " . $e->nombre}}</option>
          @endforeach
          </select>
    </div>
  </div>
  <div class="col-12 col-sm-2">
    <div class="form-group">
      <label for="apellido1">FECHA 1</label>
      <input type="date" class="form-control"  id="filtrofecha1" name="filtrofecha1" >
    </div>
  </div>
  <div class="col-12 col-sm-2">
    <div class="form-group">
      <label for="apellido1">FECHA 2</label>
      <input type="date" class="form-control"  id="filtrofecha2" name="filtrofecha2" >
    </div>
  </div>
  <div class="col-12 col-sm-2">
                <div class="form-group">
                    <label for="proyecto">PROYECTO</label>
                    <select class="form-control" id="filtroproyecto" name="filtroproyecto">
                    <option value=""><option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->codigo }}">{{ $p->codigo . " " . $p->cliente->cliente }}</option>
                        @endforeach
                    </select>
                </div>
  </div>
  <div class="col-12 col-sm-2">
    <div class="form-group">
                    <label for="responsable">RESPONSABLE</label>
                    <select class="form-control" id="filtroresp" name="filtroresp">
                    <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                        @endforeach
                    </select>
    </div>
  </div>
  <div class="col-12 col-sm-2">
    <div class="form-group">
                    <label for="responsable">CIUDAD</label>
                    <select class="form-control" id="filtrociudad" name="filtrociudad">
                        @foreach ($ciudades as $c)
                            <option value="{{ $c->ciudad }}">{{ $c->ciudad }}</option>
                        @endforeach
                    </select>
    </div>
  </div>
 
</div>
<div class="row cajaAzul">
  <div class="col-12 col-sm-1">
    <button type="button" class="btn btn-primary" onclick="filtrarprog()">Listado</button><br>
    
  </div>
  <div class="col-12 col-sm-1">
    
    <button type="button" class="btn btn-primary" onclick="calendario()">Calendario</button>
  </div>
</div>
</form>
<br>
<div id ="tprog">
    @include('tablaprog')
    
</div>
<div class="modal fade bd-example-modal-xl" id="prog">
    <div class="modal-dialog">
      <div class="modal-content">  

        <!-- Modal body -->
        <div class="modal-header">
            Crear programación
        </div>

        <!-- Modal body -->
        <div class="modal-body" id="progBody">
            <form id="formProg">
                <div class="form-group">
                    <label for="cc">FUNCIONARIO</label>
                    <select class="form-control" id="cc" name="cc">
                        <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->cc }}">{{ $e->apellido1. " " . $e->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="apellido1">FECHA</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha" onchange="validarfest(this.value)">
                </div>
                <div class="form-group">
                    <label for="proyecto">PROYECTO</label>
                    <select class="form-control" id="proyecto" name="proyecto">
                    <option value=""><option>
                        @foreach ($proyectos as $p)
                            <option value="{{ $p->codigo }}">{{ $p->codigo . " " . $p->cliente->cliente }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="responsable">RESPONSABLE</label>
                    <select class="form-control" id="responsable" name="responsable">
                    <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->id }}">{{ $e->apellido1 . " " . $e->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observaciones">OBSERVACIONES</label>
                    <input type="text" class="form-control"  id="observaciones" name="observaciones">
                </div>
                <div class="form-group">
                    <label for="">HORARIO</label>
                    <div class="row">
                      <div class="col-4 col-md-2 ">Inicio</div>
                      <div class="col-4 col-md-2 "><input type="number" name="hi" id="hi" min="0" max="24" class="form-control"></div>
                      <div class="col-4 col-md-2 "><input type="number" name="mi" id="mi" min="0" max="59" class="form-control"></div>
                      <div class="col-4 col-md-2 ">Fin</div>
                      <div class="col-4 col-md-2 "><input type="number" name="hf" id="hf" min="0" max="24" class="form-control"></div>
                      <div class="col-4 col-md-2 "><input type="number" name="mf" id="mf" min="0" max="59" class="form-control"></div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="guardarprog()">Guardar</button>

            </form>
        </div>        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
</div>
  <div class="modal fade bd-example-modal-xl" id="editarprog">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar programación
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarprogBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminarprog">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarprogBody">
        <p>Desea eliminar esta programación?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminarprog()">Eliminar</button>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
 
  <script src="{{asset('js/scripts.js')}}"></script>    
@endsection


