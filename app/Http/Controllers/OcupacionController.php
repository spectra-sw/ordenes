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
        $user_ciudad = Empleado::where('id', $user_id)->first()->ciudad;
        $today_date = Carbon::now();
        $input_date = new Carbon($request->dia);
        $date_july_15 = Carbon::createFromDate(2023, 7, 15);
        $friday_hours = $input_date->gte($date_july_15) ? 8.5 : 9.5;
        
        $date_july_2025 = Carbon::createFromDate(2025, 6, 30);
        $date_july_2026 = Carbon::createFromDate(2026, 7, 1);

        if ($input_date->gte($date_july_2026)) {
            // Desde 1 Jul 2026: lunes = 8h, martes-viernes = 8.5h
            $max_hours = $input_date->dayOfWeek == 1 ? 8.0 : 8.5;
        } elseif ($input_date->gte($date_july_2025) && $user_ciudad == 'BOGOTA') {
            // New rules after July 1, 2025 for BOGOTA
            $max_hours = $input_date->dayOfWeek == 5 ? 7.5 : 9.0; // Friday = 7.5, Mon-Thu = 9.0
        } elseif ($input_date->gte($date_july_2025)) {
            // New rules after July 1, 2025 for other cities
            $max_hours = $input_date->dayOfWeek == 1 ? 7.5 : 9.0; // Monday = 7.5, Tue-Fri = 9.0
        } else {
            // Keep existing logic for dates before July 1, 2025
            $max_hours = $input_date->gte($date_july_15) ? 8.5 : 9.5;
        }

        
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

        /*if ($hours_completed > $friday_hours && ($input_date->dayOfWeek == 5||$input_date->dayOfWeek == 4)) {
            return "La horas que desea registrar superan las 8,5 horas";
        }

        if ($hours_completed > 9.5) {
            return "La horas que desea registrar superan las 9,5 horas";
        }*/
        if ($hours_completed > $max_hours) {
            if ($input_date->gte($date_july_2026)) {
                if ($input_date->dayOfWeek == 1) {
                    return "Las horas que desea registrar superan las 8 horas permitidas para el lunes";
                } else {
                    return "Las horas que desea registrar superan las 8,5 horas permitidas";
                }
            } elseif ($input_date->gte($date_july_2025)) {
                if ($input_date->dayOfWeek == 1) {
                    return "Las horas que desea registrar superan las 7,5 horas permitidas para lunes";
                } else {
                    return "Las horas que desea registrar superan las 9 horas permitidas";
                }
            } else {
                if ($input_date->dayOfWeek == 5 || $input_date->dayOfWeek == 4) {
                    return "Las horas que desea registrar superan las 8,5 horas";
                }
                return "Las horas que desea registrar superan las 9,5 horas";
            }
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
        $area        = $request->area;
        $responsable = $request->responsable;
        $fechaInicio = new Carbon($request->fechaInicioOcup1);
        $fechaFin    = new Carbon($request->fechaFinalOcup1);

        // Filter employees upfront — responsable takes priority over area
        $query = Empleado::where('estado', 1)->with('narea');
        if ($responsable != "") {
            $query->where('cc', $responsable);
        } elseif ($area != "") {
            $query->where('area', $area);
        } else {
            $query->where('area', '>', 1);
        }
        $empleados = $query->orderBy('area', 'asc')->get();

        // Pre-load festivos in the date range as a hash for O(1) lookup
        $festivosHash = Festivo::whereBetween('fecha', [
            $fechaInicio->toDateString(),
            $fechaFin->toDateString(),
        ])->pluck('fecha')->flip()->all();

        // Pre-load all ocupaciones for these employees in the date range
        $ccs = $empleados->pluck('cc');
        $ocupacionesMap = ocupacion::whereIn('cc', $ccs)
            ->whereBetween('dia', [$fechaInicio->toDateString(), $fechaFin->toDateString()])
            ->get()
            ->groupBy(function ($o) {
                return $o->cc . '_' . Carbon::parse($o->dia)->toDateString();
            });

        $seguimiento = collect([]);

        foreach ($empleados as $empleado) {
            $date_current = $fechaInicio->copy();

            while ($date_current <= $fechaFin) {
                $fechaStr = $date_current->toDateString();
                $fila = collect([]);
                $fila->put('cc', $empleado->cc);
                $fila->put('nombre', $empleado->nombre . " " . $empleado->apellido1);
                $fila->put('area', $empleado->narea->area);
                $fila->put('fecha', $fechaStr);

                $total_hours_worked = 0;
                $employee_tracking  = null;

                // Non-working day check using pre-loaded hash
                if (isset($festivosHash[$fechaStr]) || $date_current->dayOfWeek === 0 || $date_current->dayOfWeek === 6) {
                    $employee_tracking = "NH";
                }

                if ($employee_tracking === null) {
                    $key = $empleado->cc . '_' . $fechaStr;
                    $registros = $ocupacionesMap->get($key, collect([]));
                    $total_hours_worked = $registros->sum('horas') + ($registros->sum('minutos') / 60);
                    $employee_tracking  = $total_hours_worked;
                }

                $max_hours = $this->getMaxHorasOcupacion($date_current, $empleado->ciudad ?? '');

                // Color coding
                if ($employee_tracking === "NH") {
                    $clase = 'table-default';
                } elseif ($total_hours_worked === 0) {
                    $clase = 'table-danger';
                } elseif ($total_hours_worked < $max_hours) {
                    $clase = 'table-warning';
                } else {
                    $clase = 'table-success';
                }

                $fila->put('registro', $employee_tracking);
                $fila->put('clase', $clase);

                $seguimiento->push($fila);
                $date_current->addDay();
            }
        }

        return view('seguimiento', ['seguimiento' => $seguimiento]);
    }

    private function getMaxHorasOcupacion(Carbon $fecha, string $ciudad): float
    {
        $dateJul2026 = Carbon::createFromDate(2026, 7, 1);
        $dateJul2025 = Carbon::createFromDate(2025, 7, 1);
        $dateJul2023 = Carbon::createFromDate(2023, 7, 15);

        if ($fecha->gte($dateJul2026)) {
            return $fecha->dayOfWeek === 1 ? 8.0 : 8.5; // lunes = 8h, mar-vie = 8.5h
        }

        if ($fecha->gte($dateJul2025)) {
            if (strtoupper($ciudad) === 'BOGOTA') {
                return $fecha->dayOfWeek === 5 ? 7.5 : 9.0; // viernes corto en Bogotá
            }
            return $fecha->dayOfWeek === 1 ? 7.5 : 9.0; // lunes corto en otras ciudades
        }

        if ($fecha->gte($dateJul2023)) {
            return $fecha->dayOfWeek === 5 ? 8.5 : 9.5; // viernes corto
        }

        return 9.5;
    }
}
