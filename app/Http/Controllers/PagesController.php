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

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    //
    public function yoursix(){
        return view('yoursix');
    }
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
        $user = session('user');
        //dd($tipo);
        if (($tipo ==0)||($tipo ==1)||($tipo ==10)){
            $e = Empleado::where('id',$user)->first();
            $cc = $e->cc;
            $nombre = $e->nombre. " " . $e->apellido1;
            $prog = Programacion::where('cc',$cc)->orderBy('fecha','asc')->get();
            //dd($prog);
            return view('menu',[
                'prog' => $prog,
                'nombre' => $nombre
            ]);
        }
        else{
            return view('login');
        }

    }
    public function bases(){
        $tipo = session('tipo');
        $user = session('user');
        $authpr=0;
        if (($user ==32)||($user ==31)||($user ==82)||($user ==141)||($user ==187)){
            $authpr=1;
        }
        //dd($tipo);
        if ($tipo ==0){
            $emp = Empleado::orderBy('apellido1','asc')->get();
            $cdc = Cdc::all();
            $clientes = Cliente::orderBy('cliente','asc')->get();
            $proyectos = Proyecto::orderBy('codigo','asc')->get();
            $horarios = Horario::all();
            $areas = Area::all();
            return view('bases',[
                'emp' => $emp,
                'cdc' => $cdc,
                'clientes' => $clientes,
                'proyectos' => $proyectos,
                'horarios' => $horarios,
                'authpr' => $authpr,
                'areas' => $areas
            ]);
        }
        else{
            return view('login');
        }
        
    }
    public function programacion(){
        $tipo = session('tipo');
        //dd($tipo);
        if ($tipo ==0){
            //$prog = Programacion::orderBy('fecha','desc')->paginate(15);
            $prog =Programacion::where('fecha',date('Y-m-d'))->get();

            $emp = Empleado::orderBy('apellido1','asc')->get();
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
    public function ordenes(){
        //$proyectos = Proyecto::orderBy('codigo','asc')->get();
        $proyectos = collect([]);
        $user = session('user');
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

        
        return view('ordenes',[
            'proyectos' => $proyectos 

        ]);
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
    public function filtrarproy(Request $request){
        
        $proy =  Proyecto::orderBy('codigo','asc');
        
        if ($request->fcodigo !=""){
            $proy = $proy->where('codigo',$request->fcodigo );
        }
        if ($request->fcliente !=""){
            $proy = $proy->where('cliente_id',$request->fcliente);
        }
        if ($request->fdirector !=""){
            $proy = $proy->where('director',$request->fdirector );
        }
        if ($request->flider !=""){
            $proy = $proy->where('lider',$request->flider);
        }
        if ($request->fciudad !=""){
            $proy = $proy->where('ciudad',$request->fciudad);
        }
        $proy = $proy->get();
        return view('tablaproyecto',[
            'proyectos' => $proy,
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
    public function filtrarcliente(Request $request){
        $clientes =  Cliente::orderBy('cliente','asc');
        if ($request->fcliente !=""){
            $clientes = $clientes->where('cliente','like' ,'%'.$request->fcliente.'%');
        }
        $clientes  = $clientes->get();
        return view('tablacliente',[
            'clientes' => $clientes,
        ]);
    }
    public function buscarprog(Request $request){
        $p = Programacion::where('id',$request->id)->first();
        $emp = Empleado::orderBy('apellido1','asc')->get();
        $cdc = Cdc::all();
        $clientes = Cliente::orderBy('cliente','asc')->get();
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
            
        return view('formprog',[
            'emp' => $emp,
            'cdc' => $cdc,
            'clientes' => $clientes,
            'proyectos' => $proyectos,
            'datos' => $p
        ]);
    }
    public function eliminarprog(Request $request){
        Programacion::where('id', $request->id )->delete();
        return "Programación eliminada";
    }

//empleado
    public function nuevoemp(Request $request){
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
            'password' => bcrypt($request->cc)
        ]);

        return "Empleado creado";
    }
    public function nuevoproy(Request $request){
        if(Proyecto::where('codigo',$request->codigo)->exists()){
            return "Ya existe un proyecto con ese código";
        }
        else{
            $e = Proyecto::create([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'cliente_id' => $request->cliente,
                'sistema' => $request->sistema,
                'subportafolio' => $request->subportafolio,
                'director' => $request->director,
                'lider' => $request->lider,
                'ciudad' => $request->ciudad,
                'creado_por' => session('user'),
                'creacion' => date("Y-m-d")

            ]);
            $c =  Cdc::create([
                'codigo' => $request->codigo,
                'descripcion' => $request->descripcion,
                'centro_operacion' => $request->co,
                'unidad_negocio' => $request->un,
                'responsable' => '',
                'mayor' => 0,
                'grupo' => 'CP',
                'observaciones' => '',

            ]);
        }

        return "Proyecto creado";
    }
    public function nuevocliente(Request $request){
        $e = Cliente::create([
            'cliente' => $request->cliente,
            'contactos' => $request->contactos,
        ]);

        return "Cliente creado";
    }
    public function tablacliente(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $clientes = Cliente::orderBy('cliente','asc')->get();  
        }
        else{
            $clientes = Cliente::orderBy($campo,'asc')->get();  
        }
        return view('tablacliente',[
            'clientes' => $clientes,
        ]);
    }
    public function buscaremp(Request $request){
        $horario=$idh="";
        $e = Empleado::where('id',$request->id)->first();
        $horarios = Horario::all();
        if ($e->horario_id !=0){
            $horario =  $e->horario->nombre;
            $idh = $e->horario->id;
        } 
        return view('formemp',[
            'datos' => $e,
            'horarios' => $horarios,
            'horario' => $horario,
            'idh' => $idh
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
            'auxiliot' => $request->auxiliot,
            'correo' => $request->correo,
            'ciudad' => $request->ciudad,
            'horario_id' => $request->horario,
            'tipo' => $request->tipo
          ]);
          return "Empleado actualizado";
    }
    public function buscarproy(Request $request){
        $horario=$idh="";
        $p = Proyecto::where('id',$request->id)->first();
        $emp = Empleado::orderBy('apellido1','asc')->get();
        $clientes = Cliente::orderBy('cliente','asc')->get();
        //dd($p);
        return view('formproy',[
            'p' => $p,
            'clientes' => $clientes,
            'emp' => $emp
        ]);
    }
    public function editarproy(Request $request){
        Proyecto::where('id', $request->id )
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

         
          return "Proyecto actualizado";
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
    public function tablaproy(Request $request){
        $campo = $request->campo;
        if ($campo == ''){
            $proyectos = Proyecto::orderBy('codigo','asc')->get();
        }
        else{
            $proyectos= Proyecto::orderBy($campo,'asc')->get();  
        }
        return view('tablaproyecto',[
            'proyectos' => $proyectos,
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
    public function buscarcliente(Request $request){
        $c = Cliente::where('id',$request->id)->first();
        return view('formcliente',[
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
    public function editarcliente(Request $request){
        Cliente::where('id', $request->id )
        ->update([
            'cliente' => $request->cliente,
            'contactos' => $request->contactos,
            
        ]);
        return "Cliente actualizado";
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
        $areas = Area::all();
        $actividades = Actividad::all();
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        $u = session('user');
        $area = Empleado::where('id',$u)->first()->area;
        
        return view('ocupacion',[
            'areas' => $areas,
            'actividades' => $actividades,
            'proyectos' => $proyectos,
            'area' => $area

        ]);
    }
    public function rocupacion(Request $request){
        //dd($request);
        $u = session('user');
        $cc = Empleado::where('id',$u)->first()->cc;
        $existe = ocupacion::where('cc',$cc)->where('dia',$request->dia)->exists();
        $hoy = Carbon::now();
        $dia = new Carbon($request->dia);
        $diff = $hoy->diffInDays($dia);
        $totalh=0;
        $registros= ocupacion::where('cc',$cc)->where('dia',$request->dia)->get();
        foreach($registros as $r){
            $totalh = $totalh + $r->horas + ($r->minutos/60);
        }
        if ($diff> 21){
            return 'No puede registrar actividades anteriores a tres semanas';
        }
        if (Festivo::where('fecha',$request->dia)->exists()){
            return 'La fecha seleccionada es un día festivo';
        }
        if(($dia->dayOfWeek == 0 || $dia->dayOfWeek == 6)){
            return 'Solo se pueden seleccionar días de Lunes a Viernes';
        }
        if ($request->horas == 0 && $request->min == 0){
            return "El tiempo registrado no puede ser 0";
        }
        
        if ($dia >= $hoy){
            return "No es posible registrar una fecha posterior";
        }
        else{
            $totalh = $totalh + $request->horas + ($request->min/60);
            if (($totalh)<=9.5){
                $e = ocupacion::create([
                    'cc' => $cc,
                    'dia' => $request->dia,
                    'area' => $request->area,
                    'actividad' => $request->actividad,
                    'proyecto' => $request->proyecto,
                    'horas' => $request->horas,
                    'minutos' => $request->min,
                ]);
            }
            else{
                return "La horas que desea registrar superan las 9,5 horas";
            }
            return "Registro creado";
        }
    }
    public function consfestivo(Request $request){
        $fecha = $request->fecha;
        if (Festivo::where('fecha',$fecha)->exists()){
            return 'si';
        }
        return 'no';
    }

    //ocupacion
    public function seguimiento(Request $request){
        $area = $request->area;
        $oc =  DB::table('ocupacion');

        if ($area != ""){
            $emp = Empleado::where('area',$area)->orderBy('area','asc')->get();
        }
        else{
            $emp = Empleado::where('area','>',1)->orderBy('area','asc')->get();
        }
        //dd($emp);
        /*
        if (($request->fechaInicioOcup1 !="")&&($request->fechaFinalOcup1 !="")){
            $oc = $oc->where('dia','>=',$request->fechaInicioOcup)->where('dia','<=',$request->fechaFinalOcup);
        }
        
       
        $ocs = $oc->get();
        //dd($ocs);
        */

        $seguimiento  = collect([]);

        $inicio = new Carbon($request->fechaInicioOcup1);
        $fin = new Carbon($request->fechaFinalOcup1);


        foreach($emp as $e){
            $inicio = new Carbon($request->fechaInicioOcup1);
            $fin = new Carbon($request->fechaFinalOcup1);
    
            while ($inicio <= $fin){
            
                $fila = collect([]);
                $fila->put('cc',$e->cc);
                $fila->put('nombre',$e->nombre." ".$e->apellido1);
                $fila->put('area',$e->narea->area);
                $fila->put('fecha',$inicio->toDateString());

                $dia = new Carbon($inicio);
                $totalh =0;
                $registro="";
                if (Festivo::where('fecha',$inicio)->exists()){
                    $registro="NH";
                }
                if(($dia->dayOfWeek == 0 || $dia->dayOfWeek == 6)){
                    $registro="NH";
                }
                if($registro==""){
                    $hoc = Ocupacion::where('cc',$e->cc)->where('dia','=',$inicio)->sum('horas');
                    $moc = Ocupacion::where('cc',$e->cc)->where('dia','=',$inicio)->sum('minutos');
                    $totalh=$hoc + $moc/60;
                    $registro = $totalh;
                }

                $fila->put('registro',$registro);
                $fila->put('clase','table-default');
                    
               
                if($registro===0){
                    $fila->put('clase','table-danger');
                }

                if(($totalh > 0)&&($totalh < 9.5)){
                        $fila->put('clase','table-warning');
                }
                if($totalh == 9.5){
                    $fila->put('clase','table-success');
                }
                
            
                $seguimiento->push($fila);
                $inicio = $inicio->addDay();

            }
        }
        //dd($seguimiento);
        return view('seguimiento',[
            'seguimiento' => $seguimiento,
        ]);
    }
    public function generalo(Request $request){
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
        return view('generalo',[
            'ocs' => $ocs,
        ]);
    }
    public function buscarinfooc(Request $request){
        $fecha = $request->fecha;
        $user = session('user');
        $cc = Empleado::where('id',$user)->first()->cc;
        $hoc = Ocupacion::where('cc',$cc)->where('dia','=',$fecha)->sum('horas');
        $moc = Ocupacion::where('cc',$cc)->where('dia','=',$fecha)->sum('minutos');
        $restantes=(9.5-$hoc + $moc/60);
        return "Faltan ".$restantes." horas por reportar este día";
    }
}
