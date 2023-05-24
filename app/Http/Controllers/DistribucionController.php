<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jornada;
use App\Models\Cdc;
use App\Models\Empleado;
use App\Models\Turno;
use App\Models\Horario;
use Carbon\Carbon;
use Log;

class DistribucionController extends Controller
{
    //
    public function distribucion(Request $request){
        $datos = $this->getDatosDistribucion($request);
        $datos[0] = $datos[0]->sortBy(['codigo del empleado','fecha movimiento']);
        return view('tablan',[
            'datos' => $datos[0],
            'talmuerzo' => $datos[1] ,
        ]);

    }
    function getDatosDistribucion($request){
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
       /* if ($request->estado) {
            $jornadas->where('estado', $request->estado);
        }*/
        $jornadas->where('estado', 2);
        $jornadas = $jornadas->orderBy('fecha','asc')->get();
        //dd($jornadas);
        $datos = collect([]);

        $inicio_diurno = 6; 
        $fin_diurno  = 21; 
        $inicio_nocturno = 21; 
        $fin_nocturno  = 6; 
        $tsb=array();
        $ttsb=0;
        $cont = 0;
        foreach ($jornadas as $j){
            $cont = $cont + 1;
            Log::info($tsb);
            $hi = explode(":", $j->hi);
            $hi =intval($hi[0]) + round(floatval($hi[1]/60),1);
            $hf = explode(":", $j->hf);
            $hf =intval($hf[0]) + round(floatval($hf[1]/60),1);
            $duracion  = explode(":", $j->duracion);
            $duracion =intval($duracion[0]) + round(floatval($duracion[1]/60),1);
                
            $festivo = app('App\Http\Controllers\FilesController')->consfestivo($j->fecha);
            $c = new Carbon($j->fecha);
            if (!array_key_exists($j->fecha, $tsb) ) {
                $tsb[$j->fecha] = 0;
            }
            $cf = new Carbon($j->fechaf);
            $numdia = $c->dayOfWeek;
            $sb = $hedo = $heno= $hedf = $henf = $rno = $dtc = $rnd = 0;

                
            //horario laboral
            $turno = Turno::where('user_id', $j->user_id)
            ->where('fecha_inicio','<=', $j->fecha)
            ->where('fecha_fin','>=', $j->fechaf)
            
            ->first();
           // dd( $j->fechaf);
            if ($turno === null) {
                $horario_id = Empleado::where('id',$request->trabajador)->first()->horario_id;
                //dd($horario_id);
                $turno = Horario::where('id',$horario_id)->first();
                $especial = false;
            }
            else{
                $especial = true;
            }
            //dd($turno);
            //Log::info($especial);
            if ($turno->fecha_inicio == $turno->fecha_fin){
                $laborales = $turno->hora_fin - $turno->hora_inicio - $turno->almuerzo;
               // dd($laborales);
            }
            else{
                $laborales = (24-$turno->hora_inicio) + $turno->hora_fin - $turno->almuerzo;
            }
            //dd($laborales);
            if($especial==true){               
               
                if (($numdia > 0)&&($festivo=="no")){
                    $sb = $tsb[$j->fecha] + ($duracion - $j->almuerzo);
                    //dd($sb);
                    //Log::info($turno->id.":".$sb);
                    if ($sb>$laborales){
                        $excede = $sb -$laborales;
                        //dd($excede);
                        $sb =$laborales - $tsb[$j->fecha];
                        $heno = $this->calcularHeno($turno->hora_fin,$hf);
                       // dd($sb);
                        if ($heno ==0){
                            $hedo = $excede;  
                        }
                        else{
                            $hedo = $excede - $heno;
                        }
                        if ($heno ==0){
                            $rno = $this->calcularHeno($hi,$hf);
                        }
                    }
                    else{
                        $sb =  ($duracion - $j->almuerzo);
                        $rno = $this->calcularHeno($hi,$hf);
                        //dd($heno);
                        //$sb = $sb-$rno;
                        /*if ($sb == $rno){
                            $sb = 0;
                        }*/
                    }

                }
                if (($numdia == 0)||($festivo=="si")){
                    $dtc = $duracion - $j->almuerzo;
                    if ($dtc>$laborales){
                        $excede = $dtc -$laborales;
                        $dtc =$laborales;
                        
                        $henf = $this->calcularHeno($turno->hora_fin,$hf);
                        //dd($excede);
                        if ($henf ==0){
                            $hedf = $excede;  
                        }
                        else{
                            $hedf = $excede - $henf;
                        }
                        if ($hedf ==0){
                        $rnd = $this->calcularHeno($hi,$hf);
                        }
                    }
                    else{
                        $rnd = $this->calcularHeno($hi,$hf);
                        /*if ($rnd >0){
                            $sb = $rnd;
                        }*/
                    }
                }
            }
            if (($especial == false)&&($numdia >= $turno->dia_inicio)&&($numdia <= $turno->dia_fin)){
                if (($numdia > 0)&&($festivo=="no")){
                    $sb = $duracion - $j->almuerzo;
                    //dd($sb);
                    if ($sb>$laborales){
                        $excede = $sb -$laborales;
                        $sb =$laborales;
                        //dd($sb);
                        if ($hf == 0){
                            $hf = 24;
                        }
                        $heno = $this->calcularHeno($turno->hora_fin,$hf);
                        //dd($heno);
                        if ($heno ==0){
                            $hedo = $excede;  
                        }
                        else{
                            $hedo = $excede - $heno;
                        }
                        if ($heno ==0){
                            $rno = $this->calcularHeno($hi,$hf);
                        }
                    }
                    else{
                        $rno = $this->calcularHeno($hi,$hf);
                        /*//dd($heno);
                        $sb = $sb-$heno;
                        //dd($sb);
                        if($sb==0){
                            $rno=$heno;
                        }*/
                    }
            
                }
                if (($numdia == 0)||($festivo=="si")){
                    if($festivo=="si"){
                        $hedf=$hf - $hi - $j->almuerzo;
                    }
                    if($festivo=="no"){
                        $dtsc=$hf - $hi -  $j->almuerzo;
                    }
                    $henf = $this->calcularHeno($hi,$hf);
                    $hedf = $hedf-$henf;
                    //dd($hedf);
                    //rnd
                    if (($hi < 21)&&($hi > 6)&&($hf>21)&&($hf<=24)){
                        $rnd = $hf - 21;
                    }
                    if (($hi >= 21)&&($hf<=24)){
                        $rnd = $hf - $hi;
                    }
                    if (($hi >=0 )&&($hi <=6 )&&($hf>6)){
                        $rnd = 6 - $hi;
                    }
                    if (($hi >= 0)&&($hf<=6)){
                        $rnd = $hf - $hi;
                    }
                }
            }
            
            $horas_diurnas =0;
            $horas_nocturnas=0;
            if (($especial == false)&&(($numdia < $turno->dia_inicio)||($numdia > $turno->dia_fin))){
               
                
                if ($hi < $fin_diurno && $hf > $inicio_diurno) { // si hay alguna intersección entre los intervalos
                    // calculamos las horas dentro del intervalo de 6 a 21
                    $horas_diurnas = min($hf, $fin_diurno) - max($hi, $inicio_diurno);
                    // imprimimos el resultado

                } else {
                    // no hay intersección entre los intervalos
                    //echo "No hay horas dentro del rango de 6 a 21.";
                    $horas_nocturnas = min($hf, $fin_diurno) - max($hi, $inicio_diurno);
                }

                if (($numdia > 0)&&($festivo=="no")){
                    $hedo = $horas_diurnas -  $j->almuerzo;
                    $heno = $horas_nocturnas;
                }
                if (($numdia == 0)||($festivo=="si")){
                    $hedf = $horas_diurnas -  $j->almuerzo;
                    $henf= $horas_nocturnas;
                }
            }

            
                $valores = [
                    'emp' => $j->trabajador->cc,
                    'concepto' => '',
                    'centro' => $j->cdcinfo->centro_operacion,
                    'proyecto' => $j->proyecto,
                    'fecha' => str_replace("-","",$j->fecha),
                    'horas' => 0,
                    'unidad' => $j->cdcinfo->unidad_negocio
                ];
                //dd($sb);
               
                if ($sb>0){
                    //dd($sb);
                    $valores['concepto']="001";
                    $valores['horas'] = $sb;
                    $tsb[$j->fecha] = $tsb[$j->fecha] + $sb;
                    $ttsb = $ttsb + $sb;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if ($hedo>0){
                
                    $valores['concepto']="006";
                    $valores['horas'] = $hedo;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if ($heno>0){
                    $valores['concepto']="007";
                    $valores['horas'] = $heno;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($rno>0){
                    $valores['concepto']="012";
                    $valores['horas'] = $rno;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($dtc>0){
                    $valores['concepto']="010";
                    $valores['horas'] = $dtc;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($hedf>0){
                    $valores['concepto']="008";
                    $valores['horas'] = $hedf;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($henf>0){
                    $valores['concepto']="009";
                    $valores['horas'] = $henf;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($rnd>0){
                    $valores['concepto']="014";
                    $valores['horas'] = $rnd;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
            
        }
        //dd($tsb);
        $datos2 = collect([]);
        foreach ($datos as $d){
            if ($d['codigo del concepto']=='001'){
                $cc = $d['codigo del empleado'];
                $horas = $d['horas'];
                

                if ($j->trabajador->auxilio>0){
            
                    $auxilio= round(($j->trabajador->auxilio/$ttsb)*$horas,1);
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
        //dd($datos);
        $talmuerzo=0;
        return [$datos,$talmuerzo]; 
    }
    function addLinea($datos,$valores){
        $linea=collect([]);
        $linea->put('codigo del empleado', $valores['emp']);
        $linea->put('sucursal', '');
        $linea->put('codigo del concepto', $valores['concepto']);
        $linea->put('centro de operacion', $valores['centro']);
        $linea->put('centro de costo', $valores['proyecto']);
        $linea->put('fecha movimiento',$valores['fecha'] );
        $linea->put('horas', $valores['horas']);
        $linea->put('valor', '');
        $linea->put('cantidad', '');
        $linea->put('proyecto', '');
        $linea->put('numero de contrato', '');
        $linea->put('unidad de negocio', $valores['unidad']);
        $linea->put('fecha de causacion', '');
        $linea->put('numero de cuotas', '');
        $linea->put('notas', '');
       
        return $linea;

    }
    function calcularHeno($hi,$hf){
        $l1 = 21;
        $l2 = 0;
        $l3 = 6;
        $heno = 0;
      
        // intervalo 1
        if ($hi < $l1 && $hf > $l1) {
          $heno += $hf - $l1;
        } else if ($hi >= $l1 && $hf > $l1) {
          $heno += $hf - $hi;
        } else if ($hi >= $l1 && $hf < $hi) {
          $heno += 24 - $hi;
        }
      
        // intervalo 2
        if ($hi >= $l1 && $hf > $l2 && $hi>$hf) {
          $heno += $hf;
        } else if ($hi >= $l2 && $hf <= $l3) {
          $heno += $hf - $hi;
        } else if ($hi >= $l2 && $hi <= $l3 && $hf > $l3) {
          $heno += $l3 - $hi;
        }
      
        return $heno;
     }
}
