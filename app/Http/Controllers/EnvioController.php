<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DatosEnvio;
use App\Models\Ciudad;
use App\Models\Ciudade;
use App\Models\DatosPago;
use App\Models\Departamento;
use App\Models\Envio;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;




class EnvioController extends Controller
{

    public function index()
    {
        $envios = Envio::with('ciudade.departamento', 'venta.user')->get();

        return Inertia::render('Envios/Listado', ['envios' => $envios]);
    }



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


    public function edit($id)
    {
        $envio = Envio::with('ciudade.departamento', 'venta.user')
            ->find($id);
        $departamentos = Departamento::select('id', 'nombre')
            ->get();
        $ciudades = Ciudade::select('id', 'nombre_ciudad')
            ->get();

        return Inertia::render('Envios/FormEditar', [
            'envio' => $envio,
            'departamentos' => $departamentos,
            'ciudades' => $ciudades
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'costo_envio' => 'required|numeric',
            'fecha_envio' => 'required|date',
            'estado_envio' => 'required|string',
            'ciudade_id' => 'required|integer',
        ]);

        $envio = Envio::findOrFail($id);

        $envio->update([
            'telefono' => $request->input('telefono'),
            'direccion' => $request->input('direccion'),
            'costo_envio' => $request->input('costo_envio'),
            'fecha_envio' => $request->input('fecha_envio'),
            'estado_envio' => $request->input('estado_envio'),
            'ciudade_id' => $request->input('ciudade_id')
        ]);

        return Redirect::route('envios.index')->with('success', 'Envío actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
}
