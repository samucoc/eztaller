<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'venta_id';



	protected $fillable = [	];

	public function clientes(){
		return $this->belongsTo('App\Clientes','cliente_id','cliente_id');
	}

	public function sectores(){
		return $this->belongsTo('App\Sector','sector_id','sector_id');
	}

	public function tipoformaspagos(){
		return $this->belongsTo('App\TipoFormaPago','tfp_id','tfp_id');
	}

	public function trabajadores(){
		return $this->belongsTo('App\Trabajador','trabajador_id','trabajador_id');
	}

	public function estadoventas(){
		return $this->belongsTo('App\EstadoVentas','ev_id','ev_id');
	}

	public function abonos(){
		return $this->hasMany('App\Abono','venta_id','venta_id');
	}

	public function cuotas(){
		return $this->hasMany('App\Cuota','venta_id','venta_id');
	}

	public function ventadetalles(){
		return $this->hasMany('App\VentaDetalle','venta_id','venta_id');
	}

	public function devoluciones(){
		return $this->hasMany('App\Devolucion','venta_id','venta_id');
	}

	public function descuentos(){
		return $this->hasMany('App\Descuentos','venta_id','venta_id');
	}


}
