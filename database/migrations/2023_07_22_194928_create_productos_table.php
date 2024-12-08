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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_producto', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_compra', 10, 2);
            $table->integer('stock');
            $table->unsignedBigInteger('proveedore_id')->nullable();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->foreign('proveedore_id')
                ->references('id')
                ->on('proveedores')
                ->onDelete('set null');
            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('set null');
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
        Schema::dropIfExists('productos');
    }
};
