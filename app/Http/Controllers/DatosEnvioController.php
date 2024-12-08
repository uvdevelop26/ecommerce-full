<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DatosEnvio;
use App\Models\Ciudad;
use App\Models\DatosPago;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;




class DatosEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*         $datosenvio = DatosEnvio::all();
        return Inertia::render('DatosEnvio/Listado', ['datosenvio' => $datosenvio]); */

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      /*   // Validación de los datos del formulario
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
        $DatosEnvio
     = new DatosEnvio
    ([
            'numero_tarjeta' => $request->input('numero_tarjeta'),
            'fecha_expiracion' => $request->input('fecha_expiracion'),
            'nombre_tarjeta' => $request->input('nombre_tarjeta'),
            'cvv' => $request->input('cvv'),
            'user_id' => $user->id, 
            // Agrega otros campos según tus necesidades
        ]);

        // Guarda el nuevo registro en la base de datos
        $DatosEnvio
    ->save();

        // Puedes devolver una respuesta de éxito, redirigir a otra página, etc.
        return response()->json(['datos_pago' => 'Pagado con exito']); */
        
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
