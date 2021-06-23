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
use DB;
use Carbon\Carbon;
class ExcelController extends Controller
{
    //
    public function export(Request $request){
        /*//$datos=$request;
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 11:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        //dd($fin);

        $o = Orden::where('id','>',0);
        if ($proyecto!=""){
            $o=$o->where('proyecto',$proyecto);
        }
        if($responsable!=""){
            $o=$o->where('responsable',$responsable);
        }
        if($cliente!=""){
          $o=$o->where('cliente','like','%'.$cliente.'%');
        }
        if(($inicio!=" 00:00:00")&&($fin!=" 11:59:59")){
                $o=$o->where('created_at','>=',$inicio)->where('created_at','<=',$fin);
        }
        //$o=$o->orderBy('created_at','desc')->get();
        $o=$o->where('cliente','<>',NULL)->orderBy('created_at','desc')->get();

        $ordenes = $o;




        //$ordenes=Orden::orderBy('created_at','desc')->get();
        
        $datos = collect([]);

        foreach($ordenes as $o){
            //dd($o['id']);
            $dias = Dia::where('ordenes_id',$o['id'])->get();
            $centro = Cdc::where('codigo',$o->proyecto)->first();

            foreach($dias as $d){
                $horas = Hora::where('ordenes_id',$o['id'])->where('dias_id',$d['id'])->get();
                //dd($horas);
                
                foreach($horas as $h){
                    //dd($h['trabajador']);
                    $emp=Empleado::where('cc',$h['trabajador'])->first();
                    $auxilio=round((($emp->auxilio)/240)*$h['ha'],1);

                    //horas
                    $linea=collect([]);
                    $linea->put('codigo del empleado', $h['trabajador']);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '001');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', $d->fecha);
                    $linea->put('horas', $h['ha']);
                    $linea->put('valor', '');
                    $linea->put('cantidad', '');
                    $linea->put('proyecto', '');
                    $linea->put('numero de contrato', '');
                    $linea->put('unidad de negocio', $centro->unidad_negocio);
                    $linea->put('fecha de causacion', '');
                    $linea->put('numero de cuotas', '');
                    $linea->put('notas', '');
                    $datos->push($linea);

                    //valor
                    $linea=collect([]);
                    $linea->put('codigo del empleado', $h['trabajador']);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '075');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', $d->fecha);
                    $linea->put('horas','');
                    $linea->put('valor', $auxilio);
                    $linea->put('cantidad', '');
                    $linea->put('proyecto', '');
                    $linea->put('numero de contrato', '');
                    $linea->put('unidad de negocio', $centro->unidad_negocio);
                    $linea->put('fecha de causacion', '');
                    $linea->put('numero de cuotas', '');
                    $linea->put('notas', '');
                    $datos->push($linea);



                    //dd($datos);
                }
                //dd($datos);
            }

        }*/
        $inicio= $request->fechaInicio." 00:00:00";
        $fin =$request->fechaFinal." 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        //dd($fin);
        //$o = DB::table('ordenes')->join('dias','ordenes.id','=','dias.ordenes_id')->where('ordenes.cliente','<>',NULL)->where('dias.fecha','>=', '2021-05-10')->get();

       // $o = Orden::where('id','>',0);
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
            //dd($o['id']);
            //dd($o->ordenes_id);
            $dias = Dia::where('id',$o->id)->get();
            $centro = Cdc::where('codigo',$o->proyecto)->first();

            foreach($dias as $d){
                $horas = Hora::where('ordenes_id',$o->ordenes_id)->where('dias_id',$d['id'])->get();
                //dd($horas);
                $c = new Carbon($d['fecha']);
                $numdia = $c->dayOfWeek;
                //dd($numdia);
                foreach($horas as $h){
                    //dd($h['trabajador']);
                    $emp=Empleado::where('cc',$h['trabajador'])->first();
                    $horario = $emp->horario_id;

                    if (Detalleh::where('horario_id',$horario)->where('dia',$numdia)->exists()){
                        $detalleh = Detalleh::where('horario_id',$horario)->where('dia',$numdia)->first();
                        $detallei = explode(":", $detalleh->hi);
                        $inicio = intval($detallei[0]) + round(floatval($detallei[1]/60),1);
                        $detallef = explode(":", $detalleh->hf);
                        $fin = intval($detallef[0]) + round(floatval($detallef[1]/60),1);
                    }
                    //dd($inicio." ".$fin);
                    $ri = explode(":", $h->hi);
                    $rinicio = intval($ri[0]) + round(floatval($ri[1]/60),1);
                    $rfin = explode(":", $h->hf);
                    //dd($rfin);
                    $rfin = intval($rfin[0]) + round(floatval($rfin[1]/60),1);
                    
                    $sb = $hedo = $heno=$hedf=$henf= 0;
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
                    }
                    //hedf
                    if ($numdia == 0){
                        if (($rinicio >= 6)&& ($rfin <= 21)){
                            $hedf = $h['ha'];  
                        }
                        if (($rinicio < 6)&& ($rfin <= 21)){
                            $henf = 6-$rinicio;
                            $hedf = $h['ha'] - $henf;  
                        }
                        if (($rinicio >= 6)&& ($rfin > 21)){
                            $henf = 21-$rfin;
                            $hedf = $h['ha'] - $henf;  
                        }
                        if (($rinicio < 6 )&& ($rfin > 21)){
                            $henf = (6-$rinicio) + (21-$rfin);
                            $hedf = $h['ha'] - $henf;  
                        }
                        
                    }

                    $auxilio=round((($emp->auxilio)/240)*$sb,1);

                   
                    if (array_key_exists($h['trabajador'], $total) ) {
                        $total[$h['trabajador']] = $total[$h['trabajador']] + $h['ha'];
                    }
                    else{
                        $total[$h['trabajador']]= $h['ha'];
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


                    //valor
                    if ($auxilio >0){
                        $linea=collect([]);
                        $linea->put('codigo del empleado', $h['trabajador']);
                        $linea->put('sucursal', '');
                        $linea->put('codigo del concepto', '075');
                        $linea->put('centro de operacion', $centro->centro_operacion);
                        $linea->put('centro de costo', $centro->codigo);
                        $linea->put('fecha movimiento', $d->fecha);
                        $linea->put('horas','');
                        $linea->put('valor', $auxilio);
                        $linea->put('cantidad', '');
                        $linea->put('proyecto', '');
                        $linea->put('numero de contrato', '');
                        $linea->put('unidad de negocio', $centro->unidad_negocio);
                        $linea->put('fecha de causacion', '');
                        $linea->put('numero de cuotas', '');
                        $linea->put('notas', '');
                        $datos->push($linea);
                    }



                    //dd($datos);
                }
               // dd($total);
            }

        }

        //return $datos;
        $datos = $datos->sortBy('codigo del empleado');
        return Excel::download(new NominaExport($datos), 'nomina.xlsx');
    }
}
