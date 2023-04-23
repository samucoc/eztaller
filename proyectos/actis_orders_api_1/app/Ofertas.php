<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    protected $fillable = [
        'programa_id', 'oferta_anio', 'oferta_monto', 'oferta_cupos', 'oferta_sector', 'oferta_periodo_inicio', 'oferta_periodo_fin'
    ];
}
