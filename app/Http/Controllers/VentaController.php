<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Ciudade;
use App\Models\Clientes;
use App\Models\Departamento;
use App\Models\DetalleVenta;
use App\Models\Envio;
use App\Models\MetodoPago;
use App\Models\Productos;
use App\Models\TarjetaDato;
use App\Models\Venta;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        /* $ventas = Ventas::join('productos', 'ventas.id_producto', '=', 'productos.id')
            ->join('clientes', 'ventas.id_cliente', '=', 'clientes.id')
            ->select('ventas.*', 'productos.nombre_producto', 'clientes.nombre')
            ->get();
        return Inertia::render('Ventas/Listado', ['ventas' => $ventas]); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $userId = Auth::user()->id;

        $carrito = Carrito::where('user_id', $userId)
            ->with('items.producto.publicars')
            ->first();

        $metodosPago = MetodoPago::select('id', 'metodo')
            ->get();
        $departamentos = Departamento::select('id', 'nombre')
            ->get();
        $ciudades = Ciudade::select('id', 'nombre_ciudad')
            ->get();

        return Inertia::render('Ventas/FormNuevo', [
            'carrito' => $carrito,
            'metodosPago' => $metodosPago,
            'departamentos' => $departamentos,
            'ciudades' => $ciudades
        ]);


        /*   $ventas = Ventas::all();
        $clientes = Clientes::all();
        $productos = Productos::all();


        return Inertia::render('Ventas/FormNuevo', [
           'ventas' => $ventas,
            'clientes' => $clientes,
            'productos' => $productos,
            

        ]); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        //   $metodoPagoTarjetaId = MetodoPago::where('metodo', 'tarjeta')->value('id');

        // Validar campos comunes
        $request->validate([
            'total' => 'required|numeric',
            'estado' => 'required|boolean',
            'tipo_entrega' => 'required|in:envio,tienda', // Validar que solo sea "envio" o "tienda"
            'metodo_pago_id' => 'required|integer',
            //'user_id' => 'required|integer',
            'detalle_venta' => 'required|array',
        ]);

        // Validar campos relacionados con "envío" si `tipo_entrega` es "envio"
        if ($request->input('tipo_entrega') === 'envio') {
            $request->validate([
                'telefono' => 'required|string',
                'direccion' => 'required|string',
                'costo_envio' => 'required|numeric',
                'fecha_envio' => 'required|date',
                'estado_envio' => 'required|string',
                'ciudade_id' => 'required|integer',
            ]);
        }

        // Validar campos relacionados con "tarjeta" si el método de pago es "tarjeta"
        $metodoPagoTarjetaId = MetodoPago::where('metodo', 'tarjeta')->value('id');
        if ($request->input('metodo_pago_id') == $metodoPagoTarjetaId) {
            $request->validate([
                'numero_tarjeta' => 'required|string|max:16',
                'fecha_expiracion' => 'required|date',
                'nombre_tarjeta' => 'required|string|max:255',
                'cvv' => 'required|string|max:4',
            ]);
        }

        DB::beginTransaction();
        try {
            // Crear la venta
            $venta = Venta::create([
                'total' => $request->input('total'),
                'estado' => $request->input('estado'),
                'tipo_entrega' => $request->input('tipo_entrega'),
                'metodo_pago_id' => $request->input('metodo_pago_id'),
                'user_id' => $userId,
            ]);

            // Crear los detalles de la venta
            foreach ($request->input('detalle_venta') as $detalleVenta) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalleVenta['producto_id'],
                    'cantidad_comprada' => $detalleVenta['cantidad'],
                    'subtotal' => $detalleVenta['subtotal'],
                ]);
            }

            // Crear el envío (si aplica)
            if ($request->input('tipo_entrega') === 'envio') {
                Envio::create([
                    'telefono' => $request->input('telefono'),
                    'direccion' => $request->input('direccion'),
                    'costo_envio' => $request->input('costo_envio'),
                    'fecha_envio' => $request->input('fecha_envio'),
                    'estado_envio' => $request->input('estado_envio'),
                    'ciudade_id' => $request->input('ciudade_id'),
                    'venta_id' => $venta->id,
                ]);
            }

            // Crear los datos de la tarjeta (si aplica)
            if ($request->input('metodo_pago_id') == $metodoPagoTarjetaId) {
                TarjetaDato::create([
                    'numero_tarjeta' => $request->input('numero_tarjeta'),
                    'fecha_expiracion' => $request->input('fecha_expiracion'),
                    'nombre_tarjeta' => $request->input('nombre_tarjeta'),
                    'cvv' => $request->input('cvv'),
                    'venta_id' => $venta->id,
                ]);
            }

            DB::commit();

            return Redirect::route('inicio.index');

            // return response()->json(['message' => 'Venta creada exitosamente'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al procesar la venta', 'details' => $e->getMessage()], 500);
        }
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
        /*  $producto = Productos::all();
        $cliente = Clientes::all();
        $ventas = Ventas::where('id', $id)->first();
        return Inertia::render(
            'Ventas/FormEditar',
            [
                'ventas' => $ventas->only('id', 'id_producto', 'id_cliente', 'cantidad', 'subtotal'),
                'productos' => $producto,
                'clientes' => $cliente,
            ]
        ); */
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
        /* $request->validate([

            'id_producto' => 'required',
            'id_cliente' => 'required',
            'cantidad' => 'required',
            'subtotal' => 'required',
            // Agrega aquí las reglas de validación para los campos del formulario de edición de productos
        ]);

        $ventas = Ventas::findOrFail($id);
        $ventas->update($request->all());

        return Redirect::route('ventas.index'); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*  $ventas = Ventas::findOrFail($id);
        $ventas->delete();

        return Redirect::route('ventas.index'); */
    }
}