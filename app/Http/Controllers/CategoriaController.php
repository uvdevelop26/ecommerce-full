<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoria = Categoria::orderBy('id', 'desc')
            ->get();
        return Inertia::render('Categorias/Listado', ['categorias' => $categoria]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Categorias/FormNuevo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre_categoria' => 'required|max:100',

            ]
        );
        Categoria::create($request->all());
        return Redirect::route('categorias.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::where('id', $id)->first();

        return Inertia::render(
            'Categorias/FormEditar',
            ['categoria' => $categoria->only('id', 'nombre_categoria')]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate(
            [
                'nombre_categoria' => 'required|max:100',
            ]
        );
        $categoria->where('id', $request->id)->update($request->only('nombre_categoria'));
        return Redirect::route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Categoria $categoria)
    {
        $categoria->where('id', $request->id)->delete();
        return Redirect::route('categorias.index');
    }
}
