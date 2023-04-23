<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Bitacora;
use App\BitEstado;
use App\MotivoNoVisita;
use App\Visita;
use App\DiagnosticoFamilia;
use App\Const_Global_Diag;
use App\Convocatoria;
use App\TipoEntidad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getByBeneficiario($beneficiarioId)
    {
        return Visita::where('beneficiario_id', '=', $beneficiarioId)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return MotivoNoVisita[]|\Illuminate\Database\Eloquent\Collection
     */
    public function motivosNoVisita()
    {
        return MotivoNoVisita::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $req = $request->only('visita', 'motivo_no_visita_id', 'beneficiario_id', 'created_at', 'hora');


            // TODO: Validar el estado actuali de la familia
            $benef = Beneficiario::find($req['beneficiario_id']);
            if (!in_array($benef->bit_estado_actual_id, [BitEstado::FAM_DIA_NO_INI, BitEstado::FAM_DIA_FALLIDO])) {
                return response()->json([
                    'message' => 'No es posible registrar la visita porque el estado actual de la familia no lo permite.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }


            // TODO Validar el estado actual de la convocatoria
            $conv = Convocatoria::find($benef->convocatoria_id);
            if (!in_array($conv->bit_estado_actual_id, [BitEstado::CON_SELECCION_FAMILIAS, BitEstado::CON_DIAGNOSTICO, BitEstado::CON_PROPUESTAS_TECNICAS])) {
                return response()->json([
                    'message' => 'No es posible registrar la visita porque el estado actual de la convocatoria no lo permite.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $newVisita = [
                'visita' => $req['visita'],
                'motivo_no_visita_id' => $req['motivo_no_visita_id'],
                'beneficiario_id' => $req['beneficiario_id'],
                'created_at' => $req['created_at'] . " 00:00:00",
                'hora' => $req['hora']
            ];
            $visita = new Visita($newVisita);
            if ($visita->save()) {
                if ($visita['motivo_no_visita_id'] == NULL) {
                    // Diagnostico en desarrollo
                    DiagnosticoFamilia::where('beneficiario_id', $visita['beneficiario_id'])->update(['estado_id' => Const_Global_Diag::EN_DESARROLLO]);
                    Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $visita['beneficiario_id'], BitEstado::FAM_DIA_DES, auth()->user()->id);

                } else {
                    // Diagnostico fallido
                    DiagnosticoFamilia::where('beneficiario_id', $visita['beneficiario_id'])->update(['estado_id' => Const_Global_Diag::FALLIDO]);
                    Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $visita['beneficiario_id'], BitEstado::FAM_DIA_FALLIDO, auth()->user()->id, MotivoNoVisita::find($req['motivo_no_visita_id'])->nombre);
                    Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $visita['beneficiario_id'], BitEstado::FAM_DIA_NO_INI, auth()->user()->id);
                }
                DB::commit();
                return response()->json([
                    'message' => 'Visita registrada.',
                    'type' => 'success',
                    'data' => $visita
                ], 200);
            }
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la visita, intente mas tarde.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear la visita, intente mas tarde.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
