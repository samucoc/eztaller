<?php

namespace App\Exports;

use App\Convocatoria;
use App\Beneficiario;
use App\Const_Global_Diag;
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

class ReportLeadsExport implements FromCollection, WithTitle, WithMapping, WithHeadings, ShouldAutoSize, ShouldQueue
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
            $transaction->nom_programa,
            $transaction->count_row,
        ];
    }
    /**
     * @return Builder
     */ 
    public function headings(): array
    {
        return [
            'Programa de  origen',
            'N° Familias',
        ];
    }
    /**
     * @return Collection
     */
    public function collection()
    {
       $query = DB::table("hab_beneficiarios")
                ->select(DB::raw("COUNT(nom_programa) as count_row"),'nom_programa')
                ->join('hab_diagnostico_familias', 'hab_diagnostico_familias.beneficiario_id', '=', 'hab_beneficiarios.id')
                ->where([ ['convocatoria_id', '=', $this->convocatoria->id], ['selected', '=', true] ])
                ->where([ ['hab_diagnostico_familias.estado_id','!=', Const_Global_Diag::NO_INICIADO], ['hab_diagnostico_familias.estado_id','!=', Const_Global_Diag::FALLIDO] ])
	            ->groupBy('nom_programa');

        return $query->get();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $anio = $this->convocatoria->anio;
        return "RESUMEN POR PROGRAMA DE ORIGEN";
    }
}
