<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Rut implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value)) {
            foreach ($value as $item) {
                if (!self::isValidRut($item)) {
                    return false;
                }
            }
            return true;
        } else {
            return self::isValidRut($value);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El RUT proporcionado no es válido.';
    }

    public static function isValidRut($rut)
    {
        if (!preg_match("/^[0-9.]+[-]?+[0-9kK]{1}/", $rut)) {
            return false;
        }
        $rut = preg_replace('/[.\-]/i', '', $rut);
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut) - 1);
        $i = 2;
        $suma = 0;
        foreach (array_reverse(str_split($numero)) as $v) {
            if ($i == 8)
                $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        $dvr = 11 - ($suma % 11);
        if ($dvr == 11)
            $dvr = 0;
        if ($dvr == 10)
            $dvr = 'K';
        if ($dvr == strtoupper($dv))
            return true;
        else
            return false;
    }
}
