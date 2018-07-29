<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
	protected $table = 'bancos';


	protected $fillable = [	];

	public function depositos(){
		return $this->belongsTo('App\Deposito','deposito_banco','banco_id');
	}
}
