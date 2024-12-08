<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use App\Models\Itemcarrito;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class ItemcarritoController extends Controller
{

    public function index()
    {
        /*   $users = Auth::user();

        $itemcarrito = Itemcarrito::join('productos', 'itemcarritos.producto_id', '=', 'productos.id')
            ->select('itemcarritos.*', 'productos.nombre_producto')
            ->where('itemcarritos.carrito_id', $users->id)
            ->get();

        return Inertia::render('Carrito/Index', ['itemcarritos' => $itemcarrito, 'users' => $users]); */
    }


    public function create(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'carrito_id' => 'required',
            'product_id' => 'required',
            'cantidad' => 'required',
            'subtotal' => 'required',
            // Agrega otras reglas de validación según tus necesidades
        ]);

        // Crea una nueva instancia del modelo ItemCarrito con los datos del formulario
        $itemcarrito = new Itemcarrito([
            'carrito_id' => $request->input('carrito_id'),
            'product_id' => $request->input('product_id'),
            'cantidad' => $request->input('cantidad'),
            'subtotal' => $request->input('subtotal'),
            // Agrega otros campos según tus necesidades
        ]);

        // Guarda el nuevo registro en la base de datos
        $itemcarrito->save();

        // Puedes devolver una respuesta de éxito, redirigir a otra página, etc.
        return response()->json(['message' => 'Producto agregado al carrito con éxito']);
    }

    public function store(Request $request)
    {

        // Validar los datos del formulario
        $request->validate([
            'cantidad' => 'required|integer',
            'subtotal' => 'required|numeric',
            'producto_id' => 'required|integer',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Buscar o crear el carrito automáticamente
        $carrito = Carrito::firstOrCreate([
            'user_id' => $user->id,
        ]);

        // Crear un nuevo ítem en el carrito
        $itemcarrito = Itemcarrito::create([
            'cantidad' => $request->input('cantidad'),
            'subtotal' => $request->input('subtotal'),
            'carrito_id' => $carrito->id, // Asocia el ítem al carrito encontrado o creado
            'producto_id' => $request->input('producto_id'), // Asegúrate del nombre correcto del campo en el formulario
        ]);

        // return Inertia::render('Carrito/Index', ['carritos' => $carrito]);
    }


    public function edit($id) {}

    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'subtotal' => 'required|numeric',
            'carrito_id' => 'required|integer',
            'producto_id' => 'required|array', // Asegura que es un array
            'producto_id.id' => 'required|integer', // Valida que tenga un índice id numérico
        ]);

        $itemCarrito = Itemcarrito::findOrFail($id);

        $productoId = $request->producto_id['id'];

        $itemCarrito->update([
            'cantidad' => $request->input('cantidad'),
            'subtotal' => $request->input('subtotal'),
            'carrito_id' => $request->input('carrito_id'),
            'producto_id' => $productoId,
        ]);
    }

    public function destroy($id)
    {
        $itemcarritos = Itemcarrito::findOrFail($id);

        $itemcarritos->delete();

        return Redirect::route('carritos.index');
    }
}
