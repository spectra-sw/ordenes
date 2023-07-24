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
use App\Models\Corte;
use App\Models\Autorizados;
use App\Models\AuxilioExtras;
use App\Models\ListAuxilioExtras;
use App\Models\Turno;
use Log;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    //
    public function test(){
        return view('layouts.test');
    }
    public function inicio(){
        session(['user' => '']);
        session(['tipo' => 3]);
        return view('auth.login');
    }
    public function login(){
        session(['user' => '']);
        session(['tipo' => 3]);
        return view('auth.login');

    }
    public function menu(){
        $tipo = session('tipo');
        $user = session('user');
        if ($user==""){
            return redirect()->route('inicio');
        }
        //dd($tipo);
        if (($tipo ==0)||($tipo ==1)||($tipo ==10)){
            $e = Empleado::where('id',$user)->first();
            $cc = $e->cc;
            $nombre = $e->nombre. " " . $e->apellido1;
            $prog = Programacion::where('cc',$cc)->orderBy('fecha','desc')->get();
            //dd($prog);
           /* return view('menu',[
                'prog' => $prog,
                'nombre' => $nombre
            ]);*/
            return view('timetracker.menu');
        }
        else{
            return view('login');
        }

    }
    public function bases(){
        $tipo = session('tipo');
        $user_id = session('user');

        if ($user_id==""){
            return redirect()->route('inicio');
        }
        $area = Empleado::where('id',$user_id)->first()->area;
        if ($tipo == 0){
            return view('admin.index',[
                'area' => $area,
            ]);
        } else{
            return view('login');
        }

    }
    public function programacion(){
        $tipo = session('tipo');
        //dd($tipo);
        if ($tipo ==0){
            //$prog = Programacion::orderBy('fecha','desc')->paginate(15);
            $prog =Programacion::where('fecha',date('Y-m-d'))->get();

            $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
            $proyectos = Proyecto::orderBy('codigo','asc')->get();
            $ciudades= Empleado::select('ciudad')->orderby('ciudad','asc')->distinct()->get();

            $estados = collect([]);
            $dato=array();
            foreach($prog as $p){
                $pl=$e=$h=False;
                $dato[$p->id]=1;
                $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)->where('dias.fecha',$p->fecha)->exists();
                if($o){
                    $oid = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)->where('dias.fecha',$p->fecha)->first()->ordenes_id;
                    $pl = Planificacion::where('ordenes_id',$oid)->exists();
                    $e = Ejecucion::where('ordenes_id',$oid)->exists();
                    $h = Hora::where('ordenes_id',$oid)->exists();
                }
                if($o && $pl){
                    $dato[$p->id] = 2;
                }
                if($o && $pl && $e && $h){
                    $dato[$p->id] = 3;
                }
                $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)
                ->where('dias.fecha',$p->fecha)->where('ordenes.autorizada_por','<>',0)->exists();
                if($o && $p && $e && $h){
                    $dato[$p->id] = 4;
                }
                $estados->push($dato);
            }
            //dd($dato);
            //dd($prog);
            return view('programacion',[
                'proyectos' => $proyectos,
                'emp' => $emp,
                'prog' => $prog,
                'ciudades' => $ciudades,
                'dato' => $dato

            ]);
        }
        else{
            return view('login');
        }
    }
    public function admin(){
        $tipo = session('tipo');
        if (($tipo ==0)){
            return view('admin');
        }
        else{
            return view('login');
        }

    }
    public function consultas(){
        $tipo = session('tipo');
        if (($tipo ==0)||($tipo ==1)){
            return view('consultas',[
                'header' => 'Consulta de órdenes'
            ]);
        }
        else{
            return view('login');
        }

    }

    public function getConsec(){
        $total=Orden::all()->count();
        if ($total == 0){
            $o = Orden::create([
                'proyecto' => 1
            ]);
            return "00001";
        }
        else{
            $id = Orden::orderBy('created_at','desc')->first()->id;
            $id+=1;
            $o = Orden::create([
                'proyecto' => $id
            ]);
            return "0000".$id;
        }
    }
    public function agregardia(Request $request){
        $proyecto = $request->proyecto;
        $d = Dia::create([
            'ordenes_id' => $request->id,
            //'fecha' => date('Y-m-d'),
            'fecha' => '1900-01-01',
            'observacion' => ''
        ]);
        $ciudad = Proyecto::where('codigo',$proyecto)->first()->ciudad;

        $ts = Programacion::where('proyecto',$proyecto)->get()->unique('cc');
        return view('dia',[
            'id' => $d->id,
            'ts' => $ts,
            'ciudad' => $ciudad
        ]);
       // return $d->id;

    }
    public function agregarp(Request $request){
        //dd($request->cant);
        $p = Planificacion::create([
            'ordenes_id' => $request->id,
            'dias_id' => $request->diaid,
            'cant' => $request->cant,
            'und' => $request->und,
            'materiales' => $request->materiales

        ]);
        $datos = Planificacion::where('ordenes_id',$request->id)->where('dias_id',$request->diaid)->get();
        return view('tablap',[
            'datos' => $datos
        ]);
    }
    public function agregare(Request $request){
        $e = Ejecucion::create([
            'ordenes_id' => $request->id,
            'dias_id' => $request->diaid,
            'cant' => $request->cant,
            'und' => $request->und,
            'observacion' => $request->observacion

        ]);
        $datos = Ejecucion::where('ordenes_id',$request->id)->where('dias_id',$request->diaid)->get();
        return view('tablae',[
            'datos' => $datos
        ]);

    }
    public function agregarh(Request $request){
        $rhi =$request->hi;
        $rmi = $request->mi;
        $rhf =$request->hf;
        $rmf = $request->mf;
        $fecha = Dia::where('id',$request->diaid)->first()->fecha;
        $oid =  Dia::where('id',$request->diaid)->first()->ordenes_id;
        $datos = DB::table('dias')
            ->join('horas', 'dias.id', '=', 'horas.dias_id')
            ->where('dias.ordenes_id','=',$oid)
            ->where('dias.fecha',$fecha)
            ->where('horas.trabajador',$request->trabajador);

        $conteo = $datos->count();
        //dd($conteo);
        $datos = $datos->get();
       // dd($datos);
        if ($conteo>0){
            foreach($datos as $d){

                $hi = explode(":", $d->hi);
                $hf = explode(":", $d->hf);

                $hi = intval($hi[0]) + round(floatval($hi[1]/60),1);
                $hf = intval($hf[0]) + round(floatval($hf[1]/60),1);

                $rhi = intval($rhi) + round(floatval($rmi/60),1);
                $rhf = intval($rhf) + round(floatval($rmf/60),1);
                //dd($hi." ".$hf." ".$rhi." ".$rhf);
                if (($rhi == $hi) && ($rhf==$hf)){
                    return 'no';
                }
                if ((($rhi < $hi) && ($rhi < $hf)) && (($rhf > $hi) && ($rhf < $hf))){
                    return 'no';
                }
                if ((($rhi > $hi) && ($rhi < $hf)) && (($rhf > $hi) && ($rhf < $hf))){
                    return 'no';
                }
                if ((($rhi > $hi) && ($rhi < $hf)) && (($rhf > $hi) && ($rhf > $hf))){
                    return 'no';
                }


            }

        }





            $hi = $request->hi.":".$request->mi;
            $hf = $request->hf.":".$request->mf;
            $ha = 0;
            $h = Hora::create([
                'ordenes_id' => $request->id,
                'dias_id' => $request->diaid,
                'hi' => $hi,
                'hf' => $hf,
                'ht' => $request->ht,
                'ha' => 0,
                'trabajador' => $request->trabajador
            ]);
            $datos = Hora::where('ordenes_id',$request->id)->where('dias_id',$request->diaid)->get();
            return view('tablah',[
                'datos' => $datos
            ]);


    }
    public function almdia(Request $request){

        //if (Hora::where('ordenes_id',$request->id)->where('dias_id',$request->diaid)->exists()){

            $d=Dia::where('id', $request->diaid)
            ->update(['fecha' => $request->fecha,
                        'observacion' => $request->observaciond]);
            $datos = Dia::where('ordenes_id',$request->id)->where('fecha','<>','1900-01-01')->get();
            return view('tablad',[
                'datos' => $datos
            ]);
       /* }
        else{
            return 'no';
        }*/
        //return 'Información del día almacenada';
    }
    public function saveorden(Request $request){
        $id = $request->id;

        if (Dia::where('ordenes_id',$id)->where('fecha','<>','1900-01-01')->exists()){

            $tipou = session('tipo');
            $creada = 0;
            if ($tipou !=3){
                $creada = session('user');
            }

        $tipo = $request->sistema;
        if ($tipo==""){
            return "Ingrese el tipo de sistema solicitado";
        }
        /*$tipo="";
        if ($request->filled('cctv')) {
            if($tipo==""){ $tipo= "cctv";}
            else{ $tipo= $tipo." cctv";}
        }
        if ($request->filled('incendio')) {
            if($tipo==""){ $tipo= "incendio";}
            else{ $tipo= $tipo." incendio";}
        }
        if ($request->filled('cablestr')) {
            if($tipo==""){ $tipo= "cabl.estr";}
            else{ $tipo= $tipo." cabl.estr";}
        }
        if ($request->filled('otro')) {
            if($tipo==""){ $tipo= "otro";}
            else{ $tipo= $tipo." otro";}
        }
        if ($request->filled('acceso')) {
            if($tipo==""){ $tipo= "acceso";}
            else{ $tipo= $tipo." acceso";}
        }
        if ($request->filled('intrusion')) {
            if($tipo==""){ $tipo= "instrusion";}
            else{ $tipo= $tipo." intrusion";}
        }
        if ($request->filled('integracion')) {
            if($tipo==""){ $tipo= "integracion";}
            else{ $tipo= $tipo." integracion";}
        }
        if ($request->filled('documentacion')) {
            if($tipo==""){ $tipo= "documentacion";}
            else{ $tipo= $tipo." documentacion";}
        }

        if ($tipo==""){
            return "Ingrese el tipo de sistema solicitado";
        }*/

        /*$objeto="";
        if ($request->filled('instalacion')) {
            if($objeto==""){ $objeto= "instalacion";}
            else{ $objeto= $objeto." instalacion";}
        }
        if ($request->filled('MntoPrev')) {
            if($objeto==""){ $objeto= "Mnto.Prev";}
            else{ $objeto= $objeto." Mnto.Prev";}
        }
        if ($request->filled('TrabInt')) {
            if($objeto==""){ $objeto= "Trab.Int";}
            else{ $objeto= $objeto." Trab.Int";}
        }
        if ($request->filled('revision')) {
            if($objeto==""){ $objeto= "revision";}
            else{ $objeto= $objeto." revision";}
        }
        if ($request->filled('otro')) {
            if($objeto==""){ $objeto= "otro";}
            else{ $objeto= $objeto." otro";}
        }

        if($objeto==""){
            return "Ingrese el objeto de la orden de trabajo";
        }*/

       // return $tipo." ".$objeto;
        $objeto = $request->objeto;
        if($objeto==""){
            return "Ingrese el objeto de la orden de trabajo";
        }

       $o=Orden::where('id', $id)
       ->update([

            'proyecto' => $request->proyecto,
            'fecha_inicio' => $request->fechaInicio,
            'fecha_final' => $request->fechaFinal,
            'responsable' => $request->responsable,
            'cliente' => $request->cliente,
            'area_trabajo' => strtoupper($request->area),
            'contacto' => strtoupper($request->contacto),
            'tipo' => $tipo,
            'objeto' => $objeto,
            'observaciones' => $request->observacionesg  ,
            'autorizada_por' => 0,
            'creada_por' => $creada
        ]);

        return "Orden de trabajo almacenada";
        }
        else{
            return "No existen días registrados para esta orden";
        }
    }
    public function verorden($id){
        //dd($id);
        $ordenes = Orden::where('id',$id)->get();
        //dd($ordenes);
        $dias = Dia::where('ordenes_id')->where('fecha','<>','1900-01-01')->get();
        $h = Hora::where('ordenes_id')->get();
        $diasc = collect([]);
        foreach($ordenes as $o){
           // dd($o['id']);
            $dias = Dia::where('ordenes_id',$o['id'])->where('fecha','<>','1900-01-01')->get();
            foreach($dias as $d){
                //dd($d);
                $dia = collect([]);
                $dia->put('id',$d['id']);
                $dia->put('fecha',$d['fecha']);
                $dia->put('observacion',$d['observacion']);
                $horas = Hora::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $horast=collect([]);
                //dd($horas);
                foreach($horas as $h){
                    $horasc=collect([]);
                    $horasc->put('id',$h->id);
                    $horasc->put('Trabajador',$h->trabajador);
                    $horasc->put('Nombre',$h->empleado->nombre." ".$h->empleado->apellido1);
                    $horasc->put('Hi',$h->hi);
                    $horasc->put('Hf',$h->hf);
                    $horasc->put('Ht',$h->ht);
                    $horasc->put('Ha',$h->ha);
                    $horasc->put('Autorizada',$h->autorizada);
                    $horast->push($horasc);
                }
                $pl= Planificacion::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $plt=collect([]);
                foreach($pl as $p){
                    $pc=collect([]);
                    $pc->put('Cant',$p->cant);
                    $pc->put('Und',$p->und);
                    $pc->put('Materiales',$p->materiales);
                    $plt->push($pc);
                }
                $ej= Ejecucion::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $ejt=collect([]);
                foreach($ej as $e){
                    $ec=collect([]);
                    $ec->put('Cant',$e->cant);
                    $ec->put('Und',$e->und);
                    $ec->put('Observacion',$e->observacion);
                    $ejt->push($ec);
                }
                //dd($dia);
                $dia->put('Planificacion',$plt);
                $dia->put('Ejecucion',$ejt);
                $dia->put('Horas',$horast);
                $diasc->push($dia);
                //dd($diasc);
            }
        }
        //dd($diasc);
        return view('verorden',[
            'o' => $o,
            'dias' => $diasc,
        ]
        );
    }
    public function editorden($id){
        //dd($id);
        $ordenes = Orden::where('id',$id)->get();
        //dd($ordenes);
        $dias = Dia::where('ordenes_id')->where('fecha','<>','1900-01-01')->get();
        $h = Hora::where('ordenes_id')->get();
        $diasc = collect([]);
        foreach($ordenes as $o){
           // dd($o['id']);

            $dias = Dia::where('ordenes_id',$o['id'])->where('fecha','<>','1900-01-01')->get();
            foreach($dias as $d){
                //dd($d);
                $dia = collect([]);
                $dia->put('id',$d['id']);
                $dia->put('fecha',$d['fecha']);
                $dia->put('observacion',$d['observacion']);
                $horas = Hora::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $horast=collect([]);

                //dd($horas);
                foreach($horas as $h){
                    $horasc=collect([]);
                    $horasc->put('id',$h->id);
                    $horasc->put('Trabajador',$h->trabajador);
                    $horasc->put('Nombre',$h->empleado->nombre." ".$h->empleado->apellido1);
                    $horasc->put('Hi',$h->hi);
                    $horasc->put('Hf',$h->hf);
                    $horasc->put('Ht',$h->ht);
                    $horasc->put('Ha',$h->ha);
                    $horast->push($horasc);
                }
                $pl= Planificacion::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $plt=collect([]);
                foreach($pl as $p){
                    $pc=collect([]);
                    $pc->put('Cant',$p->cant);
                    $pc->put('Und',$p->und);
                    $pc->put('Materiales',$p->materiales);
                    $plt->push($pc);
                }
                $ej= Ejecucion::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                $ejt=collect([]);
                foreach($ej as $e){
                    $ec=collect([]);
                    $ec->put('Cant',$e->cant);
                    $ec->put('Und',$e->und);
                    $ec->put('Observacion',$e->observacion);
                    $ejt->push($ec);
                }
                //dd($dia);
                $dia->put('Planificacion',$plt);
                $dia->put('Ejecucion',$ejt);
                $dia->put('Horas',$horast);
                $diasc->push($dia);
                //dd($diasc);
            }
        }
        //dd($diasc);
        return view('ordenese',[
            'o' => $o,
            'dias' => $diasc,
            'datos' => $dias
        ]
        );
    }
    public function getdia(Request $request){

        $diasc = collect([]);

           // dd($o['id']);
            $dias = Dia::where('id',$request->id)->get();
            foreach($dias as $d){
                //dd($d);
                $dia = collect([]);
                $dia->put('id',$d['id']);
                $dia->put('fecha',$d['fecha']);
                $dia->put('observacion',$d['observacion']);
                $horas = Hora::where('dias_id',$d['id'])->get();
                $horast=collect([]);
                foreach($horas as $h){
                    $horasc=collect([]);
                    $horasc->put('id',$h->id);
                    $horasc->put('cc',$h->trabajador);
                    $horasc->put('Nombre',$h->empleado->nombre." ".$h->empleado->apellido1);
                    $horasc->put('Hi',$h->hi);
                    $horasc->put('Hf',$h->hf);
                    $horasc->put('Ht',$h->ht);
                    $horasc->put('Ha',$h->ha);
                    $horast->push($horasc);
                }
                $pl= Planificacion::where('dias_id',$d['id'])->get();
                $plt=collect([]);
                foreach($pl as $p){
                    $pc=collect([]);
                    $pc->put('Cant',$p->cant);
                    $pc->put('Und',$p->und);
                    $pc->put('Materiales',$p->materiales);
                    $plt->push($pc);
                }
                $ej= Ejecucion::where('dias_id',$d['id'])->get();
                $ejt=collect([]);
                foreach($ej as $e){
                    $ec=collect([]);
                    $ec->put('Cant',$e->cant);
                    $ec->put('Und',$e->und);
                    $ec->put('Observacion',$e->observacion);
                    $ejt->push($ec);
                }
                //dd($dia);
                $dia->put('Planificacion',$plt);
                $dia->put('Ejecucion',$ejt);
                $dia->put('Horas',$horast);
                $diasc->push($dia);
                //dd($diasc);
            }

        //dd($diasc);
        return view('infodia',[
            'dias' => $diasc,
        ]
        );
    }
    public function editDia(Request $request){
        $dias = Dia::where('id',$request->id)->first();
        $horas = Hora::where('dias_id',$request->id)->get();
        $pl= Planificacion::where('dias_id',$request->id)->get();
        $ej= Ejecucion::where('dias_id',$request->id)->get();
        //dd($pl);
        $o = Dia::where('id',$request->id)->first()->ordenes_id;
        $p = Orden::where('id',$o)->first()->proyecto;
        //$ts = Programacion::where('proyecto',$p)->get();
        $ts = Programacion::where('proyecto',$p)->get()->unique('cc');
        //dd($ts);
        return view('editDia',[
            'dias' => $dias,
            'horas' => $horas,
            'pl' => $pl,
            'ej' => $ej,
            'ts' => $ts
        ]);
    }
    public function deleteDia(Request $request){
        $orden_id = Dia::where('id',$request->id)->first()->ordenes_id;
        $horas = Hora::where('dias_id',$request->id)->delete();
        $pl= Planificacion::where('dias_id',$request->id)->delete();
        $ej= Ejecucion::where('dias_id',$request->id)->delete();
        $dias = Dia::where('id',$request->id)->delete();
        $datos = Dia::where('ordenes_id',$orden_id)->where('fecha','<>','1900-01-01')->get();
            return view('tablad',[
                'datos' => $datos
            ]);

    }
    public function autorizadas(Request $request){
        $datos = Hora::where('id', $request->id) ->first();

        $tipo = session('tipo');
        $autorizada = 0;
        if ($tipo !=3){
            $autorizada = session('user');
        }
        if ($autorizada ==0){
            return 'login';
        }
        $hi = explode(":", $datos->hi);
        $hf = explode(":", $datos->hf);

        $hi = intval($hi[0]) + round(floatval($hi[1]/60),1);
        $hf = intval($hf[0]) + round(floatval($hf[1]/60),1);
        $tiempo = $hf-$hi;
        //dd($tiempo);
        if ($request->valor>$tiempo ){
            return 'limite';
        }

        $o=Orden::where('id', $datos->ordenes_id)
          ->update(['autorizada_por' => $autorizada]);

        $h=Hora::where('id', $request->id)
          ->update(['ha' => $request->valor,
                    'autorizada' =>  date('Y-m-d H:i:s')
                ]);

          $dia = collect([]);
          $horas = Hora::where('ordenes_id',$datos->ordenes_id)->where('dias_id',$datos->dias_id)->get();
          $horast=collect([]);
          foreach($horas as $h){
              $horasc=collect([]);
              $horasc->put('id',$h->id);
              $horasc->put('Trabajador',$h->trabajador);
              $horasc->put('Hi',$h->hi);
              $horasc->put('Hf',$h->hf);
              $horasc->put('Ht',$h->ht);
              $horasc->put('Ha',$h->ha);
              $horasc->put('Autorizada',$h->autorizada);
              $horast->push($horasc);
          }
          $dia->put('Horas',$horast);
        //dd($dia);
        return view('tablah2',[
            'dia' => $dia,
            'ndia' => $datos->dias_id
        ]);
    }
    public function delete(Request $request){
        //dd($request);
        if ($request->tipo == 1){
            $orden = Planificacion::where('id',$request->id)->first()->ordenes_id;
            $p=Planificacion::where('id',$request->id)->delete();
            $datos = Planificacion::where('ordenes_id',$orden)->where('dias_id',$request->diaid)->get();
            return view('tablap',[
                'datos' => $datos
            ]);
        }
        if ($request->tipo == 2){
            $orden = Ejecucion::where('id',$request->id)->first()->ordenes_id;
            $e=Ejecucion::where('id',$request->id)->delete();
            $datos = Ejecucion::where('ordenes_id',$orden)->where('dias_id',$request->diaid)->get();
            return view('tablae',[
                'datos' => $datos
            ]);
        }
        if ($request->tipo == 3){
            $orden = Hora::where('id',$request->id)->first()->ordenes_id;
            $h=Hora::where('id',$request->id)->delete();
            $datos = Hora::where('ordenes_id',$orden)->where('dias_id',$request->diaid)->get();
            return view('tablah',[
                'datos' => $datos
            ]);
        }
    }
