<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programas extends Model
{
    protected $fillable = [
        'programa_nombre', 'programa_descripcion', 'programa_presupuesto', 'programa_poblacion_objetivo', 'programa_responsable'
    ];
}
