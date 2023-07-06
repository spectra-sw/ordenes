<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Empleado;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function modalTurnoAcciones(Request $request){
        $accion = $request->accion;

        switch ($accion) {
            case 2:
                $empleados = Empleado::orderBy('apellido1','asc')->get();
                $turno = Turno::where('id',$request->turno_id)->first();
                return view('admin.modal.turnoModal',[
                    'accion' => 2,
                    'empleados' => $empleados,
                    'turno' => $turno,
                ]);
                break;
            default:
                break;
        }
    }

    public function showTable()
    {
        // get all turno
        $turnos = Turno::select('id', 'user_id', 'fecha_inicio', 'hora_inicio', 'fecha_fin', 'hora_fin', 'almuerzo')
            ->with([
                'empleado' => function ($query) {
                    return $query->select('cc', 'id', 'apellido1', 'apellido2', 'nombre');
                },
            ])
            ->get();

        return view('admin.tabla.turnoTabla', [
            'turnos' => $turnos
        ]);
    }

    public function update(Request $request)
    {
        // validated
        $validated = $request->validate([
            'user_id' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'hora_inicio' => 'required|numeric',
            'hora_fin' => 'required|numeric',
            'almuerzo' => 'required|numeric',
        ]);
        // turno
        $turno = Turno::where('id', $request->turno_id)->first();

        // upate turno
        $turno->user_id = $request->user_id;
        $turno->fecha_inicio = $request->fecha_inicio;
        $turno->fecha_fin = $request->fecha_fin;
        $turno->hora_inicio = $request->hora_inicio;
        $turno->hora_fin = $request->hora_fin;
        $turno->almuerzo = $request->almuerzo;
        $turno->save();

        return response()->json([
            'message' => 'Turno actualizado correctamente',
        ]);
    }

    public function destroy(Turno $turno)
    {
        //
    }
}
