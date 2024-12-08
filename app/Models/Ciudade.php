<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departamento;


class Ciudade extends Model
{
    use HasFactory;

    protected $table = 'ciudades';

    public $timestamps = false;

    protected $fillable = [
        'nombre_ciudad',
        'departamento_id',
    ];

    // Deshabilitar el registro automático de timestamps
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function envios()
    {
        return $this->hasMany(Envio::class);
    }
}
