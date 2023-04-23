<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectores';


	protected $fillable = [	];


	public function clientes(){
		return $this->hasOne('App\Clientes','sector_id','sector_id');
	}

	public function ventas(){
		return $this->hasMany('App\Venta','sector_id','sectori_id');
	}
	public function depositos(){
		return $this->belongsTo('App\Deposito','deposito_sector','sector_id');
	}
}