//programacion
    public function nuevaprog(Request $request){
        $hi = $request->hi.":".$request->mi;
        $hf = $request->hf.":".$request->mf;
        //dd($hi." ".$hf);
        $extra=0;
        if($request->extra){
            $extra=1;
        }
        $grupo = Empleado::where('cc',$request->cc)->first()->ciudad;
        //dd($grupo);

        $existe = Programacion::where('cc',$request->cc)
                              ->where('fecha',$request->fecha)
                              ->where('proyecto',$request->proyecto)
                              ->where('hi',$hi)
                              ->where('hf',$hf)
                              ->exists();

        if($existe){
            return "Programacion ya existe";
        }
        else{
            $p = Programacion::create([
                'cc' => $request->cc,
                'fecha' => $request->fecha,
                'proyecto' => $request->proyecto,
                'responsable' => $request->responsable,
                'observacion' => $request->observaciones,
                'hi' => $hi,
                'hf' => $hf,
                'grupo' => $grupo  ,
                'extra' => $extra
            ]);
        // dd($p);
            return "Programacion creada";
        }
    }
    public function actgprog(){
        $prog = Programacion::all();
        foreach($prog as $p){
            $grupo = Empleado::where('cc',$p->cc)->first()->ciudad;
            $p = Programacion::where('id',$p->id)->update([
                'grupo' => $grupo
            ]);
        }
        return 'Programacion actualizada';
    }
    public function tablaprog(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $prog = Programacion::orderBy('fecha','asc')->get();
        }
        else{
            $prog = Programacion::orderBy($campo,'asc')->get();
        }
        return view('tablaprog',[
            'prog' => $prog,
        ]);
    }
    public function filtrarprog(Request $request){

        $prog =  Programacion::orderBy('fecha','asc');


        if ($request->filtrocc !=""){
            $prog = $prog->where('programacion.cc',$request->filtrocc );
        }
        if (($request->filtrofecha1 !="")&&($request->filtrofecha2 !="")){
            $prog = $prog->where('fecha','>=',$request->filtrofecha1)->where('fecha','<=',$request->filtrofecha2);
        }
        if ($request->filtroproyecto !=""){
            $prog = $prog->where('proyecto',$request->filtroproyecto );
        }
        if ($request->filtroresp !=""){
            $prog = $prog->where('responsable',$request->filtroresp );
        }
        if ($request->filtrociudad !=""){
            $prog = $prog->where('grupo',$request->filtrociudad );
        }
        $prog = $prog->orderBy('fecha','asc')->get();
        $estados = collect([]);
        $dato=array();
            foreach($prog as $p){

                /*$dato[$p->id]=1;
                $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)
                ->where('dias.fecha',$p->fecha)->exists();
                if($o){
                    $dato[$p->id] = 2;
                }
                $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)
                ->where('dias.fecha',$p->fecha)->where('ordenes.autorizada_por','<>',0)->exists();
                if($o){
                    $dato[$p->id] = 3;
                }*/
                $a=$pl=$e=$h=False;
                $dato[$p->id]=1;
                $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)->where('dias.fecha',$p->fecha)->exists();
                if($o){
                    //dd(DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)->where('dias.fecha',$p->fecha)->first());
                    $data=DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)->where('dias.fecha',$p->fecha)->first();
                    $oid = $data->ordenes_id;
                    $did = $data->id;
                    $pl = Planificacion::where('ordenes_id',$oid)->exists();
                    $e = Ejecucion::where('ordenes_id',$oid)->exists();
                    $h = Hora::where('ordenes_id',$oid)->exists();
                    $a=true;
                    $hrs = Hora::where('ordenes_id',$oid)->where('dias_id',$did)->get();
                    //dd($hrs);
                    foreach($hrs as $hx){
                        if ($hx->ha ==0){
                            $a=false;
                        }
                    }
                }

                //dd($pl." ".$e." ".$h." ".$a);
                if($o && $pl){
                    $dato[$p->id] = 2;
                }
                if($o && $pl && $e && $h){
                    $dato[$p->id] = 3;
                }

                /*$o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.proyecto',$p->proyecto)
                ->where('dias.fecha',$p->fecha)->where('ordenes.autorizada_por','<>',0)->exists();*/

                if($a && $p && $e && $h){
                    $dato[$p->id] = 4;
                }
                $estados->push($dato);

            }
        return view('tablaprog',[
            'prog' => $prog,
            'dato' => $dato
        ]);
    }
    public function calendarioprog(Request $request){
        $prog =  DB::table('programacion');

        if ($request->filtrocc !=""){
            $prog = $prog->where('programacion.cc',$request->filtrocc );
        }
        if (($request->filtrofecha1 !="")&&($request->filtrofecha2 !="")){
            $prog = $prog->where('fecha','>=',$request->filtrofecha1)->where('fecha','<=',$request->filtrofecha2);
        }
        if ($request->filtroproyecto !=""){
            $prog = $prog->where('proyecto',$request->filtroproyecto );
        }
        if ($request->filtroresp !=""){
            $prog = $prog->where('responsable',$request->filtroresp );
        }
        if ($request->filtrociudad !=""){
            $prog = $prog->where('grupo',$request->filtrociudad );
        }

        $cedulas = $prog->groupby('cc')->get(['cc']);
        //dd($cedulas);

        if (($request->filtrofecha1 !="")&&($request->filtrofecha2 !="")){
            $fechas=DB::table('programacion')->where('fecha','>=',$request->filtrofecha1)->where('fecha','<=',$request->filtrofecha2)->groupby('fecha')->get(['fecha']);
        }
        else{
            $fechas=DB::table('programacion')->groupby('fecha')->get(['fecha']);
        }
        //dd($fechas);
        $calendario = collect([]);
        foreach($cedulas as $c){
            $linea = collect([]);
            foreach ($fechas as $f){

                $e = Empleado::where('cc',$c->cc)->first();

                $nombre= $e->nombre. " ". $e->apellido1;

                $p = Programacion::where('cc',$c->cc)->where('fecha',$f->fecha)->first();


                $col = collect([]);
                if($p){
                    $re = Empleado::where('id',$p->responsable)->first();
                    $responsable = $re->nombre. " ". $re->apellido1;
                    $col->put('fecha',$f->fecha);
                    $col->put('nombre',$nombre);
                    $col->put('proyecto',$p->proyecto."-".$p->datosproyecto->cliente->cliente );
                    $col->put('responsable',$responsable);
                    $col->put('inicio',$p->hi);
                    $col->put('fin',$p->hf);
                    $col->put('observacion',$p->observacion);
                    $col->put('grupo',$p->grupo);
                    }
                else{
                    $col->put('fecha','');
                    $col->put('nombre','');
                    $col->put('proyecto','');
                    $col->put('responsable','');
                    $col->put('inicio','');
                    $col->put('fin','');
                    $col->put('observacion','');
                    $col->put('grupo','');

                }
                //dd($col);
                $linea->push($col);

            }
            $calendario->push($linea);
        }


       // dd($calendario);



        return view('calendarioprog',[
            'calendario' => $calendario,
        ]);
    }
    public function calendariooc(Request $request){
        $user = session('user');
        if ($user==""){
            return redirect()->route('inicio');
        }
        $cc =  Empleado::where('id',$user)->first()->cc;
        $oc =  DB::table('ocupacion')->where('cc',$cc);


        if (($request->fechaInicioOcup !="")&&($request->fechaFinalOcup !="")){
            $oc = $oc->where('dia','>=',$request->fechaInicioOcup)->where('dia','<=',$request->fechaFinalOcup);
        }


        $ocs = $oc->get();
        //dd($ocs);



        $calendario  = collect([]);

        $inicio = new Carbon($request->fechaInicioOcup);
        $fin = new Carbon($request->fechaFinalOcup);

        while ($inicio <= $fin){

            $col = collect([]);

            $col->put('fecha',$inicio->toDateString());
            $col->put('registro','');

            $oc = Ocupacion::where('cc',$cc)->where('dia','=',$inicio)->count();

            if ($oc>0){
                $totalh=0;
                $registros= ocupacion::where('cc',$cc)->where('dia',$inicio)->get();
                foreach($registros as $r){
                    $totalh = $totalh + $r->horas + ($r->minutos/60);
                }
                $msg='OK Horas='.$totalh;
                $col->put('registro',$msg);
            }
            else{
                $col->put('registro','SR');
            }

            $calendario->push($col);
            $inicio = $inicio->addDay();

        }
        //dd($calendario);




       // dd($calendario);



        return view('calendariooc',[
            'calendariooc' => $calendario,
        ]);
    }

    public function filtrarcentro(Request $request){

        $cdc =  Cdc::orderBy('codigo','asc');

        if ($request->fcodigo !=""){
            $cdc = $cdc->where('codigo',$request->fcodigo );
        }
        if ($request->fresponsable !=""){
            $cdc = $cdc->where('responsable','like' ,'%'.$request->fresponsable.'%');
        }

        $cdc = $cdc->get();
        return view('tablacdc',[
            'cdc' => $cdc,
        ]);
    }
    public function buscarprog(Request $request){
        $p = Programacion::where('id',$request->id)->first();
        $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        $cdc = Cdc::all();
        $clientes = Cliente::orderBy('cliente','asc')->get();
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        $hi = explode(":", $p->hi);
        $hf = explode(":",$p->hf);
        return view('formprog',[
            'emp' => $emp,
            'cdc' => $cdc,
            'clientes' => $clientes,
            'proyectos' => $proyectos,
            'datos' => $p,
            'hi' => $hi,
            'hf' => $hf,
        ]);
    }
    public function consprog(Request $request){
        //dd($request);
        if(!Programacion::where('cc',$request->cc)->where('fecha',$request->fecha)->where('proyecto',$request->proyecto)->exists()){
            return 'No existe programación';
        }
        $p = Programacion::where('cc',$request->cc)->where('fecha',$request->fecha)->where('proyecto',$request->proyecto)->first();
        //dd($p);
        $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        $cdc = Cdc::all();
        $clientes = Cliente::orderBy('cliente','asc')->get();
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        $hi = explode(":", $p->hi);
        $hf = explode(":",$p->hf);
        return view('formprog',[
            'emp' => $emp,
            'cdc' => $cdc,
            'clientes' => $clientes,
            'proyectos' => $proyectos,
            'datos' => $p,
            'hi' => $hi,
            'hf' => $hf,
        ]);
    }
    public function eliminarprog(Request $request){
        Programacion::where('id', $request->id )->delete();
        return "Programación eliminada";
    }

