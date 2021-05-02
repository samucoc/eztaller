<?php

namespace App\Exports;

use App\Convocatoria;
use App\Beneficiario;
use App\DiagnosticoFamilia;
use App\PropuestaFamilia;
use App\Solucion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\Queue\ShouldQueue;


class ReportGeneralExport implements FromCollection, WithTitle, WithMapping, WithHeadings, ShouldAutoSize, ShouldQueue
{
    private $convocatoria;

    public function __construct(Convocatoria $convocatoria)
    {
        $this->convocatoria = $convocatoria;
    }
    /**
     * @return Builder
     */
    public function map($transaction): array
    {
        return [
            $transaction->numero,
            $transaction->rut_benef,
            $transaction->nom_benef,
            $transaction->direccion,
            $transaction->nom_programa,
            $transaction->problematicas[0]->respuesta,
            $transaction->problematicas[1]->respuesta,
            $transaction->problematicas[2]->respuesta,
            $transaction->problematicas[3]->respuesta,
            $transaction->problematicas[4]->respuesta,
            $transaction->problematicas[5]->respuesta,
            $transaction->problematicas[6]->respuesta,
            $transaction->problematicas[7]->respuesta,
            $transaction->problematicas[8]->respuesta,
            $transaction->problematicas[9]->respuesta,
            $transaction->problematicas[10]->respuesta,
            $transaction->problematicas[11]->respuesta,
            $transaction->problematicas[12]->respuesta,
            $transaction->problematicas[13]->respuesta,
            $transaction->count_prob,
            $transaction->acciones[0]->respuesta,
            $transaction->acciones[1]->respuesta,
            $transaction->acciones[2]->respuesta,
            $transaction->acciones[3]->respuesta,
            $transaction->acciones[4]->respuesta,
            $transaction->acciones[5]->respuesta,
            $transaction->acciones[6]->respuesta,
            $transaction->acciones[7]->respuesta,
            $transaction->acciones[8]->respuesta,
            $transaction->acciones[9]->respuesta,
            $transaction->acciones[10]->respuesta,
            $transaction->acciones[11]->respuesta,
            $transaction->acciones[12]->respuesta,
            $transaction->acciones[13]->respuesta,
        ];
    }
    /**
     * @return Builder
     */ 
    public function headings(): array
    {
        return [
            'N°',
            'RUN  BENEFICIARIO/A',
            'NOMBRE  BENEFICIARIO/A',
            'DIRECCIÓN',
            'PROGRAMA  ORIGEN',
            'Sb - Agua',
            'Sb - Excretas',
            'Sb - Energia',
            'Vv - Reparacion',
            'Vv - Recinto',
            'Vv - Productivo',
            'Vv - Accesibilidad I.',
            'Eq - Camas',
            'Eq - Cocina',
            'Eq - Calefaccion',
            'Eq - Mobiliario',
            'Et - Ambiente S.',
            'Et - Accesos E.',
            'Et - Areas V.',
            'N° DE PROBLEMÁTICAS  POR FAMILIA',
            'Sb - Agua',
            'Sb - Excretas',
            'Sb - Energia',
            'Vv - Reparacion',
            'Vv - Recinto',
            'Vv - Productivo',
            'Vv - Accesibilidad I.',
            'Eq - Camas',
            'Eq - Cocina',
            'Eq - Calefaccion',
            'Eq - Mobiliario',
            'Et - Ambiente S.',
            'Et - Accesos E.',
            'Et - Areas V.',
        ];
    }

     /**
     * @return Collection
     */
    public function collection()
    {
        $beneficiariosDb = Beneficiario::where([
            ['convocatoria_id', '=', $this->convocatoria->id],
            ['selected', '=', true],
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
            $valor = count($problematicas);
            $contador_1=0;
                foreach ($problematicas as $items){
                    if($items->respuesta == 'X')
                        $contador_1 = $contador_1 + 1;
                }
            $cantidad_prob = $contador_1;
                           
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
            $cantidad_acc = $contador_2;

            $beneficiario->{'diagnostico'} = $diagnostico;
            $beneficiario->{'propuesta'} = $propuesta;
            $beneficiario->{'problematicas'} = $problematicas;
           
            $beneficiario->{'count_prob'} = $cantidad_prob;
            $beneficiario->{'acciones'} = $acciones;
            $beneficiario->{'count_acc'} = $cantidad_acc;

            $beneficiarios[] = $beneficiario;
        }
        return collect($beneficiarios);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "REPORTE RESUMEN DIAGNOSTICO";
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