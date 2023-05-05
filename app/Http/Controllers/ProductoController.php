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
    public function index()
    {
        $productos = Producto::paginate(5);
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
        //validar
        $request->validate([
            "nombre"=>"required",
            "categoria_id" => "required"
        ]);
      // guardar
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->categoria_id - $request->categoria_id;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->save();
        return response()->json (["mensaje" => "Producto registrado"], 201);
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
        // validar
        $request->validate([
        "nombre" =>"required",
        "categoria_id" => "required"
        ]);
        // guardar
        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->stock = $request->stock;
        $producto->precio = $request->precio;
        $producto->descripcion = $request->descripcion;
        $producto->save();
        return response() ->json (["mensaje" => "Producto actualizado"], 201);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json (["mensaje" => "Producto eliminado"], 200);
    }
}
