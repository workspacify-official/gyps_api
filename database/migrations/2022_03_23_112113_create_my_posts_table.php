<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyPostsTable extends Migration
{
    
    public function up()
    {
        Schema::create('my_posts', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->text('tag_freinds')->nullable();
            $table->bigInteger('views')->nullable();
            $table->bigInteger('share')->nullable();
            $table->bigInteger('heart')->nullable();
            $table->bigInteger('diamond')->nullable();
            $table->string('audio', 222)->nullable();
            $table->string('video', 222)->nullable();
            $table->enum('post_status', ['1', '0'])->default('1');
            $table->ipAddress('post_ip');
            $table->date('input_date');
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
        Schema::dropIfExists('my_posts');
    }
}
