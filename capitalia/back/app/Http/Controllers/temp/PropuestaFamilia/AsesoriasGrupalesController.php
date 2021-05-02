<?php

namespace App\Http\Controllers\PropuestaFamilia;

use App\Grupo;
use App\Http\Controllers\Controller;
use App\PropuestaAsesoria;
use App\PropuestaFamilia;
use App\Solucion;
use App\Tematica;
use App\TipoAsesoria;
use App\BitEstado;
use App\TipoPropuesta;
use App\Beneficiario;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AsesoriasGrupalesController extends Controller
{

    public function get($convocatoria_id)
    {
        try {
            if (!is_numeric($convocatoria_id)) {
                throw new Exception("error", 1);
            }
            $items = PropuestaAsesoria::getByConvocatoria($convocatoria_id, TipoPropuesta::PIC);
            //         $estados_convocatorias = [
            //                         'CON_REGISTRADA' => BitEstado::CON_REGISTRADA, 
            //                         'CON_REGISTRO_FAMILIAS' => BitEstado::CON_REGISTRO_FAMILIAS, 
            //                         'CON_SELECCION_FAMILIAS' => BitEstado::CON_SELECCION_FAMILIAS, 
            //                         'CON_DIAGNOSTICO' => BitEstado::CON_DIAGNOSTICO, 
            //                         'CON_PROPUESTAS_TECNICAS' => BitEstado::CON_PROPUESTAS_TECNICAS, 
            //                         'CON_PIC_APROBADO' => BitEstado::CON_PIC_APROBADO, 
            //                         'CON_IMPLEMENTACION_PROPUESTAS_TECNICAS' => BitEstado::CON_IMPLEMENTACION_PROPUESTAS_TECNICAS, 
            //                         'CON_CIERRE_TECNICO' => BitEstado::CON_CIERRE_TECNICO, 
            //                         'CON_FINALIZADA' => BitEstado::CON_FINALIZADA, 
            //                         ];

            //         foreach ($asesorias as $key => $item) {
            //             $asesorias[$key]->photos = $this->getPhotosAsesorias($item->propuesta_asesoria_id);
            //             $asesorias[$key]->comentario = PropuestaAsesoriaComentario::select([
            //                 'hab_pro_ase_comentarios.comentario',
            //                 DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
            //                 DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
            //                 'hab_users.nombre as user_nombre'
            //             ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
            //                 ->where('pro_ase_id', $item->propuesta_asesoria_id)
            //                 ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
            //                 ->first();
            //         }

            return response()->json([
                'type' => 'success',
                'message' => 'ok',
                'data' => $items
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
            ], Response::HTTP_OK);
        }
    }

    // {
    //     try {
    //         $convocatoria = Convocatoria::find($convocatoria_id);
    //         if (!$convocatoria) {
    //             return response()->json([
    //                 'type' => 'error',
    //                 'message' => 'No existe la convocatoria.',
    //             ]);
    //         }
    //         $convocatoria['nom_region'] = isset($convocatoria['comunas'][0]['nom_reg']) ? $convocatoria['comunas'][0]['nom_reg'] : '';
    //         $aux = array();
    //         foreach ($convocatoria['comunas'] as $comuna) {
    //             $aux[] = $comuna['nom_com'];
    //         }
    //         $convocatoria['nom_comuna'] = implode(', ', $aux);

    //         $tipo_asesorias = TipoAsesoria::getOptions();
    //         $modalidad_asesorias = ModalidadAsesoria::getOptions();
    //         $soluciones = Solucion::getOptions();
    //         $tematicas = Tematica::getOptions();
    //         $grupos = Grupo::getOptions();
    //         $familias = PropuestaFamilia::getOptions($convocatoria_id, $tipo_propuesta_id);
    //         $asesorias = PropuestaAsesoria::getByConvocatoria($convocatoria_id, $tipo_propuesta_id);
    //         $estados_convocatorias = [
    //                         'CON_REGISTRADA' => BitEstado::CON_REGISTRADA, 
    //                         'CON_REGISTRO_FAMILIAS' => BitEstado::CON_REGISTRO_FAMILIAS, 
    //                         'CON_SELECCION_FAMILIAS' => BitEstado::CON_SELECCION_FAMILIAS, 
    //                         'CON_DIAGNOSTICO' => BitEstado::CON_DIAGNOSTICO, 
    //                         'CON_PROPUESTAS_TECNICAS' => BitEstado::CON_PROPUESTAS_TECNICAS, 
    //                         'CON_PIC_APROBADO' => BitEstado::CON_PIC_APROBADO, 
    //                         'CON_IMPLEMENTACION_PROPUESTAS_TECNICAS' => BitEstado::CON_IMPLEMENTACION_PROPUESTAS_TECNICAS, 
    //                         'CON_CIERRE_TECNICO' => BitEstado::CON_CIERRE_TECNICO, 
    //                         'CON_FINALIZADA' => BitEstado::CON_FINALIZADA, 
    //                         ];

    //         foreach ($asesorias as $key => $item) {
    //             $asesorias[$key]->photos = $this->getPhotosAsesorias($item->propuesta_asesoria_id);
    //             $asesorias[$key]->comentario = PropuestaAsesoriaComentario::select([
    //                 'hab_pro_ase_comentarios.comentario',
    //                 DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'YYYY-MM-DD') as fecha_creacion"),
    //                 DB::raw("TO_CHAR(hab_pro_ase_comentarios.created_at,'HH24:MI') as hora_creacion"),
    //                 'hab_users.nombre as user_nombre'
    //             ])->join('hab_users', 'hab_users.id', '=', 'hab_pro_ase_comentarios.user_id')
    //                 ->where('pro_ase_id', $item->propuesta_asesoria_id)
    //                 ->orderBy('hab_pro_ase_comentarios.created_at', 'desc')
    //                 ->first();
    //         }

    //         $costos = DB::select("
    //         select t1.*,t2.item as plan_cuenta_item 
    //         from hab_costo_asesorias t1
    //         inner join hab_plan_cuenta_items t2 on t2.id=t1.plan_cuenta_item_id
    //         where t1.convocatoria_id=" . $convocatoria_id . " 
    //         and tipo_propuesta_id=" . $tipo_propuesta_id . "
    //         order by t2.item
    //         ");

    //         $grupos_etarios = DB::select("
    //         select 
    //         count(case when t1.edad between 0 and 3 then 1 end) n_0_3,
    //         count(case when t1.edad between 4 and 12 then 1 end) n_4_12,
    //         count(case when t1.edad between 13 and 59 then 1 end) a_13_59,
    //         count(case when t1.edad>=60 then 1 end) a_60,
    //         count(1) total
    //         from hab_grupo_familiares t1 
    //         inner join hab_beneficiarios t2 on t2.id=t1.beneficiario_id
    //         and t2.convocatoria_id=" . $convocatoria_id . "
    //         and t1.visible=1
    //         ");
    //         $data = [
    //             'convocatoria' => $convocatoria,
    //             'familias' => $grupos_etarios[0],
    //             'asesorias' => $asesorias,
    //             'costos' => $costos,
    //             'estados_convocatorias' => $estados_convocatorias,
    //             'options' => [
    //                 'tipo_asesorias' => $tipo_asesorias,
    //                 'modalidad_asesorias' => $modalidad_asesorias,
    //                 'soluciones' => $soluciones,
    //                 'tematicas' => $tematicas,
    //                 'familias' => $familias,
    //                 'grupos' => $grupos,
    //             ]
    //         ];
    //         $response = [
    //             'message' => '',
    //             'type' => 'success',
    //             'data' => $data,
    //         ];
    //         return response()->json($response, 200);
    //     } catch (Exception $ex) {
    //         Log::error($ex);
    //         return response()->json([
    //             'message' => 'Error al intentar consultar las participaciones en convocatorias previas de Habitabilidad.',
    //             'type' => 'error',
    //         ], 200);
    //     }
    // }

    public function getOptions($convocatoria_id)
    {
        try {
            $estados_asesorias = [
                    ['label'=>'Asesoría no iniciada', 'value' => BitEstado::ASE_NO_INI], 
                    ['label'=>'Asesoría desestimada    ', 'value' => BitEstado::ASE_DES], 
                    ['label'=>'Asesoría ejecutada', 'value' => BitEstado::ASE_EJE], 
                    ];

           return response()->json([
                'type' => 'success',
                'data' => [
                    'tipos' => TipoAsesoria::getOptions(),
                    'modalidades' => [
                        [
                            'text' => 'Presencial',
                            'value' => 1,
                        ],
                        [
                            'text' => 'Remoto',
                            'value' => 2,
                        ]
                    ],
                    'grupos' => Grupo::getOptions(),
                    'soluciones' => Solucion::getOptions(),
                    'tematicas' => Tematica::getOptions(),
                    'estados_asesorias' => $estados_asesorias,
                    'beneficiarios' => Beneficiario::where('convocatoria_id', $convocatoria_id)->get(),
                    'familias' => PropuestaFamilia::getOptions($convocatoria_id, TipoPropuesta::PIC)
                ]
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'type' => 'error',
                'message' => 'Error al intentar obtener la información.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store()
    {
    }

    public function destroy()
    {
    }

    public function getByBeneficiarioId()
    {
    }
}
