<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $table = 'empresas';


	protected $fillable = ['empresa_rut','empresa_nombre','empresa_direccion','empresa_giro','empresa_mail','empresa_mutual','empresa_estado'];
	
}
