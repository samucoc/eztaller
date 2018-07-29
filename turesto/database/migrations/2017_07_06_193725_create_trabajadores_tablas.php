<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajadoresTablas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
                   schema::create('parentesco', function(blueprint $table){
            $table->increments('p_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });


                         schema::create('estado', function(blueprint $table){
            $table->increments('e_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });


          
        schema::create('trabajadores_tienen_cargas', function(blueprint $table){
            $table->increments('tc_ncorr');
            $table->integer('rut_papa');
            $table->integer('rut_carga')->unsigned();
            $table->string('nombres');
            $table->string('ape_pat');
            $table->string('ape_mat');
            $table->date('fecha_nac');
            $table->integer('parentesco')->unsigned();
            $table->integer('estado_carga')->unsigned();
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('rut_carga')->references('trabajador_id')->on('trabajadores');
            $table->foreign('parentesco')->references('p_ncorr')->on('parentesco');
            $table->foreign('estado_carga')->references('e_ncorr')->on('estado');

        });

           schema::create('areas', function(blueprint $table){
            $table->increments('area_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

        schema::create('empresas', function(blueprint $table){
            $table->increments('empresa_id');
            $table->string('empresa_rut',11);
            $table->text('empresa_nombre');
            $table->text('empresa_direccion');
            $table->text('empresa_giro');
            $table->text('empresa_mail');
            $table->integer('empresa_aparece_menu');
            $table->integer('empresa_aparece_otro');
            $table->double('empresa_mutual');
            $table->boolean('empresa_estado');
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

        schema::create('bancos', function(blueprint $table){
            $table->increments('banco_id');
            $table->text('banco_descripcion');
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

                 schema::create('estado_empleado', function(blueprint $table){
            $table->increments('ee_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

         schema::create('tipos_cuentas', function(blueprint $table){
            $table->increments('tc_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });



        schema::create('trabajadores_tiene_laboral', function(blueprint $table){
            $table->increments('tl_ncorr');
            $table->integer('rut_trab')->unsigned();
            $table->text('cargo');
            $table->integer('area')->unsigned();
            $table->integer('empresa')->unsigned();
            $table->date('fecha_ingreso');
            $table->date('fecha_contrato');
            $table->integer('cant_vacaciones_prog');
            $table->boolean('trabajador_sexo');
            $table->text('causa_finiquito');
            $table->integer('estado_empleado')->unsigned();
            $table->date('fecha_calculo_vacaciones');
            $table->integer('asignacion_materiales');
            $table->integer('tipo_pago_remuneraciones');
            $table->integer('nro_cuenta');
            $table->integer('tipo_cuenta')->unsigned();
            $table->integer('banco')->unsigned();
            $table->string('celular');
            $table->string('auto');
            $table->string('moto');
            $table->string('asig_caja');
            $table->integer('monto_asig_caja');
            $table->integer('monto_asig_locomocion');
            $table->integer('monto_asig_fxr');
            $table->integer('anticipo');
            $table->integer('gratificacion');
            $table->integer('indefinido');
            $table->integer('mayor_once');
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('rut_trab')->references('trabajador_id')->on('trabajadores');
            $table->foreign('area')->references('area_ncorr')->on('areas');
            $table->foreign('empresa')->references('empresa_id')->on('empresas');
            $table->foreign('estado_empleado')->references('ee_ncorr')->on('estado_empleado');
            $table->foreign('tipo_cuenta')->references('tc_ncorr')->on('tipos_cuentas');
            $table->foreign('banco')->references('banco_id')->on('bancos');


        });

        schema::create('afp', function(blueprint $table){
            $table->increments('afp');
            $table->text('nombre');
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

                 schema::create('ips', function(blueprint $table){
            $table->increments('ips_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

         schema::create('salud', function(blueprint $table){
            $table->increments('salud_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });

        schema::create('institucion_apv', function(blueprint $table){
            $table->increments('inst_apv_ncorr');
            $table->text('nombre');
            
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
        });


        schema::create('trabajadores_tiene_prevision', function(blueprint $table){
            $table->increments('tp_ncorr');
            $table->integer('rut_trab')->unsigned();
            $table->integer('afp')->unsigned();
            $table->integer('ips')->unsigned();
            $table->string('porc_cotizacion');
            $table->string('porc_adicional');
            $table->string('porc_cotizacion_ips');
            $table->string('monto_cotizacion');
            $table->string('tipo_monto_cotizacion');
            $table->integer('salud')->unsigned();
            $table->integer('ahorro_vol');
            $table->integer('ints_ahorro_vol')->unsigned();
            $table->date('fecha_ahorro_vol');
            $table->integer('ahorro_full_caja');
            $table->string('plan_uf');
            $table->string('plan_pesos');
            $table->string('seguro_cesantia');
            $table->integer('sueldo_base');
            $table->integer('sueldo_base_1');
            $table->string('tramo');
            //toda tabla debera contener los siguientes campos
            $table->string('creado_por');
            $table->string('modificado_por');
            $table->timestamps();
            $table->foreign('rut_trab')->references('trabajador_id')->on('trabajadores');
            $table->foreign('afp')->references('afp')->on('afp');
            $table->foreign('salud')->references('salud_ncorr')->on('salud');
            $table->foreign('ips')->references('ips_ncorr')->on('ips');
            $table->foreign('ints_ahorro_vol')->references('inst_apv_ncorr')->on('institucion_apv');
            
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
    }
}
