<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPerfil extends Model
{
    protected $table = 'tipo_perfiles';


	protected $fillable = [	];

	public function trabajadores(){
		return $this->hasMany('App\Trabajador','tp_id','tp_id');
	}
}
