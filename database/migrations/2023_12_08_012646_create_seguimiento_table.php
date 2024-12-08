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
        Schema::create('seguimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('datosenvio_id');
            $table->enum('estado', ['en espera', 'completado'])->default('en espera');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Clave foránea que referencia al ID de datosenvio en la tabla "datosenvio"
            $table->foreign('datosenvio_id')->references('id')->on('datosenvio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seguimiento');
    }
};
