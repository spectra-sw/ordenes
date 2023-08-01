<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Empleado;
use App\Models\Festivo;
use App\Models\ocupacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OcupacionController extends Controller
{
    public function registerOcupacion(Request $request)
    {
        $user_id = session('user');

        if ($user_id == "") {
            return redirect()->route('inicio');
        }

        $user_cc = Empleado::where('id', $user_id)->first()->cc;
        $today_date = Carbon::now();
        $input_date = new Carbon($request->dia);
        $date_july_15 = Carbon::createFromDate(2023, 7, 15);
        $friday_hours = $input_date->gte($date_july_15) ? 8.5 : 9.5;
        $records_created = ocupacion::where('cc', $user_cc)->where('dia', $request->dia)->get();
        $actividad_id = Actividad::where('actividad', $request->actividad)->first()->id;
        $hours_completed = 0;

        foreach ($records_created as $record) {
            $hours_completed = $hours_completed + $record->horas + ($record->minutos / 60);
        }

        $hours_completed = $hours_completed + $request->horas + ($request->min / 60);

        if (Festivo::where('fecha', $request->dia)->exists()) {
            return 'La fecha seleccionada es un día festivo';
        }

        if (($input_date->dayOfWeek == 0 || $input_date->dayOfWeek == 6)) {
            return 'Solo se pueden seleccionar días de Lunes a Viernes';
        }

        if ($request->horas == 0 && $request->min == 0) {
            return "El tiempo registrado no puede ser 0";
        }

        if ($input_date >= $today_date) {
            return "No es posible registrar una fecha posterior a la actual";
        }

        if ($hours_completed > $friday_hours && $input_date->dayOfWeek == 5) {
            return "La horas que desea registrar superan las 8,5 horas";
        }

        if ($hours_completed > 9.5) {
            return "La horas que desea registrar superan las 9,5 horas";
        }

        $e = ocupacion::create([
            'cc' => $user_cc,
            'dia' => $request->dia,
            'area' => $request->area,
            'actividad' => $actividad_id,
            'proyecto' => $request->proyecto,
            'horas' => $request->horas,
            'minutos' => $request->min,
        ]);

        return "Registro creado";
    }

    public function seguimiento(Request $request)
    {
        $area = $request->area;
        $seguimiento  = collect([]);

        if ($area != "") {
            $empleados = Empleado::where('estado', 1)->where('area', $area)->orderBy('area', 'asc')->get();
        }

        if ($area == "") {
            $empleados = Empleado::where('estado', 1)->where('area', '>', 1)->orderBy('area', 'asc')->get();
        }

        foreach ($empleados as $empleado) {
            $date_current = new Carbon($request->fechaInicioOcup1);
            $end_date = new Carbon($request->fechaFinalOcup1);

            while ($date_current <= $end_date) {
                $fila = collect([]);
                $fila->put('cc', $empleado->cc);
                $fila->put('nombre', $empleado->nombre . " " . $empleado->apellido1);
                $fila->put('area', $empleado->narea->area);
                $fila->put('fecha', $date_current->toDateString());
                $date_july_15 = Carbon::createFromDate(2023, 7, 15);
                $friday_hours = $date_current->gte($date_july_15) ? 8.5 : 9.5;

                $total_hours_worked = 0;
                $employee_tracking = null;

                if (Festivo::where('fecha', $date_current)->exists()) {
                    $employee_tracking = "NH"; // NH = dia no habil
                }

                if ($date_current->dayOfWeek == 0 || $date_current->dayOfWeek == 6) {
                    $employee_tracking = "NH"; // NH = dia no habil
                }

                if (!$employee_tracking) {
                    $user_ocupation = ocupacion::where('cc', $empleado->cc)->where('dia', '=', $date_current)->get();

                    $total_hours_worked = $user_ocupation->sum('horas') + ($user_ocupation->sum('minutos') / 60);
                    $employee_tracking = $total_hours_worked;
                }

                $fila->put('registro', $employee_tracking);
                $fila->put('clase', 'table-default');

                if ($employee_tracking === 0) {
                    $fila->put('clase', 'table-danger');
                }

                if (($total_hours_worked > 0) && ($total_hours_worked < 9.5)) {
                    $fila->put('clase', 'table-warning');
                }

                if ($total_hours_worked == $friday_hours && $date_current->dayOfWeek == 5) {
                    $fila->put('clase', 'table-success');
                }

                if ($total_hours_worked == 9.5) {
                    $fila->put('clase', 'table-success');
                }

                $seguimiento->push($fila);
                $date_current = $date_current->addDay();
            }
        }

        if ($request->responsable != "") {
            $seguimiento = $seguimiento->where('cc', $request->responsable);
        }

        return view('seguimiento', [
            'seguimiento' => $seguimiento,
        ]);
    }
}
