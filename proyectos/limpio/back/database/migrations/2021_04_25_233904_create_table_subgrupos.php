<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubgrupos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ez_subgrupos_portafolios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('ez_grupos_portafolios');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
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
        //
        Schema::dropIfExists('ez_subgrupos_portafolios');
    }
}
