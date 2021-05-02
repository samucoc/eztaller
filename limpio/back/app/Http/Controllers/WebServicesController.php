<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetByRutRequest;
use App\Services\ChileCrece;
use App\Services\ProgActivos;
use App\Services\RegCivil;
use App\Services\Sigec;
use Symfony\Component\HttpFoundation\Response;

class WebServicesController extends Controller
{
    public function __construct()
    {
        // $this->middleware('api');
        // $this->middleware('auth:api');
    }

    public function getPersonaByRut(GetByRutRequest $request, RegCivil $regCivil, $rut)
    {
        $persona = $regCivil->getPersonaByRut($rut);
        if ($persona === null) {
            return response()->json([
                'error' => 'El RUT ingresado no existe.'
            ], Response::HTTP_NOT_FOUND);
        }
        $age = RegCivil::calculateAge($persona['fecha_nac']);
        if ($age < 18) {
            return response()->json([
                'error' => 'El RUT ingresado corresponde a un menor de edad.'
            ], Response::HTTP_BAD_REQUEST);
        }
        return $persona;
    }

    public function getProgramasByRut(GetByRutRequest $request, ProgActivos $progActivos, $rut)
    {
        $programas = $progActivos->getProgramasByRut($rut);
        if (count($programas) == 0) {
            return response()->json([
                'error' => 'El RUT ingresado no pertenece al Subsistema Seguridades y Oportunidades.'
            ], Response::HTTP_NOT_FOUND);
        }
        return $programas;
    }

    public function getChileCreceByRut(GetByRutRequest $request, ChileCrece $chileCrece)
    {
        $rut = $request->get('rut');
        return $chileCrece->getChileCreceByRut($rut);
    }

    public function getInstitucionEjecutora(Sigec $sigec, $region, $anio)
    {
        return $sigec->getInstituciones($region, $anio);
    }
}
