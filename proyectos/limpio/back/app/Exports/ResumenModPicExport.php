<?php

namespace App\Exports;

use App\PropuestaFamilia;
use App\TipoPropuesta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ResumenModPicExport implements FromView
{

    private $convocatoria_id;

    public function __construct($convocatoria_id)
    {
        $this->convocatoria_id = $convocatoria_id;
    }

    public function title(): string
    {
        return 'resumen_mod_pic';
    }

    public function view(): View
    {
        $vars = PropuestaFamilia::resumenModPicExport($this->convocatoria_id, TipoPropuesta::MOD_PIC);
        return view('propuestas/resumen_pic', $vars);
    }
}
