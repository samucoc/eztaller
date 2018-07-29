<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $table = 'ventas_detalles';


	protected $fillable = [	];

	public function ventas(){
		return $this->belongsTo('App\Venta','venta_id','venta_id');
	}

}
