<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
	//en el/los modelo/s solo indicaremos que tabla utilizaremos y que campos de esa tabla vamos a mostrar en nuestro sistema.


    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'perfiles';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [
    	'perf_desc'
    ];

}
