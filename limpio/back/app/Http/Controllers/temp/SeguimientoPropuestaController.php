<?php

namespace App\Http\Controllers;

use App\SeguimientoPropuesta;
use Illuminate\Http\Request;

class SeguimientoPropuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SeguimientoPropuesta $seguimientoPropuesta, $convocatoriaId)
    {
        return $seguimientoPropuesta->where('convocatoria_id', '=', $convocatoriaId)->orderBy('id', 'DESC')->get();
    }
}
