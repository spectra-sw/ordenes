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

class PagesController extends Controller
{
    //
    public function inicio(){
        
        return view('menu');
    }
    public function bases(){
        $emp = Empleado::orderBy('apellido1','asc')->get();
        $cdc = Cdc::all();
        return view('bases',[
            'emp' => $emp,
            'cdc' => $cdc
        ]);
    }
    public function admin(){
        return view('admin');
    }
    public function consultas(){
        return view('consultas',[
            'header' => 'Consulta de órdenes'
        ]);
    }
    public function ordenes(){
        return view('ordenes');
    }
    public function getConsec(){
        $total=Orden::all()->count();
        if ($total == 0){
            return "00001";
        } 
        else{
            $id = Orden::orderBy('created_at','desc')->first()->id;
            $id+=1;
            return "0000".$id;
        }      
    }
    public function agregardia(Request $request){
        $d = Dia::create([
            'ordenes_id' => $request->id,
            'fecha' => date('Y-m-d'),
            'observacion' => ''
        ]);
        
        return $d->id;
        
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
        $d=Dia::where('id', $request->diaid) 
          ->update(['fecha' => $request->fecha,
                    'observacion' => $request->observaciond]);
        return 'Información del día almacenada';
    }
    public function saveorden(Request $request){
        $tipo="";
        if ($request->filled('cctv')) {
            if($tipo==""){ $tipo= "cctv";}
            else{ $tipo= $tipo." cctv";}    
        }
        if ($request->filled('incendio')) {
            if($tipo==""){ $tipo= "incencio";}
            else{ $tipo= $tipo." incencio";}    
        }
        if ($request->filled('cabl.estr')) {
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
            if($tipo==""){ $tipo= "integración";}
            else{ $tipo= $tipo." integración";}    
        }
        if ($request->filled('documentacion')) {
            if($tipo==""){ $tipo= "documentacion";}
            else{ $tipo= $tipo." documentacion";}    
        }


        $objeto="";
        if ($request->filled('instalacion')) {
            if($objeto==""){ $objeto= "instalacion";}
            else{ $objeto= $objeto." instalacion";}    
        }
        if ($request->filled('Mnto.Prev')) {
            if($objeto==""){ $objeto= "Mnto.Prev";}
            else{ $objeto= $objeto." Mnto.Prev";}    
        }
        if ($request->filled('Trab.Int')) {
            if($objeto==""){ $objeto= "Trab.Int";}
            else{ $objeto= $objeto." Trab.Int";}    
        }
        if ($request->filled('revision')) {
            if($objeto==""){ $objeto= "revision";}
            else{ $objeto= $objeto." revision";}    
        }
        
        
        $o = Orden::create([
            'proyecto' => $request->proyecto,
            'fecha_inicio' => $request->fechaInicio,
            'fecha_final' => $request->fechaFinal,
            'responsable' => $request->responsable,
            'cliente' => $request->cliente,
            'area_trabajo' => $request->area,
            'contacto' => $request->contacto,
            'tipo' => $tipo,
            'objeto' => $objeto,
            'observaciones' => $request->observacionesg  ,
            'autorizada_por' => 0,
            'creada_por' => 0   
        ]);

        return "Orden de trabajo almacenada";
    }
    public function verorden($id){
        //dd($id);
        $ordenes = Orden::where('id',$id)->get();
        //dd($ordenes);
        $dias = Dia::where('ordenes_id')->get();
        $h = Hora::where('ordenes_id')->get();
        $diasc = collect([]);
        foreach($ordenes as $o){
           // dd($o['id']);
            $dias = Dia::where('ordenes_id',$o['id'])->get();
            foreach($dias as $d){
                //dd($d);
                $dia = collect([]);
                $dia->put('id',$d['id']);
                $dia->put('fecha',$d['fecha']);
                $dia->put('observacion',$d['observacion']);
                $horas = Hora::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();      
                $horast=collect([]);
                foreach($horas as $h){
                    $horasc=collect([]);
                    $horasc->put('id',$h->id);
                    $horasc->put('Trabajador',$h->trabajador);
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
        return view('verorden',[
            'o' => $o,
            'dias' => $diasc,
        ]
        );
    }
    public function autorizadas(Request $request){
        $datos = Hora::where('id', $request->id) ->first();
        
        $h=Hora::where('id', $request->id) 
          ->update(['ha' => $request->valor]);

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
              $horast->push($horasc);
          }
          $dia->put('Horas',$horast);
        //dd($dia);
        return view('tablah2',[
            'dia' => $dia, 
            'ndia' => $datos->dias_id
        ]);
    }
    public function del(Request $request){
        if ($request->tipo == 1){
            $orden = Planificacion::where('id',$request->id)->first()->ordenes_id;
            $p=Planificacion::where('id',$request->id)->delete();
            $datos = Planificacion::where('ordenes_id',$orden)->get();
            return view('tablap',[
                'datos' => $datos
            ]);
        }
        if ($request->tipo == 2){
            $orden = Ejecucion::where('id',$request->id)->first()->ordenes_id;
            $e=Ejecucion::where('id',$request->id)->delete();
            $datos = Ejecucion::where('ordenes_id',$orden)->get();
            return view('tablae',[
                'datos' => $datos
            ]);
        }
        if ($request->tipo == 3){
            $orden = Hora::where('id',$request->id)->first()->ordenes_id;
            $h=Hora::where('id',$request->id)->delete();
            $datos = Hora::where('ordenes_id',$orden)->get();
            return view('tablah',[
                'datos' => $datos
            ]);
        }
    }
}
