<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class ConsultasController extends Controller
{
    //
    public function consultas(){
        $employees = Empleado::where('estado',1)->orderBy('apellido1','asc')->get();
        return view('timetracker.consultas',[
            'emp' => $employees
        ]);
    }
}
