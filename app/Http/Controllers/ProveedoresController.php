<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class ProveedoresController extends Controller
{

    public function index()
    {
        $proveedores = Proveedore::orderBy('created_at', 'desc')
            ->paginate(6);

        return Inertia::render('Proveedores/Listado', ['proveedores' => $proveedores]);
    }


    public function create()
    {
        return Inertia::render('Proveedores/FormNuevo');
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre_proveedor' => 'required|max:100|string',
                'informacion_contacto' => 'required|max:255|string',
            ]
        );
        Proveedore::create($request->all());

        return Redirect::route('proveedores.index')->with('success', 'Proveedor registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedore $proveedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedores = Proveedore::where('id', $id)
            ->first();


        return Inertia::render(
            'Proveedores/FormEditar',
            ['proveedores' => $proveedores->only('id', 'nombre_proveedor', 'informacion_contacto')]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedore $proveedores)
    {
        $request->validate(
            [
                'nombre_proveedor' => 'required|max:100|string',
                'informacion_contacto' => 'required|max:255|string',
            ]
        );

        $proveedores->where('id', $request->id)
            ->update($request->only('nombre_proveedor', 'informacion_contacto'));

        return Redirect::route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Proveedore $proveedores)
    {
        $proveedores->where('id', $request->id)->delete();
        return Redirect::route('proveedores.index');
    }
}
