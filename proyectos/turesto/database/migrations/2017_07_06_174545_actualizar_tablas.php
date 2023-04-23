<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActualizarTablas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //
        //
        /*
        Schema::table('afp', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('areas', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('anios', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('asignacion_familiar', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        
        Schema::table('bonos', function(Blueprint $table) {
            $table->integer('tipo_trabajador')->unsigned();
            $table->foreign('tipo_trabajador')->references('tt_ncorr')->on('tipo_trabajador');
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('caja_compensacion', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('colacion', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('datos_globales', function(Blueprint $table) {
            $table->integer('mes')->unsigned();
            $table->integer('anio')->unsigned();
            $table->foreign('mes')->references('mes_ncorr')->on('meses');
            $table->foreign('anio')->references('anio_ncorr')->on('anios');
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('estado', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('estado_empleado', function(Blueprint $table) {
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        Schema::table('feriados', function(Blueprint $table) {
            $table->integer('mes')->unsigned();
            $table->integer('anio')->unsigned();
            $table->foreign('tipo_feriado')->references('tf_ncorr')->on('tipo_feriados');
            $table->foreign('especifico')->references('te_ncorr')->on('tipo_especificos');
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });
        */
                       schema::create('tipo_perfiles', function(blueprint $table){
            $table->increments('tp_id');
            $table->text('tp_descripcion');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });


                schema::create('regiones', function(blueprint $table){
            $table->increments('region_id');
            $table->string('region_nombre',45);
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });   

                schema::create('provincias', function(blueprint $table){
            $table->increments('provincia_id');
            $table->text('provincia_nombre');
            $table->integer('region_id')->unsigned();
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('region_id')->references('region_id')->on('regiones');
        });

                schema::create('comunas', function(blueprint $table){
            $table->increments('comuna_id');
            $table->text('comuna_nombre');
            $table->integer('provincia_id')->unsigned();
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('provincia_id')->references('provincia_id')->on('provincias');
        });

        schema::create('trabajadores', function(blueprint $table){
            $table->increments('trabajador_id');
            $table->text('trabajador_nombres');
            $table->text('trabajador_ap');
            $table->text('trabajador_am');
            $table->string('trabajador_rut',11);
            $table->boolean('trabajador_sexo');
            $table->text('trabajador_direccion');
            $table->integer('trabajador_celular');
            $table->date('trabajador_fecha_nace');
            $table->boolean('trabajador_estado');
            $table->integer('comuna_id')->unsigned();
            $table->integer('tp_id')->unsigned();
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('tp_id')->references('tp_id')->on('tipo_perfiles');
            $table->foreign('comuna_id')->references('comuna_id')->on('comunas');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
