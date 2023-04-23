<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Bitacora;
use App\BitEstado;
use App\Convocatoria;
use App\DiagnosticoFamilia;
use App\GrupoFamiliar;
use App\TipoPropuesta;
use App\Estado;
use App\Http\Requests\GetByRutRequest;
use App\Http\Requests\StoreBeneficiarioRequest;
use App\PropuestaFamilia;
use App\SeguimientoFamilia;
use App\Services\EmailSender;
use App\Services\ProgActivos;
use App\Services\RegCivil;
use App\Services\QueriesProd;
use PDF;
use App\Exports\BeneficiariosExport;
use App\Http\Requests\GetBeneficiariosRequest;
use App\Movimiento;
use App\TipoEntidad;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BeneficiarioController extends Controller
{
    /**
     * Devuelve el listado de familias dado la convocatoria
     *
     * @param GetBeneficiariosRequest $request
     * @return void
     */
    public function index(GetBeneficiariosRequest $request)
    {

        $convocatoriaId = $request->query('convocatoriaId');
        $beneficiarios = Beneficiario::where(['convocatoria_id' => $convocatoriaId])
            ->where(function ($query) use ($request) {
                if (is_array($request->query('estado'))) {
                    $query->whereIn('bit_estado_actual_id', $request->query('estado'));
                }
            })
            ->orderBy('numero', 'ASC')
            ->get();
        return $beneficiarios;
    }

    /**
     * Crea una nueva familia
     *
     * @param StoreBeneficiarioRequest $request
     * @param ProgActivos $progActivos
     * @return array|\Illuminate\Http\JsonResponse
     */

    public function store(StoreBeneficiarioRequest $request, ProgActivos $progActivos)
    {
        DB::beginTransaction();
        try {

            $conv = Convocatoria::findOrFail($request->get('convocatoria_id'));
            $estados = [
                BitEstado::CON_REGISTRADA,
                BitEstado::CON_REGISTRO_FAMILIAS,
            ];
            if (in_array($conv->bit_estado_actual_id, $estados)) {

                // Obtengo los integrantes de la familia a crear
                $ruts = $progActivos->getIntegrantesByFamiliaId($request->get('familia_id'), $request->get('programa_id'));
                // Verifico que los ruts no esten en el mismo programa a insertar
                $result = Beneficiario::where('convocatoria_id', $request->get('convocatoria_id'))
                    ->whereIn('rut_benef', $ruts)
                    ->where('programa_id', $request->get('programa_id'))
                    ->get();
                if (count($result)) {
                    return response()->json([
                        'error' => 'Ya existe registrado un integrante del grupo familiar inscrito en el mismo programa de origen.'
                    ], Response::HTTP_BAD_REQUEST);
                }
                // Cantidad de beneficiarios en la convocatoria
                $benef_count = Beneficiario::where('convocatoria_id', $conv->id)->get()->count();

                $request = $request->all();
                $beneficiario = Beneficiario::create($request);
                // Agregar estado inicial
                $beneficiario->cambiarEstado(BitEstado::estadoInicial(TipoEntidad::FAMILIA)->id, auth()->user()->id);


                // TODO: Cambiar estado en bitácora a En Registro de familias potenciales cuando:
                // 1 - La convocatoria se encuentre en estado Convocatoria registrada
                // 2 - Cuando sea la primera familia registrada
                if (
                    $conv->bit_estado_actual_id == BitEstado::CON_REGISTRADA &&
                    $benef_count == 0
                ) {
                    $conv->cambiarEstado(BitEstado::CON_REGISTRO_FAMILIAS, auth()->user()->id);
                }
                DB::commit();
                return $beneficiario;
            } else {
                return response()->json([
                    'error' => 'No es posible registrar una familia con el estado actual de la convocatoria.'
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return response()->json([
                'error' => 'Ha ocurrido un error al intentar registrar la familia.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Pre-selecciona una familia para ser diagnosticada
     *
     * @param Request $request
     * @param ProgActivos $progActivos
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function preSelectFamilia(Request $request, ProgActivos $progActivos)
    {
        DB::beginTransaction();
        try {
            //TODO: Obtener los beneficiarios
            $beneficiarios = Beneficiario::whereIn('id', $request->get('beneficiarios'))
                ->get()
                ->toArray();

            // TODO: obtener convocatoria
            $conv = Convocatoria::findOrFail($beneficiarios[0]['convocatoria_id']);
            $estados = [
                BitEstado::CON_REGISTRO_FAMILIAS,
                BitEstado::CON_SELECCION_FAMILIAS,
            ];
            // TODO: validar estado de la convocatoria
            if (!in_array($conv->bit_estado_actual_id, $estados)) {
                return response()->json([
                    'error' => 'No es posible pre-seleccionar una familia con el estado actual de la convocatoria.'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Validar estado de los beneficiarios elegidos
            foreach ($beneficiarios as $item) {
                if ($item['bit_estado_actual_id'] == BitEstado::FAM_PRE_SEL) {
                    return response()->json([
                        'error' => 'Ya esta(s) familia(s) se encuentra(n) pre-seleccionada(s).'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
            // Guardar movimiento de la familia
            foreach ($beneficiarios as $item) {
                $movimiento = new Movimiento([
                    "beneficiario_id" => $item['id'],
                    "convocatoria_id" => $item['convocatoria_id'],
                    "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                    "user_id" => auth()->user()->id,
                    "descripcion" => "Familia pre-seleccionada",
                    "motivo" => "Familia N° " . $item['numero']
                ]);
                $movimiento->save();
            }
            // Cantidad de beneficiarios en la convocatoria
            $benef_count = Beneficiario::where('convocatoria_id', $conv->id)->where('bit_estado_actual_id',BitEstado::FAM_PRE_SEL)->get()->count();

            // TODO: Cambiar a estado Pre-seleccionada
            foreach ($beneficiarios as $item) {
                Bitacora::cambiarEstado(TipoEntidad::FAMILIA, $item['id'], BitEstado::FAM_PRE_SEL, auth()->user()->id);
            }
            
            // TODO: Cambiar estado en bitácora a CON_SELECCION_FAMILIAS cuando:
            // 1 - La convocatoria se encuentre en estado CON_REGISTRO_FAMILIAS
            // 2 - Cuando sea la primera familia seleccionada
            if (
                $conv->bit_estado_actual_id == BitEstado::CON_REGISTRO_FAMILIAS &&
                $benef_count == 0
            ) {
                $conv->cambiarEstado(BitEstado::CON_SELECCION_FAMILIAS, auth()->user()->id);
            }
            
            DB::commit();
            return response()->json([
                'type' => 'success'
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            Log::error($ex);
            DB::rollback();
            return response()->json([
                'error' => 'Error al intentar seleccionar las familias.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Selecciona una familia para ser diagnosticada
     *
     * @param Request $request
     * @param ProgActivos $progActivos
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function selectFamilia(Request $request, ProgActivos $progActivos)
    {
        DB::beginTransaction();
        try {

            //TODO: Obtener los beneficiarios
            $beneficiarios = Beneficiario::whereIn('id', $request->get('beneficiarios'))
                ->get()
                ->toArray();

            // TODO: obtener convocatoria
            $conv = Convocatoria::findOrFail($beneficiarios[0]['convocatoria_id']);
            $estados = [
                BitEstado::CON_SELECCION_FAMILIAS,
            ];

            // TODO: validar estado de la convocatoria
            if (!in_array($conv->bit_estado_actual_id, $estados)) {
                return response()->json([
                    'error' => 'No es posible seleccionar una familia con el estado actual de la convocatoria.'
                ], Response::HTTP_BAD_REQUEST);
            }

            // Validar estado de los beneficiarios elegidos
            foreach ($beneficiarios as $item) {
                if ($item['bit_estado_actual_id'] == BitEstado::FAM_SEL) {
                    return response()->json([
                        'error' => 'Ya esta(s) familia(s) se encuentra(n) seleccionada(s).'
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            // Guardar movimiento de la familia
            foreach ($beneficiarios as $item) {
                $movimiento = new Movimiento([
                    "beneficiario_id" => $item['id'],
                    "convocatoria_id" => $item['convocatoria_id'],
                    "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                    "user_id" => auth()->user()->id,
                    "descripcion" => "Familia seleccionada",
                    "motivo" => "Familia N° " . $item['numero']
                ]);
                $movimiento->save();
            }

            // Verificar que las familias a seleccionar esten en programas activos
            $programasId = [];
            $familiasId = [];
            foreach ($beneficiarios as $item) {
                $familiasId[] = $item['familia_id'];
                $programasId[] = $item['programa_id'];
            }
            
            $programasInactivos = $progActivos->getProgramasInactivosById($programasId, $familiasId);
            if (count($programasInactivos) > 0) {
                DB::rollback();
                return response()->json([
                    'error' => 'Las familias elegidas deben estar en programas activos.'
                ], Response::HTTP_BAD_REQUEST);
            }
        
            // Cantidad de beneficiarios en la convocatoria
            $benef_count = Beneficiario::where('convocatoria_id', $conv->id)->where('bit_estado_actual_id',BitEstado::FAM_SEL)->get()->count();

            // TODO: Cambiar a estado Seleccionada
            foreach ($beneficiarios as $item) {
                Bitacora::cambiarEstado(TipoEntidad::FAMILIA, $item['id'], BitEstado::FAM_SEL, auth()->user()->id);
                Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $item['id'], BitEstado::FAM_DIA_NO_INI, auth()->user()->id);
                // TODO: Guardar en propuesta_familias
                $pro = PropuestaFamilia::getLast($item['id']);
                if (!$pro) {
                    $pro = new PropuestaFamilia([
                        'beneficiario_id' => $item['id'],
                        'tipo_propuesta_id' => TipoPropuesta::PIC,
                        'estado_id' => Estado::NO_INICIADO,
                        'visado' => 0,
                    ]);
                    $pro->save();
                }
            }

            // TODO: Cambiar estado en bitácora a CON_SELECCION_FAMILIAS cuando:
            // 1 - La convocatoria se encuentre en estado CON_REGISTRO_FAMILIAS
            // 2 - Cuando sea la primera familia seleccionada
            if (
                $conv->bit_estado_actual_id == BitEstado::CON_SELECCION_FAMILIAS &&
                $benef_count == 0
            ) {
                $conv->cambiarEstado(BitEstado::CON_DIAGNOSTICO, auth()->user()->id);
            }

            DB::commit();
            return response()->json([
                'type' => 'success'
            ], Response::HTTP_OK);
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return response()->json([
                'error' => 'Error al intentar seleccionar las familias.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Verifica que el rut del representante no este registrado en la convocatoria
     * @param GetByRutRequest $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function checkConvocatoria(GetByRutRequest $request)
    {
        $rut = $request->get('rut');
        $convocatoriaId = $request->get('convocatoria');
        $anio = $request->get('anio');
        $rut = RegCivil::formatRut($rut);
        $result = Beneficiario::where('rut_benef', $rut)
            ->where('convocatoria_id', $convocatoriaId)->get();
        if (count($result)) {
            return response()->json([
                'error' => 'El representante de familia ya se encuentra registrado en la convocatoria seleccionada.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $res = \DB::table('REG_PROV_COMINE@DBL_HABITABILIDAD REG_PROV_COMINE')
            ->join('HAB_CONVOCATORIA_HAS_COMUNAS', 'HAB_CONVOCATORIA_HAS_COMUNAS.COMUNA_ID', '=', 'REG_PROV_COMINE.COD_COM_INE')
            ->join('HAB_CONVOCATORIAS', 'HAB_CONVOCATORIAS.ID', '=', 'HAB_CONVOCATORIA_HAS_COMUNAS.CONVOCATORIA_ID')
            ->join('HAB_BENEFICIARIOS', 'HAB_BENEFICIARIOS.CONVOCATORIA_ID', '=', 'HAB_CONVOCATORIAS.ID')
            ->where('HAB_BENEFICIARIOS.RUT_BENEF', $rut)
            ->where('HAB_CONVOCATORIAS.ANIO', $anio)
            ->get();

        if (count($res)) {
            return response()->json([
                'error' => "El representante de familia ya se encuentra registrado en convocatoria {$res[0]->anio} en la región de {$res[0]->nom_reg} y comuna de {$res[0]->nom_com}."
            ], Response::HTTP_BAD_REQUEST);
        }
        return response()->json([
            'type' => 'success',
            'data' => null
        ], Response::HTTP_OK);
    }


    /**
     * Verifica que alguno de los integrantes de la familia pertenece a otro programa origen
     * @param Request $request
     * @param ProgActivos $progActivos
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkIntegrante(Request $request, ProgActivos $progActivos)
    {
        $familiaId = $request->get('familia');
        $programaId = $request->get('programa');
        $convocatoriaId = $request->get('convocatoria');
        // Obtengo los programas diferentes al programa origen dado
        $programas = $progActivos->getProgramasDiferentesByFamiliaId($familiaId, $programaId);
        if (count($programas) > 0) {
            // Construyo la query para obtener las familias de los programas
            $query = Beneficiario::where('convocatoria_id', $convocatoriaId)
                ->where(function ($query) use ($programas) {
                    foreach ($programas as $programa) {
                        $query->orWhere(function ($subQuery) use ($programa) {
                            $subQuery->where('programa_id', $programa->programa_id);
                            $subQuery->where('familia_id', $programa->familia_id);
                        });
                    }
                });
            $result = $query->get();
            $otroProgramaOrigen = count($result) > 0;
        } else {
            $otroProgramaOrigen = false;
        }
        return response()->json([
            'otroProgramaOrigen' => $otroProgramaOrigen
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
        $export = new BeneficiariosExport($convocatoria);
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
        $beneficiarios = Beneficiario::where(['convocatoria_id' => $convocatoria->id])
            ->orderBy('numero')
            ->get();
        $anio = $convocatoria->anio;
        $title = "Convocatoria $anio";
        $pdf = PDF::loadView('beneficiarios', [
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
     * Devuelve la validacion tru o false de seleccionados ya registrados.
     * @param $data => $array
     * @return mixed
     */
    public function validacion($data)
    {
        $bandera = 0;
        foreach ($data as $benef) {
            if ($benef['selected'] == 1)
                $bandera++;
        }
        if ($bandera > 0)
            return false;
        else
            return true;
    }
    /**
     * Guarda Su Grupo Familiar del beneficiario cuando es seleccionado.
     * @param $data => $array
     * @return mixed
     */
    public function Guardar_GF($data)
    {
        $id_benef = $data['id'];
        $id_prog = $data['programa_id'];
        $nom_prog = $data['nom_programa'];
        $conv_id = $data['convocatoria_id'];
        $result = QueriesProd::getGF($id_benef);
        foreach ($result as $Grupo) {
            $GF = new GrupoFamiliar([
                "beneficiario_id" => $id_benef,
                "convocatoria_id" => $conv_id,
                "programa_id" => $id_prog,
                "familia_id" => $Grupo->id_familia,
                "nom_programa" => $nom_prog,
                "run" => $Grupo->run,
                "dv" => $Grupo->dv,
                "nombre" => $Grupo->nombre,
                "apellido_paterno" => $Grupo->apellido_paterno,
                "apellido_materno" => $Grupo->apellido_materno,
                "edad" => $Grupo->edad,
                "sexo" => $Grupo->sexo,
                "parentesco" => $Grupo->parentesco
            ]);
            $GF->save();
        }
        return true;
    }

    public function show(Request $request)
    {
        $convocatoria_id = $request->segment(3);
        $beneficiario_id = $request->segment(4);
        $beneficiario = Beneficiario::where('id', $beneficiario_id)->first();
        return response()->json([
            'type' => 'success',
            'data' => $beneficiario
        ], 200);
    }
}
