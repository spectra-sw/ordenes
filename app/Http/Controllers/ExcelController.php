<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Cdc;
use App\Models\Empleado;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NominaExport;
use App\Models\Detalleh;
use App\Models\Festivo;
use DB;
use Carbon\Carbon;
use App\Models\Programacion;

class ExcelController extends Controller
{
    //
    public function export(Request $request){
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        $tecnico = $request->tecnico;
        $oauxilio=$request->auxilio;
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
        $o=$o->orderBy('ordenes.created_at','desc')->get();
       // $o=$o->orderBy('created_at','desc')->get();

        //dd($o);
        $ordenes=$o;
        $ordenes2=$o;
        
        $datos = collect([]);
        $total = array();
        $tsb=array();
        foreach($ordenes as $o){
            //dd($o['id']);
            //dd($o->ordenes_id);
            $dias = Dia::where('id',$o->id)->get();
            $centro = Cdc::where('codigo',$o->proyecto)->first();

            foreach($dias as $d){
                $extra=0;
                $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->get();
                //dd($horas);
                $c = new Carbon($d['fecha']);
                $festivo = $this->consfestivo($d['fecha']);
                $numdia = $c->dayOfWeek;
                //dd($numdia);
                $cont=1;
                $ant =0;
                foreach($horas as $h){
                  
                    
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
                     
                    $sb = $hedo = $heno=$hedf=$henf=$rno=$dtsc=$rnd= 0;
                    if ($extra !=1){      
                        
                        if ($numdia > 0){
                            $sb = $h['ha'];    
                            
                            //hedo
                            if (($rfin > $fin) && ($rfin <= 21)){
                                $sb = $sb  - ($rfin-$fin);
                                $hedo = $rfin - $fin;  
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
                            $dtsc=$h['ha'];
                            if (($rinicio >= 6)&& ($rfin <= 21)){
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
                        if ($festivo=="si"){
                            $dtsc=$sb=0;
                        }  

                    }
                    if($extra==1){
                        if ($numdia > 0){

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
                        if ($numdia == 0){
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
                        $auxilio=round((($emp->auxilio)/240)*$sb,1);
                        if (array_key_exists($h['trabajador'], $total) ) {
                            $total[$h['trabajador']] = $total[$h['trabajador']] + $h['ha'];
                        }
                        else{
                            $total[$h['trabajador']]= $h['ha'];
                        }
                       if (array_key_exists($h['trabajador'], $total) ) {
                            if(($total[$h['trabajador']]>47.5)&& ($hedf>0)&&($centro->codigo==9933)){
                                
                                $hedf2=$total[$h['trabajador']]-47.5;
                                $sb=$hedf-$hedf2;
                                
                                $hedf=$hedf2;
                            }
                            
                            if(($total[$h['trabajador']]<47.5)&& ($hedf>0)&&($centro->codigo==9933)){
                                    $sb = $h['ha'];
                                   // $dtsc=$h['ha']-$rnd;
                                    $dtsc=0;
                                    $hedf=0;
                                    $henf=0;
                                    $hedo=0;
                                    $heno=0;
                            }
                       }

                   
                    //horas
                        if ($sb>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '001');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', $d->fecha);
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
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '006');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', $d->fecha);
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
                            $linea->put('fecha movimiento', $d->fecha);
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
                            $linea->put('fecha movimiento', $d->fecha);
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
                            $linea->put('fecha movimiento', $d->fecha);
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
                        if ($rno>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '012');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', $d->fecha);
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
                        if ($rnd>0){
                            $linea=collect([]);
                            $linea->put('codigo del empleado', $h['trabajador']);
                            $linea->put('sucursal', '');
                            $linea->put('codigo del concepto', '013');
                            $linea->put('centro de operacion', $centro->centro_operacion);
                            $linea->put('centro de costo', $centro->codigo);
                            $linea->put('fecha movimiento', $d->fecha);
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
                            $linea->put('fecha movimiento', $d->fecha);
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
            foreach ($datos2 as $d){
                $datos->push($d);
            }
        }
        //return $datos;
        $datos = $datos->sortBy(['codigo del empleado','fecha movimiento']);
        return Excel::download(new NominaExport($datos), 'nomina.xlsx');
    }
    public function consfestivo($fecha){     
        if (Festivo::where('fecha',$fecha)->exists()){
            return 'si';
        }
        return 'no';
    }
}
