<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedore;
use App\Models\User;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ProductosController extends Controller
{


    public function index()
    {
        // $user = Auth::user();

        // Obtener todos los productos del usuario autenticado
        $productos = Producto::with([
            'categoria:id,nombre_categoria',
            'user:id,name',
            'proveedore:id,nombre_proveedor'
        ])
            ->orderBy('id', 'desc')
            ->paginate(6);


        return Inertia::render('Productos/Listado', ['productos' => $productos]);
    }


    public function create()
    {
        $user = Auth::user()->only(['id', 'name']);

        $proveedores = Proveedore::select('id', 'nombre_proveedor')
            ->get();
        $categorias = Categoria::select('id', 'nombre_categoria')
            ->get();


        return Inertia::render('Productos/FormNuevo', [
            'user' => $user,
            'proveedores' => $proveedores,
            'categorias' => $categorias,
        ]);
    }


    public function store(Request $request)
    {
        //validación de los campos
        $request->validate([
            'nombre_producto' => 'required|max:100|string',
            'descripcion' => 'required|max:255',
            'precio_compra' => 'required|numeric',
            'stock' => 'required|integer',
            'proveedore_id' => 'nullable|integer',
            'categoria_id' => 'nullable|integer',
        ]);

        // $user = Auth::user();

        //almacenamiento del producto
        $userId = $request->user['id'];

        Producto::create([
            'nombre_producto' => $request->input('nombre_producto'),
            'descripcion' => $request->input('descripcion'),
            'precio_compra' => $request->input('precio_compra'),
            'stock' => $request->input('stock'),
            'proveedore_id' => $request->input('proveedore_id'),
            'categoria_id' => $request->input('categoria_id'),
            'user_id' => $userId,
        ]);

        return Redirect::route('productos.index')->with('success', 'Producto registrado exitosamente.');
    }

    public function show($id)
    {
        // Implementa la lógica para mostrar detalles específicos del producto si es necesario
    }


    public function edit($id)
    {
        $proveedores = Proveedore::select('id', 'nombre_proveedor')
            ->get();
        $categorias = Categoria::select('id', 'nombre_categoria')
            ->get();

        $producto = Producto::where('id', $id)->first();


        return Inertia::render(
            'Productos/FormEditar',
            [
                'productos' => $producto->only('id', 'nombre_producto', 'descripcion', 'precio_compra', 'stock',  'proveedore_id', 'categoria_id'),
                'proveedores' => $proveedores,
                'categorias' => $categorias,
            ]
        );
    }


    public function update(Request $request, $id)
    {
        $request->validate([

            'nombre_producto' => 'required|max:100|string',
            'descripcion' => 'required|max:255',
            'precio_compra' => 'required|numeric',
            'stock' => 'required|integer',
            'proveedore_id' => 'nullable|integer',
            'categoria_id' => 'nullable|integer',
        ]);

        $producto = Producto::findOrFail($id);
        
        $producto->update($request->all());

        return Redirect::route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }


    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return Redirect::route('productos.index');
    }
}
