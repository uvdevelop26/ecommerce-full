<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiudadesTable extends Migration
{
    public function up()
    {
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_ciudad', 100);
            $table->unsignedBigInteger('departamento_id');
            $table->timestamps();

            // Clave foránea que referencia al ID del proveedor en la tabla "proveedores"
            $table->foreign('departamento_id')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');
        });
    }
}
