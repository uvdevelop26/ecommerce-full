<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clientes;
use App\Models\Productos;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'estado',
        'tipo_entrega',
        'metodo_pago_id',
        'user_id',

    ];

    public function metodo_pago()
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalle_ventas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function tarjeta_datos()
    {
        return $this->hasMany(TarjetaDato::class);
    }

    public function envios()
    {
        return $this->hasMany(Envio::class);
    }
}
