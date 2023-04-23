<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfertasDpas extends Model
{
    protected $fillable = [
        'oferta_id', 'dpa_id', 'oferta_dpa_responsable_comuna', 'oferta_dpa_cupos', 'oferta_dpa_monto'
    ];
}
