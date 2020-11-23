<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpa extends Model
{
    protected $fillable = [
        'dpa_region_nombre', 'dpa_region_codigo', 'dpa_provincia_nombre', 'dpa_provincia_codigo', 'dpa_comuna_nombre', 'dpa_comuna_codigo'
    ];
}
