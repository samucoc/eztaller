<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\Convocatoria;
use App\Beneficiario;
use App\Exports\ConvocatoriasExport;
use App\Participacion;
use App\Movimiento;
use App\BitEstado;
use App\PropuestaFamilia;
use App\Services\EmailSender;
use App\SeguimientoPropuesta;
use App\TipoEntidad;
use App\Bitacora;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;

class ConvocatoriaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $conv = $request->get('convocatoria');
            $usuarios = $request->get('usuarios');

            $existConv = $this->exist($conv['anio'], $conv['comunas_id']);

            if (empty($existConv)) {
                $conv['estado_convocatoria_id'] = $conv['estado']['id'];
                unset($conv['estado'], $conv['region']);

                $convocatoria = new Convocatoria($conv);
                $convocatoria->save();
                $convocatoria->comunas()->sync($conv['comunas_id']);

                $comunas = $convocatoria->comunas->map(function ($item) {
                    return $item->nom_com;
                })->toArray();

                // Vincular usuarios
                $users = [];
                if (is_array($usuarios)) {
                    if (count($usuarios)) {
                        foreach ($usuarios as $usuario) {
                            $users[] = $usuario['id'];
                        }
                        $convocatoria->usuarios()->sync($users);
                    }
                }

                // Guardar equipo_responsable
                foreach ($usuarios as $item) {
                    DB::table('hab_user_has_convocatorias')
                        ->where('convocatoria_id', $convocatoria->id)
                        ->where('user_id', $item['id'])
                        ->update(['equipo_responsable' => $item['equipo_responsable']]);
                }

                // Agrega movimiento
                Movimiento::create([
                    'convocatoria_id' => $convocatoria->id,
                    'user_id' => auth()->user()->id,
                    'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_PROPUESTA,
                    'descripcion' => 'Convocatoria creada. AÑO ' . $convocatoria->anio . ' - REGIÓN: ' . $convocatoria->region()['nom_reg'] . ' - COMUNA(S): ' . implode(' / ', $comunas)
                ]);

                // Agrega estado inicial
                $convocatoria->cambiarEstado(BitEstado::estadoInicial(TipoEntidad::CONVOCATORIA)->id, auth()->user()->id);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Se ha creado la convocatoria correctamente.',
                    'type' => 'success',
                ], 200);
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una convocatoria asociada a la(s) comuna(s) seleccionada(s).',
                    'type' => 'warning'
                ], 200);
            }
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar guardar la información.',
                'type' => 'error',
                // 'data' => $conv_req
            ], 200);
        }
    }

    public function search(Request $request)
    {
        $filter = $request->all();
        return Convocatoria::search($filter);
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
        DB::beginTransaction();
        try {

            // Obtener convocatoria
            $convocatoria = Convocatoria::findOrFail($id);
            $conv = $conv_req = $request->get('convocatoria');
            $usuarios = $request->get('usuarios');

            unset($conv['comunas']);
            unset($conv['comunas_id']);
            unset($conv['comunas_nombre']);
            unset($conv['region']);
            unset($conv['estado']);

            $conv['estado_convocatoria_id'] = 1;
            !isset($conv['comentario']) ? $conv['comentario'] = '' : '';
            // Agrega estado nuevo
            $convocatoria->cambiarEstado($conv['bit_estado_actual_id'], auth()->user()->id, $conv['comentario']);
            if ($conv['bit_estado_actual_id'] == BitEstado::CON_DIAGNOSTICO) {
                // TODO: Todos las familias a Diagnostico no iniciado
                $beneficiarios = Beneficiario::where('convocatoria_id', $conv['id'])
                    ->where('bit_estado_actual_id', BitEstado::FAM_SEL)->get();
                foreach ($beneficiarios as $benef) {
                    $benef->cambiarEstado(BitEstado::FAM_DIA_NO_INI, auth()->user()->id, null, TRUE);
                }
            }
            $exist = $this->exist($conv_req['anio'], $conv_req['comunas_id'], $id);
            if (empty($exist)) {
                if ($convocatoria->update($conv)) {
                    $convocatoria->comunas()->sync($conv_req['comunas_id']);
                    $convocatoria = Convocatoria::findOrFail($id);
                    $convocatoria->{'region'} = $convocatoria->comunas->first()->getRegion();
                    $comunas_id = [];
                    $comunas_nombre = [];
                    foreach ($convocatoria->comunas as $comuna_item) {
                        $comunas_id[] = $comuna_item->cod_com_ine;
                        $comunas_nombre[] = $comuna_item->nom_com;
                    }
                    $convocatoria->{'comunas_id'} = $comunas_id;
                    $convocatoria->{'comunas_nombre'} = $comunas_nombre;

                    // Vincular usuarios
                    $users = [];
                    if (is_array($usuarios)) {
                        if (count($usuarios)) {
                            foreach ($usuarios as $usuario) {
                                $users[] = $usuario['id'];
                            }
                            $convocatoria->usuarios()->sync($users);
                        }
                    }

                    // Guardar equipo_responsable
                    foreach ($usuarios as $item) {
                        DB::table('hab_user_has_convocatorias')
                            ->where('convocatoria_id', $convocatoria->id)
                            ->where('user_id', $item['id'])
                            ->update(['equipo_responsable' => $item['equipo_responsable']]);
                    }

                    DB::commit();
                    return response()->json([
                        'success' => true,
                        'message' => 'Se ha actualizado la convocatoria correctamente.',
                        'type' => 'success',
                        'data' => $convocatoria
                    ], 200);
                } else {
                    DB::rollback();
                    return response()->json([
                        'success' => false,
                        'message' => 'Ocurrio un error al actualizar el registro.',
                        'type' => 'error',
                        'data' => $conv_req
                    ], 200);
                }
            } else {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe una convocatoria asociada a la(s) comuna(s) seleccionada(s).',
                    'type' => 'warning',
                    'data' => $conv_req
                ], 200);
            }
        } catch (Exception $ex) {
            DB::rollback();
            Log::error($ex);
            return response()->json([
                'success' => false,
                'message' => 'Ha ocurrido un error al intentar guardar la información.',
                'type' => 'error',
                'exception' => $ex,
                'data' => $conv_req
            ], 200);
        }
    }


    /**
     * Remove the specified resource from storage (softdeletes).
     *
     * @param \App\Convocatoria $convocatoria
     * @return JsonResponse
     */
    public function destroy(Convocatoria $convocatoria, $id)
    {
        $convocatoria = $convocatoria->find($id);
        $nBeneficiarios = $convocatoria ? Beneficiario::where(['convocatoria_id' => $id])->count() : 0;

        if ($nBeneficiarios == 0)
            if ($convocatoria->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Se ha eliminado la convocatoria correctamente.',
                    'type' => 'success',
                    'data' => []
                ], 200);
            } else {
                $convocatoria['comunas'] = $convocatoria->comunas();
                $convocatoria['region'] = $convocatoria->region();
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el registro',
                    'type' => 'danger',
                    'data' => $convocatoria
                ], 200);
            }
        else {
            $convocatoria['comunas'] = $convocatoria->comunas();
            $convocatoria['region'] = $convocatoria->region();
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar convocatoria, ya que tiene registros asociados.',
                'type' => 'warning',
                'data' => $convocatoria
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Convocatoria $convocatoria
     * @return Response
     */
    protected function get($convocatoria)
    {
        return Convocatoria::where($convocatoria)->get();
    }

    /**
     * Retorna array con los años de una convocatoria en relación.
     *
     * @return Response
     */
    public function getAniosConvocatorias()
    {
        return Convocatoria::distinct('anio')->select('anio')->orderBy('anio', 'DESC')->get();
    }

    protected function exist($anio, $comunas, $id = false)
    {
        $where[] = ['hab_convocatorias.anio', '=', $anio];
        $where[] = ['hab_convocatorias.deleted_at', '=', null];
        if ($id)
            $where[] = ['hab_convocatorias.id', '<>', $id];

        return \DB::table('hab_convocatorias')
            ->select('hab_convocatorias.*')
            ->join('hab_convocatoria_has_comunas', 'hab_convocatoria_has_comunas.convocatoria_id', 'hab_convocatorias.id')
            ->whereIn('hab_convocatoria_has_comunas.comuna_id', $comunas)
            ->where($where)
            ->first();
    }

    public function getByComuna($comunaId)
    {
        return Convocatoria::whereHas('comunas', function ($q) use ($comunaId) {
            $q->where('cod_com_ine', $comunaId);
        })
            ->orderBy('anio', 'desc')
            ->get();
    }

    public function print($ids)
    {
        $ids = explode('-', $ids);

        $convocatorias = [];
        $convocatoriasFound = Convocatoria::whereIn('id', $ids)->get();

        foreach ($convocatoriasFound as $conv) {
            $conv->{'comunas'} = $conv->comunas;
            $conv->{'region'} = $conv->comunas->first()->getRegion();
            $conv->{'estado'} = $conv->estado;
            unset($conv->estado_convocatoria_id);
            $convocatorias[] = $conv;
        }

        if (!$convocatorias) {
            response()->json([
                'message' => 'No existen convocatorias.',
            ], Response::HTTP_NOT_FOUND);
        }

        $pdf = PDF::loadView('convocatoria', ['convocatorias' => $convocatorias])->setPaper('a4', 'portrait');

        return $pdf->download("Reporte convocatorias.pdf");
    }

    /**
     * @param Excel $excel
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Excel $excel, $ids)
    {
        $ids = explode('-', $ids);

        $convocatoriasFound = Convocatoria::whereIn('id', $ids)->get();

        foreach ($convocatoriasFound as $conv) {
            $comunas = [];
            foreach ($conv->comunas as $comuna)
                $comunas[] = $comuna->nom_com;

            $region = $conv->comunas->first()->getRegion()['nom_reg'];
            $conv->{'region'} = $region;
            $conv->{'comunas'} = implode(",", $comunas);
            $conv->{'estado'} = $conv->estado;

            $conv->fecha_transferencia = date_format(date_create($conv->fecha_transferencia), 'd-m-Y');
            $conv->fecha_termino = date_format(date_create($conv->fecha_termino), 'd-m-Y');

            unset($conv->estado_convocatoria_id);
        }

        $export = new ConvocatoriasExport($convocatoriasFound);
        return $excel->download($export, 'Convocatorias.xlsx');
    }

    public function visarListadoFamilia(Convocatoria $convocatoria, $idConvocatoria, $visar)
    {
        $conv = $convocatoria->find($idConvocatoria);
        $conv->listado_familia_visado = ($visar === 'true' ? true : false);
        $conv->listado_familia_rev_reg = null;
        $conv->save();

        $movimiento = new Movimiento([
            "convocatoria_id" => $idConvocatoria,
            "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
            "user_id" => auth()->user()->id,
            "descripcion" => ($visar === 'true' ? "Visado" : "Se revirtió visación"),
            "motivo" => '',
        ]);
        $movimiento->save();

        if ($visar === 'true') {
            EmailSender::sendVisado($conv);
        }
        $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);
        return response()->json([
            'message' => $visar === 'true' ? "Se ha visado el listado de familias" : "Se revirtió el visado del listado de familia",
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    public function aprobacionListadoRegional(Request $request, Convocatoria $convocatoria)
    {
        $req = $request->all();
        $message = null;
        $type = null;

        $movimiento = new Movimiento([
            "convocatoria_id" => $req['id'],
            "user_id" => auth()->user()->id,
            "motivo" => $req['motivo'],
            "tipo_movimiento" => Movimiento::TIPO_MOVIMIENTO_FAMILIA
        ]);

        $conv = $convocatoria->find($req['id']);

        $conv->listado_familia_rev_reg = is_null($conv->listado_familia_rev_reg) ? null : boolval($conv->listado_familia_rev_reg);
        $conv->listado_familia_visado = boolval($conv->listado_familia_visado);

        if (is_null($conv->listado_familia_rev_reg)) {
            Log::info('aprobacionListadoRegional 1');

            $conv->listado_familia_rev_reg = $req['aprobado'];
            if (!$req['aprobado']) {
                $conv->listado_familia_visado = false;
            }
            $conv->save();

            $movimiento->descripcion = "Revisión regional " . ($req['aprobado'] ? "aprobada" : "rechazada");
            $movimiento->save();

            if (!$req['aprobado']) {
                try {
                    EmailSender::sendRechazado($conv, $req['motivo']);
                } catch (Exception $e) {
                    Log::error($e);
                }
            }

            $message = $req['aprobado'] ? "Listado aprobado" : "Listado rechazado";
            $type = "success";

            // TODO: Pasar a "En diagnostico" la convocatoria

            // TODO: Cuando es aprobado, cambiar las familias con estado actual seleccionada a Diagnostico no iniciado
            $beneficiarios = Beneficiario::where('convocatoria_id', $conv->id)
                ->where('bit_estado_actual_id', BitEstado::FAM_SEL)->get();
            foreach ($beneficiarios as $item) {
                $item->cambiarEstado(BitEstado::FAM_DIA_NO_INI, auth()->user()->id);
            }
        } elseif ($conv->listado_familia_rev_reg === false && $req['aprobado'] === true) {
            Log::info('aprobacionListadoRegional 2');
            $conv->listado_familia_rev_reg = true;
            $conv->save();

            $movimiento->descripcion = "Aprobado";
            $movimiento->save();

            // TODO: Cambiar todas las familias con estado actual seleccionada a diagnostico no iniciado
            // Obtener todos los beneficiarios seleccionados
            // $beneficiarios = Beneficiario::where('convocatoria_id')
            //     ->whwre('bit_estado_actual_id', BitEstado::FAM_SEL);
            // foreach ($beneficiarios as $item) {
            //     $item->cambiarEstado($item->id, BitEstado::FAM_DIA_NO_INI, auth()->user()->id);
            // }
            try {
                EmailSender::sendRechazado($conv, $req['motivo']);
            } catch (Exception $e) {
                Log::error($e);
            }

            $message = "El listado ha sido aprobado";
            $type = "success";
        } elseif ($conv->listado_familia_rev_reg === true && $req['aprobado'] === false) {
            Log::info('aprobacionListadoRegional 3');

            $conv->listado_familia_rev_reg = null;
            $conv->listado_familia_visado = false;
            $conv->save();

            $movimiento->descripcion = "Rechazado";
            $movimiento->save();

            $message = "El listado ha sido rechazado";
            $type = "success";
        } else {
            $conv->listado_familia_rev_reg = boolval($conv->listado_familia_rev_reg);
            $conv->listado_familia_visado = boolval($conv->listado_familia_visado);
            $message = "La propuesta ya se encuentra " . ($req['aprobado'] ? "aprobado" : "rechazado");
            $type = "warning";
        }

        $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);

        return response()->json([
            'message' => $message,
            'type' => $type,
            'data' => $data
        ], 200);
    }

    public function aprobacionPropuestaRegional(Request $request, Convocatoria $convocatoria)
    {
        $req = $request->all();
        $message = null;
        $type = null;

        $seguimiento = new SeguimientoPropuesta([
            "convocatoria_id" => $req['id'],
            "user_id" => auth()->user()->id,
            "motivo" => $req['motivo'],
        ]);

        $conv = $convocatoria->find($req['id']);

        if (is_null($conv->propuesta_rev_reg)) {
            $conv->propuesta_rev_reg = $req['aprobado'];
            if (!$req['aprobado'])
                $conv->propuesta_visado = false;

            $conv->save();

            $seguimiento->accion = $req['aprobado'] ? "Aprobación de la propuesta" : "Rechazo de la propuesta";
            $seguimiento->save();

            $message = $seguimiento->accion;
            $type = "success";
        } elseif ($conv->propuesta_rev_reg == '0' && $req['aprobado'] === true) {
            $conv->propuesta_rev_reg = true;
            $conv->save();

            $seguimiento->accion = "Aprobación de la propuesta";
            $seguimiento->save();

            $message = $seguimiento->accion;
            $type = "success";
        } elseif ($conv->propuesta_rev_reg == '1' && $req['aprobado'] === false) {
            $conv->propuesta_rev_reg = false;
            $conv->propuesta_visado = false;
            $conv->save();

            $seguimiento->accion = "Rechazo de la propuesta";
            $seguimiento->save();

            $message = $seguimiento->accion;
            $type = "success";
        } else {
            $message = "La propuesta ya se encuentra " . ($req['aprobado'] ? "aprobada" : "rechazada");
            $type = "warning";
        }

        if (!$req['aprobado']) {
            $beneficiarios = Beneficiario::where('convocatoria_id', '=', $conv->id)->get();

            $beneficiariosId = [];
            foreach ($beneficiarios as $b)
                $beneficiariosId[] = $b->id;

            PropuestaFamilia::whereIn('beneficiario_id', $beneficiariosId)->update(['visado' => false]);
        }

        return response()->json([
            'message' => $message,
            'type' => $type,
            'data' => $conv
        ], 200);
    }

    public function visarPropuesta(Convocatoria $convocatoria, $id, $visar)
    {
        $conv = $convocatoria->find($id);
        $conv->propuesta_visado = $visar === 'true' ? true : false;
        if ($visar === 'true')
            $conv->propuesta_rev_reg = null;
        $conv->save();

        $accion = ($visar === 'true' ? "Se ha visado la propuesta" : "Se revirtió la visación de la propuesta");
        $seguimiento = new SeguimientoPropuesta([
            "convocatoria_id" => $id,
            "user_id" => auth()->user()->id,
            "accion" => $accion
        ]);
        $seguimiento->save();

        $conv->propuesta_visado = $conv->propuesta_visado == "1" ? true : false;

        return response()->json([
            'message' => $accion,
            'type' => 'success',
            'data' => $conv
        ], 200);
    }

    public function visarResumenPic($convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $conv = Convocatoria::findOrFail($convocatoria_id);

            if (boolval($conv->resumen_pic_visado)) {
                return response()->json([
                    'code' => 200,
                    'message' => "El Resumen PIC ya se encuentra visado.",
                    'type' => 'info',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }

            Movimiento::create([
                'convocatoria_id' => $convocatoria_id,
                'user_id' => auth()->user()->id,
                'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_PROPUESTA,
                'descripcion' => 'Resumen PIC Visado'
            ]);
            Bitacora::cambiarEstado(TipoEntidad::CONVOCATORIA, $convocatoria_id, BitEstado::VISACION_PIC, auth()->user()->id);


            $conv->resumen_pic_visado = true;
            $conv->save();
            $conv->{'region'} = $conv->comunas->first()->getRegion();

            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => "El Resumen PIC ha sido visado con éxito.",
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'code' => '500',
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function aprobarResumenPic($convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $conv = Convocatoria::findOrFail($convocatoria_id);
            if (!$conv->resumen_pic_visado) {
                return response()->json([
                    'code' => 200,
                    'type' => 'info',
                    'message' => 'El resumen PIC debe estar visado para poder ser aprobado.',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }

            if ($conv->resumen_pic_aprobado) {
                return response()->json([
                    'success' => 200,
                    'message' => "El Resumen PIC ya se encuentra aprobado.",
                    'type' => 'info',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }
            Movimiento::create([
                'convocatoria_id' => $convocatoria_id,
                'user_id' => auth()->user()->id,
                'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_PROPUESTA,
                'descripcion' => 'Resumen PIC Aprobado'
            ]);
            Bitacora::cambiarEstado(TipoEntidad::CONVOCATORIA, $convocatoria_id,  BitEstado::APROBACION_PIC, auth()->user()->id);

            $conv = Convocatoria::findOrFail($convocatoria_id);
            $conv->resumen_pic_aprobado = true;
            $conv->save();
            $conv->{'region'} = $conv->comunas->first()->getRegion();

            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => "El Resumen PIC ha sido aprobado con éxito.",
                'type' => 'success',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'code' => 500,
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function visarResumenModPic($convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $conv = Convocatoria::findOrFail($convocatoria_id);

            if (boolval($conv->resumen_mod_pic_visado)) {
                return response()->json([
                    'code' => 200,
                    'message' => "El Resumen Modificación PIC ya se encuentra visado.",
                    'type' => 'info',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }

            Movimiento::create([
                'convocatoria_id' => $convocatoria_id,
                'user_id' => auth()->user()->id,
                'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_PROPUESTA,
                'descripcion' => 'Resumen Modificación PIC Visado'
            ]);
            Bitacora::cambiarEstado(TipoEntidad::CONVOCATORIA, $convocatoria_id,  BitEstado::VISACION_PIC, auth()->user()->id);


            $conv->resumen_mod_pic_visado = true;
            $conv->save();
            $conv->{'region'} = $conv->comunas->first()->getRegion();

            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => "El Resumen Modificación PIC ha sido visado con éxito.",
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'code' => '500',
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function aprobarResumenModPic($convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $conv = Convocatoria::findOrFail($convocatoria_id);
            if (
                !$conv->resumen_pic_visado ||
                !$conv->resumen_pic_aprobado ||
                !$conv->resumen_mod_pic_visado
            ) {
                return response()->json([
                    'code' => 200,
                    'type' => 'info',
                    'message' => 'El Resumen Modificación PIC debe estar visado para poder ser aprobado.',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }

            if ($conv->resumen_mod_pic_aprobado) {
                return response()->json([
                    'success' => 200,
                    'message' => "El Resumen Modificación PIC ya se encuentra aprobado.",
                    'type' => 'info',
                    'data' => Convocatoria::searchFirst(['convocatoria_id' => $conv->id]),
                ], 200);
            }
            Movimiento::create([
                'convocatoria_id' => $convocatoria_id,
                'user_id' => auth()->user()->id,
                'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_PROPUESTA,
                'descripcion' => 'Resumen PIC Aprobado'
            ]);
            Bitacora::cambiarEstado(TipoEntidad::CONVOCATORIA, $convocatoria_id,  BitEstado::APROBACION_PIC, auth()->user()->id);

            $conv = Convocatoria::findOrFail($convocatoria_id);
            $conv->resumen_mod_pic_aprobado = true;
            $conv->save();
            $conv->{'region'} = $conv->comunas->first()->getRegion();

            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);

            DB::commit();

            return response()->json([
                'code' => 200,
                'message' => "El Resumen Modificación PIC ha sido aprobado con éxito.",
                'type' => 'success',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'code' => 500,
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function actaMesaTecnica(Request $request, $id)
    {
        $convocatoria = Convocatoria::find($id);
        if (!$convocatoria) {
            response()->json([
                'message' => 'No existe la convocatoria.',
            ], Response::HTTP_NOT_FOUND);
        }
        $file = $request->file('file');
        $archivo = new Archivo($file);
        $archivo->save();
        $convocatoria->update([
            'acta_mesa_tecnica_id' => $archivo->getAttribute('id')
        ]);

        $data = Convocatoria::searchFirst(['convocatoria_id' => $convocatoria->id]);
        return response()->json([
            'message' => 'Se ha subido correctamente el archivo.',
            'type' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function actaMesaTecnicaPic(Request $request, $convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $fields = [
                'convocatoria_id' => $convocatoria_id,
                'acta_mesa_tecnica_pic' => $request->file('file'),
            ];
            $rules = [
                'convocatoria_id' => 'required|integer',
                'acta_mesa_tecnica_pic' => 'required|file',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }

            $conv = Convocatoria::find($convocatoria_id);
            if (!$conv) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No existe la convocatoria.',
                ], 200);
            }

            $archivo = new Archivo($request->file('file'));
            $archivo->save();
            $conv->update([
                'acta_mesa_tecnica_pic_id' => $archivo->getAttribute('id')
            ]);
            DB::commit();
            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);
            return response()->json([
                'message' => 'El archivo se ha cargado con éxito.',
                'type' => 'success',
                'code' => 200,
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function actaMesaTecnicaModPic(Request $request, $convocatoria_id)
    {
        DB::beginTransaction();
        try {
            $fields = [
                'convocatoria_id' => $convocatoria_id,
                'acta_mesa_tecnica_mod_pic' => $request->file('file'),
            ];
            $rules = [
                'convocatoria_id' => 'required|integer',
                'acta_mesa_tecnica_mod_pic' => 'required|file',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }

            $conv = Convocatoria::find($convocatoria_id);
            if (!$conv) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'No existe la convocatoria.',
                ], 200);
            }

            $archivo = new Archivo($request->file('file'));
            $archivo->save();
            $conv->update([
                'acta_mesa_tecnica_mod_pic_id' => $archivo->getAttribute('id')
            ]);
            DB::commit();
            $data = Convocatoria::searchFirst(['convocatoria_id' => $conv->id]);
            return response()->json([
                'message' => 'El archivo se ha cargado con éxito.',
                'type' => 'success',
                'code' => 200,
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar guardar la información.',
            ], 200);
        }
    }

    public function downloadArchivo($archivo_id)
    {
        $archivo = Archivo::find($archivo_id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app/private/') . $archivo->filename;
        return response()->download($pathtoFile, $archivo->filename);
    }

    public function getParticipacionesByRUT(Request $request)
    {
        try {

            $res = Participacion::where('rut', $request->get('rut'))->get();
            if (count($res)) {
                $response = [
                    'message' => 'Este RUT ya participó en convocatorias previas de Habitabilidad.',
                    'type' => 'success',
                    'data' => $res,
                ];
            } else {
                $response = [
                    'message' => '',
                    'type' => 'success',
                    'data' => [],
                ];
            }
            return response()->json($response, 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => 'Error al intentar consultar las participaciones en convocatorias previas de Habitabilidad.',
                'type' => 'error',
            ], 200);
        }
    }

    public function getMovimientos($convocatoria_id, $tipo_movimiento)
    {
        try {
            $data = [];
            if (in_array($tipo_movimiento, [Movimiento::TIPO_MOVIMIENTO_FAMILIA, Movimiento::TIPO_MOVIMIENTO_PROPUESTA])) {
                $data = Movimiento::where('convocatoria_id', $convocatoria_id)
                    ->where('tipo_movimiento', $tipo_movimiento)
                    ->orderBy('id', 'DESC')->get();
            }
            return response()->json([
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Error al intentar consultar las participaciones en convocatorias previas de Habitabilidad.',
                'type' => 'error',
            ], 200);
        }
    }

    public function getBitacora($convocatoria_id)
    {
        try {
            $data = Bitacora::getByConvocatoria($convocatoria_id);
            return response()->json([
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Error al intentar realizar la solicitud.',
                'type' => 'error',
            ], 200);
        }
    }

    public function buscar(Request $request)
    {
        try {
            $data = [];
            $input = $request->all();
            // Filter region
            if (isset($input['region_id']) || isset($input['comuna_id'])) {
                $sql_fil_reg = (isset($input['region_id']) && count($input['region_id'])) ? 'AND t3.cod_reg in (' . implode(',', $input['region_id']) . ')' : '';
                $sql_fil_com = (isset($input['comuna_id']) && count($input['comuna_id'])) ? 'AND t3.cod_com_ine in (' . implode(',', $input['comuna_id']) . ')' : '';

                if ($sql_fil_reg !== '' || $sql_fil_com !== '') {
                    $sql = "
                    select
                    t1.id, 
                    t1.anio,
                    DBMS_LOB.substr(listagg(distinct(t3.nom_reg),', '),3000) as region,
                    DBMS_LOB.substr(listagg(distinct(t3.nom_com),', '),3000) as comuna,
                    t4.nombre as estado_convocatoria
                    from hab_convocatorias t1
                    inner join hab_convocatoria_has_comunas t2 on t2.convocatoria_id=t1.id
                    inner join REG_PROV_COMINE@DBL_HABITABILIDAD t3 on t3.cod_com_ine=t2.comuna_id
                    inner join hab_estado_convocatorias t4 on t4.id=estado_convocatoria_id
                    where 1=1 " . $sql_fil_reg . " " . $sql_fil_com . "
                    and deleted_at is null
                    group by t1.id,anio,nombre
                    order by anio
                    ";
                    Log::info($sql);
                    $data = DB::select($sql);
                }
            }
            return response()->json([
                'type' => 'success',
                'data' => $data,
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                'message' => 'Error al intentar realizar la solicitud.',
                'type' => 'error',
            ], 200);
        }
    }

    public function getUsuariosByConvocatoria(Request $request)
    {
        $usuarios = [];
        $estados_convocatorias = [
            'CON_REGISTRADA' => BitEstado::CON_REGISTRADA,
            'CON_REGISTRO_FAMILIAS' => BitEstado::CON_REGISTRO_FAMILIAS,
            'CON_SELECCION_FAMILIAS' => BitEstado::CON_SELECCION_FAMILIAS,
            'CON_DIAGNOSTICO' => BitEstado::CON_DIAGNOSTICO,
            'CON_PROPUESTAS_TECNICAS' => BitEstado::CON_PROPUESTAS_TECNICAS,
            'CON_PIC_APROBADO' => BitEstado::CON_PIC_APROBADO,
            'CON_IMPLEMENTACION_PROPUESTAS_TECNICAS' => BitEstado::CON_IMPLEMENTACION_PROPUESTAS_TECNICAS,
            'CON_CIERRE_TECNICO' => BitEstado::CON_CIERRE_TECNICO,
            'CON_FINALIZADA' => BitEstado::CON_FINALIZADA,
        ];
        if ($request->has('convocatoria_id')) {
            $usuarios = User::getIndex([
                'convocatoria_id' => $request->get('convocatoria_id')
            ]);
        }
        return response()->json([
            'code' => 200,
            'type' => 'success',
            'data' => $usuarios,
            'estados_convocatorias' => $estados_convocatorias,
        ], 200);
    }
}
