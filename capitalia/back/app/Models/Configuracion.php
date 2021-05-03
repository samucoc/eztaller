<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = "hab_configuraciones";

    protected $fillable = [
        'variable',
        'valor',
        'descripcion',
    ];

    public static function get($variable, $valor = null)
    {
        $res = self::where('variable', $variable)->first();
        if ($res) {
            $res = $res->toArray();
            if (in_array($valor, ['valor', 'descripcion'])) {
                return $res[$valor];
            }
            return $res;
        }
        return "";
    }

    public static function getValor($variable)
    {
        return self::get($variable, 'valor');
    }

    public static function set($variable, $valor)
    {
        if (self::where('variable', $variable)->update(['valor' => $valor])) {
            return self::get($variable);
        }
        return null;
    }
}
