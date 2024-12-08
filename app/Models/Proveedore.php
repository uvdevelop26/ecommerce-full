<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_proveedor',
        'informacion_contacto',
    ];

    /* relacion uno a muchos */

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
