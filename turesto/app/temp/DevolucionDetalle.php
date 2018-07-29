<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevolucionDetalle extends Model
{
    protected $table = 'devoluciones_detalles';


	protected $fillable = [	];

	public function devoluciones(){
		return $this->belongsTo('App\devolucion','devolucion_id','devolucion_id');
	}
}
