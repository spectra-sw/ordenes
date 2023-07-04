<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\MagicLink;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {

        if (Empleado::where('correo', $request->email)->exists()) {
            $e = Empleado::where('correo', $request->email)->first();
            $id = $e->id;
            $tipo = $e->tipo;
            $nombre = $e->nombre . " " . $e->apellido1;
            $hashedPassword = Empleado::where('correo', $request->email)->first()->password;
            if (password_verify($request->pwd, $hashedPassword)) {
                session(['user' => $id]);
                session(['tipo' => $tipo]);
                session(['area' => $e->area]);
                session(['nombre' => $nombre]);
                //dd(session()->all());
                return $tipo;
            } else {
                session(['user' => '']);
                session(['tipo' => 3]);
                return "* Datos inválidos";
            }
        } else {
            session(['user' => '']);
            session(['tipo' => 3]);
            return "* Datos inválidos";
        }
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
            'code' => 'required|exists:magic_links,code',
        ]);

        $magic_link = MagicLink::where('code', $request->code)->first();

        // check if code is used
        if ($magic_link->is_used == 1) {
            return response()->json([
                'errors' => [
                    'code' => ['El código ya ha sido utilizado.']
                ]
            ], 400);
        }

        // check if code is expired
        if ($magic_link->created_at->diffInMinutes(now()) > 10) {
            return response()->json([
                'errors' => [
                    'code' => ['El código ha expirado.']
                ]
            ], 400);
        }

        $empleado_id = $magic_link->empleado_id;

        // update password
        $empleado = Empleado::find($empleado_id);
        $empleado->password = Hash::make($request->password);
        $empleado->save();

        // update magic link field is_used to 1
        $magic_link->is_used = 1;
        $magic_link->save();

        return response()->json([
            'message' => 'Se ha actualizado la contraseña correctamente.'
        ]);
    }

    public function sendEmailRecovery(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:empleados,correo',
        ]);

        $empleado_id = Empleado::select('id')->where('correo', $request->email)->first()->id;
        $code = bcrypt("faa48e4bb227c8f6326c4904d3c53ba62d3438840d3d1de5cf1901e4bd78d835");

        MagicLink::create([
            'code' => $code,
            'empleado_id' => $empleado_id,
        ]);

        Mail::to($request->email)->send(new \App\Mail\MailPasswordRecovery($code));

        return response()->json([
            'message' => 'Se ha enviado un correo con las instrucciones para recuperar su contraseña.'
        ]);
    }
}
