<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'productos';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [];

    public function tipoproductos(){
    	return $this->belongsTo('App\TipoProductos','tproducto_id','tproducto_id');
    }

    public function modelos(){
    	return $this->hasOne('App\Modelos','modelo_id','modelo_id');
    }

    public function productosdetalles(){
    	return $this->hasOne('App\ProductosDetalles','producto_id','producto_id');
    }
}
