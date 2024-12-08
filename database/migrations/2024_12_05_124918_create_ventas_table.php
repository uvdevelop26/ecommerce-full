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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 2);
            $table->tinyInteger('estado');
            $table->string('tipo_entrega', 200);
            $table->unsignedBigInteger('metodo_pago_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('metodo_pago_id')
                ->references('id')
                ->on('metodo_pagos')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('ventas');
    }
};
