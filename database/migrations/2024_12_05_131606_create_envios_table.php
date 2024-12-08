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
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->string('telefono', 100);
            $table->string('direccion');
            $table->decimal('costo_envio', 10, 2);
            $table->date('fecha_envio');
            $table->string('estado_envio', 200);
            $table->unsignedBigInteger('ciudade_id');
            $table->unsignedBigInteger('venta_id');

            $table->foreign('ciudade_id')
                ->references('id')
                ->on('ciudades')
                ->onDelete('cascade');
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
        Schema::dropIfExists('envios');
    }
};
