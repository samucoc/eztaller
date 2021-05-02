<?php

namespace App\Http\Controllers;

use App\SeguimientoFamilia;
use Illuminate\Http\Request;

class SeguimientoFamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SeguimientoFamilia $seguimientoFamilia, $convocatoriaId)
    {
        return $seguimientoFamilia->where('convocatoria_id', '=', $convocatoriaId)->orderBy('id', 'DESC')->get();
    }
}
