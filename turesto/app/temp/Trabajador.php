<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    public function ventas(){
    	return $this->hasMany('App\Venta','trabajador_id','trabajador_id');
    }

    public function tipoperfiles(){
    	return $this->belongsTo('App\TipoPerfil','tp_id','tp_id');
    }

    public function abonos(){
    	return $this->hasMany('App\Abono','trabajador_id','abono_cobrador');
    }

    public function abonos2(){
    	return $this->hasMany('App\Abono','trabajador_id','abono_supervisor');
    }

    public function depositos(){
        return $this->belongsTo('App\Deposito','trabajador_id','trabajador_id');
    }
}
