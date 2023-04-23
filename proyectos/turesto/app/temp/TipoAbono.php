<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoAbono extends Model
{
    protected $table = 'tipo_abonos';


	protected $fillable = [	];

	public function abonos(){
		return $this->belongsTo('App\Abono','ta_id','ta_id');
	}
}
