<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('title')->nullable();
            $table->string('picture')->nullable();
            $table->string('seat_type', 33);
            $table->bigInteger('viewcounts')->default(0);
            $table->text('taxvalues')->nullable();
            $table->ipAddress('visitor');
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
        Schema::dropIfExists('live_rooms');
    }
}
