<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Cliente;

class ConsultasController extends Controller
{
    //
    public function consultas(){
        $employees = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        $clientes = Cliente::orderby('cliente','asc')->get();
        return view('timetracker.consultas',[
            'emp' => $employees,
            'clientes' => $clientes
        ]);
    }
}
