<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MensajesController extends Controller
{
    //
    public function error(Request $request){
        return view('mensajes.error',[
            'mensaje' => $request->mensaje
        ]);
    }
    public function exito(Request $request){
        return view('mensajes.exito',[
            'mensaje' => $request->mensaje
        ]);
    }
}
