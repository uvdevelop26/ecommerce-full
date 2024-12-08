<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodo_pagos';

    protected $fillable = ['metodo'];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
