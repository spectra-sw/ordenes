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

use Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrdenesController extends Controller
{
    public function ordenes(){
        //$proyectos = Proyecto::orderBy('codigo','asc')->get();
        $proyectos = collect([]);
        $user = session('user');
        if ($user==""){
            return redirect()->route('inicio');
        }
        //$user = 108;
        $cc = Empleado::where('id',$user)->first()->cc;
        $ciudad = Empleado::where('id',$user)->first()->ciudad;
        $ps = Programacion::where('cc',$cc)->get()->unique('proyecto');
        foreach ($ps as $p){
            $proyectos->push($p->proyecto);
        }
        //dd($proyectos->count());
        if ($proyectos->count() == 0){
            $ps = Proyecto::where('ciudad',$ciudad)->orderBy('codigo','asc')->get();
            foreach ($ps as $p){
                $proyectos->push($p->codigo);
            }
        }
        $ps = Proyecto::where('director',$user)->orWhere('lider',$user)->get();
        foreach ($ps as $p){
            $proyectos->push($p->codigo);
        }
        //dd($proyectos);
        $proyectosf= collect([]);
        foreach ($proyectos as $p){
            if(Proyecto::where('codigo',$p)->first()->registro == 1){
                $proyectosf->push($p);
            }
        }
        //dd($proyectosf);
        return view('ordenes',[
            'proyectos' => $proyectos 

        ]);
    }
}
