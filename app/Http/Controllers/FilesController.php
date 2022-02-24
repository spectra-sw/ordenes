<?php

namespace App\Http\Controllers;
use Log;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Cdc;
use App\Models\Empleado;
use App\Models\Detalleh;
use App\Models\Programacion;
use App\Models\Festivo;
use App\Models\Novedad;
use DB;
use Carbon\Carbon;
class FilesController extends Controller
{
    //
    public function archivon(Request $request){
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        $tecnico = $request->tecnico;
        $oauxilio=$request->auxilio;
        //dd($auxilio);
        //dd($fin);
        //$o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL)->where('dias.fecha','>=', '2021-05-10')->get();

       // $o = Orden::where('id','>',0);
        $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL)->where('dias.fecha','<>','1900-01-01');
        if ($proyecto!=""){
            $o=$o->where('ordenes.proyecto',$proyecto);
        }
        if($responsable!=""){
            $o=$o->where('ordenes.responsable',$responsable);
        }
        if($cliente!=""){
          $o=$o->where('ordenes.cliente','like','%'.$cliente.'%');
        }
        if(($inicio!=" 00:00:00")&&($fin!=" 11:59:59")){
                $o=$o->where('dias.fecha','>=',$inicio)->where('dias.fecha','<=',$fin);
        }
        $o=$o->orderBy('dias.fecha','asc')->orderBy('dias.id','asc')->get();
       // $o=$o->orderBy('created_at','desc')->get();

        //dd($o);
        $ordenes=$o;
        $ordenes2=$o;
        
