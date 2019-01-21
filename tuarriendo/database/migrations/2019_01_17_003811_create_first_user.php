<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'samu.silva@gmail.com',
            'documento' => '',
            'tipo_documento' => '',
            'telefono' => '',
            'direccion' => '',
            'estado' => '1',
            'password' => bcrypt('admin'),
        ]);
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
