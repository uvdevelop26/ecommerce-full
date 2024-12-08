<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;

class Publicar extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio_venta',
        'detalle',
        'estado',
        'imagen_url',
        'producto_id',
        'user_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
