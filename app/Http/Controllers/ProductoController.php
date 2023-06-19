<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /// listar los productos con filtro paginacion 
        // listar | /api//producto?page=2&limit=10q=laptop&orderby=id
        // $page = $request->page;
        $limit = $request->limit ? $request->limit : 10;  /// si existe verdadero : por defecto por 
        $q = $request->q;
        $orderby = $request->orderby ? $request->orderby : 'id'; // si existe verdadero : por defecto ordenado por id

        if ($q) {
            $productos = Producto::where('nombre', 'like', '%' . $q . '%')
                ->orderBy('orderby', 'desc')
                ->paginate($limit);
        } else {
            $productos = Producto::orderBy($orderby, 'desc')->paginate($limit);
        }

        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //guardar
        //validar
        $request->validate([
            "nombre" => 'required|min:3|max:200',
            "categoria_id" => "required",
        ]);

        // subir img
        $direccion_imagen = "";

        // guardar 
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        // responder
        return response()->json(["mensaje" => "producto registrado", "data" => $producto], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
