<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\ItemCarrito;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $carrito = Carrito::where('user_id', $user->id)
            ->with('items.producto.publicars', 'user')
            ->first();

        if (!$carrito) {
            // Si no se encontró un carrito, crea uno nuevo
            $carrito = Carrito::create(['user_id' => $user->id]);
        }

        // Devolver el carrito al componente Vue
        return Inertia::render('Carrito/Index', ['carrito' => $carrito]);
    }


    public function show($carritoId) {}

    public function create(Request $request) {}

    public function store(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();
        $carrito = Carrito::all();
        // Verificar si el usuario tiene un carrito asociado
        $carritoExistente = Carrito::where('user_id', $user->id)->first();

        // Si no tiene un carrito, crear uno
        if (!$carritoExistente) {
            Carrito::create([
                'user_id' => $user->id,
                // Otros campos del carrito desde el formulario o valores predeterminados
            ]);
        }

        return Inertia::render('Carrito/Index', ['carritos' => $carrito]);

        // Redirigir a Carrito/Index después de la creación
    }



    public function edit($carritoId) {}

    public function update(Request $request, $carritoId) {}

    public function destroy($carritoId) {}

    // Métodos para gestionar ítems en el carrito


}
