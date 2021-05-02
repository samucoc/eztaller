<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\BitEstado;
use App\Http\Controllers\PropuestaFamilia\BeneficiariosController;
use App\PropuestaAsesoria;
use App\PropuestaFamilia;
use App\TipoAsesoria;
use App\TipoPropuesta;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResumenPropuestaComunalController extends Controller
{
    public function get($convocatoria_id)
    {
        try {

            $data = PropuestaFamilia::resumenPicExport($convocatoria_id, TipoPropuesta::PIC);

            $visar = [
                'dia' => PropuestaFamilia::getDiagnosticosParaVisar($convocatoria_id),
                // 'sol' => PropuestaFamilia::getSolucionesParaVisar($convocatoria_id),
                // 'ase' => PropuestaFamilia::getAsesoriasParaVisar($convocatoria_id)
            ];
            // TODO: Cantidad de diagnosticos a visar
            // TODO: Cantidad de soluciones a visar
            // TODO: Cantidad de asesorias a visar
            return response()->json([
                'type' => 'success',
                'data' => $data,
                'visar' => $visar
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'message' => 'Error al intentar obtener la información.',
                'type' => 'error',
            ], 500);
        }
    }
}
