<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function validar(Request $request){
        
        if (Empleado::where('correo',$request->email)->exists()){
            $e = Empleado::where('correo',$request->email)->first();
            $id = $e->id;
            $tipo = $e->tipo;
            $nombre = $e->nombre. " ".$e->apellido1;
            $hashedPassword = Empleado::where('correo',$request->email)->first()->password;
            if (password_verify($request->pwd, $hashedPassword)) {
                session(['user' => $id]);
                session(['tipo' => $tipo]);
                session(['nombre' => $nombre]);
            //dd(session()->all());
                return $tipo;
            }
            else {
                session(['user' => '']);
                session(['tipo' => 3]);
                return "* Datos inválidos";
            }
            
            
        }
        else{
            session(['user' => '']);
            session(['tipo' => 3]);
            return "* Datos inválidos";
        }
    }
}
