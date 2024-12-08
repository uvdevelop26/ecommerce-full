<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosPago extends Model
{
    use HasFactory;

    protected $table = 'datos_pago'; // Especifica el nombre de la tabla

    protected $fillable = [
        'numero_tarjeta',
        'fecha_expiracion',
        'nombre_tarjeta',
        'cvv',
        'user_id',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    // Otros métodos, relaciones, etc.
}
