<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInversionistasHasInversiones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ez_inversionistas_has_inversiones', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('inver_id');
            $table->foreign('inver_id')->references('id')->on('ez_inversionistas');

            $table->integer('inversion_clp');
            $table->integer('inversion_us');
            $table->datetime('fecha_hora_inv');

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
        Schema::dropIfExists('ez_inversionistas_has_inversiones');
    }
}
