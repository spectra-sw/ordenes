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

class PagesController extends Controller
{
    //
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
        $h = Hora::create([
            'ordenes_id' => $request->id,
            'dias_id' => $request->diaid,
            'hi' => $hi,
            'hf' => $hf,
            'ht' => $request->ht,
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
}
