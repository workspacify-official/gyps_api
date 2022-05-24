<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
   
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id('country_id');
            $table->string('country_name', 99);
            $table->string('iso_name', 10);
            $table->string('country_code', 10)->nullable();
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
        Schema::dropIfExists('countries');
    }
}
