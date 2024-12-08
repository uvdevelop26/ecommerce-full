<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrito;
use App\Models\Productos;

class Itemcarrito extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad',
        'subtotal',
        'carrito_id',
        'producto_id',

    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }
}
