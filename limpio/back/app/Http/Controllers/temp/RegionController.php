<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getByUser()
    {
        $regiones = [];
        $comunas = User::find(auth()->user()->id)->comunas;
        foreach ($comunas as $comuna) {
            $region = $comuna->getRegion();
            if (!in_array($region, $regiones)) {
                $regiones[] = $region;
            }
        }
        return $regiones;
    }
}