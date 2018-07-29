<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaCorriente extends Model
{
     protected $table = 'cuentas_corrientes';


	protected $fillable = [	];

	public function depositos(){
		return $this->belongTo('App\Deposito','deposito_cta_cte','cta_cte_id');
	}
}