        $datos = collect([]);
        $total = array();
        $tsb=array();
        $conts =array();
        foreach($ordenes as $o){
            //dd($o['id']);
            //dd($o->ordenes_id);
            $dias = Dia::where('id',$o->id)->get();
            $centro = Cdc::where('codigo',$o->proyecto)->first();
            $bandextra=0;
            foreach($dias as $d){
                $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->get();
                if($tecnico =='1053835892'){
                    //Log::info($horas);
                }
                $c = new Carbon($d['fecha']);
                $festivo = $this->consfestivo($d['fecha']);
                $numdia = $c->dayOfWeek;
                //dd($numdia);
                $cont=1;
                $ant =0;
                foreach($horas as $h){
                    $extra=0;
                    $inicio = $fin =$rinicio=$rfin=0;
                    if (array_key_exists($h['trabajador'], $conts) ) {
                        $conts[$h['trabajador']] = $conts[$h['trabajador']] + 1;
                    }
                    else{
                        $conts[$h['trabajador']]= 1;
                    }

                    if ($ant==$h['trabajador']){
                        $cont = $cont+1;
                    }
                    else{
                        $ant=$h['trabajador'];
                        $cont=1;
                    }
                    if(Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->exists()){
                        $progs=Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->take($conts[$h['trabajador']])->get();
                        if($tecnico ==$h['trabajador']){
                           // Log::info($conts[$h['trabajador']]);
                           // Log::info($progs);
                        }
                        //dd(Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->get());
                        foreach ($progs as $prog){
                            $detallei = explode(":", $prog->hi);
                            $inicio = intval($detallei[0]) + round(floatval($detallei[1]/60),1);
                            $detallef = explode(":", $prog->hf);
                            $fin = intval($detallef[0]) + round(floatval($detallef[1]/60),1);
                            $extra = $prog->extra;
                        }
                      
                    }
                    
                    
                    $emp=Empleado::where('cc',$h['trabajador'])->first();

                    $ri = explode(":", $h->hi);
                    $rinicio = intval($ri[0]) + round(floatval($ri[1]/60),1);
                    $rfin = explode(":", $h->hf);
                    //dd($rfin);
                    $rfin = intval($rfin[0]) + round(floatval($rfin[1]/60),1);
                    if($tecnico ==$h['trabajador']){
                       // dd($horas);
                      // Log::info($d['fecha']." ".$inicio." ".$rinicio." ".$fin." ".$rfin);
                       //Log::info($total[$h['trabajador']]);
                      // Log::info("Hedf(008):".$hedf." Henf(009):".$henf);
                    }
                   
                    $sb = $hedo = $heno= $hedf = $henf = $rno = $dtsc = $rnd = 0;
                   
                    if ($extra !=1){      
                        
                        if (($numdia > 0)&&($festivo=="no")){
                            $sb = $h['ha'];    
                            
                            //hedo
                            if (($rfin > $fin) && ($rfin <= 21)){
                               
                                $sb = $sb  - ($rfin-$fin);
                                $hedo = $rfin - $fin;  
                                if($hedo>$sb){
                                   $sb =  $sb = $h['ha'];  
                                }
                            }
                            if (($rinicio < $inicio ) && ($rinicio >= 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedo = ($inicio-$rinicio);
                            }
                            
                            //heno
                            if (($rfin > $fin) && ($rfin > 21)){
                                $sb = $sb - ($rfin-$fin);
                                $hedo =  (21-$fin);
                                $heno = ($rfin - $fin) - $hedo;
                            }
                            if (($rinicio < $inicio ) && ($rinicio < 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedo = (6-$rinicio);
                                $heno = ($inicio-$rinicio) - $hedo;
                            }
                            //rno
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rno = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rno = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rno = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rno = $rfin - $rinicio;
                            }
                           
                        }
                       
                        //hedf
                        if (($numdia == 0)||($festivo=="si")){
                            
                            if($festivo=="si"){
                                $sb=$h['ha'];
                            }
                            if($festivo=="no"){
                                $dtsc=$h['ha'];
                            }

                            //hedf
                            if (($rfin > $fin) && ($rfin <= 21)){
                                $sb = $sb  - ($rfin-$fin);
                                $hedf = $rfin - $fin;  
                            }
                            if (($rinicio < $inicio ) && ($rinicio >= 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedf = ($inicio-$rinicio);
                            }

                            //henf
                            if (($rfin > $fin) && ($rfin > 21)){
                                $sb = $sb - ($rfin-$fin);
                                $hedf =  (21-$fin);
                                $henf = ($rfin - $fin) - $hedf;
                            }
                            if (($rinicio < $inicio ) && ($rinicio < 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedf = (6-$rinicio);
                                $henf = ($inicio-$rinicio) - $hedf;
                            }

                            /*if (($rinicio >= 6)&& ($rfin <= 21)){
                                $hedf = $h['ha'];  
                            }
                            if (($rinicio < 6)&& ($rfin <= 21)){
                                $henf = 6-$rinicio;
                                $hedf = $h['ha'] - $henf;  
                            }
                            if (($rinicio >= 6)&& ($rfin > 21)){
                                $henf = $rfin-21;
                                $hedf = $h['ha'] - $henf;  
                            }
                            if (($rinicio < 6 )&& ($rfin > 21)){
                                $henf = (6-$rinicio) + (21-$rfin);
                                $hedf = $h['ha'] - $henf;  
                            }*/

                            //rnd
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rnd = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rnd = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rnd = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rnd = $rfin - $rinicio;
                            }
                           
                            
                        }
                        if (($festivo=="si")&&($centro->codigo!=9933)){
                            $dtsc=$sb=0;
                        }  
                        
                    }
                    
                    if($extra==1){
                        
                        if (($numdia > 0)&&($festivo!="si")){

                            if (($rfin >= 6) && ($rfin <= 21)){
                                $hedo = $h['ha']; 
                            }
                            else{
                                $heno = $h['ha']; 
                            }   
                            
                            //rno
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rno = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rno = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rno = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rno = $rfin - $rinicio;
                            } 
                        }
                       if (($numdia == 0)||($festivo=="si")){
                            if (($rfin >= 6) && ($rfin <= 21)){
                                $hedf = $h['ha']; 
                            }
                            else{
                                $henf = $h['ha']; 
                            }   
                            //rnd
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rnd = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rnd = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rnd = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rnd = $rfin - $rinicio;
                            }
                        }
                    }
                    if($tecnico ==$h['trabajador']){
                        // dd($horas);
                        Log::info("sb(001):".$sb." Hedo(006):".$hedo." Heno(007):".$heno);
                     }
                    if(($tecnico == "")||($tecnico != "" && $tecnico ==$h['trabajador'])) {
                        //dd($extra);
                        $auxilio=round((($emp->auxilio)/240)*$sb,1);
                        if (array_key_exists($h['trabajador'], $total) ) {
                            $total[$h['trabajador']] = $total[$h['trabajador']] + $h['ha'];
                        }
                        else{
                            $total[$h['trabajador']]= $h['ha'];
                        }
                       
                       if (array_key_exists($h['trabajador'], $total) ) {
                            if(($total[$h['trabajador']]>47.5)&&($centro->codigo==9933)&&($bandextra==0)){
                               // dd($sb);
                                $bandextra=1;
                                if (($numdia == 0)){
                                    if($henf>0){
                                        $henf2=$total[$h['trabajador']]-47.5;
                                        $henf=$henf2;
                                        $dtsc=$dtsc-$henf;
                                    }
                                    else{
                                        $hedf2=$total[$h['trabajador']]-47.5;
                                        $hedf=$hedf2;
                                        $dtsc=$dtsc-$hedf;
                                    }
                                }
                                else{
                                    if ($hedo==0){
                                    $hedo2=$total[$h['trabajador']]-47.5;
                                    $hedo=$hedo2;
                                    $sb=$sb-$hedo;
                                    }
                                }    
                            }
                            
                            if(($total[$h['trabajador']]<47.5)&&($centro->codigo==9933)){
                                if (($festivo == 'no')){
                                    $sb = $h['ha'];
                                   // $dtsc=$h['ha']-$rnd;
                                    $dtsc=0;
                                    $hedf=0;
                                    $henf=0;
                                    $hedo=0;
                                    $heno=0;
                                }
                            }
                            //Log::info("Hedf(008):".$hedf." Henf(009):".$henf);
                        }
                       
                   
                        //horas
                        if ($sb>0){
                            //dd($sb);
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '001');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $sb);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                            if (array_key_exists($h['trabajador'], $tsb) ) {
                                $tsb[$h['trabajador']]= $tsb[$h['trabajador']] + $sb;
                            }
                            else{
                                $tsb[$h['trabajador']]= $sb;
                            }
                        }
                        if ($hedo>0){
                            //dd($hedo);
                           
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '006');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $hedo);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if ($heno>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '007');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $heno);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if ($hedf>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '008');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $hedf);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if ($henf>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '009');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $henf);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if( ($rno>0)&&($heno==0)){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '012');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $rno);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if (($rnd>0)&&($henf==0)){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            //$linea->put('codigo del concepto', '013');
                            $linea->put('codigo del concepto', '014');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $rnd);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                        if ($dtsc>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '011');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', str_replace("-","",$d->fecha));
                            $linea->put('horas', $dtsc);
                            $linea->put('valor', '');
                            $linea->put('cantidad', '');
                            $linea->put('proyecto', '');
                            $linea->put('numero de contrato', '');
                            $linea->put('unidad de negocio', $centro->unidad_negocio);
                            $linea->put('fecha de causacion', '');
                            $linea->put('numero de cuotas', '');
                            $linea->put('notas', '');
                            $datos->push($linea);
                        }
                    }
                }

            }

        }
        //dd($tsb);
        if ($oauxilio=="si"){
            $datos2 = collect([]);
            foreach ($datos as $d){
                if ($d['codigo del concepto']=='001'){
                    $cc = $d['codigo del empleado'];
                    $horas = $d['horas'];
                    $emp=Empleado::where('cc',$cc)->first();

                    if ($emp->auxilio>0){
                
                        $auxilio= round(($emp->auxilio/$tsb[$cc])*$horas,1);
                        $linea=collect([]);
                        /*$linea->put('total',$total[$cc]);
                        $linea->put('auxilio',$emp->auxilio);
                        $linea->put('horas',$horas);*/

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
        }
        //return $datos;
        $datos = $datos->sortBy(['codigo del empleado','fecha movimiento']);
       
        //$datos2 = $datos2->sortBy(['codigo del empleado','fecha movimiento']);
        //dd($datos2);
        return view('tablan',[
            'datos' => $datos,
            'total' => $total,
        ]);
        
    }

    public function reportep(Request $request){
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        $tecnico = $request->tecnico;
       // dd($tecnico);
        $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL);
        if ($proyecto!=""){
            $o=$o->where('ordenes.proyecto',$proyecto);
        }
        if($responsable!=""){
            $o=$o->where('ordenes.responsable',$responsable);
        }
        if($cliente!=""){
          $o=$o->where('ordenes.cliente','like','%'.$cliente.'%');
        }
        if(($inicio!=" 00:00:00")&&($fin!=" 11:59:59")){
                $o=$o->where('dias.fecha','>=',$inicio)->where('dias.fecha','<=',$fin);
        }
        $o=$o->orderBy('ordenes.created_at','desc')->get();
       // $o=$o->orderBy('created_at','desc')->get();

        //dd($o);
        $ordenes=$o;
       
        $datos = collect([]);
        $total = array();
        foreach($ordenes as $o){
            $dias = Dia::where('id',$o->id)->get();
            foreach($dias as $d){
                $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->get();
                foreach($horas as $h){
                    //dd($h['trabajador']);
                    if ($tecnico ==""){
                        $emp=Empleado::where('cc',$h['trabajador'])->first();
                        $horario = $emp->horario_id;  
                        $linea=collect([]);
                            $linea->put('cc', $h['trabajador']);
                            $linea->put('nombre', $emp->nombre." ".$emp->apellido1);
                            $linea->put('fecha', $d->fecha);
                            $linea->put('proyecto', $o->proyecto);
                            $linea->put('entrada', $h->hi);
                            $linea->put('salida', $h->hf);
                            $linea->put('autorizadas', $h->ha);
                                
                            $datos->push($linea);        
                    }    
                    else{
                        if ($tecnico==$h['trabajador']){
                            $emp=Empleado::where('cc',$h['trabajador'])->first();
                            $horario = $emp->horario_id;    
                            $linea=collect([]);
                            $linea->put('cc', $h['trabajador']);
                            $linea->put('nombre', $emp->nombre." ".$emp->apellido1);
                            $linea->put('fecha', $d->fecha);
                            $linea->put('proyecto', $o->proyecto);
                            $linea->put('entrada', $h->hi);
                            $linea->put('salida', $h->hf);
                            $linea->put('autorizadas', $h->ha);    
                            $datos->push($linea);        
                            
                        }
                    }
                       
                }   
            }

        }
        //dd($datos);
       
        $datos = $datos->sortBy(['cc','fecha']);
       
        return view('tablarp',[
            'datos' => $datos,
        ]);
        
    }
    public function consfestivo($fecha){     
        if (Festivo::where('fecha',$fecha)->exists()){
            return 'si';
        }
        return 'no';
    }

    public function archivoc(Request $request){
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        $tecnico = $request->tecnico;
        $oauxilio=$request->auxilio;
        
        $o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL)->where('dias.fecha','<>','1900-01-01');
        if ($proyecto!=""){
            $o=$o->where('ordenes.proyecto',$proyecto);
        }
        if($responsable!=""){
            $o=$o->where('ordenes.responsable',$responsable);
        }
        if($cliente!=""){
          $o=$o->where('ordenes.cliente','like','%'.$cliente.'%');
        }
        if(($inicio!=" 00:00:00")&&($fin!=" 11:59:59")){
                $o=$o->where('dias.fecha','>=',$inicio)->where('dias.fecha','<=',$fin);
        }
        $o=$o->orderBy('dias.fecha','asc')->get();
     
       
        $ordenes=$o;
        $ordenes2=$o;
        
        $datos = collect([]);
        $total = array();
        $tsb=array();
        foreach($ordenes as $o){

            $dias = Dia::where('id',$o->id)->get();
            $centro = Cdc::where('codigo',$o->proyecto)->first();
            $bandextra=0;
            foreach($dias as $d){
                if($tecnico ==""){
                    $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->get();
                }
                else{
                    $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->where('trabajador',$tecnico)->get();
                }
                $c = new Carbon($d['fecha']);
                $festivo = $this->consfestivo($d['fecha']);
                $numdia = $c->dayOfWeek;
                
                $cont=1;
                $ant =0;
                foreach($horas as $h){
                    $extra=0;
                    $inicio = $fin =$rinicio=$rfin=0;
                    if ($ant==$h['trabajador']){
                        $cont = $cont+1;
                    }
                    else{
                        $ant=$h['trabajador'];
                        $cont=1;
                    }
                    if(Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->exists()){
                        $progs=Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->take($cont)->get();
                        //dd(Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->get());
                        foreach ($progs as $prog){
                            $detallei = explode(":", $prog->hi);
                            $inicio = intval($detallei[0]) + round(floatval($detallei[1]/60),1);
                            $detallef = explode(":", $prog->hf);
                            $fin = intval($detallef[0]) + round(floatval($detallef[1]/60),1);
                            $extra = $prog->extra;
                        }
                      
                    }
                    
                    
                    $emp=Empleado::where('cc',$h['trabajador'])->first();

                    $ri = explode(":", $h->hi);
                    $rinicio = intval($ri[0]) + round(floatval($ri[1]/60),1);
                    $rfin = explode(":", $h->hf);
                    //dd($rfin);
                    $rfin = intval($rfin[0]) + round(floatval($rfin[1]/60),1);
                    
                   
                    $sb = $hedo = $heno= $hedf = $henf = $rno = $dtsc = $rnd = 0;
                   
                    if ($extra !=1){      
                        
                        if (($numdia > 0)&&($festivo=="no")){
                            $sb = $h['ha'];    
                            
                            //hedo
                            if (($rfin > $fin) && ($rfin <= 21)){
                               
                                $sb = $sb  - ($rfin-$fin);
                                $hedo = $rfin - $fin;  
                                if($hedo>$sb){
                                   $sb =  $sb = $h['ha'];  
                                }
                            }
                            if (($rinicio < $inicio ) && ($rinicio >= 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedo = ($inicio-$rinicio);
                            }
                            
                            //heno
                            if (($rfin > $fin) && ($rfin > 21)){
                                $sb = $sb - ($rfin-$fin);
                                $hedo =  (21-$fin);
                                $heno = ($rfin - $fin) - $hedo;
                            }
                            if (($rinicio < $inicio ) && ($rinicio < 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedo = (6-$rinicio);
                                $heno = ($inicio-$rinicio) - $hedo;
                            }
                            //rno
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rno = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rno = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rno = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rno = $rfin - $rinicio;
                            }
                           
                        }
                       
                        //hedf
                        if (($numdia == 0)||($festivo=="si")){
                            
                            if($festivo=="si"){
                                $sb=$h['ha'];
                            }
                            if($festivo=="no"){
                                $dtsc=$h['ha'];
                            }

                            //hedf
                            if (($rfin > $fin) && ($rfin <= 21)){
                                $sb = $sb  - ($rfin-$fin);
                                $hedf = $rfin - $fin;  
                            }
                            if (($rinicio < $inicio ) && ($rinicio >= 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedf = ($inicio-$rinicio);
                            }

                            //henf
                            if (($rfin > $fin) && ($rfin > 21)){
                                $sb = $sb - ($rfin-$fin);
                                $hedf =  (21-$fin);
                                $henf = ($rfin - $fin) - $hedf;
                            }
                            if (($rinicio < $inicio ) && ($rinicio < 6)){
                                $sb = $sb - ($inicio-$rinicio);
                                $hedf = (6-$rinicio);
                                $henf = ($inicio-$rinicio) - $hedf;
                            }

                            /*if (($rinicio >= 6)&& ($rfin <= 21)){
                                $hedf = $h['ha'];  
                            }
                            if (($rinicio < 6)&& ($rfin <= 21)){
                                $henf = 6-$rinicio;
                                $hedf = $h['ha'] - $henf;  
                            }
                            if (($rinicio >= 6)&& ($rfin > 21)){
                                $henf = $rfin-21;
                                $hedf = $h['ha'] - $henf;  
                            }
                            if (($rinicio < 6 )&& ($rfin > 21)){
                                $henf = (6-$rinicio) + (21-$rfin);
                                $hedf = $h['ha'] - $henf;  
                            }*/

                            //rnd
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rnd = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rnd = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rnd = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rnd = $rfin - $rinicio;
                            }
                           
                            
                        }
                        if (($festivo=="si")&&($centro->codigo!=9933)){
                            $dtsc=$sb=0;
                        }  
                        
                    }
                    
                    if($extra==1){
                        
                        if (($numdia > 0)&&($festivo!="si")){

                            if (($rfin >= 6) && ($rfin <= 21)){
                                $hedo = $h['ha']; 
                            }
                            else{
                                $heno = $h['ha']; 
                            }   
                            
                            //rno
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rno = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rno = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rno = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rno = $rfin - $rinicio;
                            } 
                        }
                       if (($numdia == 0)||($festivo=="si")){
                            if (($rfin >= 6) && ($rfin <= 21)){
                                $hedf = $h['ha']; 
                            }
                            else{
                                $henf = $h['ha']; 
                            }   
                            //rnd
                            if (($rinicio < 21)&&($rinicio > 6)&&($rfin>21)&&($rfin<=24)){
                                $rnd = $rfin - 21;
                            }
                            if (($rinicio >= 21)&&($rfin<=24)){
                                $rnd = $rfin - $rinicio;
                            }
                            if (($rinicio >=0 )&&($rinicio <=6 )&&($rfin>6)){
                                $rnd = 6 - $rinicio;
                            }
                            if (($rinicio >= 0)&&($rfin<=6)){
                                $rnd = $rfin - $rinicio;
                            }
                        }
                    }
                   
                    if(($tecnico == "")||($tecnico != "" && $tecnico ==$h['trabajador'])) {
                        //dd($extra);
                        $auxilio=round((($emp->auxilio)/240)*$sb,1);
                        if (array_key_exists($h['trabajador'], $total) ) {
                            $total[$h['trabajador']] = $total[$h['trabajador']] + $h['ha'];
                        }
                        else{
                            $total[$h['trabajador']]= $h['ha'];
                        }
                       
                       if (array_key_exists($h['trabajador'], $total) ) {
                            if(($total[$h['trabajador']]>47.5)&&($centro->codigo==9933)&&($bandextra==0)){
                               // dd($sb);
                                $bandextra=1;
                                if (($numdia == 0)){
                                    if($henf>0){
                                        $henf2=$total[$h['trabajador']]-47.5;
                                        $henf=$henf2;
                                        $dtsc=$dtsc-$henf;
                                    }
                                    else{
                                        $hedf2=$total[$h['trabajador']]-47.5;
                                        $hedf=$hedf2;
                                        $dtsc=$dtsc-$hedf;
                                    }
                                }
                                else{
                                    $hedo2=$total[$h['trabajador']]-47.5;
                                    $hedo=$hedo2;
                                    $sb=$sb-$hedo;
                                }    
                            }
                            
                            if(($total[$h['trabajador']]<47.5)&&($centro->codigo==9933)){
                                if (($festivo == 'no')){
                                    $sb = $h['ha'];
                                   // $dtsc=$h['ha']-$rnd;
                                    $dtsc=0;
                                    $hedf=0;
                                    $henf=0;
                                    $hedo=0;
                                    $heno=0;
                                }
                            }
                            //Log::info("Hedf(008):".$hedf." Henf(009):".$henf);
                        }
                       

                            $linea = collect([]);
                    
                            $linea->put('ID', '1');
                            $linea->put('ID TERCERO', $h['trabajador']);
                            $linea->put('NDC', '');
                            $lapso=substr(str_replace("-","",$d->fecha),0,6);
                            $linea->put('LAPSO', substr(str_replace("-","",$d->fecha),0,6));
                            $linea->put('CENTRO OPERACION', $centro->centro_operacion);
                            $linea->put('CENTRO COSTOS', $centro->codigo);
                            $linea->put('ID PROYECTO', '');
                            $linea->put('ID UNIDAD DE NEGOCIO', $centro->unidad_negocio);
                            $linea->put('NOTAS', '');
                            

                        //horas
                        if ($sb>0){
                            $linea->put('codigo del concepto', '001');
                            $linea->put('UNIDADES', $sb);
                         
                            if (array_key_exists($h['trabajador'], $tsb) ) {
                                $tsb[$h['trabajador']]= $tsb[$h['trabajador']] + $sb;
                            }
                            else{
                                $tsb[$h['trabajador']]= $sb;
                            }
                        }
                        if ($hedo>0){
                            $linea->put('codigo del concepto', '006');
                            $linea->put('UNIDADES', $hedo);
                        }
                        if ($heno>0){
                            $linea->put('codigo del concepto', '007');
                            $linea->put('UNIDADES', $heno);
                        }
                        if ($hedf>0){
                            $linea->put('codigo del concepto', '008');
                            $linea->put('UNIDADES', $hedf);
                        }
                        if ($henf>0){
                            $linea->put('codigo del concepto', '009');
                            $linea->put('UNIDADES', $henf);
                        }
                        if( ($rno>0)&&($heno==0)){
                            $linea->put('codigo del concepto', '012');
                            $linea->put('UNIDADES', $rno);
                        }
                        if (($rnd>0)&&($henf==0)){
                            $linea->put('codigo del concepto', '014');
                            $linea->put('UNIDADES', $rnd);
                        }
                        if ($dtsc>0){
                            $linea->put('codigo del concepto', '011');
                            $linea->put('UNIDADES', $dtsc);
                        }
                        $datos->push($linea);
                    }
                }

            }

        }
                    $hl =240;
                    if(Novedad::where('cc',$tecnico)->where('periodo',$lapso)->exists()){
                        $hl=Novedad::where('cc',$tecnico)->where('periodo',$lapso)->first()->horas;
                    }
                    $linea = collect([]);
                    
                    $linea->put('ID', '1');
                    $linea->put('ID TERCERO', $tecnico);
                    $linea->put('NDC', '');
                    $linea->put('LAPSO', $lapso);
                    $linea->put('UNIDADES',$hl- $total[$tecnico]);
                    $linea->put('CENTRO OPERACION', '001');
                    $linea->put('CENTRO COSTOS', '300001');
                    $linea->put('ID PROYECTO', '');
                    $linea->put('ID UNIDAD DE NEGOCIO', '999');
                    $linea->put('NOTAS', '');
                    $datos->push($linea);

        //$datos = $datos->sortBy(['codigo del empleado','fecha movimiento']);
        

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
        
        return view('tablan2',[
            'datos' => $datos,
            'total' => $total,
        ]);
        
    }
}
