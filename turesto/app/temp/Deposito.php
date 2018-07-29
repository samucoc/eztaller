<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $table = 'depositos';
    protected $primaryKey = 'deposito_id';

	protected $fillable = [];

	public function trabajadores(){
		return $this->hasone('App\Trabajador','trabajador_id','trabajador_id');
	}
	public function bancos(){
		return $this->hasone('App\Bancos','banco_id','deposito_banco');
	}
	public function ctacte(){
		return $this->hasone('App\CuentaCorriente','cta_cte_id','deposito_cta_cte');
	}

	public function sectores(){
		return $this->hasone('App\Sector','sector_id','deposito_sector');
	}
}
