<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // si esxite el valor buscado buscamos por  verdad
        if ($request->buscado) {
            $usuarios = User::orWhere('name', 'like', '%' . $request->buscado . '%')
                ->orWhere('email', 'like', '%' . $request->buscado . '%')
                ->get();
        } else {
            // listar usuario
            $usuarios = User::get(); // par obtener todos los datos desde la base de datos
        }

        return response()->json($usuarios, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // guardar

        $request->validate([
            "name" => 'required',
            "email" => 'required|email|unique:users',
            "password" => 'required'
        ]);

        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password); // incriptar importante

        $usuario->save();

        return response()->json(["mensaje" => "Usuario resgistrado", "data" => $usuario], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Mostrar

        $usuario = User::find($id);

        return response()->json($usuario, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Modificar por id

        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
            "password" => "required",
        ]);

        $usuario = User::find($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->update();

        return response()->json(["mensaje" => "Usuario modificado", "data" => $usuario], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Eliminar por id

        $usuario = User::find($id);
        $usuario->delete();

        return response()->json(["mensaje" => "usuario eliminado"], 200);
    }
}