//empleado
    public function nuevoemp(Request $request){
        // dd('sdfsd');
        // validate $request
        $validated = $request->validate([
            'cc' => 'required|unique:empleados,cc',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'nombre' => 'required',
            'auxilio' => 'required|numeric',
            'auxiliot' => 'required|numeric',
            'correo' => 'required|email|unique:empleados',
            'tipo' => 'required|numeric',
            'ciudad' => 'required',
            'horario' => 'required|exists:horarios,id',
            'area' => 'required|exists:areas,id',
            'cargo' => 'required|exists:cargos,id',
            'extra_names.*' => 'required',
            'extra_values.*' => 'required|numeric',
        ]);

        $e = Empleado::create([
            'cc' => $request->cc,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'nombre' => $request->nombre,
            'auxilio' => $request->auxilio,
            'auxiliot' => $request->auxiliot,
            'correo' => $request->correo,
            'tipo' => $request->tipo,
            'ciudad' => strtoupper($request->ciudad),
            'horario_id' => $request->horario,
            'area' => $request->area,
            'cargo'=> $request->cargo,
            'password' => bcrypt($request->cc)
        ]);

        if ($request->extra_names && $request->extra_values) {
            $extra_names = collect($request->extra_names);
            $extra_values = collect($request->extra_values);

            foreach ($extra_names as $key => $value) {
                AuxilioExtras::create([
                    'empleado_id' => $e->id,
                    'list_auxilio_extra_id' => intval($value),
                    'valor' => $extra_values[$key]
                ]);
            }
        }

        return response()->json([
            'message' => 'Empleado creado correctamente',
            'data' => $e
        ]);
    }

    public function nuevocorte(Request $request){
        // validate $request
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required',
        ]);

        // user loged
        $user = session('user');
        // create corte and saver user_id auditable
        $c = Corte::create([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'message' => 'Corte creado correctamente',
            'data' => $c
        ]);
    }
    public function tablacorte(Request $request){
        $cortes = Corte::all();
        return view('admin.tabla.corteTabla',[
            'cortes' => $cortes,
        ]);
    }
    public function editaremp(Request $request){
        // validate $request
        $validated = $request->validate([
            'id' => 'required|numeric|exists:empleados,id',
            'cc' => 'required|unique:empleados,cc,'.$request->id,
            'apellido1' => 'required',
            'nombre' => 'required',
            'auxilio' => 'required|numeric',
            'auxiliot' => 'required|numeric',
            'correo' => 'required|email|unique:empleados,correo,'.$request->id,
            'tipo' => 'required|numeric',
            'ciudad' => 'required',
            'horario' => 'required|exists:horarios,id',
            'area' => 'required|exists:areas,id',
            'cargo' => 'required|exists:cargos,id',
            'extra_names.*' => 'required',
            'extra_values.*' => 'required|numeric',
        ]);

        $e = Empleado::where('id', $request->id )->first();

        $e->update([
            'cc' => $request->cc,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'nombre' => $request->nombre,
            'auxilio' => $request->auxilio,
            'auxiliot' => $request->auxiliot,
            'correo' => $request->correo,
            'ciudad' => $request->ciudad,
            'horario_id' => $request->horario,
            'tipo' => $request->tipo,
            'area' => $request->area,
            'cargo' => $request->cargo
        ]);

        $e->auxilio_extras()->delete();

        if ($request->extra_names && $request->extra_values) {
            $extra_names = collect($request->extra_names);
            $extra_values = collect($request->extra_values);

            foreach ($extra_names as $key => $value) {
                AuxilioExtras::create([
                    'empleado_id' => $e->id,
                    'list_auxilio_extra_id' => intval($value),
                    'valor' => $extra_values[$key]
                ]);
            }
        }

        return response()->json([
            'message' => 'Empleado actualizado correctamente',
            'data' => $e
        ]);
    }

    public function updatep(Request $request){
        // validate $request
        $validated = $request->validate([
            'empleado_id' => 'required|numeric|exists:empleados,id',
            'password' => 'required|min:6',
        ]);

        Empleado::where('id', $request->empleado_id )
        ->update([
            'password' => bcrypt($request->password)
          ]);

        return response()->json([
            'message' => 'Contraseña actualizada correctamente',
        ]);
    }

    public function eliminaremp(Request $request){
        Empleado::where('id', $request->id )
        ->update([
            'estado' =>0
          ]);

        return response()->json([
            'message' => 'Empleado eliminado correctamente',
        ]);
    }

    public function modalEmpleadoAcciones(Request $request){
        $accion = $request->accion;

        switch ($accion) {
            case 1:
                $horarios = Horario::all();
                $areas = Area::all();
                $cargos = Cargo::where('estado', 1)->get();
                $list_of_extras = ListAuxilioExtras::all();

                return view('admin.modal.empleadoModal',[
                    'accion' => 1,
                    'horarios' => $horarios,
                    'areas' => $areas,
                    'cargos' => $cargos,
                    'list_of_extras' => $list_of_extras
                ]);
                break;
            case 2:
                $empleado = Empleado::where('id', $request->empleado_id)->first();
                $horario=$idh="";
                $horarios = Horario::all();
                $areas = Area::all();
                $cargos = Cargo::where('estado', 1)->get();
                $list_of_extras = ListAuxilioExtras::all();

                if ($empleado->horario_id !=0){
                    $horario =  $empleado->horario->nombre;
                    $idh = $empleado->horario->id;
                }
                $area = $empleado->narea->area;
                $cargo = $empleado->ncargo? $empleado->ncargo->cargo: null;

                return view('admin.modal.empleadoModal',[
                    'empleado' => $empleado,
                    'accion' => $accion,
                    'horarios' => $horarios,
                    'horario' => $horario,
                    'idh' => $idh,
                    'areas' => $areas,
                    'area' => $area,
                    'cargo' => $cargo,
                    'cargos' => $cargos,
                    'list_of_extras' => $list_of_extras,
                ]);
                break;
            case 3:
                return view('admin.modal.empleadoModal',[
                    'accion' => 3,
                    'empleado_id' => $request->empleado_id,
                ]);
                break;
            case 4:
                return view('admin.modal.empleadoModal',[
                    'accion' => 4,
                    'empleado_id' => $request->empleado_id,
                ]);
                break;
            default:
                break;
        }
    }

    public function modalProyectoAcciones(Request $request){
        $accion = $request->accion;

        switch ($accion) {
            case 2:
                $proyecto = Proyecto::where('id',$request->proyecto_id)->first();
                $empleados = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
                $clientes = Cliente::orderBy('cliente','asc')->get();
                return view('admin.modal.proyectoModal',[
                    'accion' => 2,
                    'proyecto' => $proyecto,
                    'empleados' => $empleados,
                    'clientes' => $clientes,
                ]);
                break;
            case 3:
                $proyecto = Proyecto::where('id',$request->proyecto_id)->first();
                return view('admin.modal.proyectoModal',[
                    'accion' => 3,
                    'proyecto' => $proyecto,
                ]);
                break;
            case 4:
                $idproy = Proyecto::where('id',$request->proyecto_id)->first()->codigo;
                $autorizados = Autorizados::where('proyecto',$idproy)->get();
                $empleados = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();

                return view('admin.modal.proyectoModal',[
                    'accion' => 4,
                    'autorizados' => $autorizados,
                    'empleados' => $empleados,
                    'proyecto_id' => $request->proyecto_id,
                ]);
                break;
            default:
                break;
        }
    }

    public function modalCortesAcciones(Request $request){
        $accion = $request->accion;

        switch ($accion) {
            case 1:
                return view('admin.modal.corteModal',[
                    'accion' => 1,
                ]);
                break;
            case 4:
                $corte = Corte::where('id',$request->corte_id)->first();
                return view('admin.modal.corteModal',[
                    'accion' => 4,
                    'corte' => $corte,
                ]);
                break;
            default:
                break;
        }
    }

    public function togleHabilitarCorte(Request $request){
        $corte = Corte::where('id', $request->corte_id )->get()->first();
        $corte->update([
            'estado' => !$corte->estado,
        ]);

        return response()->json([
            'message' => $corte->estado? 'Corte habilitado' : 'Corte cerrado'
        ]);
    }

    public function tablaemp(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        }
        else{
            $emp = Empleado::where('estado',1)->orderBy($campo,'asc')->get();
        }
        return view('admin.tabla.empleadoTabla',[
            'emp' => $emp,
        ]);
    }


