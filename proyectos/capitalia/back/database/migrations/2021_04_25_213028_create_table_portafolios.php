<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortafolios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ez_portafolios', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nombre_portafolio')->nullable();
            $table->string('descripcion')->nullable();

            $table->unsignedInteger('grupo_id');
            $table->foreign('grupo_id')->references('id')->on('ez_grupos_portafolios');

            $table->unsignedInteger('subgrupo_id');
            $table->foreign('subgrupo_id')->references('id')->on('ez_subgrupos_portafolios');

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
        Schema::dropIfExists('ez_portafolios');
    }

}
