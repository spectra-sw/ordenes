<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jornada;
use App\Models\Cdc;
use App\Models\Empleado;
use Carbon\Carbon;

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
        if ($request->inicio && $request->fin) {
            
            $jornadas->whereBetween('fecha', [$request->inicio, $request->fin]);
        }
        if ($request->estado) {
            $jornadas->where('estado', $request->estado);
        }
        $jornadas = $jornadas->get();

        $datos = collect([]);
        $tsb=0;
        $talmuerzo = 0;
        foreach ($jornadas as $j){
            $hi = explode(":", $j->hi);
            $hi =intval($hi[0]) + round(floatval($hi[1]/60),1);
            //dd($hi);
            $hf = explode(":", $j->hf);
            $hf =intval($hf[0]) + round(floatval($hf[1]/60),1);

            //dd($hf);
            /*if ($j->tipo == 0){
                $talmuerzo = $talmuerzo + ($hf-$hi);
            }*/

            if ($j->tipo == 1){
                $centro = Cdc::where('codigo',$j->proyecto)->first();
                $festivo = app('App\Http\Controllers\FilesController')->consfestivo($j->fecha);
                $c = new Carbon($j->fecha);
                $numdia = $c->dayOfWeek;
                $emp=Empleado::where('id',$j->user_id)->first();
                $sb = $hedo = $heno= $hedf = $henf = $rno = $dtsc = $rnd = 0;

                $duracion  = explode(":", $j->duracion);
                $duracion =intval($duracion[0]) + round(floatval($duracion[1]/60),1);
                $laborales = 9.5;
                if (($numdia > 0)&&($festivo=="no")){
                    $sb = $duracion - $j->almuerzo;
                    //dd($sb);
                    if ($sb>$laborales){
                        $excede = $sb -$laborales;
                        $sb =$laborales;
                        $hedo = $excede;  
                    }
                    $heno = $this->calcularHeno($hi,$hf);
                    //dd($heno);
                    $sb = $sb-$heno;
                    //dd($sb);
                    if($sb==0){
                        $rno=$heno;
                    }
            
                }
                if (($numdia == 0)||($festivo=="si")){
                    if($festivo=="si"){
                        $hedf=$hf - $hi;
                    }
                    if($festivo=="no"){
                        $dtsc=$hf - $hi;
                    }
                    $henf = $this->calcularHeno($hi,$hf);
                    $hedf = $hedf-$henf;

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
                $valores = [
                    'emp' => $emp->cc,
                    'concepto' => '',
                    'centro' => $centro->centro_operacion,
                    'proyecto' => $j->proyecto,
                    'fecha' => str_replace("-","",$j->fecha),
                    'horas' => 0,
                    'unidad' => $centro->unidad_negocio
                ];
                //dd($sb);
                if ($sb>0){
                    //dd($sb);
                    $valores['concepto']="001";
                    $valores['horas'] = $sb;
                    $tsb = $tsb + $sb;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if ($hedo>0){
                    //dd($sb);
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
                if($dtsc>0){
                    $valores['concepto']="011";
                    $valores['horas'] = $dtsc;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($hedf>0){
                    $valores['concepto']="008";
                    $valores['horas'] = $hedf;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
                if($rnd>0){
                    $valores['concepto']="014";
                    $valores['horas'] = $hedf;
                    $linea = $this->addlinea($datos,$valores); 
                    $datos->push($linea); 
                }
            }
        }
        //dd($datos);
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
        $heno = 0;

        if ($hi>$hf){
            if ($hi >= 21){
                $heno = $heno + (24-$hi);
            }
            if ($hi < 21){
                $heno = 3;
            }
        }        
        if ($hf < $hi){
            if ($hf >6){
                $heno = $heno + 6;
            }
            if ($hf <=6 ){
                $heno = $heno + $hf;
            }
        }
       /* if (($hi < 21)&&($hi > 6)&&($hf > 21)&&($hf<=24)){
            $heno = $hf - 21;
        }
        if (($hi >= 21)&&($hf<=24)){
            $heno = $hf - $hi;
        }
        if (($hi >=0 )&&($hi <=6 )&&($hf>6)){
            $heno = 6 - $hi;
        }
        if (($hi >= 0)&&($hf<=6)){
            $heno = $hf - $hi;
        }*/
        
        return $heno;
    }
}
