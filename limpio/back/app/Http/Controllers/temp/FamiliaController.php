<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Bitacora;
use App\BitEstado;
use App\Convocatoria;
use App\DiagnosticoFamilia;
use App\Exports\BeneficiariosExport;
use App\Exports\FamiliasExport;
use App\Http\Requests\GetBeneficiariosRequest;
use App\MotivoCancelacion;
use App\Movimiento;
use App\PropuestaFamilia;
use App\SeguimientoFamilia;
use App\TipoEntidad;
use Exception;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpFoundation\Response;

class FamiliaController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $convocatoriaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByConvocatoria(GetBeneficiariosRequest $request)
    {
        $convocatoriaId = $request->query('convocatoriaId');
        $options = json_decode($request->query('options'));
        $page = (int)$options->page;
        $itemsPerPage = (int)$options->itemsPerPage;

        $offset = $page > 1 ? (($page - 1) * $itemsPerPage) : 0;

        $beneficiarios = [];
        $total = Beneficiario::where([
            ['convocatoria_id', '=', $convocatoriaId],
            ['selected', '=', true]
        ])->count();

        $total = Beneficiario::where('convocatoria_id', '=', $convocatoriaId)
            ->whereIn('id', function ($query) {
                $query->select('entidad_id')
                    ->from('hab_bitacoras')
                    ->where('bit_estado_id', BitEstado::FAM_SEL);
            })->count();

        $sortBy = 'numero';
        if (is_object($options) && !empty($options->sortBy)) {
            $sortBy = $options->sortBy[0];
        }

        $sort = 'asc';
        if (is_object($options) && !empty($options->sortDesc) && $options->sortDesc[0] === true) {
            $sort = 'desc';
        }

        $beneficiariosDb = Beneficiario::getByConvocatoria($convocatoriaId, $sortBy, $sort, $offset, $itemsPerPage);

        foreach ($beneficiariosDb as $beneficiario) {
            $diagnostico = DiagnosticoFamilia::where('beneficiario_id', '=', $beneficiario->id)->first();
            $propuesta = PropuestaFamilia::where('beneficiario_id', '=', $beneficiario->id)->first();

            if ($diagnostico) {
                $diagnostico->visado = $diagnostico->visado === '1' ? true : false;
                $diagnostico->estado->nombre = ucfirst($diagnostico->estado->nombre);
            }

            if ($propuesta) {
                $propuesta->visado = $propuesta->visado === '1' ? true : false;
                $propuesta->estado->nombre = ucfirst($propuesta->estado->nombre);
            }

            $beneficiario->{'diagnostico'} = $diagnostico;
            $beneficiario->{'propuesta'} = $propuesta;

            $beneficiarios[] = $beneficiario;
        }

        return response()->json([
            "message" => '',
            "type" => 'success',
            "familias" => $beneficiarios,
            "total" => $total
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelar(Request $request, Beneficiario $beneficiario)
    {
        DB::beginTransaction();
        try {
            $req = $request->all();
            $beneficiario = $beneficiario->find($req['id']);
            $beneficiario->motivo_cancelacion_id = $req['motivo'];
            $beneficiario->save();
            $beneficiario->cambiarEstado(BitEstado::FAM_DES, auth()->user()->id, MotivoCancelacion::find($req['motivo'])->nombre);
            $movimiento = new Movimiento([
                "beneficiario_id" => $req['id'],
                "convocatoria_id" => $beneficiario->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                "user_id" => auth()->user()->id,
                "descripcion" => "Familia cancelada",
                "motivo" => "Familia n° $beneficiario->numero - " . MotivoCancelacion::find($req['motivo'])->nombre
            ]);
            $movimiento->save();

            DB::commit();
            return response()->json([
                'message' => 'Familia cancelada',
                'type' => 'success',
                'data' => $beneficiario
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'message' => 'Error al intentar cancelar la familia.',
                'type' => 'error',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activar(Beneficiario $beneficiario, $id)
    {
        DB::beginTransaction();
        try {
            $beneficiario = $beneficiario->find($id);
            $beneficiario->motivo_cancelacion_id = null;
            $beneficiario->save();
            $beneficiario->cambiarEstado(BitEstado::FAM_SEL, auth()->user()->id);

            $movimiento = new Movimiento([
                "beneficiario_id" => $id,
                "convocatoria_id" => $beneficiario->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                "user_id" => auth()->user()->id,
                "descripcion" => "Familia habilitada",
                "motivo" => "Familia n° $beneficiario->numero"
            ]);
            $movimiento->save();

            DB::commit();
            return response()->json([
                'message' => 'familia habilitada',
                'type' => 'success',
                'data' => $beneficiario
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'message' => 'Error al intentar cancelar la familia.',
                'type' => 'error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return MotivoCancelacion[]|\Illuminate\Database\Eloquent\Collection
     */
    public function motivosCancelacion()
    {
        return MotivoCancelacion::all();
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
        $export = new FamiliasExport($convocatoria);
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

        $beneficiarios = Beneficiario::where([
            ['convocatoria_id', '=', $convocatoria->id],
            ['selected', '=', true],
        ])->whereNull('motivo_cancelacion_id')
            ->get();

        $anio = $convocatoria->anio;
        $title = "Convocatoria $anio";

        $nombresComunas = [];
        foreach ($convocatoria->comunas as $comuna)
            $nombresComunas[] = $comuna->nombre;

        $pdf = PDF::loadView('familias', [
            'title' => $title,
            'convocatoria' => $convocatoria,
            'beneficiarios' => $beneficiarios,
            'comunas' => implode(", ", array_map(function ($comuna) {
                return $comuna['nom_com'];
            }, $convocatoria->comunas->toArray()))
        ])->setPaper('a4', 'landscape');

        return $pdf->download("$title.pdf");
    }
}
