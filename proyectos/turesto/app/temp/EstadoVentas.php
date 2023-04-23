<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoVentas extends Model
{
    protected $table = 'estado_ventas';


	protected $fillable = [	];

	public function ventas(){
		return $this->hasOne('App\Venta','ev_id','ev_id');
	}
}
