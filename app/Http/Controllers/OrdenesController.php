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
use App\Models\Corte;
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

        $fecha = $request->fecha;
        $hours = $request->horaInicio;
        $minutes = $request->minInicio;

        $fecha = Carbon::create($fecha, $hours, $minutes);
        $fecha->addHours($hours);
        $fecha->addMinutes($minutes);
        //$formatted_date_time = $fecha->format('Y-m-d H:i:s');

        //dd( $formatted_date_time );

        $fechaf = $fecha;
        $fechaf->addHours($request->duracionh);
        $fechaf->addMinutes($request->duracionm);
        //$formatted_fechaf  = $fechaf->format('H:i');

        //dd($formatted_fechaf);

        $user_id = session()->get('user');

        $hi = strval($request->horaInicio) . ":" . strval($request->minInicio);
        //$hf = strval($request->horaFin) . ":" . strval($request->minFin);
        $duracion = strval($request->duracionh) . ":" . strval($request->duracionm);
        $request->merge(['user_id' => $user_id, 'hi' => $hi, 'hf' => $fechaf->format('H:i'),'fechaf' => $fechaf->format('Y-m-d'), 'estado' => 1,
         'duracion' => $duracion, 'almuerzo' => 0]);
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
        //$jornadas = Jornada::where('user_id',$user)
                            //->where('fecha','>=',$fecha)->orWhere('fechaf','>=',$fecha)->get();

        $jornadas = Jornada::where('user_id', $user)
            ->where('estado','<>',3)
            ->where(function ($query) use ($fecha) {
                $query->where('fecha', '>=', $fecha)
                        ->orWhere('fechaf', '>=', $fecha);
            })
            ->get();
        // dd($jornadas);
        //$hi = intval($request->horaInicio) + floatval($request->minInicio);
        //$hf = intval($request->horaFin) + floatval($request->minFin);
        $fecha = $request->fecha;
        $hours = $request->horaInicio;
        $minutes = $request->minInicio;

        $fecha = Carbon::create($fecha);
        $fecha->addHours($hours);
        $fecha->addMinutes($minutes);
        $formatted_date_time = $fecha->format('Y-m-d H:i:s');
        $timestamp2_start = $fecha->getTimestamp();
        // dd($fecha);
        //dd( $formatted_date_time );

        $fechaf = Carbon::create($request->fecha);
        $fechaf->addHours($hours + $request->duracionh);
        $fechaf->addMinutes($minutes +$request->duracionm);
        $formatted_date_time = $fechaf->format('Y-m-d H:i:s');
    //    dd( $formatted_date_time );
        $timestamp2_end = $fechaf->getTimestamp();
        // dd($fechaf);

        // dd( $timestamp2_start ." ".$timestamp2_end);

        $solape = "false";
        foreach ($jornadas as $j){
            $inicio = explode(":",$j->hi);
            $fin = explode(":",$j->duracion);

            $fecha3 = $j->fecha;
            $hours = intval($inicio[0]);
            $minutes = floatval($inicio[1]);

            $fecha3 = Carbon::create($fecha3);
            $fecha3->addHours($hours);
            $fecha3->addMinutes($minutes);
            // dd($fecha3, );

            $hoursf = intval($fin[0]);
            $minutesf = floatval($fin[1]);

            $fecha4 = $j->fecha;
            $fecha4 = Carbon::create($fecha4);
            $fecha4->addHours($hours+$hoursf);
            $fecha4->addMinutes($minutes+$minutesf);

            //dd($fecha4);
           /* if (($fecha >= $fecha4 || $fechaf <= $fecha3) ) {
                $solape= "false";
            } else {
                $solape= "true";
                if($j->estado == 3){
                    $solape= "false";
                }
            }*/
            if (($fecha < $fecha3 && $fechaf > $fecha3) || ($fecha>= $fecha3 && $fechaf <= $fecha4) || ($fecha >= $fecha3 && $fechaf >= $fecha4 && $fecha < $fecha4)){
                $solape="true";
                return $solape;
            }



        }
        return $solape;
    }
    public function misjornadas(){
        return view('misjornadas');
    }
    public function consultaJornada(Request $request){
        $user = session()->get('user');
        $jornadas = Jornada::where('user_id',$user)->where('fecha','>=',$request->inicio)->where('fecha','<=',$request->fin)->orderBy('fecha','asc')->get();
        $users = DB::table('users')->distinct()->select('email')->where('name', 'John')->get();
        $total_jornadas = DB::table('jornada')->distinct()->select('jornada_id')->where('user_id',$user)->where('fecha','>=',$request->inicio)->where('fecha','<=',$request->fin)->count();

        $request = new Request();
        $request->merge(['fecha' => Carbon::now()->format('Y-m-d')]);
        $estado = $this->validarCorte($request);



        return view('timetracker.consultaJornadas',[
            'jornadas' => $jornadas,
            'total_jornadas' => $total_jornadas,
            'estado' => $estado
        ]);
    }
    public function consultaJornadaAdmin(Request $request){


        $jornadas = Jornada::query();

        if ($request->proyecto) {
            $jornadas->where('proyecto', $request->proyecto);
        }

        if ($request->trabajador) {
            $jornadas->where('user_id', $request->trabajador);
        }
        if( $request->cliente){
            $clientId = $request->cliente;
            $jornadas = $jornadas->whereHas('proyectoinfo', function ($query) use ($clientId) {$query->where('cliente_id', $clientId);});

        }
        if ($request->inicio && $request->fin) {
            $jornadas->whereBetween('fecha', [$request->inicio, $request->fin]);
        }

        if ($request->estado) {
            $jornadas->where('estado', $request->estado);
        }

        $jornadas = $jornadas->orderBy('fecha','asc')->get();

        return view('timetracker.consultaJornadasAdmin', [
            'jornadas' => $jornadas,
            'total_jornadas' => 0
        ]);
    }
    public function accionesJornada(Request $request){
        // validate $request
        $validate = $request->validate([
            'obs' => 'required',
        ]);


        $user = session()->get('user');
        //dd($request->obs);
        $jornada = Jornada::find($request->id);

        if ($request->op == "1"){
            $jornada->estado = 2;
            $result= "Aprobación realizada";
        } elseif ($request->op == "2") {
            $jornada->estado = 3;
            $result= "Registro rechazado";
        } elseif ($request->op == "3") {
            $jornada->delete();
            return  "Registro eliminado";
        }

        $jornada->observacion = $request->obs;
        $jornada->hi=$request->hi;
        $jornada->hf=$request->hf;
        //$jornada->duracion=$request->duracion;
        $jornada->almuerzo=$request->almuerzo;
        $jornada->revisado_por = $user;
        $jornada->fecha_revision = Carbon::now()->format('Y-m-d');
       //dd($jornada);
        $jornada->save();

        return $result;
    }

    public function validarCorte(Request $request){
        $cortes = Corte::all();
        $fecha = $request->fecha;
        foreach ($cortes as $c){
            if (($fecha >= $c->fecha_inicio)&& ($fecha<= $c->fecha_fin)){
                return $c->estado;
            }
        }
        return 1;
    }
    public function accionCorte(Request $request){
        $op = $request->op;
        $id = $request->id;

        $c = Corte::where('id',$id)->update([
            'estado' => $op
        ]);

        return "Acción realizada";
    }
}
