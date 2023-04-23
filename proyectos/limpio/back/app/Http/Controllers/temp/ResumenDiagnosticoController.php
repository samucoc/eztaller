<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Convocatoria;
use App\Solucion;
use App\DiagnosticoFamilia;
use App\Exports\BeneficiariosExport;
use App\Exports\ResumenExport;
use App\Http\Requests\GetBeneficiariosRequest;
use App\MotivoCancelacion;
use App\PropuestaFamilia;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpFoundation\Response;

class ResumenDiagnosticoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $convocatoriaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByConvocatoria(Request $request)
    {
        $convocatoriaId = $request->all()[0];

        $convocatoriaDb = Convocatoria::where('id',$convocatoriaId)->get();
        
        $beneficiariosDb = Beneficiario::where([
            ['convocatoria_id', '=', $convocatoriaId],
            ['selected', '=', true]
        ])->get();

        foreach ($beneficiariosDb as $beneficiario) {

            $problem = NULL;
            $prob_array = array();
            $accio  = NULL;
            $accio_array  = array();
            
            $diagnostico = DiagnosticoFamilia::where('beneficiario_id', '=', $beneficiario->id)->first();

            $propuesta = PropuestaFamilia::where('beneficiario_id', '=', $beneficiario->id)->first();

            $Sql = "with Solc as 
                    (
                    select  hab_sec_sol.solucion_id, hab_sec_sol.id
                    from hab_sec_sol 
                    join hab_form_seccions on hab_form_seccions.id = hab_sec_sol.seccion_id 
                    where hab_form_seccions.descripcion like 'De acuerdo al documento Estándares Técnicos%'
                    order by 1
                    )
                    SELECT hab_soluciones.id  ,  hab_soluciones.descripcion as soluciones, decode (count(hab_respuestas.valor),0,null, 'X') RESPUESTA  --count (*)--DECODE (hab_respuestas.beneficiario_id,1,'X',NULL) RESPUESTA
                    from hab_soluciones
                    left join Solc ON ( hab_soluciones.id = Solc.solucion_id )
                    left join hab_preguntas ON ( Solc.id = hab_preguntas.sec_sol_id )
                    left join hab_respuestas ON ( hab_preguntas.id = hab_respuestas.pregunta_id  and  hab_preguntas.resp_tot_diag = hab_respuestas.valor and hab_respuestas.beneficiario_id = $beneficiario->id )
                    group by hab_soluciones.id ,  hab_soluciones.descripcion 
                    order by 1";
            
            $problematicas = DB::select($Sql);
            $contador_1=0;
                foreach ($problematicas as $items){
                    if($items->respuesta == 'X')
                        $contador_1 = $contador_1 + 1;
                }
            
            $Sql_1 = "with Solc as 
                        (
                        select  hab_sec_sol.solucion_id, hab_sec_sol.id
                        from hab_sec_sol 
                        join hab_form_seccions on hab_form_seccions.id = hab_sec_sol.seccion_id 
                        where hab_form_seccions.descripcion like 'ENTREVISTA FAMILIAR%'
                        order by 1
                        )
                        SELECT hab_soluciones.id  ,  hab_soluciones.descripcion as soluciones, decode (count(hab_respuestas.valor),0,null, 'X') RESPUESTA  --count (*)--DECODE (hab_respuestas.beneficiario_id,1,'X',NULL) RESPUESTA
                        from hab_soluciones
                        left join Solc ON ( hab_soluciones.id = Solc.solucion_id )
                        left join hab_preguntas ON ( Solc.id = hab_preguntas.sec_sol_id )
                        left join hab_respuestas ON ( hab_preguntas.id = hab_respuestas.pregunta_id  and  hab_preguntas.resp_tot_diag = hab_respuestas.valor and hab_respuestas.beneficiario_id = $beneficiario->id )
                        group by hab_soluciones.id ,  hab_soluciones.descripcion 
                        order by 1";
            
            $acciones = DB::select($Sql_1);
            $contador_2=0;
            
            foreach ($acciones as $items1){
                if($items1->respuesta == 'X')
                    $contador_2 = $contador_2 + 1;
            }
            
            $beneficiario->{'diagnostico'} = $diagnostico;
            $beneficiario->{'propuesta'} = $propuesta;
            $beneficiario->{'problematicas'} = $problematicas;
            $beneficiario->{'problematicas_count'} = $contador_1;
            $beneficiario->{'acciones'} = $acciones;
            $beneficiario->{'acciones_count'} = $contador_2;

            // calculos de hacinamiento

            $Sql_H_1 = "SELECT COUNT(*) as total_familia 
                        FROM hab_grupo_familiares 
                        WHERE beneficiario_id = $beneficiario->id AND visible = 1";
            $cant_pers_activas = DB::select($Sql_H_1);
            $beneficiario->{'cant_pers_activas'} = $cant_pers_activas;

            $Sql_H_2 = "SELECT num_recinto , count(*) as cantidad
                        FROM hab_grupo_familiares
                        WHERE beneficiario_id = $beneficiario->id AND visible = 1
                        GROUP BY num_recinto";
            $total_recintos = count(DB::select($Sql_H_2));
            $beneficiario->{'total_recintos'} = $total_recintos;

            $beneficiario->{'hacinamiento_familia'} = ( $contador_1 / $total_recintos );

            $Sql_H_3 = "SELECT 'Nº niñ@s de 1 a 3 años' as rango, COUNT (EDAD) as cantidad
                        FROM hab_grupo_familiares
                        WHERE EDAD BETWEEN 1 AND 3
                        AND VISIBLE=1
                        --AND CONVOCATORIA_ID=**
                        UNION
                        SELECT 'Nº niñ@s de 4 a 12 años', COUNT (EDAD) 
                        FROM hab_grupo_familiares
                        WHERE EDAD BETWEEN 4 AND 12
                        AND VISIBLE=1
                        --AND CONVOCATORIA_ID=**
                        UNION
                        SELECT 'Nº personas entre 13 y 59 años', COUNT (EDAD) 
                        FROM hab_grupo_familiares
                        WHERE EDAD BETWEEN 13 AND 59
                        AND VISIBLE=1
                        --AND CONVOCATORIA_ID=**
                        UNION
                        SELECT 'Nº personas mayores a 60 años', COUNT (EDAD) 
                        FROM hab_grupo_familiares
                        WHERE EDAD >=60
                        AND VISIBLE=1
                        --AND CONVOCATORIA_ID=**
                        ORDER BY 1";

            $hacinamiento = DB::select($Sql_H_3);
            $beneficiario->{'hacinamiento'} = $hacinamiento;
            
            $beneficiarios[] = $beneficiario;
        }
       
        return response()->json([
            "message" => '',
            "type" => 'success',
            "familias" => $beneficiarios,
            "convocatoria" => $convocatoriaDb
        ]);
    }
    /**
     * Devuelve un Excel de las familias dada una convocatoria
     * @param Excel $excel
     * @param $convocatoriaId
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Excel $excel, $convocatoriaId)
    { 
        $convocatoria = Convocatoria::find($convocatoriaId);
        if (!$convocatoria) {
            return response()->json([
                'message' => 'No existe la convocatoria.',
            ], Response::HTTP_NOT_FOUND);
        }
 
        $export = new ResumenExport($convocatoria);
        return $excel->download($export, $export->title() . '.xlsx');
    }

    /**
     * Devuelve un PDF de las familias dada una convocatoria
     * @param $convocatoriaId
     * @return mixed
     */
    public function print($convocatoriaId)
    {
        $convocatoria = Convocatoria::find($convocatoriaId);
        if (!$convocatoria) {
            return response()->json([
                'message' => 'No existe la convocatoria.',
            ], Response::HTTP_NOT_FOUND);
        }

        $beneficiariosDb = Beneficiario::where([
            ['convocatoria_id', '=', $convocatoria->id],
            ['selected', '=', true],
        ])->whereNull('motivo_cancelacion_id')
            ->get();
        foreach ($beneficiariosDb as $beneficiario) {
            $problem = NULL;
            $prob_array = array();
            $accio  = NULL;
            $accio_array  = array();

            $problematicas = Solucion::SELECT('hab_soluciones.descripcion as soluciones')
                                        ->distinct()
                                        ->join('hab_sec_sol', 'hab_soluciones.id', '=', 'hab_sec_sol.solucion_id')
                                        ->join('hab_preguntas', 'hab_sec_sol.id', '=', 'hab_preguntas.sec_sol_id')
                                        ->join('hab_respuestas', function ($join) {
                                            $join->on('hab_preguntas.id', '=', 'hab_respuestas.pregunta_id')
                                                 ->on('hab_preguntas.resp_tot_diag', '=', 'hab_respuestas.valor');
                                            })
                                        ->where('hab_sec_sol.seccion_id','=', 
                                        DB::table('hab_form_seccions')->where('descripcion','like', 'De acuerdo al documento Estándares Técnicos%')->value('id'))
                                        ->where('hab_respuestas.beneficiario_id','=', $beneficiario->id)->get();

            $cantidad_prob = count($problematicas);
            $beneficiario->problematicas = $problematicas;
            $beneficiario->count_prob = $cantidad_prob;

            $acciones = Solucion::SELECT('hab_soluciones.descripcion as soluciones')
                                        ->distinct()
                                        ->join('hab_sec_sol', 'hab_soluciones.id', '=', 'hab_sec_sol.solucion_id')
                                        ->join('hab_preguntas', 'hab_sec_sol.id', '=', 'hab_preguntas.sec_sol_id')
                                        ->join('hab_respuestas', function ($join) {
                                            $join->on('hab_preguntas.id', '=', 'hab_respuestas.pregunta_id')
                                                ->on('hab_preguntas.resp_tot_diag', '=', 'hab_respuestas.valor');
                                            })
                                        ->where('hab_sec_sol.seccion_id','=', 
                                        DB::table('hab_form_seccions')->where('descripcion','like', 'ENTREVISTA FAMILIAR%')->value('id'))
                                        ->where('hab_respuestas.beneficiario_id','=', $beneficiario->id)->get();
            
            $beneficiario->acciones = $acciones;

             // calculos de hacinamiento

             $Sql_H_1 = "SELECT * FROM hab_grupo_familiares WHERE beneficiario_id = $beneficiario->id AND visible = 1";
             $cant_pers_activas = count(DB::select($Sql_H_1));
             $beneficiario->{'cant_pers_activas'} = $cant_pers_activas;

             $Sql_H_2 = "SELECT num_recinto , count(*) as cantidad
                        FROM hab_grupo_familiares
                        WHERE beneficiario_id = $beneficiario->id AND visible = 1
                        GROUP BY num_recinto";
            $total_recintos = count(DB::select($Sql_H_2));
            $beneficiario->{'total_recintos'} = $total_recintos;

            $beneficiario->{'hacinamiento_familia'} = ( $cant_pers_activas / $total_recintos );
 
             $Sql_H_3 = "SELECT 'Nº niñ@s de 1 a 3 años' as rango, COUNT (EDAD) as cantidad
                            FROM hab_grupo_familiares
                            WHERE EDAD BETWEEN 1 AND 3
                            AND VISIBLE=1
                            --AND CONVOCATORIA_ID=**
                            UNION
                            SELECT 'Nº niñ@s de 4 a 12 años', COUNT (EDAD) 
                            FROM hab_grupo_familiares
                            WHERE EDAD BETWEEN 4 AND 12
                            AND VISIBLE=1
                            --AND CONVOCATORIA_ID=**
                            UNION
                            SELECT 'Nº personas entre 13 y 59 años', COUNT (EDAD) 
                            FROM hab_grupo_familiares
                            WHERE EDAD BETWEEN 13 AND 59
                            AND VISIBLE=1
                            --AND CONVOCATORIA_ID=**
                            UNION
                            SELECT 'Nº personas mayores a 60 años', COUNT (EDAD) 
                            FROM hab_grupo_familiares
                            WHERE EDAD >=60
                            AND VISIBLE=1
                            --AND CONVOCATORIA_ID=**
                            ORDER BY 1";

             $hacinamiento = DB::select($Sql_H_3);
             $beneficiario->{'hacinamiento'} = $hacinamiento;

            $beneficiarios[] = $beneficiario;
        }

        $anio = $convocatoria->anio;
        $title = "Convocatoria $anio";

        $nombresComunas = [];
        foreach ($convocatoria->comunas as $comuna)
            $nombresComunas[] = $comuna->nombre;

        $pdf = PDF::loadView('resumen_diagnostico', [
            'title' => $title,
            'convocatoria' => $convocatoria,
            'beneficiarios' => $beneficiarios,
            'comunas' => implode(", ", array_map(function ($comuna) {
                return $comuna['nom_com'];
            }, $convocatoria->comunas->toArray()))
        ])->setPaper('a4', 'landscape');

        return $pdf->download("$title.pdf");
    }
    /**
     * Devuelve un PDF de las familias dada una convocatoria
     * @param $convocatoriaId
     * @return mixed
     */
    public function implode_key($glue, $arr, $key){
        $arr2 = array();
        foreach( $arr as $f ){
            if(!isset( $f[$key] )) continue;
            $arr2[] = $f[$key];
        }
        return implode($glue, $arr2);
    }
}
