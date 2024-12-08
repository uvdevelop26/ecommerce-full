<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjeta_datos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tarjeta', 100);
            $table->string('numero_tarjeta', 100);
            $table->date('fecha_expiracion');
            $table->string('cvv', 100);
            $table->unsignedBigInteger('venta_id');

            $table->foreign('venta_id')
                ->references('id')
                ->on('ventas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarjeta_datos');
    }
};
