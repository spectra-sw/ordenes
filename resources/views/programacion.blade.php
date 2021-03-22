@extends('layouts.app')

@section('content')

<br>
<button class="btn btn-primary" onclick="nuevaprog()">Nueva Programacion</button><br><br>
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
                    <label for="cc">TÉCNICO</label>
                    <select class="form-control" id="cc" name="cc">
                        <option value=""><option>
                        @foreach ($emp as $e)
                            <option value="{{ $e->cc }}">{{ $e->nombre . " " . $e->apellido1}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="apellido1">FECHA</label>
                    <input type="date" class="form-control"  id="fecha" name="fecha">
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
                            <option value="{{ $e->id }}">{{ $e->nombre . " " . $e->apellido1}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="observaciones">OBSERVACIONES</label>
                    <input type="text" class="form-control"  id="observaciones" name="observaciones">
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
  <div class="modal fade bd-example-modal-xl" id="editaremp">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
        <div class="modal-header">
            Editar empleado
        </div>
        <!-- Modal body -->
        <div class="modal-body" id="editarBody">
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>      
      </div>
    </div>
  </div>
  <div class="modal fade bd-example-modal-sm" id="eliminaremp">
    <div class="modal-dialog">
      <div class="modal-content">  
        <!-- Modal body -->
       
        <!-- Modal body -->
        <div class="modal-body" id="eliminarBody">
        <p>Desea eliminar a este empleado?</p>
        <input type="hidden" id="id" name="id" value=""> 
        <button type="button" class="btn btn-primary" onclick="eliminare()">Eliminar</button>
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


