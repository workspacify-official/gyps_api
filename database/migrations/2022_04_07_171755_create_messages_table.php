<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id');
            $table->integer('room_id');
            $table->integer('sender_id');
            $table->text('mgs')->nullable();
            $table->text('file')->nullable();
            $table->integer('deleted_user_id')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
