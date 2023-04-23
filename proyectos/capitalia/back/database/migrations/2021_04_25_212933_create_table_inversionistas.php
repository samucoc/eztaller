<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInversionistas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ez_inversionistas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('comuna_id');
            $table->foreign('comuna_id')->references('id')->on('communes');

            $table->string('nombres');
            $table->string('ape_pat');
            $table->string('ape_mat');
            $table->string('rut');
            $table->string('domicilio')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            
            $table->unsignedInteger('estado_civil');
            $table->foreign('estado_civil')->references('id')->on('hab_estados_civiles');
            
            $table->date('fecha_nac')->nullable();
            $table->string('contreseña')->nullable();

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
        Schema::dropIfExists('ez_inversionistas');
    }
}