//cdc

    public function nuevocdc(Request $request){
        $e = Cdc::create([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'centro_operacion' => $request->co,
            'unidad_negocio' => $request->un,
            'responsable' => $request->responsable,
            'mayor' => $request->mayor,
            'grupo' => $request->grupo,
            'observaciones' => $request->observaciones,

        ]);

        return "Centro creado";
    }
    public function buscarcdc(Request $request){
        $c = Cdc::where('id',$request->id)->first();
        return view('formcdc',[
            'datos' => $c
        ]);
    }
    public function editarcdc(Request $request){
        Cdc::where('id', $request->id )
        ->update([
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'centro_operacion' => $request->co,
            'unidad_negocio' => $request->un,
            'responsable' => $request->responsable,
            'mayor' => $request->mayor,
            'grupo' => $request->grupo,
            'observaciones' => $request->observaciones,
        ]);
        return "Centro actualizado";
    }
    public function eliminarcdc(Request $request){
        Cdc::where('id', $request->id )->delete();
        return "Centro eliminado";
    }
    public function tablacdc(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $cdc = Cdc::all();
        }
        else{
            $cdc = Cdc::orderBy($campo,'asc')->get();
        }
        return view('tablacdc',[
            'cdc' => $cdc,
        ]);
    }
    public function updatepwd(){
        $emps = Empleado::where('password','')->get();
        $cont =0;
        foreach($emps as $e){
            Empleado::where('id',$e->id)->update([
                'password' => bcrypt($e->cc)
            ]);
            $cont++;
        }
        return 'operacion realizada '.$cont;
    }
    public function editarprog(Request $request){
        $hi = $request->hi.":".$request->mi;
        $hf = $request->hf.":".$request->mf;

        Programacion::where('id', $request->id )
        ->update([
            'cc' => $request->cc,
            'fecha' => $request->fecha,
            'proyecto' => $request->proyecto,
            'responsable' => $request->responsable,
            'observacion' => $request->observaciones,
            'hi' => $hi,
            'hf' => $hf
        ]);
        return "Programación actualizada";
    }

    public function ocupacion(){
        $user_id = session('user');
        if ($user_id==""){
            return redirect()->route('inicio');
        }

        $areas = Area::all(['id','area']);
        $actividades = Actividad::all(['id','actividad']);
        $proyectos = Proyecto::select('id', 'codigo', 'cliente_id')->with(['cliente' => function ($query) {
            $query->select('cliente', 'id');
        }])->orderBy('codigo','asc')->get();
        // $proyectos = Proyecto::all();
        $area = Empleado::where('id',$user_id)->first()->area;
        $novedades=Novedad::all();
        $employees = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();

        // dd($proyectos);
        return view('ocupacion',[
            'areas' => $areas,
            'actividades' => $actividades,
            'proyectos' => $proyectos,
            'area' => $area,
            'novedades' => $novedades,
            'emp' => $employees

        ]);
    }

    public function consfestivo(Request $request){
        $fecha = $request->fecha;
        if (Festivo::where('fecha',$fecha)->exists()){
            return 'si';
        }
        return 'no';
    }

    public function generalo(Request $request){
        $area = $request->area;
        $oc =  Ocupacion::where('id','>',0);

        if ($area!=""){
            $oc = $oc->where('area',$area);
        }
        if($request->responsable!=""){
            $oc = $oc->where('cc',$request->responsable);
        }
        if (($request->fechaInicioOcup1 !="")&&($request->fechaFinalOcup1 !="")){
            $oc = $oc->where('dia','>=',$request->fechaInicioOcup1)->where('dia','<=',$request->fechaFinalOcup1);
        }

        $ocs = $oc->orderBy('dia','asc')->orderBy('area','asc')->get();
        //dd($ocs);
        return view('generalo',[
            'ocs' => $ocs,
        ]);
    }

    public function buscarinfooc(Request $request){
        $user = session('user');

        if ($user==""){
            return redirect()->route('inicio');
        }

        $fecha = $request->fecha;
        $date_carbon = new Carbon($fecha);
        $hours_per_day = $date_carbon->dayOfWeek == 5 ? 8.5 : 9.5;

        $cc = Empleado::where('id',$user)->first()->cc;
        $hoc = Ocupacion::where('cc',$cc)->where('dia','=',$fecha)->sum('horas');
        $moc = Ocupacion::where('cc',$cc)->where('dia','=',$fecha)->sum('minutos');

        $restantes=$hours_per_day-($hoc + $moc/60);

        return "Faltan ".$restantes." horas por reportar este día";
    }

    public function distribuciono(Request $request){

        $datos = $this->getDatosDistribucionO($request);

        //$datos2 = $datos2->sortBy(['codigo del empleado','fecha movimiento']);
        //dd($datos2);
        return view('tablan2',[
            'datos' => $datos[0],
            'total' => $datos[1],
        ]);
    }
    public function getDatosDistribucionO(Request $request){
        $area = $request->area;
        $responsable = $request->responsable;

        if ($area != ""){
            $emp = Empleado::where('estado',1)->where('area',$area)->orderBy('cc','asc')->get();
        }
        else{
            $emp = Empleado::where('estado',1)->where('area','>',1)->orderBy('area','asc')->orderBy('cc','asc')->get();
        }

        if ($responsable!=""){
            $emp = Empleado::where('cc',$responsable)->where('estado',1)->get();
        }

        $datos  = collect([]);

        $inicio = new Carbon($request->fechaInicioOcup1);
        $fin = new Carbon($request->fechaFinalOcup1);
        //dd($emp);
        $total=array();
        foreach($emp as $e){
            $inicio = new Carbon($request->fechaInicioOcup1);
            $fin = new Carbon($request->fechaFinalOcup1);
            $x="";
            $lapso="";
            while ($inicio <= $fin){
                $ocs = Ocupacion::where('cc',$e->cc)->where('dia','=',$inicio)->get();
                //dd($ocs);


                foreach ($ocs as $oc){
                    $centro = Cdc::where('codigo',$oc->proyecto)->first();
                    $totalh=$oc->horas + ($oc->minutos/60);
                    //Log::info($oc);
                    //Log::info($centro);
                    //Log::info($totalh);
                    $lapso=substr(str_replace("-","",$oc->dia),0,6);
                    $x=$x." ".$lapso;
                    //dd($lapso);
                    $linea = collect([]);

                    $linea->put('ID', '1');
                    $linea->put('ID TERCERO', $e->cc);
                    $linea->put('NDC', '');
                    $linea->put('LAPSO', $lapso);
                    $linea->put('UNIDADES', $totalh);
                    $linea->put('CENTRO OPERACION', $centro->centro_operacion);
                    $linea->put('CENTRO COSTOS', $centro->codigo);
                    $linea->put('ID PROYECTO', '');
                    $linea->put('ID UNIDAD DE NEGOCIO', $centro->unidad_negocio);
                    $linea->put('NOTAS', '');
                    /*$linea->put('codigo del empleado', $e->cc);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '001');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-","",$oc->dia));
                    $linea->put('horas', $totalh);
                    $linea->put('valor', '');
                    $linea->put('cantidad', '');
                    $linea->put('proyecto', '');
                    $linea->put('numero de contrato', '');
                    $linea->put('unidad de negocio', $centro->unidad_negocio);
                    $linea->put('fecha de causacion', '');
                    $linea->put('numero de cuotas', '');
                    $linea->put('notas', '');*/

                    $datos->push($linea);
                    Log::info($linea);
                    if (array_key_exists($e->cc, $total) ) {
                        $total[$e->cc]= $total[$e->cc] + $totalh;
                    }
                    else{
                        $total[$e->cc]= $totalh;
                    }



                }
                $inicio = $inicio->addDay();

            }
            //dd($lapso);
            if ($lapso!=""){
                $hl =240;
                if(Novedad::where('cc',$e->cc)->where('periodo',$lapso)->exists()){
                    $hl=Novedad::where('cc',$e->cc)->where('periodo',$lapso)->first()->horas;
                }
                $linea = collect([]);

                $linea->put('ID', '1');
                $linea->put('ID TERCERO', $e->cc);
                $linea->put('NDC', '');
                $linea->put('LAPSO', $lapso);
                $linea->put('UNIDADES',$hl- $total[$e->cc]);
                $linea->put('CENTRO OPERACION', '001');
                $linea->put('CENTRO COSTOS', '300001');
                $linea->put('ID PROYECTO', '');
                $linea->put('ID UNIDAD DE NEGOCIO', '999');
                $linea->put('NOTAS', '');
                $datos->push($linea);
            }

        }
       /* $datos2 = collect([]);
            foreach ($datos as $d){
                if ($d['codigo del concepto']=='001'){
                    $cc = $d['codigo del empleado'];
                    $horas = $d['horas'];
                    $emp=Empleado::where('cc',$cc)->first();

                    if ($emp->auxilio>0){

                        $auxilio= round(($emp->auxilio/$total[$cc])*$horas,1);
                        $linea=collect([]);


                        $linea->put('codigo del empleado',$cc);
                        $linea->put('sucursal', '');
                        $linea->put('codigo del concepto', '075');
                        $linea->put('centro de operacion', $d['centro de operacion']);
                        $linea->put('centro de costo', $d['centro de costo']);
                        $linea->put('fecha movimiento', $d['fecha movimiento']);
                        $linea->put('horas','');
                        $linea->put('valor', $auxilio);
                        $linea->put('cantidad', '');
                        $linea->put('proyecto', '');
                        $linea->put('numero de contrato', '');
                        $linea->put('unidad de negocio', $d['unidad de negocio']);
                        $linea->put('fecha de causacion', '');
                        $linea->put('numero de cuotas', '');
                        $linea->put('notas', '');
                        $datos2->push($linea);
                    }
                }
            }
           // dd($datos2);
            foreach ($datos2 as $d){
                $datos->push($d);
            }
        */
        $grouped = $datos->groupBy(['ID TERCERO', function ($item) {
            return $item['CENTRO COSTOS'];

        }], $preserveKeys = true);
        //dd($grouped->all());
        $grouped=$grouped->toArray();
        $datosn = collect([]);
        //dd($grouped);
        foreach ($grouped as $cc){

            foreach($cc as $py){
                $linea = collect([]);
                $totalpy = 0;
                foreach ($py as $detalle){
                    $cc=$detalle['ID TERCERO'];
                    $totalpy= $totalpy+ $detalle['UNIDADES'];
                    $pty =$detalle['CENTRO COSTOS'];
                    $lapso = $detalle['LAPSO'];
                    $centro = $detalle['CENTRO OPERACION'];
                    $unidad = $detalle['ID UNIDAD DE NEGOCIO'];
                }
                $linea->put('ID', '1');
                $linea->put('ID TERCERO', $cc);
                $linea->put('NDC', '');
                $linea->put('LAPSO', $lapso);
                $linea->put('UNIDADES', $totalpy);
                $linea->put('CENTRO OPERACION', $centro);
                $linea->put('CENTRO COSTOS', $pty);
                $linea->put('ID PROYECTO', '');
                $linea->put('ID UNIDAD DE NEGOCIO', $unidad);
                $linea->put('NOTAS', '');



                $datosn->push($linea);
            }


        }
        //dd($datosn);

        $datos = $datosn->sortBy(['ID TERCERO','LAPSO']);
        return [$datos,$total];
    }

    //horas extras
    public function authextra(Request $request){
        $p = Proyecto::where('codigo',$request->proyecto)->first();
        $e = Empleado::where('cc',$request->cc)->first();
        $autoriza=Empleado::whereIn('cargo',[23,26,30,37,38])->get();
        return view('formextra',[
            'p' => $p,
            'e' => $e,
            'fecha' => $request->fecha,
            'hi' => $request->hi,
            'hf' => $request->hf,
            'autoriza' => $autoriza
        ]);
    }
    public function nuevaextra(Request $request){
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        $autoriza = DB::table('empleados')->join('cargos','empleados.cargo','=','cargos.id')->where('cargos.extra',2)->get();
        $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();

        return view('formnuevaextra',[
           'proyectos' => $proyectos,
           'autoriza' => $autoriza,
           'emp' => $emp
        ]);
    }
    public function eliminarextra(Request $request){
        $extra = Autorizacion::where('id',$request->id)->delete();
        return true;
    }
    public function editarextra(Request $request){
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        $autoriza = DB::table('empleados')->join('cargos','empleados.cargo','=','cargos.id')->where('cargos.extra',2)->get();
        $emp = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        $extra = Autorizacion::where('id',$request->id)->first();

        $datos = array();
        $datos['id'] = $request->id;
        $ccs = $extra->trabajador;
            $ccs = explode(",", $ccs);
            $nombres = "";
            foreach($ccs as $cc){
                $e=Empleado::where('cc',$cc)->first();
                $nombre =$e->apellido1." ".$e->nombre;
                if ($nombres == "") {
                    $nombres.=$nombre;
                }
                else{
                    $nombres.=",".$nombre;
                }
            }
        $datos['nombres']=$nombres;

        $hh = explode("-",$extra->horario_habitual);
        //dd($hh);
        $hhi = explode(":",$hh[0]);
        $datos['hhi'] = $hhi[0];
        $datos['mhi'] = $hhi[1];

        $hhf = explode(":",$hh[1]);
        $datos['hhf'] = $hhf[0];
        $datos['mhf'] = $hhf[1];
        //dd($autoriza);
        //dd($datos['hhi']);

        $hi = explode(":",$extra->hora_inicio_extra);
        $datos['hi']=$hi[0];
        $datos['mi']=$hi[1];

        $hf = explode(":",$extra->hora_fin_extra);
        $datos['hf']=$hf[0];
        $datos['mf']=$hf[1];

        return view('formeditarextra',[
           'proyectos' => $proyectos,
           'autoriza' => $autoriza,
           'emp' => $emp,
           'extra' => $extra,
           'datos' => $datos

        ]);
    }
    public function saveextra(Request $request){


              //dd($request);

              $trabajadores = explode(",", trim($request->trabajador));

              /*foreach ($trabajadores as $t){
                $esta = Autorizacion::where('trabajador','like','%'.$t.'%')
                        ->where('fecha',$request->fecha)
                        ->count() ;
                if ($esta> 0){
                    $message = "Ya existe una solicitud para el trabajador con cc ".$t." el día ".$request->fecha;
                    return $message;
                }

              }*/



              $solicitado_por = session('user');
              if ($solicitado_por==""){
                return "Debes iniciar sesión de nuevo";
              }
              $p=Proyecto::where('codigo',$request->proyecto)->first();
              $autoriza = Empleado::where('cc',$request->autoriza)->first();
              //dd($autoriza->correo);
              $hie = $request->hi . ":" . $request->mi ;
              $hfe = $request->hf . ":" . $request->mf ;
              $hh =  $request->hhi . ":" . $request->mhi. "-". $request->hhf . ":" . $request->mhf ;
              $hi = explode(":", $hie);
              $hi_num =intval($hi[0]) + round(floatval($hi[1]/60),1);
              $hf = explode(":", $hfe);
              $hf_num =intval($hf[0]) + round(floatval($hf[1]/60),1);
              $total_horas = $hf_num - $hi_num;
              $extra = Autorizacion::create([

              'proyecto' => $request->proyecto,
              'trabajador'=> $request->trabajador,
              'motivo'=> $request->motivo,
              'horario_habitual' => $hh,
              'fecha' => $request->fecha,
              'hora_inicio_extra'=> $hie,
              'hora_fin_extra'=> $hfe,
              'total_horas' => $total_horas,
              'solicitado_por' => $solicitado_por,
              'autorizado_rechazado_por' => $autoriza->id,
              'fecha_solicitud' => date("Y-m-d")
            ]);
            //nombres
            $ccs = $extra->trabajador;
            $ccs = explode(",", $ccs);
            $nombres = "";
            foreach($ccs as $cc){
                $e=Empleado::where('cc',$cc)->first();
                $nombre =$e->apellido1." ".$e->nombre;
                if ($nombres == "") {
                    $nombres.=$nombre;
                }
                else{
                    $nombres.=",".$nombre;
                }
            }
            $extra->nombres=$nombres;
            //dd($extra);
            $details = [
                'title' => 'Solicitud de horas extras',
                'body' => "Ingresar a <a href='www.spectraoperaciones.com'>spectraoperaciones.com</a> para realizar la autorización"
            ];
            try{
               \Mail::to($autoriza->correo)->send(new \App\Mail\MailSolicitudExtra($details,$extra));
            }
            catch (QueryException $e) {
                return "Error al enviar correo a la persona que autoriza";
            }

            return "Formato de autorización registrado";

    }
    public function actextra(Request $request){
        try {

              //dd($request);

              $solicitado_por = session('user');
              if ($solicitado_por==""){
                return "Debes iniciar sesión de nuevo";
              }
              if ($request->trabajador == "NO"){
                 $trab = Autorizacion::where('id',$request->id)->first()->trabajador;
              }
              else{
                $trab = $request->trabajador;
              }

              $p=Proyecto::where('codigo',$request->proyecto)->first();
              $autoriza = Empleado::where('cc',$request->autoriza)->first();
              //dd($autoriza->correo);
              $hie = $request->hi . ":" . $request->mi ;
              $hfe = $request->hf . ":" . $request->mf ;
              $hh =  $request->hhi . ":" . $request->mhi. "-". $request->hhf . ":" . $request->mhf ;
              $hi = explode(":", $hie);
              $hi_num =intval($hi[0]) + round(floatval($hi[1]/60),1);
              $hf = explode(":", $hfe);
              $hf_num =intval($hf[0]) + round(floatval($hf[1]/60),1);
              $total_horas = $hf_num - $hi_num;
              $e = Autorizacion::where('id',$request->id)->update([

              'proyecto' => $request->proyecto,
              'trabajador'=> $trab,
              'motivo'=> $request->motivo,
              'horario_habitual' => $hh,
              'fecha' => $request->fecha,
              'hora_inicio_extra'=> $hie,
              'hora_fin_extra'=> $hfe,
              'total_horas' => $total_horas,
              'solicitado_por' => $solicitado_por,
              'autorizado_rechazado_por' => $autoriza->id,
              //'fecha_solicitud' => date("Y-m-d")
            ]);


            return "Formato de autorización actualizado";
          } catch (QueryException $e) {
              return $e;
          }
    }
    public function consextra(Request $request){
        $tipo = session('tipo');
        $user = session('user');
        //dd($user);
        $solicitar = DB::table('empleados')->where('empleados.id',$user)->join('cargos','empleados.cargo','=','cargos.id')->first();
        //dd($solicitar->extra);
        if ($user==""){
            return redirect()->route('inicio');
        }
        $area = Empleado::where('id',$user)->first()->area;
        if ($area==6){
            $extra = Autorizacion::orderBy('fecha','desc')->get();
        }
        else{
            $extra = Autorizacion::where('autorizado_rechazado_por',$user) ->orWhere('solicitado_por', $user)->orderBy('fecha','desc')->get();
        }

        $cont=0;
        foreach($extra as $e){
            $ccs = $e->trabajador;
            $ccs = explode(",", $ccs);
            $nombres = "";
            foreach($ccs as $cc){
                $e=Empleado::where('cc',$cc)->first();
                $nombre =$e->apellido1." ".$e->nombre;
                if ($nombres == "") {
                    $nombres.=$nombre;
                }
                else{
                    $nombres.=",".$nombre;
                }
            }
            $extra[$cont]->nombres=$nombres;
            $cont++;
        }
        //dd($extra);
        return view('extra',[
            'area' => $area,
            'extra' => $extra,
            'solicitar' => $solicitar->extra
        ]);
    }
    public function voboextra(Request $request){
       // $tipo = session('tipo');
        //$user = session('user');

        Autorizacion::where('id',$request->id)->update([
            'fecha_autorizacion_rechazo' => date("Y-m-d"),
            'observaciones' => $request->obs

        ]);
        $e = Autorizacion::where('id',$request->id)->first();
        $autoriza = Empleado::where('id',$e->solicitado_por)->first();
        $details = [
            'title' => 'Solicitud de horas extras - aprobada',
            'body' => "Se ha aprobado la solicitud de horas extras"
        ];

        \Mail::to($autoriza->correo)->send(new \App\Mail\MailSolicitudExtra($details,$e));
        return "Solicitud de tiempo extra aprobada";
    }
    public function rechazarextra(Request $request){
        // $tipo = session('tipo');
         //$user = session('user');
         $e = Autorizacion::where('id',$request->id)->first();
         $autoriza = Empleado::where('id',$e->solicitado_por)->first();
         Autorizacion::where('id',$request->id)->update([
            'fecha_autorizacion_rechazo' => date("Y-m-d"),
             'observaciones' => "RECHAZADA"

         ]);
         $e = Autorizacion::where('id',$request->id)->first();
         $autoriza = Empleado::where('id',$e->solicitado_por)->first();
         $details = [
            'title' => 'Solicitud de horas extras - rechazada',
            'body' => "Se ha rechazado la solicitud de horas extras"
        ];

        \Mail::to($autoriza->correo)->send(new \App\Mail\MailSolicitudExtra($details,$e));
         return "Solicitud de tiempo extra rechazada";
     }
    public function getDatosAnaliticas(Request $request){
        $area = $request->area;
        $oc =  Ocupacion::where('id','>',0);

        if ($area!=""){
            $oc = $oc->where('area',$area);
        }

        if (($request->fechaInicioOcup1 !="")&&($request->fechaFinalOcup1 !="")){
            $oc = $oc->where('dia','>=',$request->fechaInicioOcup1)->where('dia','<=',$request->fechaFinalOcup1);
        }
        $ocs = $oc->orderBy('dia','asc')->orderBy('area','asc')->get();
        //dd($ocs);

        $datos  = collect([]);
        foreach($ocs as $oc){
            $linea = collect([]);

            $linea->put('Fecha en la que se hizo el reporte', $oc->created_at);
            $linea->put('correo electrónico', '');
            $linea->put('Día reportado', $oc->dia);
            $linea->put('Area', $oc->narea->area);
            $linea->put('Funcionario que reporta', $oc->empleado->nombre . " " . $oc->empleado->apellido1);
            $linea->put('ID Proyecto', $oc->proyecto);
            $linea->put('Tiempo de ocupación en el proyecto(horas)', $oc->horas + ($oc->minutos/60) );
            $linea->put('Clasificación',  $oc->nactividad->actividad );
            $linea->put('Actividad', '');

            $datos->push($linea);
        }
        return $datos;
    }
    public function getDatosExtra(Request $request){
        $f1 = $request->fechaInicio;
        $f2 = $request->fechaFinal;
        if (($f1!="")&&($f2!="")){
            $datos = Autorizacion::where('fecha','>=',$f1)->where('fecha','<=',$f2)->orderBy('fecha','asc')->get();
        }


        $cont=0;
        $extras=collect([]);
        foreach ($datos as $d){
            $extra = collect([]);
            //proyecto	trabajador	motivo	fecha	horario habitual	hora inicio extra	hora fin extra	total horas	observaciones	autorizado_rechazado_por	solicitado_por	fecha_autorizacion_rechazo	fecha_solicitud	creada	actualizada	estado
            $extra->put('CC',$d->trabajador);

            $ccs = $d->trabajador;
            $ccs = explode(",", $ccs);
            $nombres = "";
            foreach($ccs as $cc){
                $e=Empleado::where('cc',$cc)->first();
                $nombre =$e->apellido1." ".$e->nombre;
                if ($nombres == "") {
                    $nombres.=$nombre;
                }
                else{
                    $nombres.=",".$nombre;
                }
            }

            $cont++;

            $extra->put('NOMBRE',$nombres);
            //$extra->put('NOMBRE',$d->ntrabajador->nombre." ".$d->ntrabajador->apellido1);
            $extra->put('MOTIVO',$d->motivo);
            $extra->put('FECHA',$d->fecha);
            $extra->put('HORARIO HABITUAL',$d->horario_habitual);
            $extra->put('HORA INICIO EXTRA',$d->hora_inicio_extra);
            $extra->put('HORA FIN EXTRA',$d->hora_fin_extra);
            $extra->put('TOTAL HORAS',$d->total_horas);
            $extra->put('PROYECTO',$d->proyecto);
            $extra->put('SOLICITADO POR',$d->nsolicita->nombre." ".$d->nsolicita->apellido1);
            $extra->put('FECHA SOLICITUD',$d->fecha_solicitud);
            $extra->put('AUTORIZADO/RECHAZADO POR',$d->ndirector->nombre." ".$d->ndirector->apellido1);
            $extra->put('FECHA AUTORIZACION/RECHAZO',$d->fecha_autorizacion_rechazo);
            $extra->put('ESTADO',$d->fecha_autorizacion_rechazo);
            if ($d->observaciones !="RECHAZADA"){
                $extra->put('ESTADO',"APROBADA");
            }
            else{
                $extra->put('ESTADO',"RECHAZADA");
            }

            /*
            $d->trabajador=$d->trabajador."-".$d->ntrabajador->nombre." ".$d->ntrabajador->apellido1;
            $d->solicitado_por = $d->nsolicita->nombre." ".$d->nsolicita->apellido1;
            $d->autorizado_rechazado_por= $d->ndirector->nombre." ".$d->ndirector->apellido1;
            if ($d->observaciones !="RECHAZADA"){
                $d->estado="APROBADA";
            }
            else{
                $d->estado="RECHAZADA";
            }*/
            $extras->push($extra);
        }

        //dd($extras);
        return $extras;
    }
    public function deleteOcupacion(Request $request){
        try{
            Ocupacion::where('id',$request->ocupacion_id)->delete();
            return "Registro eliminado. Refresque su búsqueda para ver el listado actualizado";
        } catch (QueryException $e) {
            return "Error al eliminar el registro";
        }
    }

    // v2
    public function passwordRecovery(){
        return view('auth.passwordRecovery');
    }

    public function updatePassword(){
        return view('auth.passwordUpdate');
    }
}
