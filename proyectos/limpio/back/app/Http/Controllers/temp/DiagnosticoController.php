<?php

namespace App\Http\Controllers;

use App\Beneficiario;
use App\Bitacora;
use App\BitEstado;
use App\Const_Global_Diag;
use App\Componente;
use App\DiagnosticoFamilia;
use App\FormularioDiagnostico;
use App\FormularioValor;
use App\Respuesta;
use App\Pregunta;
use App\Planos_Diagnosticos;
use App\Photos_Diagnosticos;
use App\GrupoFamiliar;
use App\Movimiento;
use App\Planos_Viv_Diagnostico;
use App\TipoEntidad;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DiagnosticoController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \App\Beneficiario $beneficiario
     * @param int $beneficiarioId
     * @param boolean $visar
     * @return \Illuminate\Http\JsonResponse
     */
    public function visarDiagnosticoFamilia($beneficiarioId, $visar)
    {
        DB::beginTransaction();
        try {
            $beneficiario = Beneficiario::find($beneficiarioId);
            if ($beneficiario) {
                $diagnostico = DiagnosticoFamilia::where('beneficiario_id', '=', $beneficiarioId)->first();
                if ($diagnostico) {
                    $diagnostico->visado = $visar == 'true' ? true : false;
                    $diagnostico->save();
                    Movimiento::create([
                        'convocatoria_id' => $beneficiario->convocatoria_id,
                        'beneficiario_id' => $beneficiario->id,
                        'user_id' => auth()->user()->id,
                        'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                        'descripcion' => ($visar === 'true' ? 'Visado del diagnóstico de la familia Nº ' . $beneficiario->numero : 'Rechazo del diagnóstico de la familia Nº ' . $beneficiario->numero),
                    ]);
                    // Cambiar a diagnóstico visado.
                    if ($visar === 'true') {
                        Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $beneficiario->id, BitEstado::FAM_DIA_VIS, auth()->user()->id);
                    } else {
                        // Revertir visación del diagnostico
                    }
                    DB::commit();
                    return response()->json([
                        'code' => '200',
                        'message' => ($visar === 'true' ? "Se ha visado el diagnóstico de la familia N° " . $beneficiario->numero : "Se revirtió la visación del diagnóstico de la familia N° " . $beneficiario->numero),
                        'type' => 'success',
                        'data' => $diagnostico
                    ], 200);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
        }
        $beneficiario = Beneficiario::find($beneficiarioId);

        $diagnostico = DiagnosticoFamilia::where('beneficiario_id', '=', $beneficiarioId)->first();
        if ($diagnostico) {
            $diagnostico->visado = $visar == 'true' ? true : false;
            $diagnostico->save();

            Movimiento::create([
                'convocatoria_id' => $convocatoria_id,
                'beneficiario_id' => $beneficiario_id,
                'user_id' => auth()->user()->id,
                'tipo_movimiento' => Movimiento::TIPO_MOVIMIENTO_FAMILIA,
                'descripcion' => 'Resumen PIC Visado'
            ]);

            return response()->json([
                'code' => '200',
                'message' => ($visar === 'true' ? "Se ha visado el diagnóstico de la familia" : "Se revirtió la visación del diagnóstico de la familia"),
                'type' => 'success',
                'data' => $diagnostico
            ], 200);
        } else {
            return response()->json([
                'message' => ($visar === 'true' ? "Ha ocurrido un error al intentar visar el diagnóstico de la familia" : "Ha ocurrido un error al intentar revertir la visación del diagnóstico de la familia"),
                'code' => '500',
                'type' => 'error',
                'data' => $diagnostico
            ], 200);
        }
    }

    public function formulario($beneficiacioId)
    {
        $beneficiario = Beneficiario::find($beneficiacioId);
        if (!$beneficiario) {
            return response()->json([
                'message' => 'No existe la familia.',
            ], Response::HTTP_NOT_FOUND);
        }
        $convocatoria = $beneficiario->convocatoria;
        $formulario = FormularioDiagnostico::where('anio', $convocatoria->anio)->first();
        return $formulario->getStructure($beneficiacioId);
    }

    public function save(Request $request, $beneficiacioId)
    {
        $beneficiario = Beneficiario::find($beneficiacioId);
        if (!$beneficiario) {
            return response()->json([
                'message' => 'No existe la familia.',
            ], Response::HTTP_NOT_FOUND);
        }
        $values = $request->all()['values'];
        $respuestas = $request->all()['respuestas'];
        $convocatoria = $beneficiario->convocatoria;
        $formulario = $convocatoria->formulario();
        //  Agregado el guardar de preguntas
        $save_resp = $this->save_respuesta($respuestas, $beneficiacioId, $formulario->{'id'});
        //  Fin guardar de preguntas
        $componentes = Componente::where('formulario_id', $formulario->{'id'})->get();
        $formValues = FormularioValor::where('beneficiario_id', $beneficiacioId)->get();
        $mapValues = [];
        foreach ($formValues as $formValue) {
            $mapValues[$formValue->{'componente_id'}] = $formValue;
        }
        foreach ($componentes as $componente) {
            $id = $componente->{'id'};
            if (key_exists($id, $values)) {
                $value = json_encode($values[$id]);
                if (key_exists($id, $mapValues)) {
                    $formValue = $mapValues[$id];
                    $formValue->value = $value;
                } else {
                    $formValue = new FormularioValor([
                        'value' => $value,
                        'beneficiario_id' => $beneficiacioId,
                        'componente_id' => $id
                    ]);
                }
                $formValue->save();
            }
        }

        $propuesta = new PropuestasController();
        $propuesta->savePicFromDiagnostico($beneficiacioId);

        return response()->json([
            'success' => true,
            'message' => 'El diagnóstico ha sido guardado con éxito.',
            'type' => 'success',
        ], 200);
    }
    public function save_respuesta($valores, $beneficiacioId, $formulario_id)
    {
        $table_Respuestas = Pregunta::SELECT(
            'hab_preguntas.id',
            'hab_form_seccions.id as id_seccion',
            'hab_soluciones.descripcion as solucion',
            'hab_preguntas.descripcion as pregunta',
            'hab_preguntas.configuracion'
        )
            ->join('hab_sec_sol', 'hab_preguntas.sec_sol_id', '=', 'hab_sec_sol.id')
            ->join('hab_soluciones', 'hab_soluciones.id', '=', 'hab_sec_sol.solucion_id')
            ->join('hab_form_seccions', 'hab_form_seccions.id', '=', 'hab_sec_sol.seccion_id')
            ->where('hab_form_seccions.formulario_id', $formulario_id)
            ->orderBy('hab_preguntas.id', 'ASC')
            ->get();

        $consulta_respuesta = Respuesta::where('beneficiario_id', $beneficiacioId)->get();

        if ($consulta_respuesta->count() <= 0) {
            foreach ($table_Respuestas as $data) {
                $id_preg = $data->{'id'};
                $x = $valores[$id_preg]['value'];
                $value_r = array("value" => $x);
                $value_e = json_encode($value_r);

                $insert = array(
                    'respuesta' => $value_e,
                    'valor' => $x,
                    'beneficiario_id' => $beneficiacioId,
                    'pregunta_id' => $id_preg
                );
                DB::table('hab_respuestas')->insert($insert);
            }
        } else {
            foreach ($table_Respuestas as $data) {
                $id_preg = $data->{'id'};
                $x = $valores[$id_preg]['value'];
                $value_r = array("value" => $x);
                $value_e = json_encode($value_r);
                $update = Respuesta::where('beneficiario_id', $beneficiacioId)
                    ->where('pregunta_id', $id_preg)
                    ->update(['respuesta' => $value_e, 'valor' => $x]);
            }
        }
    }
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws Exception
     */
    public function Plano_Diagnostico(Request $request, $id, $idcomp)
    {

        $beneficiario = Beneficiario::find($id);

        if (!$beneficiario) {
            response()->json([
                'message' => 'No existe el Beneficiario.',
            ], Response::HTTP_NOT_FOUND);
        }
        $file = $request->file('file');
        $archivo = new Planos_Diagnosticos($file, $id, $idcomp);
        $archivo->save();

        $data = Planos_Diagnosticos::search(['beneficiario_id' => $id, 'componente_id' => $idcomp]);

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
    public function Plano_Viv_Diagnostico(Request $request, $id, $idcomp)
    {

        $beneficiario = Beneficiario::find($id);

        if (!$beneficiario) {
            response()->json([
                'message' => 'No existe el Beneficiario.',
            ], Response::HTTP_NOT_FOUND);
        }
        $file = $request->file('file');
        $archivo = new Planos_Viv_Diagnostico($file, $id, $idcomp);
        $archivo->save();

        $data = Planos_Viv_Diagnostico::search(['beneficiario_id' => $id, 'componente_id' => $idcomp]);
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
    public function Photo_diagnostico(Request $request, $id, $idcomp)
    {

        $beneficiario = Beneficiario::find($id);

        if (!$beneficiario) {
            response()->json([
                'message' => 'No existe el Beneficiario.',
            ], Response::HTTP_NOT_FOUND);
        }

        $file = $request->file('file');
        $archivo = new Photos_Diagnosticos($file, $id, $idcomp);
        $archivo->save();

        $data = Photos_Diagnosticos::search(['beneficiario_id' => $id, 'componente_id' => $idcomp]);

        return response()->json([
            'message' => 'Se ha subido correctamente el archivo.',
            'type' => 'success',
            'data' => $data
        ], 200);
    }
    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function saveGrupoFamiliar(Request $request, $beneficiacioId, $compId)
    {
        DB::beginTransaction();
        try {
            $fields = $request->all()['editedItem'];
            $rules = [
                'rut' => 'required',
                'nombre' => 'required',
                'edad' => 'required|integer|min:1',
                'sexo' => 'required',
                'parentesco' => 'required',
                'actividad' => 'required',
                'enfermedad' => 'required',
                'num_recinto' => 'required',
                'uso_recinto' => 'required',
                'num_cama' => 'required|integer|min:0',
                'edo_cama' => 'required',
                'tipo_cama' => 'required',
            ];
            $v = Validator::make($fields, $rules, [
                'required' => 'Este campo es requerido.',
                'integer' => 'Este campo debe ser un número.',
                'min' => 'Este campo debe ser mayor o igual a :min'
            ]);
            if ($v->fails()) {
                return response()->json([
                    "code" => 402,
                    "errors" => $v->errors(),
                    "type" => 'success',
                ]);
            }
            list($run, $dv) = explode('-', $fields['rut']);
            if (is_null($fields['id'])) {
                // insertar
                $gru_fam = new GrupoFamiliar();
                $gru_fam->beneficiario_id = $beneficiacioId;
                $gru_fam->componente_id = $compId;
                $gru_fam->programa_id = 0;
                $gru_fam->familia_id = 0;
                $gru_fam->nom_programa = '-';
            } else {
                // editar
                $gru_fam = GrupoFamiliar::FindOrFail($fields['id']);
            }
            $gru_fam->visible = true;
            $gru_fam->run = $run;
            $gru_fam->dv = $dv;
            $gru_fam->nombre = $fields['nombre'];
            $gru_fam->apellido_paterno = '-';
            $gru_fam->edad = $fields['edad'];
            $gru_fam->edad = $fields['edad'];
            $gru_fam->sexo = $fields['sexo'];
            $gru_fam->parentesco = $fields['parentesco'];
            $gru_fam->actividad = $fields['actividad'];
            $gru_fam->enfermedad = $fields['enfermedad'];
            $gru_fam->num_recinto = $fields['num_recinto'];
            $gru_fam->uso_recinto = $fields['uso_recinto'];
            $gru_fam->num_cama = $fields['num_cama'];
            $gru_fam->edo_cama = $fields['edo_cama'];
            $gru_fam->tipo_cama = $fields['tipo_cama'];
            $gru_fam->save();

            DB::commit();
            return response()->json([
                'type' => 'success',
                'code' => 200
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

    /**app/GrupoFamiliar.php
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function add_tableGF(Request $request, $beneficiacioId, $compId)
    {
        $beneficiario = Beneficiario::find($beneficiacioId);
        if (!$beneficiario) {
            return response()->json([
                'message' => 'No existe la familia.',
            ], Response::HTTP_NOT_FOUND);
        }
        $values = $request->all()['addItem'];


        $rut_integrante = $values['rut'];
        $run_tmp = substr($rut_integrante, 0, strlen($rut_integrante) - 1);
        preg_match_all('!\d+!', $run_tmp, $matches);
        $run_integrante = implode('', $matches[0]);
        $dv_integrante = substr($rut_integrante, -1);


        GrupoFamiliar::create([
            'beneficiario_id' => $beneficiacioId,
            'convocatoria_id' => $beneficiario->convocatoria_id,
            'componente_id' => $compId,
            'programa_id' => $beneficiario->programa_id,
            'familia_id' => $beneficiario->familia_id,
            'nom_programa' => $beneficiario->nom_programa,
            'run' => $run_integrante,
            'dv' => $dv_integrante,
            'nombre' => $values['nombre'],
            'apellido_paterno' => ' ',
            'apellido_materno' => ' ',
            'edad' => $values['edad'],
            'sexo' => $values['sexo'],
            'parentesco' => $values['parentesco'],
            'actividad' => $values['actividad'],
            'enfermedad' => $values['enfermedad'],
            'num_recinto' => $values['num_recinto'],
            'num_cama' => $values['num_cama'],
            'edo_cama' => $values['edo_cama'], //edo= estado de cama
            'tipo_cama' => $values['tipo_cama'],
            'uso_recinto' => $values['uso_recinto']
        ]);
    }
    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function deleteGrupoFamiliar(Request $request)
    {
        DB::beginTransaction();
        try {
            $values = $request->all();
            GrupoFamiliar::where('id', $values['grupo_familiar_id'])
                ->where('beneficiario_id', $values['familia_id'])
                ->update(['visible' => 0]);
            DB::commit();
            return response()->json([
                'type' => 'success',
                'code' => 200
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            return response()->json([
                'type' => 'error',
                'message' => 'Ha occurido un error al intentar eliminar la información.',
            ], 200);
        }
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function displayPlanos($id)
    {
        $archivo = Planos_Diagnosticos::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->file($pathtoFile);
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadPhotos($id)
    {
        $archivo = Photos_Diagnosticos::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app/private/') . $archivo->filename;
        return response()->download($pathtoFile, $archivo->filename);
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function displayPhotos($id)
    {
        $archivo = Photos_Diagnosticos::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->file($pathtoFile);
    }


    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadPlanosViv($id)
    {
        $archivo = Planos_Viv_Diagnostico::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->download($pathtoFile, $archivo->filename);
    }

    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function displayPlanosViv($id)
    {
        $archivo = Planos_Viv_Diagnostico::find($id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->file($pathtoFile);
    }
    /**
     * @param Request $request
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadPlanos($Id)
    {
        $archivo = Planos_Diagnosticos::find($Id);
        if (!$archivo)
            return response()->json([
                'error' => 'Ocurrió un error al descargar el archivo.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        $pathtoFile = storage_path('app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR) . $archivo->filename;
        return response()->download($pathtoFile, $archivo->filename);
    }

    /**
     * @param beneficiarioId
     * @return JsonResponse
     * @throws Exception
     */
    public function validar_diag(Request $request, $beneficiarioId)
    {
        //inicializacion variables contadoras
        $num_comp = 0;
        //inicializacion array
        $comp_r_id = array();
        $file_comp = array();
        $photo_comp = array();
        $gf_comp = array();

        $beneficiario = Beneficiario::find($beneficiarioId);

        // ELIMINAR
        //cambia el estado a finalizado
        DiagnosticoFamilia::where('beneficiario_id', $beneficiario->id)->update(['estado_id' => Const_Global_Diag::FINALIZADO]);
        Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $beneficiario->id, BitEstado::FAM_DIA_FIN, auth()->user()->id);

        return response()->json(['message' => 'VALIDACIÓN EXITOSA', 'type' => 'success'], 200);
        // ELIMINAR

        if (!$beneficiario) {
            return response()->json([
                'message' => 'No existe la familia.',
            ], Response::HTTP_NOT_FOUND);
        }

        $convocatoria = $beneficiario->convocatoria;
        $formulario = $convocatoria->formulario();
        $componentes = Componente::where('formulario_id', $formulario->{'id'})->get();
        $num_comp = $componentes->count();

        foreach ($componentes as $componente) {

            $id = $componente->{'id'};
            $type = $componente->{'type'};

            if ($type != 'constant' && $type != 'files' && $type != 'files-photo' && $type != 'table-GF' && $type != 'table-question')
                array_push($comp_r_id, $id);
            if ($type == 'files')
                array_push($file_comp, $id);
            if ($type == 'files-photo')
                array_push($photo_comp, $id);
            if ($type == 'table-GF')
                array_push($gf_comp, $id);
        }
        //valida tabla => HAB_PLANOS_DIAGNOSTICO => VARIABLE HPLD
        $HPLD = $this->Validar_HPLD($beneficiarioId, $file_comp);
        if ($HPLD['error'] == true) {
            return response()->json(['message' => $HPLD['mensaje'], 'type' => $HPLD['type']], 200);
        } else {
            //valida tabla => HAB_PHOTOS_DIAGNOSTICO => VARIABLE HPHD
            $HPHD = $this->Validar_HPHD($beneficiarioId, $photo_comp);
            if ($HPHD['error'] == true) {
                return response()->json(['message' => $HPHD['mensaje'], 'type' => $HPHD['type']], 200);
            } else {
                //valida tabla => HAB_RESPUESTAS => VARIABLE HR
                $HR = $this->Validar_HR($beneficiarioId);
                if ($HR['error'] == true) {
                    return response()->json(['message' => $HR['mensaje'], 'type' => $HR['type']], 200);
                } else {
                    //valida tabla => HAB_GRUPOS_FAMILIARES => VARIABLE HGF
                    $HGF = $this->Validar_HGF($beneficiarioId, $gf_comp);
                    if ($HGF['error'] == true) {
                        return response()->json(['message' => $HGF['mensaje'], 'type' => $HGF['type']], 200);
                    } else {
                        //cambia el estado a finalizado
                        DiagnosticoFamilia::where('beneficiario_id', $beneficiario->id)->update(['estado_id' => Const_Global_Diag::FINALIZADO]);
                        Bitacora::cambiarEstado(TipoEntidad::DIAGNOSTICO, $beneficiario->id, BitEstado::FAM_DIA_FIN, auth()->user()->id);
                        return response()->json(['message' => $HGF['mensaje'], 'type' => $HGF['type']], 200);

                        //Debe Enviar una notificacion email
                        // try {
                        //     EmailSender::sendDiagnosticoFinalizado($conv, $req['motivo']);
                        //     } 
                        // catch (Exception $e) {
                        // }
                    }
                }
            }
        }
    }
    /**
     * @param beneficiarioId
     * @param id_form
     * @return json
     */
    public function Validar_HFV($id, $id_form)
    {
        $consulta_HFV = FormularioValor::where('beneficiario_id', $id)->get();

        if (!$consulta_HFV) {
            $json_data = '{
                    "code_error": 310,
                    "error" : true,
                    "mensaje" : "No Existe familia"
                    }';
            $json = json_decode($json_data);
            return $json;
        }
        foreach ($consulta_HFV as $valores) {
            $componenteId = $valores->{'componente_id'};
            $value = $valores->getValue();
            if (key_exists($componenteId, $id_form)) {
                if ($value != null) {
                    $json_data = '{
                        "code_error": 320,
                        "error" : true,
                        "mensaje" : "Revise. Usted tiene preguntas sin contestar en el diagnóstico."
                        }';
                    $json = json_decode($json_data);
                    return $json;
                }
            }
        }
        $json_data = '{
            "code_error": 200,
            "error" : false,
            "mensaje" : "exitosa validacion"
            }';
        $json = json_decode($json_data);
        return $json;
    }
    /**
     * @param id
     * @param file_comp
     * @return json
     */
    public function Validar_HPLD($id, $file_comp)
    {
        $consulta_HPLD = Planos_Diagnosticos::where('beneficiario_id', $id)->get();

        if ($consulta_HPLD->count() == 0) {
            $validator = array(
                'code_error' => 300,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta adjuntar planos de la vivienda diagnósticada.'
            );
            return $validator;
        }
        $bandera = 0;
        foreach ($consulta_HPLD as $valores) {
            $componenteId = $valores->{'componente_id'};
            $f_size = $valores->{'size'};
            if (key_exists($componenteId, $file_comp)) {
                if ($f_size <= 0) {
                    $bandera = 1;
                    break;
                }
            }
        }
        if ($bandera == 1) {
            $validator = array(
                'code_error' => 310,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta adjuntar planos de la vivienda diagnósticada.'
            );
            return $validator;
        } else {
            $validator = array(
                'code_error' => 320,
                'error' => false,
                'type' => 'success',
                'mensaje' => 'Validacion exitosa.'
            );
            return $validator;
        }
    }
    /**
     * @param id
     * @param photo_comp
     * @return json
     */
    public function Validar_HPHD($id, $photo_comp)
    {
        $consulta = Photos_Diagnosticos::where('beneficiario_id', $id)->get();

        if ($consulta->count() == 0) {
            $validator = array(
                'code_error' => 300,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta adjuntar photos de la vivienda diagnósticada.'
            );
            return $validator;
        }
        $bandera = 0;
        foreach ($consulta as $valores) {
            $componenteId = $valores->{'componente_id'};
            $f_size = $valores->{'size'};
            if (key_exists($componenteId, $photo_comp)) {
                if ($f_size <= 0) {
                    $bandera = 1;
                    break;
                }
            }
        }
        if ($bandera == 1) {
            $validator = array(
                'code_error' => 310,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta adjuntar photos de la vivienda diagnósticada.'
            );
            return $validator;
        } else {
            $validator = array(
                'code_error' => 320,
                'error' => false,
                'type' => 'success',
                'mensaje' => 'Validacion exitosa.'
            );
            return $validator;
        }
    }
    /**
     * @param id
     * @param gf_comp
     * @return json
     */
    //valida tabla => HAB_GRUPOS_FAMILIARES => VARIABLE HGF
    public function Validar_HGF($id, $gf_comp)
    {
        $consulta = GrupoFamiliar::where('beneficiario_id', $id)->where('visible', 1)->get();

        if ($consulta->count() == 0) {
            $validator = array(
                'code_error' => 300,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta datos en alguno/a integrante del grupo familiar diagnósticada.'
            );
            return $validator;
        }
        $bandera = 0;
        foreach ($consulta as $valores) {
            $componenteId = $valores->{'componente_id'};
            $edad = $valores->{'edad'};
            $sexo = $valores->{'sexo'};
            $actividad = $valores->{'actividad'};
            $enfermedad = $valores->{'enfermedad'};
            $num_recinto = $valores->{'num_recinto'};
            $num_cama = $valores->{'num_cama'};
            $edo_cama = $valores->{'edo_cama'};
            $tipo_cama = $valores->{'tipo_cama'};
            if (
                $edad == '' || $sexo == '' || $actividad == '' || $enfermedad == '' ||
                $num_recinto == '' || $num_cama == '' || $edo_cama == '' || $tipo_cama == ''
            ) {
                $bandera = 1;
                break;
            }
        }
        if ($bandera == 1) {
            $validator = array(
                'code_error' => 310,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta datos en alguno/a integrante del grupo familiar diagnósticada.'
            );
            return $validator;
        } else {
            $validator = array(
                'code_error' => 320,
                'error' => false,
                'type' => 'success',
                'mensaje' => 'Validacion exitosa.'
            );
            return $validator;
        }
    }
    /**
     * @param id
     * @param quest_comp
     * @return json
     */
    //valida tabla => HAB_RESPUESTAS => VARIABLE HR
    public function Validar_HR($id)
    {
        $consulta = Respuesta::where('beneficiario_id', $id)->get();

        if ($consulta->count() == 0) {
            $validator = array(
                'code_error' => 300,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta responder una/s pregunta/s del diagnóstico.'
            );
            return $validator;
        }
        $bandera = 0;
        foreach ($consulta as $valores) {
            $componenteId = $valores->{'componente_id'};
            $resp = $valores->{'respuesta'};
            $obj = json_decode($resp);
            $value = $obj->{'value'};
            if ($value == '' || $value == null) {
                $bandera = 1;
                break;
            }
        }
        if ($bandera == 1) {
            $validator = array(
                'code_error' => 310,
                'error' => true,
                'type' => 'warning',
                'mensaje' => 'Revise. Falta responder una/s pregunta/s del diagnóstico.'
            );
            return $validator;
        } else {
            $validator = array(
                'code_error' => 320,
                'error' => false,
                'type' => 'success',
                'mensaje' => 'Validacion exitosa.'
            );
            return $validator;
        }
    }

    function getGrupoFamiliar($familia_id)
    {
        $gf = new FormularioDiagnostico();

        $data = $gf->getGrupoFamiliar($familia_id);
        return response()->json([
            'type' => 'success',
            'data' => $data
        ], 200);
    }
}
