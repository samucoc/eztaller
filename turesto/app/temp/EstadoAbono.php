<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoAbono extends Model
{
    protected $table = 'estado_abonos';


	protected $fillable = [	];

	public function abonos(){
		return $this->belongsTo('App\Abono','estado_id','estado_id');
	}
}
