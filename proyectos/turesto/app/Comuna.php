<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = 'comunas';


	protected $fillable = [	];

	public function clientes(){
		return $this->hasOne('App\Clientes','comuna_id','comuna_id');
	}
}
