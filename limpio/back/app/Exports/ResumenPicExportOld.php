<?php

namespace App\Exports;


// use App\Beneficiario;
// use App\Convocatoria;
use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ResumenPicExportOld implements FromCollection, WithHeadings, WithMapping, WithCustomValueBinder, ShouldAutoSize, WithTitle
{

    /**
     * ResumenPicExport constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            // "N°",
            // "RUN Representante",
            // "Nombre Representante",
            // "Dirección",
            // "Programa Origen",
            // "Teléfono"
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            // $row->numero,
            // $row->rut_benef,
            // $row->nom_benef,
            // $row->direccion,
            // $row->nom_programa,
            // $row->telefono
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        // $query = Beneficiario::where([])
        // ->whereNull('motivo_cancelacion_id')
        // ->orderBy('numero');
        // return $query->get();
        return new Collection([]);
    }

    /**
     * Bind value to a cell.
     *
     * @param Cell $cell Cell to bind value to
     * @param mixed $value Value to bind in cell
     *
     * @return bool
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, DataType::TYPE_STRING);
        if ($cell->getRow() == 1) {
            $cell->getStyle()->getFont()->setBold(true);
        }
        return true;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return "resumen_pic";
    }
}
