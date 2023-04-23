<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    protected $table = 'devoluciones';


	protected $fillable = [	];

	public function devoluciondetalles(){
		return $this->hasMany('App\DevolucionDetalle','devolucion_id','devolucion_id');
	}
	public function ventas(){
		return $this->belongsTo('App\Venta','venta_id','venta_id');
	}
}
