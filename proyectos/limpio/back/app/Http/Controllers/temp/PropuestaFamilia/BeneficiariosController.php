<?php

namespace App\Http\Controllers\PropuestaFamilia;

use App\Beneficiario;
use App\BitEstado;
use App\Bitacora;
use App\TipoEntidad;
use App\Const_Global_Diag;
use App\Convocatoria;
use App\DiagnosticoFamilia;
use App\Http\Controllers\Controller;
use App\MotivoCancelacion;
use App\MotivoNoVisita;
use App\Movimiento;
use App\PropuestaFamilia;
use App\PropuestaSolucion;
use App\PropuestaAsesoria;
use App\SeguimientoPropuesta;
use App\Solucion;
use App\Visita;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BeneficiariosController extends Controller
{

    public function get($convocatoria_id)
    {
        try {
            if (!is_numeric($convocatoria_id)) {
                throw new Exception("error", 1);
            }
            $items = Beneficiario::getByConvocatoria($convocatoria_id, 'numero');
            
            foreach ($items as $item) {
                if (isset($item->propuesta_familia_id)){
                    $soluciones = PropuestaSolucion::where('propuesta_id', $item->propuesta_familia_id)->orderBy('created_at')->get();
                    $item->soluciones = $soluciones;
                    $asesorias_familiares = PropuestaAsesoria::getByPropuestaId($item->propuesta_familia_id, PropuestaAsesoria::ENTIDAD_FAMILIAR);
                    $item->asesorias_familiares = $asesorias_familiares;
                }
                else{
                    $item->soluciones = [];
                    $item->asesorias_familiares = [];
                }
                $item->bit_estado_actual = BitEstado::where('id',$item->bit_estado_actual_diag_id)->get();
                $item->detalle_visible = false;
            }
            $data = $items;
            return response()->json([
                'type' => 'success',
                'message' => 'ok',
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
                'ex' => $ex
            ], 200);
        }
    }

    public function habilitar(Request $request, $convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $rules = [
                'beneficiario_id' => 'required|numeric'
            ];
            $val = Validator::make($input, $rules);

            if ($val->fails()) {
                throw new Exception($val->errors()->first(), 1);
            }
            // TODO: Cambiar estado
            $benef = Beneficiario::where('id', $input['beneficiario_id'])
                ->where('convocatoria_id', $convocatoria_id)
                ->firstOrFail();
            $benef->cambiarEstado(BitEstado::FAM_SEL, auth()->user()->id);

            // TODO: Registrar movimiento
            $movimiento = new Movimiento([
                "beneficiario_id" => $benef->id,
                "convocatoria_id" => $benef->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                "user_id" => auth()->user()->id,
                "descripcion" => "Familia habilitada",
                "motivo" => "Familia n° $benef->numero"
            ]);
            $movimiento->save();

            DB::commit();

            return response()->json([
                'type' => 'success',
                'message' => 'La familia ha sido habilitada con éxito.',
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar habilitar la familia.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function getMotivosParaDesestimar()
    {
        try {
            $motivos = MotivoCancelacion::orderBy('id')->get();
            return response()->json([
                'type' => 'success',
                'data' => $motivos,
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function getMotivosNoVisita()
    {
        try {
            $motivos = MotivoNoVisita::orderBy('id')->get();
            return response()->json([
                'type' => 'success',
                'data' => $motivos,
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function desestimar(Request $request, $convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $rules = [
                'beneficiario_id' => 'required|numeric',
                'motivo' => 'required'
            ];
            $v = Validator::make($input, $rules, [
                'motivo.required' => 'Debe especificar un motivo para continuar.'
            ]);
            if ($v->fails()) {
                return response()->json([
                    // "code" => 422,
                    "error" => $v->errors()->first(),
                    "type" => 'error',
                ], Response::HTTP_OK);
            }

            // TODO: Cambiar estado a beneficiario
            $benef = Beneficiario::where('id', $input['beneficiario_id'])->where('convocatoria_id', $convocatoria_id)->firstOrFail();
            Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $input['beneficiario_id'], BitEstado::FAM_DIA_DES, auth()->user()->id, $input['motivo']);

            // TODO: Registrar movimiento
            $movimiento = new Movimiento([
                "beneficiario_id" => $benef->id,
                "convocatoria_id" => $benef->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                "user_id" => auth()->user()->id,
                "descripcion" => "Familia desestimada. Motivo: " . $input['motivo'],
                "motivo" => "Familia n° $benef->numero"
            ]);
            $movimiento->save();

            DB::commit();
            return response()->json([
                'type' => 'success',
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar desestimar la familia.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function guardarVisita(Request $request)
    {
        DB::beginTransaction();
        try {

            $input = $request->all();
            $rules = [
                'beneficiario_id' => 'required|numeric|exists:hab_beneficiarios,id',
                'motivo_no_visita' => 'required_if:visita,2',
                'visita' => 'required|numeric|in:1,2',
                'fecha' => 'required',
                'hora' => 'required',
            ];
            $v = Validator::make($input, $rules);

            if ($v->fails()) {
                return response()->json([
                    "message" => $v->errors()->first(),
                    "type" => 'error',
                ], Response::HTTP_OK);
            }

            // TODO: Validar el estado actual de la familia
            $benef = Beneficiario::find($input['beneficiario_id']);
            if (!in_array($benef->bit_estado_actual_diag_id, [BitEstado::FAM_DIA_NO_INI, BitEstado::FAM_DIA_DES, BitEstado::FAM_DIA_FALLIDO])) {
                return response()->json([
                    'message' => 'No es posible registrar la visita porque el estado actual de la familia no lo permite.',
                    'type' => 'error'
                ], Response::HTTP_OK);
            }

            // TODO: Validar el estado actual de la convocatoria
            $conv = Convocatoria::find($benef->convocatoria_id);
            if (!in_array($conv->bit_estado_actual_id, [BitEstado::CON_SELECCION_FAMILIAS, BitEstado::CON_DIAGNOSTICO, BitEstado::CON_PROPUESTAS_TECNICAS])) {
                return response()->json([
                    'message' => 'No es posible registrar la visita porque el estado actual de la convocatoria no lo permite.',
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // TODO: Guardar visita
            $vis = Visita::create([
                'visita' => $input['visita'],
                'motivo_no_visita' => $input['motivo_no_visita'],
                'beneficiario_id' => $input['beneficiario_id'],
                'user_id' => auth()->user()->id,
                'fecha' => $input['fecha'],
                'hora' => $input['hora']
            ]);
            if ($vis->visita == 1) {
                // Diagnostico en desarrollo
                DiagnosticoFamilia::where('beneficiario_id', $vis['beneficiario_id'])->update(['estado_id' => Const_Global_Diag::EN_DESARROLLO]);
                Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $vis['beneficiario_id'], BitEstado::FAM_DIA_DES, auth()->user()->id);
                $benef = Beneficiario::find($vis['beneficiario_id'])->update(['bit_estado_actual_id'=>BitEstado::FAM_SEL]);

            } else {
                // Diagnostico fallido
                DiagnosticoFamilia::where('beneficiario_id', $vis['beneficiario_id'])->update(['estado_id' => Const_Global_Diag::FALLIDO]);
                Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $vis['beneficiario_id'], BitEstado::FAM_DIA_FALLIDO, auth()->user()->id, $vis->motivo_no_visita);
                Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $vis['beneficiario_id'], BitEstado::FAM_DIA_NO_INI, auth()->user()->id);
                $benef = Beneficiario::find($vis['beneficiario_id'])->update(['bit_estado_actual_id'=>BitEstado::FAM_SEL]);

            }

            DB::commit();
            return response()->json([
                "message" => 'La visita se ha registrado con éxito.',
                "type" => 'success',
                "data" => $vis
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar guardar la información.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    function getVisitasByBeneficiario(Request $request)
    {
        try {
            $input = $request->all();
            $rules = [
                'beneficiario_id' => 'required|numeric|exists:hab_beneficiarios,id',
            ];
            $v = Validator::make($input, $rules);

            if ($v->fails()) {
                return response()->json([
                    "message" => $v->errors()->first(),
                    "type" => 'error',
                ], Response::HTTP_OK);
            }
            $visitas = Visita::where('beneficiario_id', $input['beneficiario_id'])
                ->orderBy('id')
                ->get();
            return response()->json([
                'type' => 'success',
                'data' => $visitas,
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
     }

    function setVisadoByConvocatoria(Request $request)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $rules = [
                'convocatoria_id' => 'required|numeric|exists:hab_convocatorias,id',
            ];
            $v = Validator::make($input, $rules);

            if ($v->fails()) {
                return response()->json([
                    "message" => $v->errors()->first(),
                    "type" => 'error',
                ], Response::HTTP_OK);
            }
            
            $conv = Convocatoria::find($input['convocatoria_id']);
            if (!in_array($conv->bit_estado_actual_id, [BitEstado::CON_DIAGNOSTICO])) {
                return response()->json([
                    'message' => 'No es posible registrar la visita porque el estado actual de la convocatoria no lo permite.',
                    "type" => 'error',
                
                ], Response::HTTP_OK);
            }
            $benefs = Beneficiario::where('convocatoria_id', $conv->id)->get();
            for($i=0;$i<count($benefs);$i++){
                $b = Beneficiario::find($benefs[$i]->id);
                $diagnostico = DiagnosticoFamilia::where('beneficiario_id', '=', $b->id)->first();
                if ($diagnostico) {
                    $diagnostico->visado = true;
                    $diagnostico->estado_id = Const_Global_Diag::VISADO;
                    $diagnostico->save();

                    $b->cambiarEstado(BitEstado::FAM_DIA_VIS, auth()->user()->id);
                }
            }
            //return;
                
            $conv->cambiarEstado(BitEstado::CON_PROPUESTAS_TECNICAS, auth()->user()->id);
            Convocatoria::where('id', $conv->id)->update(['bit_estado_actual_id' => BitEstado::CON_PROPUESTAS_TECNICAS]);
           
            $items = Beneficiario::getByConvocatoria($input['convocatoria_id'], 'numero')->map(
                function ($item) {
                    $soluciones = PropuestaSolucion::where('propuesta_id', $item->propuesta_familia_id)->orderBy('created_at')->get();
                    $item->soluciones = $soluciones;
                    $asesorias_familiares = PropuestaAsesoria::getByPropuestaId($item->propuesta_familia_id, PropuestaAsesoria::ENTIDAD_FAMILIAR);
                    $item->asesorias_familiares = $asesorias_familiares;
                    return $item;
                }
            );

            $data = $items;

            DB::commit();
            return response()->json([
                'type' => 'success',
                'message' => 'Visado familias esta correcto.',
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
                'ex' => $ex
            ], Response::HTTP_OK);
        } 
    }

}
