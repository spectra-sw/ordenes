<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function modalClienteAcciones(Request $request)
    {
        $accion = $request->accion;

        switch ($accion) {
            case 1:
                return view('admin.modal.clienteModal', [
                    'accion' => 1,
                ]);
                break;
            case 2:
                $cliente = Cliente::where('id', $request->cliente_id)->first();
                return view('admin.modal.clienteModal', [
                    'accion' => 2,
                    'cliente' => $cliente,
                ]);
                break;
            case 3:
                return view('admin.modal.clienteModal', [
                    'accion' => 3,
                    'cliente_id' => $request->cliente_id,
                ]);
                break;
            default:
                break;
        }
    }

    public function create(Request $request)
    {

        // validate $request
        $request->validate([
            'cliente' => 'required',
            'contactos' => 'required',
        ]);

        Cliente::create([
            'cliente' => $request->cliente,
            'contactos' => $request->contactos,
        ]);

        return response()->json([
            'message' => 'Cliente creado correctamente',
        ]);
    }

    public function update(Request $request)
    {
        // validate $request
        $request->validate([
            'cliente' => 'required',
            'contactos' => 'required',
        ]);

        Cliente::where('id', $request->id)->update([
            'cliente' => $request->cliente,
            'contactos' => $request->contactos,

        ]);

        return response()->json([
            'message' => 'Cliente actualizado correctamente',
        ]);
    }

    public function showTable(Request $request)
    {
        $order_by_campo = $request->campo;

        if ($order_by_campo == '') {
            $clientes = Cliente::orderBy('cliente', 'asc')->get();
        } else {
            $clientes = Cliente::orderBy($order_by_campo, 'asc')->get();
        }

        return view('admin.tabla.clienteTabla', [
            'clientes' => $clientes,
        ]);
    }

    public function destroy(Request $request)
    {
        Cliente::where('id', $request->cliente_id)->delete();

        return response()->json([
            'message' => 'Cliente eliminado correctamente',
        ]);
    }
}
