<?php

namespace App\Http\Controllers;

use App\Models\Publicar;
use App\Models\User;
use App\Models\Carrito;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    public function index()
    {

        $publicars = Publicar::with('producto', 'user')
            ->where('estado', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        $banner = Publicar::with('producto')->inRandomOrder()->first();

        return Inertia::render('Inicio/Listado', [
            'publicars' => $publicars,
            'banner' => $banner
        ]);

        /*  $ciudades = Ciudad::all();
        $departamento = Departamento::all();
        $publicar = Publicar::join('productos', 'publicars.producto_id', '=', 'productos.id')
            ->join('users', 'publicars.user_id', '=', 'users.id')
            
            ->select('publicars.*', 'productos.nombre_producto', 'users.name')
            ->get();

        // Verificar si el usuario está autenticado antes de acceder a sus propiedades
        $users = Auth::check() ? Auth::user() : null;

        return Inertia::render('Inicio/Listado', [
            'publicars' => $publicar,
            'users' => $users,
            'ciudades' => $ciudades,
            'departamentos' => $departamento,

        ]); */
    }

    // Otras funciones relacionadas con la gestión de publicaciones
}
