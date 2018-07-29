<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoFormaPago extends Model
{
    protected $table = 'tipo_formas_pagos';


	protected $fillable = [	];

	public function ventas(){
		return $this->hasOne('App\Venta','tfp_id','tfp_id');
	}
}
