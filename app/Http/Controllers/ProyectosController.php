<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\Orden;
use App\Models\Planificacion;
use App\Models\Ejecucion;
use App\Models\Hora;
use App\Models\Dia;
use App\Models\Empleado;
use App\Models\Cdc;
use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Programacion;
use App\Models\Horario;
use App\Models\Area;
use App\Models\Actividad;
use App\Models\ocupacion;
use App\Models\Festivo;
use App\Models\Novedad;
use App\Models\Autorizacion;
use App\Models\Cargo;
use App\Models\Autorizados;

use Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{
    //
    public function nuevoproy(Request $request)
    {
        if (Proyecto::where('codigo', $request->codigo)->exists()) {
            return "Ya existe un proyecto con ese código";
        } else {
            $proyecto = Proyecto::create([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'cliente_id' => $request->cliente,
                'sistema' => $request->sistema,
                'subportafolio' => $request->subportafolio,
                'director' => $request->director,
                'lider' => $request->lider,
                'ciudad' => $request->ciudad,
                'creado_por' => session('user'),
                'creacion' => date("Y-m-d"),
                'registro' => $request->registro
            ]);

            $cdc =  Cdc::create([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'centro_operacion' => $request->co,
                'unidad_negocio' => $request->un,
                'responsable' => '',
                'mayor' => 0,
                'grupo' => 'CP',
                'observaciones' => '',
            ]);
            return "Proyecto creado";
        }
    }
    public function agautorizadoproy(Request $request)
    {
        $idemp = Empleado::where('cc', $request->empleado)->first()->id;
        $idproy = Proyecto::where('id', $request->id)->first()->codigo;
        Autorizados::create([
            'proyecto' => $idproy,
            'empleado_id' => $idemp
        ]);
        $autorizados = Autorizados::where('proyecto', $idproy)->get();
        return view('tablaautorizadosproy', [
            'autorizados' => $autorizados
        ]);
    }
    public function borrarautorizado(Request $request)
    {
        $idproy = Autorizados::where('id', $request->id)->first()->proyecto;
        Autorizados::where('id', $request->id)->delete();
        $autorizados = Autorizados::where('proyecto', $idproy)->get();
        return view('tablaautorizadosproy', [
            'autorizados' => $autorizados
        ]);
    }
    public function editarproy(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'descripcion' => 'required',
            'cliente' => 'required',
            'sistema' => 'required',
            'subportafolio' => 'required',
            'director' => 'required',
            'lider' => 'required',
            'ciudad' => 'required',
        ]);

        Proyecto::where('id', $request->id)
            ->update([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'cliente_id' => $request->cliente,
                'sistema' => $request->sistema,
                'subportafolio' => $request->subportafolio,
                'director' => $request->director,
                'lider' => $request->lider,
                'ciudad' => $request->ciudad,
            ]);

        Cdc::where('codigo', $request->codigo)
            ->update([
                'descripcion' => $request->descripcion,
                'centro_operacion' => $request->co,
                'unidad_negocio' => $request->un,
            ]);


        return response()->json([
            'message' => 'Proyecto actualizado'
        ]);
    }
    public function togleHabilitarProyecto(Request $request)
    {
        $proyecto = Proyecto::where('id', $request->id)->get()->first();
        $proyecto->update([
            'registro' => !$proyecto->registro,
        ]);

        return response()->json([
            'message' => $proyecto->registro ? 'Proyecto habilitado' : 'Proyecto deshabilitado'
        ]);
    }
    public function tablaproy(Request $request)
    {
        $campo = $request->campo;
        if ($campo == '') {
            $proyectos = Proyecto::select(
                'id',
                'cliente_id',
                'codigo',
                'descripcion',
                'sistema',
                'subportafolio',
                'director',
                'lider',
                'ciudad',
                'registro'
            )->with([
                'cliente' => function ($query) {
                    $query->select('cliente', 'id');
                },
                'ndirector' => function ($query) {
                    $query->select('nombre', 'apellido1', 'id');
                },
                'nlider' => function ($query) {
                    $query->select('nombre', 'apellido1', 'id');
                },
                'cdc' => function ($query) {
                    $query->select('centro_operacion', 'unidad_negocio', 'codigo');
                }
            ])->orderBy('codigo', 'asc')->get();
        } else {
            $proyectos = Proyecto::select(
                'codigo',
                'descripcion',
                'sistema',
                'subportafolio',
                'director',
                'lider',
                'ciudad',
                'registro'
            )->with([
                'cliente' => function ($query) {
                    $query->select('cliente');
                },
                'ndirector' => function ($query) {
                    $query->select('nombre', 'apellido1');
                },
                'nlider' => function ($query) {
                    $query->select('nombre', 'apellido1');
                },
                'cdc' => function ($query) {
                    $query->select('centro_operacion', 'unidad_negocio');
                }
            ])->orderBy($campo, 'asc')->get();
        }

        return view('admin.tabla.proyectoTabla', [
            'proyectos' => $proyectos,
        ]);
    }
    public function filtrarproy(Request $request)
    {

        $proy =  Proyecto::orderBy('codigo', 'asc');

        if ($request->fcodigo != "") {
            $proy = $proy->where('codigo', $request->fcodigo);
        }
        if ($request->fcliente != "") {
            $proy = $proy->where('cliente_id', $request->fcliente);
        }
        if ($request->fdirector != "") {
            $proy = $proy->where('director', $request->fdirector);
        }
        if ($request->flider != "") {
            $proy = $proy->where('lider', $request->flider);
        }
        if ($request->fciudad != "") {
            $proy = $proy->where('ciudad', $request->fciudad);
        }
        $proy = $proy->get();
        return view('admin.tabla.proyectoTabla', [
            'proyectos' => $proy,
        ]);
    }
}
