<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
   protected $table = 'cuotas';


	protected $fillable = [	];

	public function ventas(){
		return $this->belongsTo('App\Venta','venta_id','venta_id');
	}
}
