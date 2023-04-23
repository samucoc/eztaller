<?php

namespace App\Exports;

use App\PropuestaFamilia;
use App\TipoPropuesta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ResumenPicExport implements FromView
{

    private $convocatoria_id;

    public function __construct($convocatoria_id)
    {
        $this->convocatoria_id = $convocatoria_id;
    }

    public function title(): string
    {
        // $anio = $this->convocatoria->anio;
        return 'resumen_pic';
    }

    public function view(): View
    {
        $vars = PropuestaFamilia::resumenPicExport($this->convocatoria_id, TipoPropuesta::PIC);
        return view('propuestas/resumen_pic', $vars);
    }
}
