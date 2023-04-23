<?php

namespace App\Http\Controllers;

use App\Archivo;
use Webpatser\Uuid\Uuid;
use App\ProcesoAdquisicion;
use App\Beneficiario;
use App\Convocatoria;
use App\DiagnosticoFamilia;
use App\GrupoFamiliar;
use App\Movimiento;
use App\Http\Requests\GetByRutRequest;
use App\Http\Requests\StoreBeneficiarioRequest;
use App\PropuestaFamilia;
use App\SeguimientoFamilia;
use App\Services\EmailSender;
use App\Services\ProgActivos;
use App\Services\RegCivil;
use App\Services\QueriesProd;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class ProcesoAdquisicionController extends Controller
{
    /**
     * Devuelve el listado de familias dado la convocatoria
     *
     * @param GetBeneficiariosRequest $request
     * @return void
     */
    public function index(Request $request)
    {
        $convocatoriaId = $request->query('convocatoriaId');
        $data = ProcesoAdquisicion::orderBy('fecha', 'desc')->get()->map(function ($item) {
            $item->fecha = date('d/m/Y', strtotime($item->fecha));
            return $item;
        });
        if (count($data)) {
            return response()->json([
                'code' => 200,
                'type' => 'success',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'code' => 500,
            'message' => 'Los procesos de compras y adquisiciones no tienen registros.',
            'type' => 'warning',
            'data' => $data
        ], 200);
    }

    public function archivoPCA(Request $request)
    {
        $req = $request->all();

        $ProcesoAdquisicion = ProcesoAdquisicion::find($req['id']);
        if (!$ProcesoAdquisicion) {
            response()->json([
                'message' => 'No existe el proceso de compras y adquisición',
            ], Response::HTTP_NOT_FOUND);
        }

        $file = $request->file('file');

        $archivo = new Archivo();
        list($name, $ext) = explode('.', $req['filename']);
        $archivo->filename =  Uuid::generate()->string . '.' . $ext;
        $archivo->original_name = $req['original_name'];
        $archivo->size = $req['size'];
        $archivo->mime_type = $req['mime_type'];
        $archivo->disk = $req['disk'];
        $archivo->setFile($file);

        $archivo->save();

        $lastArchivo = Archivo::orderby('created_at', 'DESC')->take(1)->get();
        $ProcesoAdquisicion->archivo_id = $lastArchivo[0]->id;
        $ProcesoAdquisicion->update();

        $data = ProcesoAdquisicion::find(['id' => $ProcesoAdquisicion->id]);
        return response()->json([
            'message' => 'Se ha subido correctamente el archivo.',
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $req = $request->all();

        $ProcesoAdquisicion = new ProcesoAdquisicion();


        $ProcesoAdquisicion->convocatoria_id = $req['convocatoria_id'];
        $ProcesoAdquisicion->disk = $req['disk'];
        $ProcesoAdquisicion->filename = $req['filename'];
        $ProcesoAdquisicion->mime_type = $req['mime_type'];
        $ProcesoAdquisicion->original_name = $req['original_name'];
        $ProcesoAdquisicion->size = $req['size'];
        $ProcesoAdquisicion->tipo = $request['tipo'];
        $ProcesoAdquisicion->comentarios = $req['comentarios'];
        $ProcesoAdquisicion->fecha = $req['fecha'];
        $ProcesoAdquisicion->numero = $req['numero'];

        if ($ProcesoAdquisicion->save()) {
            $movimiento = new Movimiento([
                "convocatoria_id" => $ProcesoAdquisicion->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_PROCESOS,
                "user_id" => auth()->user()->id,
                "descripcion" => "Proceso agregado - Tipo: " . $ProcesoAdquisicion->tipo . " - Nombre de Documento: " . $ProcesoAdquisicion->original_name,
                "motivo" => ""
            ]);
            $movimiento->save();

            return response()->json([
                'success' => true,
                'message' => 'Se ha creado el proceso de compras y adquisición correctamente.',
                'type' => 'success',
                'data' => $req,
                'id' => $ProcesoAdquisicion->id
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un error al actualizar el registro.',
                'type' => 'danger',
                'data' => $req
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $ProcesoAdquisicion = ProcesoAdquisicion::find($id);
        $req = $request->all();

        if ($ProcesoAdquisicion->update($req)) {
            return response()->json([
                'success' => true,
                'message' => 'Se ha actualizado el proceso de compras y adquisición correctamente.',
                'type' => 'success',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrio un error al actualizar el registro.',
                'type' => 'danger',
                'data' => $req
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage (softdeletes).
     *
     * @param \App\ProcesoAdquisicion $ProcesoAdquisicion
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $req = $request->all();
        $ProcesoAdquisicion = ProcesoAdquisicion::find($req['id']);

        if ($ProcesoAdquisicion->delete()) {
            $movimiento = new Movimiento([
                "convocatoria_id" => $ProcesoAdquisicion->convocatoria_id,
                "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_PROCESOS,
                "user_id" => auth()->user()->id,
                "descripcion" => "Proceso eliminado - Tipo: " . $ProcesoAdquisicion->tipo . " - Nombre de Documento: " . $ProcesoAdquisicion->original_name,
                "motivo" => ""
            ]);
            $movimiento->save();
            return response()->json([
                'success' => true,
                'message' => 'Se ha eliminado el proceso de compras y adquisición correctamente.',
                'type' => 'success',
                'data' => []
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el registro',
                'type' => 'danger',
                'data' => $ProcesoAdquisicion
            ], 200);
        }
    }
}
