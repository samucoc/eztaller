<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\PropuestaFamilia;
use App\SeguimientoPropuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PropuestaController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param Beneficiario $beneficiario
     * @param int $beneficiacioId
     * @param boolean $visar
     * @return \Illuminate\Http\JsonResponse
     */
    public function visarPropuestaFamilia(Beneficiario $beneficiario, $beneficiacioId, $visar)
    {
        $beneficiarioAux = $beneficiario->find($beneficiacioId);

        $propuesta = $beneficiarioAux->propuesta;
        $propuesta->visado = $visar == 'true' ? true : false;
        $propuesta->save();

        $seguimiento = new SeguimientoPropuesta([
            "convocatoria_id" => $beneficiarioAux->convocatoria_id,
            "beneficiario_id" => $beneficiacioId,
            "user_id" => auth()->user()->id,
            "accion" => ($visar === 'true'
                ? "Se ha visado la propuesta para la familia"
                : "Se revirtió la visación de la propuesta para la familia")
        ]);
        $seguimiento->save();

        return response()->json([
            'message' => $seguimiento->{'accion'},
            'type' => 'success',
            'data' => $propuesta
        ], 200);
    }
}
