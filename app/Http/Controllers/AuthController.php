<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class AuthController extends Controller
{
    //
    public function validar(Request $request){
        if (Empleado::where('cc',$request->pwd)->where('correo',$request->email)->exists()){
            return "ok";
        }
        else{
            return "* Datos inválidos";
        }
    }
}
