<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Cdc;
use App\Models\Empleado;
use App\Models\Proyecto;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NominaExport;
use App\Exports\OcupacionExport;
use App\Exports\AnaliticasExport;
use App\Exports\ConsultasExport;
use App\Exports\ExtraExport;
use App\Exports\JornadasPendientesExport;
use App\Exports\ProyectosExport;
use App\Models\Detalleh;
use App\Models\Festivo;
use DB;
use Log;
use Carbon\Carbon;
use App\Models\Programacion;

use App\Imports\ImportNovedad;
use App\Imports\importTurnos;
use App\Models\Jornada;
use DateInterval;
use DateTime;

class ExcelController extends Controller
{
    //
    public function export(Request $request)
    {
        $inicio = $request->fechaInicio . " 00:00:00";
        $fin = $request->fechaFinal . " 23:59:59";
        $proyecto = $request->proyecto;
        $responsable = $request->responsable;
        $cliente = $request->cliente;
        $tecnico = $request->tecnico;
        $oauxilio = $request->auxilio;

        $o = DB::table('ordenes')->join('dias', 'ordenes.id', '=', 'dias.ordenes_id')->join('horas', 'dias.id', '=', 'horas.dias_id')->where('ordenes.cliente', '<>', NULL)->where('dias.fecha', '<>', '1900-01-01');
        if ($proyecto != "") {
            $o = $o->where('ordenes.proyecto', $proyecto);
        }
        if ($responsable != "") {
            $o = $o->where('ordenes.responsable', $responsable);
        }
        if ($cliente != "") {
            $o = $o->where('ordenes.cliente', 'like', '%' . $cliente . '%');
        }
        if ($tecnico != "") {
            $o = $o->where('horas.trabajador', $tecnico);
        }
        if (($inicio != " 00:00:00") && ($fin != " 11:59:59")) {
            $o = $o->where('dias.fecha', '>=', $inicio)->where('dias.fecha', '<=', $fin);
        }
        //$o=$o->orderBy('dias.fecha','asc')->orderBy('dias.id','asc')->get();
        //$o=$o->orderBy('dias.fecha','asc')->orderBy('horas.id','asc')->orderBy('horas.hi','asc')->get();

        $o = $o->orderBy('dias.fecha', 'asc')->orderBy('dias.id', 'asc')->get();

        $ordenes = $o;

        foreach ($ordenes as $o) {

            $hi = explode(":", $o->hi);
            $hi_num = intval($hi[0]) + round(floatval($hi[1] / 60), 1);
            $o->hi_num = $hi_num;
        }


        $total = $ordenes->count();
        for ($i = 0; $i < $total; $i++) {
            for ($j = $i + 1; $j < $total; $j++) {
                if ($ordenes[$i]->fecha == $ordenes[$j]->fecha) {

                    if ($ordenes[$i]->hi_num > $ordenes[$j]->hi_num) {
                        $aux = $ordenes[$i];
                        $ordenes[$i] = $ordenes[$j];
                        $ordenes[$j] = $aux;
                    }
                }
            }
        }
        $datos = collect([]);
        $total = array();
        $tsb = array();
        $conts = array();
        //dd($o);
        foreach ($ordenes as $o) {
            if (array_key_exists($o->fecha, $conts)) {
                $conts[$o->fecha] = $conts[$o->fecha] + 1;
            } else {
                $conts[$o->fecha] = 0;
            }

            $centro = Cdc::where('codigo', $o->proyecto)->first();
            $bandextra = 0;


            $c = new Carbon($o->fecha);
            $festivo = $this->consfestivo($o->fecha);
            $numdia = $c->dayOfWeek;

            $extra = 0;
            $inicio = $fin = $rinicio = $rfin = 0;

            if (Programacion::where('cc', $o->trabajador)->where('fecha', $o->fecha)->exists()) {
                $progs = Programacion::where('cc', $o->trabajador)->where('fecha', $o->fecha)->get();

                foreach ($progs as $p) {
                    $hi = explode(":", $p->hi);
                    $hi_num = intval($hi[0]) + round(floatval($hi[1] / 60), 1);
                    $p->hi_num = $hi_num;
                }
                for ($i = 0; $i < $progs->count(); $i++) {
                    for ($j = $i + 1; $j < $progs->count(); $j++) {
                        if ($progs[$i]->hi_num > $progs[$j]->hi_num) {
                            $aux = $progs[$i];
                            $progs[$i] = $progs[$j];
                            $progs[$j] = $aux;
                        }
                    }
                }
                //dd($progs);
                //$prog=Programacion::where('cc',$o->trabajador)->where('fecha',$o->fecha)->orderBy('hi','asc')->skip($conts[$o->fecha])->first();
                $prog = $progs[$conts[$o->fecha]];
                Log::info($conts[$o->fecha]);
                Log::info($prog);
                //dd(Programacion::where('cc',$h['trabajador'])->where('fecha',$d['fecha'])->where('proyecto',$o->proyecto)->get());

                $detallei = explode(":", $prog->hi);
                $inicio = intval($detallei[0]) + round(floatval($detallei[1] / 60), 1);
                $detallef = explode(":", $prog->hf);
                $fin = intval($detallef[0]) + round(floatval($detallef[1] / 60), 1);
                $extra = $prog->extra;
            }



            $emp = Empleado::where('cc', $o->trabajador)->first();

            $ri = explode(":", $o->hi);
            $rinicio = intval($ri[0]) + round(floatval($ri[1] / 60), 2);
            $rfin = explode(":", $o->hf);
            $rfin = intval($rfin[0]) + round(floatval($rfin[1] / 60), 2);
            Log::info($o->fecha . " " . $inicio . " " . $rinicio . " " . $fin . " " . $rfin);
            $sb = $hedo = $heno = $hedf = $henf = $rno = $dtsc = $rnd = 0;
            $rango = $fin - $inicio;
            if (($o->proyecto == 14014) || ($o->proyecto == 13155) || ($o->proyecto == 14002) || ($o->proyecto == 14293)) {
                $almuerzo = 1.5;
            } else {
                $almuerzo = 1;
            }
            if ($rango > 5) {
                $laborales = $rango - $almuerzo;
                $laborales = $rango - $almuerzo;
                if ($laborales > 9.5) {
                    $laborales = 9.5;
                }
            } else {
                $laborales = $rango;
            }
            if ($rango > 0) {

                if ($extra != 1) {

                    if (($numdia > 0) && ($festivo == "no")) {
                        $sb = $o->ha;

                        if (($rfin == $fin) && ($rinicio == $inicio)) {
                            if (($sb > $laborales) && (($laborales == 8.5) || ($laborales == 9.5) || ($laborales == $rango))) {
                                $excede = $sb - $laborales;
                                $sb = $laborales;
                                $hedo = $excede;
                            }
                        }

                        //hedo
                        if (($rfin > $fin) && ($rfin <= 21)) {

                            if (($sb > $laborales) && ($laborales <= $rango)) {
                                $sb = $sb  - ($rfin - $fin);
                                $excede = $sb - $laborales;
                                $sb = $laborales;
                                $hedo = $excede + ($rfin - $fin);
                            } else {
                                $excede = 0;
                            }

                            if ($hedo > $sb) {
                                $sb = $o->ha;
                            }
                            /* $sb = $fin -$inicio;
                                if($sb> $o->ha){
                                    $sb = $o->ha;
                                 }
                                $hedo = $o->ha - $sb;*/
                        }
                        if (($rinicio < $inicio) && ($rinicio >= 6)) {
                            $sb = $sb - ($inicio - $rinicio);
                            $hedo = ($inicio - $rinicio);
                        }

                        //heno
                        if (($rfin > $fin) && ($rfin > 21)) {
                            $sb = $sb - ($rfin - $fin);
                            $hedo =  (21 - $fin);
                            $heno = ($rfin - $fin) - $hedo;
                        }
                        if (($rinicio < $inicio) && ($rinicio < 6)) {
                            $sb = $sb - ($inicio - $rinicio);
                            $hedo = (6 - $rinicio);
                            $heno = ($inicio - $rinicio) - $hedo;
                        }
                        //rno
                        if (($rinicio < 21) && ($rinicio > 6) && ($rfin > 21) && ($rfin <= 24)) {
                            $rno = $rfin - 21;
                        }
                        if (($rinicio >= 21) && ($rfin <= 24)) {
                            $rno = $rfin - $rinicio;
                        }
                        if (($rinicio >= 0) && ($rinicio <= 6) && ($rfin > 6)) {
                            $rno = 6 - $rinicio;
                        }
                        if (($rinicio >= 0) && ($rfin <= 6)) {
                            $rno = $rfin - $rinicio;
                        }
                        if ($rno > $sb) {
                            $rno = $sb;
                        }
                    }

                    //hedf
                    if (($numdia == 0) || ($festivo == "si")) {

                        if ($festivo == "si") {
                            $sb = $o->ha;
                        }
                        if ($festivo == "no") {
                            $dtsc = $o->ha;
                        }

                        //hedf
                        if (($rfin > $fin) && ($rfin <= 21)) {
                            $sb = $sb  - ($rfin - $fin);
                            $hedf = $rfin - $fin;
                        }
                        if (($rinicio < $inicio) && ($rinicio >= 6)) {
                            $sb = $sb - ($inicio - $rinicio);
                            $hedf = ($inicio - $rinicio);
                        }

                        //henf
                        if (($rfin > $fin) && ($rfin > 21)) {
                            $sb = $sb - ($rfin - $fin);
                            $hedf =  (21 - $fin);
                            $henf = ($rfin - $fin) - $hedf;
                        }
                        if (($rinicio < $inicio) && ($rinicio < 6)) {
                            $sb = $sb - ($inicio - $rinicio);
                            $hedf = (6 - $rinicio);
                            $henf = ($inicio - $rinicio) - $hedf;
                        }



                        //rnd
                        if (($rinicio < 21) && ($rinicio > 6) && ($rfin > 21) && ($rfin <= 24)) {
                            $rnd = $rfin - 21;
                        }
                        if (($rinicio >= 21) && ($rfin <= 24)) {
                            $rnd = $rfin - $rinicio;
                        }
                        if (($rinicio >= 0) && ($rinicio <= 6) && ($rfin > 6)) {
                            $rnd = 6 - $rinicio;
                        }
                        if (($rinicio >= 0) && ($rfin <= 6)) {
                            $rnd = $rfin - $rinicio;
                        }
                    }
                    if (($festivo == "si") && (($centro->codigo != 9933) || ($centro->codigo != 13920))) {
                        $dtsc = $sb = 0;
                    }
                }

                if ($extra == 1) {

                    if (($numdia > 0) && ($festivo != "si")) {

                        if ($rfin >= 6 && $rfin <= 21) {
                            if ($rinicio >= 6) {
                                $hedo = $o->ha;
                            } else {
                                $hedo = ($o->ha) - (6 - $rinicio);
                                $heno = (6 - $rinicio);
                            }
                        }
                        if (($rinicio >= 6) && ($rfin > 21)) {
                            $heno = $rfin - 21;
                            if ($heno > $o->ha) {
                                $heno = $o->ha;
                            }
                            $hedo = $o->ha - $heno;
                        }
                        if (($rinicio > 21) && ($rfin <= 24)) {
                            $heno = $rfin - $rinicio;
                            if ($heno > $o->ha) {
                                $heno = $o->ha;
                            }
                            $hedo = $o->ha - $heno;
                        }
                        if (($rinicio >= 0) && ($rfin <= 6)) {
                            $heno = $rfin - $rinicio;
                            if ($heno > $o->ha) {
                                $heno = $o->ha;
                            }
                        }
                        /*
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
                            */
                    }
                    if (($numdia == 0) || ($festivo == "si")) {
                        if (($rfin > 6) && ($rfin <= 21)) {
                            //dd("extra1");
                            if ($rinicio < 6) {
                                $henf = 6 - $rinicio;
                                $hedf = $o->ha - $henf;
                            } else {
                                $hedf = $o->ha;
                            }
                        } else {
                            if ($rfin > 21) {
                                //dd("extra2");
                                $henf = $fin - 21;
                            }
                            if (($rfin <= 6) && ($rinicio >= 0)) {
                                // dd("extra3");
                                $henf = $fin - $inicio;
                            }
                            $hedf = $o->ha - $henf;
                        }
                        /*
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
                            }*/
                    }
                }
            } //fin rango >0
            if (($tecnico == "") || ($tecnico != "" && $tecnico == $o->trabajador)) {
                //dd($extra);
                $auxilio = round((($emp->auxilio) / 240) * $sb, 1);
                if (array_key_exists($o->trabajador, $total)) {
                    $total[$o->trabajador] = $total[$o->trabajador] + $o->ha;
                } else {
                    $total[$o->trabajador] = $o->ha;
                }

                if (array_key_exists($o->trabajador, $total)) {
                    if (($total[$o->trabajador] > 47.5) && (($centro->codigo == 9933) || ($centro->codigo == 13920)) && ($bandextra == 0)) {
                        // dd($sb);
                        $bandextra = 1;
                        if (($numdia == 0)) {
                            if ($henf > 0) {
                                $henf2 = $total[$o->trabajador] - 47.5;
                                $henf = $henf2;
                                $dtsc = $dtsc - $henf;
                            } else {
                                $hedf2 = $total[$o->trabajador] - 47.5;
                                $hedf = $hedf2;
                                $dtsc = $dtsc - $hedf;
                            }
                        } else {
                            if ($hedo == 0) {
                                $hedo2 = $total[$o->trabajador] - 47.5;
                                $hedo = $hedo2;
                                $sb = $sb - $hedo;
                            }
                        }
                    }

                    if (($total[$o->trabajador] < 47.5) && (($centro->codigo == 9933) || ($centro->codigo == 13920))) {
                        if (($festivo == 'no')) {
                            $sb = $o->ha;
                            // $dtsc=$h['ha']-$rnd;
                            $dtsc = 0;
                            $hedf = 0;
                            $henf = 0;
                            $hedo = 0;
                            $heno = 0;
                        }
                    }
                    //Log::info("Hedf(008):".$hedf." Henf(009):".$henf);
                }


                //horas
                if ($sb > 0) {
                    //dd($sb);
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '001');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                    if (array_key_exists($o->trabajador, $tsb)) {
                        $tsb[$o->trabajador] = $tsb[$o->trabajador] + $sb;
                    } else {
                        $tsb[$o->trabajador] = $sb;
                    }
                }
                if (($hedo > 0) && ($sb >= 0)) {
                    //dd($hedo);

                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '006');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if ($heno > 0) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '007');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if ($hedf > 0) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '008');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if ($henf > 0) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '009');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if (($rno > 0) && ($heno == 0)) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '012');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if (($rnd > 0) && ($henf == 0)) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    //$linea->put('codigo del concepto', '013');
                    $linea->put('codigo del concepto', '014');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
                if ($dtsc > 0) {
                    $linea = collect([]);
                    $linea->put('codigo del empleado', $o->trabajador);
                    $linea->put('sucursal', '');
                    $linea->put('codigo del concepto', '011');
                    $linea->put('centro de operacion', $centro->centro_operacion);
                    $linea->put('centro de costo', $centro->codigo);
                    $linea->put('fecha movimiento', str_replace("-", "", $o->fecha));
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
        //dd($tsb);
        if ($oauxilio == "si") {
            $datos2 = collect([]);
            foreach ($datos as $d) {
                if ($d['codigo del concepto'] == '001') {
                    $cc = $d['codigo del empleado'];
                    $horas = $d['horas'];
                    $emp = Empleado::where('cc', $cc)->first();

                    if ($emp->auxilio > 0) {

                        $auxilio = round(($emp->auxilio / $tsb[$cc]) * $horas, 1);
                        $linea = collect([]);
                        /*$linea->put('total',$total[$cc]);
                        $linea->put('auxilio',$emp->auxilio);
                        $linea->put('horas',$horas);*/

                        $linea->put('codigo del empleado', $cc);
                        $linea->put('sucursal', '');
                        $linea->put('codigo del concepto', '075');
                        $linea->put('centro de operacion', $d['centro de operacion']);
                        $linea->put('centro de costo', $d['centro de costo']);
                        $linea->put('fecha movimiento', $d['fecha movimiento']);
                        $linea->put('horas', '');
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
            foreach ($datos2 as $d) {
                $datos->push($d);
            }
        }
        //return $datos;


        //$datos2 = $datos2->sortBy(['codigo del empleado','fecha movimiento']);
        //dd($datos2);
        $datos = $datos->sortBy(['codigo del empleado', 'fecha movimiento']);
        return Excel::download(new NominaExport($datos), 'nomina.xlsx');
    }

    public function exportt(Request $request)
    {
        //dd($request);
        $datos = app(DistribucionController::class)->getDatosDistribucion($request);
        $datos = $datos[0]->sortBy(['codigo del empleado', 'fecha movimiento']);
        return Excel::download(new NominaExport($datos), 'nomina.xlsx');
    }

    public function consfestivo($fecha)
    {
        if (Festivo::where('fecha', $fecha)->exists()) {
            return 'si';
        }
        return 'no';
    }

    public function export_jornadas_faltantes(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
        $empleado = $request->empleado;

        if ($empleado != '' && $empleado != '0' && $empleado != null) {
            $empleados = Empleado::where('id', $empleado)->where('estado', 1)->with([
                'ncargo' => function ($query) {
                    $query->select('id', 'cargo');
                }
            ])->get(['id', 'nombre', 'apellido1', 'cc', 'cargo']);
        } else {
            $empleados = Empleado::where('estado', 1)->with([
                'ncargo' => function ($query) {
                    $query->select('id', 'cargo');
                }
            ])->get(['id', 'nombre', 'apellido1', 'cc', 'cargo']);
        }

        $fecha_incio_corte = new DateTime($fecha_inicio);
        $fecha_fin_corte = new DateTime($fecha_fin);

        $jornadas_group_by_user = Jornada::where('fecha', '>=', $fecha_incio_corte)->where('fecha', '<=', $fecha_fin_corte)->get()->groupBy(['user_id', 'fecha']);
        $jornadas_pendientes_by_user = [];


        foreach ($empleados as $empleado) {
            $fecha_incio_corte = new DateTime($fecha_inicio);
            $fecha_fin_corte = new DateTime($fecha_fin) > Carbon::now()->format('Y-m-d') ? new DateTime(Carbon::now()->format('Y-m-d')) : new DateTime($fecha_fin);
            for ($i = $fecha_incio_corte; $i < $fecha_fin_corte; $i->add(new DateInterval('P1D'))) {
                if (!isset($jornadas_group_by_user[$empleado->id][$i->format('Y-m-d')])) {
                    if (!isset($jornadas_pendientes_by_user[$empleado->id])) {

                        $jornadas_pendientes_by_user[$empleado->id] = [
                            'nombre' => $empleado->nombre,
                            'apellido1' => $empleado->apellido1,
                            'cc' => $empleado->cc,
                            'jornadas_faltantes' => [$i->format('Y-m-d') => ['duracion' => '00:00', 'color' => '#fecaca']],
                            'cargo' => $empleado->ncargo->cargo ?? '',
                        ];
                    } else {
                        $jornadas_pendientes_by_user[$empleado->id]['jornadas_faltantes'][$i->format('Y-m-d')] = ['duracion' => '00:00', 'color' => '#fecaca'];
                    }
                } else {
                    $almuerzo = $jornadas_group_by_user[$empleado->id][$i->format('Y-m-d')][0]->almuerzo;
                    $duracion = $jornadas_group_by_user[$empleado->id][$i->format('Y-m-d')][0]->duracion;
                    $duracion  = explode(":", $duracion);
                    $duracion = intval($duracion[0]) + round(floatval($duracion[1] / 60), 2);
                    $total = $duracion - $almuerzo;

                    $color = $duracion >= 9.5 ? '#6ee7b7' : '#fef08a';

                    if ($total < 0) {
                        $total = '00:00';
                    } else {
                        $decimal = $total - intval($total);
                        $decimal = $decimal * 60;
                        $total = intval($total) > 10? intval($total) . ':' . intval($decimal) : '0' . intval($total) . ':' . intval($decimal);
                    }

                    if (!isset($jornadas_pendientes_by_user[$empleado->id])) {
                        $jornadas_pendientes_by_user[$empleado->id] = [
                            'nombre' => $empleado->nombre,
                            'apellido1' => $empleado->apellido1,
                            'cc' => $empleado->cc,
                            'jornadas_faltantes' => [$i->format('Y-m-d') => ['duracion' => $total, 'color' => $color]],
                            'cargo' => $empleado->ncargo->cargo ?? '',
                        ];
                    } else {
                        $jornadas_pendientes_by_user[$empleado->id]['jornadas_faltantes'][$i->format('Y-m-d')] = ['duracion' => $total, 'color' => $color];
                    }
                }
            }
        }

        $fechas_columnas = [];
        $fecha_incio_columna = new DateTime($fecha_inicio);
        $fecha_fin_columna = new DateTime($fecha_fin) > Carbon::now()->format('Y-m-d') ? new DateTime(Carbon::now()->format('Y-m-d')) : new DateTime($fecha_fin);

        while ($fecha_incio_columna <= $fecha_fin_columna) {
            array_push($fechas_columnas, $fecha_incio_columna->format('Y-m-d'));
            $fecha_incio_columna->add(new DateInterval('P1D'));
        }


        return Excel::download(new JornadasPendientesExport($jornadas_pendientes_by_user, $fechas_columnas), 'jornadas_pendientes_por_empleado.xlsx');
        return view('tabla_jornadas_faltantes', [
            'jornadas_pendientes' => $jornadas_pendientes_by_user,
            'fechas_columnas' => $fechas_columnas,
        ]);
    }

    public function exporto(Request $request)
    {
        //dd($request);
        $datos = app(PagesController::class)->getDatosDistribucionO($request);
        //dd($datos);
        return Excel::download(new OcupacionExport($datos[0]), 'ocupacion.xlsx');
    }

    public function exporta(Request $request)
    {
        //dd($request);
        $datos = app(PagesController::class)->getDatosAnaliticas($request);
        //dd($datos);
        return Excel::download(new AnaliticasExport($datos), 'analiticas.xlsx');
    }

    public function exportextra(Request $request)
    {
        //dd($request);
        $datos = app(PagesController::class)->getDatosExtra($request);
        //dd($datos);
        return Excel::download(new ExtraExport($datos), 'extra.xlsx');
    }

    public function exportProyectos()
    {
        $datos = Proyecto::orderBy('codigo', 'asc')->get();
        return Excel::download(new ProyectosExport($datos), 'proyectos.xlsx');
    }

    public function exportConsultas(Request $request)
    {
        $jornadas = Jornada::query();

        if ($request->proyecto) {
            $jornadas->where('proyecto', $request->proyecto);
        }

        if ($request->trabajador) {
            $jornadas->where('user_id', $request->trabajador);
        }
        if ($request->cliente) {
            $clientId = $request->cliente;
            $jornadas = $jornadas->whereHas('proyectoinfo', function ($query) use ($clientId) {
                $query->where('cliente_id', $clientId);
            });
        }
        if ($request->inicio && $request->fin) {
            $jornadas->whereBetween('fecha', [$request->inicio, $request->fin]);
        }

        if ($request->estado) {
            $jornadas->where('estado', $request->estado);
        }

        $jornadas = $jornadas->orderBy('fecha', 'asc')->get();

        return Excel::download(new ConsultasExport($jornadas), 'jornadas.xlsx');
    }

    public function importHoras(Request $request)
    {
        Excel::import(new ImportNovedad, $request->file('file')->store('files'));
        return redirect()->back();
    }

    public function importTurnos(Request $request)
    {
        Excel::import(new importTurnos, $request->file('file')->store('files'));
        return redirect()->back();
    }
}
