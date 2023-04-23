<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelos extends Model
{
    //le indicamos a nuestro modelo cual tabla usaremos de nuestra bd
    protected $table = 'modelos';

    //estos son los campos que se utilizaran del modelo
    protected $fillable = [];

    public function producto(){
    	return $this->belongsTo('App\Productos','modelo_id','modelo_id');
    }
}
