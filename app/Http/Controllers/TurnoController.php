<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Empleado;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function printTablaTurnos()
    {
        // get all turno
        $turnos = Turno::all();

        return view('tablaTurnos', [
            'turnos' => $turnos
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function modalFormularioEdit(Turno $turno)
    {
        // get all empleado
        $empleado = Empleado::all();

        return view('formEditarTurno', [
            'turno' => $turno,
            'empleado' => $empleado
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function modalFormularioUpdate(Request $request, Turno $turno)
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
            'data' => $turno
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Turno  $turno
     * @return \Illuminate\Http\Response
     */
    public function destroy(Turno $turno)
    {
        //
    }
}
