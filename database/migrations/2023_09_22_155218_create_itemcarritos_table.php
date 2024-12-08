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
        Schema::create('itemcarritos', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->integer('subtotal');
            $table->unsignedBigInteger('carrito_id');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('carrito_id')
                ->references('id')
                ->on('carritos')
                ->onDelete('cascade');
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itemcarritos');
    }
};
