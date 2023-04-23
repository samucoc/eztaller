<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoProductos extends Model
{
    protected $table = 'tipo_productos';


	protected $fillable = [	];

	public function categorias(){
		return $this->belongsTo('App\Categorias','categoria_id','categoria_id');
	}

	public function productos(){
		return $this->hasMany('App\productos','tproducto_id','tproducto_id');
	}
}
