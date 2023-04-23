<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TrabajadoresTienenLaboral extends Model
{
    protected $table = 'trabajadores_tiene_laboral';
    protected $primaryKey = 'tl_ncorr';

    public function ttl(){
        return $this->belongsTo('App\Trabajadores','rut_trab','trabajador_id');
    }

}
