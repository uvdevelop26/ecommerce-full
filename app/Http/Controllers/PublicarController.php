<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use App\Models\Publicar;
use App\Models\Productos;
use Illuminate\Validation\Rule;



use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class PublicarController extends Controller
{


    public function index()
    {
        //$user = Auth::user();
        $publicars = Publicar::with([
            'producto:id,nombre_producto,precio_compra,stock',
            'user:id,name'
        ])->orderBy('id', 'desc')
            ->paginate(8);

        return Inertia::render('Publicar/Listado', ['publicars' => $publicars]);
    }

    public function create()
    {

        // Aquí puedes obtener cualquier información adicional que necesites para la vista de creación
        $user = Auth::user()->only(['id', 'name']);

        $productos = Producto::select('id', 'nombre_producto')
            ->get();

        return Inertia::render('Publicar/FormNuevo', [
            'user' => $user,
            'productos' => $productos,

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'precio_venta' => 'required|numeric|min:0',
            'detalle' => 'required|string|max:255',
            'estado' => 'required|boolean',
            'imagen_url' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'producto_id' => 'required|exists:productos,id|unique:publicars,producto_id',
            'user' => 'required',
        ]);

        $userId = $request->user['id'];

        // $user = Auth::user();

        // Manejar la carga de la imagen
        if ($request->hasFile('imagen_url')) {
            $image = $request->file('imagen_url');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        Publicar::create([
            'precio_venta' => $request->input('precio_venta'),
            'detalle' => $request->input('detalle'),
            'estado' => $request->input('estado'),
            'imagen_url' => $imageName,
            'producto_id' => $request->input('producto_id'),
            'user_id' => $userId,
        ]);

        return redirect()->route('publicar.index')->with('success', 'Producto publicado con éxito.');
    }

    public function show($id)
    {
        $publicar = Publicar::where('id', $id)
            ->with([
                'producto:id,nombre_producto,precio_compra,descripcion,stock,categoria_id',
                'producto.categoria:id,nombre_categoria'
            ])
            ->first();

        return Inertia::render(
            'Publicar/Mostrar',
            [
                'publicar' => $publicar,
            ]
        );
    }


    public function edit($id)
    {
        $productos = Producto::select('id', 'nombre_producto')
            ->get();

        $publicar = Publicar::where('id', $id)->first();

        return Inertia::render(
            'Publicar/FormEditar',
            [
                'publicars' => $publicar->only('id', 'producto_id', 'precio_venta', 'estado', 'detalle'),
                'productos' => $productos,
            ]
        );
    }


    public function update(Request $request, $id)
    {
        $publicar = Publicar::findOrFail($id);

        // Validación dinámica para la imagen
        $request->validate([
            'precio_venta' => 'required|numeric|min:0',
            'detalle' => 'required|string|max:255',
            'estado' => 'required|boolean',
            'imagen_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Hacer que sea opcional
            'producto_id' => 'required|exists:productos,id',
        ]);

        // Manejo de la imagen
        if ($request->hasFile('imagen_url')) {
            // Eliminar la imagen existente si es necesario
            if ($publicar->imagen_url && file_exists(public_path('images/' . $publicar->imagen_url))) {
                unlink(public_path('images/' . $publicar->imagen_url));
            }

            $image = $request->file('imagen_url');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $publicar->imagen_url = $imageName;
        }

        // Actualizar el resto de los campos
        $publicar->update([
            'precio_venta' => $request->input('precio_venta'),
            'detalle' => $request->input('detalle'),
            'estado' => $request->input('estado'),
            'producto_id' => $request->input('producto_id'),
        ]);

        return redirect()->route('publicar.index')->with('success', 'Publicación actualizada con éxito.');
    }


    public function destroy($id)
    {
        $publicar = Publicar::findOrFail($id);

        if ($publicar->imagen_url && file_exists(public_path('images/' . $publicar->imagen_url))) {
            unlink(public_path('images/' . $publicar->imagen_url));
        }
        $publicar->delete();

        return redirect()->route('publicar.index')->with('success', 'Publicación eliminada con éxito.');
    }
}
