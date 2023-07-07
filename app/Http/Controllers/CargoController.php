<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Empleado;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function modalCargoAcciones(Request $request)
    {
        $accion = $request->accion;
        $cargo_id = $request->cargo_id ?? null;

        switch ($accion) {
            case 1:
                return view('admin.modal.cargoModal', [
                    'accion' => 1,
                ]);
                break;
            case 2:
                $cargo = Cargo::where('id', $cargo_id)->first();
                return view('admin.modal.cargoModal', [
                    'accion' => 2,
                    'cargo' => $cargo,
                ]);
                break;
            case 3:
                $cargo = Cargo::where('id', $cargo_id)->first();
                return view('admin.modal.cargoModal', [
                    'accion' => 3,
                    'cargo' => $cargo,
                ]);
                break;
            default:
                break;
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'cargo' => 'required|max:100|unique:cargos,cargo',
        ]);

        $cargo = new Cargo();
        $cargo->cargo = $request->cargo;
        $cargo->extra = 0;
        $cargo->save();

        return response()->json([
            "message" => "Cargo creado correctamente",
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cargo' => 'required|max:100|unique:cargos,cargo,' . $request->cargo_id,
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        $cargo = Cargo::where('id', $request->cargo_id)->first();
        $cargo->cargo = $request->cargo;
        $cargo->save();

        return response()->json([
            "message" => "Cargo actualizado correctamente",
        ]);
    }

    public function toggleEstado(Request $request)
    {
        $cargo = Cargo::where('id', $request->cargo_id)->first();
        $cargo->estado = !$cargo->estado;
        $cargo->save();

        return response()->json([
            "message" => "Cargo " . ($cargo->estado? 'activado': 'inactivado') . " correctamente",
        ]);
    }

    public function showTable()
    {
        $cargos = Cargo::all();
        return view("admin.tabla.cargosTabla", ["cargos" => $cargos]);
    }
}
