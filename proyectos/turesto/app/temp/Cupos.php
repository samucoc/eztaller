<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cupos extends Model
{
    protected $table = 'cupos';


	protected $fillable = [	];


	public function clientes(){
		return $this->hasOne('App\Clientes','cupo_id','cupo_id');
	}
}
