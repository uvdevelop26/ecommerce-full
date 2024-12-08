<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosPagoTable extends Migration
{
    public function up()
    {
        Schema::create('datos_pago', function (Blueprint $table) {
            $table->id();
            $table->string('numero_tarjeta', 16);
            $table->date('fecha_expiracion');
            $table->string('nombre_tarjeta');
            $table->string('cvv');
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('datos_pago');
    }
}
