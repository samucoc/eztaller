<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Bitacora;
use App\BitEstado;
use App\Convocatoria;
use App\CostoAsesoria;
use App\DetalleSolucion;
use App\Estado;
use App\Exports\ResumenModPicExport;
use App\Exports\ResumenPicExport;
use App\Grupo;
use App\ModalidadAsesoria;
use App\PropuestaAsesoria;
use App\PropuestaAsesoriaComentario;
use App\PropuestaFamilia;
use App\PropuestaSolucion;
use App\PropuestaSolucionDetalleSolucion;
use App\SeguimientoPropuesta;
use App\Solucion;
use App\Tematica;
use App\TipoAsesoria;
use App\TipoEntidad;
use App\TipoPropuesta;
use App\PhotoAsesoria;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class PropuestasController extends Controller
{

    public function dropAsesoriaFamiliar(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $rules = [
                'propuesta_id' => 'required|integer',
                'propuesta_asesoria_id' => 'required|integer',
            ];
            $v = Validator::make($fields, $rules);
            if ($v->fails()) {
                return response()->json([
                    "code" => 200,
                    "message" => $v->errors()->first(),
                    "type" => 'error',
                ]);
            }

            // //TODO: Eliminar en hab_pro_fam_pro_ase
            // DB::table('hab_pro_fam_pro_ase')
            //     ->where('pro_fam_id', $fields['propuesta_id'])
            //     ->where('pro_ase_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            // //TODO: Eliminar en hab_pro_ase_sol
            // DB::table('hab_pro_ase_sol')
            //     ->where('propuesta_asesoria_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            // //TODO: Eliminar en hab_pro_ase_tem
            // DB::table('hab_pro_ase_tem')
            //     ->where('propuesta_asesoria_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            //TODO: Eliminar propuesta_asesorias
            $pro_ase = PropuestaAsesoria::find($fields['propuesta_asesoria_id']);
            $pro_ase->delete();

            DB::commit();
            return response()->json([
                'type' => 'success',
                'code' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function exportResumenPic(Excel $excel, $convocatoria_id)
    {
        // $vars = PropuestaFamilia::resumenPicExport($convocatoria_id, TipoPropuesta::PIC);
        // return view('propuestas/resumen_pic', $vars);

        $export = new ResumenPicExport($convocatoria_id, TipoPropuesta::PIC);
        return $excel->download($export, $export->title() . '.xlsx');
    }

    public function exportResumenModPic(Excel $excel, $convocatoria_id)
    {
        // $vars = PropuestaFamilia::resumenModPicExport($convocatoria_id, TipoPropuesta::MOD_PIC);
        // return view('propuestas/resumen_pic', $vars);

        $export = new ResumenModPicExport($convocatoria_id, TipoPropuesta::MOD_PIC);
        return $excel->download($export, $export->title() . '.xlsx');
    }



    public function getResumenPic($convocatoria_id)
    {
        $data = [
            'familias_estimadas' => 0,
            'familias_comprometidas' => 0,
            'asesorias' => 0,
            'soluciones' => 0,
            'cobertura' => 0,
            'monto_aporte_mds' => 0,
            'monto_aporte_local' => 0,
            'monto_aporte_otros' => 0,
            'monto_aporte_total' => 0,
        ];
        // TODO: Obtener beneficiarios de una convocatoria
        $beneficiarios = Beneficiario::where('convocatoria_id', $convocatoria_id)->pluck('id')->toArray();

        // TODO: Familias estimadas
        $convocatoria = Convocatoria::find($convocatoria_id);
        $data['familias_estimadas'] = $convocatoria->familias_estimadas;

        // TODO: Familias comprometidas
        $sql = "select 
            count(distinct(t1.id)) as familias_comprometidas
            from hab_beneficiarios t1
            inner join hab_propuesta_familias t2 on t2.beneficiario_id=t1.id
            inner join hab_propuesta_soluciones t3 on t3.propuesta_id=t2.id
            inner join hab_pro_sol_det_sol t4 on t4.propuesta_solucion_id=t3.id
            inner join hab_detalle_soluciones t5 on t5.id=t4.detalle_solucion_id
            where t1.convocatoria_id=" . $convocatoria_id . "
            and t3.deleted_at is null
            and t2.tipo_propuesta_id=" . TipoPropuesta::PIC . "
            and t4.intervenir=1";
        $res = DB::select($sql);
        $data['familias_comprometidas'] = $res[0]->familias_comprometidas;

        // TODO: % Cobertura
        $data['cobertura'] = (empty($data['familias_estimadas'])) ? 0 : ($data['familias_comprometidas'] / $data['familias_estimadas']) * 100;

        $pic = PropuestaFamilia::getDatosPropuestaByFamilias($beneficiarios, TipoPropuesta::PIC);
        foreach ($pic as $row) {

            $data['soluciones'] += $row->num_soluciones;
            $data['monto_aporte_mds'] += $row->monto_aporte_mds;
            $data['monto_aporte_otros'] += $row->monto_aporte_otros;
            $data['monto_aporte_local'] += $row->monto_aporte_local;
            $data['monto_aporte_total'] += $row->monto_aporte_total;
            // $data['asesorias'] += $res[0]->num_asesorias;
        }
        // TODO: Número de asesorias
        $sql = "select 
                count(distinct(t7.id)) as num_asesorias                
                from hab_beneficiarios t1
                inner join hab_propuesta_familias t2 on t2.beneficiario_id=t1.id
                inner join hab_pro_fam_pro_ase t6 on t6.pro_fam_id=t2.id
                inner join hab_propuesta_asesorias t7 on t7.id=t6.pro_ase_id                
                where t1.convocatoria_id=" . $convocatoria_id . "
                and t7.deleted_at is null
                and t2.tipo_propuesta_id=" . TipoPropuesta::PIC;
        $res = DB::select($sql);
        $data['asesorias'] = $res[0]->num_asesorias;
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function getResumenModPic($convocatoria_id)
    {
        $data = [
            'familias_estimadas' => 0,
            'familias_comprometidas' => 0,
            'asesorias' => 0,
            'soluciones' => 0,
            'cobertura' => 0,
            'monto_aporte_mds' => 0,
            'monto_aporte_local' => 0,
            'monto_aporte_otros' => 0,
            'monto_aporte_total' => 0,
        ];
        // TODO: Obtener beneficiarios de una convocatoria
        $beneficiarios = Beneficiario::where('convocatoria_id', $convocatoria_id)->pluck('id')->toArray();

        // TODO: Familias estimadas
        $convocatoria = Convocatoria::find($convocatoria_id);
        $data['familias_estimadas'] = $convocatoria->familias_estimadas;

        // TODO: Familias comprometidas
        $sql = "select 
            count(distinct(t1.id)) as familias_comprometidas
            from hab_beneficiarios t1
            inner join hab_propuesta_familias t2 on t2.beneficiario_id=t1.id
            inner join hab_propuesta_soluciones t3 on t3.propuesta_id=t2.id
            inner join hab_pro_sol_det_sol t4 on t4.propuesta_solucion_id=t3.id
            inner join hab_detalle_soluciones t5 on t5.id=t4.detalle_solucion_id
            where t1.convocatoria_id=" . $convocatoria_id . "
            and t3.deleted_at is null
            and t2.tipo_propuesta_id=" . TipoPropuesta::MOD_PIC . "
            and t4.intervenir=1";
        $res = DB::select($sql);
        $data['familias_comprometidas'] = $res[0]->familias_comprometidas;

        // TODO: % Cobertura
        $data['cobertura'] = (empty($data['familias_estimadas'])) ? 0 : ($data['familias_comprometidas'] / $data['familias_estimadas']) * 100;

        $pic = PropuestaFamilia::getDatosPropuestaByFamilias($beneficiarios, TipoPropuesta::MOD_PIC);
        foreach ($pic as $row) {
            $data['soluciones'] += $row->num_soluciones;
            $data['monto_aporte_mds'] += $row->monto_aporte_mds;
            $data['monto_aporte_otros'] += $row->monto_aporte_otros;
            $data['monto_aporte_local'] += $row->monto_aporte_local;
            $data['monto_aporte_total'] += $row->monto_aporte_total;
        }
        // TODO: Número de asesorias
        $sql = "select 
                count(distinct(t7.id)) as num_asesorias                
                from hab_beneficiarios t1
                inner join hab_propuesta_familias t2 on t2.beneficiario_id=t1.id
                inner join hab_pro_fam_pro_ase t6 on t6.pro_fam_id=t2.id
                inner join hab_propuesta_asesorias t7 on t7.id=t6.pro_ase_id                
                where t1.convocatoria_id=" . $convocatoria_id . "
                and t7.deleted_at is null
                and t2.tipo_propuesta_id=" . TipoPropuesta::MOD_PIC;
        $res = DB::select($sql);
        $data['asesorias'] = $res[0]->num_asesorias;
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }


    public function getDetalleSolucionOptions($solucion_id)
    {
        $res = DetalleSolucion::select('id as value', 'detalle_solucion as text')->where('solucion_id', $solucion_id)->get();
        return response()->json([
            'type' => 'success',
            'data' => $res
        ], 200);
    }

    public function getPicbyConvocatorias($convocatoria_id)
    {
        //soluciones
        $sql = "
            select 
            distinct(t1.descripcion) as solucion, 
            t6.nom_benef as nombre_beneficiario, 
            t1.id as solucion_id,
            t4.problematica_social,
            0 as problematica_constructiva,
            0 as intervenir,
            DBMS_LOB.substr(t4.descripcion,3000) as descripcion,
            DBMS_LOB.substr(t1.configuracion,3000) as solucion_configuracion,
            monto_aporte_total,
            monto_aporte_mds,
            monto_aporte_local,
            monto_aporte_otros,
            t4.id as propuesta_solucion_id,
            be.estado as bit_estado,
            be.id as bit_estado_id,
            t4.propuesta_id,
            " . TipoEntidad::SOLUCION . "as tipo_entidad_id
            from hab_soluciones t1
            inner join hab_detalle_soluciones t2 on t2.solucion_id=t1.id
            inner join hab_pro_sol_det_sol t3 on t3.detalle_solucion_id=t2.id
            inner join hab_propuesta_soluciones t4 on t4.id=t3.propuesta_solucion_id
            inner join hab_propuesta_familias t5 on t5.id=t4.propuesta_id
            inner join hab_beneficiarios t6 on t6.id=t5.beneficiario_id
            inner join hab_convocatorias t7 on t7.id=t6.convocatoria_id
            left join hab_bit_estados be on t4.bit_estado_actual_id=be.id
            where t7.id={$convocatoria_id}
            and t4.deleted_at is null
            order by t1.id
        ";
        $soluciones = DB::select($sql);
        
        //failiares
        $filter_entidad = " AND t1.entidad = " . PropuestaAsesoria::ENTIDAD_FAMILIAR;
        $sql = "
        SELECT t1.id as propuesta_asesoria_id,
        t2.pro_fam_id as propuesta_id,
        TO_CHAR(t1.fecha_planificada,'YYYY-MM-DD') as fecha_planificada,
        TO_CHAR(t1.fecha_planificada,'HH24:MI') as hora_planificada,
        t1.objetivos,
        t1.descripcion as actividades,
        t1.entidad,
        t1.num_personas,
        t1.tipo_asesoria_id,
        t3.tipo_asesoria,
        t1.modalidad_asesoria_id,
        t4.modalidad_asesoria,
        be.estado as bit_estado,
        be.id as bit_estado_id,
        " . TipoEntidad::ASESORIA . " as tipo_entidad_id    
        FROM hab_propuesta_asesorias t1
        left join hab_bit_estados be on t1.bit_estado_actual_id=be.id
        INNER JOIN hab_tipo_asesorias t3 ON t3.id=t1.tipo_asesoria_id
        INNER JOIN hab_modalidad_asesorias t4 ON t4.id=t1.modalidad_asesoria_id
        INNER JOIN hab_pro_fam_pro_ase t2 ON t2.pro_ase_id=t1.id
        inner join hab_propuesta_familias t5 on t5.id=t2.pro_fam_id
        inner join hab_beneficiarios t6 on t6.id=t5.beneficiario_id
        inner join hab_convocatorias t7 on t7.id=t6.convocatoria_id
        where t7.id={$convocatoria_id}
        AND t1.deleted_at is null
        " . $filter_entidad . "
        ";
        $res = DB::select($sql);
        foreach ($res as $key => $row) {
            $res[$key]->tipo_asesoria_id = (int) $res[$key]->tipo_asesoria_id;
            $res[$key]->modalidad_asesoria_id = (int) $res[$key]->modalidad_asesoria_id;
            // Soluciones
            $sql = "
            SELECT t1.id,
            t1.descripcion as solucion,
            t1.configuracion
            FROM hab_soluciones t1
            INNER JOIN hab_pro_ase_sol t2 ON t2.solucion_id=t1.id
            WHERE t2.propuesta_asesoria_id=" . $row->propuesta_asesoria_id . "
            order by t1.id
            ";
            $res[$key]->soluciones = DB::select($sql);
            $res[$key]->solucion_id = [];
            foreach ($res[$key]->soluciones as $_row) {
                $res[$key]->solucion_id[] = $_row->id;
            }

            // Tematicas
            $sql = "
            SELECT t1.id,
            t1.tematica
            FROM hab_tematicas t1
            INNER JOIN hab_pro_ase_tem t2 ON t2.tematica_id=t1.id
            WHERE t2.propuesta_asesoria_id=" . $row->propuesta_asesoria_id . "
            order by t1.tematica
            ";
            $res[$key]->tematicas = DB::select($sql);
            $res[$key]->tematica_id = [];
            foreach ($res[$key]->tematicas as $_row) {
                $res[$key]->tematica_id[] = $_row->id;
            }
        }
        $asesorias_familiares = $res;

        //grupales

        $filter_entidad = " AND t1.entidad = " . PropuestaAsesoria::ENTIDAD_GRUPAL;
        $sql = "
        SELECT t1.id as propuesta_asesoria_id,
        t2.pro_fam_id as propuesta_id,
        TO_CHAR(t1.fecha_planificada,'YYYY-MM-DD') as fecha_planificada,
        TO_CHAR(t1.fecha_planificada,'HH24:MI') as hora_planificada,
        t1.objetivos,
        t1.descripcion as actividades,
        t1.entidad,
        t1.num_personas,
        t1.tipo_asesoria_id,
        t3.tipo_asesoria,
        t1.modalidad_asesoria_id,
        t4.modalidad_asesoria,
        be.estado as bit_estado,
        be.id as bit_estado_id,
        " . TipoEntidad::ASESORIA . " as tipo_entidad_id    
        FROM hab_propuesta_asesorias t1
        left join hab_bit_estados be on t1.bit_estado_actual_id=be.id
        INNER JOIN hab_tipo_asesorias t3 ON t3.id=t1.tipo_asesoria_id
        INNER JOIN hab_modalidad_asesorias t4 ON t4.id=t1.modalidad_asesoria_id
        INNER JOIN hab_pro_fam_pro_ase t2 ON t2.pro_ase_id=t1.id
        inner join hab_propuesta_familias t5 on t5.id=t2.pro_fam_id
        inner join hab_beneficiarios t6 on t6.id=t5.beneficiario_id
        inner join hab_convocatorias t7 on t7.id=t6.convocatoria_id
        where t7.id={$convocatoria_id}
        AND t1.deleted_at is null
        " . $filter_entidad . "
        ";
        $res = DB::select($sql);
        foreach ($res as $key => $row) {
            $res[$key]->tipo_asesoria_id = (int) $res[$key]->tipo_asesoria_id;
            $res[$key]->modalidad_asesoria_id = (int) $res[$key]->modalidad_asesoria_id;
            // Soluciones
            $sql = "
            SELECT t1.id,
            t1.descripcion as solucion,
            t1.configuracion
            FROM hab_soluciones t1
            INNER JOIN hab_pro_ase_sol t2 ON t2.solucion_id=t1.id
            WHERE t2.propuesta_asesoria_id=" . $row->propuesta_asesoria_id . "
            order by t1.id
            ";
            $res[$key]->soluciones = DB::select($sql);
            $res[$key]->solucion_id = [];
            foreach ($res[$key]->soluciones as $_row) {
                $res[$key]->solucion_id[] = $_row->id;
            }

            // Tematicas
            $sql = "
            SELECT t1.id,
            t1.tematica
            FROM hab_tematicas t1
            INNER JOIN hab_pro_ase_tem t2 ON t2.tematica_id=t1.id
            WHERE t2.propuesta_asesoria_id=" . $row->propuesta_asesoria_id . "
            order by t1.tematica
            ";
            $res[$key]->tematicas = DB::select($sql);
            $res[$key]->tematica_id = [];
            foreach ($res[$key]->tematicas as $_row) {
                $res[$key]->tematica_id[] = $_row->id;
            }
        }
        $asesorias_grupales = $res;
        
        $data = [
            'soluciones' => $soluciones,
            'asesorias_familiares' => $asesorias_familiares,
            'asesorias_grupales' => $asesorias_grupales,
            
        ];
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function getPic($beneficiario_id)
    {
        $beneficiario = Beneficiario::getById($beneficiario_id);
        $convocatoria = Convocatoria::where('id', $beneficiario->convocatoria_id)->first();
        $propuesta = PropuestaFamilia::getByBeneficiarioId($beneficiario->id, TipoPropuesta::PIC);
        $soluciones = [];
        $asesorias_familiares = [];
        $tipo_asesoria_options = [];
        $modalidad_asesoria_options = [];
        $tematica_options = [];
        if ($propuesta) {
            $soluciones = PropuestaSolucion::getByPropuestaId($propuesta->id);
            $asesorias_familiares = PropuestaAsesoria::getByPropuestaId($propuesta->id, PropuestaAsesoria::ENTIDAD_FAMILIAR);
            $tipo_asesoria_options = TipoAsesoria::getOptions();
            $modalidad_asesoria_options = [
                [
                    'text' => 'Presencial',
                    'value' => 1,
                ],
                [
                    'text' => 'Remoto',
                    'value' => 2,
                ]
            ];
            $tematica_options = Tematica::getOptions();
        }

        $convocatoria['nom_region'] = isset($convocatoria['comunas'][0]['nom_reg']) ? $convocatoria['comunas'][0]['nom_reg'] : '';

        $aux = array();
        foreach ($convocatoria['comunas'] as $comuna) {
            $aux[] = $comuna['nom_com'];
        }
        $convocatoria['nom_comuna'] = implode(', ', $aux);
        $estados = BitEstado::getConstantes();

        $data = [
            'beneficiario' => $beneficiario,
            'convocatoria' => $convocatoria,
            'propuesta' => $propuesta,
            'soluciones' => $soluciones,
            'asesorias_familiares' => $asesorias_familiares,
            'tipo_asesoria_options' => $tipo_asesoria_options,
            'modalidad_asesoria_options' => $modalidad_asesoria_options,
            'tematica_options' => $tematica_options,
            'estados' => $estados,
        ];
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function getModPic($beneficiario_id)
    {
        $beneficiario = Beneficiario::getById($beneficiario_id);
        $convocatoria = Convocatoria::where('id', $beneficiario->convocatoria_id)->first();
        $propuesta = PropuestaFamilia::getByBeneficiarioId($beneficiario->id, TipoPropuesta::MOD_PIC);
        $soluciones = [];
        $asesorias_familiares = [];
        $tipo_asesoria_options = [];
        $tematica_options = [];
        if ($propuesta) {
            $soluciones = PropuestaSolucion::getByPropuestaId($propuesta->id);
            $asesorias_familiares = PropuestaAsesoria::getByPropuestaId($propuesta->id, PropuestaAsesoria::ENTIDAD_FAMILIAR);
            $tipo_asesoria_options = TipoAsesoria::getOptions();
            $tematica_options = Tematica::getOptions();
        }

        $convocatoria['nom_region'] = isset($convocatoria['comunas'][0]['nom_reg']) ? $convocatoria['comunas'][0]['nom_reg'] : '';

        $aux = array();
        foreach ($convocatoria['comunas'] as $comuna) {
            $aux[] = $comuna['nom_com'];
        }
        $convocatoria['nom_comuna'] = implode(', ', $aux);
        $estados_convocatorias = [
                'CON_REGISTRADA' => BitEstado::CON_REGISTRADA, 
                'CON_REGISTRO_FAMILIAS' => BitEstado::CON_REGISTRO_FAMILIAS, 
                'CON_SELECCION_FAMILIAS' => BitEstado::CON_SELECCION_FAMILIAS, 
                'CON_DIAGNOSTICO' => BitEstado::CON_DIAGNOSTICO, 
                'CON_PROPUESTAS_TECNICAS' => BitEstado::CON_PROPUESTAS_TECNICAS, 
                'CON_PIC_APROBADO' => BitEstado::CON_PIC_APROBADO, 
                'CON_IMPLEMENTACION_PROPUESTAS_TECNICAS' => BitEstado::CON_IMPLEMENTACION_PROPUESTAS_TECNICAS, 
                'CON_CIERRE_TECNICO' => BitEstado::CON_CIERRE_TECNICO, 
                'CON_FINALIZADA' => BitEstado::CON_FINALIZADA, 
                ];
        $estados_soluciones = [
                ['label'=>'Solución no iniciada', 'value' => BitEstado::SOL_NO_INI], 
                ['label'=>'Solución desestimada', 'value' => BitEstado::SOL_DES], 
                ['label'=>'Solución en ejecución', 'value' => BitEstado::SOL_EN_EJE], 
                ['label'=>'Solicita recepción', 'value' => BitEstado::SOL_SOL_REC], 
                ['label'=>'Recepción rechazada', 'value' => BitEstado::SOL_REC_REC], 
                ['label'=>'Recepción aprobada', 'value' => BitEstado::SOL_REC_APR], 
                ['label'=>'Recepción Administrativa aprobada', 'value' => BitEstado::SOL_REC_APR_ADM], 
                ['label'=>'Recepción aprobada con observaciones', 'value' => BitEstado::SOL_REC_APR_OBS], 
                ['label'=>'Recepción aprobada - Subsanar', 'value' => BitEstado::SOL_REC_APR_SUB], 
                ];
        $estados_asesorias = [
                ['label'=>'Asesoría no iniciada', 'value' => BitEstado::ASE_NO_INI], 
                ['label'=>'Asesoría desestimada    ', 'value' => BitEstado::ASE_DES], 
                ['label'=>'Asesoría ejecutada', 'value' => BitEstado::ASE_EJE], 
                ];


        $data = [
            'beneficiario' => $beneficiario,
            'convocatoria' => $convocatoria,
            'propuesta' => $propuesta,
            'soluciones' => $soluciones,
            'asesorias_familiares' => $asesorias_familiares,
            'tipo_asesoria_options' => $tipo_asesoria_options,
            'modalidad_asesoria_options' => $modalidad_asesoria_options,
            'tematica_options' => $tematica_options,
            'estados_convocatorias' => $estados_convocatorias,
            'estados_soluciones' => $estados_soluciones,
            'estados_asesorias' => $estados_asesorias,
        ];
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function getDatosPropuestasByFamilias(Request $request)
    {
        $data = [];
        $beneficiarios = $request->beneficiarios;
        if (is_array($beneficiarios) && count($beneficiarios)) {
            $data['pic'] = PropuestaFamilia::getDatosPropuestaByFamilias($beneficiarios, TipoPropuesta::PIC);
            $data['mod_pic'] = PropuestaFamilia::getDatosPropuestaByFamilias($beneficiarios, TipoPropuesta::MOD_PIC);
        }
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function getAsesoriasFamiliares($beneficiario_id)
    {
        $res = PropuestaFamilia::where('beneficiario_id', $beneficiario_id)->first();
        return response()->json([
            'type' => 'success',
            'data' => $res
        ], 200);
    }

    public function getPropuestas($beneficiario_id)
    {
        $res = PropuestaFamilia::where('beneficiario_id', $beneficiario_id)->first();
        return response()->json([
            'type' => 'success',
            'data' => $res
        ], 200);
    }

    public function getSolucionOptions()
    {
        $res = Solucion::select('id as value', 'descripcion as text', 'configuracion')->get()->toArray();
        return response()->json([
            'type' => 'success',
            'data' => $res
        ], 200);
    }

    public function saveAsesoriaFamiliar(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $rules = [
                'propuesta_id' => 'required|integer',
                'tipo_asesoria_id' => 'required|integer',
                'modalidad_asesoria_id' => 'required|integer',
                'objetivos' => 'required',
                'actividades' => 'required',
                'solucion_id' => 'required|array',
                'tematica_id' => 'required|array',
                'fecha_planificada' => 'required|date',
                'hora_planificada' => 'required',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }

            $conv = Convocatoria::findOrFail($request->get('convocatoria_id'));
            $estados = [
                BitEstado::CON_DIAGNOSTICO,
                BitEstado::CON_PROPUESTAS_TECNICAS
            ];
            if (in_array($conv->bit_estado_actual_id, $estados)) {

                // Cantidad de beneficiarios en la convocatoria
                $benef_count = count(PropuestaSolucion::getByPropuestaId($request->get('propuesta_id')));
                $benef_count = $benef_count + count(PropuestaAsesoria::getByPropuestaId($request->get('propuesta_id')));


                if (is_null($request->propuesta_asesoria_id)) {
                    // Insertar
                    $pro_ase = new PropuestaAsesoria();
                } else {
                    // Editar
                    $pro_ase = PropuestaAsesoria::find($request->propuesta_asesoria_id);
                }
                $pro_ase->fecha_planificada = $fields['fecha_planificada'] . ' ' . $fields['hora_planificada'] . ':00';
                $pro_ase->entidad = PropuestaAsesoria::ENTIDAD_FAMILIAR;
                $pro_ase->objetivos = $fields['objetivos'];
                $pro_ase->descripcion = $fields['actividades'];
                $pro_ase->num_personas = 0;
                $pro_ase->tipo_asesoria_id = $fields['tipo_asesoria_id'];
                $pro_ase->modalidad_asesoria_id = $fields['modalidad_asesoria_id'];
                $pro_ase->save();

                $pro_ase->savePropuestaFamilia($fields['propuesta_id']);
                $pro_ase->saveSoluciones($fields['solucion_id']);
                $pro_ase->saveTematicas($fields['tematica_id']);

                // Agrega estado inicial
                if (is_null($request->propuesta_asesoria_id)) {
                    $pro_ase->cambiarEstado(BitEstado::estadoInicial(TipoEntidad::ASESORIA)->id, auth()->user()->id);
                }

                // TODO: Cambiar estado en bitácora a CON_PROPUESTAS_TECNICAS cuando:
                // 1 - La convocatoria se encuentre en estado CON_DIAGNOSTICO
                // 2 - Cuando sea la primera asesoria ingresada
                // 3 - Cuando sea la primera solucion ingresada
                // if (
                //     $conv->bit_estado_actual_id == BitEstado::CON_DIAGNOSTICO &&
                //     $benef_count == 0
                // ) {
                //     //$conv->cambiarEstado(BitEstado::CON_PROPUESTAS_TECNICAS, auth()->user()->id);
                // }

                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'code' => 200
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No es posible registrar una asesoría con el estado actual de la convocatoria.',
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function changeStatusSoluciones(Request $request)
    {
        $pro_sol = PropuestaSolucion::find($request->solucion_id);
        $pro_sol->cambiarEstado($request->status,  Auth::id(), $request->comentario);
    }

    
    public function changeStatusAsesorias(Request $request)
    {
        $pro_ase = PropuestaAsesoria::find($request->solucion_id);
        $pro_ase->cambiarEstado($request->status, Auth::id(), $request->comentario);
    }

    public function savePropuestaSolucion(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $fields['monto_aporte_mds'] = str_replace(['.', ','], ['', '.'], $fields['monto_aporte_mds']);
            $fields['monto_aporte_local'] = str_replace(['.', ','], ['', '.'], $fields['monto_aporte_local']);
            $fields['monto_aporte_otros'] = str_replace(['.', ','], ['', '.'], $fields['monto_aporte_otros']);
            $rules = [
                'propuesta_id' => 'required|integer',
                'solucion_id' => 'required|integer',
                'descripcion' => 'required|max:1000',
                'monto_aporte_mds' => 'required|numeric',
                'monto_aporte_local' => 'required|numeric',
                'monto_aporte_otros' => 'required|numeric',
                'detalle_soluciones' => 'required|array',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
                'detalle_soluciones.required' => 'Debe agregar al menos un detalle solución.'
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }


            $conv = Convocatoria::findOrFail($request->get('convocatoria_id'));
            $estados = [
                BitEstado::CON_DIAGNOSTICO,
                BitEstado::CON_PROPUESTAS_TECNICAS
            ];
            if (in_array($conv->bit_estado_actual_id, $estados)) {
                // Cantidad de beneficiarios en la convocatoria
                $benef_count = count(PropuestaSolucion::getByPropuestaId($request->get('propuesta_id')));
                $benef_count = $benef_count + count(PropuestaAsesoria::getByPropuestaId($request->get('propuesta_id')));

                // Validar Intervenir / Infactibilidades
                // $aux_detalle_soluciones = 1;
                $aux_monto_aporte = false;
                foreach ($request->detalle_soluciones as $row) {
                    if ($row['intervenir'] == true) {
                        $aux_monto_aporte = true;
                    }
                }

                if (is_null($request->propuesta_solucion_id)) {
                    // insert
                    $pro_sol = new PropuestaSolucion();
                    $pro_sol->propuesta_id = $fields['propuesta_id'];
                    $pro_sol->descripcion = $fields['descripcion'];
                    $pro_sol->problematica_social = 0;
                    if ($aux_monto_aporte) {
                        $pro_sol->monto_aporte_mds = $fields['monto_aporte_mds'];
                        $pro_sol->monto_aporte_local = $fields['monto_aporte_local'];
                        $pro_sol->monto_aporte_otros = $fields['monto_aporte_otros'];
                        $pro_sol->monto_aporte_total = $fields['monto_aporte_mds'] + $fields['monto_aporte_local'] + $fields['monto_aporte_otros'];
                    } else {
                        $pro_sol->monto_aporte_mds = 0;
                        $pro_sol->monto_aporte_local = 0;
                        $pro_sol->monto_aporte_otros = 0;
                        $pro_sol->monto_aporte_total = 0;
                    }
                    $pro_sol->save();
                    foreach ($request->detalle_soluciones as $row) {
                        $det_sol = new PropuestaSolucionDetalleSolucion();
                        $det_sol->propuesta_solucion_id = $pro_sol->id;
                        $det_sol->detalle_solucion_id = $row['detalle_solucion_id'];
                        $det_sol->problematica_constructiva = 0;
                        $det_sol->intervenir = $row['intervenir'];
                        $det_sol->inf_eco = $row['inf_eco'];
                        $det_sol->inf_tec = $row['inf_tec'];
                        $det_sol->inf_leg = $row['inf_leg'];
                        $det_sol->inf_otr = $row['inf_otr'];
                        $det_sol->save();
                    }
                } else {
                    // update
                    $pro_sol = PropuestaSolucion::find($request->propuesta_solucion_id);
                    if ($pro_sol) {
                        $pro_sol->descripcion = $fields['descripcion'];
                        if ($aux_monto_aporte) {
                            $pro_sol->monto_aporte_mds = $fields['monto_aporte_mds'];
                            $pro_sol->monto_aporte_local = $fields['monto_aporte_local'];
                            $pro_sol->monto_aporte_otros = $fields['monto_aporte_otros'];
                            $pro_sol->monto_aporte_total = $fields['monto_aporte_mds'] + $fields['monto_aporte_local'] + $fields['monto_aporte_otros'];
                        } else {
                            $pro_sol->monto_aporte_mds = 0;
                            $pro_sol->monto_aporte_local = 0;
                            $pro_sol->monto_aporte_otros = 0;
                            $pro_sol->monto_aporte_total = 0;
                        }

                        $pro_sol->save();

                        foreach ($request->detalle_soluciones as $row) {
                            if (!empty($row['id'])) {
                                $det_sol = PropuestaSolucionDetalleSolucion::find($row['id']);
                                if ($det_sol) {
                                    $det_sol->intervenir = $row['intervenir'];
                                    $det_sol->inf_eco = $row['inf_eco'];
                                    $det_sol->inf_tec = $row['inf_tec'];
                                    $det_sol->inf_leg = $row['inf_leg'];
                                    $det_sol->inf_otr = $row['inf_otr'];
                                    $det_sol->save();
                                }
                            } else {
                                $row['propuesta_solucion_id'] = $pro_sol->id;
                                $det_sol = new PropuestaSolucionDetalleSolucion($row);
                                $det_sol->save();
                            }
                        }
                    }
                }

                // Agrega estado inicial
                if (is_null($request->propuesta_solucion_id)) {
                    $pro_sol->cambiarEstado(BitEstado::estadoInicial(TipoEntidad::SOLUCION)->id, auth()->user()->id);
                }
    
                // TODO: Cambiar estado en bitácora a CON_PROPUESTAS_TECNICAS cuando:
                // 1 - La convocatoria se encuentre en estado CON_DIAGNOSTICO
                // 2 - Cuando sea la primera asesoria ingresada
                // 3 - Cuando sea la primera solucion ingresada
                // if (
                //     $conv->bit_estado_actual_id == BitEstado::CON_DIAGNOSTICO &&
                //     $benef_count == 0
                // ) {
                //     //$conv->cambiarEstado(BitEstado::CON_PROPUESTAS_TECNICAS, auth()->user()->id);
                // }

                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'code' => 200
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No es posible registrar una solución con el estado actual de la convocatoria.',
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function savePICFromDiagnostico($beneficiario_id)
    {
        DB::beginTransaction();

        // TODO: Guardar en propuesta_familias
        $pro = PropuestaFamilia::getLast($beneficiario_id);
        if (!$pro) {
            $pro = new PropuestaFamilia([
                'beneficiario_id' => $beneficiario_id,
                'tipo_propuesta_id' => TipoPropuesta::PIC,
                'estado_id' => Estado::NO_INICIADO,
                'visado' => 0,
            ]);
            $pro->save();
        }

        // TODO: Obtener beneficiario
        $ben = Beneficiario::find($beneficiario_id);

        // TODO: Obtener convocatoria
        $con = $ben->convocatoria;

        // TODO: Obtener respuestas de problematica constructiva (detalle_solucion)
        $sql = "
        select 
        t8.beneficiario_id, 
        t4.res_pro,
        t8.valor,
        t5.id as solucion_id,
        t5.descripcion as solucion,
        t7.id as detalle_solucion_id,
        t7.detalle_solucion
        from hab_form_diagnosticos t1
        inner join hab_form_seccions t2 on t2.formulario_id = t1.id
        inner join hab_sec_sol t3 on t3.seccion_id = t2.id
        inner join hab_preguntas t4 on t4.sec_sol_id = t3.id
        inner join hab_soluciones t5 on t5.id = t3.solucion_id 
        inner join hab_pre_det_sol t6 on t6.pregunta_id = t4.id
        inner join hab_detalle_soluciones t7 on t7.id = t6.detalle_solucion_id
        inner join hab_respuestas t8 on t8.pregunta_id = t4.id
        where t1.anio = '" . $con->anio . "'
        and t8.beneficiario_id = " . $ben->id . "
        and t4.res_pro = t8.valor
        ";

        $res = DB::select($sql);
        $data = [];
        $lis_det_sol = [];
        foreach ($res as $row) {
            $key = array_search($row->solucion_id, array_column($data, 'solucion_id'));
            if ($key === false) {
                $data[] = [
                    'propuesta_id' => $pro->id,
                    'solucion_id' => $row->solucion_id,
                    'solucion' => $row->solucion,
                    'problematica_social' => false,
                    'detalle_soluciones' => [
                        [
                            'detalle_solucion_id' => $row->detalle_solucion_id,
                            // 'detalle_solucion' => $row->detalle_solucion,
                            'problematica_constructiva' => true,
                            'origen' => PropuestaSolucionDetalleSolucion::ORIGEN_DIAGNOSTICO
                        ]
                    ]
                ];
            } else {
                $data[$key]['detalle_soluciones'][] = [
                    'detalle_solucion_id' => $row->detalle_solucion_id,
                    // 'detalle_solucion' => $row->detalle_solucion,
                    'problematica_constructiva' => true,
                    'origen' => PropuestaSolucionDetalleSolucion::ORIGEN_DIAGNOSTICO
                ];
            }
            $lis_det_sol[] = $row->detalle_solucion_id;
        }

        foreach ($data as $sol) {
            // TODO: Obtener pro_sol desde los detalle soluciones
            $det_sol_aux = [];
            foreach ($sol['detalle_soluciones'] as $det_sol) {
                $det_sol_aux[] = $det_sol['detalle_solucion_id'];
            }
            $sql = "select
            distinct(t1.id),t1.propuesta_id
            from hab_propuesta_soluciones t1
            inner join hab_pro_sol_det_sol t2 on t2.propuesta_solucion_id = t1.id
            and t1.propuesta_id=" . $sol['propuesta_id'] . "
            and t1.deleted_at is null
            and t2.detalle_solucion_id in (" . implode(',', $det_sol_aux) . ")";
            $res = DB::select($sql);

            if (count($res)) {
                $pro_sol = $res[0];
            } else {
                $pro_sol = new PropuestaSolucion([
                    'propuesta_id' => $pro->id,
                    'problematica_social' => 0,
                    'monto_aporte_total' => 0,
                    'monto_aporte_mds' => 0,
                    'monto_aporte_local' => 0,
                    'monto_aporte_otros' => 0,
                    'bit_estado_actual_id' => BitEstado::estadoInicial(TipoEntidad::SOLUCION)->id,
                ]);
                $pro_sol->save();
            }

            $aux = [];
            foreach ($sol['detalle_soluciones'] as $det_sol) {
                // TODO: Guardar detalle_solucion
                $pro_sol_det_sol = PropuestaSolucionDetalleSolucion::where('propuesta_solucion_id', $pro_sol->id)
                    ->where('detalle_solucion_id', $det_sol['detalle_solucion_id'])
                    ->first();
                if ($pro_sol_det_sol) {
                    $pro_sol_det_sol->problematica_constructiva = 1;
                } else {
                    $det_sol['propuesta_solucion_id'] = $pro_sol->id;
                    $pro_sol_det_sol = new PropuestaSolucionDetalleSolucion($det_sol);
                }
                $pro_sol_det_sol->save();
                $aux[] = $det_sol['detalle_solucion_id'];
            }

            $res = PropuestaSolucionDetalleSolucion::whereNotIn('detalle_solucion_id', $lis_det_sol)
                ->where('origen', PropuestaSolucionDetalleSolucion::ORIGEN_DIAGNOSTICO)
                ->delete();
        }
        DB::commit();

        // TODO: Evaluar problematica social
        DB::beginTransaction();
        $sql = "
        select distinct(t1.id), problematica_social, t3.solucion_id 
        from hab_propuesta_soluciones t1
        inner join hab_pro_sol_det_sol t2 on t2.propuesta_solucion_id=t1.id
        inner join hab_detalle_soluciones t3 on t3.id=t2.detalle_solucion_id
        where propuesta_id=" . $pro->id . "
        and t1.deleted_at is null
        ";
        $res = DB::select($sql);
        foreach ($res as $row) {
            // TODO: encontrar problematica social
            $sql = "select 
            t8.beneficiario_id, 
            t4.res_pro,
            t8.valor,
            t5.id as solucion_id,
            t5.descripcion as solucion
            from hab_form_diagnosticos t1
            inner join hab_form_seccions t2 on t2.formulario_id = t1.id
            inner join hab_sec_sol t3 on t3.seccion_id = t2.id
            inner join hab_preguntas t4 on t4.sec_sol_id = t3.id
            inner join hab_soluciones t5 on t5.id = t3.solucion_id 
            left join hab_pre_det_sol t6 on t6.pregunta_id = t4.id
            inner join hab_respuestas t8 on t8.pregunta_id = t4.id
            where t1.anio = '" . $con->anio . "'
            and t6.detalle_solucion_id is null
            and t8.beneficiario_id = " . $ben->id . "
            and t5.id=" . $row->solucion_id . "
            and t4.res_pro = t8.valor";
            $res_qry = DB::select($sql);
            $pro_sol = PropuestaSolucion::find($row->id);
            if ($pro_sol) {
                $pro_sol->problematica_social = ($res_qry) ? 1 : 0;
                $pro_sol->save();
            }
        }
        DB::commit();
    }

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

    private function getAsesoriasGrupales($convocatoria_id, $tipo_propuesta_id)
    {
        try {
            $convocatoria = Convocatoria::find($convocatoria_id);
            if (!$convocatoria) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No existe la convocatoria.',
                ]);
            }
            $convocatoria['nom_region'] = isset($convocatoria['comunas'][0]['nom_reg']) ? $convocatoria['comunas'][0]['nom_reg'] : '';
            $aux = array();
            foreach ($convocatoria['comunas'] as $comuna) {
                $aux[] = $comuna['nom_com'];
            }
            $convocatoria['nom_comuna'] = implode(', ', $aux);

            $tipo_asesorias = TipoAsesoria::getOptions();
            $modalidad_asesorias = ModalidadAsesoria::getOptions();
            $soluciones = Solucion::getOptions();
            $tematicas = Tematica::getOptions();
            $grupos = Grupo::getOptions();
            $familias = PropuestaFamilia::getOptions($convocatoria_id, $tipo_propuesta_id);
            $asesorias = PropuestaAsesoria::getByConvocatoria($convocatoria_id, $tipo_propuesta_id);
            $estados_convocatorias = [
                            'CON_REGISTRADA' => BitEstado::CON_REGISTRADA, 
                            'CON_REGISTRO_FAMILIAS' => BitEstado::CON_REGISTRO_FAMILIAS, 
                            'CON_SELECCION_FAMILIAS' => BitEstado::CON_SELECCION_FAMILIAS, 
                            'CON_DIAGNOSTICO' => BitEstado::CON_DIAGNOSTICO, 
                            'CON_PROPUESTAS_TECNICAS' => BitEstado::CON_PROPUESTAS_TECNICAS, 
                            'CON_PIC_APROBADO' => BitEstado::CON_PIC_APROBADO, 
                            'CON_IMPLEMENTACION_PROPUESTAS_TECNICAS' => BitEstado::CON_IMPLEMENTACION_PROPUESTAS_TECNICAS, 
                            'CON_CIERRE_TECNICO' => BitEstado::CON_CIERRE_TECNICO, 
                            'CON_FINALIZADA' => BitEstado::CON_FINALIZADA, 
                            ];
            $estados_soluciones = [
                    ['label'=>'Solución no iniciada', 'value' => BitEstado::SOL_NO_INI], 
                    ['label'=>'Solución desestimada', 'value' => BitEstado::SOL_DES], 
                    ['label'=>'Solución en ejecución', 'value' => BitEstado::SOL_EN_EJE], 
                    ['label'=>'Solicita recepción', 'value' => BitEstado::SOL_SOL_REC], 
                    ['label'=>'Recepción rechazada', 'value' => BitEstado::SOL_REC_REC], 
                    ['label'=>'Recepción aprobada', 'value' => BitEstado::SOL_REC_APR], 
                    ['label'=>'Recepción Administrativa aprobada', 'value' => BitEstado::SOL_REC_APR_ADM], 
                    ['label'=>'Recepción aprobada con observaciones', 'value' => BitEstado::SOL_REC_APR_OBS], 
                    ['label'=>'Recepción aprobada - Subsanar', 'value' => BitEstado::SOL_REC_APR_SUB], 
                    ];
            $estados_asesorias = [
                    ['label'=>'Asesoría no iniciada', 'value' => BitEstado::ASE_NO_INI], 
                    ['label'=>'Asesoría desestimada    ', 'value' => BitEstado::ASE_DES], 
                    ['label'=>'Asesoría ejecutada', 'value' => BitEstado::ASE_EJE], 
                    ];


            foreach ($asesorias as $key => $item) {
                $asesorias[$key]->photos = $this->getPhotosAsesorias($item->propuesta_asesoria_id);
                $asesorias[$key]->comentario = PropuestaAsesoriaComentario::select([
                    'hab_pro_ase_comentarios.comentario',
                    DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
                    DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
                    'hab_users.nombre as user_nombre'
                ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
                    ->where('pro_ase_id', $item->propuesta_asesoria_id)
                    ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
                    ->first();
            }

            $costos = DB::select("
            select t1.*,t2.item as plan_cuenta_item 
            from hab_costo_asesorias t1
            inner join hab_plan_cuenta_items t2 on t2.id=t1.plan_cuenta_item_id
            where t1.convocatoria_id=" . $convocatoria_id . " 
            and tipo_propuesta_id=" . $tipo_propuesta_id . "
            order by t2.item
            ");

            $grupos_etarios = DB::select("
            select 
            count(case when t1.edad between 0 and 3 then 1 end) n_0_3,
            count(case when t1.edad between 4 and 12 then 1 end) n_4_12,
            count(case when t1.edad between 13 and 59 then 1 end) a_13_59,
            count(case when t1.edad>=60 then 1 end) a_60,
            count(1) total
            from hab_grupo_familiares t1 
            inner join hab_beneficiarios t2 on t2.id=t1.beneficiario_id
            and t2.convocatoria_id=" . $convocatoria_id . "
            and t1.visible=1
            ");
            $data = [
                'convocatoria' => $convocatoria,
                'familias' => $grupos_etarios[0],
                'asesorias' => $asesorias,
                'costos' => $costos,
                'estados_convocatorias' => $estados_convocatorias,
                'estados_soluciones' => $estados_soluciones,
                'estados_asesorias' => $estados_asesorias,
                'options' => [
                    'tipo_asesorias' => $tipo_asesorias,
                    'modalidad_asesorias' => $modalidad_asesorias,
                    'soluciones' => $soluciones,
                    'tematicas' => $tematicas,
                    'familias' => $familias,
                    'grupos' => $grupos,
                ]
            ];
            $response = [
                'message' => '',
                'type' => 'success',
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Error al intentar consultar las participaciones en convocatorias previas de Habitabilidad.',
                'type' => 'error',
            ], 200);
        }
    }

    public function getAsesoriasGrupalesPic($convocatoria_id)
    {
        return $this->getAsesoriasGrupales($convocatoria_id, TipoPropuesta::PIC);
    }
    public function getAsesoriasGrupalesModPic($convocatoria_id)
    {
        return $this->getAsesoriasGrupales($convocatoria_id, TipoPropuesta::MOD_PIC);
    }

    public function saveAsesoriaGrupal(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $rules = [
                'tipo_asesoria_id' => 'required|integer',
                'modalidad_asesoria_id' => 'required|integer',
                'grupo_id' => 'required|integer',
                'solucion_id' => 'required|array',
                'tematica_id' => 'required|array',
                'num_personas' => 'required|integer',
                'actividades' => 'required',
                'propuesta_familia_id' => 'required|array',
                'fecha_planificada' => 'required|date',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }
            $conv = Convocatoria::findOrFail($request->get('convocatoria_id'));
            $estados = [
                BitEstado::CON_DIAGNOSTICO,
                BitEstado::CON_PROPUESTAS_TECNICAS
            ];
            if (in_array($conv->bit_estado_actual_id, $estados)) {
            //if (1 == 1) {
                // Cantidad de beneficiarios en la convocatoria
                // $benef_count = count(PropuestaSolucion::getByPropuestaId($request->get('propuesta_id')));
                // $benef_count = $benef_count + count(PropuestaAsesoria::getByPropuestaId($request->get('propuesta_id')));


                if (is_null($request->propuesta_asesoria_id)) {
                    // Insertar
                    $pro_ase = new PropuestaAsesoria();
                } else {
                    // Editar
                    $pro_ase = PropuestaAsesoria::find($request->propuesta_asesoria_id);
                }
                $pro_ase->fecha_planificada = $fields['fecha_planificada'];
                $pro_ase->entidad = PropuestaAsesoria::ENTIDAD_GRUPAL;
                $pro_ase->num_personas = $fields['num_personas'];
                $pro_ase->tipo_asesoria_id = $fields['tipo_asesoria_id'];
                $pro_ase->modalidad_asesoria_id = $fields['modalidad_asesoria_id'];
                $pro_ase->grupo_id = $fields['grupo_id'];
                $pro_ase->descripcion = $fields['actividades'];
                $pro_ase->save();


                $pro_ase->savePropuestaFamilia($fields['propuesta_familia_id']);

                $pro_ase->saveSoluciones($fields['solucion_id']);
                $pro_ase->saveTematicas($fields['tematica_id']);

                // Agrega estado inicial
                if (is_null($request->propuesta_asesoria_id)) {
                    $pro_ase->cambiarEstado(BitEstado::estadoInicial(TipoEntidad::ASESORIA)->id, auth()->user()->id);
                }
                
                // TODO: Cambiar estado en bitácora a CON_PROPUESTAS_TECNICAS cuando:
                // 1 - La convocatoria se encuentre en estado CON_DIAGNOSTICO
                // 2 - Cuando sea la primera asesoria ingresada
                // 3 - Cuando sea la primera solucion ingresada
                // if (
                //     $conv->bit_estado_actual_id == BitEstado::CON_DIAGNOSTICO &&
                //     $benef_count == 0
                // ) {
                //     //$conv->cambiarEstado(BitEstado::CON_PROPUESTAS_TECNICAS, auth()->user()->id);
                // }

                DB::commit();
                return response()->json([
                    'type' => 'success',
                    'code' => 200
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No es posible registrar una asesoría grupal con el estado actual de la convocatoria.',
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
                'e'=>$e
            ], 200);
        }
    }

    public function dropAsesoriaGrupal(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $rules = [
                // 'propuesta_id' => 'required|integer',
                'propuesta_asesoria_id' => 'required|integer',
            ];
            $v = Validator::make($fields, $rules);
            if ($v->fails()) {
                return response()->json([
                    "code" => 200,
                    "message" => $v->errors()->first(),
                    "type" => 'error',
                ]);
            }

            // //TODO: Eliminar en hab_pro_fam_pro_ase
            // DB::table('hab_pro_fam_pro_ase')
            //     // ->where('pro_fam_id', $fields['propuesta_id'])
            //     ->where('pro_ase_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            // //TODO: Eliminar en hab_pro_ase_sol
            // DB::table('hab_pro_ase_sol')
            //     ->where('propuesta_asesoria_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            // //TODO: Eliminar en hab_pro_ase_tem
            // DB::table('hab_pro_ase_tem')
            //     ->where('propuesta_asesoria_id', $fields['propuesta_asesoria_id'])
            //     ->delete();

            //TODO: Eliminar propuesta_asesorias
            $pro_ase = PropuestaAsesoria::find($fields['propuesta_asesoria_id']);
            $pro_ase->delete();

            DB::commit();
            return response()->json([
                'type' => 'success',
                'code' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function saveCostoAsesoria(Request $request)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all();
            $rules = [
                'id' => 'required|integer',
                'monto_aporte_mds' => 'required|numeric',
                'monto_aporte_local' => 'required|numeric',
                'monto_aporte_otros' => 'required|numeric',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }


            // Editar
            $cos_ase = CostoAsesoria::find($request->id);
            if ($cos_ase) {
                $conv = Convocatoria::findOrFail($request->get('convocatoria_id'));
                $estados = [
                    BitEstado::CON_DIAGNOSTICO,
                    BitEstado::CON_PROPUESTAS_TECNICAS
                ];
                if (in_array($conv->bit_estado_actual_id, $estados)) {

                    $cos_ase->monto_aporte_mds = $fields['monto_aporte_mds'];
                    $cos_ase->monto_aporte_local = $fields['monto_aporte_local'];
                    $cos_ase->monto_aporte_otros = $fields['monto_aporte_otros'];
                    $cos_ase->monto_aporte_total = $fields['monto_aporte_mds'] + $fields['monto_aporte_local'] + $fields['monto_aporte_otros'];
                    $cos_ase->save();
                    DB::commit();
                    return response()->json([
                        'type' => 'success',
                        'code' => 200
                    ], 200);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'message' => 'No es posible registrar un costo de asesoría grupal con el estado actual de la convocatoria.',
                    ], 200);
                }
            } else {
                return response()->json([
                    'type' => 'error',
                    'message' => 'Ha occurido un error al intentar guardar la información.',
                ], 200);
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function getCertificadoAprobacionPic($convocatoria_id)
    {

        $convocatoria = Convocatoria::find($convocatoria_id);
        $convocatoria->comuna = implode(', ', $convocatoria->comunas->map(function ($item) {
            return $item->nom_com;
        })->toArray());

        $registros = PropuestaFamilia::getCertificadoAprobacion($convocatoria_id, TipoPropuesta::PIC);

        if ($convocatoria) {
            $titulo = 'Certificado Aprobación PIC ' . $convocatoria->comuna . ' ' . $convocatoria->anio . '.pdf';
            $view = view('pdf.certificado_aprobacion_pic', compact('titulo', 'convocatoria', 'registros'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream($titulo);
        }
    }
    public function getCertificadoAprobacionModPic($convocatoria_id)
    {

        $convocatoria = Convocatoria::find($convocatoria_id);
        $convocatoria->comuna = implode(', ', $convocatoria->comunas->map(function ($item) {
            return $item->nom_com;
        })->toArray());

        $registros = PropuestaFamilia::getCertificadoAprobacion($convocatoria_id, TipoPropuesta::MOD_PIC);
        // $titulo = 'Certificado Aprobación Modificación PIC ' . $convocatoria->comuna . ' ' . $convocatoria->anio . '.pdf';

        // return  view('pdf.certificado_aprobacion_mod_pic', compact('titulo', 'convocatoria', 'registros'));
        if ($convocatoria) {
            $titulo = 'Certificado Aprobación Modificación PIC ' . $convocatoria->comuna . ' ' . $convocatoria->anio . '.pdf';
            $view = view('pdf.certificado_aprobacion_mod_pic', compact('titulo', 'convocatoria', 'registros'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream($titulo);
        }
    }
    public function getPhotosAsesorias($pro_ase_id)
    {
        $result = PhotoAsesoria::search(['pro_ase_id' => $pro_ase_id]);
        return $result->toArray();
    }
    public function getStatusEntidad($entidad_id)
    { 
        $bit = BitEstado::find($entidad_id);
        $arr = explode(',',$bit->bit_estado_id_post);
        for($i=0; $i<count($arr);$i++){
            $arr[$i] = (int) $arr[$i];
        }
        $arr[] = $bit->id;
        
        return response()->json([
            'type' => 'success',
            'data' => BitEstado::wherein('id', $arr)->orderby('orden','asc')->get()
        ], 200);

    }
    
}
