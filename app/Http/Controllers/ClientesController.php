<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Clientes::all();
        return Inertia::render('Clientes/Listado', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Clientes::all();
        return Inertia::render('Clientes/FormNuevo', ['clientes' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required',
                'direccion' => 'required',
                'telefono' => 'required',
                'email' => 'required',
            ]
        );
        Clientes::create($request->all());
        return Redirect::route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clientes $Clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $clientes = Clientes::where('id', $id)->first();
        return Inertia::render(
            'Clientes/FormEditar',
            ['clientes' => $clientes->only('id', 'nombre', 'direccion','telefono','email')]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Clientes $clientes)
    {
        $request->validate([
            'nombre' => 'required',
                
                'direccion' => 'required',
                'telefono' => 'required',
                'email' => 'required',
            
        ]);
        $clientes->where('id', $request->id)->update($request->only('nombre', 'direccion','telefono','email'));
        return Redirect::route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Clientes $clientes)
    {
        $clientes->where('id', $request->id)->delete();
        return Redirect::route('clientes.index');
    }
}
