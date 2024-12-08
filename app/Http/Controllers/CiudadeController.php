<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Ciudade;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class CiudadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*  $ciudad = Ciudad::all();

        // Utiliza el método inertia() para renderizar una vista Inertia
        return inertia('Index/Listado', ['ciudades' => $ciudad]); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*  $ciudades = Ciudad::all(); 
        return Inertia::render('Inicio/Listado', ['ciudades' => $ciudades]);    */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /*  $request->validate([
        'nombre_ciudad' => 'required',
        'id_departamento' => 'required',
        'user_id' => 'required',
    ]);

    $user = Auth::user();

    $ciudad = new Ciudad([
        'nombre_ciudad' => $request->input('nombre_ciudad'),
        'id_departamento' => $request->input('id_departamento'),
        'user_id' => $user->id,
    ]);

    $ciudad->save();

    return response()->json(['message' => 'Ciudad agregada con éxito', 'ciudad' => $ciudad]); */
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
    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ciudade $ciudad) {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ciudade $ciudad) {}
}
