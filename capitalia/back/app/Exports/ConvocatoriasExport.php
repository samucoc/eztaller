<?php


namespace App\Exports;

use App\Convocatoria;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ConvocatoriasExport implements FromCollection, WithHeadings, WithMapping, WithCustomValueBinder, ShouldAutoSize, WithTitle
{
    private $convocatorias;

    /**
     * BeneficiariosExport constructor.
     * @param Convocatoria $convocatoria
     */
    public function __construct($convocatorias)
    {
        $this->convocatorias = $convocatorias;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            "Año",
            "Región",
            "Comunas",
            "Estado convocatoria",
            "Observación",
            "Institución ejecutora",
            "RUT institución ejecutora ",
            "Dirección Institución ejecutora",
            "Télefono Institución ejecutora",
            "Fecha de transferencia",
            "Fecha de termino",
            "Estado SIGEC",
            "RUT encargado ejecutor",
            "Nombre encargado ejecutor",
            "Email encargado ejecutor",
            "RUT profesional constructivo",
            "Nombre profesional constructivo",
            "Email profesional constructivo",
            "Profesión profesional constructivo",
            "RUT profesional social",
            "Nombre profesional social",
            "Email profesional social",
            "Profesión profesional social",
            "RUT encargado programa SEREMI",
            "Nombnre encargado programa SEREMI",
            "Email encargado programa SEREMI",
            "RUT ATE FOSIS",
            "Nombre ATE FOSIS",
            "Email ATE FOSIS"
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
            $row->anio,
            $row->region,
            $row->comunas,
            $row->estado->nombre,
            $row->observacion,
            $row->ejecutor,
            $row->rut_ejecutor,
            $row->direccion_ejecutor,
            $row->fono_ejecutor,
            $row->fecha_transferencia,
            $row->fecha_termino,
            $row->estado_sigec,
            $row->rut_enc_ejec,
            $row->nombre_enc_ejec,
            $row->email_enc_ejec,
            $row->rut_ejec_const,
            $row->nombre_ejec_const,
            $row->email_ejec_const,
            $row->profesion_ejec_const,
            $row->rut_ejec_social,
            $row->nombre_ejec_social,
            $row->email_ejec_social,
            $row->profesion_ejec_social,
            $row->rut_enc_prog_seremi,
            $row->nombre_enc_prog_seremi,
            $row->email_enc_prog_seremi,
            $row->rut_ate_fosis,
            $row->nombre_ate_fosis,
            $row->email_ate_fosis
        ];
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->convocatorias;
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
//    public function title(): string
//    {
//        $anio = $this->convocatoria->anio;
//        $comuna = $this->convocatoria->comuna->nombre;
//        return "Convocatoria $comuna $anio";
//    }
    /**
     * @return string
     */
    public function title(): string
    {
        return "Convocatorias";
    }
}