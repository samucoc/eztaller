<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marcas_categorias extends Model
{
    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'marcas_has_categorias';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [];
}
