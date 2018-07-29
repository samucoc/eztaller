<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuentos extends Model
{
    protected $table = 'descuentos';
    protected $primaryKey = 'descuento_id';

	protected $fillable = [	];

	public function ventas(){
		return $this->belongsTo('App\Venta','venta_id','venta_id');
	}
}
