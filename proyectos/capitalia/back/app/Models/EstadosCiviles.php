<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosCiviles extends Model
{
    use HasFactory;
    protected $table = "ez_estados_civiles";

    protected $fillable = [
        'nombre',
    ];
}
