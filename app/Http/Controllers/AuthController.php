<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        //validar 
        // loguearnos
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // validar correo y password (metodos para verificar y validar un correo de laravel)
        if (!Auth::attempt($credenciales)) {
            return response()->json(["message" => "No Autorizado"], 401);
        }

        // generar tokken

        $user = Auth::user(); // -> captura al usuario actual
        $tokenResult = $user->createToken("Token Auth"); //-> asignar un nombre para la autenticacion, aqui se genera el token
        $token = $tokenResult->plainTextToken;

        // respuesta
        return response()->json([
            "access_token" => $token,
            "token_type" => "Bearer",
            "usuario" => $user
        ]);
    }

    public function registro(Request $request)
    {
        /// 1.- validacion
        // 2.- guardar
        // 3.- respuesta
        $request->validate([
            "nombre" => "required",
            'email' => 'required|email|unique:users', // |email => de tipo email
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $usuario = new User;
        $usuario->name = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        //respuesta
        return response()->json(['mensaje' => 'El usuario ha sido registrado'], 201);
    }

    public function miPerfil()
    {
        // return Auth::user();
        // capturar los datos del usuario actual
        $usuarioCapturado = Auth::user();
        return response()->json($usuarioCapturado, 200); //usario capturado si esta autenticado

    }

    public function cerrar(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(["message" => "Logout"], 200);
    }
}
