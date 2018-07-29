<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TrabajadoresTienenPrevision extends Model
{
    protected $table = 'trabajadores_tiene_prevision';
    protected $primaryKey = 'tp_ncorr';

    public function ttp(){
        return $this->belongsTo('App\Trabajadores','rut_trab','trabajador_id');
    }

}
