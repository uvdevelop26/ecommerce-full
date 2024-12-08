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
        Schema::create('publicars', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio_venta', 10, 2);
            $table->string('detalle');
            $table->tinyInteger('estado');
            $table->text('imagen_url');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
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
        Schema::dropIfExists('prublicars');
    }
};
