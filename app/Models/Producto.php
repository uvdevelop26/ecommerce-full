<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Proveedore;
use App\Models\User;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_producto',
        'descripcion',
        'precio_compra',
        'stock',
        'proveedore_id',
        'categoria_id',
        'user_id',
    ];

    /* relación de uno a muchos */
    public function proveedore()
    {
        return $this->belongsTo(Proveedore::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publicars()
    {
        return $this->hasMany(Publicar::class);
    }

    public function detalle_venta()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
