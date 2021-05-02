<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Convocatoria;
use App\PropuestaAsesoria;
use App\PropuestaAsesoriaComentario;
use App\PropuestaSolucion;
use App\PropuestaSolucionComentario;
use App\PropuestaFamilia;
use App\TipoPropuesta;
use App\Bitacora;
use App\BitEstado;
use App\TipoEntidad;
use App\PhotoAsesoria;
use App\PhotoSolucion;
use Webpatser\Uuid\Uuid;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Signer\EcdsaTest;

class EjecucionPropuestasController extends Controller
{

    public function __construct()
    {
        $this->middleware('api');
        // $this->middleware('auth:api');
    }

    /**
     * Display the specified resource.
     *
     * @param int $convocatoriaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFamilias($convocatoria_id)
    {
        $beneficiarios = Beneficiario::getByConvocatoria($convocatoria_id, 'numero');
        $total = [
            'solucion_no_iniciada' => 0,
            'solucion_en_ejecucion' => 0,
            'solucion_desestimada' => 0,
            'solucion_solicita_recepcion' => 0,
            'solucion_recepcion_aprobadas' => 0,
            'solucion_recepcion_rechazada' => 0,
            'inversion_por_familia' => 0,
            'porcentaje_soluciones' => 0,
            'asesoria_no_iniciada' => 0,
            'asesoria_no_iniciada' => 0,
            'asesoria_no_iniciada' => 0,
            'asesoria_desestimada' => 0,
            'asesoria_ejecutada' => 0,
        ];
        foreach ($beneficiarios as $key => $item) {

            $sol_no_ini = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_NO_INI)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_en_eje = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_EN_EJE)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_des = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_DES)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_sol_rec = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_SOL_REC)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_rec_apr_obs = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_APR_OBS)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_rec_apr_adm = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_APR_ADM)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_rec_apr = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_APR)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_rec_apr_sub = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_APR_SUB)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();
            $sol_rec_rec = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_REC)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();

            $sol_rec_rec = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->where('hab_propuesta_soluciones.bit_estado_actual_id', BitEstado::SOL_REC_REC)
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->count();

            $sol_total = $sol_no_ini + $sol_en_eje + $sol_des + $sol_sol_rec + $sol_rec_apr_obs + $sol_rec_apr_adm + $sol_rec_apr + $sol_rec_apr_sub + $sol_rec_rec;
            $sol_apr_total = $sol_rec_apr_obs + $sol_rec_apr_adm + $sol_rec_apr + $sol_rec_apr_sub;
            $sol_por_apr = ($sol_total == 0) ? 0 : ($sol_apr_total * 100) / $sol_total;
            $sol_por_apr = round($sol_por_apr, 1);
            $sol_por_apr = number_format($sol_por_apr, 1);

            $beneficiarios[$key]->{'solucion_no_iniciada'} = $sol_no_ini;
            $beneficiarios[$key]->{'solucion_en_ejecucion'} = $sol_en_eje;
            $beneficiarios[$key]->{'solucion_desestimada'} = $sol_des;
            $beneficiarios[$key]->{'solucion_solicita_recepcion'} = $sol_sol_rec;
            $beneficiarios[$key]->{'solucion_recepcion_aprobadas'} = $sol_rec_apr_sub + $sol_rec_apr_obs + $sol_rec_apr_adm + $sol_rec_apr;
            $beneficiarios[$key]->{'solucion_recepcion_rechazada'} = $sol_rec_rec;


            $beneficiarios[$key]->{'porcentaje_soluciones'} = $sol_por_apr;

            $total['solucion_no_iniciada'] += $beneficiarios[$key]->{'solucion_no_iniciada'};
            $total['solucion_en_ejecucion'] += $beneficiarios[$key]->{'solucion_en_ejecucion'};
            $total['solucion_desestimada'] += $beneficiarios[$key]->{'solucion_desestimada'};
            $total['solucion_solicita_recepcion'] += $beneficiarios[$key]->{'solucion_solicita_recepcion'};
            $total['solucion_recepcion_aprobadas'] += $beneficiarios[$key]->{'solucion_recepcion_aprobadas'};
            $total['solucion_recepcion_rechazada'] += $beneficiarios[$key]->{'solucion_recepcion_rechazada'};


            $ase_no_ini = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
                ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
                ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_NO_INI)
                ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_FAMILIAR)
                ->where('hab_propuesta_familias.beneficiario_id', $item->id)
                ->count();
            $ase_des = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
                ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
                ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_DES)
                ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_FAMILIAR)
                ->where('hab_propuesta_familias.beneficiario_id', $item->id)
                ->count();
            $ase_eje = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
                ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
                ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_EJE)
                ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_FAMILIAR)
                ->where('hab_propuesta_familias.beneficiario_id', $item->id)
                ->count();

            $beneficiarios[$key]->{'asesoria_no_iniciada'} = $ase_no_ini;
            $beneficiarios[$key]->{'asesoria_desestimada'} = $ase_des;
            $beneficiarios[$key]->{'asesoria_ejecutada'} = $ase_eje;

            $total['asesoria_no_iniciada'] += $beneficiarios[$key]->{'asesoria_no_iniciada'};
            $total['asesoria_desestimada'] += $beneficiarios[$key]->{'asesoria_desestimada'};
            $total['asesoria_ejecutada'] += $beneficiarios[$key]->{'asesoria_ejecutada'};


            $sol_monto_aporte_total = PropuestaSolucion::join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_propuesta_soluciones.propuesta_id')
                ->join('hab_beneficiarios', 'hab_beneficiarios.id', '=', 'hab_propuesta_familias.beneficiario_id')
                ->select(DB::raw('sum(monto_aporte_total) as monto_aporte_total'))
                ->where('hab_beneficiarios.convocatoria_id', $item->id)
                ->get();

            $monto_aporte_total = 0;
            foreach ($sol_monto_aporte_total as $monto_total) {
                $monto_aporte_total  = $monto_total['monto_aporte_total'];
            }
            $beneficiarios[$key]->{'inversion_por_familia'} = (int) $monto_aporte_total;
            $total['inversion_por_familia'] += (int) $beneficiarios[$key]->{'inversion_por_familia'};
        }

        $_sol_total = $total['solucion_no_iniciada'] +
            $total['solucion_en_ejecucion'] +
            $total['solucion_desestimada'] +
            $total['solucion_solicita_recepcion'] +
            $total['solucion_recepcion_aprobadas'] +
            $total['solucion_recepcion_rechazada'];

        $_sol_apr_total = $total['solucion_recepcion_aprobadas'];

        $_sol_por_apr = ($_sol_total == 0) ? 0 : ($_sol_apr_total * 100) / $_sol_total;
        $_sol_por_apr = round($_sol_por_apr, 1);
        $_sol_por_apr = number_format($_sol_por_apr, 1);

        $total['porcentaje_soluciones'] = $_sol_por_apr;

        return response()->json([
            "code" => 200,
            "type" => 'success',
            "data" => [
                'familias' => $beneficiarios,
                'familias_total' => $total
            ],
        ]);
    }

    public function getAsesoriasGrupales($convocatoria_id)
    {
        $ase_no_ini = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
            ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
            ->join('hab_beneficiarios', 'hab_propuesta_familias.beneficiario_id', '=', 'hab_beneficiarios.id')
            ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_NO_INI)
            ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_GRUPAL)
            ->where('hab_beneficiarios.convocatoria_id', $convocatoria_id)
            ->distinct()
            ->count('hab_propuesta_asesorias.id');
        // $ase_no_ini = 99;
        $ase_des = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
            ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
            ->join('hab_beneficiarios', 'hab_propuesta_familias.beneficiario_id', '=', 'hab_beneficiarios.id')
            ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_DES)
            ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_GRUPAL)
            ->where('hab_beneficiarios.convocatoria_id', $convocatoria_id)
            ->distinct()
            ->count('hab_propuesta_asesorias.id');
        $ase_eje = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
            ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
            ->join('hab_beneficiarios', 'hab_propuesta_familias.beneficiario_id', '=', 'hab_beneficiarios.id')
            ->where('hab_propuesta_asesorias.bit_estado_actual_id', BitEstado::ASE_EJE)
            ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_GRUPAL)
            ->where('hab_beneficiarios.convocatoria_id', $convocatoria_id)
            ->distinct()
            ->count('hab_propuesta_asesorias.id');
        $can_fam = PropuestaAsesoria::join('hab_pro_fam_pro_ase', 'hab_pro_fam_pro_ase.pro_ase_id', '=', 'hab_propuesta_asesorias.id')
            ->join('hab_propuesta_familias', 'hab_propuesta_familias.id', '=', 'hab_pro_fam_pro_ase.pro_fam_id')
            ->join('hab_beneficiarios', 'hab_propuesta_familias.beneficiario_id', '=', 'hab_beneficiarios.id')
            ->where('hab_propuesta_asesorias.entidad', PropuestaAsesoria::ENTIDAD_GRUPAL)
            ->where('hab_beneficiarios.convocatoria_id', $convocatoria_id)
            ->distinct()
            ->count('hab_propuesta_asesorias.id');

        $ase_total = $ase_no_ini + $ase_des + $ase_eje;
        $por_eje = ($ase_total == 0) ? 0 : ($ase_eje * 100) / $ase_total;
        $por_eje = round($por_eje, 1);
        $por_eje = number_format($por_eje, 1);


        $data = [
            'no_iniciada' => $ase_no_ini,
            'desestimada' => $ase_des,
            'ejecutada' => $ase_eje,
            'porcentaje_ejecucion' => $por_eje,
            'cantidad_familias' => $can_fam,
        ];
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $data,
        ], 200);
    }

    public function getByBeneficiario($beneficiario_id)
    {
        try {
            $benef = Beneficiario::getById($beneficiario_id);
            $pro = PropuestaFamilia::getByBeneficiarioId($benef->id, TipoPropuesta::PIC);
            $conv = Convocatoria::searchFirst(['convocatoria_id' => $benef->convocatoria_id]);
            $ase_fam = PropuestaAsesoria::getByPropuestaId($pro->id, PropuestaAsesoria::ENTIDAD_FAMILIAR);
            $sol_fam = PropuestaSolucion::getByPropuestaId($pro->id);
            $sol_tot_apo = [
                'aporte_total' => 0,
                'aporte_mds' => 0,
                'aporte_local' => 0,
                'aporte_otros' => 0,
            ];

            // Asesorias
            foreach ($ase_fam as $key => $item) {
                $ase_fam[$key]->comentario = PropuestaAsesoriaComentario::select([
                    'hab_pro_ase_comentarios.comentario',
                    DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
                    DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
                    'hab_users.nombre as user_nombre'
                ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
                    ->where('pro_ase_id', $item->propuesta_asesoria_id)
                    ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
                    ->first();
            }

            // Soluciones
            foreach ($sol_fam as $key => $item) {
                $sol_fam[$key]->comentario = PropuestaSolucionComentario::select([
                    'hab_pro_sol_comentarios.comentario',
                    DB::raw("TO_CHAR(hab_pro_sol_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
                    DB::raw("TO_CHAR(hab_pro_sol_comentarios.created_at,'HH:II') as hora_creacion"),
                    'hab_users.nombre as user_nombre'
                ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_sol_comentarios.user_id')
                    ->where('pro_sol_id', $item->propuesta_id)
                    ->orderBy('hab_pro_sol_comentarios.created_at', 'desc')
                    ->first();
                $sol_fam[$key]->photos = $this->getPhotosSoluciones($item->propuesta_solucion_id);

                $sol_tot_apo['aporte_total'] += $sol_fam[$key]->monto_aporte_total;
                $sol_tot_apo['aporte_mds'] += $sol_fam[$key]->monto_aporte_mds;
                $sol_tot_apo['aporte_local'] += $sol_fam[$key]->monto_aporte_local;
                $sol_tot_apo['aporte_otros'] += $sol_fam[$key]->monto_aporte_otros;
            }

            $data = [
                'beneficiario' => $benef,
                'convocatoria' => $conv,
                'asesorias_familiares' => $ase_fam,
                'soluciones_familiares' => $sol_fam,
                'soluciones_total_aportes' => $sol_tot_apo
            ];
            return response()->json([
                'code' => 200,
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'code' => 500,
                'type' => 'error',
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function saveAseFamComentario(Request $request)
    {
        $fields = $request->all();

        $rules = [
            'pro_ase_id' => 'required|integer',
            'comentario' => 'required',
        ];
        $v = Validator::make($fields, $rules, [
            'required' => 'Este campo es requerido.'
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }

        $res = PropuestaAsesoriaComentario::create([
            'comentario' => $fields['comentario'],
            'pro_ase_id' => $fields['pro_ase_id'],
            'user_id' =>  auth()->user()->id,
        ]);

        return response()->json([
            'code' => 200,
            'type' => 'success',
            'message' => 'El comentario se ha registrado con éxito',
            'data' => $res
        ], 200);
    }

    public function saveAseFamGrupComentario(Request $request)
    {
        $fields = $request->all();

        $rules = [
            'pro_ase_id' => 'required|integer',
            'comentario' => 'required',
        ];
        $v = Validator::make($fields, $rules, [
            'required' => 'Este campo es requerido.'
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }

        $res = PropuestaAsesoriaComentario::create([
            'comentario' => $fields['comentario'],
            'pro_ase_id' => $fields['pro_ase_id'],
            'user_id' =>  auth()->user()->id,
        ]);

        return response()->json([
            'code' => 200,
            'type' => 'success',
            'message' => 'El comentario se ha registrado con éxito',
            'data' => $res
        ], 200);
    }

    public function saveSolFamComentarios(Request $request)
    {
        $fields = $request->all();

        $rules = [
            'pro_sol_id' => 'required|integer',
            'comentario' => 'required',
        ];
        $v = Validator::make($fields, $rules, [
            'required' => 'Este campo es requerido.'
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }

        $res = PropuestaSolucionComentario::create([
            'comentario' => $fields['comentario'],
            'pro_sol_id' => $fields['pro_sol_id'],
            'user_id' =>  auth()->user()->id,
        ]);

        return response()->json([
            'code' => 200,
            'type' => 'success',
            'message' => 'El comentario se ha registrado con éxito',
            'data' => $res
        ], 200);
    }

    public function saveSolFamEstados(Request $request)
    {
        $fields = $request->all();

        $rules = [
            'pro_sol_id' => 'required|integer',
            'estado_id' => 'required',
        ];
        $v = Validator::make($fields, $rules, [
            'required' => 'Este campo es requerido.'
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }

        $res = Bitacora::cambiarEstado(TipoEntidad::SOLUCION, $fields['pro_sol_id'], $fields['estado_id'], auth()->user()->id);


        return response()->json([
            'code' => 200,
            'type' => 'success',
            'message' => 'Estado Actualizado',
            'data' => $res
        ], 200);
    }

    public function saveAseFamEstados(Request $request)
    {
        $fields = $request->all();

        $rules = [
            'pro_sol_id' => 'required|integer',
            'estado_id' => 'required',
        ];
        $v = Validator::make($fields, $rules, [
            'required' => 'Este campo es requerido.'
        ]);

        if ($v->fails()) {
            return response()->json([
                "code" => 422,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }

        $res = Bitacora::cambiarEstado(TipoEntidad::ASESORIA, $fields['pro_sol_id'], $fields['estado_id'], auth()->user()->id);


        return response()->json([
            'code' => 200,
            'type' => 'success',
            'message' => 'Estado Actualizado',
            'data' => $res
        ], 200);
    }

    public function getAseFamComentarios($propuesta_asesoria_id)
    {
        $comentarios = PropuestaAsesoriaComentario::select([
            'hab_pro_ase_comentarios.comentario',
            DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
            DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
            'hab_users.nombre as user_nombre'
        ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
            ->where('pro_ase_id', $propuesta_asesoria_id)
            ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
            ->get();
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $comentarios
        ], 200);
    }

    public function getAseFamGrupComentarios($propuesta_asesoria_id)
    {
        $comentarios = PropuestaAsesoriaComentario::select([
            'hab_pro_ase_comentarios.comentario',
            DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
            DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
            'hab_users.nombre as user_nombre'
        ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
            ->where('pro_ase_id', $propuesta_asesoria_id)
            ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
            ->get();
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $comentarios
        ], 200);
    }

    public function getSolFamComentarios($solucion_id)
    {
        $comentarios = PropuestaSolucionComentario::select([
            'hab_pro_sol_comentarios.comentario',
            DB::raw("TO_CHAR(hab_pro_sol_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
            DB::raw("TO_CHAR(hab_pro_sol_comentarios.created_at,'HH24:MI') as hora_creacion"),
            'hab_users.nombre as user_nombre'
        ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_sol_comentarios.user_id')
            ->where('pro_sol_id', $solucion_id)
            ->orderBy('hab_pro_sol_comentarios.created_at', 'desc')
            ->get();
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $comentarios
        ], 200);
    }

    public function getEstadoOptions()
    {
        $soluciones = BitEstado::select([
            'estado as text',
            'id as value',
        ])->where('tipo_entidad_id', TipoEntidad::SOLUCION)->orderBy('orden')->get();

        $asesorias = BitEstado::select([
            'estado as text',
            'id as value',
        ])->where('tipo_entidad_id', TipoEntidad::ASESORIA)->orderBy('orden')->get();
        $data = [
            'soluciones' => $soluciones,
            'asesorias' => $asesorias,
        ];
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function PhotoAsesoria(Request $request)
    {

        try {
            $req = $request->all();
            $id = $req['id'];
            $PropuestaAsesoria = PropuestaAsesoria::find($id);

            if (!$PropuestaAsesoria) {
                response()->json([
                    'message' => 'No existe el Beneficiario.',
                ], Response::HTTP_NOT_FOUND);
            }

            $file = $request->file('file');

            $archivo = new PhotoAsesoria();
            list($name, $ext) = explode('.', $req['filename']);
            $archivo->filename =  Uuid::generate()->string . '.' . $ext;
            $archivo->original_name = $req['original_name'];
            $archivo->size = $req['size'];
            $archivo->mime_type = $req['mime_type'];
            $archivo->disk = $req['disk'];
            $archivo->pro_ase_id = $req['id'];
            $archivo->setFile($file);
            $archivo->save();

            $data = PhotoAsesoria::search(['pro_ase_id' => $PropuestaAsesoria->id]);

            return response()->json([
                'message' => 'Se ha subido correctamente el archivo.',
                'type' => 'success',
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Ha ocurrido un error al intentar subir el archivo.',
                'type' => 'success',
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function displayPhotos($id)
    {
        $archivo = PhotoAsesoria::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->file($pathtoFile);
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadPhotos($id)
    {
        $archivo = PhotoAsesoria::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app/private/') . $archivo->filename;
        return response()->download($pathtoFile, $archivo->filename);
    }

    public function getPhotosSoluciones($pro_sol_id)
    {
        $result = PhotoSolucion::search(['pro_sol_id' => $pro_sol_id]);
        return $result->toArray();
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function uploadPhotoSoluciones(Request $request)
    {
        try {

            $req = $request->all();

            $PropuestaSolucion = PropuestaSolucion::findOrFail($request->pro_sol_id);
            $file = $request->file('file');
            Log::info($file);

            list($name, $ext) = explode('.', $request->filename);

            $arc = new PhotoSolucion();

            $arc->pro_sol_id = $request->pro_sol_id;
            $arc->filename = Uuid::generate()->string . '.' . $ext;
            $arc->original_name = $request->original_name;
            $arc->size = $request->size;
            $arc->mime_type = $request->mime_type;
            $arc->disk = $request->disk;
            $arc->setFile($file);
            $arc->save();

            $data = PhotoSolucion::search([
                'pro_sol_id' => $PropuestaSolucion->id
            ]);

            return response()->json([
                'message' => 'Se ha subido correctamente el archivo.',
                'type' => 'success',
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Ha ocurrido un error al intentar subir el archivo.',
                'type' => 'success',
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function displayPhotoSoluciones($id)
    {
        try {
            $archivo = PhotoSolucion::findOrFail($id);

            $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
            return response()->file($pathtoFile);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadPhotoSoluciones($id)
    {
        try {
            $arc = PhotoSolucion::findOrFail($id);
            $path = storage_path('app/private/') . $arc->filename;
            return response()->download($path, $arc->filename);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
