<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->increments('programa_id');
            $table->string('programa_nombre');
            $table->string('programa_descripcion');
            $table->integer('programa_presupuesto');
            $table->integer('programa_poblacion_objetivo');
            $table->integer('programa_responsable');
            $table->timestamps();

            // $table->foreign('user_id')
            //         ->references('id')
            //         ->on('users')
            //         ->onDelete('cascade');
        });
        Schema::create('ofertas', function (Blueprint $table) {
            $table->increments('oferta_id');
            $table->integer('programa_id');
            $table->integer('oferta_anio');
            $table->integer('oferta_monto');
            $table->integer('oferta_cupos');
            $table->integer('oferta_sector');
            $table->date('oferta_periodo_inicio');
            $table->date('oferta_periodo_fin');
            $table->timestamps();

            
        });
        Schema::create('ofertas_dpa', function (Blueprint $table) {
            $table->increments('oferta_dpa_id');
            $table->integer('oferta_id');
            $table->integer('dpa_id');
            $table->integer('oferta_dpa_responsable_comuna');
            $table->integer('oferta_dpa_cupos');
            $table->integer('oferta_dpa_monto');
            $table->timestamps();

           
        });
        Schema::create('dpa', function (Blueprint $table) {
            $table->increments('dpa_id');
            $table->string('dpa_region_nombre');
            $table->string('dpa_region_codigo');
            $table->string('dpa_provincia_nombre');
            $table->string('dpa_provincia_codigo');
            $table->string('dpa_comuna_nombre');
            $table->string('dpa_comuna_codigo');
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
        Schema::dropIfExists('programas');
        Schema::dropIfExists('ofertas');
        Schema::dropIfExists('ofertas_dpa');
        Schema::dropIfExists('dpa');
    }
}
