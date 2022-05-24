<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('usertype')->default(1)->comment('1 = Sinti, 2 = Roma, 3 = Travellers');
            $table->string('phone', 33)->nullable();
            $table->string('gender', 15)->nullable();
            $table->date('dob');
            $table->integer('country_id');
            $table->integer('division_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('input_date');
            $table->string('photo')->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
