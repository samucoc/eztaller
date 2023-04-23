<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hab_provinces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('province_name');
            $table->unsignedBigInteger('region_id');

            $table->foreign('region_id')->references('id')->on('hab_regions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hab_provinces');
    }
}
