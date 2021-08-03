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
use App\Models\Ocupacion;
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
        if (($tipo ==0)||($tipo ==1)){
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
        //dd($tipo);
        if ($tipo ==0){
            $emp = Empleado::orderBy('apellido1','asc')->get();
            $cdc = Cdc::all();
            $clientes = Cliente::orderBy('cliente','asc')->get();
            $proyectos = Proyecto::orderBy('codigo','asc')->get();
            $horarios = Horario::all();
            return view('bases',[
                'emp' => $emp,
                'cdc' => $cdc,
                'clientes' => $clientes,
                'proyectos' => $proyectos,
                'horarios' => $horarios
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
            $prog = Programacion::all();
            $emp = Empleado::orderBy('apellido1','asc')->get();
            $proyectos = Proyecto::orderBy('codigo','asc')->get();
            return view('programacion',[
                'proyectos' => $proyectos,
                'emp' => $emp,
                'prog' => $prog,
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
        $datos = $datos->get();

        if ($conteo>0){
            foreach($datos as $d){
                $hi = explode(":", $d->hi);
                $hf = explode(":", $d->hf);
                
                $hi = intval($hi[0]) + round(floatval($hi[1]/60),1);
                $hf = intval($hf[0]) + round(floatval($hf[1]/60),1);

                $rhi = intval($rhi) + round(floatval($rmi/60),1);
                $rhf = intval($rhf) + round(floatval($rmf/60),1);

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
            $datos = Dia::where('ordenes_id',$request->id)->get();
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

        if (Dia::where('ordenes_id',$id)->exists()){   

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
    public function editorden($id){
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
        $ts = Programacion::where('proyecto',$p)->get();
        return view('editDia',[
            'dias' => $dias,
            'horas' => $horas,
            'pl' => $pl,
            'ej' => $ej,
            'ts' => $ts
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
    public function delete(Request $request){
        //dd($request);
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
//programacion
    public function nuevaprog(Request $request){
        $hi = $request->hi.":".$request->mi;
        $hf = $request->hf.":".$request->mf;
        //dd($hi." ".$hf);
        $p = Programacion::create([
            'cc' => $request->cc,
            'fecha' => $request->fecha,
            'proyecto' => $request->proyecto,
            'responsable' => $request->responsable,
            'observacion' => $request->observaciones,
            'hi' => $hi,
            'hf' => $hf    
        ]);
       // dd($p);
        return "Programacion creada";
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
            $prog = $prog->where('cc',$request->filtrocc );
        }
        if (($request->filtrofecha1 !="")&&($request->filtrofecha2 !="")){
            $prog = $prog->where('fecha','>=',$request->filtrofecha1)->where('fecha','<=',$request->filtrofecha2);
        }
        if ($request->filtroproyecto !=""){
            $prog = $prog->where('proyecto',$request->filtroproyecto );
        }
        if ($request->filtroresp !=""){
            $prog = $prog->where('cc',$request->filtroresp );
        }
        $prog = $prog->get();
        return view('tablaprog',[
            'prog' => $prog,
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
        $proy = $proy->get();
        return view('tablaproyecto',[
            'proyectos' => $proy,
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
            'password' => bcrypt($request->cc)
        ]);

        return "Empleado creado";
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
        $areas = Area::all();
        $actividades = Actividad::all();
        $proyectos = Proyecto::orderBy('codigo','asc')->get();
        return view('ocupacion',[
            'areas' => $areas,
            'actividades' => $actividades,
            'proyectos' => $proyectos
        ]);
    }
    public function rocupacion(Request $request){
        //dd($request);
        $u = session('user');
        $cc = Empleado::where('id',$u)->first()->cc;
        $existe = ocupacion::where('cc',$cc)->where('dia',$request->dia)->exists();
        $hoy = Carbon::now();
        $dia = new Carbon($request->dia);
        if ($dia > $hoy){
            return "No es posible registrar una fecha posterior";
        }
        else{
            if (!$existe){
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
                return "Ya existe un registro para esta fecha";
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
























    public function apiyoursix(Request $request){
        //dd($request);
        $call = $request['arg']['call'];
        //dd($call);
        if ($call === "fetch") {
            $this->fetchCap($request);
        }
        else if ($call === "login") {
            $this->user_login($request);
        }
        else if ($call === "trigger") {
            $this->triggerIO($request);
        }	
    }
    public function fetchCap($request) {
        $host = "security.yoursix.com";
        $user_sid = $request['arg']['sid'];
        
        $path="https://$host/portal/device.php?a=capabilities";
        $data = array("api"=>"JSON", "v" => 4);
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);    
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-avhs-authentication: ' .$user_sid));
        $retValue = curl_exec($ch);          
        curl_close($ch);
        $io_devices = array();
        
        $json = json_decode($retValue, true);
        foreach ($json as $key => $value)
        {
            if ($key === "devices") {
                foreach ($value as $devices) {
                        $io = array();
                        $online = $this->retrieveDevice($devices['id'],$user_sid);
                        foreach ($devices['output'] as $output) {				
                            $state = false;
                            if ($online === 1) {
                                $state = $this->fetchIOState($devices['id'], $output['id'],$user_sid);
                            }
                            
                            $io[] = array('id' => $output['id'], 'name' => $output['name'], 'state' => $state);
                        }
                        $io_devices[] = array("device" => $devices['id'], "outputs" => $io, "online" => $online);
                }
            }
        }
        echo json_encode(array("devices" => $io_devices));
    }
    
    public function fetchIOState($mac, $portid,$user_sid) {
        $host = "security.yoursix.com";
        //$user_sid = $_POST['arg']['sid'];
        
        $path="https://$host/portal/device.php?a=get_output_state";
    
        $data = array("api"=>"JSON",  "deviceid" => $mac, "portid" => $portid);
        error_log("SID: " . $user_sid);
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);    
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-avhs-authentication: ' .$user_sid));
        $retValue = curl_exec($ch);    
        if(curl_errno($ch))
        {
            error_log('Curl error: ' . curl_error($ch));
            error_log("ErrOR = " . curl_errno($ch));
        }	
        curl_close($ch);
    
        $json = json_decode($retValue, true);
        return $json['device']['state'];
    
    }
    
    public function retrieveDevice($mac,$user_sid) {
        $host = "security.yoursix.com";
        //$user_sid = $_POST['arg']['sid'];
        $path="https://$host/portal/device.php?a=retrieve";
        
        $data = array("api"=>"JSON", "sid"=> $user_sid, "v" => 3, "deviceid" => array($mac));
        
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);    
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-avhs-authentication: ' .$user_sid));
        $retValue = curl_exec($ch);    
        if(curl_errno($ch))
        {
            error_log('Curl error: ' . curl_error($ch));
            error_log("ErrOR = " . curl_errno($ch));
        }	
        curl_close($ch);
    
        $json = json_decode($retValue, true);
        foreach ($json['devices'] as $device) {
            error_log($device['connected']);
            if ($device['connected']) {
                return 1;
            }
            return 0;
        }
    }
    
    public function triggerIO($request) {
        $host = "security.yoursix.com";
        $user_sid = $request['arg']['sid'];
        $portid = $request['arg']['portid'];
        $mac = $request['arg']['mac'];
        $state = $request['arg']['state'];
        if ($state == 1) {
            $action = "\\";
        } 
        else {
            $action = '/';
        }
        
        $path="https://$host/portal/device.php?a=set_output_state";
        error_log("Register url = ". $path."&api=JSON&deviceid=".$mac."&portid=".$portid."&action=".$action."&sid=".$user_sid);
        $data = array("api"=>"JSON", "deviceid" => $mac, "action" => $action , "portid" => $portid);
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);    
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'x-avhs-authentication: ' .$user_sid));
        $retValue = curl_exec($ch);          
        curl_close($ch);
    
        $json = json_decode($retValue, true);
    
        echo json_encode($json);
    }
    
    public function user_login($request) {
        //$user = $request['arg']['user'];
        $user = "bogata";
        //$user_pass = $request['arg']['pass'];
        $user_pass = "Colombia1996@";
        $host = "security.yoursix.com";
        error_log($user . " - " . $user_pass . " - " . $host);
        $url = "https://".$host.'/auth/v1.0/login';
        $body = json_encode([
            'data' => [
                'type' => 'login',
                'attributes' => [
                    'username' => $user,
                    'password' => $user_pass,
                ],
            ],
        ]);
        $httpHeaders = [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body)
        ];
        $resp = json_decode($this->curlRequest($url, $body, $httpHeaders),true);
        //dd($resp);
        foreach($resp['data'] as $data) {
            if (isset($data['token'])) {
               echo json_encode(array("sid" => $data['token']));
               return;
            }
        }
        echo json_encode(array("error" => "Failed to login user."));
    }	
    
    public function curlRequest ($url, $body = null, $httpHeader = []) {
        $curl = curl_init();
        $curlOpts = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
        ];
        if ($body !== null) {
            $curlOpts[CURLOPT_POSTFIELDS] = $body;
        }
        if (!empty($httpHeader)) {
          $curlOpts[CURLOPT_HTTPHEADER] = $httpHeader;
        }
        curl_setopt_array($curl, $curlOpts);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        if(curl_errno($curl))
        {
            error_log('Curl error: ' . curl_error($curl));
            error_log("ErrOR = " . curl_errno($curl));
        }
        curl_close($curl);
        return $resp;
    }
}
