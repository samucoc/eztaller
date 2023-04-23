<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hab_communes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('commune_name');
            $table->unsignedBigInteger('province_id');

            $table->foreign('province_id')->references('id')->on('hab_provinces')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hab_communes');
    }
}
