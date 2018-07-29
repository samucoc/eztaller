<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'categorias';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [];

    public function tipoproductos(){
    	return $this->hasMany('App\TipoProductos','categoria_id','categoria_id');
    }
}
