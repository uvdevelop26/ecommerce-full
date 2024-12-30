<?php

namespace App\Http\Controllers;

use App\Models\Publicar;
use App\Models\User;
use App\Models\Carrito;
use App\Models\Categoria;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class InicioController extends Controller
{
    public function index(Request $request)
    {

        $queries = ['search'];

        $publicars = Publicar::with('producto.categoria', 'user')
            ->where('estado', 1)
            ->inRandomOrder()
            ->filter($request->only($queries))
            ->get();

        $banner = Publicar::with('producto.categoria')->inRandomOrder()->first();

        $categorias = Categoria::select('id', 'nombre_categoria')->get();

        return Inertia::render('Inicio/Listado', [
            'publicars' => $publicars,
            'banner' => $banner,
            'categorias' => $categorias,
            'filters' => $request->all($queries)
        ]);
    }
}
