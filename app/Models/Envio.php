<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $table = 'envios'; // Especifica el nombre de la tabla

    protected $fillable = [
        'telefono',
        'direccion',
        'costo_envio',
        'fecha_envio',
        'estado_envio',
        'ciudade_id',
        'venta_id',

    ];

    public function ciudade()
    {
        return $this->belongsTo(Ciudade::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
