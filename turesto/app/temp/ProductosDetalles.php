<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosDetalles extends Model
{
    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'productos_detalles';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [];

    public function productos(){
    	return $this->belongsTo('App\Productos','producto_id','producto_id');
    }
}
