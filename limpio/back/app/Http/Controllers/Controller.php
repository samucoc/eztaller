<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getComunasIdUsuario()
    {
        $comunas = User::find(auth()->user()->id)->comunas->toArray();
        return array_map(function ($comuna) {
            return $comuna['cod_com_ine'];
        }, $comunas);
    }
}
