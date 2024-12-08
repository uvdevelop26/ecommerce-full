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
    Schema::create('datosenvio', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('ciudad_id')->nullable(); // Cambié el nombre de la columna a 'ciudad_id'
        $table->unsignedBigInteger('departamento_id')->nullable();
        $table->string('telefono', 20);
        $table->unsignedBigInteger('carrito_id');
        $table->timestamps();

        // Claves foráneas que referencia al ID de ciudad y departamento en sus respectivas tablas
        $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('set null');
        $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('set null');
       
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datosenvio');
    }
};
