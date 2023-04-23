<?php

namespace App\Http\Controllers;

use App\Bitacora;
use App\Convocatoria;
use App\PropuestaAsesoria;
use App\TipoEntidad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

class BitacoraController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function get(Request $request)
    {
        try {

            $fields = $request->all();
            $rules = [
                'id' => 'required|integer',
                'tipo_entidad_id' => 'required|integer|exists:hab_tipo_entidades,id',
            ];
            $v = Validator::make($fields, $rules);
            if ($v->fails()) {
                throw new Exception($v->errors()->first());
            }

            $data = Bitacora::getByEntidad($fields['id'], $fields['tipo_entidad_id']);
            
            switch ($fields['tipo_entidad_id']) {
                case TipoEntidad::CONVOCATORIA:
                    $title = "Bitácora de la convocatoria";
                    break;
                case TipoEntidad::FAMILIA:
                    $title = "Bitácora de la familia";
                    break;
                case TipoEntidad::SOLUCION:
                    $title = "Bitácora de la solución";
                    break;
                case TipoEntidad::ASESORIA:
                    $title = "Bitácora de la asesoría";
                    break;
                default:
                    $title = "Bitácora";
                    break;
            }
            return response()->json([
                "code" => Response::HTTP_OK,
                "type" => 'success',
                "data" => $data,
                "title" => $title,
            ]);
        } catch (Exception $ex) {
            Log::error($ex);
            return response()->json([
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "type" => 'error',
                "error" => 'Ha ocurrido un error al intentar obtener la bitácora',
            ]);
        }
    }
}
