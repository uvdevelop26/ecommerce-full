<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{

    public function index()
    {
        $categoria = Categoria::orderBy('id', 'desc')
            ->paginate(6);
        return Inertia::render('Categorias/Listado', ['categorias' => $categoria]);
    }


    public function create()
    {
        return Inertia::render('Categorias/FormNuevo');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre_categoria' => 'required|max:100',

            ]
        );

        Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría registrada exitosamente.');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $categoria = Categoria::where('id', $id)->first();

        return Inertia::render(
            'Categorias/FormEditar',
            ['categoria' => $categoria->only('id', 'nombre_categoria')]
        );
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate(
            [
                'nombre_categoria' => 'required|max:100',
            ]
        );
        $categoria->where('id', $request->id)->update($request->only('nombre_categoria'));

        return Redirect::route('categorias.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Request $request, Categoria $categoria)
    {
        $categoria->where('id', $request->id)->delete();
        return Redirect::route('categorias.index');
    }
}
