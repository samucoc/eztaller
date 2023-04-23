<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ConfiguracionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
        // $this->middleware('auth:api');
    }

    public function get(Request $request)
    {
        $fields = $request->all();
        $rules = [
            'variable' => 'required',
            'campo' => 'nullable|in:valor,descripcion',
        ];
        $v = Validator::make($fields, $rules);
        if ($v->fails()) {
            return response()->json([
                "code" => 402,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }
        $res = Configuracion::get($fields['variable']);
        return response()->json([
            'type' => 'success',
            'code' => 200,
            'data' => $res
        ], 200);
    }

    public function set(Request $request)
    {
        $fields = $request->all();
        $rules = [
            'variable' => 'required',
            'valor' => 'required',
        ];
        $v = Validator::make($fields, $rules);
        if ($v->fails()) {
            return response()->json([
                "code" => 402,
                "errors" => $v->errors(),
                "type" => 'success',
            ]);
        }
        $res = Configuracion::set($fields['variable'], $fields['valor']);
        return response()->json([
            'type' => 'success',
            'code' => 200,
            'data' => $res
        ], 200);
    }
}
