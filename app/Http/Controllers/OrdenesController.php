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
use App\Models\Jornada;
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
    public function jornada(Request $request){
        $proyectos = collect([]);
        
        $user = session('user');
        if ($user==""){
            return redirect()->route('inicio');
        }
        $aut = Autorizados::where('empleado_id',$user)->get();
        return view('jornada',[
            'proyectos' => $aut

        ]);
    }
    public function registrarJornada(Request $request){
        //$sessionData = session()->all();
        //dd($sessionData);
        $user_id = session()->get('user');
        $hi = strval($request->horaInicio) . ":" . strval($request->minInicio);
        $hf = strval($request->horaFin) . ":" . strval($request->minFin);
        $request->merge(['user_id' => $user_id, 'hi' => $hi, 'hf' => $hf, 'estado' => 1]);
        $data = $request->all();
        
        $j = Jornada::create($data);

        $datosJornada = Jornada::where('jornada_id',$data['jornada_id'])->where('user_id',$user_id)->get();
        return view('tablaJornada',[
            'jornada' => $datosJornada
        ]);
    }
    public function consecJornada(Request $request){
        $user = session()->get('user');
        //$next = Jornada::max('id')+ 1;
        if(Jornada::where('user_id',$user)->latest()->first()){
            $jornada_id = Jornada::where('user_id',$user)->latest()->first()->jornada_id +1;
        }
        else{
            $jornada_id =1;
        }
        return $jornada_id;

    }
    public function deleteJornada(Request $request){
        $datos = Jornada::where('id',$request->id)->first();
        Jornada::where('id',$request->id)->delete();
        $datosJornada = Jornada::where('jornada_id',$datos->jornada_id)->where('user_id',$datos->user_id)->get();
        return view('tablaJornada',[
            'jornada' => $datosJornada
        ]);
        
    }
    public function solapeJornada(Request $request){
        $user = session()->get('user');
        $fecha =$request->fecha;
       // $fecha = "2023-02-06";
        $jornadas = Jornada::where('user_id',$user)
                            ->where('fecha',$fecha)->get();
        $hi = intval($request->horaInicio) + floatval($request->minInicio);
        $hf = intval($request->horaFin) + floatval($request->minFin);
      
        
        $solape = "false";
        foreach ($jornadas as $j){
            $inicio = explode(":",$j->hi);
            $fin = explode(":",$j->hf);
            $hibd = intval($inicio[0])+ floatval($inicio[1]/60);
            $hfbd = intval($fin[0])+ floatval($fin[1]/60);

            if (($hi < $hibd) and ($hf > $hibd) and ($hf <= $hfbd)){
                $solape= "true";
            }
            if (($hi >= $hibd) and ($hi < $hfbd)  and ($hf > $hibd) and ($hf <= $hfbd)){
                $solape= "true";
            }
            if (($hi >= $hibd) and ($hi < $hfbd)  and ($hf > $hibd) and ($hf > $hfbd)){
                $solape= "true";
            }

           
        }
        return $solape;
    }
    public function misjornadas(){
        return view('misjornadas');
    }
    public function consultaJornada(Request $request){
        $user = session()->get('user');
        $jornadas = Jornada::where('user_id',$user)->where('fecha','>=',$request->inicio)->where('fecha','<=',$request->fin)->get();
        $users = DB::table('users')->distinct()->select('email')->where('name', 'John')->get();
        $total_jornadas = DB::table('jornada')->distinct()->select('jornada_id')->where('user_id',$user)->where('fecha','>=',$request->inicio)->where('fecha','<=',$request->fin)->count();
        return view('timetracker.consultaJornadas',[
            'jornadas' => $jornadas,
            'total_jornadas' => $total_jornadas
        ]);
    }
}
