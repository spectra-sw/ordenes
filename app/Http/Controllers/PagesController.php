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
        session(['user' => '']);
        session(['tipo' => 3]);
        return view('login');
    }
    public function login(){
        session(['user' => '']);
        session(['tipo' => 3]);
        return view('login');

    }
    public function menu(){
        $tipo = session('tipo');
        //dd($tipo);
        if ($tipo ==0){
            return view('menu');
        }
        else{
            return view('login');
        }

    }
    public function bases(){
        $tipo = session('tipo');
        //dd($tipo);
        if ($tipo ==0){
            $emp = Empleado::orderBy('apellido1','asc')->get();
            $cdc = Cdc::all();
            return view('bases',[
                'emp' => $emp,
                'cdc' => $cdc
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
        if (($tipo ==0)){
            return view('consultas',[
                'header' => 'Consulta de órdenes'
            ]);
        }
        else{
            return view('login');
        }
       
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
            $o = Orden::create([
                'proyecto' => $id
            ]);
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

        if (Hora::where('ordenes_id',$request->id)->where('dias_id',$request->diaid)->exists()){   

            $d=Dia::where('id', $request->diaid) 
            ->update(['fecha' => $request->fecha,
                        'observacion' => $request->observaciond]);
            $datos = Dia::where('ordenes_id',$request->id)->get();
            return view('tablad',[
                'datos' => $datos
            ]);
        }
        else{
            return 'no';
        }
        //return 'Información del día almacenada';
    }
    public function saveorden(Request $request){
        $id = $request->id;

        if (Dia::where('ordenes_id',$id)->exists()){   

            $tipou = session('tipo');
            $creada = 0;
            if ($tipou !=3){
                $creada = session('user');
            }

        $tipo="";
        if ($request->filled('cctv')) {
            if($tipo==""){ $tipo= "cctv";}
            else{ $tipo= $tipo." cctv";}    
        }
        if ($request->filled('incendio')) {
            if($tipo==""){ $tipo= "incencio";}
            else{ $tipo= $tipo." incencio";}    
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
            if($tipo==""){ $tipo= "integración";}
            else{ $tipo= $tipo." integración";}    
        }
        if ($request->filled('documentacion')) {
            if($tipo==""){ $tipo= "documentacion";}
            else{ $tipo= $tipo." documentacion";}    
        }
        
        if ($tipo==""){
            return "Ingrese el tipo de sistema solicitado";
        }

        $objeto="";
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
        }

       // return $tipo." ".$objeto;

        
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
                    $horasc->put('Trabajador',$h->trabajador);
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
    public function autorizadas(Request $request){
        $datos = Hora::where('id', $request->id) ->first();

        $tipo = session('tipo');
        $autorizada = 0;
        if ($tipo !=3){
            $autorizada = session('user');
        }
        $o=Orden::where('id', $datos->ordenes_id) 
          ->update(['autorizada_por' => $autorizada]);
        
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


//empleado
    public function nuevoemp(Request $request){
        $e = Empleado::create([
            'cc' => $request->cc,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'nombre' => $request->nombre,
            'auxilio' => $request->auxilio,
            'correo' => $request->correo,
            'tipo' => $request->tipo,
            'password' => bcrypt($request->cc)
        ]);

        return "Empleado creado";
    }
    public function buscaremp(Request $request){
        $e = Empleado::where('id',$request->id)->first();
        return view('formemp',[
            'datos' => $e
        ]);
    }
    public function editaremp(Request $request){
        Empleado::where('id', $request->id )
        ->update([
            'cc' => $request->cc,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'nombre' => $request->nombre,
            'auxilio' => $request->auxilio,
            'correo' => $request->correo,
            'tipo' => $request->tipo
          ]);
          return "Empleado actualizado";
    }
    public function updatep(Request $request){
        Empleado::where('id', $request->id )
        ->update([
            'password' => bcrypt($request->password)
          ]);
          return "Contraseña actualizada";
    }
    public function eliminaremp(Request $request){
        Empleado::where('id', $request->id )->delete();
        return "Empleado eliminado";
    }
    public function tablaemp(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $emp = Empleado::orderBy('apellido1','asc')->get();  
        }
        else{
            $emp = Empleado::orderBy($campo,'asc')->get();  
        }
        return view('tablaemp',[
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
        $emps = Empleado::all();
        foreach($emps as $e){
            Empleado::where('id',$e->id)->update([
                'password' => bcrypt($e->cc)
            ]);
        }
        return 'operacion realizada';
    }
}
