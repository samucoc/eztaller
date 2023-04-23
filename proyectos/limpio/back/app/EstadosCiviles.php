<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadosCiviles extends Model
{
    protected $table = "ez_estados_civiles";

    protected $fillable = [
        'nombre',
    ];
}
