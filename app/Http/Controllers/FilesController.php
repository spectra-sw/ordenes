<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Cdc;
use App\Models\Empleado;
class FilesController extends Controller
{
    //
    public function archivon(Request $request){
        $ordenes=Orden::orderBy('created_at','desc')->get();
        
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

        }

        //return $datos;
        $datos = $datos->sortBy('codigo del empleado');
        return view('tablan',[
            'datos' => $datos
        ]);
        
    }
}
