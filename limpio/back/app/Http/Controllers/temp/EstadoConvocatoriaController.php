<?php

namespace App\Http\Controllers;

use App\EstadoConvocatoria;
use Illuminate\Http\Request;

class EstadoConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EstadoConvocatoria::select('id')->select('estado as nombre')->where('id','<','9')->get();
    }
}
