<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';


	protected $fillable = [	];

	//cliente pertenece a una comuna
	public function comunas(){
		return $this->belongsTo('App\Comuna','comuna_id','comuna_id');
	}

	//cliente pertenece a un sector
	public function sectores(){
		return $this->belongsTo('App\Sector','sector_id','sector_id');
	}
	//cliente tiene muchas ventas
	public function ventas(){
		return $this->hasmany('App\Venta','cliente_id','cliente_id');
	}
	//cliente tiene un cupo
	public function cupos(){
		return $this->belongsTo('App\Cupos','cupo_id','cupo_id');
	}


}
