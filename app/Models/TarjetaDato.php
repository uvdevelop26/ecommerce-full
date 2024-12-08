<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarjetaDato extends Model
{
    use HasFactory;

    protected $table = 'tarjeta_datos';

    protected $fillable = [
        'nombre_tarjeta',
        'numero_tarjeta',
        'fecha_expiracion',
        'cvv',
        'venta_id'
    ];


    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
