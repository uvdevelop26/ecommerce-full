<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->text('content');
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
