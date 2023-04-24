<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registrar(Request $request)
    {
        // Validar
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"
        ]);

        // Guardar
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        // Respuesta
        return response()->json(["mensaje" => "Usuario Registrado"], 201);
    }

    public function ingresar(Request $request)
    {
        // Validar
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // Verificar
        if (!Auth::attempt($credenciales)) {
            return response()->json(["mensaje" => "NO AUTORIZADO"], 401);
        }

        // Generar token
        $usuario = $request->user();
        $tokenResult = $usuario->createToken("access_token_name");
        $token = $tokenResult->plainTextToken;

        // Responder
        return response()->json([
            "accessToken" => $token,
            "token_type" => "Bearer",
            "usuario" => $usuario,
        ]);
    }

    public function getPerfil()
    {
        $usuario = Auth::user();

        return response()->json($usuario, 200);
    }

    public function salir()
    {
        $usuario = Auth::user();
        $usuario->tokens()->delete();

        return response()->json(["mensaje" => "Salió"], 200);
    }
}

