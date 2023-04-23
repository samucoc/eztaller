<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nuevotrabajador extends Model
{
    protected $table = 'trabajadores';

    protected $fillable = ['nombres','apellido_pat', 'apellido_mat', 'rut', 'dv' , ' sexo', 'direccion','ciudad', 'celular' , 'fecha_nac', 'estado'];
    protected $guarded = ['trabajador_ncorr']; 
}
