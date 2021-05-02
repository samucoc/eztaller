<?php

namespace App\Exports;

use App\Convocatoria;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResumenExport implements WithMultipleSheets, WithTitle
{
    use Exportable;

    protected $convocatoria;
    
    public function __construct(Convocatoria $convocatoria)
    {
        $this->convocatoria = $convocatoria;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ReportGeneralExport($this->convocatoria);
        $sheets[] = new ReportLeadsExport($this->convocatoria);

        return $sheets;
    }
       /**
     * @return string
     */
    public function title(): string
    {
        $anio = $this->convocatoria->anio;
        return "Resumen_diagnostico $anio";
    }
}