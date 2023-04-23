<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $table = 'abonos';


	protected $fillable = [	];

	public function ventas(){
		return $this->belongsTo('App\Venta','venta_id','venta_id');
	}

	public function estadoabonos(){
		return $this->hasone('App\EstadoAbono','estado_id');
	}

	public function tipoabonos(){
		return $this->hasOne('App\TipoAbono','ta_id','ta_id');
	}
	public function cobrador(){
		return $this->belongsTo('App\Trabajador','abono_cobrador','trabajador_id');
	}
	public function supervisor(){
		return $this->belongsTo('App\Trabajador','abono_supervisor','trabajador_id');
	}
	public function trabajador(){
		return $this->belongsTo('App\Trabajador','abono_cobrador','trabajador_id');
	}
	
}
