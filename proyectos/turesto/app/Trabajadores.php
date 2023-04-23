<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Trabajadores extends Model
{
    protected $table = 'trabajadores';
	protected $primaryKey = 'trabajador_id';

    public function comunas(){
        return $this->belongsTo('App\Comunas','comuna_id','comuna_id');
    }    
    public function tipos_perfiles(){
        return $this->belongsTo('App\TipoPerfil','tp_id','tp_id');
    }
    public function ttp(){
        return $this->belongsTo('App\TrabajadoresTienenPrevision','trabajador_id','rut_trab');
    }
    public function ttl(){
        return $this->belongsTo('App\TrabajadoresTienenLaboral','trabajador_id','rut_trab');
    }
}
