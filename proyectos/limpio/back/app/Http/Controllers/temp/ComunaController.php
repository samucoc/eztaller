<?php

namespace App\Http\Controllers;

use App\Comuna;
use App\User;

class ComunaController extends Controller
{

    public function __construct()
    {
        $this->middleware('api');
        // $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param $regionId
     * @return \Illuminate\Http\Response
     */
    public function comunasByRegion($regionId)
    {
        $comunaIds = $this->getComunasIdUsuario();
        return Comuna::where('cod_reg', $regionId)
            ->whereIn('cod_com_ine', $comunaIds)
            ->get();

    }

    public function comunasByLoggedUser()
    {
        $userId = auth()->user()->id;
        return User::find($userId)->comunas;
    }

    /**
     * Display the specified resource.
     *
     * @param Comuna $comuna
     * @return Comuna
     */
    public function show(Comuna $comuna)
    {
        return $comuna;
    }
}
