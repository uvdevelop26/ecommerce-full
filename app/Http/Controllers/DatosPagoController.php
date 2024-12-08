<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DatosPago;
use App\Models\Ciudad;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;




class DatosPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $datospago = DatosPago::all();

        // Utiliza el método inertia() para renderizar una vista Inertia
        return inertia('/Index', ['datos_pago' => $datospago]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'numero_tarjeta' => 'required',
            'fecha_expiracion' => 'required',
            'nombre_tarjeta' => 'required',
            'cvv' => 'required',
            'user_id' => 'required',
            // Agrega otras reglas de validación según tus necesidades
        ]);
        $user = Auth::user();
        // Crea una nueva instancia del modelo ItemCarrito con los datos del formulario
        $datospago = new DatosPago([
            'numero_tarjeta' => $request->input('numero_tarjeta'),
            'fecha_expiracion' => $request->input('fecha_expiracion'),
            'nombre_tarjeta' => $request->input('nombre_tarjeta'),
            'cvv' => $request->input('cvv'),
            'user_id' => $user->id, 
            // Agrega otros campos según tus necesidades
        ]);

        // Guarda el nuevo registro en la base de datos
        $datospago->save();

        // Puedes devolver una respuesta de éxito, redirigir a otra página, etc.
        return response()->json(['datos_pago' => 'Pagado con exito']);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validaciones (puedes ajustar según tus necesidades)
        $request->validate([
            'numero_tarjeta' => 'required|string',
            'fecha_expiracion' => 'required|date',
            'nombre_tarjeta' => 'required|string',
            'cvv' => 'required|numeric',
            'user_id' => 'required',
           
            // Otros campos y reglas de validación
        ]);
        $user = Auth::user();
        
    
        // Guardar los datos en la base de datos
        $datospago = new DatosPago([
            'numero_tarjeta' => $request->input('numero_tarjeta'),
            'fecha_expiracion' => $request->input('fecha_expiracion'),
            'nombre_tarjeta' => $request->input('nombre_tarjeta'),
            'cvv' => $request->input('cvv'),
            'user_id' => $user->id,
        ]);
        $datospago->save();
    
        return redirect()->route('inicio.index')->with('success', 'pay con éxito.');
        // Puedes hacer algo más después de guardar, como redirigir o devolver una respuesta
     }



    // ... Puedes continuar implementando las acciones update, edit, y destroy según tus necesidades ...

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
